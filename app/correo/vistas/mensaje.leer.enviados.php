<?php 
require '../../../cfg/base.php';
$men_row = $mcorreo->selectMensajeIde($_POST['enide']);
$etiquetas = $mcorreo->etiquetas();
$adjuntos = $mcorreo->selectMensajeAdjuntosIde($_POST['enide']);
$q = (isset($_POST['activarLeido']) and $_POST['activarLeido']==1) ? $mcorreo->marcarLeido() : null;
$enide = $_POST['enide'];
?>

<script>
	function procesarMensajes(ide) {
		datos = $('.actionMensaje').serialize()+'&'+ide;
		$.post('app/correo/procesos/p.update.etiqueta.php',datos,function(data){
			load('app/correo/vistas/mensaje.leer.php','enide=<?php echo $enide ?>&activarLeido=1','#opcion-etiqueta')
		})
	}
	function marcarLectura(ide) {
		datos = $('.actionMensaje').serialize()+'&'+ide;
		$.post('app/correo/procesos/p.update.lectura.php',datos,function(data){
			load('app/correo/vistas/admin.panel.php','enviado=0','#admin-panel');
		})
	}
	function eliminar() {
		datos = $('.actionMensaje').serialize();
		$.post('app/correo/procesos/p.delete.mensaje.php',datos,function(data){
			load('app/correo/vistas/admin.panel.php','enviado=0','#admin-panel');
		})
	}
</script>
<form action="" class="actionMensaje">
	<input type="hidden" name="itemmensaje[]" value="<?php echo $enide ?>">
</form>
<div class="row">
	<ul class="nav nav-pills pull-right herramientas-mensaje">
    <!--<li class="">
      <a href="" class="text-success" onclick="eliminar()"><i class="fa fa-times"></i> Eliminar</a>
    </li>-->
    <!--
    <li class="">
      <a href="" class="text-success" onclick=""><i class="fa fa-share"></i> Reenviar</a>
    </li>
    <li class="">
      <a href="" class="text-success" onclick=""><i class="fa fa-reply-all"></i> Responder</a>
    </li>
  -->
    <li class="">
      <a href="" class="text-success" onclick="load('app/correo/vistas/mensaje.leer.enviados.php','enide=<?php echo $enide ?>&activarLeido=1','#opcion-etiqueta'); return false;"><i class="fa fa-refresh"></i> Refrescar</a>
    </li>
    <li class="">
      <a href="" class="text-success" onclick="window.open('memo-<?php echo $enide; ?>'); return false;"><i class="fa fa-print"></i> Imprimir</a>
    </li>
	</ul>
</div>

<div class="space-10"></div>

<table class="table">
	<tbody>
		<tr>
			<th style="width:150px">Marcado como:</th>
			<td>
				<span class="badge badge-<?php echo $men_row[0]->etclase ?> mail-tag"> <?php echo $men_row[0]->etdescri; ?></span>
			</td>
		</tr>
		<tr>
			<th>Número:</th>
			<td><?php echo $men_row[0]->deabrevi ?>-<?php echo sprintf("%05d",$men_row[0]->enide) ?></td>
		</tr>
		<tr>
			<th>Fecha y Hora:</th>
			<td><?php echo $fun->fecha($men_row[0]->mefecha).' -- '.substr($men_row[0]->mehora, 0,5); ?></td>
		</tr>
		<tr>
			<th>Remitente:</th>
			<td>
				<?php echo $men_row[0]->rapellido.', '.$men_row[0]->rnombre ?> / <?php echo $men_row[0]->rcadescri ?> <?php echo $men_row[0]->rdedescri ?>
			</td>
		</tr>
		<tr>
			<th>Para:</th>
			<td>
				<?php echo $men_row[0]->dapellido.', '.$men_row[0]->dnombre ?> / <?php echo $men_row[0]->dcadescri ?> <?php echo $men_row[0]->ddedescri ?>
			</td>
		</tr>
		<tr>
			<th>Asunto:</th>
			<td><?php echo $men_row[0]->metitulo ?></td>
		</tr>
		<tr><th colspan="2">Mensaje:</th></tr>
		<tr><td colspan="2"><?php echo $men_row[0]->memensaj ?></td></tr>
		<?php if(count($adjuntos)>0) { ?>
			<tr><th colspan="2">Adjuntos (<?php echo count($adjuntos) ?>)</th></tr>
			<tr>
				<td colspan="2">
					<?php foreach($adjuntos as $ad) { ?>
						<a target="_blank" href="img/adjuntos/<?php echo $ad->arruta ?>"><?php echo $ad->arruta ?></a> - 
					<?php } ?>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>