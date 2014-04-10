function load(url,datos,capa) {
	$.post(url,datos,function(data){
		$(capa).html(data);
	})
}

function alerta(capa,tipo,data) {
	$(capa).fadeIn().html('<div class="alert alert-'+tipo+'"><button class="close" data-dismiss="alert" type="button"><i class="icon-remove"></i></button><strong>'+data+'</strong></div>');
}

function modalForm(url,datos) {
	$.post(url,datos,function(data){
		$('.modal').modal('show');
		$('.modal .modal-dialog .modal-content').html(data);
	})
}
function cerrarmodal() {
	$('.modal').modal('hide');
}