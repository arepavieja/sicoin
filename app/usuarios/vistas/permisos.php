<?php 
require '../../../cfg/base.php';
$ide = $_POST['ide'];
?>
<script>
	load('app/usuarios/vistas/permisos.lista.php','ide=<?php echo $ide ?>','#permisos-lista')
</script>
<?php echo $fun->modalHeader('Permisos de: '.$_POST['des']) ?>
<div class="modal-body" id="permisos-lista">
	
</div>
<?php echo $fun->modalFooter2(); ?>