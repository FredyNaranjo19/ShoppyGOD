<?php
session_start();

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.pedidos.php';


class AjaxPedidos{

	/*====================================================
	=            MOSTRAR CONTENIDO DEL PEDIDO            =
	====================================================*/
	
	public $folioPedido;

	public function ajaxMostrarDetallesPedido(){

		$tabla = "tv_pedidos_detalle";
		$item = "folio";
		$valor = $this -> folioPedido;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloPedidos::mdlMostrarDetallePedido($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR CONTENIDO DEL PEDIDO  ======*/

	/*==============================================================
	=            MOSTRAR COMPROBANTE DE PAGO (EFECTIVO)            =
	==============================================================*/
	
	public $PedidentesfolioComprobanteEfectivo;
	public function ajaxMostrarComprobanteEfectivo(){

		$tabla = "tv_pedidos_comprobantes_pago";
		$item = "folio";
		$valor = $this -> PedidentesfolioComprobanteEfectivo;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloPedidos::mdlMostrarComprobanteEfectivo($tabla,$item, $valor, $empresa);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR COMPROBANTE DE PAGO (EFECTIVO)  ======*/

	/*======================================================================
	=            ACCION DE COMPROBANTE (APROBADO O DESAPROBADO)            =
	======================================================================*/
	
	public $folioDecision;
	public $estadoDecision;

	public function ajaxAccionComprobante(){

		if ($this -> estadoDecision == "Aprobado") {

			$estadoPedido = "Aprobado";

		} else {

			$estadoPedido = "Desaprobado";

		}
		
		/* CAMBIAR ESTADO DE COMPROBANTE */

		$tabla = "tv_pedidos_comprobantes_pago";
		$datos = array("estado" => $estadoPedido,
						"folio" => $this -> folioDecision,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

		$respuesta = ModeloPedidos::mdlModificarEstadoComprobantePagoEfectivo($tabla, $datos);

		/* CAMBIAR ESTADO EN PEDIDOS */ 

		$tablaPedidos = "tv_pedidos";
		$datosPedidos = array("estado" => $estadoPedido,
						"folio" => $this -> folioDecision,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

		$respuestaPedidos = ModeloPedidos::mdlCambioEstadoPedido($tablaPedidos, $datosPedidos);

		/* CAMBIAR ESTADO DE ENTREGAS */
		$varEstado = $this -> estadoDecision;

		if ($varEstado == "Aprobado") {

			$estado = "En preparación";

		} else {

			$estado = $varEstado;
		}

		$tablaEntregas = "tv_pedidos_entregas";
		$datosEntregas = array("estado_entrega" => $estado,
								"folio" => $this -> folioDecision,
								"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

		$respuestaEntregas = ModeloPedidos::mdlModificarEstadoPreparacion($tablaEntregas, $datosEntregas);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ACCION DE COMPROBANTE (APROBADO O DESAPROBADO)  ======*/


//*************************************************************************************
//*************************************************************************************
//*************************************************************************************

	/*============================================================
	=            CAMBIO ESTADO EN SECCION PREPARACION            =
	============================================================*/
	public $folioPreparacion;
	public $statusPreparacion;
	public function ajaxCambioEstadoPreparacion(){

		$tabla = "tv_pedidos_entregas";
		$datos = array("folio" => $this -> folioPreparacion,
						"estado_entrega" => $this -> statusPreparacion,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

		$respuesta = ModeloPedidos::mdlModificarEstadoPreparacion($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of CAMBIO ESTADO EN SECCION PREPARACION  ======*/
	
	/*==============================================
	=            CANCELACION DEL PEDIDO            =
	==============================================*/
	
	public $folioPedidoCancelar;
	public $tipoPedidoCancelar;

	public function ajaxCancelarPedido(){
				
		$tabla = "tv_pedidos";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"folio" => $this -> folioPedidoCancelar,
						"estado" => "Cancelada");

		$respuestaPedido = ModeloPedidos::mdlCambioEstadoPedido($tabla, $datos);

		$tablaEntrega = "tv_pedidos_entregas";
		$datosEntrega = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"folio" => $this -> folioPedidoCancelar,
								"estado_entrega" => "Cancelada");

		$respuestaEntregas = ModeloPedidos::mdlModificarEstadoPreparacion($tablaEntrega, $datosEntrega);


		/* RETORNO DE CANTIDAD EN PRODUCTOS */
		$tablaDetalles = "tv_pedidos_detalle";
		
		$item = "folio";
		$valor = $this -> folioPedidoCancelar;
		$empresa = $_SESSION["idEmpresa_dashboard"];
		
		$detalle = ModeloPedidos::mdlMostrarDetallePedido($tablaDetalles,$item,$valor,$empresa);

		foreach ($detalle as $key => $value) {

			$tablaRetorno = "productos";
			$datosRetorno = array("stock_disponible" => $value["cantidad"],
									"id_producto" => $value["id_producto"],
									"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

			$retorno = ModeloPedidos::mdlRetornoProductoCancelacion($tablaRetorno, $datosRetorno);

		}
 
		echo json_encode($respuestaPedido); 

	}
	
	/*=====  End of CANCELACION DEL PEDIDO  ======*/

}

/*====================================================
=            MOSTRAR CONTENIDO DEL PEDIDO            =
====================================================*/

if (isset($_POST["folioPedido"])) {
	$detallePedido = new AjaxPedidos();
	$detallePedido -> folioPedido = $_POST["folioPedido"];
	$detallePedido -> ajaxMostrarDetallesPedido();
}

/*=====  End of MOSTRAR CONTENIDO DEL PEDIDO  ======*/

/*==============================================================
=            MOSTRAR COMPROBANTE DE PAGO (EFECTIVO)            =
==============================================================*/

if (isset($_POST["PedidentesfolioComprobanteEfectivo"])) {
	$comprobanteEfectivo = new AjaxPedidos();
	$comprobanteEfectivo -> PedidentesfolioComprobanteEfectivo = $_POST["PedidentesfolioComprobanteEfectivo"];
	$comprobanteEfectivo -> ajaxMostrarComprobanteEfectivo();

}

/*=====  End of MOSTRAR COMPROBANTE DE PAGO (EFECTIVO)  ======*/

/*======================================================================
=            ACCION DE COMPROBANTE (APROBADO O DESAPROBADO)            =
======================================================================*/

if (isset($_POST["folioAprobacionEfectivo"])) {
	$desicion = new AjaxPedidos();
	$desicion -> folioDecision = $_POST["folioAprobacionEfectivo"];
	$desicion -> estadoDecision = $_POST["estadoAprobacionEfectivo"];
	$desicion -> ajaxAccionComprobante();
}

/*=====  End of ACCION DE COMPROBANTE (APROBADO O DESAPROBADO)  ======*/

/*=================================================================================
=            CAMBIAR ESTADO EN SECCION DE ENTREGAS(ENTREGADO SUCURSAL)            =
=================================================================================*/

if (isset($_POST["folioStatusEntregado"])) {
	
	$pedidoEntrega = new AjaxPedidos();
	$pedidoEntrega -> folioStatusEntregado = $_POST["folioStatusEntregado"];
	$pedidoEntrega -> estadoEntregadoPedido = $_POST["estadoEntregadoPedido"];
	$pedidoEntrega -> tipoPedidoEntregado = $_POST["tipoPedidoEntregado"];
	$pedidoEntrega -> ajaxModificarEstadoEntregado();
}

/*=====  End of CAMBIAR ESTADO EN SECCION DE ENTREGAS(ENTREGADO SUCURSAL)  ======*/

//*************************************************************************************
//*************************************************************************************
//*************************************************************************************

/*=============================================================
=            CAMBIAR ESTADO EN SECCION PREPARACION            =
=============================================================*/

if (isset($_POST["folioStatusPreparacion"])) {
	$preparacion = new AjaxPedidos();
	$preparacion -> folioPreparacion = $_POST["folioStatusPreparacion"];
	$preparacion -> statusPreparacion = $_POST["entregaStatusPreparacion"];
	$preparacion -> ajaxCambioEstadoPreparacion();
}

/*=====  End of CAMBIAR ESTADO EN SECCION PREPARACION  ======*/

//*************************************************************************************
//*************************************************************************************
//*************************************************************************************

/*==============================================
=            CAMCELACION DEL PEDIDO            =
==============================================*/

if (isset($_POST["folioPedidoCancelar"])) {
	
	$cancelarPedido = new AjaxPedidos();
	$cancelarPedido -> folioPedidoCancelar = $_POST["folioPedidoCancelar"];
	$cancelarPedido -> ajaxCancelarPedido();

}

/*=====  End of CAMCELACION DEL PEDIDO  ======*/

?>