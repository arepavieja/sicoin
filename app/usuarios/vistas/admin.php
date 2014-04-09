<script>
	load('app/usuarios/vistas/usuarios.lista.php','','#usuarios-lista');
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
		<li class="active"><i class="fa fa-users"></i> Administración de Usuarios</li>
	</ul><!-- .breadcrumb -->		
</div>
<div class="space-10"></div>

<div class="col-xs-12">
	<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
		<button class="btn btn-xs btn-inverse btn-lg radius bolder" type="button" onclick="modalForm('app/usuarios/vistas/usuario.insert.php','')">
			<i class="fa fa-plus"></i> Nuevo Usuario
		</button>
	</div>
</div>
<div class="clearfix"></div>
<div class="space-10"></div>
<div class="col-xs-12" id="usuarios-lista">
	
</div>