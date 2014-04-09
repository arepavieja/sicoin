<?php 
require '../../../cfg/base.php';
$perm_rows = $musuarios->permisosSelectAll();
$ide = $_POST['ide'];
?>
<script>
	function cambiarPermiso(datos) {
		$.post('app/usuarios/procesos/p.permiso.update.php',datos,function(data) {
			if(data==1) {
				load('app/usuarios/vistas/permisos.lista.php','ide=<?php echo $ide ?>','#permisos-lista')
			} else {
				alerta('.msj3','danger',data);
			}
		})
	}
</script>
<div class="msj3"></div>
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Módulo</th>
			<th>Submódulos</th>
			<th>Estado</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($perm_rows as $pr) { ?>
			<?php 
				$permisoUsuario = $musuarios->selectPermisoUsuario($ide,$pr->suide);
				$estadoPermiso = (count($permisoUsuario)>0) ? $cusuarios->estadoPermiso($permisoUsuario[0]->auestado) : $cusuarios->estadoPermiso(0);
			?>
			<tr>
				<td><?php echo $pr->modescri ?></td>
				<td><?php echo $pr->sudescri ?></td>
				<td><?php echo $estadoPermiso['text'] ?></td>
				<td>
					<button class="btn btn-xs <?php echo $estadoPermiso['class'] ?>" type="button" onclick="cambiarPermiso('ide=<?php echo $ide ?>&suide=<?php echo $pr->suide ?>&val=<?php echo $estadoPermiso['value'] ?>')">
						<?php echo $estadoPermiso['buttonText'] ?>
					</button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>