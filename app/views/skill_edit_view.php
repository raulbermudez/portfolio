<?php
    require_once "loged.php";
    // Recojo el valor de $data['skills'] que viene del controlador
    $skills = $data['skills'];
    var_dump($_POST);
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
    <h3>Formulario de creacion de skills</h3>
    <form action="" method="post" enctype="multipart/form-data">
    <fieldset>
            <legend>Información de skills</legend>
            <label for="habilidades">Habilidades</label>
            <input type="text" name="habilidades" id="habilidades" value="<?php echo $data[0]['habilidades']?>"><br/>
            <label for="skills">Skills:</label><br/>
            <?php
            if (!empty($skills)) {
                echo '<ul id="skills">';
                foreach ($skills as $skill) {
                    echo '<li id="categorias">';
                    if($skill['categoria'] == $data[0]['categorias_skills_categoria']){
                        echo '<input type="radio" name="skills" value="' . htmlspecialchars($skill['categoria']) . '" checked> ' . htmlspecialchars($skill['categoria']);
                    }else{
                        echo '<input type="radio" name="skills" value="' . htmlspecialchars($skill['categoria']) . '"> ' . htmlspecialchars($skill['categoria']);
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }
        ?>
        </fieldset>
        <input type="submit" name="editar" id="enviar" value="Editar">
    </form>
</body>
</html>