<?php

class ModeloEmbarcacion{

	/*=============================================
	=            MOSTRAR EMBARCACIONES            =
	=============================================*/
	
	static public function mdlMostrarEmbarcaciones($tabla, $item, $valor, $empresa){

		if ($item == "id_embarcacion") {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else if ($item == "id_almacen") {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchall();

		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR EMBARCACIONES  ======*/

	/*===================================================
	=            MOSTRAR DETALLE DE EMBARQUE            =
	===================================================*/
	
	static public function mdlMostrarEmbarcacionesDetalle($datos){

		$stmt = Conexion::conectar()->prepare("SELECT e.*, p.nombre, p.caracteristicas FROM embarcacion_detalle as e, productos as p 
												WHERE e.id_almacen = :id_almacen 
												AND e.folio = :folio
												AND e.id_producto = p.id_producto");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR DETALLE DE EMBARQUE  ======*/

	/*==========================================================
	=            MOSTRAR DETALLE DE ENBARQUE SIMPLE            =
	==========================================================*/
	
	static public function mdlMostrarEmbarqueDetalleSimple($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR DETALLE DE ENBARQUE SIMPLE  ======*/
	
	
	
	/*==============================================
	=            CREAR EMBARQUE GENERAL            =
	==============================================*/
	
	static public function mdlCrearEmbarque($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_almacen, folio) VALUES(:id_empresa, :id_almacen, :folio)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR EMBARQUE GENERAL  ======*/

	/*===============================================
	=            CREAR EMBARQUE DETALLES            =
	===============================================*/
	
	static public function mdlCrearEmbarqueDetalle($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_almacen, folio, id_producto, stock, estado) 
													VALUES(:id_almacen, :folio, :id_producto, :stock, :estado)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR EMBARQUE DETALLES  ======*/
	
	/*=========================================================
	=            EDITAR ESTADO DE PRODUCTO CARGADO            =
	=========================================================*/
	
	static public function mdlEditarEstadoDetalleCarga($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_embarcacion_detalle = :id_embarcacion_detalle");
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_embarcacion_detalle", $datos["id_embarcacion_detalle"], PDO::PARAM_STR);

		if ($stmt -> execute()) {

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR ESTADO DE PRODUCTO CARGADO  ======*/
	
	/*============================================================
	=            AGREGAR NOTA DE PROBLEMA DE PRODUCTO            =
	============================================================*/
	
	static public function mdlAgregarNotaProblema($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, nota = :nota 
												WHERE id_embarcacion_detalle = :id_embarcacion_detalle");

		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":nota", $datos["nota"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_embarcacion_detalle", $datos["id_embarcacion_detalle"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of AGREGAR NOTA DE PROBLEMA DE PRODUCTO  ======*/
	
	/*=========================================================
	=                   EMBARQUE RECIDO POR                   =
	=========================================================*/
	
	static public function mdlModificacionRecibidoPor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET recibido = :recibido WHERE id_almacen = :id_almacen AND folio = :folio");
		$stmt -> bindParam(":recibido", $datos["recibido"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of EMBARQUE RECIDO POR  =============*/
}

?>