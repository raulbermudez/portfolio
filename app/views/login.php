<?php
    require_once "loged.php";
    if ($isLogged){
        header("Location: ..");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion de portfolios</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/estilo.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/form-login.css">
</head>
<body>
    <?php if (!$isLogged){
            require_once "cabecera_view.php";
        }
    ?>
    <h3>Formulario de inicio de sesión</h3>
    <form action="" method="post">
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo $data["email"]?>" required><?php echo $data["msjErrorEmail"]?><br><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" value="<?php echo $data["password"]?>" required><?php echo $data["msjErrorPassword"]?><br><br>
        
        <?php echo $data["msjErrorMissmatch"] . "<br/>"?>
        <input type="submit" id="enviar" value="submit">
    </form>
</body>
</html>