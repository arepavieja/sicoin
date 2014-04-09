<?php 
require '../../../cfg/base.php';
$res = $ccargos->validarInsert();
if($res==1) {
	echo $mcargos->insert();
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>