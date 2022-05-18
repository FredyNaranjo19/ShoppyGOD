<?php

class ModeloCategorias{

	/*========================================================
	=            MOSTRAR CATEGORIAS DE LA EMPRESA            =
	========================================================*/
	
	static public function mdlMostrarCategorias($tabla, $item, $valor, $empresa){

		if ($item == "id_categoria") {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();
			$stmt = NULL;

		}
	}
	
	/*=====  End of MOSTRAR CATEGORIAS DE LA EMPRESA  ======*/

	/*===============================================================
	=            MOSTRAR SUBCATEGORIAS DE LAS CATEGORIAS            =
	===============================================================*/
	
	static public function mdlMostrarSubCategorias($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt->fetchAll();

		$stmt -> close();
		$stmt = null;

	}
	
	/*=====  End of MOSTRAR SUBCATEGORIAS DE LAS CATEGORIAS  ======*/
}
 
?>