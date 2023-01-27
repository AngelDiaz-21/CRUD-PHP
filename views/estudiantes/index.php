<!DOCTYPE html>
<html>
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
				<h2>Estudiantes - Crud con PDO y MySQL - MVC</h2>
				<div class="col-sm-12">
					<div class="card text-left">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<a class="btn btn-primary text-white text-decoration-none" href="<?php echo constant('URL');?>estudiantes/create">
										<i class="fas fa-plus-circle me-1"></i>
										Nuevo registro
									</a>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered">
										<thead>
											<tr class="font-weight-bold bg-dark text-white text-center">
												<td>Matricula</td>
												<td>Nombre</td>
												<td>Apellido Paterno</td>
												<td>Apellido Materno</td>
												<td>Editar</td>
												<td>Eliminar</td>
											</tr>
										</thead>
										<tbody id="tbody-alumnos">
											<?php 
												foreach ($this->estudiantes as $key => $value) {
											?>
											<tr id="fila-<?php echo $value['matricula']; ?>">
												<td class="text-center"><?php echo $value['matricula'];?></td>
												<td class="text-center"><?php echo $value['nombre'];?></td>
												<td class="text-center"><?php echo $value['apellido_p']?></td>
												<td class="text-center"><?php echo $value['apellido_m']?></td>
												<td class="text-center">
													<a class="btn btn-warning btn-sm" href="<?php echo constant('URL').'estudiantes/detail/'.$value['matricula'];?>">
														<i class="fas fa-edit"></i>
													</a>
												</td>
												<td class="text-center">
													<button class="btnEliminar btn btn-danger btn-sm" onclick="eliminarDatos(<?php echo $value['matricula'];?>)">
														<i class="fas fa-trash-alt"></i>
													</button>
												</td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
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

	<script src="../../librerias/bootstrap5/jquery-3.4.1.min.js"></script>
	<script src="../../librerias/bootstrap5/popper.min.js"></script>
	<script src="../../librerias/bootstrap5/bootstrap.min.js"></script>
	<script src="../../librerias/sweetalert.min.js"></script>
	<script src="../../js/crudEstudiantes.js"></script>
</body>
</html>