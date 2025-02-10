<?php
namespace App\Controllers;
use App\Models\SkillsUsuario;
use App\Models\Skills;

class SkillController extends BaseController
{
    // Función que añade todas las tareas
    public function AddAction(){
        $lprocesaFormulario = false;
        $data = array();
        $data['msjErrorHabilidadesS'] = $data['msjErrorSkills'] = '';
        $data['skills'] = $data['habilidadesS'] = '';
        if (isset($_POST['crear'])){
            // Obtengo todos los valores y los guardo en variables
            $data['habilidadesS'] = $_POST['habilidades'];
            $data['skills']  = $_POST['skills'];
            $lprocesaFormulario = true;
            // Compruebo que los campos no estén vacíos
            if ($data['habilidadesS'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorHabilidadesS'] = "* Las habilidades de la tarea no pueden estar vacías";
            }
            if ($data['skills'] === "") {
                $lprocesaFormulario = false;
                $data['msjErrorSkills'] = "* Las skills de la tarea no pueden estar vacías";
            }
        }

        // Si se ha validado todo
        if($lprocesaFormulario){
            $id_usua = $_SESSION['id'];
            // Creo la tarea
            $tarea = new SkillsUsuario();
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

    // Función que edita una tarea
    public function EditAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = SkillsUsuario::getInstancia()->getUserId($categ);
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
        }

        // Comprobamos si se ha pulsado el botón de editar
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = SkillsUsuario::getInstancia()->getbyId($categ);

            $habilidades = $_POST['habilidades'];
            $skills = $_POST['skills'];

            // Comprobamos si los campos están vacíos
            if (!$habilidades){
                $habilidades = $data[0]['habilidades'];
            }

            if (!$skills){
                $skills = $data[0]['categorias_skills_categoria'];
            }

            // Creamos la tarea
            $tarea = new SkillsUsuario();
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
            $data = SkillsUsuario::getInstancia()->getbyId($categ);
            $data['skills'] = Skills::getInstancia()->get();
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/skill_edit_view.php', $data);
        }
    }

    // Función que elimina una tarea
    public function DelAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = SkillsUsuario::getInstancia()->getUserId($categ);
        
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }

        // Llamamos al delete de proyectos con el id del proyecto que recibimos en la ruta
        $tarea = SkillsUsuario::getInstancia();
        $tarea->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    // Función que cambia la visibilidad de una tarea
    public function VisibilidadAction($categoria){
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = SkillsUsuario::getInstancia()->getUserId($categ);
        
        if($_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }
        
        // Llamamos al toggleVisibility de proyectos con el id del proyecto que recibimos en la ruta
        $proyecto = SkillsUsuario::getInstancia();
        $proyecto->toggleVisibility($categ);

        header('Location: /portfolio/');
    }
}