<?php 
class mUsuarios {

	protected $dbh,$con,$msj,$permisosDefecto;

	function __clone() {

	} #clone
	
	function __construct() {
		$this->dbh = new Conexion();
		$this->con = $this->dbh->postgres();
		$this->msj = array();
		$this->permisosDefecto = array(1,2);
		if(isset($_POST)) {
			foreach($_POST as $indice=>$valor) {
				if(!is_array($valor)) {
					$this->$indice = strtoupper($valor);
				}
			}
		}
	} #construct

	function comprobarSesionInicio() {
		if(!isset($_SESSION['casicoin_usr'])) {
			header('location:login');
		}
	}
	function comprobarSesionLogin() {
		if(isset($_SESSION['casicoin_usr'])) {
			header('location:inicio');
		}
	}

	function iniciarSesion() {
		$nomusu = strip_tags($this->nomusu);
		$sql = "SELECT * FROM adacceso AS acc 
			INNER JOIN amperson AS per ON acc.peide=per.peide
			WHERE acc.acnomusu=? AND acc.acclave=? AND acc.acestado=1";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$nomusu);
		$res->bindParam(2,$this->clave);
		$res->execute();
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	function cerrarSesion() {
		session_unset();
		session_destroy();
		header('location:login');
	}

	function selectAll() {
		$sql = "SELECT * FROM amperson AS per 
			INNER JOIN adacceso AS acc ON per.peide=acc.peide
			INNER JOIN amdepart AS dep ON per.deide=dep.deide
			INNER JOIN amcargos AS car ON per.caide=car.caide
			WHERE acc.acvisibl=1
			ORDER BY per.penombre ASC";
		$res = $this->con->prepare($sql);
		$res->execute();
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	function usuarioInsert() {
		$this->con->beginTransaction();
		$sql = "INSERT INTO amperson (penacion, pecedula, penombre, peapelli, petelefo, pecorreo, peabrevi, caide, deide, pecoralt)
			VALUES (?,?,?,?,?,?,?,?,?,?)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1, $this->nacionalidad);
		$res->bindParam(2, $this->cedula);
		$res->bindParam(3, $this->nombres);
		$res->bindParam(4, $this->apellidos);
		$res->bindParam(5, $this->telefono);
		$res->bindParam(6, $this->correo);
		$res->bindParam(7, $this->abreviatura);
		$res->bindParam(8, $this->cargo);
		$res->bindParam(9, $this->departamento);
		$res->bindParam(10, $this->correo2);
		$exe_1 = $res->execute();
		$last = $this->con->lastInsertId('amperson_peide_seq');

		$sql = "INSERT INTO adacceso (peide, acnomusu, acclave, acestado, acvisibl) VALUES (?,?,?,1,1)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$last);
		$res->bindParam(2,$this->usuario);
		$res->bindParam(3,$this->clave);
		$exe_2 = $res->execute();

		foreach($this->permisosDefecto as $pd) {
			$sql = "INSERT INTO adautori (peide,suide,auestado) VALUES (?,?,1)";
			$res = $this->con->prepare($sql);
			$res->bindParam(1,$last);
			$res->bindParam(2,$pd);
			$exe_3 = $res->execute();
		}

		if($exe_1==true and $exe_2==true and $exe_3==true) {
			$this->con->commit();
			$rt = 1;
		} else {
			$this->con->rollBack();
			$rt = print_r($res->errorInfo());
		}
		return $rt;
	}

	function selectIde($ide) {
		$sql = "SELECT * FROM amperson AS per 
			INNER JOIN adacceso AS acc ON per.peide=acc.peide
			INNER JOIN amdepart AS dep ON per.deide=dep.deide
			INNER JOIN amcargos AS car ON per.caide=car.caide
			WHERE per.peide=?
			ORDER BY per.penombre ASC";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$ide);
		$res->execute();
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	function usuarioUpdate() {
		$this->con->beginTransaction();
		$sql = "UPDATE amperson SET penacion=?, pecedula=?, penombre=?, peapelli=?, petelefo=?, pecorreo=?, 
			peabrevi=?, caide=?, deide=?, pecoralt=?
			WHERE peide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1, $this->nacionalidad);
		$res->bindParam(2, $this->cedula);
		$res->bindParam(3, $this->nombres);
		$res->bindParam(4, $this->apellidos);
		$res->bindParam(5, $this->telefono);
		$res->bindParam(6, $this->correo);
		$res->bindParam(7, $this->abreviatura);
		$res->bindParam(8, $this->cargo);
		$res->bindParam(9, $this->departamento);
		$res->bindParam(10, $this->correo2);
		$res->bindParam(11, $this->ide);
		$exe_1 = $res->execute();

		$sql = "UPDATE adacceso SET acnomusu=?, acclave=? WHERE peide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1, $this->usuario);
		$res->bindParam(2, $this->clave);
		$res->bindParam(3, $this->ide);
		$exe_2 = $res->execute();

		if($exe_1==true and $exe_2==true) {
			$this->con->commit();
			$rt = 1;
		} else {
			$this->con->rollBack();
			$rt = print_r($res->errorInfo());
		}
		return $rt;
	}

	function estadoUpdate() {
		$sql = "UPDATE adacceso SET acestado=? WHERE peide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1, $this->estado);
		$res->bindParam(2, $this->ide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? 1 : print_r($res->errorInfo());
		return $rt;
	}

	function permisosSelectAll() {
		$sql = "SELECT * FROM ammodulo AS mo 
			INNER JOIN amsubmod AS su ON mo.moide=su.moide";
		$res = $this->con->prepare($sql);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectPermisoUsuario($ide,$sumo) {
		$sql = "SELECT * FROM adautori WHERE peide=? AND suide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$ide);
		$res->bindParam(2,$sumo);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function permisoUpdate() {
		$total = $this->selectPermisoUsuario($this->ide,$this->suide);
		if(count($total)>0) {
			$sql = "UPDATE adautori SET auestado=? WHERE peide=? AND suide=?";
			$res = $this->con->prepare($sql);
			$res->bindParam(1,$this->val);
			$res->bindParam(2,$this->ide);
			$res->bindParam(3,$this->suide);
			$exe_1 = $res->execute();
		} else {
			$sql = "INSERT INTO adautori (peide, suide, auestado) VALUES (?,?,?)";
			$res = $this->con->prepare($sql);
			$res->bindParam(1,$this->ide);
			$res->bindParam(2,$this->suide);
			$res->bindParam(3,$this->val);
			$exe_1 = $res->execute();
		}

		$rt = ($exe_1==true) ? 1 : print_r($res->errorInfo());
		return $rt;
	}

	function traerMenu() {
		$sql = "SELECT mo.modescri,mo.moide FROM adautori AS au
			INNER JOIN amsubmod AS su ON au.suide=su.suide
			INNER JOIN ammodulo AS mo ON su.moide=mo.moide
			WHERE au.auestado=1 AND au.peide=?
			GROUP BY mo.moide
			ORDER BY mo.moorden";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function traerSubmenu($moide) {
		$sql = "SELECT * FROM adautori AS au
			INNER JOIN amsubmod AS su ON au.suide=su.suide
			WHERE au.auestado=1 AND au.peide=? AND su.moide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$res->bindParam(2,$moide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function getContenido($var) {
		$sql = "SELECT * FROM amsubmod AS su 
			INNER JOIN adautori AS au ON su.suide=au.suide
			WHERE au.auestado=1 AND su.suvariab=? AND au.peide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$var);
		$res->bindParam(2,$_SESSION['casicoin_usr']);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function usuarioDelete() {
		$sql = "UPDATE adacceso SET acvisibl=0 WHERE peide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->ide);
		$rt = ($res->execute()==true) ? 1 : print_r($res->errorInfo());
		return $rt;
	}

} #m
?>