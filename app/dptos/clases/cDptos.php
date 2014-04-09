<?php 
class cDptos extends mDptos {
	
	function descripcionInsert($var) {
		$sql = "SELECT dedescri FROM amdepart WHERE dedescri=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$var);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Departamento ya registrado";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function descripcionUpdate($var,$ide) {
		$sql = "SELECT dedescri FROM amdepart WHERE dedescri=? AND deide!=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$var);
		$res->bindParam(2,$ide);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Departamento ya registrado";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function abreviaturaInsert($var) {
		$sql = "SELECT deabrevi FROM amdepart WHERE deabrevi=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$var);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Abreviatura de departamento ya registrada";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function abreviaturaUpdate($var,$ide) {
		$sql = "SELECT deabrevi FROM amdepart WHERE deabrevi=? AND deide!=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$var);
		$res->bindParam(2,$ide);
		$res->execute();
		if($res->rowCount()>0) {
			$rt = "Abreviatura de departamento ya registrada";
		} else {
			$rt = 1;
		}
		return $rt;
	}

	function validarInsert() {
		$a = $this->descripcionInsert($this->descripcion);
		$b = $this->abreviaturaInsert($this->abreviatura);
		$a1 = ($a==1) ? 1 : $this->msj[] = $a;
		$b1 = ($b==1) ? 1 : $this->msj[] = $b;
		$rt = ($a1==1 and $b1==1) ? 1 : $this->msj;
		return $rt;
	}
	function validarUpdate() {
		$a = $this->descripcionUpdate($this->descripcion,$this->ide);
		$b = $this->abreviaturaUpdate($this->abreviatura,$this->ide);
		$a1 = ($a==1) ? 1 : $this->msj[] = $a;
		$b1 = ($b==1) ? 1 : $this->msj[] = $b;
		$rt = ($a1==1 and $b1==1) ? 1 : $this->msj;
		return $rt;
	}
}
?>