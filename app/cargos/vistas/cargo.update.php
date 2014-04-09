<?php 
require '../../../cfg/base.php';
$cargo_row = $mcargos->selectIde();
?>

<script>
	$(function(){
		$('.cargo-update').validate({
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
				$('.alert-danger', $('.cargo-update')).show();
			},

			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},

			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
				$(e).remove();
			},
			submitHandler: function (form) {
				$.post('app/cargos/procesos/p.cargo.update.php',$('.cargo-update').serialize(),function(data){
					if(data==1) {
						alerta('.msj1','success','Registro actualizado correctamente');
						load('app/cargos/vistas/cargos.lista.php','','#cargos')
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

<form action="" class="form-horizontal cargo-update">
	<?php echo $fun->modalHeader('Editar Cargo') ?>
	<div class="modal-body">
		<div class="msj1"></div>
		<div class="form-group">
			<label for="" class="lbl col-sm-12 bolder">Descripción</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="descripcion" value="<?php echo $cargo_row[0]->cadescri ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="lbl col-sm-12 bolder">Abreviatura</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="abreviatura" value="<?php echo $cargo_row[0]->caabrevi ?>">
			</div>
		</div>
	</div>
	<?php echo $fun->modalFooter() ?>
	<input type="hidden" name="ide" value="<?php echo $cargo_row[0]->caide ?>">
</form>