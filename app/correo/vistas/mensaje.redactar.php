<?php 
require '../../../cfg/base.php';
$usua_rows = $musuarios->selectAll();
?>
<script src="app/correo/vistas/js/wysiwyg.js"></script>
<script src="app/correo/vistas/js/dropzone.js"></script>
<script>
	$(function(){
		$(".uno").chosen({
			no_results_text: "No hay resultados",
			max_selected_options: 1
		});
		$(".dos").chosen({
			no_results_text: "No hay resultados"
		});
		
		$('.redactar-mensaje').validate({
			errorElement: 'div',
			errorClass: 'help-block',
			focusInvalid: false,
			rules: {
				para: {
					required: true
				},
				asunto: {
					required: true
				}
			},

			messages: {
				para: {
					required: 'Debe indicar el destinatario'
				},
				asunto: {
					required: 'Debe indicar el asunto'
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit   
				$('.alert-danger', $('.redactar-mensaje')).show();
			},

			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},

			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
				$(e).remove();
			},
			submitHandler: function (form) {
				var msj = $('.wysiwyg-editor').html();
				//var mensaje = $('#mensaje').val(msj)
				//alert(msj);
				$.post('app/correo/procesos/p.mensaje.enviar.php',$('.redactar-mensaje').serialize()+'&mensaje='+msj,function(data){
					if(data==1) {
						load('app/correo/vistas/admin.panel.php','enviado=1','#admin-panel');
					} else {
						alerta('.msj','danger',data);
					}
				})
			},
			invalidHandler: function (form) {
			}
		});		
	})
</script>

<div class="col-xs-12">
	<div class="msj"></div>
	<!--<form action="" class="form-horizontal redactar-mensaje">-->
	<form action="app/correo/procesos/p.correo.php" method="POST" class="form-horizontal redactar-mensaje" enctype="multipart/form-data">
		<div class="col-sm-7">
			<div class="form-group">
				<label for="" class="col-sm-12 bolder">Para:</label>
				<div class="col-sm-12">
					<select class="width-auto chosen-select uno form-control" data-placeholder="Seleccione Destinatario" name="para">	
						<option value=""></option>
						<?php foreach($usua_rows as $ur) { ?>
							<option value="<?php echo $ur->peide ?>"><?php echo $ur->penombre.' - '.$ur->cadescri.' '.$ur->dedescri ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-12 bolder">Con Copia a:</label>
				<div class="col-sm-12">
					<select id="form-field-select-4" class="width-auto chosen-select dos form-control" data-placeholder="Seleccione" multiple=""  name="cc[]">
						<option value=""></option>
						<?php foreach($usua_rows as $ur) { ?>
							<option value="<?php echo $ur->peide ?>"><?php echo $ur->penombre.' - '.$ur->cadescri.' '.$ur->dedescri ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-12 bolder">Asunto:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="asunto">
				</div>
			</div>
		</div>

		<div class="col-sm-5">
			<label for="" class="col-sm-12"><span class="bolder"><i class="fa fa-paperclip"></i> Adjuntar Archivos</span> (Arrastre o click para adjuntar)</label>
			<div class="col-sm-12 dropzone-col">
				<div class="dropzone">
					<div class="fallback" style="width:50px">
						<input name="file" type="file" multiple="" />
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>

		<div class="form-group">
			<label for="" class="col-sm-12 bolder">Mensaje:</label>
			<div class="col-sm-12">
				<div class="wysiwyg-editor editor"></div>
				<!--<input type="hidden" name="mensaje" id="mensaje"/>-->
			</div>
		</div>

		<div class="clearfix form-actions">
			<div class="col-sm-10"></div>
			<!--<div class="col-sm-3">
				<button class="btn btn-default btn-lg"><i class="fa fa-search"></i> Vista Previa</button>
			</div>-->
			<div class="col-sm-2">
				<button class="btn btn-primary btn-lg"><i class="fa fa-check-square"></i> Enviar</button>
			</div>
		</div>
		<div id="fotos">
			
		</div>
	</form>
</div>