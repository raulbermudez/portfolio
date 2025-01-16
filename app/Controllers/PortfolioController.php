<?php

namespace App\Controllers;
use App\Models\Skills;

class PortfolioController extends BaseController
{
    public function GestionAction()
    {
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/portfolio_view.php');
    }
    public function DelSkillsAction($categoria)
    {
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        echo $categ;
        $skills = Skills::getInstancia();
        $skills->setCategoria($categ);
        $skills->delete();

        // Llamamos a la función renderHTML
        header('Location: ..');
    }
    

    public function AddAction()
    {
        // Obtengo del modelo Skills los datos de las skills
        $skills = Skills::getInstancia()->get();

        // Alamacenamos los datos en $data
        $data['skills'] = $skills;

        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/portfolio_add_view.php', $data);
    }

    public function SkillsAction()
    {
        // Obtengo del modelo Skills los datos de las skills
        $skills = Skills::getInstancia()->get();

        // Alamacenamos los datos en $data
        $data['skills'] = $skills;

        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/skill_view.php', $data);
    }

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

    
}