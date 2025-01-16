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
            <input type="text" name="titulo" id="titulo"><br/>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"></textarea><br/>
            <label for="tecnologias">Tecnologias</label>
            <input type="text" name="tecnologias" id="tecnologias"><br/>
            <label for="visible_pro">Visible:</label>
            <input type="checkbox" name="visible_pro" id="visible_pro">
        </fieldset>
        <fieldset>
            <legend>Información de redes sociales</legend>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre"><br/>
            <label for="descripcion">Url</label>
            <input type="url" name="url" id="url"><br/>
            <label for="visible_rs">Visible:</label>
            <input type="checkbox" name="visible_rs" id="visible_rs">
        </fieldset>
        <fieldset>
            <legend>Información de trabajos</legend>
            <label for="titulo_trab">Titulo</label>
            <input type="text" name="titulo_trab" id="titulo_trab"><br/>
            <label for="descripcion_trab">Descripción</label>
            <textarea name="descripcion_trab" id="descripcion_trab"></textarea><br/>
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"><br/>
            <label for="fecha_final">Fecha final</label>
            <input type="date" name="fecha_final" id="fecha_final"><br/>
            <label for="logros">Logros</label>
            <textarea name="logros" id="logros"></textarea><br/>
            <label for="visible_tra">Visible:</label>
            <input type="checkbox" name="visible_tra" id="visible_tra">
        </fieldset>
        <fieldset>
            <legend>Información de skills</legend>
            <label for="habilidades">Habilidades</label>
            <input type="text" name="habilidades" id="habilidades"><br/>
            <label for="visible_sk">Visible:</label>
            <input type="checkbox" name="visible_sk" id="visible_sk"><br/>
            <label for="skills">Skills:</label><br/>
        </fieldset>
        <input type="submit" id="enviar" value="Crear">
    </form>
</body>
</html>