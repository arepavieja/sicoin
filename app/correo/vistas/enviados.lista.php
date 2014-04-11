<?php 
require '../../../cfg/base.php';
$recib_row = $mcorreo->selectEnviados();
?>

<script>
	$(function(){
		$('#id-toggle-all').on('click', function() {
			var estado = this.checked;
			if(estado==true) {
				count=0;
				$('table input[type=checkbox]').each(function(){
					this.checked = true;
					count++;
				});
			} else {
				count=0;
				$('table input[type=checkbox]').each(function(){
					this.checked = false;
					count++;
				});
			}
		})
		$('#id-select-message-all').on('click', function(e) {
			e.preventDefault();
			count=0;
			$('table input[type=checkbox]').each(function(){
				this.checked = true;
				count++;
			});
		});
		$('#id-select-message-none').on('click', function(e) {
			e.preventDefault();
			count=0;
			$('table input[type=checkbox]').each(function(){
				this.checked = false;
				count++;
			});
		});
		$('#id-select-message-read').on('click', function(e) {
			e.preventDefault();
			count=0;
			$('table tr:not(.bolder) input[type=checkbox]').each(function(){
				this.checked = true;
				count++;
			});
			$('table .bolder input[type=checkbox]').each(function(){
				this.checked = false;
				count++;
			});
		});
		$('#id-select-message-unread').on('click', function(e) {
			e.preventDefault();
			count=0;
			$('table .bolder input[type=checkbox]').each(function(){
				this.checked = true;
				count++;
			});
			$('table tr:not(.bolder) input[type=checkbox]').each(function(){
				this.checked = false;
				count++;
			});
		});
	})
</script>
<div class="space-20"></div>
<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<th style="width:50px">
<!--					
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
									<a id="id-select-message-unread" href="#">No Aprobados</a>
								</li>
								<li>
									<a id="id-select-message-read" href="#">Aprobados</a>
								</li>
							</ul>
						</div>
-->
				</th>
				<th>Asunto</th>
				<th class="hidden-480">Fecha</th>
				<th class="hidden-480">Hora</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
			<?php if(count($recib_row)>0) { ?>
				<?php foreach($recib_row as $rr) { ?>
					<tr class="<?php echo $ccorreo->leidos($rr->meestado); ?>">
						<td>
<!--							
							<label for="">
								<input type="checkbox" class="ace">
								<span class="lbl"></span>
							</label>
-->						
						</td>
						<td>
							<?php echo $ccorreo->siHayAdjuntos($rr->meide) ?> 
							<a href="#" onclick="load('app/correo/vistas/mensaje.leer.enviados.php','enide=<?php echo $rr->enide ?>&activarLeido=0','#opcion-etiqueta')">
								<?php echo $rr->metitulo ?>
							</a>
						</td>
						<td class="hidden-480">
							<?php echo $rr->mefecha ?>
						</td>
						<td class="hidden-480">
							<?php echo substr($rr->mehora, 0,5) ?>
						</td>
						<td>
							<?php echo $caprobar->estado($rr->meestado); ?>
						</td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<tr>
					<td colspan="4">No hay mensajes enviados</td>
				</tr>
			<?php } ?>
		</tbody>
</table>

<!--
		<tbody>
			<tr class="bolder">
				<td>
					<label for="">
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>
				<td>Publio Quintero</td>
				<td>Jornada de cedulación</td>
				<td class="hidden-480">10-02-2013</td>
				<td class="hidden-480">14:23</td>
			</tr>
			<tr>
				<td>
					<label for="">
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>
				<td>Publio Quintero</td>
				<td>Jornada de cedulación</td>
				<td class="hidden-480">10-02-2013</td>
				<td class="hidden-480">14:23</td>
			</tr>
			<tr>
				<td>
					<label for="">
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>
				<td>Publio Quintero</td>
				<td>Jornada de cedulación</td>
				<td class="hidden-480">10-02-2013</td>
				<td class="hidden-480">14:23</td>
			</tr>
			<tr>
				<td>
					<label for="">
						<input type="checkbox" class="ace">
						<span class="lbl"></span>
					</label>
				</td>
				<td>Publio Quintero</td>
				<td>Jornada de cedulación</td>
				<td class="hidden-480">10-02-2013</td>
				<td class="hidden-480">14:23</td>
			</tr>
		</tbody>
-->
	</table>
</div>