<?php 
require '../../../cfg/base.php';
$res = 1;
if($res==1) :
	if($_POST['forma']==1) :
		echo $maprobar->guardar();
	else :
		echo $maprobar->guardarAprobar();
	endif;
else :
	foreach ($res as $r) :
		echo ($r!=1) ? $r.'<br>' : null;
	endforeach;
endif;
?>