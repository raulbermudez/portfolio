<?php
namespace App\Controllers;
use App\Models\Trabajos;
use App\Models\RedesSociales;
use App\Models\Proyectos;
use App\Models\Skills;
use App\Models\Tareas;

class PortfolioController extends BaseController
{
    public function GestionAction()
    {
        session_start();
        // Llamamos a que se obtengan los valores de la tabla proyectos que coincida con el id de usuario
        $data["proyectos"] = Proyectos::getInstancia()->get($_SESSION['id']);
        // Llamamos a que se obtengan los valores de la tabla trabajos que coincida con el id de usuario
        $data["trabajos"] = Trabajos::getInstancia()->get($_SESSION['id']);
        // Llamamos a que se obtengan los valores de la tabla redes_sociales que coincida con el id de usuario
        $data["redesSociales"] = RedesSociales::getInstancia()->get($_SESSION['id']);
        // Llamamos a que se obtengan los valores de la tabla tareas que coincida con el id de usuario
        $data["tareas"] = Tareas::getInstancia()->get($_SESSION['id']);
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/portfolio_view.php', $data);
    }
    
    // Accion para añadir un nuevo portfolio
    public function AddAction()
    {
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorTituloP'] = $data['msjErrorDescripcionP'] = $data['msjErrorTecnologias'] = $data['msjErrorNombre'] = $data['msjErrorUrl'] 
        = $data['msjErrorTituloT'] = $data['msjErrorDescripcionT'] = $data['msjErrorHabilidadesS'] = $data['msjErrorSkills'] = $data['msjErrorFechaIni'] = $data['msjErrorFechaFin'] = '';
        $data['tituloP'] = $data['descripcionP'] = $data['tecnologias'] = $data['nombre'] = $data['url'] = $data['tituloT'] = $data['descripcionT'] = $data['fechaIni'] = $data['fechaFin'] = $data['logros'] = $data['habilidadesS'] = '';
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['tituloP'] = $_POST['titulo'];
            $data['descripcionP'] = $_POST['descripcion'];
            $data['tecnologias'] = $_POST['tecnologias'];
            $data['nombre'] = $_POST['nombre'];
            $data['url']  = $_POST['url'];
            $data['tituloT']  = $_POST['titulo_trab'];
            $data['descripcionT']  = $_POST['descripcion_trab'];
            $data['fechaIni'] =  $_POST['fecha_inicio'];
            $data['fechaFin'] = $_POST['fecha_final'];
            $data['logros'] = $_POST['logros'];
            $data['habilidadesS'] = $_POST['habilidades'];
            if (isset($_POST['skills'])){
                $data['skills'] = $_POST['skills'];
            } else{
                $data['skills'] = '';
            }
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
            if ($data['nombre'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorNombre'] = "* El nombre del proyecto no puede estar vacío";
            }
            if ($data['url'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorUrl'] = "* La url del proyecto no puede estar vacía";
            }
            if ($data['tituloT'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorTituloT'] = "* El título de la tarea no puede estar vacío";
            }
            if ($data['descripcionT'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorDescripcionT'] = "* La descripción de la tarea no puede estar vacía";
            }
            if ($data['habilidadesS'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorHabilidadesS'] = "* Las habilidades de la tarea no pueden estar vacías";
            }
            if ($data['skills'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorSkills'] = "* Las skills de la tarea no pueden estar vacías";
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

        if($lprocesaFormulario){
            session_start();
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
            // Creo el proyecto
            $proyecto = new Proyectos();
            $proyecto->setTitulo($data['tituloP']);
            $proyecto->setDescripcion($data['descripcionP']);
            $proyecto->setTecnologias($data['tecnologias']);
            $proyecto->setVisible("on");
            $proyecto->setIdUsuario($id_usua);
            $proyecto->set();
            // Creo la red social
            $redSocial = new RedesSociales();
            $redSocial->setRedesSocialescol($data['nombre']);
            $redSocial->setUrl($data['url']);
            $redSocial->setVisible("on");
            $redSocial->setIdUsuario($id_usua);
            $redSocial->set();
            // Creo la tarea
            $tarea = new Tareas();
            $tarea->setHabilidades($data['habilidadesS']);
            $tarea->setVisible("on");
            $tarea->setSkills($data['skills']);
            $tarea->setIdUsuario($id_usua);
            $tarea->set();
            // Creo la relación entre la tarea y el trabajo
            header('Location: ..');
        } else{
            // Obtengo del modelo Skills los datos de las skills
            $skills = Skills::getInstancia()->get();

            // Alamacenamos los datos en $data
            $data['skills'] = $skills;

            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/portfolio_add_view.php', $data);
        }   
    }
}