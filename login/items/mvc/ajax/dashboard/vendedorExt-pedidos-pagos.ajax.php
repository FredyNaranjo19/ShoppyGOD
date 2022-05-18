<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.vendedorext-pedidos.php';

class AjaxVendExtPagosPedidos {
    /*=============================================================
    =                   MOSTRAR PEDIDOS A PAGOS                   =
    =============================================================*/
    public $folioPedido;
    public $usuarioPlataforma;

    public function ajaxMostrarPedidosPagos(){
        $tabla = "vendedorext_pedidos_pagos";
        $datos = array("id_usuario_plataforma" => $this -> usuarioPlataforma,
                        "folioPedido" => $this -> folioPedido);

        $respuesta = ModeloVendedorextPedidos::mdlMostrarPagosPedidosDataTable($tabla, $datos);

        echo json_encode($respuesta);
    }
    
    /*============  End of MOSTRAR PEDIDOS A PAGOS  =============*/

    /*==========================================================
    =                   CREAR PAGO DE PEDIDO                   =
    ==========================================================*/
    public $montoPagoPedido;
    public $tipoPagoPedido;
    public $comprobantePago;
    public $vendedor;
    public $folio;
    public function ajaxCrearPagoPedido(){
    
        $tabla = "vendedorext_pedidos_pagos";
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_usuario_plataforma" => $this -> vendedor,
                        "folio" => $this -> folio,
                        "monto" => $this -> montoPagoPedido,
                        "comprobante" => $this -> comprobantePago,
                        "estado_pago" => $this -> tipoPagoPedido);

        $respuesta = ModeloVendedorextPedidos::mdlHacerPago($tabla, $datos);

        echo json_encode($respuesta);

    }
    
    
    /*============  End of CREAR PAGO DE PEDIDO  =============*/

    /*==========================================================================
    =                   RESTAR MONTO COMPROBANTE DESAPROBADO                   =
    ==========================================================================*/
    public $montoRestarCorte;
	public $idCorteAprobadoActualizar;

	public function ajaxActualizarTotalCorteCaja(){
		$tabla = "vendedorext_pedidos_cortes";
		$datos = array("montoResta" => $this -> montoRestarCorte,
						"id_corte" => $this -> idCorteAprobadoActualizar);

		$respuesta = ModeloVendedorextPedidos::mdlActualizarCorteDiaAprobado($tabla,$datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of RESTAR MONTO COMPROBANTE DESAPROBADO  =============*/

    /*===========================================================================================
    =                   MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos                   =
    ===========================================================================================*/
    public $idVendedorMostrarCorte;

	public function ajaxMostrarSiHayCorte(){
		date_default_timezone_set("America/Mexico_City");
		$fechaActual = date("Y-m-d");

		$tabla = "vendedorext_pedidos_cortes";
        
		$datos = array("id_vendedor" => $this -> idVendedorMostrarCorte,
						"fecha" => $fechaActual);

        $respuesta = ModeloVendedorextPedidos::mdlMostrarCortesVentasDia($tabla, $datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos   =============*/


    /*==============================================================
    =                   APROBAR DESAPROBAR PAGOS                   =
    ==============================================================*/
    public $idPagoAprobar;
    public $estadoPagoAprobar;

    public function ajaxAprobarPagoPedido(){
        $tabla = "vendedorext_pedidos_pagos";
        $datos = array("estado_pago" => $this -> estadoPagoAprobar,
                        "id_pago" => $this -> idPagoAprobar);
        
        $respuesta = ModeloVendedorextPedidos::mdlAprobarPagoPedido($tabla, $datos);
        
        echo json_encode($respuesta);
    }
    
    
    /*============  End of APROBAR DESAPROBAR PAGOS  =============*/

    

    /*=========================================================================
	=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
	=========================================================================*/

    public $folioPedidoMostrarPagos;
    public $vendedorCancelarPago;

    public function ajaxMostrarPagosCancelados(){
        $tabla = "ventas_pagos";
        $datos = array("folio" => $this -> folioPedidoMostrarPagos,
                        "id_usuario_plataforma" => $this -> vendedorCancelarPago);

        $respuesta = ModeloVendedorextPedidos::mdlMostrarPagosCanceladosDesaprobados($tabla, $datos);

        echo json_encode($respuesta);
    }

    /*============  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE  =============*/


    /*=====================================================================================
    =                   GUARDAR CONFIGURACION DE PEDIDOS PAGOS VEND EXT                   =
    =====================================================================================*/
    
    public $idVendedorConfiguracionVendExt;
    public $jsonPagoInicialConfiguracionVendExt;
    public $jsonPeriodosConfiguracionVendExt;
    public $promocionConfiguracionVendExt;

    public function ajaxGuardarConfiguracionPagos(){
        $tabla = "vendedorext_pagos_configuracion";
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_usuario_plataforma" => $this -> idVendedorConfiguracionVendExt,
                        "pago_inicial" => $this -> jsonPagoInicialConfiguracionVendExt,
                        "periodos" => $this -> jsonPeriodosConfiguracionVendExt,
                        "promocion_pedido" => $this -> promocionConfiguracionVendExt);
        
        $respuesta = ModeloVendedorextPedidos::mdlGuardarConfiguracionPedidosPagos($tabla, $datos);

        echo json_encode($respuesta);
    }

    /*=====================================================================================
    =                   MOSTRAR CONFIGURACION DE PEDIDOS PAGOS VEND EXT                   =
    =====================================================================================*/
    
    public $idVendedorConfig;

    public function ajaxMostrarConfiguracionPedidosPagos(){
        $tabla = "vendedorext_pagos_configuracion";
        $item = "id_usuario_plataforma";
        $valor = $this -> idVendedorConfig;

        $respuesta = ModeloVendedorextPedidos::mdlMostrarConfiguracionPedidosPagos($tabla,$item,$valor);

        echo json_encode($respuesta);
    }

    /*===========================================================
    =                   FILTRAR PEDIDOS PAGOS                   =
    ===========================================================*/
    
    public $campoPedidosVE;
    public $busquedaPedidosVE;

    public function ajaxFiltrarPedidosPagos(){
        $datos = array("item" => $this -> campoPedidosVE,
                        "valor" => $this -> busquedaPedidosVE,
                        "id_usuario_plataforma" => $_SESSION["id_dashboard"],
                        "id_empresa" => $_SESSION["idEmpresa_dashboard"]);
        
        $respuesta = ModeloVendedorextPedidos::mdlFiltrarPedidosVendedorExt($datos);

        echo json_encode($respuesta);
    }
    

}

/*=============================================================
=                   MOSTRAR PEDIDOS A PAGOS                   =
=============================================================*/

if (isset($_POST["folioPedido"])) {
    $mostrarPedidos = new AjaxVendExtPagosPedidos();
    $mostrarPedidos -> folioPedido = $_POST["folioPedido"];
    $mostrarPedidos -> usuarioPlataforma = $_POST["idUsuarioPlataforma"];
    $mostrarPedidos -> ajaxMostrarPedidosPagos();
}

/*============  End of MOSTRAR PEDIDOS A PAGOS  =============*/

/*============================================================
=                   CREAR PAGO DE PEDIDO                   =
============================================================*/

if (isset($_POST["montoPagoPedido"])) {
    $crearPagoPedido = new AjaxVendExtPagosPedidos();
    $crearPagoPedido -> montoPagoPedido = $_POST["montoPagoPedido"];
    $crearPagoPedido -> tipoPagoPedido = $_POST["tipoPagoPedido"];
    $crearPagoPedido -> comprobantePago = $_POST["comprobantePago"];
    $crearPagoPedido -> vendedor = $_POST["vendedor"];
    $crearPagoPedido -> folio = $_POST["folio"];
    $crearPagoPedido -> ajaxCrearPagoPedido();

}

/*============  End of GUARDAR PAGO DE PEDIDO  =============*/

/*==============================================================
=                   APROBAR DESAPROBAR PAGOS                   =
==============================================================*/

if (isset($_POST["idPagoAprobar"])) {
    $aprobar = new AjaxVendExtPagosPedidos();
    $aprobar -> idPagoAprobar = $_POST["idPagoAprobar"];
    $aprobar -> estadoPagoAprobar = $_POST["estadoPagoAprobar"];
    $aprobar -> ajaxAprobarPagoPedido();
}

/*============  End of APROBAR DESAPROBAR PAGOS  =============*/

/*================================================================================
=                   ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO                   =
================================================================================*/

if (isset($_POST["montoRestarCorte"])) {
	$actualizarCorteAprobado = new AjaxVendExtPagosPedidos();
	$actualizarCorteAprobado -> montoRestarCorte = $_POST["montoRestarCorte"];
	$actualizarCorteAprobado -> idCorteAprobadoActualizar = $_POST["idCorteAprobadoActualizar"];
	$actualizarCorteAprobado -> ajaxActualizarTotalCorteCaja();
}

/*============  End of ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO  =============*/

/*===========================================================================================
=                   MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos                   =
===========================================================================================*/

if (isset($_POST["idVendedorMostrarCorte"])) {
	$mostrarCorte = new AjaxVendExtPagosPedidos();
	$mostrarCorte -> idVendedorMostrarCorte = $_POST["idVendedorMostrarCorte"];
	$mostrarCorte -> ajaxMostrarSiHayCorte();
}

/*============  End of MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos  =============*/

/*=========================================================================
=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
=========================================================================*/

if (isset($_POST["folioPedidoMostrarPagos"])) {
	$mostrarPagosCancelados = new AjaxVendExtPagosPedidos();
	$mostrarPagosCancelados -> folioPedidoMostrarPagos = $_POST["folioPedidoMostrarPagos"];
	$mostrarPagosCancelados -> vendedorCancelarPago = $_POST["vendedorCancelarPago"];
	$mostrarPagosCancelados -> ajaxMostrarPagosCancelados();
}

/*============  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE  =============*/


/********************************************************************
*********************************************************************
*******CONFIGURACION PAGOS VENDEDOR EXTERNO
*********************************************************************
********************************************************************/

/*=================================================================================
=                   GUARDAR CONFIGURACION DE PAGOS VENDEDOR EXT                   =
=================================================================================*/

if (isset($_POST["idVendedorConfiguracionVendExt"])) {
    $guardarConfiguracion = new AjaxVendExtPagosPedidos();
    $guardarConfiguracion -> idVendedorConfiguracionVendExt = $_POST["idVendedorConfiguracionVendExt"];
    $guardarConfiguracion -> jsonPagoInicialConfiguracionVendExt = $_POST["jsonPagoInicialConfiguracionVendExt"];
    $guardarConfiguracion -> jsonPeriodosConfiguracionVendExt = $_POST["jsonPeriodosConfiguracionVendExt"];
    $guardarConfiguracion -> promocionConfiguracionVendExt = $_POST["promocionConfiguracionVendExt"];
    $guardarConfiguracion -> ajaxGuardarConfiguracionPagos();
}

/*============  End of GUARDAR CONFIGURACION DE PAGOS VENDEDOR EXT  =============*/

/*===================================================================================
=                   MOSTRAR LA CONFIGURACION DE PAGOS UN VENDEDOR                   =
===================================================================================*/

if (isset($_POST["idVendedorConfig"])) {
    $mostrarConfiguracion = new AjaxVendExtPagosPedidos();
    $mostrarConfiguracion -> idVendedorConfig = $_POST["idVendedorConfig"];
    $mostrarConfiguracion -> ajaxMostrarConfiguracionPedidosPagos();
}

/*============  End of MOSTRAR LA CONFIGURACION DE UN VENDEDOR  =============*/

/*********************************************************************************
**********************************************************************************
******** FILTRAR PEDIDOS PAGOS
**********************************************************************************
**********************************************************************************/

if (isset($_POST["campoPedidosVE"])) {
    $filtrarPedidos = new AjaxVendExtPagosPedidos();
    $filtrarPedidos -> campoPedidosVE = $_POST["campoPedidosVE"];
    $filtrarPedidos -> busquedaPedidosVE = $_POST["busquedaPedidosVE"];
    $filtrarPedidos -> ajaxFiltrarPedidosPagos();
}
?>