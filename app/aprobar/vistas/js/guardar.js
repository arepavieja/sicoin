$(function(){
	$(".uno").chosen({
		no_results_text: "No hay resultados",
		max_selected_options: 1
	});
	$(".dos").chosen({
		no_results_text: "No hay resultados"
	});

	$('.guardar').on('click',function(){
		$('.formaDeEnvio').val(1);
		$('.editar-mensaje').submit();
	})

	$('.aprobar').on('click',function(){
		$('.formaDeEnvio').val(2);
		$('.editar-mensaje').submit();
	})
	
	$('.editar-mensaje').validate({
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
			$('.alert-danger', $('.editar-mensaje')).show();
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
			var forma = $('.formaDeEnvio').val();
			var datos = $('.editar-mensaje').serialize()+'&mensaje='+msj+'&forma='+forma;
			modalForm('loading.aprobar.php','');
			$.post('app/aprobar/procesos/p.mensaje.editar.php',datos,function(data){
				if(data==1) {
					//cerrarmodal()
					location.reload()
				} else {
					//cerrarmodal()
					alerta('.msj','danger',data);
				}
			})
		},
		invalidHandler: function (form) {
		}
	});
})

function borrarAdjunto(ide) {
	$.post('app/aprobar/procesos/p.borrarAdjunto.php',ide)
}