<?php
namespace App\Models;
require_once "DBAbstractModel.php";

class Skills extends DBAbstractModel
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

    private $categoria;

    // Setters
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    /*Método para insertar datos en la tabla categorias_skills*/
    public function set() {
        $this->query = "INSERT INTO categorias_skills (categoria) VALUES (:categoria)";
        $this->parametros["categoria"] = $this->categoria;
        $this->get_results_from_query();
        $this->mensaje = "Categoría añadida";
    }

    /*Método para obtener los datos de la tabla categorias_skills*/
    public function get() {
        $this->query = "SELECT * FROM categorias_skills";
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = "No hay categorías";
        }
    }

    /*Método para eliminar un trabajo en categorias_skills*/
    public function delete() {
        $this->query = "DELETE FROM categorias_skills WHERE categoria = :categoria";
        $this->parametros["categoria"] = $this->categoria;
        $this->get_results_from_query();
        $this->mensaje = "Categoría eliminada";
        
    }

    /*Métdo para editar los categorias_skills */
    public function edit() {
        $this->query = "UPDATE categorias_skills SET categoria = :categoria WHERE categoria = :categoria_anterior";
        $this->parametros[":categoria"] = $this->categoria;
        $this->get_results_from_query();
        $this->mensaje = "Categoría editada";
        
    }
}