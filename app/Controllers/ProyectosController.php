<?php
namespace App\Controllers;
use App\Models\Proyectos;

class ProyectosController extends BaseController
{
    // Funcion para añadir un proyecto
    public function AddAction(){
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorTituloP'] = $data['msjErrorDescripcionP'] = $data['msjErrorTecnologias'] = '';
        $data['tituloP'] = $data['descripcionP'] = $data['tecnologias']  = '';
        // Compruebo si se ha pulsado el botón de crear
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['tituloP'] = $_POST['titulo'];
            $data['descripcionP'] = $_POST['descripcion'];
            $data['tecnologias'] = $_POST['tecnologias'];
            $lprocesaFormulario = true;
            // Compruebo que los campos no estén vacíos
            if ($data['tituloP'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorTituloP'] = "* El título del proyecto no puede estar vacío";
            }
            if ($data['descripcionP'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorDescripcionP'] = "* La descripción del proyecto no puede estar vacía";
            }
            if ($data['tecnologias'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorTecnologias'] = "* Las tecnologías del proyecto no pueden estar vacías";
            }
        }

        // Si se ha pulsado el botón de crear y los campos no están vacíos introduzco los datos en la base de datos
        if($lprocesaFormulario){
            $id_usua = $_SESSION['id'];
            // Creo el proyecto
            $proyecto = new Proyectos();
            $proyecto->setTitulo($data['tituloP']);
            $proyecto->setDescripcion($data['descripcionP']);
            $proyecto->setTecnologias($data['tecnologias']);
            $proyecto->setVisible("on");
            $proyecto->setIdUsuario($id_usua);
            $proyecto->set();
            header('Location: /portfolio/');
        } else{
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/proyectos_add_view.php', $data);
        }
    }

    // Función para editar los datos
    public function EditAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = Proyectos::getInstancia()->getUserId($categ);
        if( $_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
        }

        // Si he pulsado en editar
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Proyectos::getInstancia()->getbyId($categ);

            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $tecnologias = $_POST['tecnologias'];

            // Valido los campos
            if (!$titulo){
                $titulo = $data[0]['titulo'];
            }

            if (!$descripcion){
                $descripcion = $data[0]['descripcion'];
            }

            if (!$tecnologias){
                $tecnologias =$data[0]['tecnologias'];
            }

            // Creo el proyecto
            $proyecto = new Proyectos();
            $proyecto->setTitulo($titulo);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setTecnologias($tecnologias);
            $proyecto->setVisible("on");
            $proyecto->setIdUsuario($data[0]['usuarios_id']);
            $proyecto->edit($categ);
            header("Location: /portfolio/");
        } else{
            // Muestro la vista
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Proyectos::getInstancia()->getbyId($categ);
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/proyectos_edit_view.php', $data);
        }
    }

    // Funcion para eliminar un proyecto
    public function DelAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = Proyectos::getInstancia()->getUserId($categ);
        
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }
        
        // Elimino el proyecto
        $proyecto = Proyectos::getInstancia();
        $proyecto->delete($categ);

        header('Location: /portfolio/');
    }


    // Funcion para cambiar la visibilidad de un proyecto
    public function VisibilidadAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = Proyectos::getInstancia()->getUserId($categ);
        
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }
        
        // Cambio la visibilidad del proyecto
        $proyecto = Proyectos::getInstancia();
        $proyecto->toggleVisibility($categ);

        header('Location: /portfolio/');
    }
}