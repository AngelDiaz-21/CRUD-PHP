<!DOCTYPE html>
<html lang="es">
<head>
    <title>PDO</title>
    <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>librerias/bootstrap5/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/120px-PHP-logo.svg.png" sizes="32x32">
</head>
<body>
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <h1 class="display-1 fw-bold">404</h1>
            <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
            <p class="lead">
                <?php
                    echo $this->mensaje; 
                ?>
            </p>
            <a href="<?php echo constant('URL');?>" class="btn btn-primary">Go Home</a>
        </div>
    </div>
    <script src="<?php echo constant('URL');?>librerias/bootstrap5/jquery-3.4.1.min.js"></script>
    <script src="<?php echo constant('URL');?>librerias/bootstrap5/popper.min.js"></script>
    <script src="<?php echo constant('URL');?>librerias/bootstrap5/bootstrap.min.js"></script>
</body>
</html>
