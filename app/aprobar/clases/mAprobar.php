<?php 
class mAprobar {

	protected $dbh,$con,$msj;

	function __clone() {

	} #clone
	
	function __construct() {
		$this->dbh = new Conexion();
		$this->con = $this->dbh->postgres();
		$this->mail = new PHPMailer();
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

	function guardar() {
		$this->con->beginTransaction();
		// Primera Operación: Actualizar el mensaje
		$sql = "UPDATE ammensaj SET metitulo=?, memensaj=? WHERE meide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->asunto);
		$res->bindParam(2,$this->mensaje);
		$res->bindParam(3,$this->meide);
		$exe1 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());
		// Segunda Operación: Actualizar Destinatario Principal
		$sql = "UPDATE adentrad SET peide=? WHERE meide=? and peide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->para);
		$res->bindParam(2,$this->meide);
		$res->bindParam(3,$this->parappal);
		$exe2 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());
		// Tercera Operación: Actualizar Destinatarios CC
		$exe3 = 0;
		// Cuarta Operación: Actualizando los cc
		// Borrando todos los destinatarios cc
		$sql = "DELETE FROM adentrad WHERE meide=? AND entipo=2";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->meide);
		$res->execute();
		if(isset($_POST['cc']) AND count($_POST['cc'])>0) :
			// Creando los nuevos destinatarios cc
			foreach($_POST['cc'] as $cc) :
				$sql = "INSERT INTO adentrad (meide,peide,etide,enlectur,entipo,enestatu) 
					VALUES (?,?,3,0,2,2)";
				$res = $this->con->prepare($sql);
				$res->bindParam(1,$this->meide);
				$res->bindParam(2,$cc);
				$exe3 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());
			endforeach;
		else :
			$exe3 = 1;
		endif;
		// Creando archivos adjuntos, si existen
		$exe4 = 0;
		if(isset($_POST['imagen']) and count($_POST['imagen'])>0) :
			foreach($_POST['imagen'] as $i) :
				if(!empty($i)) :
					// Buscando el archivo adjunto
					$q = strtoupper($i);
					$sql = "SELECT * FROM amarchiv WHERE arruta=?";
					$res = $this->con->prepare($sql);
					$res->bindParam(1,$q);
					$res->execute();
					$row = $res->fetchAll(PDO::FETCH_OBJ);
					// Agregando el archivo al mensaje
					$sql = "INSERT INTO adadjunt (meide, aride) VALUES (?, ?)";
					$res = $this->con->prepare($sql);
					$res->bindParam(1,$this->meide);
					$res->bindParam(2,$row[0]->aride);
					$exe4 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());
				endif;
			endforeach;
		else :
			$exe4 = 1;
		endif;

		// Guardando el registro de cambios recientes
		$sql = "INSERT INTO adcamrec (peide,crfecha,crhora,meide) 
			VALUES (?,now(),now(),?)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$res->bindParam(2,$this->meide);
		$exe5 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());

		if ($exe1==1 and $exe2==1 and $exe3==1 and $exe4==1 and $exe5==1) :
			$this->con->commit();
			$rt = 1;
		else :
			$this->con->rollBack();
			$rt = $this->msj;
		endif;

		return $rt;
	}

	function borrarAdjunto() {
		$sql = "DELETE FROM adadjunt WHERE adide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->adide);
		$res->execute();
	}

	function guardarAprobar() {
		$this->guardar();
		$this->con->beginTransaction();
		$sql = "UPDATE adentrad SET enestatu=1 WHERE meide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->meide);
		$exe1 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());
		$sql = "UPDATE ammensaj SET meestado=1 WHERE meide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->meide);
		$exe2 = ($res->execute()==1) ? 1 : $this->msj[] = print_r($res->errorInfo());
		// Seleccionar usuarios y enviar correos
		$sql = "SELECT * FROM adentrad AS ent 
			INNER JOIN amperson AS per ON ent.peide=per.peide
			WHERE ent.meide=? AND ent.enestatu=1";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->meide);
		$res->execute();
		$row = $res->fetchAll(PDO::FETCH_OBJ);
		foreach($row as $r) :
			$this->sendMail($r->pecorreo);
			$this->sendMail($r->pecoralt);
		endforeach;
		if($exe1==1 and $exe2==1) :
			$this->con->commit();
			$rt = 1;
		else :
			$this->con->rollBack();
			$rt = $this->msj;
		endif;
		return $rt;
	}

	function sendMail($destino) {
		$titulo = 'Nueva Correspondencia Interna';
		$cuerpo = 'Ha recibido una nueva correspondencia, para revisarla por favor visite <a href="http://iutai.tec.ve/casicoin/" target="_blank">
			iutai.tec.ve</a><br><br><hr><div style="font-size:12px;color:#AEAEAE;font-style:italic;font-weing:bold;">Equipo de Sistemas IUTAI</div>';
		$this->mail->IsSMTP();
		$this->mail->SMTPAuth = true;
		$this->mail->Host     =   "smtp.iutai.tec.ve";
		$this->mail->Username = "siscoin@iutai.tec.ve";
		$this->mail->Password = "asdrty123#";
		$this->mail->Port     = 25;
		$this->mail->From     = "siscoin@iutai.tec.ve";
		$this->mail->FromName = 'Equipo de Sistemas IUTAI';
		$this->mail->AddAddress($destino);
		$this->mail->IsHTML(true);
		$this->mail->Subject  = $titulo;
		$body                 = $cuerpo;
		$this->mail->Body     = $body;
		$exito                = $this->mail->Send();
		if($exito) :
			$rt = 1;
		else :
			$rt = '¡ERROR!';
		endif;

		return $rt;
	}

} #m
?>