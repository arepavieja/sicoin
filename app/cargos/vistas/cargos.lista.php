<?php 
require '../../../cfg/base.php';
$cargos_rows = $mcargos->selectAll();
?>
<table class="table table-hover table-bordered table-striped">
	<thead>
		<tr>
			<th>Código</th>
			<th>Descripción</th>
			<th>Abreviatura</th>
			<th>Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($cargos_rows as $row) { ?>
			<tr>
				<td><?php echo $row->caide ?></td>
				<td><?php echo $row->cadescri ?></td>
				<td><?php echo $row->caabrevi ?></td>
				<td>
					<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
						<button class="btn btn-xs btn-purple" type="button" onclick="modalForm('app/cargos/vistas/cargo.update.php','ide=<?php echo $row->caide ?>')">
							<i class="icon-edit bigger-140"></i>
						</button>
						<button class="btn btn-xs btn-danger" type="button" onclick="modalForm('app/cargos/vistas/cargo.delete.php','ide=<?php echo $row->caide ?>')">
							<i class="icon-trash bigger-140"></i>
						</button>
					</div>							
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>