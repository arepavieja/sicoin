<?php 
require '../../../cfg/base.php';
$res = $ccargos->validarUpdate();
if($res==1) {
	echo $mcargos->update();
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>