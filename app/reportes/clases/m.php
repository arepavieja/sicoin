<?php 
class m {

	protected $dbh,$con,$msj;

	function __clone() {

	} #clone
	
	function __construct() {
		$this->dbh = new Conexion();
		$this->con = $this->dbh->postgres();
		$this->msj = array();
		if(isset($_POST)) {
			foreach($_POST as $indice=>$valor) {
				$this->$indice = strtoupper($valor);
			}
		}
	} #construct

} #m
?>