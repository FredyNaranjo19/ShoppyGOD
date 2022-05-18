<?php

class ModeloProductosMasivo{

	/*==================================================
	=            MOSTRAR PRODUCTOS PRECARGA            =
	==================================================*/
	
	static public function mdlMostrarProductosPrecarga($tabla, $item, $valor, $empresa){

		if ($item != NULL) {

			if ($item == "id_precarga") {
				
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetch();

			} else {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetchAll();

			}
				

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}
 
		$stmt -> close();
		$stmt = NULL;
			
	}
	
	/*=====  End of MOSTRAR PRODUCTOS PRECARGA  ======*/

	/*===============================================
	=            CREAR PRODUCTO PRECARGA            =
	===============================================*/
	
	static public function mdlCrearProductoPrecarga($tabla, $datos){

	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, sku, codigo, 
															nombre, descripcion, stock, costo, folio, 
															proveedor, precio, promo, p_sugerido, largo, ancho, 
															alto, peso,  sat_clave_prod_serv, sat_clave_unidad) 
											VALUES(:id_empresa, :sku, :codigo,
													:nombre, :descripcion, :stock, :costo, :folio,
													:proveedor, :precio, :promo, :p_sugerido, :largo, :ancho, 
													:alto, :peso, :sat_clave_prod_serv, :sat_clave_unidad)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":proveedor", $datos["proveedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":promo", $datos["promo"], PDO::PARAM_STR);
		$stmt -> bindParam(":p_sugerido", $datos["p_sugerido"], PDO::PARAM_STR);
		$stmt -> bindParam(":largo", $datos["largo"], PDO::PARAM_STR);
		$stmt -> bindParam(":ancho", $datos["ancho"], PDO::PARAM_STR);
		$stmt -> bindParam(":alto", $datos["alto"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
		$stmt -> bindParam(":sat_clave_prod_serv", $datos["sat_clave_prod_serv"], PDO::PARAM_STR);
		$stmt -> bindParam(":sat_clave_unidad", $datos["sat_clave_unidad"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR PRODUCTO PRECARGA  ======*/

	/*===================================================
	=            MODIFICAR CAMPO DE PRECARGA            =
	===================================================*/
	
	static public function mdlModificarCampoPrecarga($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ".$datos['campo']." = :valor WHERE id_precarga = :id_precarga");
		$stmt -> bindParam(":valor", $datos["valor"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_precarga", $datos["id_precarga"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MODIFICAR CAMPO DE PRECARGA  ======*/

	/*====================================================
	=            ELIMINAR PRODUCTO PRECARGADO            =
	====================================================*/
	
	static public function mdlEliminarProducto($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {

			return "ok";

		} 

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of ELIMINAR PRODUCTO PRECARGADO  ======*/
}

?>