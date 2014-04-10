<?php 
class mCorreo {

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
					$this->$indice = $valor;
				}
			}
		}
	} #construct

	function archivoInsert($nom,$tmp) {
		$ruta = '../../../img/adjuntos/'.$nom;
		move_uploaded_file($tmp, $ruta);
		$sql = "INSERT INTO amarchiv (arruta) VALUES (?)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$nom);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? 1 : print_r($res->errorInfo());
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

	function correoEnviar($from,$fromName) {
		$this->con->beginTransaction();
		/**
		 * Creamos el mensaje y lo guardamos en la tabla.
		 * @var string
		 */
		$sql = "INSERT INTO ammensaj (peide, metitulo, memensaj, mereenvi, mefecha, mehora, meestado)
			VALUES (?, ?, ?, 0, now(), now(), 0)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$res->bindParam(2,$this->asunto);
		$res->bindParam(3,$_POST['mensaje']);
		$exe_1 = ($res->execute()==true) ? true : $this->msj[] = print_r($res->errorInfo()); 
		$meide = $this->con->lastInsertId('ammensaj_meide_seq');

		/**
		 * Creamos los adjuntos
		 */
		if(isset($_POST['imagen']) and count($_POST['imagen'])>0) {
			foreach($_POST['imagen'] as $i) {
				if(!empty($i)) {
					$q = strtoupper($i);
					$sql = "SELECT * FROM amarchiv WHERE arruta=?";
					$res = $this->con->prepare($sql);
					$res->bindParam(1,$q);
					$exe_2 = $res->execute();
					$row = $res->fetchAll(PDO::FETCH_OBJ);

					$sql = "INSERT INTO adadjunt (meide, aride) VALUES (?, ?)";
					$res = $this->con->prepare($sql);
					$res->bindParam(1,$meide);
					$res->bindParam(2,$row[0]->aride);
					$exe_3 = ($res->execute()==true) ? true : $this->msj[] = print_r($res->errorInfo());
				}
			}
		} else {
			$exe_3 = true;
		}

		/**
		 * Guardamos el mensaje al destinatario principal
		 * @var string
		 */
		$sql = "INSERT INTO adentrad (meide, peide, etide, enlectur, entipo, enestatu) VALUES (?, ?, 3, 0, 1,2)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$res->bindParam(2,$this->para);
		$exe_4 = ($res->execute()==true) ? true : $this->msj[] = print_r($res->errorInfo());
		/*if($exe_4==true):
			$destinatario = $this->selectIde($this->para);
			$destino  = $destinatario[0]->pecorreo;
			$destino2 = $destinatario[0]->pecoralt;
			$rt1      = $this->sendMail($from,$fromName,$destino);
			$rt2      = $this->sendMail($from,$fromName,$destino2);
		endif;*/
		/**
		 * Enviamos el mensaje a los destinatarios con copia
		 */
		if(isset($_POST['cc']) and count($_POST['cc'])>0) {
			foreach($_POST['cc'] as $c) {	
				$sql = "INSERT INTO adentrad (meide, peide, etide, enlectur, entipo, enestatu) VALUES (?, ?, 3, 0, 2, 2)";
				$res = $this->con->prepare($sql);
				$res->bindParam(1,$meide);
				$res->bindParam(2,$c);
				$exe_5 = ($res->execute()==true) ? true : $this->msj[] = print_r($res->errorInfo());
				/*if($exe_5==true):
					$destinatario = $this->selectIde($c);
					$destino  = $destinatario[0]->pecorreo;
					$destino2 = $destinatario[0]->pecoralt;
					$rt1      = $this->sendMail($from,$fromName,$destino);
					$rt2      = $this->sendMail($from,$fromName,$destino2);
				endif;*/
			}
		} else {
			$exe_5 = true;
		}

		/**
		 * Guardamos el mensaje en salida
		 * @var string
		 */
		$sql = "INSERT INTO adsalida (meide, peide) VALUES (?, ?)";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$res->bindParam(2,$_SESSION['casicoin_usr']);
		$exe_6 = ($res->execute()==true) ? true : $this->msj[] = print_r($res->errorInfo());

		if($exe_1==true and $exe_3==true and $exe_4==true and $exe_5==true and $exe_6==true) {
			$this->con->commit();
			$rt = 1;
		} else {
			$this->con->rollBack();
			$rt = print_r($this->msj);
		}
		return $rt;
	}

	function selectRecibidos() {
		$sql = "SELECT *
			FROM adentrad AS ent 
			INNER JOIN ammensaj AS men ON ent.meide=men.meide
			INNER JOIN amperson AS per ON men.peide=per.peide
			INNER JOIN ametique AS eti ON ent.etide=eti.etide
			WHERE ent.peide=? AND ent.enestatu=1
			ORDER BY ent.enide DESC";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectEnviados() {
		$sql = "SELECT * FROM ammensaj AS men
			INNER JOIN adsalida AS sal ON men.meide=sal.meide
			WHERE men.peide=?
			ORDER BY men.mefecha, men.mehora DESC";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectRecibidosTotal() {
		$sql = "SELECT * FROM adentrad AS ent
			WHERE ent.peide=? AND ent.enlectur=0 AND ent.enestatu=1";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->rowCount() : print_r($res->errorInfo());
		return $rt;
	}

	function selectMensajeIde($enide) {
		$sql = "SELECT *, per.penombre AS rnombre, per.peapelli AS rapellido, pe2.penombre AS dnombre, pe2.peapelli AS dapellido,
			car.cadescri AS rcadescri, ca2.cadescri AS dcadescri,
			dep.dedescri AS rdedescri, de2.dedescri AS ddedescri
			FROM adentrad AS ent 
			INNER JOIN ammensaj AS men ON ent.meide=men.meide
			INNER JOIN amperson AS per ON men.peide=per.peide
			INNER JOIN amperson AS pe2 ON ent.peide=pe2.peide
			INNER JOIN amcargos AS car ON per.caide=car.caide
			INNER JOIN amdepart AS dep ON per.deide=dep.deide
			INNER JOIN amcargos AS ca2 ON pe2.caide=ca2.caide
			INNER JOIN amdepart AS de2 ON pe2.deide=de2.deide
			LEFT JOIN  ametique AS eti ON ent.etide=eti.etide
			WHERE ent.enide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$enide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function marcarLeido() {
		$sql = "UPDATE adentrad SET enlectur=1 WHERE enide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$this->enide);
		$exe_1 = $res->execute();
	}

	function etiquetas() {
		$sql = "SELECT * FROM ametique";
		$res = $this->con->prepare($sql);
		$res->execute();
		return $res->fetchAll(PDO::FETCH_OBJ);
	}

	function updateEtiqueta() {
		if(count($_POST['itemmensaje'])>0) {
			foreach($_POST['itemmensaje'] as $i) {
				$sql = "UPDATE adentrad SET etide=? WHERE enide=?";
				$res = $this->con->prepare($sql);
				$res->bindParam(1,$this->etide);
				$res->bindParam(2,$i);
				$exe_1 = $res->execute();
			}
		}
	}

	function updateLectura() {
		if(count($_POST['itemmensaje'])>0) {
			foreach($_POST['itemmensaje'] as $i) {
				$sql = "UPDATE adentrad SET enlectur=? WHERE enide=?";
				$res = $this->con->prepare($sql);
				$res->bindParam(1,$this->lectura);
				$res->bindParam(2,$i);
				$exe_1 = $res->execute();
			}
		}
	}

	function deleteMensaje() {
		if(count($_POST['itemmensaje'])>0) {
			foreach($_POST['itemmensaje'] as $i) {
				$sql = "UPDATE adentrad SET enestatu=0 WHERE enide=?";
				$res = $this->con->prepare($sql);
				$res->bindParam(1,$i);
				$exe_1 = $res->execute();
			}
		}
	}

	function selectEtiquetas($etide) {
		$sql = "SELECT * FROM adentrad AS ent 
			INNER JOIN ammensaj AS men ON ent.meide=men.meide
			INNER JOIN amperson AS per ON men.peide=per.peide
			LEFT JOIN ametique AS eti ON ent.etide=eti.etide
			WHERE ent.peide=? AND ent.enestatu=1 AND ent.etide=?
			ORDER BY men.mefecha, men.mehora DESC";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$res->bindParam(2,$etide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function selectMensajeAdjuntosIde($enide) {
		$sql = "SELECT * FROM adentrad AS ent 
			INNER JOIN adadjunt AS adj ON ent.meide=adj.meide
			INNER JOIN amarchiv AS arc ON adj.aride=arc.aride
			WHERE ent.peide=? AND ent.enestatu=1 AND ent.enide=?";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$_SESSION['casicoin_usr']);
		$res->bindParam(2,$enide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function conCopia($meide) {
		$sql = "SELECT * FROM adentrad AS ent 
			INNER JOIN amperson AS per ON ent.peide=per.peide
			INNER JOIN amcargos AS car ON per.caide=car.caide
			INNER JOIN amdepart AS dep ON per.deide=dep.deide
			WHERE ent.meide=? AND ent.entipo=2";
		$res = $this->con->prepare($sql);
		$res->bindParam(1,$meide);
		$exe_1 = $res->execute();
		$rt = ($exe_1==true) ? $res->fetchAll(PDO::FETCH_OBJ) : print_r($res->errorInfo());
		return $rt;
	}

	function sendMail($desde,$nombredesde,$destino) {
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