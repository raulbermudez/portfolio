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
            <input type="text" name="titulo" id="titulo" value="<?php echo $data['tituloT']?>"><?php echo $data['msjErrorTituloT'] ?><br/>
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion"><?php echo $data['descripcionT']?></textarea><?php echo $data['msjErrorDescripcionT'] ?><br/>
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"value="<?php echo $data['fechaIni']?>"><?php echo $data['msjErrorFechaIni'] ?><br/>
            <label for="fecha_final">Fecha final</label>
            <input type="date" name="fecha_final" id="fecha_final"value="<?php echo $data['fechaFin']?>"><?php echo $data['msjErrorFechaFin'] ?><br/>
            <label for="logros">Logros</label>
            <textarea name="logros" id="logros"></textarea><br/>
        </fieldset>
        <input type="submit" name="crear" id="enviar" value="Crear">
    </form>
</body>
</html>