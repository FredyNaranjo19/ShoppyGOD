<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';
require_once '../../modelos/dashboard/modelo.productos.php';

class AjaxVentasCedis{

	/*==========================================================
	=                   MOSTRAR VENTAS CEDIS                   =
	==========================================================*/
	public $folioVentaMostrar;
	public $vendedorVentaMostrar;
	public function ajaxMostrarVentas(){

		$tabla = "cedis_ventas";
		$item = "folio";
		$valor = $this -> folioVentaMostrar;
		$vendedor = $this -> vendedorVentaMostrar;

		$respuesta = ModeloVentasCedis::mdlMostrarVentas($tabla,$item,$valor,$vendedor);

		echo json_encode($respuesta);	
	}
	
	
	/*============  End of MOSTRAR VENTAS CEDIS  =============*/
	/*==========================================================
	=                   MOSTRAR VENTAS CEDIS  Y SUMA DEV       =
	==========================================================*/
	public $folioVentaMostrarYSuma;
	public function ajaxMostrarVentasYSuma(){

		$tabla = "cedis_ventas";
		$item = "folio";
		$valor = $this -> folioVentaMostrarYSuma;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVentasCedis::mdlMostrarVentasYSuma($tabla,$item,$valor,$empresa);

		echo json_encode($respuesta);	
	}
	
	
	/*============  End of MOSTRAR VENTAS CEDIS Y SUMA DEV =============*/

	/*=============================================
	=                   MOSTRAR VENTAS EMPRESA                   =
	=============================================*/
	
	public function ajaxMostrarVentasEmpresa(){

		$tabla = "cedis_ventas";
		$item = "folio";
		$valor = $this -> folioVentaMostrar;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVentasCedis::mdlMostrarVentasEmpresa($tabla,$item,$valor,$empresa);

		echo json_encode($respuesta);	
	}
	
	/*============  End of MOSTRAR VENTAS EMPRESA  =============*/

	/*===================================================================
	=                   EDIITAR ESTADO DE VENTA CEDIS                   =
	===================================================================*/
	public $folioVentaEditar;
	public $vendedorVentaEditar;
	public $estadoVentaEditar;
	public $tipoFecha;
	public function ajaxEditarEstadoVenta(){
		date_default_timezone_set('America/Mexico_City');
		$tabla = "cedis_ventas";
		$fecha = date("Y-m-d H:i:s");

		if ($this -> tipoFecha == "fecha_aprobacion") {
			
			$datos = array("vendedor"=> $this -> vendedorVentaEditar,
							"folio" => $this -> folioVentaEditar,
							"estado" => $this -> estadoVentaEditar,
							"fecha_aprobacion" => $fecha,
							"fecha_finalizar_link" => null,
							"comprobante" => null);

		}else if($this -> tipoFecha == "fecha_finalizar_link"){

			$datos = array("vendedor"=> $this -> vendedorVentaEditar,
							"folio" => $this -> folioVentaEditar,
							"estado" => $this -> estadoVentaEditar,
							"fecha_finalizar_link" => $fecha,
							"fecha_aprobacion" => null,
							"comprobante" => null);

		}else if($this -> tipoFecha == "fecha_regresar_aprobacion"){

			$datos = array("vendedor"=> $this -> vendedorVentaEditar,
							"folio" => $this -> folioVentaEditar,
							"fecha_regresar_aprobacion" => 'true');
		}else{

			$datos = array("vendedor"=> $this -> vendedorVentaEditar,
							"folio" => $this -> folioVentaEditar,
							"estado" => $this -> estadoVentaEditar,
							"fecha_finalizar_link" => null,
							"fecha_aprobacion" => null,
							"comprobante" => null,
							"fecha_regresar_aprobacion" => null);
		}
		
		

		$res = ModeloVentasCedis::mdlActualizarComprobanteLink($tabla, $datos);

		echo json_encode($res);
	}
	
	/*============  End of EDIITAR ESTADO DE VENTA CEDIS  =============*/

    /*================================================
	=            TRAER DETALLES DEL VENTA            =
	================================================*/
	
	public $folioVenta;
	public $vendedorVenta;

	public function ajaxMostrarDetalleVenta(){

		$datos = array("folio" => $this -> folioVenta,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $this->vendedorVenta);
 
		$respuesta = ModeloVentasCedis::mdlMostrarDetallesVenta($datos);

		echo json_encode($respuesta);
	}

	/*=====  End of TRAER DETALLES DEL PEDIDO  ======*/
	/*================================================
	=            TRAER DETALLES DEL VENTA            =
	================================================*/
	
	public $folioVentaDetalleYDev;

	public function ajaxMostrarDetalleVentaYDev(){

		$datos = array("folio" => $this -> folioVentaDetalleYDev,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"]);
 
		$respuesta = ModeloVentasCedis::mdlMostrarDetallesVentaYDev($datos);

		echo json_encode($respuesta);
	}

	/*=====  End of TRAER DETALLES DEL PEDIDO  ======*/

	/*===========================================================
	=            PETICION DE CANCELACION DE LA VENTA            =
	===========================================================*/
	
	public $folioVentaPorCancelar;
	public $notaVentaPorCancelar;
	public $metodoVentaPorCancelar;

	public function ajaxVentaPorCancelar(){

		/* CAMBIO DE ESTADO VENTAS PAGOS */
		$metodo = $this -> metodoVentaPorCancelar;

		if ($metodo == "Pagos") {
			$tablaVP = "cedis_ventas_pagos";
			$datos = array("folio" => $this -> folioVentaPorCancelar,
							"empresa" => $_SESSION["idEmpresa_dashboard"],
							"estado" => "Por Cancelar",
							"vendedor" => $_SESSION["id_dashboard"]);
			$cancelacion = ModeloVentasCedis::mdlCancelarPagoVentaPagos($tablaVP, $datos);
		}

		/* CAMBIO DE ESTADO VENTAS */
		$tabla = "cedis_ventas";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"], 
						"id_usuario" => $_SESSION["id_dashboard"], 
						"folio" => $this -> folioVentaPorCancelar,
						"notaCancelacion" => $this -> notaVentaPorCancelar,
						"estado" => "Por Cancelar");

		$respuesta = ModeloVentasCedis::mdlVentaCancelar($tabla, $datos);

		


		echo json_encode($respuesta);

	}
	
	/*=====  End of PETICION DE CANCELACION DE LA VENTA  ======*/

	/*========================================================================
	=                   CANCELACION DEFINITIVA DE LA VENTA                   =
	========================================================================*/
	
	public $folioVentaCancelarDefinitivo;
	public $vendedorCancelarDefinitivo;

	public function ajaxVentaCancelarDefinitivo(){
 
		/* CAMBIO DE ESTADO VENTAS */
		$tabla = "cedis_ventas";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $this -> vendedorCancelarDefinitivo, 
						"folio" => $this -> folioVentaCancelarDefinitivo,
						"estado" => "Cancelada");

		$respuesta = ModeloVentasCedis::mdlVentaCancelarDefinitivo($tabla, $datos);


		/* RETORNO DE CANTIDAD EN PRODUCTOS */

		$datos = array("folio" => $this -> folioVentaCancelarDefinitivo,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" =>$this -> vendedorCancelarDefinitivo);
		
		$detalle = ModeloVentasCedis::mdlMostrarDetallesVenta($datos);

		foreach ($detalle as $key => $value) {

			$tabla = "productos";
			$datos = array("stock_disponible" => $value["cantidad"],
							"id_producto" => $value["id_producto"],
							"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

			$retorno = ModeloVentasCedis::mdlRetornoProductoCancelacion($tabla, $datos);

		}

		echo json_encode($retorno); 

	}

	/* ************** CANCELACION DEFINITIVA DE VENTAS A PAGOS ************** */
	public $folioVentaPagosCancelar;
	public $vendedorVentaPagosCancelar;
	public function ajaxVentaPagosCancelarDefinitivo(){
 
		/* CAMBIO DE ESTADO VENTAS */
		$tabla = "cedis_ventas";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $this -> vendedorVentaPagosCancelar, 
						"folio" => $this -> folioVentaPagosCancelar,
						"estado" => "Cancelada");

		$respuesta = ModeloVentasCedis::mdlVentaCancelarDefinitivo($tabla, $datos);


		/* RETORNO DE CANTIDAD EN PRODUCTOS */

		$datos = array("folio" => $this -> folioVentaPagosCancelar,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" =>$this -> vendedorVentaPagosCancelar);
		
		$detalle = ModeloVentasCedis::mdlMostrarDetallesVenta($datos);

		foreach ($detalle as $key => $value) {

			$tabla = "productos";
			$datos = array("stock_disponible" => $value["cantidad"],
							"id_producto" => $value["id_producto"],
							"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

			$retorno = ModeloVentasCedis::mdlRetornoProductoCancelacion($tabla, $datos);

		}

		$tablaVP = "cedis_ventas_pagos";
		$datos = array("folio" => $this -> folioVentaPagosCancelar,
						"empresa" => $_SESSION["idEmpresa_dashboard"],
						"estado" => "Cancelado",
						"vendedor" => $this -> vendedorVentaPagosCancelar);
		$cancelacion = ModeloVentasCedis::mdlCancelarPagoVentaPagos($tablaVP, $datos);

		echo json_encode($retorno); 

	}
	
	
	/*============  End of CANCELACION DEFINITIVA DE LA VENTA  =============*/

	/*============================================
	=            CANCELACION DE VENTA            =
	============================================*/
	
	public $folioVentaCancelar;
	public $notaVentaCancelar;
	
	public function ajaxPedidoLinkWebCancelar(){
 
		/* CAMBIO DE ESTADO VENTAS */
		$tabla = "cedis_ventas";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"id_usuario" => $_SESSION["id_dashboard"],
						"folio" => $this -> folioVentaCancelar,
						"estado" => "Cancelada",
						"notaCancelacion" => $this -> notaVentaCancelar);

		$respuesta = ModeloVentasCedis::mdlVentaCancelar($tabla, $datos);


		/* RETORNO DE CANTIDAD EN PRODUCTOS */

		$datos = array("folio" => $this -> folioVentaCancelar,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $_SESSION["id_dashboard"]);
		
		$detalle = ModeloVentasCedis::mdlMostrarDetallesVenta($datos);

		foreach ($detalle as $key => $value) {

			$tabla = "productos";
			$datos = array("stock_disponible" => $value["cantidad"],
							"id_producto" => $value["id_producto"],
							"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

			$retorno = ModeloVentasCedis::mdlRetornoProductoCancelacion($tabla, $datos);

		}

		echo json_encode($retorno); 

	}
	
	/*=====  End of CANCELACION DE VENTA  ======*/
	

	/*================================================
	=            CREAR CORTE DEL VENDEDOR            =
	================================================*/
	
	public $totalCorteCaja;
	public $fechaCorteCaja;
	public $idCorteActualizar;
	
	public function ajaxCrearCorteCaja(){

		$tabla = "cedis_ventas_corte";

		if ($this -> idCorteActualizar != 0) {
			$datos = array("total" => $this -> totalCorteCaja,
							"fecha" => $this -> fechaCorteCaja,
							"id_corte" => $this -> idCorteActualizar);
						
			$respuesta = ModeloVentasCedis::mdlActualizarCorteDia($tabla, $datos);
			
		}else{

			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"id_usuario_plataforma" => $_SESSION["id_dashboard"],
							"total" => $this -> totalCorteCaja,
							"fecha" => $this -> fechaCorteCaja);
	
			$respuesta = ModeloVentasCedis::mdlCrearCorteCaja($tabla, $datos);
		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of CREAR CORTE DEL VENDEDOR  ======*/
	
	
	/*================================================================================
	=                   ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO                   =
	================================================================================*/
	public $montoSumarCorte;
	public $idCorteAprobadoActualizar;

	public function ajaxActualizarTotalCorteCaja(){
		date_default_timezone_set("America/Mexico_City");
		$fechaActual = date("Y-m-d");
		$tabla = "cedis_ventas_corte";
		$datos = array("montoSuma" => $this -> montoSumarCorte,
						"id_corte" => $this -> idCorteAprobadoActualizar,
						"fecha" => $fechaActual);

		$respuesta = ModeloVentasCedis::mdlActualizarCorteDiaAprobado($tabla,$datos);

		echo json_encode($respuesta);
	}
	
	
	/*============  End of ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO  =============*/
	

	/*=============================================
	=            ESTADO CORTES DE CAJA            =
	=============================================*/
	
	public $idCorteAprobacion;
	public $EstadoCorteAprobacion;
	public function ajaxAprobacionCorteCaja(){

		$tabla = "cedis_ventas_corte";
		$datos = array("estado" => $this -> EstadoCorteAprobacion,
						"id_cedis_ventas_corte" => $this -> idCorteAprobacion);

		$respuesta = ModeloVentasCedis::mdlAprobacionCorteCaja($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ESTADO CORTES DE CAJA  ======*/

	/*====================================================================
	=                   PEDIDOS SIN FINALIZAR LINK-WEB                   =
	=====================================================================*/
	public $itemMostrarPedidos;
	public $valorMostrarPedidos;
	public function ajaxMostrarLinkWebDT(){

		$item = $this -> itemMostrarPedidos;
		$valor = $this -> valorMostrarPedidos;
		$respuesta = ModeloVentasCedis::mdlMostrarPedidosLinkWebDT($item,$valor);
		echo json_encode($respuesta);

	}
	
	/*============  End of PEDIDOS SIN FINALIZAR LINK-WEB   =============*/

	/*==================================================================
	=                   PEDIDOS FINALIZADOS LINK-WEB                   =
	==================================================================*/
	public $itemMostrarPedidosFin;
	public $valorMostrarPedidosFin;

	public function ajaxMostrarLinkWebFinalizadassDT(){
		$item = $this -> itemMostrarPedidosFin;
		$valor =  $this -> valorMostrarPedidosFin;
		$respuesta = ModeloVentasCedis::mdlMostrarVentasLWFinalizadasDT($item,$valor);
		echo json_encode($respuesta);

	}
	
	/*============  End of PEDIDOS FINALIZADOS LINK-WEB  =============*/

	
	/*=====================================================================
	=                   DESAPROBAR COMPROBANTE LINK WEB                   =
	=====================================================================*/
	
	public $folioVentaDesaprobarComprobante;
	public $vendedorVentaDesaprobarComprobante;

	public function ajaxDesaprobarComprobanteLW(){
		$vendedor = $this -> vendedorVentaDesaprobarComprobante;
		$folio = $this -> folioVentaDesaprobarComprobante;
		$respuesta = ModeloVentasCedis::mdlDesaprobarComprobanteLinkWeb($vendedor, $folio);

		echo json_encode($respuesta);
	}

	
	/*============  End of DESAPROBAR COMPROBANTE LINK WEB  =============*/
		 /*================================================
	=            Buscar producto            =
	================================================*/
	
	public $producttofind;
	public function ajaxBuscarProducto(){
		$idEmpresa = $_SESSION["idEmpresa_dashboard"];
		$producto = $this -> producttofind;
		
		$respuesta = ModeloProductos::mdlMostrarProductoPOS($idEmpresa,$producto);
		$idproducto=json_encode($respuesta);
		echo json_encode($respuesta);
	}

	/*=====  Buscar producto  ======*/
	/*================================================
	=         Buscar lista de precios producto      =
	================================================*/
	
	public $modelotofind;
	public function ajaxBuscarLDPProducto(){
		$idEmpresa = $_SESSION["idEmpresa_dashboard"];
		$modelo = $this -> modelotofind;
		
		$respuesta = ModeloProductos::mdlMostrarLDPProductoPOS($idEmpresa,$modelo);
		
		echo json_encode($respuesta);
	}

	/*=====  Buscar lista de precios producto  ======*/

	/*=============================================================================================
	=                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
	=============================================================================================*/
	public $folioVentaActualizarEstadoPago;
	public function ajaxActualizarEstadoPagoVenta(){
		$tabla ="cedis_ventas";
		$folio = $this -> folioVentaActualizarEstadoPago;
		$id_empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVentasCedis::mdlActualizarEstadoPagoVenta($tabla, $folio, $id_empresa);

		echo json_encode($respuesta);
	}
	
	/*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/
	/*=====================================
    =            FILTRAR PAGOS            =
    =====================================*/
    
    public $campo;
    public $busqueda;
    public $usuarioPlataforma;

    public function ajaxFiltrarVentas(){
        
        $datos = array("item" => $this -> campo,
                        "valor" => $this -> busqueda,
                        "id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_usuario" => $this -> usuarioPlataforma);

        $respuesta = ModeloVentasCedis::mdlFiltrarVenta($datos);
        
        echo json_encode($respuesta); 
    }
    
    /*=====  End of FILTRAR PAGOS  ======*/
    /*================================================
    =            FILTRAR Todas las Ventas            =
    ================================================*/
    
    public $campoV;
    public $busquedaV;

    public function ajaxFiltrarTodasVentas(){
        
        $datos = array("item" => $this -> campoV,
                        "valor" => $this -> busquedaV,
                        "id_empresa" => $_SESSION["idEmpresa_dashboard"]);

        $respuesta = ModeloVentasCedis::mdlFiltrarTodasVentas($datos);
		
        
        echo json_encode($respuesta); 
    }
    
    /*=====  End of FILTRAR Todas las Ventas  ======*/
	/*================================================
	=   TRAER DETALLES DEL VENTA DEVOLUCION          =
	================================================*/
	
	public $folioVentaDev;

	public function ajaxMostrarDetalleVentaDev(){

		$datos = array("folio" => $this -> folioVentaDev,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"]);
 
		$respuesta = ModeloVentasCedis::mdlMostrarDetallesVentaDev($datos);

		echo json_encode($respuesta);
	}

	/*=====  End of TRAER DETALLES DEL VENTA DEVOLUCION  ======*/
	/*=================================================================================
	=                   MOSTRAR CONFIGURACION GENERAL DE LAS VENTAS                   =
	=================================================================================*/
	
	public function ajaxMostrarConfigVentas(){
		$tabla = "configuracion_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$respuesta = ModeloVentasCedis::mdlMostrarConfiguracionGeneralVentas($tabla,$empresa);

		echo json_encode($respuesta);

	}
	
	/*============  End of MOSTRAR CONFIGURACION GENERAL DE LAS VENTAS  =============*/

}
	
	




/*================================================
=            TRAER DETALLES DEL VENTA            =
================================================*/

if (isset($_POST["folioVenta"])) {
	$detalleFolio = new AjaxVentasCedis();
	$detalleFolio -> folioVenta = $_POST["folioVenta"];
	$detalleFolio -> vendedorVenta = $_POST["vendedorVenta"];
	$detalleFolio -> ajaxMostrarDetalleVenta();
}

/*=====  End of TRAER DETALLES DEL VENTA  ======*/
/*================================================
=            TRAER DETALLES DEL VENTA            =
================================================*/

if (isset($_POST["folioVentaDetalleYDev"])) {
	$detalleFolio = new AjaxVentasCedis();
	$detalleFolio -> folioVentaDetalleYDev = $_POST["folioVentaDetalleYDev"];
	$detalleFolio -> ajaxMostrarDetalleVentaYDev();
}

/*=====  End of TRAER DETALLES DEL VENTA  ======*/

/*===========================================================
=            PETICION DE CANCELACION DE LA VENTA            =
===========================================================*/

if (isset($_POST["folioVentaPorCancelar"])) {
	$porCancelar = new AjaxVentasCedis();
	$porCancelar -> folioVentaPorCancelar = $_POST["folioVentaPorCancelar"];
	$porCancelar -> notaVentaPorCancelar = $_POST["notaVentaPorCancelar"];
	$porCancelar -> metodoVentaPorCancelar = $_POST["metodoVentaPorCancelar"];
	$porCancelar -> ajaxVentaPorCancelar();
}

/*=====  End of PETICION DE CANCELACION DE LA VENTA  ======*/

/*==========================================================
=            CANCELACION DEFINITIVA DE LA VENTA            =
==========================================================*/

if (isset($_POST["folioVentaCancelarDefinitivo"])) {
	$cancelarDefinitivo = new AjaxVentasCedis();
	$cancelarDefinitivo -> folioVentaCancelarDefinitivo = $_POST["folioVentaCancelarDefinitivo"];
	$cancelarDefinitivo -> vendedorCancelarDefinitivo = $_POST["vendedorCancelarDefinitivo"];
	$cancelarDefinitivo -> ajaxVentaCancelarDefinitivo();
}

/*=====  End of CANCELACION DEFINITIVA DE LA VENTA  ======*/


/*=================================================================
=            CANCELACION DEFINITIVA DE LA VENTA A PAGOS           =
=================================================================*/

if (isset($_POST["folioVentaPagosCancelar"])) {
	$cancelarVenta = new AjaxVentasCedis();
	$cancelarVenta -> folioVentaPagosCancelar = $_POST["folioVentaPagosCancelar"];
	$cancelarVenta -> vendedorVentaPagosCancelar = $_POST["vendedorVentaPagosCancelar"];
	$cancelarVenta -> ajaxVentaPagosCancelarDefinitivo();
}

/*=====  End of CANCELACION DEFINITIVA DE LA VENTA A PAGOS  ======*/

/*=====================================================
=            CANCELACION DE PEDIDO LINK-WEB           =
=====================================================*/

if (isset($_POST["folioVentaCancelar"])) {
	$cancelar = new AjaxVentasCedis();
	$cancelar -> folioVentaCancelar = $_POST["folioVentaCancelar"];
	$cancelar -> notaVentaCancelar = $_POST["notaVentaCancelar"];
	$cancelar -> ajaxPedidoLinkWebCancelar();
}

/*=====  End of CANCELACION DE PEDIDO LINK-WEB  =================*/

/*================================================
=            CREAR CORTE DEL VENDEDOR            =
================================================*/

if (isset($_POST["totalCorteCaja"])) {
	$crearCorte = new AjaxVentasCedis();
	$crearCorte -> totalCorteCaja = $_POST["totalCorteCaja"];
	$crearCorte -> fechaCorteCaja = $_POST["fechaCorteCaja"];
	$crearCorte -> idCorteActualizar = $_POST["idCorteActualizar"];
	$crearCorte -> ajaxCrearCorteCaja();
}

/*=====  End of CREAR CORTE DEL VENDEDOR  ======*/

/*=============================================
=                   ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO                   =
=============================================*/

if (isset($_POST["montoSumarCorte"])) {
	$actualizarCorteAprobado = new AjaxVentasCedis();
	$actualizarCorteAprobado -> montoSumarCorte = $_POST["montoSumarCorte"];
	$actualizarCorteAprobado -> idCorteAprobadoActualizar = $_POST["idCorteAprobadoActualizar"];
	$actualizarCorteAprobado -> ajaxActualizarTotalCorteCaja();
}

/*============  End of ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO  =============*/

/*================================================
=            ESTADO DE CORTES DE CAJA            =
================================================*/

if (isset($_POST["idCorteAprobacion"])) {
	$corteCaja = new AjaxVentasCedis();
	$corteCaja -> idCorteAprobacion = $_POST["idCorteAprobacion"];
	$corteCaja -> EstadoCorteAprobacion = $_POST["EstadoCorteAprobacion"];
	$corteCaja -> ajaxAprobacionCorteCaja();
}

/*=====  End of ESTADO DE CORTES DE CAJA  ======*/

/*=============================================
=                   MOSTRAR VENTAS CEDIS                   =
=============================================*/

if (isset($_POST["folioVentaMostrar"])) {
	$mostrarVenta = new AjaxVentasCedis();
	$mostrarVenta -> folioVentaMostrar = $_POST["folioVentaMostrar"];
	$mostrarVenta -> vendedorVentaMostrar = $_POST["vendedorVentaMostrar"];
	$mostrarVenta -> ajaxMostrarVentas();
}

/*============  End of MOSTRAR VENTAS CEDIS  =============*/
/*==============================================================================
=                   MOSTRAR VENTAS CEDIS Y SUMA DEVOLUCIONES                   =
==============================================================================*/

if (isset($_POST["folioVentaMostrarYSuma"])) {
	$mostrarVenta = new AjaxVentasCedis();
	$mostrarVenta -> folioVentaMostrarYSuma = $_POST["folioVentaMostrarYSuma"];
	$mostrarVenta -> ajaxMostrarVentasYSuma();
}

/*============  End of MOSTRAR VENTAS CEDIS Y SUMA DEVOLUCIONES  =============*/

/*===============================================================
=                   EDITAR ESTADO VENTA CEDIS                   =
===============================================================*/
if (isset($_POST["folioVentaEditar"])) {
	$editarEstadoVenta = new AjaxVentasCedis();
	$editarEstadoVenta -> folioVentaEditar = $_POST["folioVentaEditar"];
	$editarEstadoVenta -> vendedorVentaEditar = $_POST["vendedorVentaEditar"];
	$editarEstadoVenta -> estadoVentaEditar = $_POST["estadoVentaEditar"];
	$editarEstadoVenta -> tipoFecha = $_POST["tipoFecha"];
	$editarEstadoVenta -> ajaxEditarEstadoVenta();
}


/*============  End of EDITAR ESTADO VENTA CEDIS  =============*/

/*==========================================================================================
=                   MOSTRAR TABLA PEDIDOS SIN FINALIZAT LINK WEB DataTable                   =
==========================================================================================*/

if (isset($_POST["itemMostrarPedidos"])) {
	$mostrarPedidosLW = new AjaxVentasCedis();
	$mostrarPedidosLW -> itemMostrarPedidos = $_POST["itemMostrarPedidos"];
	$mostrarPedidosLW -> valorMostrarPedidos = $_POST["valorMostrarPedidos"];
	$mostrarPedidosLW -> ajaxMostrarLinkWebDT();
}

/*============  End of OSTRAR TABLA PEDIDOS SIN FINALIZAT LINK WEB DataTaable  =============*/

/*==========================================================================================
=                   MOSTRAR TABLA PEDIDOS FINALIZADOS LINK WEB DataTable                   =
==========================================================================================*/

if (isset($_POST["itemMostrarPedidosFin"])) {
	$mostrarTablaCanceladas = new AjaxVentasCedis();
	$mostrarTablaCanceladas -> itemMostrarPedidosFin = $_POST["itemMostrarPedidosFin"];
	$mostrarTablaCanceladas -> valorMostrarPedidosFin = $_POST["valorMostrarPedidosFin"];
	$mostrarTablaCanceladas -> ajaxMostrarLinkWebFinalizadassDT();
}

/*============  End of MOSTRAR TABLA PEDIDOS FINALIZADOS LINK WEB DataTabl  =============*/


/*=====================================================================
=                   DESAPROBAR COMPROBANTE LINK WEB                   =
=====================================================================*/

if (isset($_POST["folioVentaDesaprobarComprobante"])) {
	$desaprobarComprobante = new AjaxVentasCedis();
	$desaprobarComprobante -> folioVentaDesaprobarComprobante = $_POST["folioVentaDesaprobarComprobante"];
	$desaprobarComprobante -> vendedorVentaDesaprobarComprobante = $_POST["vendedorVentaDesaprobarComprobante"];
	$desaprobarComprobante -> ajaxDesaprobarComprobanteLW();
}

/*============  End of DESAPROBAR COMPROBANTE LINK WEB  =============*/
/*================================================
=                 Buscar producto                =
================================================*/

if (isset($_POST["Productobuscar"])) {
	$productotf = new AjaxVentasCedis();
	$productotf -> producttofind = $_POST["Productobuscar"];
	$productotf -> ajaxBuscarProducto();
}

/*=====                 Buscar producto                ======*/
/*================================================
=                 Buscar lista de precios producto                =
================================================*/

if (isset($_POST["Listadeprecios"])) {
	$modelotof = new AjaxVentasCedis();
	$modelotof -> modelotofind = $_POST["Listadeprecios"];
	$modelotof -> ajaxBuscarLDPProducto();
}

/*=====   Buscar lista de precios producto     ======*/

/*=============================================================================================
=                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
=============================================================================================*/

if (isset($_POST["folioVentaActualizarEstadoPago"])) {
	$cambiarEstadoPedido = new AjaxVentasCedis();
	$cambiarEstadoPedido -> folioVentaActualizarEstadoPago = $_POST["folioVentaActualizarEstadoPago"];
	$cambiarEstadoPedido -> ajaxActualizarEstadoPagoVenta();
}

/*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/
/*======================================
=            FILTRAR VENTAS            =
======================================*/

if (isset($_POST["campo"])) {
    $filtrar = new AjaxVentasCedis();
    $filtrar -> campo = $_POST["campo"];
    $filtrar -> busqueda = $_POST["busqueda"];
    $filtrar -> usuarioPlataforma = $_POST["usuarioPlataforma"];
    $filtrar -> ajaxFiltrarVentas();
}

/*=====  End of FILTRAR PAGOS  ======*/

/*======================================
=            FILTRAR VENTAS            =
======================================*/

if (isset($_POST["campoV"])) {
    $filtrar = new AjaxVentasCedis();
    $filtrar -> campoV = $_POST["campoV"];
    $filtrar -> busquedaV = $_POST["busquedaV"];
    $filtrar -> ajaxFiltrarTodasVentas();
}

/*=====  End of VENTAS  ======*/
/*================================================
=    TRAER DETALLES DEL VENTA DEVOLUCIÓN         =
================================================*/

if (isset($_POST["folioVentaDev"])) {
	$detalleFolio = new AjaxVentasCedis();
	$detalleFolio -> folioVentaDev = $_POST["folioVentaDev"];
	$detalleFolio -> ajaxMostrarDetalleVentaDev();
}

/*=====  End of TRAER DETALLES DEL VENTA DEVOLUCIÓN  ======*/

/*=====================================================================
=                   MOSTRAR CONFIGURACION DE VENTAS                   =
=====================================================================*/

if (isset($_POST["aux"])) {
	$mostrarConfig = new AjaxVentasCedis();
	$mostrarConfig -> ajaxMostrarConfigVentas();
}

/*============  End of MOSTRAR CONFIGURACION DE VENTAS  =============*/

?> 