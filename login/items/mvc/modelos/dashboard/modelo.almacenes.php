<?php 

class ModeloAlmacenes{

	/*=========================================
	=            MOSTRAR ALMACENES            =
	=========================================*/
	
	static public function mdlMostrarAlmacenes($tabla, $item, $valor, $empresa){

		if ($item != NULL) {
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

	
	/*=====  End of MOSTRAR ALMACENES  ======*/
	
	/*=====================================
	=            CREAR ALMACEN            =
	=====================================*/
	
	static public function mdlCrearAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, nombre, direccion, telefono) 
												VALUES(:id_empresa, :nombre, :direccion, :telefono)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR ALMACEN  ======*/
	
	/*======================================
	=            EDITAR ALMACEN            =
	======================================*/
	
	static public function mdlEditarAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, direccion = :direccion, telefono = :telefono
												WHERE id_almacen = :id_almacen");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR ALMACEN  ======*/
	
	/*========================================
	=            ELIMINAR ALMACEN            =
	========================================*/
	
	static public function mdlEliminarAlmacenes($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR ALMACEN  ======*/
	
	/*===========================================================================
	=                   GUARDAR REGISTRO DE COMPRA DE ALMACEN                   =
	===========================================================================*/
	
	static public function mdlCrearRegistroCompraAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_almacen, fecha_adquirido, fecha_ultimo_pago, fecha_proximo_pago, estado) 
													VALUES(:id_empresa, :id_almacen, :fecha_adquirido, :fecha_ultimo_pago, :fecha_proximo_pago, :estado)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_adquirido", $datos["fecha_adquirido"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		
		if($stmt -> execute()){

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of GUARDAR REGISTRO DE COMPRA DE ALMACEN  =============*/


}

?>