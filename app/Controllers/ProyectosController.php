<?php
namespace App\Controllers;
use App\Models\Proyectos;

class ProyectosController extends BaseController
{
    public function AddAction(){
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorTituloP'] = $data['msjErrorDescripcionP'] = $data['msjErrorTecnologias'] = '';
        $data['tituloP'] = $data['descripcionP'] = $data['tecnologias']  = '';
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['tituloP'] = $_POST['titulo'];
            $data['descripcionP'] = $_POST['descripcion'];
            $data['tecnologias'] = $_POST['tecnologias'];
            $lprocesaFormulario = true;
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

        if($lprocesaFormulario){
            session_start();
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

    public function EditAction($categoria){
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Proyectos::getInstancia()->getbyId($categ);

            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $tecnologias = $_POST['tecnologias'];

            if (!$titulo){
                $titulo = $data[0]['titulo'];
            }

            if (!$descripcion){
                $descripcion = $data[0]['descripcion'];
            }

            if (!$tecnologias){
                $tecnologias =$data[0]['tecnologias'];
            }

            $proyecto = new Proyectos();
            $proyecto->setTitulo($titulo);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setTecnologias($tecnologias);
            $proyecto->setVisible("on");
            $proyecto->setIdUsuario($data[0]['usuarios_id']);
            $proyecto->edit($categ);
            header("Location: /portfolio/");
        } else{
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Proyectos::getInstancia()->getbyId($categ);
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/proyectos_edit_view.php', $data);
        }
    }

    public function DelAction($categoria){
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $proyecto = Proyectos::getInstancia();
        $proyecto->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }
}