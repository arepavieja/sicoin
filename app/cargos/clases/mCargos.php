<?php 
class mCargos {

	protected $dbh,$con,$msj;

	function __clone() {

	} #clone
	
	function __construct() {
		$this->dbh = new Conexion();
		$this->con = $this->dbh->postgres();
		$this->msj = array();
		if(isset($_POST)) {
			foreach($_POST as $indice=>$valor) {
				if(!is_array($valor)) {
					$this->$indice = strtoupper($valor);
				}
			}
		}
	} #construct

	function selectAll() {
		$sql = "SELECT * FROM amcargos ORDER BY caide ASC";
		$res = $this->con->prepare($sql);
		$exe_1 = $res->execute();
		$rows = $res->fetchAll(PDO::FETCH_OBJ);
		$rt = ($exe_1==true) ? $rows : print_r($res->errorInfo());
		return $rt;
	}

	function insert() {
		$sql = "INSERT INTO amcargos (cadescri,caabrevi) VALUES (?,?)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->descripcion);
		$res->bindParam(2,$this->abreviatura);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? 1 : print_r($res->errorInfo());
		return $rt;
	}

	function selectIde() {
		$sql = "SELECT * FROM amcargos WHERE caide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->ide);
		$exe_1 = $res->execute();
		$rows = $res->fetchAll(PDO::FETCH_OBJ);
		$rt = ($exe_1==true) ? $rows : print_r($res->errorInfo());
		return $rt;
	}

	function update() {
		$sql = "UPDATE amcargos SET cadescri=?, caabrevi=? WHERE caide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->descripcion);
		$res->bindParam(2,$this->abreviatura);
		$res->bindParam(3,$this->ide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? 1 : print_r($res->errorInfo());
		return $rt;
	}

	function delete() {
		$sql = "DELETE FROM amcargos WHERE caide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->ide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? 1 : print_r($res->errorInfo());
		return $rt;
	}

} #m
?>