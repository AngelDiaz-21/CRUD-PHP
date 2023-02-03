<!DOCTYPE html>
<html lang="es">
<head>
	<title>PDO</title>
	<link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>librerias/bootstrap5/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="<?php echo constant('URL');?>public/css/style.css">
	<link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/120px-PHP-logo.svg.png" sizes="32x32">
</head>
<body>

	<header>
		<?php
			require 'views/header.php';
		?>
	</header>

    <main>
		<section class="d-flex justify-content-center mt-5">
			<h1>Sección principal</h1>
		</section>
	</main>

	<footer>
		<?php
			require 'views/footer.php';
		?>
	</footer>
</body>
</html>