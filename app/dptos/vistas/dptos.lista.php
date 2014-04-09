<?php 
require '../../../cfg/base.php';
$dptos_rows = $mdptos->selectAll();
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
		<?php foreach($dptos_rows as $row) { ?>
			<tr>
				<td><?php echo $row->deide ?></td>
				<td><?php echo $row->dedescri ?></td>
				<td><?php echo $row->deabrevi ?></td>
				<td>
					<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
						<button class="btn btn-xs btn-purple" type="button" onclick="modalForm('app/dptos/vistas/dpto.update.php','ide=<?php echo $row->deide ?>')">
							<i class="icon-edit bigger-140"></i>
						</button>
						<button class="btn btn-xs btn-danger" type="button" onclick="modalForm('app/dptos/vistas/dpto.delete.php','ide=<?php echo $row->deide ?>')">
							<i class="icon-trash bigger-140"></i>
						</button>
					</div>							
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>