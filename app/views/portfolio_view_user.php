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
<?php if ($perfil == ""){
        require_once "cabecera_view.php";
    }else if($perfil == "usuario"){ 
        require_once "cabecera_in_view.php";
    }else{
        require_once "cabecera_admin_view.php";
    } ?>
    <h3>Gestión del portfolio de <?php echo $data['usuario']['nombre'] ?></h3>
    <div class="portfolio-actions">
    </div>
    <h3>Datos Personales</h3>
    <div class="flexeo">
        <div class="caja">
            <p class="informacion"><span class="negrita">Nombre:</span> <?php echo $data['usuario']['nombre'] ?></p>
            <p class="informacion"><span class="negrita">Apellidos:</span> <?php echo $data['usuario']['apellidos'] ?></p>
            <p class="informacion"><span class="negrita">Email:</span> <?php echo $data['usuario']['email'] ?></p>
        </div>
    </div>
    <h3>Proyectos </h3>
    <div class="flexeo">
        <?php
        if($data['proyectos'] !=  null){
            foreach ($data['proyectos'] as $proyecto) {
                echo "<div class='caja'>";
                echo "<p class='informacion'><span class='negrita'>Titulo:</span> " . $proyecto['titulo'] . "</p>";
                echo "<p class='informacion'><span class='negrita'>Descripción:</span> " . $proyecto['descripcion'] . "</p>";
                echo "<div class='botones'>";
                echo "<p class='informacion'><span class='negrita'>Tecnologías empleadas:</span> " . $proyecto['tecnologias'] . "</p>";
                echo "<div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else{
            echo "<p class='informacion'>No hay proyectos</p>";
        }
        ?>
    </div>
    <h3>Redes Sociales </h3>
    <div class="flexeo">
        <?php
            if($data['redesSociales'] == null){
                echo "<p class='informacion'>No hay redes sociales</p>";
            }else{
                foreach ($data['redesSociales'] as $redSocial) {
                echo "<div class='caja'>";
                echo "<p class='informacion'><span class='negrita'>Nombre:</span> " . $redSocial['redes_socialescol'] . "</p>";
                echo "<div class='botones'>";
                echo "<p class='informacion'><span class='negrita'>Url:</span> " . $redSocial['url'] . "</p>";
                echo "<div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                }
            }
        ?>
    </div>

    <h3>Trabajos </h3>
    <div class="flexeo">
        <?php
        if($data['trabajos'] == null){
            echo "<p class='informacion'>No hay trabajos</p>";
        }else{
            foreach ($data['trabajos'] as $trabajo) {
                echo "<div class='caja'>";
                echo "<p class='informacion'><span class='negrita'>Titulo:</span> " . $trabajo['titulo'] . "</p>";
                echo "<p class='informacion'><span class='negrita'>Descripción:</span> " . $trabajo['descripcion'] . "</p>";
                echo "<p class='informacion'><span class='negrita'>Fecha de inicio:</span> " . $trabajo['fecha_inicio'] . "</p>";
                echo "<p class='informacion'><span class='negrita'>Fecha de fin:</span> " . $trabajo['fecha_final'] . "</p>";
                echo "<div class='botones'>";
                echo "<p class='informacion'><span class='negrita'>Logros:</span> " . $trabajo['logros'] . "</p>";
                echo "<div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
    <h3>Skills </h3>
    <div class="flexeo">
        <?php
            if($data['skills'] == null){
                echo "<p class='informacion'>No hay skills</p>";
            }else{
                foreach ($data['skills'] as $skill) {
                    echo "<div class='caja'>";
                    echo "<p class='informacion'><span class='negrita'>Habilidad:</span> " . $skill['habilidades'] . "</p>";
                    echo "<div class='botones'>";
                    echo "<p class='informacion'><span class='negrita'>Skill:</span> " . $skill['categorias_skills_categoria'] . "</p>";
                    echo "<div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
    </div>
</body>
</html>