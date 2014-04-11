<?php 
require '../../../cfg/base.php';
$usua_rows = $musuarios->selectAll();
$mensaje   = $maprobar->selectMensajeIdeEditar($_POST['meide']);
$para      = $maprobar->selectMensajeIdeEditarDestino(1,$_POST['meide']);
$cc        = $maprobar->selectMensajeIdeEditarDestino(2,$_POST['meide']);
$adjuntos  = $maprobar->selectMensajeAdjuntosIdeEditar($_POST['meide']);
?>

<script src="app/aprobar/vistas/js/wysiwyg.js"></script>
<script src="app/aprobar/vistas/js/dropzone.js"></script>
<script src="app/aprobar/vistas/js/guardar.js"></script>

<div class="col-xs-12">
	<div class="msj"></div>
	<!--<form action="" class="form-horizontal redactar-mensaje">-->
	<form action="" method="POST" class="form-horizontal editar-mensaje" enctype="multipart/form-data">
		<div class="col-sm-7">
			<div class="form-group">
				<label for="" class="col-sm-12 bolder">Para:</label>
				<div class="col-sm-12">
					<select class="width-auto chosen-select uno form-control" data-placeholder="Seleccione Destinatario" name="para">	
						<option value=""></option>
						<?php foreach($usua_rows as $ur) { ?>
							<option value="<?php echo $ur->peide ?>" <?php echo $fun->selected($ur->peide,$para[0]->peide) ?>>
								<?php echo $ur->penombre.' - '.$ur->cadescri.' '.$ur->dedescri ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-12 bolder">Con Copia a:</label>
				<div class="col-sm-12">
					<select id="form-field-select-4" class="width-auto chosen-select dos form-control" data-placeholder="Seleccione" multiple=""  name="cc[]">
						<option value=""></option>
						<?php foreach($usua_rows as $ur) { ?>
							<option value="<?php echo $ur->peide ?>" <?php foreach($cc as $c) { echo $fun->selected($ur->peide,$c->peide); } ?>><?php echo $ur->penombre.' - '.$ur->cadescri.' '.$ur->dedescri ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-12 bolder">Asunto:</label>
				<div class="col-sm-12">
					<input type="text" class="form-control" name="asunto" value="<?php echo $mensaje[0]->metitulo ?>">
				</div>
			</div>
		</div>

		<div class="col-sm-5">
			<label for="" class="col-sm-12"><span class="bolder"><i class="fa fa-paperclip"></i> Adjuntar Archivos</span> (Arrastre o click para adjuntar)</label>
			<div class="col-sm-12 dropzone-col">
				<div class="dropzone">
					<div class="fallback" style="width:50px">
						<input name="file" type="file" multiple="" />
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col-sm-12">
			<?php if(count($adjuntos)>0) { ?>
				<label class="bolder control-label">
					Adjuntos (<?php echo count($adjuntos) ?>)
				</label>
					<div class="clearfix"></div>
					<?php foreach($adjuntos as $ad) { ?>
						<div class="alert well well-sm pull-left">
							<button class="close" data-dismiss="alert" type="button" onclick="borrarAdjunto('adide=<?php echo $ad->adide ?>')">
								<i class="icon-remove"></i> 
							</button>
							<a target="_blank" href="img/adjuntos/<?php echo $ad->arruta ?>">
								<?php echo $ad->arruta ?>
							</a>&nbsp;&nbsp;&nbsp;
						</div><div style="padding-right: 2px;"></div>
					<?php } ?>
					<div class="clearfix"></div>
			<?php } ?>
		</div>
		<div class="form-group">
			<label for="" class="col-sm-12 bolder">Mensaje:</label>
			<div class="col-sm-12">
				<div class="wysiwyg-editor editor"><?php echo $mensaje[0]->memensaj ?></div>
			</div>
		</div>

		<div class="clearfix form-actions">
			<div class="col-sm-10"></div>
			<div class="col-sm-4 pull-right">
				<button class="btn btn-success btn-lg pull-right aprobar" type="button">
					<i class="fa fa-check-square"></i> Guardar Cambios y Aprobar
				</button>
			</div>
			<div class="col-sm-3 pull-right">
				<button class="btn btn-primary btn-lg pull-right guardar" type="button">
					<i class="fa fa-check-square-o"></i> Guardar Cambios
				</button>
			</div>
		</div>
		<div id="fotos"></div>
		<input type="hidden" class="formaDeEnvio">
		<input type="hidden" name="meide" value="<?php echo $mensaje[0]->meide ?>">
		<input type="hidden" name="parappal" value="<?php echo $para[0]->peide ?>">
	</form>
</div>