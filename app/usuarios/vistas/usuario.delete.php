<?php 
require '../../../cfg/base.php';
$usua_row = $musuarios->selectIde($_POST['ide']);
$depar_rows = $mdptos->selectAll();
$cargo_rows = $mcargos->selectAll();
?>
<script>
	$(function(){
		$('.usuario-delete').submit(function(e){
			e.preventDefault();
			$.post('app/usuarios/procesos/p.usuario.delete.php',$('.usuario-delete').serialize(),function(data){
				if(data==1){
					load('app/usuarios/vistas/usuarios.lista.php','','#usuarios-lista');
					alerta('.msj1','success','Registro Borrado correctamente');
					setTimeout("$('.modal').modal('hide')",1000);
				} else {
					alerta('.msj1','danger',data);
					//setTimeout("$('.msj1').fadeOut(1)",2000);
				}
			})
		})
	})
</script>
<form action="" class="usuario-delete">
	<?php echo $fun->modalHeader('Eliminar Usuario') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		<div class="alert alert-info">¿Borrar el usuario seleccionado?</div>
		<div class="col-sm-4 bolder">
			Cédula de Identidad:
		</div>
		<div class="col-sm-8">
			<?php echo $usua_row[0]->penacion.$usua_row[0]->pecedula ?>
		</div>
		<div class="col-sm-4 bolder">
			Apellidos y Nombres:
		</div>
		<div class="col-sm-8">
			<?php echo $usua_row[0]->penacion.$usua_row[0]->peapelli ?>, <?php echo $usua_row[0]->penacion.$usua_row[0]->penombre ?>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php echo $fun->modalFooter() ?>
	<input type="hidden" name="ide" value="<?php echo $usua_row[0]->peide ?>">
</form>

