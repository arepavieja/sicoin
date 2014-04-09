<?php 
require '../../../cfg/base.php';
$usua_rows = $musuarios->selectAll();
?>
<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>Cédula</th>
			<th>Apellidos y Nombres</th>
			<th>Teléfono</th>
			<th>Usuario</th>
			<th>Cargo</th>
			<th>Departamento</th>
			<th>Estado</th>
			<th>Opciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($usua_rows as $row) { ?>
			<?php $estado = $cusuarios->estado($row->acestado); ?>
			<tr>
				<td><?php echo $row->penacion.$row->pecedula ?></td>
				<td><?php echo $row->peapelli.', '.$row->penombre ?></td>
				<td><?php echo $row->petelefo ?></td>
				<td><?php echo $row->acnomusu ?></td>
				<td><?php echo $row->cadescri ?></td>
				<td><?php echo $row->dedescri ?></td>
				<td><?php echo $estado['text'] ?></td>
				<td>
					<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
						<button class="btn btn-xs btn-purple" type="button" onclick="modalForm('app/usuarios/vistas/usuario.update.php','ide=<?php echo $row->peide ?>')">
							<i class="icon-edit bigger-140"></i>
						</button>
						<button class="btn btn-xs btn-danger" type="button" onclick="modalForm('app/usuarios/vistas/usuario.delete.php','ide=<?php echo $row->peide ?>')">
							<i class="icon-trash bigger-140"></i>
						</button>
						<button class="btn btn-xs btn-success" type="button" onclick="modalForm('app/usuarios/vistas/permisos.php','ide=<?php echo $row->peide ?>&des=<?php echo $row->peapelli.', '.$row->penombre ?>')">
							<i class="fa fa-lock bigger-150"></i>
						</button>
						<button class="btn btn-xs btn-warning" type="button" onclick="modalForm('app/usuarios/vistas/estado.update.php','ide=<?php echo $row->peide ?>&estado=<?php echo $estado['val'] ?>')">
							<i class="fa <?php echo $estado['ico'] ?> bigger-150"></i>
						</button>
					</div>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>