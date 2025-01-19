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

        .btn:hover {
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

        .btn-del:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php 
        require_once "cabecera_in_view.php";
    ?>
    <h3>Gestión del portfolio</h3>
    <div class="portfolio-actions">
        <a class="btn btn-create" href="/portfolio/crear/">Crear Portfolio</a>
        <a class="btn btn-edit" href="/portfolio/editar/<?php echo $_SESSION['id'] ?>">Editar Portfolio</a>
        <a class="btn btn-del" href="/portfolio/del/<?php echo $_SESSION['id'] ?>">Borrar Portfolio</a>
    </div>
    </div>
</body>
</html>