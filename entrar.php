<?php 
require 'cfg/base.php';
$musuarios->comprobarSesionLogin();
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
	<script>
		$(function(){
			$('.login').validate({
				errorElement: 'div',
				errorClass: 'help-block',
				focusInvalid: true,
				rules: {
					nomusu: {
						required: true
					},
					clave: {
						required: true
					}
				},

				messages: {
					nomusu: {
						required: 'Debe indicar el nombre de usuario'
					},
					clave: {
						required: 'Debe escribir su clave de acceso'
					}
				},

				invalidHandler: function (event, validator) { //display error alert on form submit   
					$('.alert-danger', $('.login')).show();
				},

				highlight: function (e) {
					$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
				},

				success: function (e) {
					$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
					$(e).remove();
				},
				submitHandler: function (form) {
					$.post('app/usuarios/procesos/p.login.php',$('.login').serialize(),function(data){
						if(data==1) {
							location.href="inicio";
						} else {
							alerta('.msj','danger',data);
						}
					})
				}
			});
		})
</script>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<img src="img/header-new.jpg" alt="" class="logo">
				</div>
			</div>
			<div class="page-content">			
				<div class="space-24"></div>
				<div class="row">
					<div class="col-sm-4 col-sm-offset-4">
						<div class="msj"></div>
						<form action="" class="form-horizontal well well-lg login">
							<div class="form-group">
								<label for="" class="control-label col-sm-3 bolder">
									Usuario:
								</label>
								<div class="col-sm-9">
									<span class="input-icon">
										<input type="text" class="form-control" name="nomusu">
										<i class="icon-user"></i>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-sm-3 bolder">
									Clave:
								</label>
								<div class="col-sm-9">
									<span class="input-icon">
										<input type="password" class="form-control" name="clave">
										<i class="icon-lock"></i>
									</span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-primary pull-right">
										<i class="fa fa-check"></i> Entrar
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</body>

</html>
