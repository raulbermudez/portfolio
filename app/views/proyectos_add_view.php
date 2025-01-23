<?php
    require_once "loged.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion de portfolio</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/form-login.css">
</head>
<body>
    <?php 
        require_once "cabecera_in_view.php";
    ?>
    <h3>Formulario de creacion del portfolio</h3>
    <form action="" method="post" enctype="multipart/form-data">
    <fieldset>
            <legend>Información de proyectos</legend>
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo $data['tituloP']?>"><?php echo $data['msjErrorTituloP'] ?><br/>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"><?php echo $data['descripcionP']?></textarea><?php echo $data['msjErrorDescripcionP'] ?><br/>
            <label for="tecnologias">Tecnologias</label>
            <input type="text" name="tecnologias" id="tecnologias" value="<?php echo $data['tecnologias']?>"><?php echo $data['msjErrorTecnologias'] ?><br/>
        </fieldset>
        <input type="submit" name="crear" id="enviar" value="Crear">
    </form>
</body>
</html>