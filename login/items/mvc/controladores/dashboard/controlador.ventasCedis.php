<?php

class ControladorVentasCedis{

    /*====================================================
	=            MOSTRAR VENTAS VENDEDOR CEDIS           =
	====================================================*/
	
	static public function ctrMostrarVentas($item, $valor, $vendedor){

		$tabla = "cedis_ventas";

		$respuestas = ModeloVentasCedis::mdlMostrarVentas($tabla, $item, $valor, $vendedor);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR VENTAS VENDEDOR CEDIS  ======*/
	/*====================================================
	=            MOSTRAR VENTAS A PAGOS CEDIS           =
	====================================================*/
	
	static public function ctrMostrarVentasEmpresapagos($item, $valor, $empresa){

		$tabla = "cedis_ventas";

		$respuestas = ModeloVentasCedis::mdlMostrarVentasEmpresa($tabla, $item, $valor, $empresa);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR VENTAS A PAGOS CEDIS  ======*/
	/*=============================================================
	=            MOSTRAR VENTAS A PAGOS CEDIS X Cliente           =
	=============================================================*/
	
	static public function ctrMostrarVentasEmpresapagosXCliente($item, $valor, $empresa){

		$tabla = "cedis_ventas";

		$respuestas = ModeloVentasCedis::mdlMostrarVentasEmpresaxCliente($tabla, $item, $valor, $empresa);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR VENTAS A PAGOS CEDIS X Cliente  ======*/

	/*============================================================
	=            MOSTRAR TODAS LAS VENTAS DE LA EMPRESA           =
	============================================================*/
	
	static public function ctrMostrarVentasEmpresa($item, $valor){
		$tabla = "cedis_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVentasCedis::mdlMostrarVentasEmpresa($tabla, $item, $valor, $empresa);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR TODAS LAS VENTAS DE LA EMPRESA  ======*/
	/*============================================================
	=            MOSTRAR TODAS LAS VENTAS DE LA EMPRESA           =
	============================================================*/
	
	static public function ctrMostrarVentasEmpresaHoy(){
		$tabla = "cedis_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVentasCedis::mdlMostrarVentasEmpresaHoy($tabla, $empresa);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR TODAS LAS VENTAS DE LA EMPRESA  ======*/

	/*==================================================
	=            MOSTRAR VENTAS TV LINK-PAGO           =
	==================================================*/
	
	static public function ctrMostrarVentasEnTVLinkPago($item, $valor, $vendedor){

		$tabla = "cedis_ventas";
		
		$respuestas = ModeloVentasCedis::mdlMostrarVentasEnTVLinkPago($tabla, $item, $valor, $vendedor);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR VENTAS TV LINK-PAGO  ======*/

	/*===================================================================================
	=                   MOSTRAR CANTIDAD DE PEDIDOS/VENTAS POR ESTADO                   =
	===================================================================================*/
	
	static public function ctrMostrarCantidadPedidosPorEstado($item, $valor){
		$tabla = "cedis_ventas";
		$respuesta = ModeloVentasCedis::mdlMostrarCantidadPedidosPorEstado($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*============  End of MOSTRAR CANTIDAD DE PEDIDOS/VENTAS POR ESTADO  =============*/

	
	/*===========================================================================
	=            MOSTRAR TODAS LAS VENTAS DEL VENDEDOR DE LA EMPRESA            =
	===========================================================================*/
	
	static public function ctrMostrarVentasVendedor($datos){

		$tabla = "cedis_ventas";

		$respuesta = ModeloVentasCedis::mdlMostrarVentasVendedor($tabla, $datos);

		return $respuesta;
 
	}
	
	/*=====  End of MOSTRAR TODAS LAS VENTAS DEL VENDEDOR DE LA EMPRESA  ======*/


	/*==============================================================
	=            MOSTRAR MONTO TOTAL  DEL DIA POR ESTADO           =
	==============================================================*/
	
	static public function ctrCorteDia($datos){

		$tabla = "cedis_ventas";

		$respuesta = ModeloVentasCedis::mdlCorteDia($tabla, $datos);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DEL DIA POR ESTADO ======*/


	/*==================================================================
	=            MOSTRAR MONTO TOTAL DEL DIA FINAL SIN PAGOS           =
	==================================================================*/
	
	static public function ctrCorteDiaFinal($datos){

		$tabla = "cedis_ventas";

		$respuesta = ModeloVentasCedis::mdlCorteDiaFinal($tabla, $datos);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DEL DIA FINAL SIN PAGOS ======*/

	/*==================================================================
	=            MOSTRAR MONTO TOTAL DEL DIA SOLO PAGOS          =
	==================================================================*/
	
	static public function ctrCorteDiaPagosFinal($datos){

		$tabla = "cedis_ventas_pagos";

		$respuesta = ModeloVentasCedis::mdlCorteDiaPagosFinal($tabla, $datos);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DEL DIA SOLO PAGOS ======*/

	

	/*================================================
	=            MOSTRAR CORTES DE UN MES            =
	================================================*/
	
	static public function ctrMostrarCortesCaja($datos){

		$tabla = "cedis_ventas_corte";

		$respuesta = ModeloVentasCedis::mdlMostrarCortesCaja($tabla, $datos);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR CORTES DE UN MES  ======*/

	/*============================================================
	=                   MOSTRAR CORTES DEL DIA                   =
	============================================================*/
	static public function ctrMostrarCortesVentasCedisDia($datos){
        $tabla = "cedis_ventas_corte";

        $respuesta = ModeloVentasCedis::mdlMostrarCortesVentasCedisDia($tabla, $datos);

        return $respuesta;
    }

	/*============  End of MOSTRAR CORTES DEL DIA  =============*/



	/*=============================================================
	=                   MOSTRAR VENTAS DETALLES                   =
	=============================================================*/
	
	static public function ctrMostrarVentasDetallesCedis($datos){
		
		$respuesta = ModeloVentasCedis::mdlMostrarDetallesVenta($datos);

		return $respuesta;

	}
	
	
	/*============  End of MOSTRAR VENTAS DETALLES  =============*/

	/*=================================================================
	=                   MOSTRAR PAGOS EN VENTAS DIA                   =
	=================================================================*/
	
	static public function ctrMostrarVentasPagosCorteDia($datos){
		// $empresa = $_SESSION["idEmpresa_dashboard"];
		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagosCorteDia($datos);

		return $respuesta;
	}
	
	
	/*============  End of MOSTRAR PAGOS EN VENTAS DIA  =============*/



//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*************************** V E N T A S ***** P A G O S   ***********************************
	
	static public function ctrMostrarPagos($datos){
		$tabla = "cedis_ventas_pagos";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuestas = ModeloVentasCedis::mdlMostrarPagos($tabla, $datos, $empresa);

		return $respuestas; 
	}

	
	static public function ctrMostrarPagosVenta($datos){
		$tabla = "cedis_ventas_pagos";
		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagosDataTable($tabla, $datos);

		return $respuesta;
	}


	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------
	//  -------------------- CONTROLADORES DE MODULO DE FACTURACION ------------------
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------

		/*============================================================
		=            MOSTRAR PEDIDOS DEL MES SIN FACTURAR            =
		============================================================*/
		
		static public function ctrMostrarVentasSinFacturar($item, $valor){ //ocupo

			$tabla = "cedis_ventas";
			$empresa = $_SESSION["idEmpresa_dashboard"];

			$respuesta = ModeloVentasCedis::mdlMostrarVentasSinFacturar($tabla, $item, $valor, $empresa);

			return $respuesta;

		}
		
		/*=====  End of MOSTRAR PEDIDOS DEL MES SIN FACTURAR  ======*/

		/*====================================================================================
		=                   CONTAR SI HAY PRODUCTOS FACTURADOS EN LA VENTA                   =
		====================================================================================*/
		
		static public function ctrContarProductosFacturados($datos){
			$tabla = "cedis_venta_detalles";

			$respuesta = ModeloVentasCedis::mdlContarProductosFacturados($tabla,$datos);

			return $respuesta;
		}
		
		
		/*============  End of CONTAR SI HAY PRODUCTOS FACTURADOS EN LA VENTA  =============*/
    /*===========================================
	= Contar ventas a pagos activas de cedis    =
	===========================================*/
	
	static public function ctrVentasActivasCedis(){
        $tabla = "cedis_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];

        $respuesta = ModeloVentasCedis::mdlVentasActivasCedis($tabla,$empresa);

        return $respuesta;
    }
	
	/*=====  End of Contar ventas a pagos activas de cedis   ======*/

	
	
	//***********************************************************************************************************
	//***********************************************************************************************************
	//***********************************************************************************************************
	//***********************************************************************************************************
	//*************************** V E N T A S ***** C O N F I G U R A C I O N  ***********************************

	static public function ctrMostrarConfiguracionGeneralVentas(){
		$tabla = "configuracion_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVentasCedis::mdlMostrarConfiguracionGeneralVentas($tabla, $empresa);

		return $respuesta;
	}

}
 
?>