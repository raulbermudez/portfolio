<?php
namespace App\Models;
require_once "DBAbstractModel.php";

class Proyectos extends DBAbstractModel
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

    private $titulo;

    private $descripcion;

    private $tecnologias;

    private $visible;

    private $created_at;

    private $updated_at;

    private $usuarios_id;

    // Creo los setters
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion ;
    }

    public function setTecnologias($tecnologias) {
        $this->tecnologias = $tecnologias ;
    }

    public function setUsuariosId($usuarios_id) {
        $this->usuarios_id = $usuarios_id ;
    }

    public function setCreated_at($created_at) {
        $this->created_at = $created_at ;
    }

    public function setUpdated_at($updated_at) {
        $this->updated_at = $updated_at ;
    }

    public function setVisible($visible) {
        if($visible == "on"){
            $visible = 1;
        }else{
            $visible = 0;
        }
        $this->visible = $visible ;
    }

    public function setIdUsuario($id_usuario) {
        $this->usuarios_id = $id_usuario ;
    }

    public function getMensaje(){
        return $this->mensaje;
    }

    /*Método para insertar datos en la tabla proyectos*/
    public function get(){}

    public function set(){}

    public function edit(){}

    public function delete(){}
}