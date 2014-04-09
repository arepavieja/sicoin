$(function(){

	$('#id-toggle-all').on('click', function() {
		var estado = this.checked;
		if(estado==true) {
			count=0;
			$('table input[type=checkbox]').each(function(){
				this.checked = true;
				count++;
			});
			$('.herramientas-mensaje li').removeClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','');
		} else {
			count=0;
			$('table input[type=checkbox]').each(function(){
				this.checked = false;
				count++;
			});
			$('.herramientas-mensaje li').addClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','display:none');
		}
	})

	$('#id-select-message-all').on('click', function(e) {
		e.preventDefault();
		count=0;
		$('table input[type=checkbox]').each(function(){
			this.checked = true;
			count++;
		});
		$('.herramientas-mensaje li').removeClass('disabled')
		$('.herramientas-mensaje .dropdown-menu').attr('style','');
	});

	$('#id-select-message-none').on('click', function(e) {
		e.preventDefault();
		count=0;
		$('table input[type=checkbox]').each(function(){
			this.checked = false;
			count++;
		});
		$('.herramientas-mensaje li').addClass('disabled')
		$('.herramientas-mensaje .dropdown-menu').attr('style','display:none');
	});

	$('#id-select-message-read').on('click', function(e) {
		e.preventDefault();
		count=0;
		total=0;
		$('table tr:not(.bolder) input[type=checkbox]').each(function(){
			this.checked = true;
			count++;
			total = total+1;
		});
		$('table .bolder input[type=checkbox]').each(function(){
			this.checked = false;
			count++;
		});
		if(total>0) {
			$('.herramientas-mensaje li').removeClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','');
		} else {
			$('.herramientas-mensaje li').addClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','display:none');
		}
	});

	$('#id-select-message-unread').on('click', function(e) {
		e.preventDefault();
		count=0;
		total=0;
		$('table .bolder input[type=checkbox]').each(function(){
			this.checked = true;
			count++;
			total = total+1;
		});
		$('table tr:not(.bolder) input[type=checkbox]').each(function(){
			this.checked = false;
			count++;
		});
		if(total>0) {
			$('.herramientas-mensaje li').removeClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','');
		} else {
			$('.herramientas-mensaje li').addClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','display:none');
		}
	});

	$('.itemmensaje').on('click',function(){
		count=0;
		total=0;
		$('table .itemmensaje').each(function(){
			count++;
			if(this.checked==true) {
				total = total+1;
			}
		});
		if(total>0) {
			$('.herramientas-mensaje li').removeClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','');
		} else {
			$('.herramientas-mensaje li').addClass('disabled')
			$('.herramientas-mensaje .dropdown-menu').attr('style','display:none');
		}
	})
	
})