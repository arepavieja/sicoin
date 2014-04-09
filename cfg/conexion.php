<?php 
class Conexion {
	private $driver,$host,$usr,$dbname,$pwd,$con;

	function __clone() {

	} #clone

	function postgres() {
		$this->driver = 'pgsql';
		$this->host   = 'localhost';
		$this->usr    = 'sicoin';
		$this->dbname = 'bdsicoin';
		$this->pwd    = 'sicoin';

		try {
			$this->con = new PDO($this->driver.':host='.$this->host.';dbname='.$this->dbname, $this->usr, $this->pwd);
			return $this->con;
		} catch(PDOExecption $err) {
			echo $err->getMessage();
		}
		
	} #postgres

} #conexion

?>