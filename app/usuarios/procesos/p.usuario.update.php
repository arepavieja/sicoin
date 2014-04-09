<?php 
require '../../../cfg/base.php';
$res = $cusuarios->validarUpdate();
if($res==1) {
	echo $musuarios->usuarioUpdate();
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>