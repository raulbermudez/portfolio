<?php
namespace App\Controllers;
use App\Models\Trabajos;

class TrabajosController extends BaseController
{
    // Funcion para añadir un trabajo
    public function AddAction()
    {
        // Valido el formulario
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorTituloT'] = $data['msjErrorDescripcionT'] = $data['msjErrorTecnologias'] = $data['msjErrorFechaIni'] = $data['msjErrorFechaFin'] = '';
        $data['tituloT'] = $data['descripcionT'] = $data['tecnologias'] = $data['logros'] = $data['fechaIni'] = $data['fechaFin'] = '';
        // Compruebo si se ha enviado el formulario
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['tituloT'] = $_POST['titulo'];
            $data['descripcionT'] = $_POST['descripcion'];
            $data['logros'] = $_POST['logros'];
            $data['fechaIni'] =  $_POST['fecha_inicio'];
            $data['fechaFin'] = $_POST['fecha_final'];
            $lprocesaFormulario = true;

            // Compruebo que los campos no estén vacíos
            if ($data['tituloT'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorTituloT'] = "* El título del proyecto no puede estar vacío";
            }
            if ($data['descripcionT'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorDescripcionT'] = "* La descripción del proyecto no puede estar vacía";
            }
            if ($data['fechaIni'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorFechaIni'] = "* La fecha de inicio no puede estar vacía";
            }

            if ($data['fechaFin'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorFechaFin'] = "* La fecha de fin no puede estar vacía";
            }

            if ($lprocesaFormulario){
                if ($data['fechaIni'] > $data['fechaFin']) {
                    $lprocesaFormulario = false;
                    $data['msjErrorFechaIni'] = "* La fecha de inicio debe ser anterior a la fecha de fin";
                    $data['msjErrorFechaFin'] = "* La fecha de inicio debe ser anterior a la fecha de fin";
                }
            }
        }
        
        // Si se ha enviado el formulario y los datos son correctos
        if($lprocesaFormulario){
            $id_usua = $_SESSION['id'];
            // Creo el trabajo
            $trabajo = new Trabajos();
            $trabajo->setTitulo($data['tituloT']);
            $trabajo->setDescripcion($data['descripcionT']);
            $trabajo->setFechaInicio($data['fechaIni']);
            $trabajo->setFechaFinal($data['fechaFin']);
            $trabajo->setLogros($data['logros']);
            $trabajo->setVisible("on");
            $trabajo->setIdUsuario($id_usua);
            $trabajo->set();
            header('Location: /portfolio/');
        }else{
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/trabajos_add_view.php', $data);
        }
    }

    // Funcion para editar un trabajo
    public function EditAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = Trabajos::getInstancia()->getUserId($categ);
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
        }

        // Comprobamos si se ha enviado el formulario
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Trabajos::getInstancia()->getbyId($categ);

            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_final = $_POST['fecha_final'];
            $logros = $_POST['logros'];

            // Comprobamos si los campos están vacíos
            if (!$titulo){
                $titulo = $data[0]['titulo'];
            }

            if (!$descripcion){
                $descripcion = $data[0]['descripcion'];
            }

            if (!$fecha_inicio){
                $fecha_inicio = $data[0]['fecha_inicio'];
            }

            if (!$fecha_final){
                $fecha_final = $data[0]['fecha_final'];
            }

            // Creamos el proyecto
            $trabajo = new Trabajos();
            $trabajo->setTitulo($titulo);
            $trabajo->setDescripcion($descripcion);
            $trabajo->setFechaInicio($fecha_inicio);
            $trabajo->setFechaFinal($fecha_final);
            $trabajo->setLogros($logros);
            $trabajo->setVisible("on");
            $trabajo->setIdUsuario($data[0]['usuarios_id']);
            $trabajo->edit($categ);
            header("Location: /portfolio/");
        } else{
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Trabajos::getInstancia()->getbyId($categ);
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/trabajos_edit_view.php', $data);
        }
    }

    // Funcion para eliminar un trabajo
    public function DelAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = Trabajos::getInstancia()->getUserId($categ);
        
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }

        // Eliminamos el proyecto
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $trabajo = Trabajos::getInstancia();
        $trabajo->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    // Funcion para cambiar la visibilidad de un trabajo
    public function VisibilidadAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = Trabajos::getInstancia()->getUserId($categ);
        
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }

        // Cambiamos la visibilidad del proyecto
        
        $proyecto = Trabajos::getInstancia();
        $proyecto->toggleVisibility($categ);

        header('Location: /portfolio/');
    }
}