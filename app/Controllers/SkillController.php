<?php
namespace App\Controllers;
use App\Models\SkillsUsuario;
use App\Models\Skills;

class SkillController extends BaseController
{
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

    public function EditAction($categoria){
        if(isset($_POST['editar'])){
            $data = "";
            $elementos = explode('/', $categoria);
            $categ = end($elementos);
            // Llamamos al get de proyectos con el id del proyecto que recibimos en la ruta
            $data = SkillsUsuario::getInstancia()->getbyId($categ);

            $habilidades = $_POST['habilidades'];
            $skills = $_POST['skills'];

            if (!$habilidades){
                $habilidades = $data[0]['habilidades'];
            }

            if (!$skills){
                $skills = $data[0]['categorias_skills_categoria'];
            }

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

    public function DelAction($categoria){
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $tarea = SkillsUsuario::getInstancia();
        $tarea->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }
}