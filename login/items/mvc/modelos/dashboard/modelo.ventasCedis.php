<?php

class ModeloVentasCedis{

    /*=====================================================
	=            MOSTRAR VENTAS VENDEDOR CEDIS            =
	=====================================================*/
	
	static public function mdlMostrarVentas($tabla, $item, $valor, $vendedor){

		if ($item == "id_cedis_ventas " || $item == "folio") {
 
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_usuario_plataforma = :vendedor");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else if($item == "estado" || $item == "metodo"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_usuario_plataforma = :vendedor ORDER BY fecha ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario_plataforma = :vendedor ORDER BY fecha DESC");
			$stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} 

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR VENTAS VENDEDOR CEDIS  ======*/ 
	/*=====================================================
	=           MOSTRAR VENTAS Y SUMA DEVOLUCIONES        =
	=====================================================*/
	
	static public function mdlMostrarVentasYSuma($tabla, $item, $valor, $empresa){

		 
		$stmt = Conexion::conectar()->prepare("SELECT cv.*, (SELECT SUM(monto) FROM devoluciones WHERE id_empresa = :id_empresa AND folio = :folio) AS cantdev 
											   FROM cedis_ventas as cv WHERE id_empresa = :id_empresa AND folio = :folio");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();

		

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR VENTAS Y SUMA DEVOLUCIONES  ======*/ 

	/*============================================================================= 
	=                   MOSTRAR TODAS LAS VENTAS DE LA EMPRESA                    =
	=============================================================================*/
	static public function mdlMostrarVentasEmpresa($tabla, $item, $valor, $empresa){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa ORDER BY fecha ASC");
		
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	
	/*============  End of MOSTRAR TODAS LAS VENTAS DE LA EMPRESA   =============*/
	/*============================================================================= 
	=                   MOSTRAR TODAS LAS VENTAS DE LA EMPRESA                    =
	=============================================================================*/
	static public function mdlMostrarVentasEmpresaHoy($tabla, $empresa){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE  TO_DAYS(fecha) = TO_DAYS(NOW()) AND id_empresa = :id_empresa ORDER BY fecha ASC");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	
	/*============  End of MOSTRAR TODAS LAS VENTAS DE LA EMPRESA   =============*/
	/*====================================================================================== 
	=                   MOSTRAR TODAS LAS VENTAS DE LA EMPRESA X CLIENTE                   =
	======================================================================================*/
	static public function mdlMostrarVentasEmpresaxCliente($tabla, $item, $valor, $empresa){
		
		// $stmt = Conexion::conectar()->prepare("SELECT cv.id_empresa, cv.id_usuario_plataforma, cv.estado, cv.id_cliente, cv.metodo,cv.folio, SUM(cv.total), ce.nombre, 
		// (SELECT SUM(cvp.monto) FROM cedis_ventas_pagos as cvp 
		// INNER JOIN cedis_ventas as cvs ON cvs.folio = cvp.folio 
		// WHERE cvp.estado = 'pagado' AND cvs.estado = 'Pendiente'
		// GROUP BY cvs.id_cliente, cvs.id_empresa 
		// HAVING cvs.id_cliente = cv.id_cliente) as MontoCVP, 
		// (SELECT SUM(d.monto) FROM devoluciones as d 
		// WHERE d.id_cedis_venta = cv.folio) as devolucion 
		// FROM cedis_ventas as cv 
		// INNER JOIN clientes_empresa as ce ON ce.id_cliente = cv.id_cliente 
		// GROUP BY id_cliente, estado, metodo 
		// HAVING cv.estado = 'Pendiente' AND cv.id_empresa=:id_empresa");

		$stmt = Conexion::conectar()->prepare("SELECT * FROM ventas_pagos_clientes WHERE id_empresa=:id_empresa");
		
		//$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	
	/*============  End of MOSTRAR TODAS LAS VENTAS DE LA EMPRESA X CLIENTE  =============*/
	

	/*==================================================
	=            MOSTRAR VENTAS TV LINK-PAGO           =
	==================================================*/
	static public function mdlMostrarVentasEnTVLinkPago($tabla, $item, $valor, $vendedor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_usuario_plataforma = :id_usuario_plataforma");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $vendedor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*============  End of MOSTRAR VENTAS TV LINK-PAGO   =============*/

	/*===================================================================================
	=                   MOSTRAR CANTIDAD DE PEDIDOS/VENTAS POR ESTADO                   =
	===================================================================================*/
	
	static public function mdlMostrarCantidadPedidosPorEstado($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT estado, COUNT(*) as cantidad FROM $tabla WHERE $item = :$item
																				GROUP BY estado");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR CANTIDAD DE PEDIDOS/VENTAS POR ESTADO  =============*/

	/*========================================================================
	=                   MOSTRAR PEDIDOS LINK WEB DATATABLE                   =
	========================================================================*/
	
	static public function mdlMostrarPedidosLinkWebDT($item,$valor){

		if ($item == "id_usuario_plataforma") {

			$stmt = Conexion::conectar()->prepare("SELECT c.nombre, vc.*
													FROM cedis_ventas as vc, clientes_empresa as c
													WHERE vc.$item = :$item
													AND vc.id_cliente = c.id_cliente
													AND vc.metodo = 'Link'
													AND (vc.estado = 'En preparacion'
													OR vc.estado = 'En guia'
													OR vc.estado = 'Listo en sucursal')
													ORDER BY fecha");
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT c.nombre AS cliente, vc.*, up.nombre AS vendedor
													FROM cedis_ventas as vc, clientes_empresa as c, usuarios_plataforma AS up
													WHERE vc.$item = :$item
													AND vc.id_cliente = c.id_cliente
													AND vc.id_usuario_plataforma = up.id_usuario_plataforma
													AND vc.metodo = 'Link'
													AND vc.estado != 'Cancelada'
													AND (vc.estado != 'Enviado' AND vc.estado != 'Entregado')
													ORDER BY fecha");
		}

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR PEDIDOS LINK WEB DATATABLE  =============*/

	/*==========================================================================
	=                   MOSTRAR VENTAS FINALIZADAS DATATABLE                   =
	==========================================================================*/
	
	static public function mdlMostrarVentasLWFinalizadasDT($item,$valor){

		if ($item == "id_usuario_plataforma") {
			
			$stmt = Conexion::conectar()->prepare("SELECT c.nombre, vc.*
													FROM cedis_ventas as vc, clientes_empresa as c
													WHERE vc.$item = :$item
													AND vc.id_cliente = c.id_cliente
													AND (vc.estado = 'Enviado' OR vc.estado = 'Entregado')");
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT c.nombre AS cliente, vc.*,up.nombre AS vendedor
													FROM cedis_ventas AS vc, clientes_empresa AS c, usuarios_plataforma AS up
													WHERE vc.$item = :$item
													AND vc.id_cliente = c.id_cliente
													AND vc.id_usuario_plataforma = up.id_usuario_plataforma
													AND (vc.estado = 'Enviado' OR vc.estado = 'Entregado')");
		}

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR VENTAS FINALIZADAS DATATABLE   =============*/

	

	/*======================================================
	=                   ACTUALIZAR VENTA                   =
	======================================================*/
	
	static public function mdlActualizarComprobanteLink($tabla,$datos){

		if ($datos["pago_tarjeta"] !== NULL) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET comprobante = :comprobante, estado = :estado, fecha_aprobacion = :fecha_aprobacion
												WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");
		
			$stmt -> bindParam(":comprobante",$datos["comprobante"],PDO::PARAM_STR);
			$stmt -> bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
			$stmt -> bindParam(":fecha_aprobacion",$datos["fecha_aprobacion"],PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario_plataforma",$datos["vendedor"],PDO::PARAM_STR);
			$stmt -> bindParam(":folio",$datos["folio"],PDO::PARAM_STR);
		}else if ($datos["comprobante"] !== NULL) {

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, comprobante = :comprobante
												WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");
		
			$stmt -> bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
			$stmt -> bindParam(":comprobante",$datos["comprobante"],PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario_plataforma",$datos["vendedor"],PDO::PARAM_STR);
			$stmt -> bindParam(":folio",$datos["folio"],PDO::PARAM_STR);

		}else if($datos["fecha_aprobacion"] !== NULL){
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, fecha_aprobacion = :fecha_aprobacion
												WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");
		
			$stmt -> bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
			$stmt -> bindParam(":fecha_aprobacion",$datos["fecha_aprobacion"],PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario_plataforma",$datos["vendedor"],PDO::PARAM_STR);
			$stmt -> bindParam(":folio",$datos["folio"],PDO::PARAM_STR);

		}else if ($datos["fecha_regresar_aprobacion"] !== NULL){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 'Por valorar', fecha_aprobacion = NULL
												WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");

			$stmt -> bindParam(":id_usuario_plataforma",$datos["vendedor"],PDO::PARAM_STR);
			$stmt -> bindParam(":folio",$datos["folio"],PDO::PARAM_STR);
		
		}else if($datos["fecha_finalizar_link"] !== NULL){
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, fecha_finalizar_link = :fecha_finalizar_link
												WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");
		
			$stmt -> bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
			$stmt -> bindParam(":fecha_finalizar_link",$datos["fecha_finalizar_link"],PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario_plataforma",$datos["vendedor"],PDO::PARAM_STR);
			$stmt -> bindParam(":folio",$datos["folio"],PDO::PARAM_STR);
		}else{
			
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado
													WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");
		
			$stmt -> bindParam(":id_usuario_plataforma",$datos["vendedor"],PDO::PARAM_STR);
			$stmt -> bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
			$stmt -> bindParam(":folio",$datos["folio"],PDO::PARAM_STR);
		}
		

		if($stmt -> execute()){
			return "ok";
		}else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of ACTUALIZAR VENTA  =============*/

	static public function mdlDesaprobarComprobanteLinkWeb($vendedor, $folio){
		$stmt = Conexion::conectar()->prepare("UPDATE cedis_ventas SET comprobante = NULL, estado = 'Sin comprobante'
												WHERE id_usuario_plataforma = :id_usuario_plataforma AND folio = :folio");
		
		$stmt -> bindParam(":id_usuario_plataforma",$vendedor,PDO::PARAM_STR);
		$stmt -> bindParam(":folio",$folio,PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/*===================================================
	=            MOSTRAR VENTAS DEL VENDEDOR            =
	===================================================*/
	
	static public function mdlMostrarVentasVendedor($tabla, $datos){

		if ($datos["fecha"] != NULL) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario_plataforma = :id_usuario_plataforma AND DATE(fecha_aprobacion) = :fecha AND id_empresa = :id_empresa ORDER BY fecha_aprobacion DESC");

			$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
			$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa ORDER BY fecha DESC");
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		}

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR VENTAS DEL VENDEDOR  ======*/

	/*================================================================
	=                   MOSTRAR VENTAS PAGOS CEDIS                   =
	================================================================*/
	
	static public function mdlMostrarVentasPagos($vendedor){

		$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha, v.id_empresa, c.telefono, v.id_usuario_plataforma
													FROM cedis_ventas as v, clientes_empresa as c 
													WHERE v.id_usuario_plataforma = :vendedor
													AND v.metodo = 'Pagos'
													AND estado = 'Pendiente'
													AND c.id_cliente = v.id_cliente");
		$stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR VENTAS PAGOS CEDIS  =============*/

	/*===================================================
	=            MOSTRAR DETALLES DEL PEDIDO            =
	===================================================*/
	
	static public function mdlMostrarDetallesVenta($datos){

		$stmt = Conexion::conectar()->prepare("SELECT v.*, p.codigo, p.nombre, p.sku 
												FROM cedis_venta_detalles as v, productos as p 
												WHERE p.id_producto = v.id_producto 
												AND v.folio = :folio 
												AND v.id_empresa = :id_empresa
												AND v.id_usuario_plataforma = :vendedor");

		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR DETALLES DEL PEDIDO  ======*/
	/*===========================================================================
	=            MOSTRAR DETALLES DEL PEDIDO  con suma de devoluciones          =
	===========================================================================*/
	
	static public function mdlMostrarDetallesVentaYDev($datos){

		$stmt = Conexion::conectar()->prepare("SELECT v.*, p.codigo, p.nombre, p.sku, (SELECT SUM(cantidad) FROM devoluciones WHERE id_empresa = :id_empresa AND folio = :folio AND id_producto = v.id_producto) AS cantdev 
												FROM cedis_venta_detalles as v, productos as p 
												WHERE p.id_producto = v.id_producto 
												AND v.folio = :folio 
												AND v.id_empresa = :id_empresa");

		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR DETALLES DEL PEDIDO con suma de devoluciones ======*/

	/*=========================================
	=            CREAR NUEVA VENTA            =
	=========================================*/
	
	static public function mdlCrearVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, 
																	id_usuario_plataforma, 
																	id_cliente, 
																	folio, 
																	total, 
																	metodo, 
																	folio_pago_tarjeta, 
																	estado,
																	fecha_aprobacion, 
																	entrega_producto,
																	envio,
																	id_domicilio) 
														VALUES(:id_empresa, 
																:id_usuario_plataforma, 
																:id_cliente, 
																:folio, 
																:total, 
																:metodo, 
																:folio_pago_tarjeta, 
																:estado,
																:fecha_aprobacion, 
																:entrega_producto,
																:envio,
																:id_domicilio)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt -> bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio_pago_tarjeta", $datos["folio_pago_tarjeta"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_aprobacion", $datos["fecha_aprobacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":entrega_producto", $datos["entrega_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":envio", $datos["envio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_domicilio", $datos["id_domicilio"], PDO::PARAM_STR);


		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR NUEVA VENTA  ======*/

	/*==============================================
	=            CREAR DETALLE DE VENTA            =
	==============================================*/
	
	static public function mdlCrearDetalle($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, id_usuario_plataforma, folio, id_producto, cantidad, costo, precio, monto, utilidad) 
												VALUES (:id_empresa, :id_usuario_plataforma,  :folio, :id_producto, :cantidad, :costo, :precio, :monto, :utilidad)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt -> bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR DETALLE DE VENTA  ======*/

	/*=========================================================
	=            SOLICITUD DE CANCELACION DE VENTA            =
	=========================================================*/
	
	static public function mdlVentaCancelar($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, notaCancelacion = :notaCancelacion 
												WHERE folio = :folio AND id_empresa = :id_empresa AND id_usuario_plataforma = :id_usuario");

		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":notaCancelacion", $datos["notaCancelacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/* *********************************************************************** */

	static public function mdlVentaCancelarDefinitivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE folio = :folio 
												AND id_empresa = :id_empresa AND id_usuario_plataforma = :vendedor");
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/*=====  End of SOLICITUD DE CANCELACION DE VENTA  ======*/
	/* *********************************************************************** */

	static public function mdlVentaCancelarpordevolucion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, notaCancelacion = :notaCancelacion WHERE folio = :folio 
												AND id_empresa = :id_empresa");
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":notaCancelacion", $datos["notaCancelacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/*=====  End of CANCELACION DE VENTA POR DEVOLUCION  ======*/

	/*=====================================================================
	=            RETORNO DE STOCK DEL PRODUCTO POR CANCELACION            =
	=====================================================================*/
	
	static public function mdlRetornoProductoCancelacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible + :stock_disponible 
												WHERE id_producto = :id_producto AND id_empresa = :id_empresa");
		
		$stmt -> bindParam(":stock_disponible", $datos["stock_disponible"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;


	}
	
	/*=====  End of RETORNO DE STOCK DEL PRODUCTO POR CANCELACION  ======*/

	/*=================================================================
	=             MOSTRAR MONTO TOTAL  DEL DIA POR ESTADO             =
	=================================================================*/
	
	static public function mdlCorteDia($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) FROM $tabla 
												WHERE id_empresa = :id_empresa
												AND id_usuario_plataforma = :vendedor 
												AND  (estado != 'Cancelada') AND (estado != 'Sin comprobante')
												AND estado != 'Por Cancelar' 
												AND DATE(fecha_aprobacion) = :fecha 
												AND metodo = :metodo");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR MOSTRAR MONTO TOTAL  DEL DIA POR ESTADO  ======*/

	/*===================================================================
	=            MOSTRAR MONTO TOTAL DEL DIA FINAL SIN PAGOS            =
	===================================================================*/
	
	static public function mdlCorteDiaFinal($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT ROUND( SUM(total), 2) FROM $tabla
												WHERE id_empresa = :id_empresa 
												AND  (estado != 'Cancelada') AND (estado != 'Sin comprobante') 
												AND DATE(fecha_aprobacion) = :fecha
												AND metodo != 'Pagos'");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DEL DIA FINAL SIN PAGOS  ======*/

	/*==============================================================
	=            MOSTRAR MONTO TOTAL DEL DIA SOLO PAGOS            =
	==============================================================*/
	
	static public function mdlCorteDiaPagosFinal($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT ROUND( SUM(monto), 2) FROM $tabla
												WHERE id_empresa = :id_empresa 
												AND  (estado != 'Desaprobado') AND (estado != 'Cancelado') 
												AND DATE(fecha_pago) = :fecha");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DEL DIA SOLO PAGOS  ======*/

	/*==============================================================================
	=                   ACTUALIZAR TODO EL CORTE DE CAJA CEDIS                   =
	==============================================================================*/
	
	static public function mdlActualizarCorteDia($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = :total, fecha = :fecha, estado = 'Pendiente'
                                                WHERE id_cedis_ventas_corte = :id_corte");
        
        $stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        $stmt -> close();
        $stmt = null;
    }

	/*============  End of ACTUALIZAR TODO EL CORTE DE CAJA CEDIS  =============*/

	/*===========================================
	=            CREAR CORTE DE CAJA            =
	===========================================*/
	
	static public function mdlCrearCorteCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_usuario_plataforma, total, fecha) 
													VALUES(:id_empresa, :id_usuario_plataforma, :total, :fecha)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR CORTE DE CAJA  ======*/

	/*=============================================================
	=            ACTUALIZAR CORTE CAJA UNA VEZ APROBADO           =
	=============================================================*/
	
	static public function mdlActualizarCorteDiaAprobado($tabla, $datos){

		if ($datos["montoSuma"] !== null) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = total + :monto, fecha = :fecha
													WHERE id_cedis_ventas_corte = :id_corte
													AND (estado != 'Desaprobado')");
			
			$stmt -> bindParam(":monto", $datos["montoSuma"], PDO::PARAM_STR);
			$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);
		}else {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = total - :monto, fecha = :fecha
													WHERE id_cedis_ventas_corte = :id_corte
													AND (estado != 'Desaprobado')");
			
			$stmt -> bindParam(":monto", $datos["montoResta"], PDO::PARAM_STR);
			$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);
		}

        if ($stmt -> execute()) {
            return "ok";
        }else{
			return "error";
		}

        $stmt -> close();
        $stmt = null;
	}
	
	/*=====  End of ACTUALIZAR CORTE CAJA UNA VEZ APROBADO  ======*/

	/*==========================================================
	=            MOSTRAR CORTE O CORTES DE EMPRESA            =
	==========================================================*/
	
	static public function mdlMostrarCortesCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
		
	}

	/* MOSTRAR CORTES DE CAJA (SOLO EL DEL DÍA)
	-------------------------------------------------- */
	static public function mdlMostrarCortesVentasCedisDia($tabla, $datos){
		$stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE DATE(fecha) = :fecha AND id_empresa = :id_empresa AND id_usuario_plataforma = :id_usuario_plataforma");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"]);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["vendedor"]);
		$stmt -> bindParam(":fecha", $datos["fecha"]);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CORTE O CORTES DE EMPRESA  ======*/

	/*====================================================
	=            APROBACION DE CORTES DE CAJA            =
	====================================================*/
	
	static public function mdlAprobacionCorteCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_cedis_ventas_corte = :id_cedis_ventas_corte");
		$stmt -> bindPARAM(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindPARAM(":id_cedis_ventas_corte", $datos["id_cedis_ventas_corte"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of APROBACION DE CORTES DE CAJA  ======*/

	/*===========================================================================================
	=                   MOSTRAR LOS PAGOS DE VENTAS A PAGOS EN VENTAS DEL DIA                   =
	===========================================================================================*/
	
	static public function mdlMostrarVentasPagosCorteDia($datos){
		$stmt = Conexion::conectar()->prepare("SELECT cvp.*, cv.id_cliente
												FROM cedis_ventas_pagos AS cvp, cedis_ventas AS cv
												WHERE cv.id_empresa = :empresa
												AND cv.id_usuario_plataforma = :vendedor
												AND DATE(cvp.fecha_pago) = :fecha
												AND cvp.folio = cv.folio");
		
		$stmt -> bindPARAM(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt -> bindPARAM(":vendedor", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindPARAM(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->execute();

		return  $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR LOS PAGOS DE VENTAS A PAGOS EN VENTAS DEL DIA  =============*/

	/*=========================================================================
	=            MOSTRAR PAGOS CANCELADOS / DESAPROBADOS DATA TABLE            =
	=========================================================================*/
	
	static public function mdlMostrarPagosCanceladosDesaprobados($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
												WHERE folio = :folio
												AND (estado = 'Desaprobado' || estado = 'Cancelado')
												AND id_usuario_plataforma = :id_usuario_plataforma");
		$stmt -> bindParam(":id_usuario_plataforma", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE   ======*/
	/*=========================================================================
	=            MOSTRAR PAGOS CANCELADOS / DESAPROBADOS DATA TABLE            =
	=========================================================================*/
	
	static public function mdlMostrarPagosCanceladosDesaprobadosTodos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
												WHERE folio = :folio
												AND (estado = 'Desaprobado' || estado = 'Cancelado')
												AND id_usuario_plataforma = :id_usuario_plataforma");
		$stmt -> bindParam(":id_usuario_plataforma", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE   ======*/


//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********** CEDIS VENTAS PAGOS  ************************************************************

	static public function mdlMostrarPagos($tabla,$datos,$empresa){

		if ($datos["folio"] !== null) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa
												AND DATE(fecha_pago) = :fecha_pago AND estado != 'Desaprobado' AND folio = :folio");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha_pago", $datos["fecha"], PDO::PARAM_STR);
			$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
			$stmt -> execute();
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa
													AND DATE(fecha_pago) = :fecha_pago AND estado != 'Desaprobado'");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha_pago", $datos["fecha"], PDO::PARAM_STR);
			$stmt -> execute();
		}
		
		

		return $stmt -> fetchAll();
		
		$stmt -> close();
		$stmt = NULL; 
	}


	/*=====================================================================
	=                   MOSTRAR VENTAS PAGOS DATA TABLE                   =
	=====================================================================*/
	
	static public function mdlMostrarVentasPagosDataTable($tabla,$datos){
		

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
												WHERE id_empresa = :id_empresa 
												AND folio = :folio 
												AND estado != 'Desaprobado' 
												AND estado != 'Cancelado'");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> execute();
		

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;
	}
	
	
	/*============  End of MOSTRAR VENTAS PAGOS DATA TABLE  =============*/
	/*=================================================================================
	=                   MOSTRAR VENTAS PAGOS DATA TABLE POR CLIENTE                   =
	=================================================================================*/
	
	static public function mdlMostrarVentasPagosCliente($datos,$metodo,$estado){
		

		$stmt = Conexion::conectar()->prepare("SELECT cv.folio,cv.total,cv.fecha, cv.id_cliente,
		(SELECT SUM(d.monto) FROM devoluciones as d 
		 WHERE d.folio = cv.folio) as devolucion,
		 (SELECT SUM(cvp.monto) FROM cedis_ventas_pagos as cvp 
		 WHERE cvp.folio = cv.folio AND cvp.estado='pagado' ) as pagos
		FROM cedis_ventas as cv 
		WHERE cv.id_empresa = :id_empresa AND cv.id_cliente = :id_cliente AND cv.metodo =:metodo AND cv.estado = :estado");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":metodo", $metodo, PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt -> execute();
		

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;
	}
	
	
	/*============  End of MOSTRAR VENTAS PAGOS DATA TABLE POR CLIENTE  =============*/

	/*=================================================================================
	=                            MOSTRAR VENTAS PAGOS FOLIO MODAL                     =
	=================================================================================*/
	
	static public function mdlMostrarVentasPagosfolio($datos,$metodo,$estado){
		

		$stmt = Conexion::conectar()->prepare("SELECT cv.folio,cv.total,cv.fecha, cv.id_cliente,
		(SELECT SUM(d.monto) FROM devoluciones as d 
		 WHERE d.folio = cv.folio) as devolucion,
		 (SELECT SUM(cvp.monto) FROM cedis_ventas_pagos as cvp 
		 WHERE cvp.folio = cv.folio AND cvp.estado = 'pagado' ) as pagos
		FROM cedis_ventas as cv 
		WHERE cv.id_empresa = :id_empresa AND cv.folio = :folio AND cv.metodo =:metodo ");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":metodo", $metodo, PDO::PARAM_STR);
		//$stmt -> bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt -> execute();
		

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = null;
	}
	
	
	/*============   MOSTRAR VENTAS PAGOS FOLIO MODAL  =============*/

	/*==========================================================================
    =                   MOSTRAR TODOS LOS PAGOS DE UNA VENTA                   =
    ==========================================================================*/
    
    static public function mdlMostrarTodosPagosVentas($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
                                                WHERE id_empresa = :id_empresa
                                                AND folio = :folio");
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 
        $stmt -> bindParam(":folio", $datos["folioPedido"], PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();
        $stmt = null;
    }
    /*============  End of MOSTRAR TODOS LOS PAGOS DE UNA VENTA  =============*/

	

	/*=====================================================================
	=                   APROBAR / DESAPROBAR PAGO CEDIS                   =
	=====================================================================*/
	
	static public function mdlActualizarAprobarDesaprobarPago($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_cedis_ventas_pagos = :id_cedis_ventas_pagos");
		$stmt -> bindParam(":estado", $datos["estadoPago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cedis_ventas_pagos", $datos["id_pago"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}else{
			return 'error';
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/*============  End of APROBAR / DESAPROBAR PAGO CEDIS  =============*/

	/*=================================================================
	=                   CANCELAR PAGO VENTA A PAGOS                   =
	=================================================================*/
	
	static public function mdlCancelarPagoVentaPagos($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado 
												WHERE folio = :folio 
												AND id_empresa = :id_empresa 
												AND id_usuario_plataforma = :vendedor");
		
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}else{
			return 'error';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CANCELAR PAGO VENTA A PAGOS  =============*/

	/*=============================================================================================
    =                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
    =============================================================================================*/
    static public function mdlActualizarEstadoPagoVenta($tabla,$folio,$id_empresa){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 'Aprobado' 
                                                WHERE folio = :folio AND id_empresa = :id_empresa");
        
        $stmt -> bindParam(":folio", $folio, PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $id_empresa, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        }

        $stmt -> close();
        $stmt =null;
    }
    
    
    /*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/


	/*==========================================================
	=                   FILTRAR VENTAS PAGOS                   =
	==========================================================*/
	static public function mdlFiltrarPago($datos){

		if ($datos["item"] == "fecha_pago") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha_aprobacion, v.id_empresa, v.id_usuario_plataforma 
													FROM cedis_ventas as v, clientes_empresa as c 
													WHERE DATE(v.fecha_aprobacion) = :fecha 
													AND v.id_empresa = :id_empresa
													AND v.id_usuario_plataforma = :id_usuario
													AND v.metodo = 'Pagos'
													AND c.id_cliente = v.id_cliente");

			$stmt -> bindParam(":fecha", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else if($datos["item"] == "folio"){

			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha_aprobacion, v.id_empresa, v.id_usuario_plataforma  
													FROM cedis_ventas as v, clientes_empresa as c 
													WHERE v.folio = :item 
													AND v.id_empresa = :id_empresa
													AND v.id_usuario_plataforma = :id_usuario
													AND v.metodo = 'Pagos'
													AND c.id_cliente = v.id_cliente");

			$stmt -> bindParam(":item", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else if ($datos["item"] == "cliente") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha_aprobacion, v.id_empresa, v.id_usuario_plataforma 
													FROM cedis_ventas as v, clientes_empresa as c
													WHERE c.nombre LIKE '%".$datos['valor']."%' 
													AND (c.id_cliente = v.id_cliente 
													AND v.id_empresa = :id_empresa
													AND v.id_usuario_plataforma = :id_usuario
													AND v.metodo = 'Pagos')");

			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of FILTRAR VENTAS PAGOS  =============*/


//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********** C O N F I G U R A C I O N ********** V E N T A S ********** P A G O S ***********

	/*=============================================================
	=            MOSTRAR CONFIGURACION DE VENTAS PAGOS            =
	=============================================================*/
	
	static public function mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE VENTAS PAGOS  ======*/

	/*======================================
	=            REGISTRAR PAGO            =
	======================================*/
	
	static public function mdlRealizarPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, id_usuario_plataforma, folio, monto, comprobante, estado) 
													VALUES(:id_empresa, :id_usuario_plataforma, :folio, :monto, :comprobante, :estado)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt -> bindParam(":comprobante", $datos["comprobante"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of REGISTRAR PAGO  ======*/

	/*========================================================
	=            CREAR CONFIGURACION VENTAS PAGOS            =
	========================================================*/
	
	static public function mdlCrearConfiguracionVentasPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, pago_inicial, periodos, promocion_venta) 
													VALUES(:id_empresa, :pago_inicial, :periodos, :promocion_venta)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":pago_inicial", $datos["pago_inicial"], PDO::PARAM_STR);
		$stmt -> bindParam(":periodos", $datos["periodos"], PDO::PARAM_STR);
		$stmt -> bindParam(":promocion_venta", $datos["promocion_venta"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR CONFIGURACION VENTAS PAGOS  ======*/

	/*=========================================================
	=            EDITAR CONFIGURACION VENTAS PAGOS            =
	=========================================================*/
	
	static public function mdlEditarConfiguracionVentasPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET pago_inicial = :pago_inicial, periodos = :periodos, promocion_venta = :promocion_venta
													WHERE id_empresa = :id_empresa");

		$stmt -> bindParam(":pago_inicial", $datos["pago_inicial"], PDO::PARAM_STR);
		$stmt -> bindParam(":periodos", $datos["periodos"], PDO::PARAM_STR);
		$stmt -> bindParam(":promocion_venta", $datos["promocion_venta"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR CONFIGURACION VENTAS PAGOS  ======*/


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
	
	static public function mdlMostrarVentasSinFacturar($tabla, $item, $valor, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND id_empresa = :id_empresa AND factura = 'No' AND (estado = 'Aprobado' OR estado = 'Enviado' OR estado = 'Entregado')");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR); 
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR PEDIDOS DEL MES SIN FACTURAR  ======*/

	/*========================================================
	=            AGRUPACION VENTAS SELECCIONADOS            =
	========================================================*/
	
	static public function mdlMostrarAgrupacionFolios($consulta, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(v.cantidad), SUM(round((v.precio * v.cantidad),2)), p.*, v.precio
												FROM cedis_venta_detalles as v, productos as p 
												WHERE ($consulta) 
												AND v.id_empresa = :id_empresa 
												AND v.id_producto = p.id_producto 
												GROUP BY v.id_producto, v.precio");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of AGRUPACION VENTAS SELECCIONADOS  ======*/

	/*===========================================================
	=            MODIFICACION DE VENTA PARA FACTURA            =
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
	
	/*=====  End of MODIFICACION DE VENTA PARA FACTURA  ======*/

	/*=========================================================================
	=            Contar ventas a pagos activas de cedis                       =
	=========================================================================*/
	
	static public function mdlVentasActivasCedis($tabla,$empresa){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(1) FROM cedis_ventas
												WHERE metodo = 'Pagos' AND
												 id_empresa = :id_empresa AND
												  estado= 'Pendiente'");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Contar ventas a pagos activas de cedis   ======*/
		/*==========================================================
	=                   FILTRAR VENTAS PAGOS                   =
	==========================================================*/
	static public function mdlFiltrarVenta($datos){

		if ($datos["item"] == "fecha_pago") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.fecha_aprobacion, v.metodo, v.id_empresa, v.total   
													FROM cedis_ventas as v, clientes_empresa as c 
													WHERE DATE(v.fecha_aprobacion) = :fecha 
													AND v.id_empresa = :id_empresa
													AND c.id_cliente = v.id_cliente
													AND v.estado != 'Cancelada'");

			$stmt -> bindParam(":fecha", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else if($datos["item"] == "folio"){

			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.fecha_aprobacion, v.metodo, v.id_empresa, v.total 
													FROM cedis_ventas as v, clientes_empresa as c 
													WHERE v.folio = :item 
													AND v.id_empresa = :id_empresa
													AND c.id_cliente = v.id_cliente");

			$stmt -> bindParam(":item", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else if ($datos["item"] == "cliente") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.fecha_aprobacion, v.metodo, v.id_empresa, v.total  
													FROM cedis_ventas as v, clientes_empresa as c
													WHERE c.nombre LIKE '%".$datos['valor']."%' 
													AND (c.id_cliente = v.id_cliente 
													AND v.id_empresa = :id_empresa)");

			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of FILTRAR VENTAS PAGOS  =============*/

	/*===================================================
	=   MOSTRAR DETALLES DE Venta Devolucion            =
	===================================================*/
	
	static public function mdlMostrarDetallesVentaDev($datos){


		$stmt = Conexion::conectar()->prepare("SELECT v.*, p.codigo, p.nombre, p.sku, (SELECT SUM(cantidad) FROM devoluciones WHERE id_producto = v.id_producto AND folio = v.folio) AS cantdev
												FROM cedis_venta_detalles v  
												INNER JOIN productos  p on p.id_producto = v.id_producto AND v.folio = :folio AND v.id_empresa = :id_empresa
												");


		// $stmt = Conexion::conectar()->prepare("SELECT v.*, p.codigo, p.nombre, p.sku 
		// 										FROM cedis_venta_detalles as v, productos as p 
		// 										WHERE p.id_producto = v.id_producto 
		// 										AND v.folio = :folio 
		// 										AND v.id_empresa = :id_empresa");

		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR DETALLES DE Venta Devolucion  ======*/

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	//  ------------------------ MODELOS DE CONFIGURACION GENERAL DE VENTAS ----------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------

	static public function mdlMostrarConfiguracionGeneralVentas($tabla,$empresa){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();
		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}

	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	//  ----------------------- MODELOS DE MODULO DE FACTURACION VENTAS PAGOS---------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------

	/*=======================================================================
	=                   MOSTRAR VENTAS PAGOS SIN FACTURAR                   =
	=======================================================================*/
	
	static public function mdlMostrarVentasPagosSinFacturar($empresa, $consulta){

		if($consulta == "todas"){
			$stmt = Conexion::conectar()->prepare("SELECT ce.nombre, cv.* FROM cedis_ventas as cv, clientes_empresa as ce WHERE cv.id_cliente = ce.id_cliente AND cv.id_empresa = :id_empresa AND cv.metodo = 'Pagos' AND cv.factura = 'No' AND cv.estado != 'Cancelada'");

		}else{
			$stmt = Conexion::conectar()->prepare("SELECT ce.nombre, cv.* FROM cedis_ventas AS cv, clientes_empresa AS ce WHERE $consulta AND cv.id_cliente = ce.id_cliente AND cv.id_empresa = :id_empresa AND cv.metodo = 'Pagos' AND cv.factura = 'No' AND cv.estado != 'Cancelada'");

		}
		
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;


	}
	
	/*============  End of MOSTRAR VENTAS SIN FACTURAR  =============*/

	/*========================================================================
	=                   AGRUPACION PRODUCTOS SELECCIONADOS                   =
	========================================================================*/
	
	static public function mdlMostrarAgrupacionProductos($consulta,$empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM productos WHERE id_empresa = :id_empresa AND (".$consulta.")");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();
		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of AGRUPACION PRODUCTOS SELECCIONADOS  =============*/

	/*===========================================================
	=            MODIFICACION DE PRODUCTO FACTURADO            =
	===========================================================*/

	static public function mdlModificacionProductoFacturado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET factura = :factura WHERE id_cedis_ventas_detalles = :id");
		$stmt -> bindParam(":factura", $datos["factura"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}

	/*============  End of MODIFICACION DE PRODUCTO FACTURADO  =============*/

	/*==============================================================================
	=                   CONTAR PRODUCTOS QUE HAN SIDO FACTURADOS                   =
	==============================================================================*/
	
	static public function mdlContarProductosFacturados($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(factura) AS facturados FROM $tabla WHERE folio = :folio 
												AND id_empresa = :id_empresa AND factura = :factura");
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura", $datos["estadoFactura"], PDO::PARAM_STR);

		$stmt -> execute();
		return $stmt ->fetch();
		

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CONTAR PRODUCTOS QUE HAN SIDO FACTURADOS  =============*/
	
	
	/*==========================================================
	=               FILTRAR TODAS LAS VENTAS                   =
	==========================================================*/
	static public function mdlFiltrarTodasVentas($datos){

		if ($datos["item"] == "Día") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, up.nombre as vendedor, c.nombre as cliente, v.total, v.id_usuario_plataforma, v.fecha, v.metodo, v.estado, v.id_empresa, v.total   
													FROM cedis_ventas as v, clientes_empresa as c, usuarios_plataforma as up 
													WHERE DATE(v.fecha) = :fecha 
													AND v.id_empresa = :id_empresa
													AND c.id_cliente = v.id_cliente
													AND up.id_usuario_plataforma = v.id_usuario_plataforma");

			$stmt -> bindParam(":fecha", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}else if($datos["item"] == "folio"){

			$stmt = Conexion::conectar()->prepare("SELECT v.folio, up.nombre as vendedor, c.nombre as cliente, v.total, v.id_usuario_plataforma, v.fecha, v.metodo, v.estado, v.id_empresa, v.total
													FROM cedis_ventas as v, clientes_empresa as c, usuarios_plataforma as up  
													WHERE v.folio = :item 
													AND v.id_empresa = :id_empresa
													AND c.id_cliente = v.id_cliente
													AND up.id_usuario_plataforma = v.id_usuario_plataforma");

			$stmt -> bindParam(":item", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else if ($datos["item"] == "cliente") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, up.nombre as vendedor, c.nombre as cliente, v.total, v.id_usuario_plataforma, v.fecha, v.metodo, v.estado, v.id_empresa, v.total  
													FROM cedis_ventas as v, clientes_empresa as c, usuarios_plataforma as up  
													WHERE c.nombre LIKE '%".$datos['valor']."%' 
													AND (c.id_cliente = v.id_cliente 
													AND v.id_empresa = :id_empresa)
													AND up.id_usuario_plataforma = v.id_usuario_plataforma");

			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of FILTRAR TODAS LAS VENTAS   =============*/
}
?>