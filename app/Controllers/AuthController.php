<?php
namespace App\Controllers;
use App\Models\Tareas;
use App\Models\Skills;

class AuthController extends BaseController
{
    // Accion para mostrar las skills en la parte del administrador
    public function SkillAction()
    {
        // Obtengo del modelo Skills los datos de las skills
        $skills = Skills::getInstancia()->get();

        // Alamacenamos los datos en $data
        $data['skills'] = $skills;

        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/skill_view.php', $data);
    }

    // Accion para añadir una skill desde el administrador
    public function AddSkillAction()
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

    // Accion para eliminar una skill desde la capa del administrador
    public function DelSkillAction($categoria)
    {
        if ($_SESSION['perfil_usuario'] !== 'admin') {
            // Si no es administrador, redirigimos a una página de error o login
            header('Location: /');
            exit();
        }
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $skills = Skills::getInstancia();
        $skills->setCategoria($categ);
        $skills->delete();
        // Volvemos a mostrar las skills
        header('Location: /skills/');
    }
}