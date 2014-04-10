<?php 
class mAprobar {

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

	function selectPorAprobar() {
		$sql = "SELECT * FROM ammensaj AS men 
			INNER JOIN amperson AS per ON men.peide=per.peide
			ORDER BY men.mefecha, men.mehora DESC";
		$res = $this->con->prepare($sql);
		$rt = ($res->execute()==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectMensajeIdeEditar($meide) {
		$sql = "SELECT * FROM ammensaj AS men 
			WHERE men.meide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$rt = ($res->execute()==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectMensajeIdeEditarDestino($tipo,$meide) {
		$sql = "SELECT * FROM adentrad AS ent 
			INNER JOIN amperson AS per ON ent.peide=per.peide
			INNER JOIN amcargos AS car ON car.caide=per.caide 
			INNER JOIN amdepart AS dep On dep.deide=per.deide
			WHERE ent.meide=? AND ent.entipo=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$res->bindParam(2,$tipo);
		$rt = ($res->execute()==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectMensajeAdjuntosIdeEditar($meide) {
		$sql = "SELECT * FROM adadjunt AS adj
			INNER JOIN amarchiv AS arc ON adj.aride=arc.aride
			WHERE adj.meide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

} #m
?>