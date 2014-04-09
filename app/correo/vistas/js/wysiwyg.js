jQuery(function($) {
	$('.editor').ace_wysiwyg({
		toolbar:
		[
			{
				name:'font',
				title:'Fuente',
				values:['Some Special Font!','Arial','Verdana','Comic Sans MS','Custom Font!']
			},
			null,
			{
				name:'fontSize',
				title:'Tamaño Fuente',
				values:{1 : 'Ancho#1 Texto' , 2 : 'Ancho#2 Texto' , 3 : 'Ancho#3 Texto' , 4 : 'Ancho#4 Texto' , 5 : 'Ancho#5 Texto'} 
			},
			null,
			{name:'bold', title:'Negrita'},
			{name:'italic', title:'Cursiva'},
			{name:'strikethrough', title:'Tachado'},
			{name:'underline', title:'Subrayado'},
			null,
			{name:'insertunorderedlist', title:'Viñetas'},
			{name:'insertorderedlist', title:'Numeración'},
			{name:'outdent', title:'Reducir Sangría'},
			{name:'indent', title:'Aumentar Sangría'},
			null,
			{name:'justifyleft', title:'Izquierda'},
			{name:'justifycenter', title:'Centrado'},
			{name:'justifyright', title:'Derecha'},
			{name:'justifyfull', title:'Justificado'},
			null,
			{
				name:'createLink',
				title:'Hipervínculo',
				placeholder:'...',
				button_class:'btn-purple',
				button_text:'Ok'
			},
			{name:'unlink',title:'Quitar hipervínculo'},
			null,
			{
				name:'insertImage',
				title:'Imagen',
				placeholder:'...',
				button_class:'btn-inverse',
				//choose_file:false,//hide choose file button
				button_text:'Buscar',
				button_insert_class:'btn-pink',
				button_insert:'Ok'
			},
			null,
			{
				name:'foreColor',
				title:'Colores',
				values:['red','green','blue','navy','orange'],
				/**
					You change colors as well
				*/
			},
			/**null,
			{
				name:'backColor'
			},*/
			null,
			{name:'undo',title:'Deshacer'},
			{name:'redo',title:'Rehacer'},
			null,
			{name:'viewSource',title:'Código fuente'}
		],
		//speech_button:false,//hide speech button on chrome
		
		'wysiwyg': {
			hotKeys : {} //disable hotkeys
		}
		
	}).prev().addClass('wysiwyg-style2');

	
	
	//handle form onsubmit event to send the wysiwyg's content to server
	$('#myform').on('submit', function(){
		
		//put the editor's html content inside the hidden input to be sent to server
		//$('input[name=wysiwyg-value]' , this).val($('#editor').html());
		
		//but for now we will show it inside a modal box

		$('#modal-wysiwyg-editor').modal('show');
		$('#wysiwyg-editor-value').css({'width':'99%', 'height':'200px'}).val($('#editor').html());
		
		return false;
	});
	$('#myform').on('reset', function() {
		$('#editor').empty();
	});
	
	
});
