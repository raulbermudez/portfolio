<?php
    require_once "loged.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de portfolios</title>
    <link rel="stylesheet" href="./css/estilo.css">
</head>
<body>
    <?php if ($perfil == ""){
        require_once "cabecera_view.php";
    }else if($perfil == "usuario"){ 
        require_once "cabecera_in_view.php";
    }else{
        require_once "cabecera_admin_view.php";
    } ?>
    <h1>Portfolios visibles</h1>
    <form action="" method="post">
        <div class="search-bar">
            <input type="text" name="filtro" placeholder="Buscar portfolios...">
            <button type="submit" name="buscar" id="buscar">Buscar</button>
        </div>
    </form>

    <?php
        if (isset($data['usuarios']) && is_array($data['usuarios'])) {
            echo '<div class="usuarios-container">';
            foreach ($data['usuarios'] as $usuario) {
                if ($usuario['visible'] == 0) {
                    continue;
                } else if ($usuario['perfil_usuario'] == "admin") {
                    continue;
                }
                echo '<div class="usuario-tarjeta">';
                echo '<h2>' . htmlspecialchars($usuario['nombre']) . ' ' . htmlspecialchars($usuario['apellidos']) . '</h2>';
                echo '<img class="fotos" src="./img/' . htmlspecialchars($usuario['foto']) . '" alt="Foto de ' . htmlspecialchars($usuario['nombre']) . '">';
                echo '<p class="parrafo">Email: ' . htmlspecialchars($usuario['email']) . '</p>';
                if (isset($data['tecnologias']) && is_array($data['tecnologias'])) {
                    echo '<ul class="tecnologias">';
                    echo "<p class='parrafo'>Tecnologias:</p>";
                    foreach ($data['tecnologias'] as $tecnologia) {
                        if ($tecnologia['usuarios_id'] == $usuario['id'] && $tecnologia['tecnologias'] != null) {
                            echo '<li>' . htmlspecialchars($tecnologia['tecnologias']) . '</li>';
                        }
                    }
                    echo '</ul>';
                }
                echo "<button class='portfolio'><a href='/portfolio/view/" . $usuario['id'] ."'>Ver portfolio</a></button>";
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No hay usuarios disponibles.</p>';
        }
    ?>

</body>
</html>