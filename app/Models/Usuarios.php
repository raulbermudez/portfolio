<?php
namespace App\Models;
require_once "DBAbstractModel.php";

use App\Models\Trabajos;
use App\Models\Proyectos;
use App\Models\SkillsUsuario;
use App\Models\RedesSociales;

class Usuarios extends DBAbstractModel
{
    private static $instancia;
    // Patron singleton, no puedo tener dos objetos de la clase usuario
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miClase = __CLASS__;
            self::$instancia = new $miClase;
        }
        return self::$instancia;
    }

    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $resumen_perfil;
    private $token;
    private $foto;
    private $fecha_creacion_token;
    private $visible;
    private $cuenta_activa;

    private $trabajos;

    private $skills;
    
    private $redesSociales;

    private $proyectos;

    // Creo los setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos ;
    }
    public function setEmail($email) {
        $this->email = $email ;
    }
    public function setPassword($password) {
        $this->password = $password ;
    }
    public function setProfileSummary($resumen_perfil) {
        $this->resumen_perfil = $resumen_perfil ;
    }
    public function setToken($token) {
        $this->token = $token ;
    }

    public function setFoto($foto){
        $this->foto = $foto;
    }

    public function setActivo($cuenta_activa){
        $this->cuenta_activa = $cuenta_activa;
    }

    public function setFechaCreacionToken($fecha_creacion_token){
        $this->fecha_creacion_token = $fecha_creacion_token;
    }

    public function getMensaje(){
        return $this->mensaje;
    }

    /*Método para insertar datos en la tabla usuario*/
    public function set() {
        $this->query = "INSERT INTO usuarios(nombre, apellidos, foto, email, resumen_perfil, password, visible, token, fecha_creacion_token, cuenta_activa)
        VALUES(:nombre, :apellidos, :foto, :email, :resumen_perfil, :password, :visible, :token, :fecha_creacion_token, :cuenta_activa)";
        
        $this->parametros['nombre']= $this->nombre;
        $this->parametros['apellidos']= $this->apellidos;
        $this->parametros['email']= $this->email;
        $this->parametros['password']= $this->password;
        $this->parametros['resumen_perfil']= $this->resumen_perfil;
        $this->parametros['foto']= $this->foto;
        $this->parametros['token']= $this->token;
        $this->parametros['fecha_creacion_token'] = date('Y-m-d H:i:s');
        $this->parametros['cuenta_activa'] = $this->cuenta_activa;
        $this->parametros['visible'] = 0;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario añadido.';
    }

    // Para obtener un usuario por id
    public function get($id = ''){
        $this->query = "SELECT * FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                // $this->$propiedad = $valor;
            }
            $this->mensaje = 'Usuario encontrada';
        } else {
            $this->mensaje = 'Usuario no encontrada';
        }
        $usuario = $this->rows[0] ?? null;

        // Obtengo los trabajos, proyectos, skills, redes sociales.
        $usuario['trabajos'] = Trabajos::getInstancia()->get($id);
        $usuario['proyectos'] = Proyectos::getInstancia()->get($id);
        $usuario['skills'] = SkillsUsuario::getInstancia()->get($id);
        $usuario['redesSociales'] = RedesSociales::getInstancia()->get($id);
        return $usuario ?? null;
        
    }

    // Para editar usuarios
    public function edit(){
        $fecha = new \DateTime();
        $this->query = "UPDATE usuarios 
                        SET nombre = :nombre, apellidos = :apellidos, foto = :foto, email = :email, password = :password, resumen_perfil = :resumen_perfil, token = :token, updated_at = :update_at, visible = :visible, cuenta_activa = :cuenta_activa
                        WHERE id = :id";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['foto']= $this->foto;
        $this->parametros['email'] = $this->email;
        $this->parametros['password'] = $this->password;
        $this->parametros['resumen_perfil'] = $this->resumen_perfil;
        $this->parametros['token'] = $this->token;
        $this->parametros['update_at'] = date( 'Y-m-d H:i:s', $fecha->getTimestamp());
        $this->parametros['visible'] = $this->visible;
        $this->parametros['cuenta_activa'] = $this->cuenta_activa;
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario modificado';
    }

    // Para eliminar el ultimo usuario creado
    public function delete(){
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Usuario eliminado';
    }

    // Para obtener todos los usuarios
    public function getAll(){
        $this->query = "SELECT * FROM usuarios";
        $this->get_results_from_query();
        // Obtengo los trabajos, proyectos, skills, redes sociales.
        // Recooro todos los usuarios y segun el id voy guardando los datos
        foreach ($this->rows as $usuario) {
            $id = $usuario['id'];
            $usuario['trabajos'] = Trabajos::getInstancia()->get($id);
            $usuario['proyectos'] = Proyectos::getInstancia()->get($id);
            $usuario['skills'] = SkillsUsuario::getInstancia()->get($id);
            $usuario['redesSociales'] = RedesSociales::getInstancia()->get($id);
        }
        return $this->rows;
    }

    // Función para comprobar si un email que se le pasa ya se encuentra en la base de datos
    public function emailExists($email){
        $this->query = "SELECT * FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Función parar comprobar que un email y una contraseña coinciden
    public function emailPasswordExists($email, $password){
        $this->query = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
        $this->parametros['email'] = $email;
        $this->parametros['password'] = $password;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Función para obtener el nombre usando el email
    public function getNameByEmail($email){
        $this->query = "SELECT nombre FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['nombre'];
        } else {
            return null;
        }
    }

    // Función para obtener el apellido usando el email
    public function getLastNameByEmail($email){
        $this->query = "SELECT apellidos FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['apellidos'];
        } else {
            return null;
        }
    }

    // Función para comprobar que la cuenta del usuario esta activa o no
    public function estaActivo($email){
        $this->query = "SELECT cuenta_activa FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if ($this->rows[0]['cuenta_activa'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    // Funcion para obtener el perfil de usuario
    public function getUserProfile($email){
        $this->query = "SELECT perfil_usuario FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['perfil_usuario'];
        } else {
            return null;
        }
    }

    // Funcion para obtener el id de un usuario usando el email
    public function getIdByEmail($email){
        $this->query = "SELECT id FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['id'];
        } else {
            return null;
        }
    }

    // Funcion para obtener la foto de un usuario usando el email
    public function getFotoByEmail($email){
        $this->query = "SELECT foto FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows[0]['foto'];
        } else {
            return null;
        }
    }

    // Funcion para obtener el token de un usuario usando el email
    public function verificarToken($token = ''){
        $this->query = "SELECT * FROM usuarios WHERE token = :token";
        $this->parametros['token'] = $token;
        $this->get_results_from_query();
        // var_dump($token);die();
        if(count($this->rows) == 1){
           // Comprobar si el token ha caducado
            $this->fecha_creacion_token = $this->rows[0]['fecha_creacion_token'];
            $fecha_actual = date('Y-m-d H:i:s');
            $diferencia = strtotime($fecha_actual) - strtotime($this->fecha_creacion_token);
            if ($diferencia < 86400) {
                $this->query = "UPDATE usuarios SET token = NULL, fecha_creacion_token = NULL, visible = 1 , cuenta_activa = 1 WHERE token = :token";
                $this->parametros['token'] = $token;
                $this->get_results_from_query();
                $this->mensaje = 'Usuario verificado';
            } else {
                $this->mensaje = 'El token ha caducado';
            }
        } else {
            $this->mensaje = 'Token no encontrado';
        }
    }

    // Funcion para actualizar la foto de un usuario
    public function updateFoto($id = ''){
        $this->query = "UPDATE usuarios SET foto = :foto WHERE id = :id";
        $this->parametros['foto'] = $this->foto;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Foto actualizada';
    }
}
?>