<?php

namespace App\Controllers;
use App\Models\Portfolio;

class PortfolioController extends BaseController
{
    public function GestionAction()
    {
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/portfolio_view.php');
    }

    public function AddAction()
    {
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/portfolio_add_view.php');
    }

    public function SkillsAction()
    {
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/skill_view.php');
    }

    public function AddSkillsAction()
    {
        // Llamamos a la función renderHTML
        $this->renderHTML('../app/views/skills_add_view.php');
    }

    
}