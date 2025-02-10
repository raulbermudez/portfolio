<?php

namespace App\Controllers;
use App\Models\Usuarios;
use App\Models\Proyectos;
use App\Core\EmailSender;

class UsuarioController extends BaseController
{

    // Manejo de la página principal de la aplicación
    public function IndexAction()
    {
        if (isset($_GET)){
            if (isset($_GET['filtro'])){
                $filtro = $_GET['filtro'];
            } else{
                $filtro = "";
            }
            $data["filtro"] = $filtro;
            

            // Creamos una instancia de usuarios
            $usuario = Usuarios::getInstancia();
            $tecnologias = Proyectos::getInstancia();
    
            $data['tecnologias'] = $tecnologias->getTecnologiasFromSearch($filtro);

            if ($data['tecnologias'] !== null){
                // Una vez que tengo el id saco todos los usuarios con ese id
                foreach ($data["tecnologias"] as $tecnologia => $valor){
                    $tecnolo = $usuario->get($valor['usuarios_id']);
                    $data['usuarios'][$valor['usuarios_id']] = $tecnolo;
                }
            }
            
            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/index_view.php', $data);
        } else{
            // Creamos una instancia de usuarios
            $usuario = Usuarios::getInstancia();
            $tecnologias = Proyectos::getInstancia();

            // Alamacenamos los datos en $data
            $data['usuarios'] = $usuario->getAll();
            $data['tecnologias'] = $tecnologias->getTecnologias();

            // Llamamos a la función renderHTML
            $this->renderHTML('../app/views/index_view.php', $data);
        }
        
    }

    // Manejo de creación de usuarios en la base de datos.
    public function AddAction()
    {
        $lprocesaFormulario = false;
        $data = array();
        $data['nombre'] = $data['apellidos'] = $data['email'] = $data['password'] = $data['password_confirmation'] = $data['perfil_usuario'] = $data['picture'] = '';
        $data['msjErrorNombre'] = $data['msjErrorApellidos'] = $data['msjErrorEmail'] = $data['msjErrorPassword'] = $data['msjErrorPassword2'] = $data['msjErrorImagen'] = '';

        $data['picture'] = "default.png";
        $img = false;
        if(!empty($_POST)){
            // Saneamos las entradas antes de utilizarlas
            $data['nombre'] = $_POST['nombre'];
            $data['apellidos'] = $_POST['apellidos'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['password_confirmation'] = $_POST['password_confirmation'];
            $data['perfil_usuario'] = $_POST['perfil_usuario'];
            if (isset($_FILES['profile_picture'])  && $_FILES['profile_picture']['name'] != "") {
                $data['picture'] = $_FILES['profile_picture'];
                // Comprobamos si se ha subido una imagen
            if ($data['picture']['error'] == 0) {
                // Comprobamos si el archivo subido es una imagen
                if ($data['picture']['type'] == 'image/jpeg' || $data['picture']['type'] == 'image/png') {
                    // Comprobamos si el archivo subido no supera los 2MB
                    if ($data['picture']['size'] <= 2000000) {
                        $img = true;
                    } else {
                        $lprocesaFormulario = false;
                        $data['msjErrorImagen'] = "* La imagen no puede superar los 2MB";
                    }
                } else {
                    $lprocesaFormulario = false;
                    $data['msjErrorImagen'] = "* El archivo subido no es una imagen";
                }
            }
            }

            // Creamos una instancia de usuarios
            $objUsuario = Usuarios::getInstancia();

            $lprocesaFormulario = true;

            // Validamos que el campo nombre no esté vacío
            if (empty($data['nombre'])) {
                $lprocesaFormulario = false;
                $data['msjErrorNombre'] = "* El nombre no puede estar vacío";
            }

            // Validamos que el campo apellidos no esté vacío
            if (empty($data['apellidos'])) {
                $lprocesaFormulario = false;
                $data['msjErrorApellidos'] = "* Los apellidos no pueden estar vacíos";
            }

            // Validamos que el campo email no esté vacío
            if (empty($data['email'])) {
                $lprocesaFormulario = false;
                $data['msjErrorEmail'] = "* El email no puede estar vacío";
            }

            // Validamos que el email no se encuentre ya en la base de datos
            if ($objUsuario->emailExists($data['email'])) {
                $lprocesaFormulario = false;
                $data['msjErrorEmail'] = "* El email ya está en uso";
            }

            // Validamos que el campo password no esté vacío
            if (empty($data['password'])) {
                $lprocesaFormulario = false;
                $data['msjErrorPassword'] = "* La contraseña no puede estar vacía";
            }

            // valida que el campo password_confirmation sea igual que password
            if ($data['password'] !== $data['password_confirmation']) {
                $lprocesaFormulario = false;
                $data['msjErrorPassword2'] = "* Las contraseñas no coinciden";
            }
        }

        if ($lprocesaFormulario) {
            var_dump($data);
            if ($img){
                // Subo la imagen
                $nombre = $data['picture']['name'];
                // Obtengo la extension de la imagen
                $ext = explode(".", $nombre);
                $name = end($ext);
                // Generamos un nombre para la imagen al azar
                $data['picture']['name'] = uniqid() . "." . $name;
                // Movemos el archivo a la carpeta de imágenes
                move_uploaded_file($data['picture']['tmp_name'], dirname(__DIR__, 2) . '/public/img/' . $data['picture']['name']);
            } else{
                // Movemos el archivo a la carpeta de imágenes
                move_uploaded_file($data['picture'], dirname(__DIR__, 2) . '/public/img/' . $data['picture']);
            }
            
            // Generación de token
            $rb = random_bytes(32);
            $token = base64_encode($rb);
            $secureToken = uniqid("",true) . $token;

            if(isset($data['picture']['name'])){
                $fotografia = $data['picture']['name'];
            } else{
                $fotografia = $data['picture'];
            }

            // Guardar el usuario en la base de datos
            $objUsuario->setNombre($data['nombre']);
            $objUsuario->setApellidos($data['apellidos']);
            $objUsuario->setFoto($fotografia);
            $objUsuario->setEmail($data['email']);
            $objUsuario->setPassword($data['password']);
            $objUsuario->setProfileSummary($data['perfil_usuario']);
            $objUsuario->setToken($secureToken);
            $objUsuario->setActivo(0);
            $objUsuario->set();

            $emailSender = new EmailSender;
            $emailSender->sendConfirmationMail($data['nombre'], $data['apellidos'], $data['email'], $secureToken);

            header('Location: ..');
        } else {
            // Mostrar la vista de agregar usuario con los datos y errores
            $this->renderHTML('../app/views/register.php', $data);
        }
    }

    // Manejo del login de usuarios en la base de datos
    public function LoginAction()
    {
        $data = array();
        $data['email'] = $data['password'] = '';
        $data['msjErrorEmail'] = $data['msjErrorPassword'] = $data['msjErrorMissmatch'] = '';

        if(!empty($_POST)){
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            // Creamos una instancia de usuarios
            $objUsuario = Usuarios::getInstancia();

            // Validamos que el campo email no esté vacío
            if (empty($data['email'])) {
                $data['msjErrorEmail'] = "* El email no puede estar vacío";
            }

            // Validamos si el correo existe en la base de datos
            if (!$objUsuario->emailExists($data['email'])) {
                $data['msjErrorEmail'] = "* El email no está registrado";
            }

            // Validamos que el campo password no esté vacío
            if (empty($data['password'])) {
                $data['msjErrorPassword'] = "* La contraseña no puede estar vacía";
            }

            // Validamos que el email y la contraseña coincidan, además de comprobar si la cuenta está activa
            if ($objUsuario->emailPasswordExists($data['email'], $data['password']) && $objUsuario->estaActivo($data['email'])){

                // Guardamos el email y el nombre y apellidos del usuario en la sesión
                $_SESSION['email'] = $data['email'];
                $_SESSION['nombre'] = $objUsuario->getNameByEmail($data['email']);
                $_SESSION['apellidos'] = $objUsuario->getLastNameByEmail($data['email']);
                $_SESSION['perfil_usuario'] = $objUsuario->getUserProfile($data['email']);
                $_SESSION['id'] = $objUsuario->getIdByEmail($data['email']);
                $_SESSION['imagen'] = $objUsuario->getFotoByEmail($data['email']);

                header('Location: ..');
            } 

            // Validamos que la cuenta se encuentra activa
            if (!$objUsuario->emailPasswordExists($data['email'], $data['password'])){
                $data['msjErrorMissmatch'] = "El email o la contraseña no son correctos";
            }else if (!$objUsuario->estaActivo($data['email'])) {
                $data['msjErrorMissmatch'] = "La cuenta no está activa, revisa el correo electronico";
            }
        }
        // Mostrar la vista de login con los datos y errores
        $this->renderHTML('../app/views/login.php', $data);
    }

    // Manejo del logout de usuarios en la base de datos
    public function LogoutAction()
    {
        // Iniciar sesión
        session_start();

        // Destruir la sesión
        session_destroy();

        header('Location: ..');
    }

    public function VerificarAction(){
        // Obtiene el token de la URL
        $token = explode('/', string: $_SERVER['REQUEST_URI']);
        // Elimina los dos primeros elementos del array $token y los une en una cadena separada por / y lo almacena en la variable $token
        $token = array_slice($token, 2);
        $token = implode('/', $token);
        // var_dump($token);
        // die();

        // Crea una instancia de la clase Usuarios y verifica el token
        $claseUsuario = Usuarios::getInstancia();
        $claseUsuario->verificarToken($token);

        // Si el token es válido, muestra un mensaje de éxito y redirige a la página principal
        if ($claseUsuario->getMensaje() == 'Usuario verificado') {
            // $_SESSION['autenticado'] = true;
            // $_SESSION['usuario'] = $claseUsuario->nombre;
            //     $this->cerrarSesionAction();
            header('Location: /usuarios/login');
        } else {
            echo "<h2>" . $claseUsuario->getMensaje() . "</h2>";
            header('Location: /usuarios/login');
        }
    }

    // Funcion para actualizar la foto
    public function UpdateFotoAction(){
        session_start();
        $data = array();
        $data['picture'] = '';
        $data['msjErrorImagen'] = '';

        // Comprobamos si se ha subido una imagen
        $img = false;
        if(isset($_POST['actualizar'])){
            // Comprobamos si se ha subido una imagen
            if ($_FILES['profileImage']['error'] == 0) {
                // Comprobamos si el archivo subido es una imagen
                if ($_FILES['profileImage']['type'] == 'image/jpg' || $_FILES['profileImage']['type'] == 'image/jpeg' || $_FILES['profileImage']['type'] == 'image/png') {
                    // Comprobamos si el archivo subido no supera los 2MB
                    if ($_FILES['profileImage']['size'] <= 2000000) {
                        $img = true;
                    } else {
                        $data['msjErrorImagen'] = "* La imagen no puede superar los 2MB";
                    }
                } else {
                    $data['msjErrorImagen'] = "* El archivo subido no es una imagen";
                }
            }
        }

        if ($img){
            // Subo la imagen
            $nombre = $_FILES['profileImage']['name'];
            // Obtengo la extension de la imagen
            $ext = explode(".", $nombre);
            $name = end($ext);
            // Generamos un nombre para la imagen al azar
            $nombre = uniqid() . "." . $name;
            // Movemos el archivo a la carpeta de imágenes
            move_uploaded_file($_FILES['profileImage']['tmp_name'], dirname(__DIR__, 2) . '/public/img/' . $nombre);
        } else{
            $nombre = "default.png";
        }

        $_SESSION['imagen'] = $nombre;

        // Creamos una instancia de usuarios
        $objUsuario = Usuarios::getInstancia();

        // Guardar el usuario en la base de datos
        $objUsuario->setFoto($nombre);
        $objUsuario->updateFoto($_SESSION['id']);

        header('Location: ..');
    }
}