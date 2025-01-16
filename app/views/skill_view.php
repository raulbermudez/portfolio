<?php
    require_once "loged.php";
    if ($perfil != "admin"){
        header("Location: ..");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de portfolios</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/form-login.css">
</head>
<body>
    <?php
        require_once "cabecera_admin_view.php";
    ?>
    <a href="/skills/add/">Añadir nueva skill</a>
    <h1>Skills creadas</h1>

</body>
</html>