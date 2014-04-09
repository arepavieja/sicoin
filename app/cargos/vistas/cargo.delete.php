<?php 
require '../../../cfg/base.php';
$cargo_row = $mcargos->selectIde();
?>

<script>
	$(function(){
		$('.cargo-delete').submit(function(e){
			e.preventDefault();
			$.post('app/cargos/procesos/p.cargo.delete.php',$('.cargo-delete').serialize(),function(data){
				if(data==1) {
					$('.msj2').fadeOut('1');
					alerta('.msj1','success','Registro eliminado correctamente');
					load('app/cargos/vistas/cargos.lista.php','','#cargos')
					setTimeout($('#modal-form').modal('hide'),5000)
				} else {
					alerta('.msj1','danger',data)
				}
			})
		})	
	})
</script>

<form action="" class="form-horizontal cargo-delete">
	<?php echo $fun->modalHeader('Eliminar Cargo') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		<h5 class="text-danger text-center msj2">
			¿Realmente desea borrar el cargo con descripción: <span class="bolder"><?php echo $cargo_row[0]->cadescri ?></span>?
		</h5>
	</div>
	<?php echo $fun->modalFooter() ?>
	<input type="hidden" name="ide" value="<?php echo $cargo_row[0]->caide ?>">
</form>