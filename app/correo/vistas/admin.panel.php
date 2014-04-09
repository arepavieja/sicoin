<?php 
require '../../../cfg/base.php';
$etiquetas = $mcorreo->etiquetas();
?>
<script>
	load('app/correo/vistas/recibidos.php','','#opcion-etiqueta')
	$(function(){
		$('.redactar-nuevo-mensaje').click(function(e){
			e.preventDefault();
			$('#redactar-tag').click()
		})
		<?php if(isset($_POST['enviado']) and $_POST['enviado']==1) { ?>
			alerta('.enviado','success','Su mensaje ha sido enviado correctamente');
			setTimeout("$('.enviado').fadeOut('1')",2000);
		<?php } ?>
	})
</script>
<div class="col-xs-12">
	<div class="tabbable">
		<ul id="" class="nav nav-tabs">
			<li class="active">
				<a href="#home" data-toggle="tab" id="recibidos-tag" onclick="load('app/correo/vistas/admin.panel.php','enviado=0','#admin-panel');return false;">
					<i class="green fa fa-cloud-download bigger-100"></i>
					Recibidos
					<span class="badge badge-danger"><?php echo $mcorreo->selectRecibidosTotal() ?></span>
				</a>
			</li>
			<li>
				<a href="#profile" data-toggle="tab" onclick="load('app/correo/vistas/enviados.php','','#opcion-etiqueta'); return false;">
					<i class="blue fa fa-cloud-upload bigger-100"></i>
					Enviados
				</a>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" href="#" data-toggle="dropdown">
					<i class="purple fa fa-tag bigger-100"></i>
					Etiquetas  
					<i class="icon-caret-down bigger-110 width-auto"></i>
				</a>
				<ul class="dropdown-menu dropdown-info">
					<?php foreach($etiquetas as $e) { ?>
					<li>
						<a href="" data-toggle="tab" onclick="load('app/correo/vistas/etiquetas.lista.php','etide=<?php echo $e->etide ?>','#opcion-etiqueta'); return false;"><span class="badge badge-<?php echo $e->etclase ?> mail-tag"></span> <?php echo $e->etdescri ?></a>
					</li>
					<?php } ?>
				</ul>
			</li>
			<li>
				<a href="#" data-toggle="tab" id="redactar-tag" onclick="load('app/correo/vistas/mensaje.redactar.php','','#opcion-etiqueta');return false;">
					<i class="red fa fa-envelope bigger-100"></i>
					Redactar
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="enviado"></div>
			<div id="opcion-etiqueta"></div>
			<div class="clearfix"></div>
		</div>
	</div>

