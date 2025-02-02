<?php
namespace App\Controllers;
use App\Models\RedesSociales;

class RedSocialController extends BaseController
{
    public function AddAction(){
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

    public function EditAction($categoria){
        session_start();
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = RedesSociales::getInstancia()->getUserId($categ);
        if(!isset($_SESSION['id']) || $_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
        }

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

    public function DelAction($categoria){

        session_start();
        $data = "";
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = RedesSociales::getInstancia()->getUserId($categ);
        
        if(!isset($_SESSION['id']) || $_SESSION['id'] == null || $_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }
        $redSocial = RedesSociales::getInstancia();
        $redSocial->delete($categ);

        // Llamamos a la función renderHTML
        header('Location: /portfolio/');
    }

    public function VisibilidadAction($categoria){
        session_start();
        $elementos = explode('/', $categoria);
        $categ = end($elementos);
        $data = RedesSociales::getInstancia()->getUserId($categ);
        
        if(!isset($_SESSION['id']) || $_SESSION['id'] != $data[0]['usuarios_id']){
            header('Location: /');
            exit();
        }
        
        $proyecto = RedesSociales::getInstancia();
        $proyecto->toggleVisibility($categ);

        header('Location: /portfolio/');
    }
}