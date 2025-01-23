<?php
namespace App\Models;
require_once "DBAbstractModel.php";

class Trabajos extends DBAbstractModel
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

    private $fecha_inicio;

    private $fecha_final;

    private $logros;
    private $created_at;
    private $updated_at;
    private $visible;
    private $id_usuario;

    // Creo los setters
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion ;
    }
    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio ;
    }

    public function setFechaFinal($fecha_final) {
        $this->fecha_final = $fecha_final ;
    }

    public function setLogros($logros) {
        $this->logros = $logros ;
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
        $this->id_usuario = $id_usuario ;
    }

    public function getMensaje(){
        return $this->mensaje;
    }

    /*Método para insertar datos en la tabla usuario*/
    public function set() {
        $this->query = "INSERT INTO trabajos (titulo, descripcion, fecha_inicio, fecha_final, logros, visible, created_at, updated_at, usuarios_id) VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_final, :logros, 1, NOW(), NOW(), :id_usuario)";
        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['logros'] = $this->logros;
        $this->parametros['id_usuario'] = $this->id_usuario;
        $this->get_results_from_query();
        $this->mensaje = "Trabajo añadido";
    }

    /*Método para obtener los datos de la tabla trabajos*/
    public function get($id = "") {
        $this->query = "SELECT * FROM trabajos WHERE usuarios_id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay trabajos";
            return null;
        }
    }

    /*Método para eliminar un trabajo en específico*/
    public function delete() {
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Trabajo eliminado';
    }

    /*Métdo para editar los trabajos */
    public function edit() {
        $this->query = "UPDATE trabajos SET titulo = :titulo, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, logros = :logros, updated_at = NOW() WHERE id = :id";
        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['logros'] = $this->logros;
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
        $this->mensaje = 'Trabajo actualizado';
    }
}