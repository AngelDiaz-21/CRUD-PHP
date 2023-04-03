<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/reset.css?version=0.0.3">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/default.css?version=0.0.1">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css?version=0.0.3">
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>librerias/bootstrap5/bootstrap.min.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/120px-PHP-logo.svg.png" sizes="32x32">
</head>
<body>
    <header><?php $this->showMessages(); ?></header>
    <div id="login-main" class="mb-5">
        <form action="<?php echo constant('URL'); ?>login/authenticate" method="POST">
        <div></div>
            <h2>Iniciar sesión</h2>
            <p class="mb-0">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off">
            </p>
            <p class="mb-0">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="off">
            </p>
            <p class="mb-0">
                <input type="submit" value="Iniciar sesión" />
            </p>
            <p class="mb-0 p-1">
                ¿No tienes cuenta? <a class="text-decoration-none fw-bold" href="<?php echo constant('URL'); ?>signup">Registrarse</a>
            </p>
        </form>
    </div>
    <footer><?php require 'views/footer.php'; ?></footer>
</body>
</html>