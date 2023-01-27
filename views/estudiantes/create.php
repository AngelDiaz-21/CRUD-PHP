<!DOCTYPE html>
<html lang="es">
<head>
	<title>PDO</title>
	<link rel="stylesheet" type="text/css" href="../../librerias/bootstrap5/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../../public/css/style.css">
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
				<h2 class="text-center">Nuevo estudiante</h2>
				<div class="col-sm-12">
					<div class="card text-left">
						<div class="card-body">
							<form id="formCreate" onsubmit="return insertarDatos()" method="post">
								<div class="row">
									<div class="col-12 col-md-6">
										<div class="form-group">
											<label class="mb-2" for="matricula">Matricula</label>
											<input type="text" name="matricula" class="form-control" maxlength="15" 
											placeholder="Ingrese su matricula" required>
											<span></span>
										</div>
									</div>
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label class="mb-2" for="nombre">Nombre</label>
											<input type="text" name="nombre" class="form-control" maxlength="30"  placeholder="Ingrese su nombre" required>
											<span></span>
										</div>
									</div>
									<div class="col-12 col-md-6">
										<div class="form-group">
											<label class="my-2" for="apellido_p">Apellido paterno</label>
											<input type="text" name="apellido_p" class="form-control" maxlength="20" 
											placeholder="Ingrese su apellido paterno" required>
											<span></span>
										</div>
									</div>
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label class="my-2" for="apellido_m">Apellido materno</label>
											<input type="text" name="apellido_m" class="form-control" maxlength="20"  placeholder="Ingrese su apellido materno" required>
											<span></span>
										</div>
									</div>
									<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4">
										<input type="submit" value="Guardar" class="btn btn-primary">
										<a class="btn btn-sm btn-danger py-2 px-3 ml-3" href="<?php echo constant('URL');?>estudiantes">Regresar</a>
									</div>
								</div>
							</form>
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

	<script src="../../librerias/bootstrap5/jquery-3.4.1.min.js"></script>
	<script src="../../librerias/bootstrap5/popper.min.js"></script>
	<script src="../../librerias/bootstrap5/bootstrap.min.js"></script>
	<script src="../../librerias/sweetalert.min.js"></script>
	<script src="../../js/crudEstudiantes.js"></script>
</body>
</html>