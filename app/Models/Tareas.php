<?php
namespace App\Models;
require_once "DBAbstractModel.php";

class Tareas extends DBAbstractModel
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

    private $habilidades;

    private $visible;

    private $skills;

    private $usuarios_id;

    // Creo los setters
    public function setHabilidades($habilidades) {
        $this->habilidades = $habilidades;
    }

    public function setVisible($visible) {
        if($visible == "on"){
            $visible = 1;
        }else{
            $visible = 0;
        }
        $this->visible = $visible ;
    }

    public function setSkills($skills) {
        $this->skills = $skills ;
    }

    public function setIdUsuario($usuarios_id) {
        $this->usuarios_id = $usuarios_id ;
    }

    /*Método para insertar datos en la tabla categorias_skills*/
    public function set() {
        $this->query = "INSERT INTO skills (habilidades, visible, categorias_skills_categoria, usuarios_id) VALUES (:habilidades, :visible, :skills, :usuarios_id)";
        $this->parametros['habilidades'] = $this->habilidades;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['skills'] = $this->skills;
        $this->parametros['usuarios_id'] = $this->usuarios_id;
        $this->get_results_from_query();
        $this->mensaje = "Categoría de habilidades añadida";
    }

    /*Método para obtener los datos de la tabla categorias_skills*/
    public function get() {
        $this->query = "SELECT * FROM categorias_skills";
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay categorías de habilidades";
        }
    }

    /*Método para eliminar un trabajo en categorias_skills*/
    public function delete() {
        $this->query = "DELETE FROM categorias_skills WHERE usuario_id = :usuario_id";
        $this->parametros["usuario_id"] = $this->usuarios_id;
        $this->get_results_from_query();
        $this->mensaje = "Categoría de habilidades eliminada";
    }

    /*Métdo para editar los categorias_skills */
    public function edit() {
        $this->query = "UPDATE categorias_skills SET habilidades = :habilidades WHERE usuario_id = :usuario_id";
        $this->parametros["usuario_id"] = $this->usuarios_id;
        $this->get_results_from_query();
        $this->mensaje = "Categoría de habilidades editada";
    }
}