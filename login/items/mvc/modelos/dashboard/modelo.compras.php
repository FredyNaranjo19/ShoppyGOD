<?php

class ModeloCompras{

	/*=====================================================
	=            CREAR COMPRA EN LA PLATAFORMA            =
	=====================================================*/
	
	static public function mdlCrearCompra($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, descripcion, monto, payment_id, preference_id) VALUES(:id_empresa, :descripcion, :monto, :payment_id, :preference_id)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt -> bindParam(":payment_id", $datos["payment_id"], PDO::PARAM_STR);
		$stmt -> bindParam(":preference_id", $datos["preference_id"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of CREAR COMPRA EN LA PLATAFORMA  ======*/
	
	/************************************************************************************/
	/************************************************************************************/
	/************************************************************************************/
	/************************************************************************************/

	/*=====================================================================
	=                   MOSTRAR CONTENIDO DE LA EMPRESA                   =
	=====================================================================*/
	
	static public function mdlMostrarElementosEmpresa($empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM empresas_contenido_sistema WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;		

	}
	
	/*============  End of MOSTRAR CONTENIDO DE LA EMPRESA  =============*/

	/*=========================================================================
	=                   GUARDAR CONTENIDO DE COMPRA ALMACEN                   =
	=========================================================================*/
	
	static public function mdlContenidoCompraAlmacen($empresa){

		$stmt = Conexion::conectar()->prepare("UPDATE empresas_contenido_sistema SET almacenes = almacenes + 1																					 
												WHERE id_empresa = :id_empresa");
		
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of GUARDAR CONTENIDO DE COMPRA ALMACEN  =============*/

	/*==================================================================================
	=                   GUARDAR CONTENIDO DE COMPRA VENDEDOR ALMACEN                   =
	==================================================================================*/
	
	static public function mdlContenidoCompraVendedorAlmacen($empresa){

		$stmt = Conexion::conectar()->prepare("UPDATE empresas_contenido_sistema SET vendedores_almacen = vendedores_almacen + 1 
												WHERE id_empresa = :id_empresa");
		
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of GUARDAR CONTENIDO DE COMPRA VENDEDOR ALMACEN  =============*/


	/*===========================================================================
	=                   MOSTRAR COMPRAS DE VENDEDORES ALMACEN                   =
	===========================================================================*/
	
	static public function mdlMostrarComprasVendedoresAlmacen($item, $valor, $empresa){

		if ($item != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios_plataforma_compras WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios_plataforma_compras WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		}
		

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR COMPRAS DE VENDEDORES ALMACEN  =============*/

	/*==================================================================
	=                   MOSTRAR COMPRAS DE ALMACENES                   =
	==================================================================*/
	
	static public function mdlMostrarComprasAlmacenes($item, $valor, $empresa){

		if ($item != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM almacenes_compras WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM almacenes_compras WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of MOSTRAR COMPRAS DE ALMACENES  =============*/

	/*====================================================================================
	=                   MOSTRAR COMPRAS DE ESPACIOD DE PRODCUTOS EN TV                   =
	====================================================================================*/
	
	static public function mdlMostrarComprasProductosTV($item, $valor, $empresa){

		// $stmt = Conexion::conectar()->prepare("SELECT c.*, p.cantidad, p.precio FROM tv_productos_compras as c,
		// 											tv_productos_espacios_precios as p
		// 										WHERE p.id_tv_productos_espacios_precios = c.id_tv_productos_lista_compras
		// 										AND c.id_empresa = :id_empresa");
		$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos_compras WHERE $item = :$item AND id_empresa = :id_empresa");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);


		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of MOSTRAR COMPRAS DE ESPACIOD DE PRODCUTOS EN TV  =============*/

	/*============================================================
	=                   RENOVAR COMPRA ALMACEN                   =
	============================================================*/
	
	static public function mdlRenovarPagoAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ultimo_pago = :fecha_ultimo_pago, fecha_proximo_pago = :fecha_proximo_pago, estado = 'activo'
												WHERE id_almacenes_compras = :id_almacenes_compras");
		
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacenes_compras", $datos["id_almacenes_compras"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of RENOVAR COMPRA ALMACEN  =============*/

	/*================================================================
	=                   RENOVAR COMPRA DE VENDEDOR                   =
	================================================================*/
	
	static public function mdlRenovarPagoVendedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ultimo_pago = :fecha_ultimo_pago, fecha_proximo_pago = :fecha_proximo_pago, estado = 'activo'
												WHERE id_usuarios_plataforma_compras = :id_usuarios_plataforma_compras");
		
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuarios_plataforma_compras", $datos["id_usuarios_plataforma_compras"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of RENOVAR COMPRA DE VENDEDOR  =============*/
	
	/*================================================================================
	=                   RENOVAR COMPRA DE ESPACIOS DE PRODCUTOS TV                   =
	================================================================================*/
	
	static public function mdlRenovarPagoProductos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ultimo_pago = :fecha_ultimo_pago, fecha_proximo_pago = :fecha_proximo_pago
												WHERE id_tv_productos_compras = :id_tv_productos_compras");
		
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_tv_productos_compras", $datos["id_tv_productos_compras"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of RENOVAR COMPRA DE ESPACIOS DE PRODCUTOS TV  =============*/
	/*=====================================================================
	=                   MOSTRAR Compras creditos                   =
	=====================================================================*/
	
	static public function mdlMostrarComprasCreditos($empresa){

		$stmt = Conexion::conectar()->prepare("SELECT ventas_pagos FROM empresas_contenido_sistema WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;		

	}
	
	/*============  End of MOSTRAR Compras creditos  =============*/

}
?>