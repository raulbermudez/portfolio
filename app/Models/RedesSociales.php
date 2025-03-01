<?php
namespace App\Models;
require_once "DBAbstractModel.php";

class RedesSociales extends DBAbstractModel
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

    private $redes_socialescol;

    private $url;

    private $created_at;

    private $updated_at;

    private $visible;

    private $id_usuario;

    // Creo los setters
    public function setRedesSocialescol($redes_socialescol) {
        $this->redes_socialescol = $redes_socialescol;
    }
    public function setUrl($url) {
        $this->url = $url ;
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
    public function set(){
        $this->query = "INSERT INTO redes_sociales (redes_socialescol, url, created_at, updated_at, usuarios_id) VALUES (:redes_socialescol, :url, :created_at, :updated_at, :id_usuario)";
        $this->parametros['redes_socialescol'] = $this->redes_socialescol;
        $this->parametros['url'] = $this->url;
        $this->parametros['created_at'] = date('Y-m-d H:i:s');
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->parametros['id_usuario'] = $this->id_usuario;
        $this->get_results_from_query();
        $this->mensaje = 'Redes sociales agregadas';
    }

    /*Métdodo para obtener una red social */
    public function get($id = " "){
        $this->query = "SELECT * FROM redes_sociales WHERE usuarios_id = :id_usuario";
        $this->parametros['id_usuario'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Redes sociales obtenidas';
        return $this->rows;
    }

    /*Método para editar datos en la tabla redes_sociales*/
    public function edit($id = ''){
        $this->query = "UPDATE redes_sociales SET redes_socialescol = :redes_socialescol, url = :url, updated_at = :updated_at WHERE id = :id";
        $this->parametros['redes_socialescol'] = $this->redes_socialescol;
        $this->parametros['url'] = $this->url;
        $this->parametros['updated_at'] = date('Y-m-d H:i:s');
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Redes sociales actualizadas';
    }

    /*Método para obtener una red social por su id */
    public function getById($id = ''){
        $this->query = "SELECT * FROM redes_sociales WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Redes sociales obtenidas';
        return $this->rows;
    }

    /*Método para eliminar una red social */
    public function delete($id = ''){
        $this->query = "DELETE FROM redes_sociales WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Redes sociales eliminadas';
    }

    /* Función para obtenr las redes_sociales visibles */
    public function getVisibleRedesSosciales($id = ''){
        $this->query = "SELECT * FROM redes_sociales WHERE usuarios_id = :id_usuario AND visible = 1";
        $this->parametros['id_usuario'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Redes sociales obtenidas';
        return $this->rows;
    }

    /* Función para obtener las redes_sociales de un usuario */
    public function getUserId($id = ''){
        $this->query = "SELECT * FROM redes_sociales WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay proyectos";
            return null;
        }
    }

    // Funcion para obtener la visibilidad de una red social
    public function getVisibility($id = '') {
        if ($id != '') {
            $this->query = "SELECT visible FROM redes_sociales WHERE id = :id";
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

    // Funcion para cambiar la visibilidad de una red social
    public function toggleVisibility($id = '') {
        if ($id != '') {
            $currentVisibility = $this->getVisibility($id);
            $newVisibility = ($currentVisibility == 'Visible') ? 0 : 1;
            $this->query = "UPDATE redes_sociales SET visible = :visible WHERE id = :id";
            $this->parametros['visible'] = $newVisibility;
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Visibilidad del proyecto cambiada';
        } else {
            $this->mensaje = 'ID del proyecto no proporcionado';
        }
    }

}