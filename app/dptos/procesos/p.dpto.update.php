<?php 
require '../../../cfg/base.php';
$res = $cdptos->validarUpdate();
if($res==1) {
	echo $mdptos->update();
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>