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
    public function get($id = ""){
        if($id != ''){
            $this->query = "SELECT * FROM proyectos WHERE usuarios_id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Proyecto encontrado';
            return $this->rows;
        }else{
            $this->mensaje = 'Proyecto no encontrado';
        }
    }

    /*Método para insertar datos en la tabla proyectos*/
    public function getbyId($id = ""){
        if($id != ''){
            $this->query = "SELECT * FROM proyectos WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Proyecto encontrado';
            return $this->rows;
        }else{
            $this->mensaje = 'Proyecto no encontrado';
        }
    }

    /*Método para insertar datos en la tabla proyectos*/
    public function set(){
        $this->query = "INSERT INTO proyectos (titulo, descripcion, tecnologias, visible, created_at, updated_at, usuarios_id) VALUES (:titulo, :descripcion, :tecnologias, :visible, :created_at, :updated_at, :usuarios_id)";
        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['tecnologias'] = $this->tecnologias;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->parametros['usuarios_id'] = $this->usuarios_id;
        $this->get_results_from_query();
        $this->mensaje = 'Proyecto agregado';
    }

    /*Método para modificar datos en la tabla proyectos*/
    public function edit($id = ""){
        $this->query = "UPDATE proyectos SET titulo = :titulo, descripcion = :descripcion, tecnologias = :tecnologias, visible = :visible, updated_at = :updated_at WHERE id = :id";
        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['tecnologias'] = $this->tecnologias;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Proyecto modificado';
    }

    /*Método para eliminar datos en la tabla proyectos*/
    public function delete($id = ''){
        $this->query = "DELETE FROM proyectos WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Proyecto eliminado';
    }

    // Funcion para obtener todas las tecnologias de un usuario
    public function getTecnologias() {
        $this->query = "SELECT DISTINCT tecnologias, usuarios_id FROM proyectos";
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay tecnologias";
            return null;
        }
    }

    // Funcion para obtenr una tecnologia que sea del filtro
    public function getTecnologiasFromSearch($filter = ""){
        $this->query = "SELECT DISTINCT tecnologias, usuarios_id FROM proyectos WHERE tecnologias LIKE :tecnologias";
        $this->parametros['tecnologias'] = "%".$filter."%";
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay tecnologias";
            return null;
        }
    }

    // Funcion para obtener todos los proyectos visibles
    public function getVisibleProyectos($id = ''){
        $this->query = "SELECT * FROM proyectos WHERE visible = 1 AND usuarios_id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay proyectos visibles";
            return null;
        }
    }

    // Funcion para obtener todos los proyectos de un usuario
    public function getUserId($id = ''){
        $this->query = "SELECT * FROM proyectos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay proyectos";
            return null;
        }
    }

    // Funcion para obtener la visibilidad de un proyecto
    public function getVisibility($id = '') {
        if ($id != '') {
            $this->query = "SELECT visible FROM proyectos WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            if (count($this->rows) > 0) {
                return $this->rows[0]['visible'] == 1 ? 'Visible' : 'No Visible';
            } else {
                $this->mensaje = 'Proyecto no encontrado';
                return null;
            }
        } else {
            $this->mensaje = 'ID del proyecto no proporcionado';
            return null;
        }
    }

    // Funcion para cambiar la visibilidad de un proyecto
    public function toggleVisibility($id = '') {
        if ($id != '') {
            $currentVisibility = $this->getVisibility($id);
            $newVisibility = ($currentVisibility == 'Visible') ? 0 : 1;
            $this->query = "UPDATE proyectos SET visible = :visible WHERE id = :id";
            $this->parametros['visible'] = $newVisibility;
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Visibilidad del proyecto cambiada';
        } else {
            $this->mensaje = 'ID del proyecto no proporcionado';
        }
    }
}