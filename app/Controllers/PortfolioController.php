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

    public function EditPortfolioAction()
    {
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/portfolio_edit_view.php');
    }

    public function AddTrabajosAction()
    {
        // Valido el formulario
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorTituloT'] = $data['msjErrorDescripcionT'] = $data['msjErrorTecnologias'] = $data['msjErrorFechaIni'] = $data['msjErrorFechaFin'] = '';
        $data['tituloT'] = $data['descripcionT'] = $data['tecnologias'] = $data['logros'] = $data['fechaIni'] = $data['fechaFin'] = '';
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['tituloT'] = $_POST['titulo'];
            $data['descripcionT'] = $_POST['descripcion'];
            $data['logros'] = $_POST['logros'];
            $data['fechaIni'] =  $_POST['fecha_inicio'];
            $data['fechaFin'] = $_POST['fecha_final'];
            $lprocesaFormulario = true;
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
            header('Location: /portfolio/');
        }else{
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/trabajos_add_view.php', $data);
        }
    }

    public function AddProyectosAction(){
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

    public function EditProyectosAction($categoria){
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

    public function EditRedesSocialesAction($categoria){
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = RedesSociales::getInstancia()->getbyId($categ);

            $nombre = $_POST['nombre'];
            $url = $_POST['url'];

            if (!$nombre){
                $nombre = $data[0]['redes_socialescol'];
            }

            if (!$url){
                $url = $data[0]['url'];
            }

            $redSocial = new RedesSociales();
            $redSocial->setRedesSocialescol($nombre);
            $redSocial->setUrl($url);
            $redSocial->setVisible("on");
            $redSocial->edit($categ);
            header("Location: /portfolio/");
        } else{
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = RedesSociales::getInstancia()->getbyId($categ);
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/redesSociales_edit_view.php', $data);
        }
    }

    public function EditSkillAction($categoria){
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Tareas::getInstancia()->getbyId($categ);

            $habilidades = $_POST['habilidades'];
            $skills = $_POST['skills'];

            if (!$habilidades){
                $habilidades = $data[0]['habilidades'];
            }

            if (!$skills){
                $skills = $data[0]['categorias_skills_categoria'];
            }

            $tarea = new Tareas();
            $tarea->setHabilidades($habilidades);
            $tarea->setVisible("on");
            $tarea->setSkills($skills);
            $tarea->edit($categ);
            header("Location: /portfolio/");
        } else{
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = Tareas::getInstancia()->getbyId($categ);
            $data['skills'] = Skills::getInstancia()->get();
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/skill_edit_view.php', $data);
        }
    }

    public function EditTrabajoAction($categoria){
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

    public function AddRedesSocialesAction(){
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorNombre'] = $data['msjErrorUrl'] = '';
        $data['nombre'] = $data['url'] = '';
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['nombre'] = $_POST['nombre'];
            $data['url']  = $_POST['url'];
            $lprocesaFormulario = true;
            if ($data['nombre'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorNombre'] = "* El nombre del proyecto no puede estar vacío";
            }
            if ($data['url'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorUrl'] = "* La url del proyecto no puede estar vacía";
            }
        }

        if($lprocesaFormulario){
            session_start();
            $id_usua = $_SESSION['id'];
            // Creo la red social
            $redSocial = new RedesSociales();
            $redSocial->setRedesSocialescol($data['nombre']);
            $redSocial->setUrl($data['url']);
            $redSocial->setVisible("on");
            $redSocial->setIdUsuario($id_usua);
            $redSocial->set();
            header('Location: /portfolio/');
        } else{
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/redesSociales_add_view.php', $data);
        }
    }

    public function AddSkillAction(){
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorHabilidadesS'] = $data['msjErrorSkills'] = '';
        $data['skills'] = $data['habilidadesS'] = '';
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['habilidadesS'] = $_POST['habilidades'];
            $data['skills']  = $_POST['skills'];
            $lprocesaFormulario = true;
            if ($data['habilidadesS'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorHabilidadesS'] = "* Las habilidades de la tarea no pueden estar vacías";
            }
            if ($data['skills'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorSkills'] = "* Las skills de la tarea no pueden estar vacías";
            }
        }

        if($lprocesaFormulario){
            session_start();
            $id_usua = $_SESSION['id'];
            // Creo la tarea
            $tarea = new Tareas();
            $tarea->setHabilidades($data['habilidadesS']);
            $tarea->setVisible("on");
            $tarea->setSkills($data['skills']);
            $tarea->setIdUsuario($id_usua);
            $tarea->set();
            header('Location: /portfolio/');
        } else{
            // Obtengo del modelo Skills los datos de las skills
            $skills = Skills::getInstancia()->get();

            // Alamacenamos los datos en $data
            $data['skills'] = $skills;

            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/skill_add_view.php', $data);
        }
    }

    public function DelRedSocialAction($categoria){
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $redSocial = RedesSociales::getInstancia();
        $redSocial->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    public function DelTrabajoAction($categoria){
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $trabajo = Trabajos::getInstancia();
        $trabajo->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    public function DelProyectoAction($categoria){
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $proyecto = Proyectos::getInstancia();
        $proyecto->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    public function DelSkillAction($categoria){
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $tarea = Tareas::getInstancia();
        $tarea->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    // Accion para mostrar las skills
    public function SkillsAction()
    {
        // Obtengo del modelo Skills los datos de las skills
        $skills = Skills::getInstancia()->get();

        // Alamacenamos los datos en $data
        $data['skills'] = $skills;

        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/skill_view.php', $data);
    }

    // Accion para añadir una skill
    public function AddSkillsAction()
    {
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorCategoria'] = '';
        // Recojo los datos obtenidos del formulario del campo con name skill
        if (isset($_POST['enviar'])) {
            $skill = $_POST['skill'];
            $lprocesaFormulario = true;
            if ($skill === "") {
                $lprocesaFormulario = false;
                $data['msjErrorCategoria'] = "* La categoria no puede estar vacía";
            }
        }
        
        if ($lprocesaFormulario){
            // Creamos una instancia de Skills
            $skills = Skills::getInstancia();
            // Llamamos al método set de la clase Skills
            $skills->setCategoria($skill);
            $skills->set();
            header('Location: ..');
        } else{
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/skills_add_view.php', $data);
        }
    }

    // Accion para eliminar una skill
    public function DelSkillsAction($categoria)
    {
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $skills = Skills::getInstancia();
        $skills->setCategoria($categ);
        $skills->delete();

        // Llamamos a la función renderHTML
        header('Location: ..');
    }
    
}