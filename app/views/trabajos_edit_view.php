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
    <h3>Formulario de creacion de trabajos</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Información de proyectos</legend>
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo $data[0]['titulo']?>"><br/>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"><?php echo $data[0]['descripcion']?></textarea><br/>
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"value="<?php echo $data[0]['fecha_inicio']?>"><br/>
            <label for="fecha_final">Fecha final</label>
            <input type="date" name="fecha_final" id="fecha_final"value="<?php echo $data[0]['fecha_final']?>"><br/>
            <label for="logros">Logros</label>
            <textarea name="logros" id="logros"></textarea><br/>
        </fieldset>
        <input type="submit" name="editar" id="enviar" value="Crear">
    </form>
</body>
</html>