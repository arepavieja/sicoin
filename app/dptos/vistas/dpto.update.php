<?php 
require '../../../cfg/base.php';
$dpto_row = $mdptos->selectIde();
?>

<script>
	$(function(){
		$('.dpto-update').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			rules: {
				descripcion: {
					required: true
				},
				abreviatura: {
					required: true
				}
			},

			messages: {
				descripcion: {
					required: 'Debe indicar la descripción'
				},
				abreviatura: {
					required: 'Debe indicar la abreviatura'
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit   
				$('.alert-danger', $('.dpto-update')).show();
			},

			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},

			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
				$(e).remove();
			},
			submitHandler: function (form) {
				$.post('app/dptos/procesos/p.dpto.update.php',$('.dpto-update').serialize(),function(data){
					if(data==1) {
						alerta('.msj1','success','Registro actualizado correctamente');
						load('app/dptos/vistas/dptos.lista.php','','#dptos')
						setTimeout("$('.msj1').fadeOut(1)",2000)
					} else {
						alerta('.msj1','danger',data)
					}
				})
			},
			invalidHandler: function (form) {
			}
		});
	})
</script>

<form action="" class="form-horizontal dpto-update">
	<?php echo $fun->modalHeader('Editar Departamento') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		<div class="form-group">
			<label for="" class="lbl col-sm-12 bolder">Descripción</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="descripcion" value="<?php echo $dpto_row[0]->dedescri ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="lbl col-sm-12 bolder">Abreviatura</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="abreviatura" value="<?php echo $dpto_row[0]->deabrevi ?>">
			</div>
		</div>
	</div>
	<?php echo $fun->modalFooter() ?>
	<input type="hidden" name="ide" value="<?php echo $dpto_row[0]->deide ?>">
</form>