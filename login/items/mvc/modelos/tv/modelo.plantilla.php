<?php

class ModeloPlantilla{

	/*=================================
	=            Plantilla            =
	=================================*/
	
	static public function mdlEmpresa($empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM empresas WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = NULL;
		
	}
	
	/*=====  End of Plantilla  ======*/
	
	/*===================================================
	=            MOSTRAR MI PLANTILLA ACTIVA            =
	===================================================*/
	
	static public function mdlMostrarMisPlantillas($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND estado = :estado");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR MI PLANTILLA ACTIVA  ======*/

	/*=========================================
	=            MOSTRAR PLANTILLA            =
	=========================================*/
	
	static public function mdlMostrarPlantilla($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PLANTILLA  ======*/

	/*=============================================================
	=            MOSTRAR CONFIGURACION DE LA PLANTILLA            =
	=============================================================*/
	
	static public function mdlMostrarConfiguracionPlantilla($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE LA PLANTILLA  ======*/
	
}

?>