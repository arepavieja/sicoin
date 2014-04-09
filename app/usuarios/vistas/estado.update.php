<?php 
require '../../../cfg/base.php';
$usua_row = $musuarios->selectIde($_POST['ide']);
$depar_rows = $mdptos->selectAll();
$cargo_rows = $mcargos->selectAll();
$estado = $cusuarios->cestadoUpdate($usua_row[0]->acestado)
?>
<script>
	$(function(){
		$('.estado-update').submit(function(e) {
			e.preventDefault();
			$.post('app/usuarios/procesos/p.estado.update.php',$('.estado-update').serialize(),function(data){
				if(data==1){
					load('app/usuarios/vistas/usuarios.lista.php','','#usuarios-lista');
					alerta('.msj1','success','Registro actualizado correctamente');
					setTimeout("$('.msj1').fadeOut(1);$('#modal-form').modal('hide')",3000);
				} else {
					alerta('.msj1','danger',data);
					//setTimeout("$('.msj1').fadeOut(1)",2000);
				}
			})
		});
		$(".uno").chosen({
			no_results_text: "No hay resultados",
			max_selected_options: 1
		});
		$(".dos").chosen({
			no_results_text: "No hay resultados"
		});
	})
</script>
<form action="" class="form-horizontal estado-update">
	<?php echo $fun->modalHeader('Registro de nuevo usuario') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		<div class="text-danger text-center">
			Por favor, confirme que realmente desea <span class="bolder"><?php echo $estado['estado'] ?></span> al usuario:
		</div>
		<div class="space-14"></div>
		<div class="form-group">
			<label for="" class="control-label col-sm-3 no-padding-right bolder">Cédula:</label>
			<div class="col-sm-1">
				<select name="nacionalidad" id="" disabled>
					<option value="V" <?php echo $fun->selected('V',$usua_row[0]->penacion) ?>>V</option>
					<option value="E" <?php echo $fun->selected('E',$usua_row[0]->penacion) ?>>E</option>
				</select>
			</div>
			<div class="col-sm-7">
				<input disabled type="text" name="cedula" class="col-sm-12" value="<?php echo $usua_row[0]->pecedula ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Apellidos:</label>
			<div class="col-sm-8">
				<input type="text" disabled class="form-control" name="apellidos" value="<?php echo $usua_row[0]->peapelli ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Nombres:</label>
			<div class="col-sm-8">
				<input type="text" disabled class="form-control" name="nombres" value="<?php echo $usua_row[0]->penombre ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Usuario:</label>
			<div class="col-sm-8">
				<input disabled type="text" class="form-control" name="usuario" value="<?php echo $usua_row[0]->acnomusu ?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="control-label bolder no-padding-right col-sm-3">Departamento:</label>
			<div class="col-sm-8">
				<select disabled class="width-90 chosen-select uno" data-placeholder="Seleccione Departamento" name="departamento">	
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
				<select disabled class="width-90 chosen-select dos" data-placeholder="Seleccione Función" name="cargo">	
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
	<input type="hidden" name="estado" value="<?php echo $_POST['estado'] ?>">
</form>

<script>
	$(document).ready(function(){
		$('.chosen-container').attr('style','width:100%');
	})
</script>