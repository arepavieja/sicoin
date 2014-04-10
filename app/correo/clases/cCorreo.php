<?php 
class cCorreo extends mCorreo {
	
	function leidos($var) {
		$rt = ($var==0) ? 'bolder' : null;
		return $rt;
	}

	function siHayadjuntos($meide) {
		$sql = "SELECT * from adadjunt WHERE meide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$exe_1 = $res->execute();
		$tot = $res->rowCount();
		$rt = ($tot>0) ? '<i class="fa fa-paperclip bigger-130"></i>' : null;
		return $rt;
	}	

	function estado($var) {
		$rt = ($var==0) ? 'En espera' : 'Aprobado';
		return $rt;
	}

}
?>