<?php 
class cAprobar extends mAprobar {
	
	function estado($var) {
		$rt = ($var==0) ? 'En espera' : 'Aprobado';
		return $rt;
	}

	function editarLeer($var,$titulo,$meide) {
		if ($var==0) :
			$vinc = 
			$rt = '<a href="#" onclick="load(\'app/aprobar/vistas/mensaje.editar.php\',\'meide='.$meide.'&activarLeido=0\',\'#admin-panel\')">'.$titulo.'</a>';
		else :
			$rt = $titulo;
		endif;
		return $rt;
	}

}
?>