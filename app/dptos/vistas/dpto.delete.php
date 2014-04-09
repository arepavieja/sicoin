<?php 
require '../../../cfg/base.php';
$dpto_row = $mdptos->selectIde();
?>

<script>
	$(function(){
		$('.dpto-delete').submit(function(e){
			e.preventDefault();
			$.post('app/dptos/procesos/p.dpto.delete.php',$('.dpto-delete').serialize(),function(data){
				if(data==1) {
					$('.msj2').fadeOut('1');
					alerta('.msj1','success','Registro eliminado correctamente');
					load('app/dptos/vistas/dptos.lista.php','','#dptos')
					setTimeout($('#modal-form').modal('hide'),5000)
				} else {
					alerta('.msj1','danger',data)
				}
			})
		})	
	})
</script>

<form action="" class="form-horizontal dpto-delete">
	<?php echo $fun->modalHeader('Eliminar Departamento') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		<h5 class="text-danger text-center msj2">
			¿Realmente desea borrar el departamento: <span class="bolder"><?php echo $dpto_row[0]->dedescri ?></span>?
		</h5>
	</div>
	<?php echo $fun->modalFooter() ?>
	<input type="hidden" name="ide" value="<?php echo $dpto_row[0]->deide ?>">
</form>