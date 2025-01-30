<?php
    require_once "loged.php";
    if ($perfil != "admin"){
        header("Location: ..");
    }

    // Recojo el valor de $data['skills'] que viene del controlador
    $skills = $data['skills'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de portfolios</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/form-login.css">
    <style>
        #skills {
            list-style-type: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #categorias {
            background-color: #f4f4f4;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
        }

        #categorias:hover {
            background-color: #e0e0e0;
        }

        .add-skill-link {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .add-skill-link:hover {
            background-color: #0056b3;
        }

        .formato-skills {
            display: flex;
            justify-content: space-between;
        }

        .delete-link {
            margin-left: 10px;
            color: red;
            text-decoration: none;
        }

        .delete-link:hover {
            color: darkred;
        }
    </style>
</head>
<body>
    <?php
        require_once "cabecera_admin_view.php";
    ?>
    <div class="formato-skills">
        <h1>Skills creadas</h1>
        <a class="add-skill-link" href="/skills/add/">Añadir nueva skill</a>
        
    </div>
    <?php
    if (!empty($skills)) {
        echo '<ul id="skills">';
        foreach ($skills as $skill) {
            echo '<li id="categorias">' . htmlspecialchars($skill['categoria']) . '</li><a href="/skills/del/' . $skill['categoria'] .'" class="delete-link">Eliminar</a>';
        }
        echo '</ul>';
    } else {
        echo '<p>No hay skills disponibles.</p>';
    }
    ?>
</body>
</html>