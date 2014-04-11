<?php 
require '../../../cfg/base.php';
$ancho = $_FILES['file']['size'];
$nombre = strtoupper(str_replace(" ", "", $_FILES['file']['name']));
$nombre_final = date('d').date('n').date('Y').$ancho.'_'.$nombre;
$tmp_name = $_FILES['file']['tmp_name'];
echo $mcorreo->archivoInsert($nombre_final,$tmp_name);
?>