<?php 
/**
 * Se incluyen los archivos y librerías principales del sistema
 */
if(file_exists('cfg/')) {
	require 'cfg/config.php';
	require 'cfg/conexion.php';
	require 'cfg/funciones.php';
	require 'lib/PHPMailer/class.phpmailer.php';
	#require 'lib/dompdf/dompdf_config.inc.php';
} else {
	if(file_exists('../../../cfg/')) {
		require '../../../cfg/config.php';
		require '../../../cfg/conexion.php';
		require '../../../cfg/funciones.php';
		require '../../../lib/PHPMailer/class.phpmailer.php';
		#require '../../../lib/dompdf/dompdf_config.inc.php';
	}
}
$folder = array(
		'usuarios',
		'correo',
		'cargos',
		'dptos'
	);
$files  = array(
		array('mUsuarios','cUsuarios'),
		array('mCorreo','cCorreo'),
		array('mCargos','cCargos'),
		array('mDptos','cDptos')
	);
/**
 * El sistema busca las rutas dentro de app para crear los directorios
 */
foreach($folder as $ind=>$fol) {
	foreach($files[$ind] as $file) {
		if(file_exists('app/'.$fol.'/clases/')) {
			require 'app/'.$fol.'/clases/'.$file.'.php';
		} else {
			if(file_exists('../../'.$fol.'/clases/')) {
				require '../../'.$fol.'/clases/'.$file.'.php';
			} else {
				if(file_exists('../clases/'.$file[0].'.php')) {
					require '../clases/'.$file.'.php';
				}
			}
		}
	}
}
/**
 * Se instancias las clases las cuales deben ser iguales al nombre del archivo del de cada módulo y al nombre de la clase.
 */
#$con = new Conexion();
$fun = new Funciones();
foreach($folder as $ind=>$fol) {
	foreach($files[$ind] as $file) {
		$clase = strtolower($file);
		$$clase = new $file();
	}
}

?>