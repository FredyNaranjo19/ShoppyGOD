<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.vendedorext-pedidos.php';
require_once '../../modelos/dashboard/modelo.ventas.php';
require_once '../../modelos/dashboard/modelo.pedidos.php';
require_once '../../modelos/dashboard/modelo.productos.php';

class AjaxVentas{

	/*=====================================
	=            MOSTRAR VENTA            =
	=====================================*/
	
	public function ajaxMostrarVenta(){

		$tabla = "ventas";
		$item = "folio";
		$valor = $this -> folioVenta;
		$almacen = $this -> almacenVenta;

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor, $almacen);

		echo json_encode($respuesta);	
	}
	
	/*=====  End of MOSTRAR VENTA  ======*/
	

	/*=================================================
	=            TRAER DETALLES DEL PEDIDO            =
	=================================================*/
	
	public $folioPedido;

	public function ajaxMostrarDetallePedido(){

		$datos = array("folio" => $this -> folioPedido,
						"id_almacen" => $_SESSION["almacen_dashboard"]);
 
		$respuesta = ModeloVentas::mdlMostrarDetallesVenta($datos);

		echo json_encode($respuesta);
	}

	/*=====  End of TRAER DETALLES DEL PEDIDO  ======*/

	/*================================================
	=            CREAR CORTE DEL VENDEDOR            =
	================================================*/
	
	public $totalCorteCaja;
	public $fechaCorteCaja;
	public $idCorteActualizar;
	
	public function ajaxCrearCorteCaja(){

		$tabla = "ventas_cortes";

		if ($this -> idCorteActualizar != 0) {
			$datos = array("total" => $this -> totalCorteCaja,
							"fecha" => $this -> fechaCorteCaja,
							"id_corte" => $this -> idCorteActualizar);

			$respuesta = ModeloVentas::mdlActualizarCorteDia($tabla, $datos);
		}else{
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"id_almacen" => $_SESSION["almacen_dashboard"],
							"id_usuario_plataforma" => $_SESSION["id_dashboard"],
							"total" => $this -> totalCorteCaja,
							"fecha" => $this -> fechaCorteCaja);
			
			$respuesta = ModeloVentas::mdlCrearCorteCaja($tabla, $datos);
		}



		echo json_encode($respuesta);

	}
	
	/*=====  End of CREAR CORTE DEL VENDEDOR  ======*/
	
	/*=============================================
	=            ESTADO CORTES DE CAJA            =
	=============================================*/
	
	public $idCorteAprobacion;
	public $EstadoCorteAprobacion;
	public function ajaxAprobacionCorteCaja(){

		$tabla = "ventas_cortes";
		$datos = array("estado" => $this -> EstadoCorteAprobacion,
						"id_cortes" => $this -> idCorteAprobacion);

		$respuesta = ModeloVentas::mdlAprobacionCorteCaja($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ESTADO CORTES DE CAJA  ======*/

	/*===========================================================
	=            PETICION DE CANCELACION DE LA VENTA            =
	===========================================================*/
	
	// public $folioVentaPorCancelar;
	// public $notaVentaPorCancelar;

	// public function ajaxVentaPorCancelar(){

	// 	/* CAMBIO DE ESTADO VENTAS */
		
	// 	$tabla = "ventas";
	// 	$datos = array("id_almacen" => $_SESSION["almacen_dashboard"], 
	// 					"folio" => $this -> folioVentaPorCancelar,
	// 					"notaCancelacion" => $this -> notaVentaPorCancelar,
	// 					"estado" => "Cancelada");

	// 	$respuesta = ModeloVentas::mdlVentaPorCancelar($tabla, $datos);


	// 	echo json_encode($respuesta);

	// }
	
	/*=====  End of PETICION DE CANCELACION DE LA VENTA  ======*/

	/*============================================
	=            CANCELACION DE VENTA            =
	============================================*/
	
	public $folioVentaCancelar;
	public $notaVentaCancelar;

	public function ajaxVentaCancelar(){
 
		/* CAMBIO DE ESTADO VENTAS */
		$tabla = "ventas";
		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"], 
						"folio" => $this -> folioVentaCancelar,
						"estado" => "Cancelada",
						"notaCancelacion" => $this -> notaVentaCancelar);

		$respuesta = ModeloVentas::mdlVentaCancelar($tabla, $datos);


		/* RETORNO DE CANTIDAD EN PRODUCTOS */

		$datos = array("folio" => $this -> folioVentaCancelar,
						"id_almacen" => $_SESSION["almacen_dashboard"]);
		
		$detalle = ModeloVentas::mdlMostrarDetallesVenta($datos);

		foreach ($detalle as $key => $value) {

			$tabla = "almacenes_productos";
			$datos = array("stock" => $value["cantidad"],
							"id_producto" => $value["id_producto"],
							"id_almacen" => $_SESSION["almacen_dashboard"]);

			$retorno = ModeloVentas::mdlRetornoProductoCancelacion($tabla, $datos);

		}

		echo json_encode($respuesta); 



	}
	
	/*=====  End of CANCELACION DE VENTA  ======*/

	/*==============================================================================
	=                   CANCELAR VENTA A PAGOS Y SU PAGO INICIAL                   =
	==============================================================================*/

	public $folioVentaPagosCancelar;
	public $notaVentaPagosCancelar;
	public $fechaVentaPagosCancelar;
	public function ajaxVentaPagosCancelar(){ 
		/* CAMBIO DE ESTADO VENTAS */
		$tabla = "ventas";
		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"], 
						"folio" => $this -> folioVentaPagosCancelar,
						"estado" => "Cancelada",
						"notaCancelacion" => $this -> notaVentaPagosCancelar);

		$respuesta = ModeloVentas::mdlVentaCancelar($tabla, $datos);


		// /* RETORNO DE CANTIDAD EN PRODUCTOS */

		$datos = array("folio" => $this -> folioVentaPagosCancelar,
						"id_almacen" => $_SESSION["almacen_dashboard"]);
		
		$detalle = ModeloVentas::mdlMostrarDetallesVenta($datos);

		foreach ($detalle as $key => $value) {

			$tabla = "almacenes_productos";
			$datos = array("stock" => $value["cantidad"],
							"id_producto" => $value["id_producto"],
							"id_almacen" => $_SESSION["almacen_dashboard"]);

			$retorno = ModeloVentas::mdlRetornoProductoCancelacion($tabla, $datos);

		}

		$tablaVP = "ventas_pagos";
		$datos = array("folio" => $this -> folioVentaPagosCancelar,
						"id_almacen" => $_SESSION["almacen_dashboard"],
						"fecha_pago" => $this -> fechaVentaPagosCancelar);
		$cancelacion = ModeloVentas::mdlCancelarPagoVentaPagos($tablaVP, $datos);
		
		echo json_encode($cancelacion);
	}
	
	
	/*============  End of CANCELAR VENTA A PAGOS Y SU PAGO INICIAL  =============*/

	/*====================================================
	=            MOSTRAR VENTAS PAGOS ALMACEN            =
	====================================================*/
	
	public $almacenVentas;
	public function ajaxMostrarVentasPagosAlmacen(){

		$almacen = $this -> almacenVentas;

		$respuesta = ModeloVentas::mdlMostrarVentasPagosAlmace($almacen);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR VENTAS PAGOS ALMACEN  ======*/

	/*==================================================
	=            MOSTRAR VENTAS DEL CLIENTE            =
	==================================================*/
	
	public $idClienteVentas;
	public function ajaxVentasCliente(){
		
		$item = "id_cliente";
		$valor = $this -> idClienteVentas;

		/* MOSTRAR VENTAS ALMACENES POR CLIENTE
		-------------------------------------------------- */
		$tabla = "ventas";

		$ventas = ModeloVentas::mdlMostrarVentasCliente($tabla, $item, $valor);
		
		$noVentas = 0;
		$total = 0;
		$fecha = "";

		foreach ($ventas as $key => $value) {
			
			$noVentas = $noVentas + 1;
			$total = $total + $value["total"];
			$fecha = $value["fecha"];

		}

		/* MOSTRAR VENTAS CEDIS POR CLIENTE
		-------------------------------------------------- */
		$tabla_cedis = "cedis_ventas";

		$ventasCedis = ModeloVentas::mdlMostrarVentasCliente($tabla_cedis, $item, $valor);

		$noVentasCedis = 0;
		$totalCedis = 0;
		$fechaCedis = "";

		foreach ($ventasCedis as $key => $value) {
			
			$noVentasCedis = $noVentasCedis + 1;
			$totalCedis = $totalCedis + $value["total"];
			$fechaCedis = $value["fecha"];

		}

		/* MOSTRAR VENTAS VENDEDOR EXT
		-------------------------------------------------- */
		$tablaVE = "vendedorext_pedidos";

		$ventasVE = ModeloVendedorextPedidos::mdlMostrarVentasCliente($tablaVE, $item, $valor);

		$noVentasVE = 0;
		$totalVE = 0;
		$fechaVE = "";

		foreach ($ventasVE as $key => $value) {
			
			$noVentasVE = $noVentasVE + 1;
			$totalVE = $totalVE + $value["total"];
			$fechaVE = $value["fecha_entrega"];

		}
		

		$totalNoVentas = $noVentas + $noVentasCedis + $noVentasVE;
		$totalPagadoVentas = $total + $totalCedis + $totalVE;
		$fechas = ["fecha cedis" => $fechaCedis,
					"fecha almacenes" => $fecha,
					"fecha VE" => $fechaVE];

		sort($fechas, SORT_STRING);

		$respuesta = array("noVentas" => $totalNoVentas,
							"totalVentas" => number_format($totalPagadoVentas,"2",".",","),
							"fecha" => $fechas[2]);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR VENTAS DEL CLIENTE  ======*/
	

		
	
}

/*======================================
=            MOSTRAR VENTA             =
======================================*/

if (isset($_POST["folioVenta"])) {
	$mostrarVenta = new AjaxVentas();
	$mostrarVenta -> folioVenta = $_POST["folioVenta"];
	$mostrarVenta -> almacenVenta = $_POST["almacenVenta"];
	$mostrarVenta -> ajaxMostrarVenta();
}

/*=====  End of MOSTRAR VENTA   ======*/

/*=================================================
=            TRAER DETALLES DEL PEDIDO            =
=================================================*/

if (isset($_POST["folioPedido"])) {
	$detalleFolio = new AjaxVentas();
	$detalleFolio -> folioPedido = $_POST["folioPedido"];
	$detalleFolio -> ajaxMostrarDetallePedido();
}

/*=====  End of TRAER DETALLES DEL PEDIDO  ======*/

/*================================================
=            CREAR CORTE DEL VENDEDOR            =
================================================*/

if (isset($_POST["totalCorteCaja"])) {
	$crearCorte = new AjaxVentas();
	$crearCorte -> totalCorteCaja = $_POST["totalCorteCaja"];
	$crearCorte -> fechaCorteCaja = $_POST["fechaCorteCaja"];
	$crearCorte -> idCorteActualizar = $_POST["idCorteActualizar"];
	$crearCorte -> ajaxCrearCorteCaja();
}

/*=====  End of CREAR CORTE DEL VENDEDOR  ======*/


/*================================================
=            ESTADO DE CORTES DE CAJA            =
================================================*/

if (isset($_POST["idCorteAprobacion"])) {
	$corteCaja = new AjaxVentas();
	$corteCaja -> idCorteAprobacion = $_POST["idCorteAprobacion"];
	$corteCaja -> EstadoCorteAprobacion = $_POST["EstadoCorteAprobacion"];
	$corteCaja -> ajaxAprobacionCorteCaja();
}

/*=====  End of ESTADO DE CORTES DE CAJA  ======*/

/*============================================
=            CANCELACION DE VENTA            =
============================================*/

if (isset($_POST["folioVentaCancelar"])) {
	$cancelar = new AjaxVentas();
	$cancelar -> folioVentaCancelar = $_POST["folioVentaCancelar"];
	$cancelar -> notaVentaCancelar = $_POST["notaVentaCancelar"];
	$cancelar -> ajaxVentaCancelar();
}

/*=====  End of CANCELACION DE VENTA  ======*/

/*============================================
=            CANCELACION DE VENTA            =
============================================*/

if (isset($_POST["folioVentaPagosCancelar"])) {
	$cancelarVenta = new AjaxVentas();
	$cancelarVenta -> folioVentaPagosCancelar = $_POST["folioVentaPagosCancelar"];
	$cancelarVenta -> notaVentaPagosCancelar = $_POST["notaVentaPagosCancelar"];
	$cancelarVenta -> fechaVentaPagosCancelar = $_POST["fechaVentaPagosCancelar"];
	$cancelarVenta -> ajaxVentaPagosCancelar();
}

/*=====  End of CANCELACION DE VENTA  ======*/

/*=======================================================
=            MOSTRAR VENTAS PAGOS DE ALMACEN            =
=======================================================*/

if (isset($_POST["almacenVentas"])) {
	$ventasAlmacen = new AjaxVentas();
	$ventasAlmacen -> almacenVentas = $_POST["almacenVentas"];
	$ventasAlmacen -> ajaxMostrarVentasPagosAlmacen();
}

/*=====  End of MOSTRAR VENTAS PAGOS DE ALMACEN  ======*/

/*===================================================
=            MOSTRAR VENTAS DEL CLIENTE             =
===================================================*/

if (isset($_POST["idClienteVentas"])) {
	$ventasCliente = new AjaxVentas();
	$ventasCliente -> idClienteVentas = $_POST["idClienteVentas"];
	$ventasCliente -> ajaxVentasCliente();
}

/*=====  End of MOSTRAR VENTAS DEL CLIENTE   ======*/

?>