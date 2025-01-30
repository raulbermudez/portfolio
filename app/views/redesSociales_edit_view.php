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
    <h3>Formulario de edicion de Red Social</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Información de redes sociales</legend>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $data[0]['redes_socialescol']?>"><br/>
            <label for="descripcion">Url</label>
            <input type="url" name="url" id="url"value="<?php echo $data[0]['url']?>"><br/>
        </fieldset>
        <input type="submit" name="editar" id="enviar" value="Editar">
    </form>
</body>
</html>