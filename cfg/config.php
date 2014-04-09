<?php 

if(!isset($_SESSION)) {
	session_start();
}
/**
 * Indica si se muestran o no errores en el sistema
 * 1 => Muestra errores
 * 0 => No muestra nada
 */
ini_set('display_errors', '1');

/**
 * Indica la cantidad de memoria a usar.
 * -1 => Sin límite
 * XXM => Cantidad de memoria en megas, ejm '15M'
 */
ini_set('memory_limit', '-1');

/**
 * Los tipos de errores a ser mostrados en el sistema
 * E_ALL => Muestra todo tipo de errores
 * Mayor información: http://php.net/manual/es/function.error-reporting.php
 */
error_reporting(E_ALL);

/**
 * Fecha por defecto del servidor para el sistema
 */
date_default_timezone_set('America/Caracas');

?>