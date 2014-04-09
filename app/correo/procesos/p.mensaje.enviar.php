<?php 
require '../../../cfg/base.php';
#print_r($_POST);
$res = 1;
if($res==1) {
	$remitente = $musuarios->selectIde($_SESSION['casicoin_usr']);
	$from = $remitente[0]->pecorreo;
	$fromName = $remitente[0]->penombre.' '.$remitente[0]->peapelli;
	echo $mcorreo->correoEnviar($from,$fromName);
} else {
	foreach($res as $r) {
		echo ($r!=1) ? $r.'<br>' : null;
	}
}
?>