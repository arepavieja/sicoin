<?php 
require '../../../cfg/base.php';
$res = $cusuarios->validarInsert();
if($res==1) {
	echo $musuarios->usuarioInsert();
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>