<?php 
require '../../../cfg/base.php';
$recib_row = $mcorreo->selectEtiquetas($_POST['etide']);
$etiquetas = $mcorreo->etiquetas();
$etide = $_POST['etide'];
?>
<script src="app/correo/vistas/js/control.checkbox.js"></script>

<script>
	function procesarMensajes(ide) {
		datos = $('.mensajes').serialize()+'&'+ide;
		$.post('app/correo/procesos/p.update.etiqueta.php',datos,function(data){
			load('app/correo/vistas/etiquetas.lista.php','etide=<?php echo $etide ?>','#opcion-etiqueta')
		})
	}
	function marcarLectura(ide) {
		datos = $('.mensajes').serialize()+'&'+ide;
		$.post('app/correo/procesos/p.update.lectura.php',datos,function(data){
			load('app/correo/vistas/etiquetas.lista.php','etide=<?php echo $etide ?>','#opcion-etiqueta')
		})
	}
	function eliminar() {
		datos = $('.mensajes').serialize();
		$.post('app/correo/procesos/p.delete.mensaje.php',datos,function(data){
			load('app/correo/vistas/etiquetas.lista.php','etide=<?php echo $etide ?>','#opcion-etiqueta')
		})
	}
</script>

<div class="row">
	<ul class="nav nav-pills pull-right herramientas-mensaje">
    <li class="disabled">
      <a href="#" class="dropdown-toggle text-success" data-toggle="dropdown">
      	<i class="fa fa-star"></i> Etiquetar Como 
      	<span class="icon-caret-down icon-only"></span> 
      </a>
      <ul class="dropdown-menu" style="display:none;">
				<?php foreach($etiquetas as $e) { ?>
					<li>
						<a href="" data-toggle="tab" onclicK="procesarMensajes('etide=<?php echo $e->etide ?>')">
							<span class="badge badge-<?php echo $e->etclase ?> mail-tag"></span> <?php echo $e->etdescri ?>
						</a>
					</li>
				<?php } ?>
				<li>
					<a href="" data-toggle="tab" onclicK="procesarMensajes('etide=0')">
						<span class="badge badge-gray mail-tag"></span> Sin Etiqueta
					</a>
				</li>
      </ul>
    </li>
    <li class="disabled">
      <a href="#" class="dropdown-toggle text-success" data-toggle="dropdown">
      	<i class="fa fa-thumb-tack"></i> Marcar Como 
      	<span class="icon-caret-down icon-only"></span> 
      </a>
      <ul class="dropdown-menu" style="display:none;">
					<li>
						<a href="" data-toggle="tab" onclick="marcarLectura('lectura=1')"><i class="fa fa-eye"></i> Leído</a>
					</li>
					<li>
						<a href="" data-toggle="tab" onclick="marcarLectura('lectura=0')"><i class="fa fa-eye-slash"></i> No Leído</a>
					</li>
      </ul>
    </li>
    <li class="disabled">
      <a href="" class="text-success" onclick="eliminar()"><i class="fa fa-times"></i> Eliminar</a>
    </li>
    <li class="">
      <a href="#" class="text-success" onclick="load('app/correo/vistas/etiquetas.lista.php','etide=<?php echo $etide ?>','#opcion-etiqueta');"><i class="fa fa-refresh"></i> Refrescar</a>
    </li>
	</ul>
</div>

<div class="space-10"></div>
<form action="" class="mensajes">
	<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr>
					<th style="width:50px">
							<div class="btn-group">
								<input id="id-toggle-all" class="ace" type="checkbox">
								<span class="lbl"></span>
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<i class="icon-caret-down bigger-125 middle"></i>
								</a>
								<ul class="dropdown-menu dropdown-lighter dropdown-100">
									<li>
										<a id="id-select-message-all" href="#">Todos</a>
									</li>
									<li>
										<a id="id-select-message-none" href="#">Ninguno</a>
									</li>
									<li class="divider"></li>
									<li>
										<a id="id-select-message-unread" href="#">No leídos</a>
									</li>
									<li>
										<a id="id-select-message-read" href="#">Leídos</a>
									</li>
								</ul>
							</div>
					</th>
					<th>Remitente</th>
					<th>Asunto</th>
					<th class="hidden-480">Fecha</th>
					<th class="hidden-480">Hora</th>
				</tr>
			</thead>
			<tbody>
				<?php if(count($recib_row)>0) { ?>
					<?php foreach($recib_row as $rr) { ?>
						<tr class="<?php echo $ccorreo->leidos($rr->enlectur); ?>">
							<td>
								<label for="">
									<input type="checkbox" class="ace itemmensaje" name="itemmensaje[]" value="<?php echo $rr->enide ?>">
									<span class="lbl"></span>
								</label>
							</td>
							<td><span class="badge badge-<?php echo $rr->etclase ?> mail-tag"></span> <?php echo $rr->peapelli.', '.$rr->penombre ?></td>
							<td><?php echo $ccorreo->siHayAdjuntos($rr->meide) ?> <a href="#" onclick="load('app/correo/vistas/mensaje.leer.php','enide=<?php echo $rr->enide ?>&activarLeido=1','#opcion-etiqueta')"><?php echo $rr->metitulo ?></a></td>
							<td class="hidden-480"><?php echo $rr->mefecha ?></td>
							<td class="hidden-480"><?php echo substr($rr->mehora, 0,5) ?></td>
						</tr>
					<?php } ?>
				<?php } else { ?>
					<tr>
						<td colspan="4">No hay nuevos mensajes</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</form>