<?php
require_once 'items/mvc/modelos/conexion.php';
require_once 'items/mvc/modelos/dashboard/modelo.pruebacron.php';
class ModeloPCron{
	/*==========================================
	=            Prueba Cron            =
	==========================================*/
	
	static public function mdlpcron(){

		$stmt = Conexion::conectar()->prepare("INSERT INTO pruebacron (id_empresa, nombre, direccion, telefono) 
        VALUES(1, 2, 3, 4)");

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Prueba Cron  ======*/
	
}

?>