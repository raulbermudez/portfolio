<?php
session_start();
$_SESSION['perfil_usuario'] = $_SESSION['perfil_usuario'] ?? "invitado";
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

// Ruta que muestra los portfolios
$router->add([  'name' => 'Todos los usuarios',
                'path' => '/^\/(\?.*)?$/',
                'action' => [UsuarioController::class, 'IndexAction']]);

// Ruta para añadir un usuario
$router->add([  'name' => 'Añadir usuario',
                'path' => '/^\/usuarios\/add$/',
                'action' => [UsuarioController::class, 'AddAction'],
                'perfil' => ["invitado"]]);

// Ruta para loguearse un usuario
$router->add([  'name' => 'Iniciar sesión de usuario',
                'path' => '/^\/usuarios\/login$/',
                'action' => [UsuarioController::class, 'LoginAction'],
                'perfil' => ["invitado"]]);

// Ruta para cerrar sesión
$router->add([  'name' => 'Cerrar sesión de usuario',
                'path' => '/^\/usuarios\/logout$/',
                'action' => [UsuarioController::class, 'LogoutAction'],
                'perfil' => ["usuario", "admin"]]);

// Ruta para ver el portfolio estando logueado
$router->add([  'name' => 'Ver portfolios',
                'path' => '/^\/portfolio\/$/',
                'action' => [PortfolioController::class, 'GestionAction'],
                'perfil' => ["usuario"]]);

// Ruta para crear el portfolio
$router->add([ 'name' => 'Crear portfolio',
                'path' => '/^\/portfolio\/crear\/$/',
                'action' => [PortfolioController::class, 'AddAction'],
                'perfil' => ["usuario"]]);

// Ruta para crear una red social
$router->add([ 'name' => 'Crear nueva red social',
                'path' => '/^\/portfolio\/crear\/redesSociales\/$/',
                'action' => [RedSocialController::class, 'AddAction'],
                'perfil' => ["usuario"]]);

// Ruta para editar una red social
$router->add([ 'name' => 'Editar red Social',
                'path' => '/^\/portfolio\/editar\/redsocial\/[0-9]+$/',
                'action' => [RedSocialController::class, 'EditAction'],
                'perfil' => ["usuario"]]);

// Ruta para eliminar una red social
$router->add([ 'name' => 'Eliminar una red social',
                'path' => '/^\/portfolio\/del\/redsocial\/[0-9]+$/',
                'action' => [RedSocialController::class, 'DelAction'],
                'perfil' => ["usuario"]]);

// Ruta para crear un proyecto
$router->add([ 'name' => 'Crear proyecto',
                'path' => '/^\/portfolio\/crear\/proyecto\/$/',
                'action' => [ProyectosController::class, 'AddAction'],
                'perfil' => ["usuario"]]);

// Ruta para editar un proyecto
$router->add([ 'name' => 'Editar proyecto',
                'path' => '/^\/portfolio\/editar\/proyecto\/[0-9]+$/',
                'action' => [ProyectosController::class, 'EditAction'],
                'perfil' => ["usuario"]]);
       
// Ruta para eliminar un proyecto
$router->add([ 'name' => 'Eliminar un proyecto',
                'path' => '/^\/portfolio\/del\/proyecto\/[0-9]+$/',
                'action' => [ProyectosController::class, 'DelAction'],
                'perfil' => ["usuario"]]);

// Ruta para crear un trabajo
$router->add([ 'name' => 'Crear trabajo',
                'path' => '/^\/portfolio\/crear\/trabajo\/$/',
                'action' => [TrabajosController::class, 'AddAction'],
                'perfil' => ["usuario"]]);

// Ruta para editar un trabajo
$router->add([ 'name' => 'Editar trabajo',
                'path' => '/^\/portfolio\/editar\/trabajo\/[0-9]+$/',
                'action' => [TrabajosController::class, 'EditAction'],
                'perfil' => ["usuario"]]);

// Ruta para eliminar un trabajo
$router->add([ 'name' => 'Eliminar un trabajo',
                'path' => '/^\/portfolio\/del\/trabajo\/[0-9]+$/',
                'action' => [TrabajosController::class, 'DelAction'],
                'perfil' => ["usuario"]]);

// Ruta para crear una skill
$router->add([ 'name' => 'Crear skill del usuario',
                'path' => '/^\/portfolio\/crear\/skills\/$/',
                'action' => [SkillController::class, 'AddAction'],
                'perfil' => ["usuario"]]);

// Ruta para editar una skill
$router->add([ 'name' => 'Editar skill del usuario',
                'path' => '/^\/portfolio\/editar\/skill\/[0-9]+$/',
                'action' => [SkillController::class, 'EditAction'],
                'perfil' => ["usuario"]]);

// Ruta para eliminar una skill
$router->add([ 'name' => 'Eliminar una skill del usuario',
                'path' => '/^\/portfolio\/del\/skill\/[0-9]+$/',
                'action' => [SkillController::class, 'DelAction'],
                'perfil' => ["usuario"]]);

// Ruta para gestionar las skills desde el administrador
$router->add([ 'name' => 'Gestionar skills',
                'path' => '/^\/skills\/$/',
                'action' => [AuthController::class, 'SkillAction'],
                'perfil' => ["admin"]]);

// Ruta para añadir una skill desde el administrador
$router->add([ 'name' => 'Crear skills',
                'path' => '/^\/skills\/add\/$/',
                'action' => [AuthController::class, 'AddSkillAction'],
                'perfil' => ["admin"]]);

// Ruta para eliminar una skill desde el administrador
$router->add([ 'name' => 'Eliminar una skill',
                'path' => '/^\/skills\/del\/[a-zA-Z %áéíóúÁÉÍÓÚÑñ]+$/',
                'action' => [AuthController::class, 'DelSkillAction'],
                'perfil' => ["admin"]]);

// Ruta para ver los portfolios de un usuario
$router->add([ 'name' => 'Ver portfolios de usuario',
                'path' => '/^\/portfolio\/view\/[0-9]+$/',
                'action' => [PortfolioController::class, 'verPortfoliosAction']]);

// Ruta para cambiar la visibilidad de un proyecto
$router->add([ 'name' => 'Para cambiar la visibilidad del proyecto',
                'path' => '/^\/portfolio\/visibilidad\/proyecto\/[0-9]+$/',
                'action' => [ProyectosController::class, 'VisibilidadAction'],
                'perfil' => ["usuario"]]); 

// Ruta para cambiar la visibilidad de un trabajo
$router->add([ 'name' => 'Para cambiar la visibilidad del trabajo',
                'path' => '/^\/portfolio\/visibilidad\/trabajo\/[0-9]+$/',
                'action' => [TrabajosController::class, 'VisibilidadAction'],
                'perfil' => ["usuario"]]); 

// Ruta para cambiar la visibilidad de una skill
$router->add([ 'name' => 'Para cambiar la visibilidad de las skills',
                'path' => '/^\/portfolio\/visibilidad\/skill\/[0-9]+$/',
                'action' => [SkillController::class, 'VisibilidadAction'],
                'perfil' => ["usuario"]]); 

// Ruta para cambiar la visibilidad de una red social
$router->add([ 'name' => 'Para cambiar la visibilidad de las redes sociales',
                'path' => '/^\/portfolio\/visibilidad\/redSocial\/[0-9]+$/',
                'action' => [RedSocialController::class, 'VisibilidadAction'],
                'perfil' => ["usuario"]]); 

// Ruta para verificar una cuenta por el correo electronico
$router->add([ 'name' => 'Para verfificar la cuenta',
                'path' => '/^\/verificacion(\/|\?token=)[\w\|.\+\-\/=]+$/',
                'action' => [UsuarioController::class, 'VerificarAction']]);

// Ruta para eliminar un portfolio
$router->add([ 'name' => 'Eliminar portfolio',
                'path' => '/^\/portfolio\/del\/$/',
                'action' => [PortfolioController::class, 'DelPortfolioAction'],
                'perfil' => ["usuario"]]); 

// Ruta para actualizar una imagen
$router->add([ 'name' => 'Actualizar imagen',
                'path' => '/^\/portfolio\/uploadImage$/',
                'action' => [UsuarioController::class, 'UpdateFotoAction'],
                'perfil' => ["usuario"]]); 

// Esto limpia la ruta de la petición
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = $router->match($request);

if($route){
    if (isset($route['perfil']) && !in_array($_SESSION['perfil_usuario'], $route['perfil'])) {
        header("Location: /");
    } else{
        $controllerName = $route['action'][0];
        $actionName = $route['action'][1];
        $controller = new $controllerName;
        $controller->$actionName($request);
    }
    
}else{
    echo "No route";
}