<?php 
if(isset($_GET['var'])) {
	$url = $musuarios->getContenido($_GET['var']);
	if(count($url)>0) {
		if(file_exists('app/'.$url[0]->suruta.'.php')) {
			require 'app/'.$url[0]->suruta.'.php';
		} else {
			echo 'El directorio solicitado no existe';
		}
	} else {
		echo '¡Disculpe!. No tiene permisos de acceso.';
	}
} else {
	require 'app/correo/vistas/admin.php';
}
?>