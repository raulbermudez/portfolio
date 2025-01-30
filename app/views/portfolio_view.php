<?php
    require_once "loged.php";
    if($data['proyectos'] == null && $data['redesSociales'] == null && $data['tareas'] == null && $data['trabajos'] == null){
        $creacion = false;
    } else{
        $creacion = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion de portfolio</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/form-login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=add,delete,edit" />
    <style>
        .portfolio-actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover, .btn-edit-small:hover {
            background-color: #0056b3;
        }

        .btn-create {
            background-color: #28a745;
        }

        .btn-create:hover {
            background-color: #218838;
        }

        .btn-del {
            background-color: #dc3545;
        }

        .btn-del:hover, .btn-del-small:hover {
            background-color: #c82333;
        }

        .btn-edit-small, .btn-del-small, .btn-create-small {
            display: inline-block;
            padding: 5px 10px;
            font-size: 8px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }

        .btn-del-small{
            background-color: #dc3545;
        }

        .btn-create-small{
            background-color: #f4f4f4;
            color: black;
        }

        .botones{
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: center;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-size: 16px;
        }

        a{
            margin: 2.5px 0;
        }

        .borde{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <?php 
        require_once "cabecera_in_view.php";
    ?>
    <h3>Gestión del portfolio de <?php echo $_SESSION['nombre'] ?></h3>
    <!-- <div class="portfolio-actions">    
    <?php
        if(!$creacion){
            echo '<a class="btn btn-create" href="/portfolio/crear/">Crear Portfolio</a>';
        }
    ?>
    </div> -->
    <h3>Datos Personales</h3>
    <div class="flexeo">
        <div class="caja">
            <p class="informacion"><span class="negrita">Nombre:</span> <?php echo $_SESSION['nombre'] ?></p>
            <p class="informacion"><span class="negrita">Apellidos:</span> <?php echo $_SESSION['apellidos'] ?></p>
            <p class="informacion"><span class="negrita">Email:</span> <?php echo $_SESSION['email'] ?></p>
        </div>
    </div>
    <h3>Proyectos <a class="borde btn-create-small" href="/portfolio/crear/proyecto/"><span class="material-symbols-outlined">add</span></a></h3>
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
                echo '<a class="btn-edit-small" href="/portfolio/editar/proyecto/' .  $proyecto["id"] . '"><span class="material-symbols-outlined">edit
                </span></a>';
                echo '<a class="btn-del-small" href="/portfolio/del/proyecto/' . $proyecto['id'] . '"><span class="material-symbols-outlined">delete
                </span></a>';
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else{
            echo "<p class='informacion'>No hay proyectos</p>";
        }
        ?>
    </div>
    <h3>Redes Sociales <a class="borde btn-create-small" href="/portfolio/crear/redesSociales/"><span class="material-symbols-outlined">add</span></a></h3>
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
                echo '<a class="btn-edit-small" href="/portfolio/editar/redsocial/' .  $redSocial["id"] . '"><span class="material-symbols-outlined">edit
                </span></a>';
                echo '<a class="btn-del-small" href="/portfolio/del/redsocial/' . $redSocial['id'] . '"><span class="material-symbols-outlined">delete
                </span></a>';
                echo "</div>";
                echo "</div>";
                echo "</div>";
                }
            }
        ?>
    </div>

    <h3>Trabajos <a class="borde btn-create-small" href="/portfolio/crear/trabajo/"><span class="material-symbols-outlined">add</span></a></h3>
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
                echo '<a class="btn-edit-small" href="/portfolio/editar/trabajo/' .  $trabajo["id"] . '"><span class="material-symbols-outlined">edit
                </span></a>';
                echo '<a class="btn-del-small" href="/portfolio/del/trabajo/' . $trabajo['id'] . '"><span class="material-symbols-outlined">delete
                </span></a>';
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
    </div>
    <h3>Skills <a class="borde btn-create-small" href="/portfolio/crear/skills/"><span class="material-symbols-outlined">add</span></a></h3>
    <div class="flexeo">
        <?php
            if($data['tareas'] == null){
                echo "<p class='informacion'>No hay skills</p>";
            }else{
                foreach ($data['tareas'] as $skill) {
                    echo "<div class='caja'>";
                    echo "<p class='informacion'><span class='negrita'>Habilidad:</span> " . $skill['habilidades'] . "</p>";
                    echo "<div class='botones'>";
                    echo "<p class='informacion'><span class='negrita'>Skill:</span> " . $skill['categorias_skills_categoria'] . "</p>";
                    echo "<div>";
                    echo '<a class="btn-edit-small" href="/portfolio/editar/skill/' .  $skill["id"] . '"><span class="material-symbols-outlined">edit
                </span></a>';
                    echo '<a class="btn-del-small" href="/portfolio/del/skill/' . $skill['id'] . '"><span class="material-symbols-outlined">delete
                </span></a>';
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
    </div>
</body>
</html>