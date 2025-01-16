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
            <input type="text" name="buscar" placeholder="Buscar portfolios...">
            <button type="submit" id="buscar">Buscar</button>
        </div>
    </form>

</body>
</html>