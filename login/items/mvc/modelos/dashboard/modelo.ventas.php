<?php

class ModeloVentas{

	/*======================================
	=            MOSTRAR VENTAS            =
	======================================*/
	
	static public function mdlMostrarVentas($tabla, $item, $valor, $almacen){

		if ($item == "id_ventas" || $item == "folio") {
 
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_almacen = :id_almacen");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else if($item == "estado" || $item == "metodo"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_almacen = :id_almacen ORDER BY fecha ASC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen ORDER BY fecha DESC");
			$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} 

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR VENTAS  ======*/ 

	/*====================================================================
	=                   MOSTRAR VENTAS POR SKU ALMACEN                   =
	====================================================================*/
	
	static public function mdlMostrarVentasPorSKUAlmacen($datos){
		$stmt = Conexion::conectar()->prepare("SELECT p.codigo, vd.* FROM ventas_detalle as vd, ventas as v, productos as p
												WHERE v.folio = vd.folio AND vd.id_producto = p.id_producto AND p.sku = :sku AND v.fecha >= :fecha");
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of MOSTRAR VENTAS POR SKU ALMACEN  =============*/

	/*=================================================================================
	=                   EDITAR COSTO UTILIDAD DETALLE VENTA ALMACEN                   =
	=================================================================================*/
	
	static public function mdlEditarCostoUtilidadDetalleVenta($tabla,$datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET costo= :costo, utilidad = :utilidad WHERE id_detalle = :id_detalle");
		$stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt -> bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_detalle", $datos["id_detalle"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		} 

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of EDITAR COSTO UTILIDAD DETALLE VENTA ALMACEN  =============*/

	/*==================================================
	=            MOSTRAR VENTAS DEL CLIENTE            =
	==================================================*/
	
	static public function mdlMostrarVentasCliente($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND estado != 'Pendiente' AND estado != 'Sin comprobante' AND estado != 'Cancelada' ORDER BY folio");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR VENTAS DEL CLIENTE  ======*/
	

	/*====================================================
	=            MOSTRAR VENTAS PAGOS ALMACEN            =
	====================================================*/
	
	static public function mdlMostrarVentasPagosAlmace($almacen){

		$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha, v.id_almacen, c.telefono
													FROM ventas as v, clientes_empresa as c 
													WHERE v.id_almacen = :id_almacen
													AND v.metodo = 'Pagos'
													AND v.estado != 'Cancelada' AND v.estado != 'Aprobado'
													AND c.id_cliente = v.id_cliente");
		$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR VENTAS PAGOS ALMACEN  ======*/
	

	/*=========================================
	=            CREAR NUEVA VENTA            =
	=========================================*/
	
	static public function mdlCrearVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_almacen, 
																	id_usuario_plataforma, 
																	id_cliente, 
																	folio, 
																	total, 
																	metodo, 
																	folio_pago_tarjeta, 
																	estado, 
																	entrega_producto,
																	envio,
																	id_domicilio) 
														VALUES(:id_almacen, 
																:id_usuario_plataforma, 
																:id_cliente, 
																:folio, 
																:total, 
																:metodo, 
																:folio_pago_tarjeta, 
																:estado, 
																:entrega_producto,
																:envio,
																:id_domicilio)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt -> bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio_pago_tarjeta", $datos["folio_pago_tarjeta"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
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

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_almacen, folio, id_producto, cantidad, costo, precio, monto, utilidad) 
												VALUES (:id_almacen, :folio, :id_producto, :cantidad, :costo, :precio, :monto, :utilidad)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
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

	/*===================================================
	=            MOSTRAR VENTAS DEL VENDEDOR            =
	===================================================*/
	
	static public function mdlMostrarVentasVendedor($tabla, $datos){

		if ($datos["fecha"] != NULL) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario_plataforma = :id_usuario_plataforma AND DATE(fecha) = :fecha AND id_almacen = :id_almacen ORDER BY fecha DESC");

			$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
			$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen ORDER BY fecha DESC");
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		}

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR VENTAS DEL VENDEDOR  ======*/

	/*===================================================
	=            MOSTRAR DETALLES DEL PEDIDO            =
	===================================================*/
	
	static public function mdlMostrarDetallesVenta($datos){

		$stmt = Conexion::conectar()->prepare("SELECT v.*, p.codigo, p.nombre 
												FROM ventas_detalle as v, productos as p 
												WHERE p.id_producto = v.id_producto 
												AND v.folio = :folio 
												AND v.id_almacen = :id_almacen");

		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR DETALLES DEL PEDIDO  ======*/

	/*=============================================================
	=            MOSTRAR VENTAS SIN FACURAR DE ALMACEN            =
	=============================================================*/
	
	static public function ctrMostrarVentasSinFacturar($tabla, $item, $valor, $almacen){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item 
													AND id_almacen = :id_almacen 
													AND estado = 'Aprobado' 
													AND factura = 'No'");
		
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR VENTAS SIN FACURAR DE ALMACEN  ======*/

	/*========================================================
	=            AGRUPACION VENTAS SELECCIONADOS            =
	========================================================*/
	
	static public function mdlMostrarAgrupacionFolios($consulta, $almacen){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(v.cantidad), SUM(v.precio * v.cantidad), p.*, v.precio
												FROM ventas_detalle as v, productos as p 
												WHERE ($consulta) 
												AND v.id_almacen = :id_almacen 
												AND v.id_producto = p.id_producto 
												GROUP BY v.id_producto, v.precio");
		$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
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

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET factura = :factura WHERE folio = :folio AND id_almacen = :id_almacen");
		$stmt -> bindParam(":factura", $datos["factura"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MODIFICACION DE VENTA PARA FACTURA  ======*/
	

//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//**************************************   C O R T E S   **************************************

	/*=============================================
	=            MOSTRAR CORTE DE CAJA            =
	=============================================*/
	
	static public function mdlMostrarCorte($tabla, $item, $valor, $item2, $valor2, $rol){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2 AND rol = :rol");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		$stmt -> bindParam(":rol", $rol, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CORTE DE CAJA  ======*/

	/*==========================================================
	=            MOSTRAR CORTE O CORTES DE EMPRESA            =
	==========================================================*/
	
	static public function mdlMostrarCortesCaja($tabla, $datos){

		if ($datos["id_almacen"] != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen Limit 20");
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		}

		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
		
	}

	/* MOSTRAR CORTES DE CAJA (SOLO LOS DEL DÍA)
	-------------------------------------------------- */
	static public function mdlMostrarCortesVentasDia($tabla, $datos){
		$stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE DATE(fecha) = :fecha AND id_almacen = :id_almacen");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"]);
		$stmt -> bindParam(":fecha", $datos["fecha"]);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CORTE O CORTES DE EMPRESA  ======*/

	/*============================================================
	=            MOSTRAR MONTO TOTAL DE CORTE DEL DIA            =
	============================================================*/
	
	static public function mdlCorteDia($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) FROM $tabla 
												WHERE id_usuario_plataforma = :id_usuario_plataforma 
												AND (estado = 'Aprobado') 
												AND DATE(fecha) = :fecha 
												AND metodo = :metodo");

		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":metodo", $datos["metodo"], PDO::PARAM_STR);
		
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DE CORTE DEL DIA  ======*/

	/*==============================================================================
	=                   ACTUALIZAR TODO EL CORTE DE CAJA ALMACEN                   =
	==============================================================================*/
	
	static public function mdlActualizarCorteDia($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = :total, fecha = :fecha, estado = 'Pendiente'
                                                WHERE id_cortes = :id_corte");
        
        $stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        $stmt -> close();
        $stmt = null;
    }
	
	
	/*============  End of ACTUALIZAR TODO EL CORTE DE CAJA ALMACEN  =============*/


	/*===========================================
	=            CREAR CORTE DE CAJA            =
	===========================================*/
	
	static public function mdlCrearCorteCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_almacen, id_usuario_plataforma, total, fecha) 
													VALUES(:id_empresa, :id_almacen, :id_usuario_plataforma, :total, :fecha)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
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

	/*====================================================
	=            APROBACION DE CORTES DE CAJA            =
	====================================================*/
	
	static public function mdlAprobacionCorteCaja($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_cortes = :id_cortes");
		$stmt -> bindPARAM(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindPARAM(":id_cortes", $datos["id_cortes"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of APROBACION DE CORTES DE CAJA  ======*/

	/*=============================================================
	=            ACTUALIZAR CORTE CAJA UNA VEZ APROBADO           =
	=============================================================*/
	
	static public function mdlActualizarCorteDiaAprobado($tabla, $datos){

		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = total - :monto, fecha = :fecha
												WHERE id_cortes = :id_corte
												AND (estado != 'Desaprobado')");
		
		$stmt -> bindParam(":monto", $datos["montoResta"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);
	

        if ($stmt -> execute()) {
            return "ok";
        }else{
			return "error";
		}

        $stmt -> close();
        $stmt = null;
	}
	
	/*=====  End of ACTUALIZAR CORTE CAJA UNA VEZ APROBADO  ======*/

	/*=========================================================
	=            SOLICITUD DE CANCELACION DE VENTA            =
	=========================================================*/
	
	static public function mdlVentaCancelar($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, notaCancelacion = :notaCancelacion 
												WHERE folio = :folio AND id_almacen = :id_almacen");

		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":notaCancelacion", $datos["notaCancelacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/*=====  End of SOLICITUD DE CANCELACION DE VENTA  ======*/

	/*=====================================================================
	=            RETORNO DE STOCK DEL PRODUCTO POR CANCELACION            =
	=====================================================================*/
	
	static public function mdlRetornoProductoCancelacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = stock + :stock 
												WHERE id_producto = :id_producto AND id_almacen = :id_almacen");
		
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;


	}
	
	/*=====  End of RETORNO DE STOCK DEL PRODUCTO POR CANCELACION  ======*/

	/*===========================================================================================
	=                   MOSTRAR LOS PAGOS DE VENTAS A PAGOS EN VENTAS DEL DIA                   =
	===========================================================================================*/
	
	static public function mdlMostrarVentasPagosCorteDia($datos){
		$stmt = Conexion::conectar()->prepare("SELECT vp.*, v.id_cliente
												FROM ventas_pagos AS vp, ventas AS v
												WHERE v.id_almacen = :id_almacen
												AND DATE(vp.fecha_pago) = :fecha
												AND vp.folio = v.folio
												AND (vp.estado != 'Desaprobado')");
		
		$stmt -> bindPARAM(":id_almacen", $datos["almacen"], PDO::PARAM_STR);
		$stmt -> bindPARAM(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->execute();

		return  $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR LOS PAGOS DE VENTAS A PAGOS EN VENTAS DEL DIA  =============*/

	/*=============================================================================================
    =                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
    =============================================================================================*/
    static public function mdlActualizarEstadoPagoVenta($tabla,$folio,$almacen){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 'Aprobado' 
                                                WHERE folio = :folio AND id_almacen = :id_almacen");
        
        $stmt -> bindParam(":folio", $folio, PDO::PARAM_STR);
        $stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        }

        $stmt -> close();
        $stmt =null;
    }
    
    
    /*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/

	/*=================================================================
	=                   CANCELAR PAGO VENTA A PAGOS                   =
	=================================================================*/
	
	static public function mdlCancelarPagoVentaPagos($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 'Cancelado' 
												WHERE folio = :folio 
												AND id_almacen = :id_almacen 
												AND fecha_pago = :fecha_pago");
		
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_pago", $datos["fecha_pago"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}else{
			return 'error';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CANCELAR PAGO VENTA A PAGOS  =============*/
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*************************** V E N T A S ***** P A G O S   ***********************************

	/*=====================================
	=            MOSTRAR PAGOS            =
	=====================================*/
	
	static public function mdlMostrarPagos($tabla,$datos,$almacen){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen
												AND DATE(fecha_pago) = :fecha_pago AND estado = :estado AND folio = :folio");
		$stmt -> bindParam(":id_almacen", $almacen, PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_pago", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		// if ($item != NULL) {

		// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		// 	$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		// 	//$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		// 	$stmt -> execute();

		// 	return $stmt -> fetch();

		// }else{

		// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
		// 	//$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		// 	$stmt -> execute();

		// 	return $stmt -> fetchAll();
		// }
		

		$stmt -> close();
		$stmt = NULL; 
    }
	
	/*=====  End of MOSTRAR PAGOS  ======*/
	
	/*======================================
	=            REGISTRAR PAGO            =
	======================================*/
	
	static public function mdlHacerPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_almacen, id_usuario_plataforma, folio, monto, estado, comprobante) VALUES(:id_almacen, :id_usuario_plataforma, :folio, :monto, :estado, :comprobante)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":comprobante", $datos["comprobante"], PDO::PARAM_STR);
		
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of REGISTRAR PAGO  ======*/
	
	/*===============================================================
	=            APROBAR / DESAPROBAR PAGO ALMACEN CEDIS            =
	===============================================================*/
	
	static public function mdlActualizarAprobarDesaprobarPago($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_ventas_pagos = :id_ventas_pagos");
		$stmt -> bindParam(":estado", $datos["estadoPago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_ventas_pagos", $datos["id_pago"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}else{
			return 'error';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of APROBAR / DESAPROBAR PAGO ALMACEN CEDIS   ======*/
	

	/*=====================================
	=            FILTRAR PAGOS            =
	=====================================*/
	
	static public function mdlFiltrarPago($datos){

		if ($datos["item"] == "fecha") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha, v.id_almacen 
													FROM ventas as v, clientes_empresa as c 
													WHERE DATE(v.fecha) = :fecha 
													AND v.id_almacen = :id_almacen
													AND v.metodo = 'Pagos'
													AND c.id_cliente = v.id_cliente");

			$stmt -> bindParam(":fecha", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else if($datos["item"] == "folio"){

			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha, v.id_almacen 
													FROM ventas as v, clientes_empresa as c 
													WHERE v.folio = :item 
													AND v.id_almacen = :id_almacen
													AND v.metodo = 'Pagos'
													AND c.id_cliente = v.id_cliente");

			$stmt -> bindParam(":item", $datos["valor"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} else if ($datos["item"] == "cliente") {
			
			$stmt = Conexion::conectar()->prepare("SELECT v.folio, c.nombre, v.total, v.estado, v.fecha, v.id_almacen 
													FROM ventas as v, clientes_empresa as c
													WHERE c.nombre LIKE '%".$datos['valor']."%' 
													AND (c.id_cliente = v.id_cliente 
													AND v.id_almacen = :id_almacen
													AND v.metodo = 'Pagos')");
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of FILTRAR PAGOS  ======*/

	/*================================================
	=            MOSTRAR PAGOS DATA TABLE            =
	================================================*/
	
	static public function mdlMostrarPagosDataTable($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT *FROM $tabla 
											WHERE id_almacen = :id_almacen 
											AND folio = :folio
											AND estado != 'Desaprobado' 
											AND estado != 'Cancelado'");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PAGOS DATA TABLE  ======*/

	/*=========================================================================
    =                   MOSTRAR TODOS LOS PAGOS DE UNA VENTA                  =
    =========================================================================*/
    
    static public function mdlMostrarTodosPagosVentas($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
                                                WHERE id_almacen = :id_almacen
                                                AND folio = :folio");
        $stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folioPedido"], PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();
        $stmt = null;
    }
    /*============  End of MOSTRAR TODOS LOS PAGOS DE UNA VENTA =============*/

	/*=========================================================================
	=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
	=========================================================================*/
	
	static public function mdlMostrarPagosCanceladosDesaprobados($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
												WHERE folio = :folio
												AND (estado = 'Desaprobado' || estado = 'Cancelado')
												AND id_almacen = :id_almacen");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
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
	
	/*========================================================
	=            CREAR CONFIGURACION VENTAS PAGOS            =
	========================================================*/
	
	static public function mdlCrearConfiguracionVentasPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_almacen, pago_inicial, periodos, promocion_venta) 
													VALUES(:id_almacen, :pago_inicial, :periodos, :promocion_venta)");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
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
													WHERE id_almacen = :id_almacen");

		$stmt -> bindParam(":pago_inicial", $datos["pago_inicial"], PDO::PARAM_STR);
		$stmt -> bindParam(":periodos", $datos["periodos"], PDO::PARAM_STR);
		$stmt -> bindParam(":promocion_venta", $datos["promocion_venta"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR CONFIGURACION VENTAS PAGOS  ======*/
		
			
}
?>