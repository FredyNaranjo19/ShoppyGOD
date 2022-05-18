<?php

class ModeloVendedorextPedidos{

    /*===================================================================
    =                   CREAR PEDIDO VENDEDOR EXTERNO                   =
    ===================================================================*/
    
    
    static public function mdlCrearPedido($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_cliente, id_usuario_plataforma, id_empresa, folio, estado_pedido, total)
                                                            VALUES (:id_cliente, :id_usuario_plataforma, :id_empresa, :folio, :estado_pedido, :total)");

        $stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 
        $stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $stmt -> bindParam(":estado_pedido", $datos["estado_pedido"], PDO::PARAM_STR);
        $stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }
        // $stmt -> close(); 
        $stmt = null;
    }

    /*======================================================================
    =                   MOSTRAR PEDIDOS VENDEDOR EXTERNO                   =
    ======================================================================*/

    static public function mdlMostrarPedidos($tabla,$item,$valor, $id_empresa, $vendedor){

        if ($item == "fecha_entrega") {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE DATE($item) = :$item AND id_empresa = :id_empresa AND id_usuario_plataforma = :vendedor ORDER BY fecha_entrega DESC");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $id_empresa, PDO::PARAM_STR);
            $stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
			$stmt -> execute();

            return $stmt -> fetchAll();

        }else if($item == "folio") {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa AND id_usuario_plataforma = :vendedor");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $id_empresa, PDO::PARAM_STR);
            $stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();
            
        }else if ($item == "tipo_pago" || $item == "estado_pedido") {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa AND id_usuario_plataforma = :vendedor ORDER BY fecha_entrega DESC");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $stmt -> bindParam(":id_empresa", $id_empresa, PDO::PARAM_STR);
            $stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
            $stmt -> execute();

			return $stmt -> fetchAll();

        }else{
            // si hay error agregar un where con id usuario plataforma
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario_plataforma = :vendedor");
			$stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();
		}

        // if ($item != null) {
		// 	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_usuario_plataforma = :id_usuario_plataforma");
		// 	$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		// 	$stmt -> bindParam(":id_usuario_plataforma", $id_usuario_plataforma, PDO::PARAM_STR);
		// 	$stmt -> execute();

		// 	return $stmt -> fetch();

		// }else
		

		$stmt -> close();
		$stmt = null; 
    }


    /*==================================================
	=            MOSTRAR VENTAS DEL CLIENTE            =
	==================================================*/
	
	static public function mdlMostrarVentasCliente($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND estado_pago = 'Pagado'");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR VENTAS DEL CLIENTE  ======*/




    /*============================================================================= 
	=                   MOSTRAR TODOS LOS PEDIDOS DE LA EMPRESA                    =
	=============================================================================*/
	static public function mdlMostrarPedidosEmpresa($tabla, $item, $valor, $empresa){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa ORDER BY fecha_pedido ASC");
		
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL; 
	}
	
	
	/*============  End of MOSTRAR TODOS LOS PEDIDOS DE LA EMPRESA   =============*/

    /*===============================================================================
    =                   CREAR DETALLES DE PEDIDO VENDEDOR EXTERNO                   =
    ===============================================================================*/

    static public function mdlCrearDetallePedido($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_cliente, id_usuario_plataforma, id_empresa, folio, id_producto, cantidad, costo, precio, monto, utilidad)
                                                VALUES (:id_cliente, :id_usuario_plataforma, :id_empresa, :folio, :id_producto, :cantidad, :costo, :precio, :monto, :utilidad)");
        
        $stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
        $stmt -> bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*===============================================================
    =                   EDITAR STOCK DE PRODUCTOS                   =
    ===============================================================*/
    static public function mdlEditarStock($tabla, $datos){
        $stmt = Conexion::conectar() -> prepare("UPDATE $tabla SET stock_disponible = stock_disponible - :stock_disponible 
                                                    WHERE id_producto = :id_producto AND id_empresa = :id_empresa");
        
        $stmt -> bindParam(":stock_disponible", $datos["cantidad"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*===============================================================================
    =                   REGISTRAR PAGO DE PEDIDO VENDEDOR EXTERNO                   =
    ===============================================================================*/

    static public function mdlHacerPago($tabla, $datos){
        $stmt = Conexion::conectar() -> prepare("INSERT INTO $tabla (id_usuario_plataforma, id_empresa, folio, monto, comprobante, estado_pago)
                                        VALUES (:id_usuario_plataforma, :id_empresa, :folio, :monto, :comprobante, :estado_pago)");
        
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"],PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"],PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folio"],PDO::PARAM_STR);
        $stmt -> bindParam(":monto", $datos["monto"],PDO::PARAM_STR);
        $stmt -> bindParam(":comprobante", $datos["comprobante"],PDO::PARAM_STR);
        $stmt -> bindParam(":estado_pago", $datos["estado_pago"],PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;

    }

    /*=================================================================
    =                   MOSTRAR DETALLES DEL PEDIDO                   =
    =================================================================*/

    static public function mdlMostrarDetallesPedido($datos){
        // si hay error agregar la sentencia AND vd.id_usuario_plataforma = :id_usuario_plataforma
        $stmt = Conexion::conectar()->prepare("SELECT vd.*, p.codigo, p.nombre, vep.total
                                                FROM vendedorext_pedidos_detalles as vd, productos as p, vendedorext_pedidos AS vep
                                                WHERE p.id_producto = vd.id_producto
                                                AND vd.folio = :folio
                                                AND vd.folio = vep.folio
                                                AND vd.id_empresa = :id_empresa
                                                AND vd.id_usuario_plataforma = :vendedor");
                                    
        $stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();
        $stmt = null;
    }

    /*======================================================================
    =                   CANCELAR PEDIDO VENDEDOR EXTERNO                   =
    ======================================================================*/

    static public function mdlCancelarPedido($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_pedido = :estado_pedido, nota_cancelacion = :nota_cancelacion
                                                WHERE folio = :folio AND id_usuario_plataforma = :id_usuario_plataforma");

        $stmt -> bindParam(":estado_pedido", $datos["estado"], PDO::PARAM_STR);
        $stmt -> bindParam(":nota_cancelacion", $datos["nota_cancelacion"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return 'ok';
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*=========================================================================
    =                   CANCELACION DEFINITIVA VENDEDOR EXT                   =
    =========================================================================*/
    
    static public function mdlPedidoCancelarDefinitivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_pedido = :estado WHERE folio = :folio 
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
    

    /*=====================================================================================
    =                   AL CANCELAR ACTUALIZAR STOCK EN TABLA PRODUCTOS                   =
    =====================================================================================*/
    
    static public function mdlActualizaStockProductosCancelacion($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible + :stock 
                                                WHERE id_producto = :id_producto");
        
        $stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return 'ok';
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*==============================================================================
    =                   ACTUALIZAR ESTADO DE PEDIDO VENDEDOR EXT                   =
    ==============================================================================*/
    
    static public function mdlActualizarEstadoPedido($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_pedido = :estado_pedido
                                                WHERE folio = :folio AND id_empresa = :id_empresa AND id_usuario_plataforma = :id_usuario_plataforma");
        $stmt -> bindParam(":estado_pedido", $datos["estado_pedido"],PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folio"],PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"],PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario_plataforma", $datos["vendedor"],PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt =null;
    }
    
    /*==============================================================
    =                   MOSTRAR PEDIDOS A PAGOS                    =
    ==============================================================*/
    
    static public function mdlMostrarPedidosPagos($tabla, $datos, $vendedor, $id_empresa){
        
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND id_usuario_plataforma = :id_usuario_plataforma
                                                AND DATE(fecha_pago) = :fecha_pago AND estado_pago = :estado_pago AND folio = :folio");
        $stmt -> bindParam(":id_usuario_plataforma", $vendedor, PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $id_empresa, PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_pago", $datos["fecha_pago"], PDO::PARAM_STR);
        $stmt -> bindParam(":estado_pago", $datos["estado_pago"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetchAll();
        
		$stmt = null; 
        
    }

    /*=============================================================================================
    =                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
    =============================================================================================*/
    static public function mdlActualizarEstadoPagoPedido($tabla,$folio,$id_empresa,$vendedor){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_pago = 'Pagado' 
                                                WHERE folio = :folio AND id_empresa = :id_empresa AND id_usuario_plataforma = :vendedor");
        
        $stmt -> bindParam(":folio", $folio, PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $id_empresa, PDO::PARAM_STR);
        $stmt -> bindParam(":vendedor", $vendedor, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        }

        $stmt -> close();
        $stmt =null;
    }
    
    
    /*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/

    /*=========================================================================
	=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
	=========================================================================*/
	
	static public function mdlMostrarPagosCanceladosDesaprobados($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM vendedorext_pedidos_pagos
                                                WHERE folio = :folio
                                                AND (estado_pago = 'Desaprobado' || estado_pago = 'Cancelado')
                                                AND id_usuario_plataforma = :id_usuario_plataforma");
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE   ======*/

    /***************************************************************************
    ****************************************************************************
    * CORTES DE CAJA VEND ESXT
    ****************************************************************************
    ****************************************************************************/

    /*===============================================================
    =                   MOSTRAR MONTO TOTAL DIA                     =
    ===============================================================*/
    static public function mdlCorteDiaVendExt($tabla,$datos){
        // if ($datos["tipo_pago"] == "Efectivo") {

            $stmt = Conexion::conectar() -> prepare("SELECT SUM(total) FROM $tabla 
                                                        WHERE id_empresa = :id_empresa
                                                        AND id_usuario_plataforma = :vendedor
                                                        AND (estado_pedido = 'entregado')
                                                        AND DATE(fecha_entrega) = :fecha_entrega
                                                        AND tipo_pago = :tipo_pago");                                
        
        
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":vendedor", $datos["vendedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_entrega", $datos["fecha_entrega"], PDO::PARAM_STR);
		$stmt -> bindParam(":tipo_pago", $datos["tipo_pago"], PDO::PARAM_STR);
        
        $stmt -> execute();

		return $stmt -> fetch();

		// $stmt -> close();
		$stmt = NULL; 
    }

    /*==============================================================================
    =                   CREAR CORTE DE CAJA DIARIO DE PEDIDOS VE                   =
    ==============================================================================*/
    
    static public function mdlCrearCorteDiaPedidosVendExt($tabla, $datos){
        $stmt = Conexion::conectar() -> prepare("INSERT INTO $tabla (id_usuario_plataforma, id_empresa, total, fecha_corte) 
                                                    VALUES (:id_usuario_plataforma, :id_empresa, :total, :fecha_corte)");

        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);

        if($stmt -> execute()){
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*=========================================================================
    =                   MOSTRAR CORTES DE CAJA VENDEDOR EXT                   =
    =========================================================================*/
    
    static public function mdlMostrarCortesPedidosVendExt($tabla, $datos, $id_empresa){
        
        if ($datos["fecha"] != null) {
            // si hay error colocar id_usuario_plataforma = :id_usuario_plataforma
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE DATE(fecha_corte) = :fecha AND id_empresa = :id_empresa");

            // $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"]);
            $stmt -> bindParam(":fecha", $datos["fecha"]);
            $stmt -> bindParam(":id_empresa", $id_empresa);
            $stmt -> execute();

            return $stmt -> fetch();

        }else{
            // si hay error colocar WHERE id_usuario_plataforma = :id_usuario_plataforma"
            $stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");

            $stmt -> bindParam(":id_empresa", $id_empresa);
            $stmt -> execute();

            return $stmt -> fetchAll();
        }

        // $stmt -> close();
        $stmt = null;
    }

    /* MOSTRAR CORTES DE CAJA (SOLO LOS DEL DÍA)
	-------------------------------------------------- */
	static public function mdlMostrarCortesVentasDia($tabla, $datos){
		$stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE DATE(fecha_corte) = :fecha AND id_usuario_plataforma = :id_usuario_plataforma AND estado != 'Desaprobado'");

		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_vendedor"]);
		$stmt -> bindParam(":fecha", $datos["fecha"]);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}

    /*==============================================================
    =                   APROBAR DESAPROBAR CORTE                   =
    ==============================================================*/
    
    static public function mdlAprobarDesaprobarCorte($tabla, $datos){
        $stmt = Conexion::conectar() -> prepare("UPDATE $tabla SET estado = :estado
                                                WHERE id_corte = :id_corte");
        
        $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;
    }


    static public function mdlActualizarCorteDiaVendExt($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = :total, fecha_corte = :fecha_corte, estado = 'Pendiente'
                                                WHERE id_corte = :id_corte");
        
        $stmt -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_corte", $datos["fecha_corte"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_corte", $datos["id_corte"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*=============================================================
	=            ACTUALIZAR CORTE CAJA UNA VEZ APROBADO           =
	=============================================================*/
	
	static public function mdlActualizarCorteDiaAprobado($tabla, $datos){

		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET total = total - :monto
												WHERE id_corte = :id_corte
												AND (estado != 'Desaprobado')");
		
		$stmt -> bindParam(":monto", $datos["montoResta"], PDO::PARAM_STR);
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

    /*===========================================================================================
	=                   MOSTRAR LOS PAGOS DE PEDIDOS A PAGOS EN PEDIDOS DEL DIA                   =
	===========================================================================================*/
	
	static public function mdlMostrarVentasPagosCorteDia($datos){
		$stmt = Conexion::conectar()->prepare("SELECT vepag.*, veped.id_cliente
												FROM vendedorext_pedidos_pagos AS vepag, vendedorext_pedidos AS veped
												WHERE veped.id_usuario_plataforma = :id_usuario_plataforma
												AND DATE(vepag.fecha_pago) = :fecha
												AND vepag.folio = veped.folio
												");
		
		$stmt -> bindPARAM(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindPARAM(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->execute();

		return  $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR LOS PAGOS DE PEDIDOS A PAGOS EN PEDIDOS DEL DIA  =============*/

    
    
    /***************************************************************************
    ****************************************************************************
    * TERMINA CORTES DE CAJA VEND ESXT
    ****************************************************************************
    ****************************************************************************/

    /*======================================================================
    =                   MOSTRAR PAGOS PEDIDOS DATA-TABLE                   =
    ======================================================================*/
    
    static public function mdlMostrarPagosPedidosDataTable($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
                                                WHERE id_usuario_plataforma = :id_usuario_plataforma
                                                AND folio = :folio
                                                AND estado_pago != 'Desaprobado' 
                                                AND estado_pago != 'Cancelado'");
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folioPedido"], PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetchAll();

        // $stmt -> close();
        $stmt = null;
    }
    /*============  End of MOSTRAR PAGOS PEDIDOS DATA-TABLE  =============*/

    /*==========================================================================
    =                   MOSTRAR TODOS LOS PAGOS DE UN PEDIDO                   =
    ==========================================================================*/
    
    static public function mdlMostrarTodosPagosPedidos($tabla,$datos){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
                                                WHERE id_usuario_plataforma = :id_usuario_plataforma
                                                AND folio = :folio");
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio", $datos["folioPedido"], PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetchAll();

        $stmt -> close();
        $stmt = null;
    }
    /*============  End of MOSTRAR TODOS LOS PAGOS DE UN PEDIDO  =============*/
    
    
    /*===================================================================================
    =                   MOSTRAR HISTORIAL VENTAS A PAGOS POR VENDEDOR                   =
    ===================================================================================*/
    
    static public function mdlMostrarVentasPagosVendedor($vendedor){
        $stmt = Conexion::conectar()->prepare("SELECT vp.folio, c.nombre, vp.total, vp.estado_pedido, vp.fecha_pedido, vp.id_usuario_plataforma, c.telefono
                                                FROM vendedorext_pedidos as vp, clientes_empresa as c 
                                                WHERE vp.id_usuario_plataforma = :id_usuario_plataforma
                                                AND vp.tipo_pago = 'Pagos'
                                                AND vp.estado_pedido != 'cancelado' AND vp.estado_pago != 'Pagado'
                                                AND c.id_cliente = vp.id_cliente");
        
        $stmt -> bindParam(":id_usuario_plataforma", $vendedor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		// $stmt -> close();
		$stmt = NULL;
    }

    /*=============================================================
    =                   APROBAR DESAPROBAR PAGO                   =
    =============================================================*/
    static public function mdlAprobarPagoPedido($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_pago = :estado_pago 
                                                WHERE  id_pago = :id_pago");
		$stmt -> bindParam(":estado_pago", $datos["estado_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_pago", $datos["id_pago"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}else{
			return 'error';
		}

		// $stmt -> close();
		$stmt = NULL;
	}

    /*==============================================================================
    =                   GUARDAR PAGO DE PEDIDO UNA VEZ ENTREGADO                   =
    ==============================================================================*/
    static public function mdlGuardarPagoPedidoEntregado($tabla, $datos){
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_pedido = :estado_pedido, total = :total, tipo_pago = :tipo_pago,
                                                folio_pago_tarjeta = :folio_pago_tarjeta, estado_pago = :estado_pago,
                                                fecha_entrega = :fecha_entrega WHERE folio = :folio AND id_usuario_plataforma = :id_usuario_plataforma AND id_empresa = :id_empresa");
        
        $stmt -> bindParam(":estado_pedido" , $datos["estado_pedido"], PDO::PARAM_STR);
        $stmt -> bindParam(":total" , $datos["total"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo_pago" , $datos["tipo_pago"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio_pago_tarjeta" , $datos["folio_pago_tarjeta"], PDO::PARAM_STR);
        $stmt -> bindParam(":estado_pago" , $datos["estado_pago"], PDO::PARAM_STR);
        $stmt -> bindParam(":fecha_entrega" , $datos["fecha_entrega"], PDO::PARAM_STR);
        $stmt -> bindParam(":folio" , $datos["folio"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario_plataforma" , $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_empresa" , $datos["id_empresa"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
			return 'ok';
		}else{
			return 'error';
		}

		// $stmt -> close();
		$stmt = NULL;
    }
    
    /**********************************************************************************
    ***********************************************************************************
    * PEDIDOS PAGOS CONFIGURACION
    ***********************************************************************************
    ***********************************************************************************/

    /*=================================================================================
    =                   GUARDAR CONFIGURACION PAGOS PEDIDOS DE VENDEDOR EXT                   =
    =================================================================================*/
        
    static public function mdlGuardarConfiguracionPedidosPagos($tabla, $datos){
        $stmt = Conexion::conectar() -> prepare("INSERT INTO $tabla (id_empresa, id_usuario_plataforma, pago_inicial, periodos, promocion_pedido)
                                                VALUES (:id_empresa, :id_usuario_plataforma, :pago_inicial, :periodos, :promocion_pedido)");
        
        $stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
        $stmt -> bindParam(":pago_inicial", $datos["pago_inicial"], PDO::PARAM_STR);
        $stmt -> bindParam(":periodos", $datos["periodos"], PDO::PARAM_STR);
        $stmt -> bindParam(":promocion_pedido", $datos["promocion_pedido"], PDO::PARAM_STR);

        if ($stmt -> execute()) {
            return "ok";
        }

        // $stmt -> close();
        $stmt = null;
    }

    /*=================================================================================
    =                   MOSTRAR CONFIGURACION DE PAGOS VENDEDOR EXT                   =
    =================================================================================*/
    
    static public function mdlMostrarConfiguracionPedidosPagos($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		// $stmt -> close();
		$stmt = NULL;
	}

    /**************************************************************************************
    ***************************************************************************************
    * FILTRAR PEDIDOS 
    ***************************************************************************************
    ***************************************************************************************/

    static public function mdlFiltrarPedidosVendedorExt($datos){

        if ($datos["item"] == "fecha") {
            
            $stmt = Conexion::conectar()->prepare("SELECT pve.folio, pve.total, pve.estado_pedido, pve.fecha_pedido, pve.id_usuario_plataforma, c.nombre
                                                    FROM vendedorext_pedidos as pve, clientes_empresa as c
                                                    WHERE DATE(pve.fecha_pedido) = :fecha
                                                    AND pve.id_usuario_plataforma = :vendedor
                                                    AND pve.id_empresa = :empresa
                                                    AND pve.tipo_pago = 'Pagos'
                                                    AND c.id_cliente = pve.id_cliente");

            $stmt -> bindParam(":fecha", $datos["valor"], PDO::PARAM_STR);
            $stmt -> bindParam(":vendedor", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
            $stmt -> bindParam(":empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();

        } else if ($datos["item"] == "folio") {

            $stmt = Conexion::conectar()->prepare("SELECT pve.folio, pve.total, pve.estado_pedido, pve.fecha_pedido, pve.id_usuario_plataforma, c.nombre
                                                    FROM vendedorext_pedidos as pve, clientes_empresa as c
                                                    WHERE pve.folio = :item 
                                                    AND pve.id_usuario_plataforma = :vendedor
                                                    AND pve.id_empresa = :empresa
                                                    AND pve.tipo_pago = 'Pagos'
                                                    AND c.id_cliente = pve.id_cliente");

            $stmt -> bindParam(":item", $datos["valor"], PDO::PARAM_STR);
            $stmt -> bindParam(":vendedor", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
            $stmt -> bindParam(":empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();

        } else if ($datos["item"] == "cliente"){

            $stmt = Conexion::conectar()->prepare("SELECT pve.folio, pve.total, pve.estado_pedido, pve.fecha_pedido, pve.id_usuario_plataforma, c.nombre
                                                    FROM vendedorext_pedidos as pve, clientes_empresa as c
                                                    WHERE c.nombre LIKE '%".$datos['valor']."%'
                                                    AND (c.id_cliente = pve.id_cliente
                                                    AND pve.id_usuario_plataforma =:vendedor
                                                    AND pve.id_empresa = :empresa
                                                    AND pve.tipo_pago = 'Pagos')");

            $stmt -> bindParam(":vendedor", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
            $stmt -> bindParam(":empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $stmt -> bindParam(":vendedor", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetchAll();
            
        }

        // $stmt -> close();
		$stmt = NULL;
        

    }
    
    
    
}