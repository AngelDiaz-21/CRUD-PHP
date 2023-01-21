<!DOCTYPE html>
<html>
<head>
	<title>PDO</title>
	<link rel="stylesheet" type="text/css" href="librerias/bootstrap5/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body>
	<header>
		<?php
			require 'views/header.php';
		?>
	</header>
	<main class="mt-5">
		<div class="container">
			<div class="row">
				<h2>Empleados - Crud con PDO y MySQL - MVC</h2>
				<div class="col-sm-12">
					<div class="card text-left">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<span class="btn btn-primary" data-toggle="modal" data-target="#insertarModal">
										<i class="fas fa-plus-circle"></i> Nuevo registro
									</span>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-12">
									<!-- En este div se ejecuta la función mostrar -->
									<div id="tablaDatos"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<footer>
		<?php
			require 'views/footer.php';
		?>
	</footer>

	<?php require 'views/empleados/modals/modalInsert.php'; ?>
	<?php require 'views/empleados/modals/modalUpdate.php'; ?>

	<script src="librerias/bootstrap5/jquery-3.4.1.min.js"></script>
	<script src="librerias/bootstrap5/popper.min.js"></script>
	<script src="librerias/bootstrap5/bootstrap.min.js"></script>
	<script src="librerias/sweetalert.min.js"></script>
	<script src="js/crudEmpleados.js"></script>
	<script type="text/javascript">
		mostrar();
	</script>
</body>
</html>