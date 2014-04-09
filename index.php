<?php 
require 'cfg/base.php';
$musuarios->comprobarSesionInicio();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<link rel="shortcut icon" href="img/favicon.ico" />
		<title>.:[SICOIN - IUTAI]:.</title>
		<meta name="Sistema de Correo Interno IUTAI" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/assets.css">
		<?php require 'js/assets.php'; ?>
	</head>
	<body>
		<div id="modal-form" class="modal fade in" tabindex="-1">
    	<div class="modal-dialog"><div class="modal-content"></div></div>
    </div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<img src="img/header-new.jpg" alt="" class="logo">
				</div>
			</div>
			<div class="space-4"></div>
			<div class="row">
				<div class="col-xs-12">
					<?php require 'menu.php'; ?>
				</div>
			</div>

			<div class="page-content">
				<div class="space-8"></div>
				<div class="col-xs-12">
					<?php require 'contenido.php'; ?>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</body>
</html>