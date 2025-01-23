<?php
/**
 * Path: DWES/Proyectos/portfolio/app/views/register.php
 */
// Inicialización de variables
$isLogged = false;
$perfil = "";

// Iniciamos sesión si existe
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['email'])) {
    $isLogged = true;
    if ($_SESSION['perfil_usuario'] == "admin"){
        $perfil = "admin";
    } else{
        $perfil = "usuario";
    }
}