<script>
	$(function(){
		load('app/dptos/vistas/dptos.lista.php','','#dptos')
		$('.dpto-insert').validate({
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
				$('.alert-danger', $('.dpto-insert')).show();
			},

			highlight: function (e) {
				$(e).closest('.form-group').removeClass('has-info').addClass('has-error');
			},

			success: function (e) {
				$(e).closest('.form-group').removeClass('has-error').addClass('has-info');
				$(e).remove();
			},
			submitHandler: function (form) {
				$.post('app/dptos/procesos/p.dpto.insert.php',$('.dpto-insert').serialize(),function(data){
					if(data==1) {
						alerta('.msj','success','Registro guardado correctamente');
						load('app/dptos/vistas/dptos.lista.php','','#dptos')
						setTimeout("$('.msj').fadeOut(1)",2000)
					} else {
						alerta('.msj','danger',data)
					}
				})
			},
			invalidHandler: function (form) {
			}
		});
	})
</script>

<div id="breadcrumbs" class="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-wrench"></i>
			<a href="#">Opciones</a>
		</li>
		<li class="active"><i class="fa fa-desktop"></i> Departamentos</li>
	</ul><!-- .breadcrumb -->		
</div>
<div class="space-6"></div>

<div class="col-xs-4">
	<div class="msj"></div>
	<form action="" class="form-horizontal well dpto-insert">
		<div class="form-group">
			<label for="" class="lbl col-sm-12 bolder">Descripción</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="descripcion">
			</div>
		</div>
		<div class="form-group">
			<label for="" class="lbl col-sm-12 bolder">Abreviatura</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" name="abreviatura">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<button class="btn btn-primary pull-right">Agregar</button>
			</div>
		</div>
	</form>
</div>
<div class="col-xs-8" id="dptos">
	
</div>