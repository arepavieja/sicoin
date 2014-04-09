<?php 
require '../../../cfg/base.php';
$res = $musuarios->iniciarSesion();
if(count($res)>0) {
	$_SESSION = array(
			'casicoin_usr'=>$res[0]->peide,
			'casicoin_nom'=>$res[0]->penombre
		);
	echo 1;
} else {
	echo '¡Error!. Datos no válidos';
}
?>