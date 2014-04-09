<?php 
require '../../../cfg/base.php';
$res = $cdptos->validarInsert();
if($res==1) {
	echo $mdptos->insert();
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>