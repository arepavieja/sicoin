<?php 
require '../../../cfg/base.php';
$usua_row = $musuarios->selectIde($_POST['ide']);
$depar_rows = $mdptos->selectAll();
$cargo_rows = $mcargos->selectAll();
?>
<script>
	$(function(){
		$('#telefono').mask('0999-9999999');
		$(".uno").chosen({
			no_results_text: "No hay resultados",
			max_selected_options: 1
		});
		$(".dos").chosen({
			no_results_text: "No hay resultados"
		});
		$('.usuario-update').validate({
			errorElement: 'div',
			errorClass: 'help-inline',
			focusInvalid: false,
			rules: {
				cedula: {
					required: true,
					number: true,
					maxlength: 8,
					minlength: 7
				},
				apellidos: {
					required: true
				},
				nombres: {
					required: true
				},
				correo: {
					required: true,
					email:true
				},
				correo2: {
					email:true
				},
				abreviatura: {
					required: true
				},
				usuario: {
					required: true
				},
				clave: {
					required: true
				},
				clave2: {
					required: true,
					equalTo: '#clave' 
				},
				departamento: {
					required: true
				},
				cargo: {
					required: true
				}
			},

			messages: {
				cedula: {
					required: 'Obligatorio',
					number: 'Debe ser numérico',
					maxlength: '8 caracteres máximo',
					minlength: '7 caracteres mínimo'
				},
				apellidos: {
					required: 'Obligatorio'
				},
				nombres: {
					required: 'Obligatorio'
				},
				correo: {
					required: 'Obligatorio',
					email: 'Formato no válido'
				},
				correo2: {
					email: 'Formato no válido'
				},
				abreviatura: {
					required: 'Obligatorio'
				},
				usuario: {
					required: 'Obligatorio'
				},
				clave: {
					required: 'Obligatorio'
				},
				clave2: {
					required: 'Obligatorio',
					equalTo: 'Las claves no coinciden' 
				},
				departamento: {
					required: 'Obligatorio'
				},
				cargo: {
					required: 'Obligatorio'
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit   
				$('.alert-danger', $('.usuario-update')).show();
			},

			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},

			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
				$(e).remove();
			},
			submitHandler: function (form) {
				$.post('app/usuarios/procesos/p.usuario.update.php',$('.usuario-update').serialize(),function(data){
					if(data==1){
						load('app/usuarios/vistas/usuarios.lista.php','','#usuarios-lista');
						alerta('.msj1','success','Registro actualizado correctamente');
						setTimeout("$('.msj1').fadeOut(1)",3000);
					} else {
						alerta('.msj1','danger',data);
						//setTimeout("$('.msj1').fadeOut(1)",2000);
					}
				})
			},
			invalidHandler: function (form) {
			}
		});
	})
</script>
<form action="" class="form-horizontal usuario-update">
	<?php echo $fun->modalHeader('Registro de nuevo usuario') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		
		<div class="form-group">
			<label for="" class="control-label col-sm-3 no-padding-right bolder">Cédula:</label>
			<div class="col-sm-1">
				<select name="nacionalidad" id="">
					<option value="V" <?php echo $fun->selected('V',$usua_row[0]->penacion) ?>>V</option>
					<option value="E" <?php echo $fun->selected('E',$usua_row[0]->penacion) ?>>E</option>
				</select>
			</div>
			<div class="col-sm-7">
				<input type="text" name="cedula" class="col-sm-12" value="<?php echo $usua_row[0]->pecedula ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Apellidos:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="apellidos" value="<?php echo $usua_row[0]->peapelli ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Nombres:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="nombres" value="<?php echo $usua_row[0]->penombre ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Teléfono:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $usua_row[0]->petelefo ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Correo-E:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="correo" value="<?php echo $usua_row[0]->pecorreo ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Correo N° 2:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="correo2" value="<?php echo $usua_row[0]->pecoralt ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Abreviatura:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="abreviatura" value="<?php echo $usua_row[0]->peabrevi ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Usuario:</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="usuario" value="<?php echo $usua_row[0]->acnomusu ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Clave:</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" name="clave" id="clave"  value="<?php echo $usua_row[0]->acclave ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Confirme:</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" name="clave2"  value="<?php echo $usua_row[0]->acclave ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Departamento:</label>
			<div class="col-sm-8">
				<select class="width-90 chosen-select uno" data-placeholder="Seleccione Departamento" name="departamento">	
					<option value=""></option>
					<?php foreach($depar_rows as $dr) { ?>
						<option value="<?php echo $dr->deide ?>" <?php echo $fun->selected($dr->deide,$usua_row[0]->deide) ?>>
							<?php echo $dr->dedescri ?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Función:</label>
			<div class="col-sm-8">
				<select class="width-90 chosen-select dos" data-placeholder="Seleccione Función" name="cargo">	
					<option value=""></option>
					<?php foreach($cargo_rows as $cr) { ?>
						<option value="<?php echo $cr->caide ?>" <?php echo $fun->selected($cr->caide,$usua_row[0]->caide) ?>>
							<?php echo $cr->cadescri ?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>

	</div>
	<?php echo $fun->modalFooter() ?>
	<input type="hidden" name="ide" value="<?php echo $usua_row[0]->peide ?>">
</form>

<script>
	$(document).ready(function(){
		$('.chosen-container').attr('style','width:100%');
	})
</script>