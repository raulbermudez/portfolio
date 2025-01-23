<?php
    require_once "loged.php";

    // Recojo el valor de $data['skills'] que viene del controlador
    $skills = $data['skills'];
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
        <fieldset>
            <legend>Información de redes sociales</legend>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $data['nombre']?>"><?php echo $data['msjErrorNombre'] ?><br/>
            <label for="descripcion">Url</label>
            <input type="url" name="url" id="url"value="<?php echo $data['url']?>"><?php echo $data['msjErrorUrl'] ?><br/>
        </fieldset>
        <fieldset>
            <legend>Información de trabajos</legend>
            <label for="titulo_trab">Titulo</label>
            <input type="text" name="titulo_trab" id="titulo_trab"value="<?php echo $data['tituloT']?>"><?php echo $data['msjErrorTituloT'] ?><br/>
            <label for="descripcion_trab">Descripción</label>
            <textarea name="descripcion_trab" id="descripcion_trab"><?php echo $data['descripcionT']?></textarea><?php echo $data['msjErrorDescripcionT'] ?><br/>
            <label for="fecha_inicio">Fecha de inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"value="<?php echo $data['fechaIni']?>"><?php echo $data['msjErrorFechaIni'] ?><br/>
            <label for="fecha_final">Fecha final</label>
            <input type="date" name="fecha_final" id="fecha_final"value="<?php echo $data['fechaFin']?>"><?php echo $data['msjErrorFechaFin'] ?><br/>
            <label for="logros">Logros</label>
            <textarea name="logros" id="logros"></textarea><br/>
        </fieldset>
        <fieldset>
            <legend>Información de skills</legend>
            <label for="habilidades">Habilidades</label>
            <input type="text" name="habilidades" id="habilidades" value="<?php echo $data['habilidadesS']?>"><?php echo $data['msjErrorHabilidadesS'] ?><br/>
            <label for="skills">Skills:</label><br/>
            <?php
            if (!empty($skills)) {
                echo '<ul id="skills">';
                foreach ($skills as $skill) {
                    echo '<li id="categorias">';
                    echo '<input type="radio" name="skills" value="' . htmlspecialchars($skill['categoria']) . '"> ' . htmlspecialchars($skill['categoria']);
                    echo '</li>';
                }
                echo '</ul>';
            }
        ?>
        </fieldset>
        <input type="submit" name="crear" id="enviar" value="Crear">
    </form>
</body>
</html>