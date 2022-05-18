<?php

class ModeloPedidos{


	/*===================================================
	=            MOSTRAR DETALLES DEL PEDIDO            =
	===================================================*/
	
	static public function mdlMostrarDetallePedido($tabla,$item,$valor,$empresa){

		$stmt = Conexion::conectar()->prepare("SELECT d.*,p.nombre, p.codigo 
		FROM $tabla as d, productos as p 
		WHERE d.$item = :$item  
		AND d.id_producto = p.id_producto 
		AND d.id_empresa = :id_empresa");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();
 
		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR DETALLES DEL PEDIDO  ======*/

//***********************************************************************************************************
//***********************************************************************************************************
//***********************************************************************************************************

	/*================================================================
	=            MOSTRAR PEDIDOS CON TODA LA INFORMACION             =
	================================================================*/
	
	static public function mdlMostrarPedidosEstados($datos){ //ocupo

		$stmt = Conexion::conectar()->prepare("SELECT p.*, d.* FROM tv_pedidos as p, tv_pedidos_entregas as d 
		WHERE d.estado_entrega = :estado_entrega 
		AND p.folio = d.folio 
		AND p.id_empresa = :id_empresa");

		$stmt -> bindParam(":estado_entrega", $datos["estado_entrega"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchALL();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PEDIDOS CON TODA LA INFORMACION   ======*/

	/*=============================================================================
	=            MOSTRAR PEDIDOS PENDIENTES (METODO DE PAGO: EFECTIVO)            =
	=============================================================================*/
	
	static public function mdlMostrarPedidosPendientesEfectivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE metodo_pago = :metodo_pago AND estado = :estado AND id_empresa = :id_empresa");
		$stmt -> bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR PEDIDOS PENDIENTES (METODO DE PAGO: EFECTIVO)  ======*/

	/*==============================================================
	=            MOSTRAR COMPROBANTE DE PAGO (EFECTIVO)            =
	==============================================================*/
	
	static public function mdlMostrarComprobanteEfectivo($tabla,$item, $valor, $empresa){ //ocupo
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR COMPROBANTE DE PAGO (EFECTIVO)  ======*/

	/*==================================================================
	=            CAMBIO DE ESTADO EN COMPROBANTE (EFECTIVO)            =
	==================================================================*/
	
	static public function mdlModificarEstadoComprobantePagoEfectivo($tabla, $datos){ //ocupo
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE folio = :folio AND id_empresa = :id_empresa");
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CAMBIO DE ESTADO EN COMPROBANTE (EFECTIVO)  ======*/

	/*==========================================================
	=            CAMBIO DE ESTADO EN PEDIDO GENERAL            =
	==========================================================*/
	
	static public function mdlCambioEstadoPedido($tabla, $datos){ //ocupo

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE folio = :folio AND id_empresa = :id_empresa");
		$stmt -> bindParam(":estado", $datos['estado'], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos['folio'], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}
		$stmt -> close(); 
		$stmt = NULL;


	}
	
	/*=====  End of CAMBIO DE ESTADO EN PEDIDO GENERAL  ======*/

	/*==========================================================================
	=            CAMBIO DE ESTADO EN PEDIDO (NUEVO: EN PREPARACION)            =
	==========================================================================*/
	
	static public function mdlModificarEstadoPreparacion($tabla, $datos){ //ocupo

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_entrega = :estado_entrega WHERE folio = :folio AND id_empresa = :id_empresa");
		$stmt -> bindParam(":estado_entrega", $datos["estado_entrega"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CAMBIO DE ESTADO EN PEDIDO (NUEVO: EN PREPARACION)  ======*/

	/*======================================================================================
	=            MODIFICACION DE DATOS POR GENERACION DE GUIA EN PEDIDO_ENTREGA            =
	======================================================================================*/
	
	static public function mdlModificarEstadoGuias($tabla, $datos){ //ocupo

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET paqueteria = :paqueteria, rastreo = :rastreo, estado_entrega = :estado_entrega WHERE folio = :folio AND id_empresa = :id_empresa");
		$stmt -> bindParam(":paqueteria", $datos["paqueteria"], PDO::PARAM_STR);
		$stmt -> bindParam(":rastreo", $datos["rastreo"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado_entrega", $datos["estado_entrega"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MODIFICACION DE DATOS POR GENERACION DE GUIA EN PEDIDO_ENTREGA  ======*/
	
	/*=================================================================================
	=            CAMBIAR ESTADO EN SECCION DE ENTREGAS(ENTREGADO SUCURSAL)            =
	=================================================================================*/
	
	static public function mdlModificarEstadoEntregado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_entrega = :estado_entrega WHERE folio = :folio AND id_empresa = :id_empresa");
		$stmt -> bindParam(":estado_entrega", $datos["estado_entrega"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of CAMBIAR ESTADO EN SECCION DE ENTREGAS(ENTREGADO SUCURSAL)  ======*/

	/*=================================================
	=            MOSTRAR TODAS LOS PEDIDOS            =
	=================================================*/
	
	static public function mdlMostrarPedidosFinalizados($item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT p.*, d.* 
		FROM tv_pedidos as p, tv_pedidos_entregas as d 											WHERE (d.estado_entrega = 'Entregado' OR d.estado_entrega = 'Enviado')
		AND p.folio = d.folio 
		AND p.id_empresa = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR TODAS LOS PEDIDOS  ======*/

	/*==========================================================================
	=            MOSTRAR TODOS LOS PEDIDOS CANCELADOS DE LA EMPRESA            =
	==========================================================================*/
	
	static public function mdlMostrarPedidosCancelados($item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT p.*, d.* 
		FROM tv_pedidos as p, tv_pedidos_entregas as d 
	  	WHERE d.estado_entrega = 'Cancelada'
	  	AND p.folio = d.folio 
	  	AND p.id_empresa = :$item");
		
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR TODOS LOS PEDIDOS CANCELADOS DE LA EMPRESA  ======*/

	/*==========================================================
	=            RETORNAR STOCK DE PEDIDO CANCELADO            =
	==========================================================*/
	
	static public function mdlRetornoProductoCancelacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible + :stock_disponible 
		WHERE id_producto = :id_producto");
		
		$stmt -> bindParam(":stock_disponible", $datos["stock_disponible"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> colse();
		$stmt = NULL;


	}
	
	/*=====  End of RETORNAR STOCK DE PEDIDO CANCELADO  ======*/
	

//***********************************************************************************************************
//***********************************************************************************************************
//***********************************************************************************************************
	// -------------------------------------------------------------------------
	// -------------------------------------------------------------------------
	// -------------------------------------------------------------------------
	//  -------------------- MODELOS DE MODULO DE FACTURACION ------------------
	// -------------------------------------------------------------------------
	// -------------------------------------------------------------------------
	// -------------------------------------------------------------------------

	/*============================================================
	=            MOSTRAR PEDIDOS DEL MES SIN FACTURAR            =
	============================================================*/
	
	static public function mdlMostrarPedidosSinFacturar($tabla, $item, $valor, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND id_empresa = :id_empresa AND factura = 'No'");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR); 
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PEDIDOS DEL MES SIN FACTURAR  ======*/

	/*========================================================
	=            AGRUPACION PEDIDOS SELECCIONADOS            =
	========================================================*/
	
	static public function mdlMostrarAgrupacionFolios($consulta, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(d.cantidad), SUM(d.costo * d.cantidad), p.*, d.costo
		FROM tv_pedidos_detalle as d, productos as p 
		WHERE ($consulta) 
		AND d.id_empresa = :id_empresa 
		AND d.id_producto = p.id_producto 
		GROUP BY d.id_producto, d.costo");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of AGRUPACION PEDIDOS SELECCIONADOS  ======*/

	/*===========================================================
	=            MODIFICACION DE PEDIDO PARA FACTURA            =
	===========================================================*/
	
	static public function mdlModificacionFactura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET factura = :factura WHERE folio = :folio AND id_empresa = :id_empresa");
		$stmt -> bindParam(":factura", $datos["factura"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MODIFICACION DE PEDIDO PARA FACTURA  ======*/
}



?>