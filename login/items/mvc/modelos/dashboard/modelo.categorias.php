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

		if ($item == "id_subcategoria") {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt->fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}
	
	/*=====  End of MOSTRAR SUBCATEGORIAS DE LAS CATEGORIAS  ======*/

	/*=============================================
	=            CREAR NUEVA CATEGORIA            =
	=============================================*/
	
	static public function mdlCrearCategoria($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, nombre, imagen, nombreImg) VALUES(:id_empresa, :nombre, :imagen, :nombreImg)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"] ,PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"] ,PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"] ,PDO::PARAM_STR);
		$stmt -> bindParam(":nombreImg", $datos["nombreImg"] ,PDO::PARAM_STR);
		
		if($stmt -> execute()){
			return "ok";
		} else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR NUEVA CATEGORIA  ======*/

	/*========================================
	=            EDITAR CATEGORIA            =
	========================================*/
	
	static public function mdlEditarCategoria($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre, imagen = :imagen, nombreImg = :nombreImg WHERE id_categoria=:id_categoria");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"] ,PDO::PARAM_STR);
		$stmt -> bindParam(":nombreImg", $datos["nombreImg"] ,PDO::PARAM_STR);
		$stmt -> bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR CATEGORIA  ======*/

	/*================================================
	=            CREAR MUEVA SUBCATEGORIA            =
	================================================*/
	
	static public function mdlCrearSubcategoria($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria, nombre) VALUES(:id_categoria, :nombre)");
		$stmt -> bindParam(":id_categoria",$datos["id_categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);

		if($stmt -> execute()){
		
			return "ok";
		
		} 

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR MUEVA SUBCATEGORIA  ======*/

	/*===========================================
	=            EDITAR SUBCATEGORIA            =
	===========================================*/
	
	static public function mdlEditarSubcategoria($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre WHERE id_subcategoria=:id_subcategoria");

		$stmt -> bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_subcategoria",$datos["id_subcategoria"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR SUBCATEGORIA  ======*/

	/*============================================================
	=                   ELIMINAR SUBCATEGORIAS                   =
	============================================================*/
	
	static public function mdlEliminarSubcategorias($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of ELIMINAR SUBCATEGORIAS  =============*/

	/*============================================================
	=                   ELIMINAR CATEGORIAS                   =
	============================================================*/
	
	static public function mdlEliminarCategorias($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of ELIMINAR CATEGORIAS  =============*/
	
}

?>