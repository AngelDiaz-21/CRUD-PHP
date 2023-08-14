<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/default.css">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>librerias/bootstrap5/bootstrap.min.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/120px-PHP-logo.svg.png" sizes="32x32">
    <title>Signup</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    <?php $this->showMessages(); ?>
    <div id="login-main">
        <form action="<?php echo constant('URL');?>/signup/newUser" method="POST">
        <div></div>
            <h2>Registrarse</h2>
            <p>
                <label for="username">username</label>
                <input type="text" name="username" id="username">
            </p>
            <p>
                <label for="password">password</label>
                <input type="text" name="password" id="password">
            </p>
            <p>
                <input type="submit" value="Iniciar sesión">
            </p>
            <p>
                ¿Tienes una cuenta? <a href="<?php echo constant('URL'); ?>">Iniciar sesión</a>
            </p>
        </form>
    </div>
</body>
</html>