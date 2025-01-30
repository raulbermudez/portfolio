<?php
// requreimos el bootstrap y el autoload para la carga automatica de clases
require_once "../bootstrap.php";
require_once "../vendor/autoload.php";
// require_once "../app/Controllers/UsuarioController.php";

// Usamos el espacio de nombre
use App\Core\Router;
use App\Controllers\UsuarioController;
use App\Controllers\PortfolioController;
use App\Controllers\ProyectosController;
use App\Controllers\RedSocialController;
use App\Controllers\TrabajosController;
use App\Controllers\SkillController;
use App\Controllers\AuthController;

// Creamos una instancia de la clase Router
$router = new Router();

// Añadimos rutas al array
$router->add([  'name' => 'Todos los usuarios',
                'path' => '/^\/$/',
                'action' => [UsuarioController::class, 'IndexAction']]);

$router->add([  'name' => 'Añadir usuario',
                'path' => '/^\/usuarios\/add$/',
                'action' => [UsuarioController::class, 'AddAction']]);

$router->add([  'name' => 'Iniciar sesión de usuario',
                'path' => '/^\/usuarios\/login$/',
                'action' => [UsuarioController::class, 'LoginAction']]);

$router->add([  'name' => 'Cerrar sesión de usuario',
                'path' => '/^\/usuarios\/logout$/',
                'action' => [UsuarioController::class, 'LogoutAction']]);

$router->add([  'name' => 'Ver portfolios',
                'path' => '/^\/portfolio\/$/',
                'action' => [PortfolioController::class, 'GestionAction']]);

$router->add([ 'name' => 'Crear portfolio',
                'path' => '/^\/portfolio\/crear\/$/',
                'action' => [PortfolioController::class, 'AddAction']]);

$router->add([ 'name' => 'Crear nueva red social',
                'path' => '/^\/portfolio\/crear\/redesSociales\/$/',
                'action' => [RedSocialController::class, 'AddAction']]);

$router->add([ 'name' => 'Editar red Social',
                'path' => '/^\/portfolio\/editar\/redsocial\/[0-9]+$/',
                'action' => [RedSocialController::class, 'EditAction']]);

$router->add([ 'name' => 'Eliminar una red social',
                'path' => '/^\/portfolio\/del\/redsocial\/[0-9]+$/',
                'action' => [RedSocialController::class, 'DelAction']]);

$router->add([ 'name' => 'Crear proyecto',
                'path' => '/^\/portfolio\/crear\/proyecto\/$/',
                'action' => [ProyectosController::class, 'AddAction']]);

$router->add([ 'name' => 'Editar proyecto',
                'path' => '/^\/portfolio\/editar\/proyecto\/[0-9]+$/',
                'action' => [ProyectosController::class, 'EditAction']]);
            
$router->add([ 'name' => 'Eliminar un proyecto',
                'path' => '/^\/portfolio\/del\/proyecto\/[0-9]+$/',
                'action' => [ProyectosController::class, 'DelAction']]);

$router->add([ 'name' => 'Crear trabajo',
                'path' => '/^\/portfolio\/crear\/trabajo\/$/',
                'action' => [TrabajosController::class, 'AddAction']]);

$router->add([ 'name' => 'Editar trabajo',
                'path' => '/^\/portfolio\/editar\/trabajo\/[0-9]+$/',
                'action' => [TrabajosController::class, 'EditAction']]);


$router->add([ 'name' => 'Eliminar un trabajo',
                'path' => '/^\/portfolio\/del\/trabajo\/[0-9]+$/',
                'action' => [TrabajosController::class, 'DelAction']]);

$router->add([ 'name' => 'Crear skill del usuario',
                'path' => '/^\/portfolio\/crear\/skills\/$/',
                'action' => [SkillController::class, 'AddAction']]);

$router->add([ 'name' => 'Editar skill del usuario',
                'path' => '/^\/portfolio\/editar\/skill\/[0-9]+$/',
                'action' => [SkillController::class, 'EditAction']]);

$router->add([ 'name' => 'Eliminar una skill del usuario',
                'path' => '/^\/portfolio\/del\/skill\/[0-9]+$/',
                'action' => [SkillController::class, 'DelAction']]);
$router->add([ 'name' => 'Gestionar skills',
                'path' => '/^\/skills\/$/',
                'action' => [AuthController::class, 'SkillAction']]);

$router->add([ 'name' => 'Crear skills',
                'path' => '/^\/skills\/add\/$/',
                'action' => [AuthController::class, 'AddSkillAction']]);

// $router->add([ 'name' => 'Modificar skills',
//                 'path' => '/^\/skills\/edit\/$/',
//                 'action' => [AuthController::class, 'EditSkillAction']]);

$router->add([ 'name' => 'Eliminar una skill',
                'path' => '/^\/skills\/del\/[a-zA-Z %áéíóúÁÉÍÓÚÑñ]+$/',
                'action' => [AuthController::class, 'DelSkillAction']]);

//$request = $_SERVER['REQUEST_URI'];
// Esto limpia la ruta de la petición
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = $router->match($request); // Comprobamos que coincide una ruta

if($route){
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
}else{
    echo "No route";
}