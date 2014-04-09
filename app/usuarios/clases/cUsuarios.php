<?php 
class cUsuarios extends mUsuarios {
	
	function estado($var) {
		$text = ($var==1) ? 'ACTIVO' : 'INACTIVO';
		$val  = ($var==1) ? 0 : 1;
		$ico  = ($var==1) ? 'fa-ban' : 'fa-check';
		$rt = array('text'=>$text,'val'=>$val,'ico'=>$ico);
		return $rt;
	}

	function estadoPermiso($var) {
		$text       = ($var==1) ? 'ACTIVO' : 'INACTIVO';
		$buttonText = ($var==1) ? 'Denegar' : 'Permitir';
		$value      = ($var==1) ? 0 : 1;
		$class      = ($var==1) ? 'btn-danger' : 'btn-success';
		$rt = array('text'=>$text, 'buttonText'=>$buttonText, 'value'=>$value, 'class'=>$class);
		return $rt; 
	}

	function cedulaInsert($nac,$ced) {
		$sql = "SELECT penacion,pecedula FROM amperson WHERE penacion=? AND pecedula=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$nac);
		$res->bindParam(2,$ced);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Cédula de identidad ya registrada";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function cedulaUpdate($nac,$ced,$ide) {
		$sql = "SELECT penacion,pecedula,peide FROM amperson WHERE penacion=? AND pecedula=? AND peide!=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$nac);
		$res->bindParam(2,$ced);
		$res->bindParam(3,$ide);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Cédula de identidad ya registrada";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function cusuarioInsert($usu) {
		$sql = "SELECT acnomusu FROM adacceso WHERE acnomusu=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$usu);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Nombre de usuario ya registrado";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function cusuarioUpdate($usu,$ide) {
		$sql = "SELECT acnomusu,peide FROM adacceso WHERE acnomusu=? AND peide!=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$usu);
		$res->bindParam(2,$ide);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Nombre de usuario ya registrado";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function validarInsert() {
		$a = $this->cedulaInsert($this->nacionalidad,$this->cedula);
		$b = $this->cusuarioInsert($this->usuario);
		$a1 = ($a==1) ? 1 : $this->msj[] = $a;
		$b1 = ($b==1) ? 1 : $this->msj[] = $b;
		$rt = ($a1==1 and $b1==1) ? 1 : $this->msj;
		return $rt;
	}

	function validarUpdate() {
		$a = $this->cedulaUpdate($this->nacionalidad,$this->cedula,$this->ide);
		$b = $this->cusuarioUpdate($this->usuario,$this->ide);
		$a1 = ($a==1) ? 1 : $this->msj[] = $a;
		$b1 = ($b==1) ? 1 : $this->msj[] = $b;
		$rt = ($a1==1 and $b1==1) ? 1 : $this->msj;
		return $rt;
	}

	function cestadoUpdate($var) {
		$estado = ($var==1) ? 'Inactivar/Bloquear' : 'Activar/Desbloquear';
		$rt = array('estado'=>$estado);
		return $rt;
	}

}
?>