jQuery(function($){
	var fecha = new Date();
	dia = fecha.getDate();
	mes = fecha.getMonth()+1;
	ano = fecha.getFullYear();
	fechanom = dia+''+mes+''+ano;
	//alert(fechanom);
	  $(".dropzone").dropzone({
	  	url: 'app/correo/procesos/p.cargar.adjunto.php',
	  	success:  function (response) {
              		//console.log(response);
              		//alert(response.toSource())              		
              		var nombre = response.name;
              		var nom = nombre.replace(/\s/g,'');
              		$("#fotos").append('<input type="hidden" class="cla'+response.size+'" name="imagen[]" value="'+fechanom+response.size+'_'+nom+'">');
      					},
	    paramName: "file", // The name that will be used to transfer the file
	    maxFilesize: 10, // MB  
			addRemoveLinks : true,
			dictDefaultMessage : '',
			dictResponseError: '',
			thumbnailWidth: 300,
			thumbnailHeight: 300,	
			removedfile: function(response) {
												var atributo = '.cla'+response.size;
												$(atributo).remove();
												$('.dz-preview .dz-details .dz-filename span:contains('+response.name+')').parent().parent().parent().remove();
											},
			//change the previewTemplate to use Bootstrap progress bars
			previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>",
	  });
});
