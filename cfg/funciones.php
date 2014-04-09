<?php 

class Funciones {

	function checked($var_1,$var_2) {
		$rt = (!strcmp($var_1,$var_2)) ? 'checked="checked"' : null;
		return $rt;
	} #checked

	function selected($var_1,$var_2) {
		$rt = (!strcmp($var_1,$var_2)) ? 'selected="selected"' : null;
		return $rt;
	} #selected

	function modalHeader($tit) {
		$modal = '<div class="modal-header">';
		$modal.= '<button class="close" data-dismiss="modal" type="button">x</button>';
		$modal.= '<h4 class="blue bigger">'.$tit.'</h4>';
		$modal.= '</div>';
		return $modal;
	}

	function modalFooter() {
		$modal = '<div class="modal-footer">';
		$modal.= '<button class="btn btn-sm" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</button>';
		$modal.= '<button class="btn btn-sm btn-primary"><i class="icon-ok"></i> Guardar Cambios</button>';
		$modal.= '</div>';
		return $modal;
	}

	function modalFooter2() {
		$modal = '<div class="modal-footer">';
		$modal.= '<button class="btn btn-sm" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</button>';
		$modal.= '</div>';
		return $modal;
	}

	function fecha($fecha) {
		$fecha1 = explode("-", $fecha);
		$rt = $fecha1[2].' / '.$fecha1[1].' / '.$fecha1[0];
		return $rt;
	}

} #Funciones

?>