<?php

class ModeloProveedores{

	/*===========================================
	=            MOSTRAR PROVEEDORES            =
	===========================================*/
	
	static public function mdlMostrarProveedores($tabla, $item, $valor, $empresa){

		if ($item == 'id_proveedor') {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR PROVEEDORES  ======*/

	/*=============================================
	=            CREAR NUEVO PROVEEDOR            =
	=============================================*/
	
	static public function mdlCrearProveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, nombre, contacto, telefono, calle, noExt, noInt, colonia, cp, municipio, estado, pais) VALUES(:id_empresa, :nombre, :contacto, :telefono, :calle, :noExt, :noInt, :colonia, :cp, :municipio, :estado, :pais)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":contacto", $datos["contacto"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt -> bindParam(":noExt", $datos["noExt"], PDO::PARAM_STR);
		$stmt -> bindParam(":noInt", $datos["noInt"], PDO::PARAM_STR);
		$stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt -> bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":pais", $datos["pais"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;


	}
	
	/*=====  End of CREAR NUEVO PROVEEDOR  ======*/
	/*========================================
	=            EDITAR PROVEEDOR            =
	========================================*/
	
	static public function mdlEditarProveedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_empresa = :id_empresa, nombre = :nombre, contacto = :contacto, telefono = :telefono, calle = :calle, noExt = :noExt, noInt = :noInt, colonia = :colonia, cp = :cp, municipio = :municipio, estado = :estado, pais = :pais WHERE id_proveedor = :id_proveedor");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":contacto", $datos["contacto"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt -> bindParam(":noExt", $datos["noExt"], PDO::PARAM_STR);
		$stmt -> bindParam(":noInt", $datos["noInt"], PDO::PARAM_STR);
		$stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt -> bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR PROVEEDOR  ======*/
	
	/*==========================================
	=            ELIMINAR PROVEEDOR            =
	==========================================*/
	
	static public function mdlEliminarProveedor($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR PROVEEDOR  ======*/
	
}

?>