<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.ventas.php';

class AjaxPagosVentas {

    /*======================================
    =            MOSTRAR VENTAS            =
    ======================================*/
    
    public $folioMostrar;
    public $almacenMostrar;
    public function ajaxMostrarPagos(){
        $tabla = "ventas_pagos";
        $datos = array("id_almacen" => $this -> almacenMostrar,
                        "folio" => $this -> folioMostrar);

        $respuesta = ModeloVentas::mdlMostrarPagosDataTable($tabla, $datos);

        echo json_encode($respuesta); 
    }
    
    /*=====  End of MOSTRAR VENTAS  ======*/

    /*=====================================================================================
	=                   MOSTRAR TODOS LOS PAGOS DE UNA DATA-TABLE                   =
	=====================================================================================*/
	
	public $folioVentaAprobaciones;
	public $idAlmacen;

	public function ajaxMostrarTodosPagosVentas(){
		$tabla = "ventas_pagos";
		$datos = array("id_almacen" => $this -> idAlmacen,
						"folioPedido" => $this -> folioVentaAprobaciones);

		$respuesta = ModeloVentas::mdlMostrarTodosPagosVentas($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*============  End of MOSTRAR TODOS LOS PAGOS DE UNA VENTA DATA-TABLE  =============*/
    

    /*===========================================
    =            CREAR PAGO DE VENTA            =
    ===========================================*/
    
    public $inputPagosMonto;
    public $selectTipoPago;  
    public $inputUrlPagoFotoComprobante;
    public $folio;
    public $almacen;

    public function ajaxCrearPago(){
        $tabla = "ventas_pagos";

        $datos = array("id_almacen" => $this -> almacen,
                        "id_usuario_plataforma" => $_SESSION["id_dashboard"],
                        "folio" => $this -> folio,
                        "monto" => $this -> inputPagosMonto,
                        "estado" => $this -> selectTipoPago,
                        "comprobante" => $this -> inputUrlPagoFotoComprobante);

        $respuesta = ModeloVentas::mdlHacerPago($tabla,$datos);

        if ($respuesta == "ok") {
            
            echo json_encode($respuesta);
            
        }
        
    }
    
    /*=====  End of CREAR PAGO DE VENTA  ======*/

    /*=====================================
    =            FILTRAR PAGOS            =
    =====================================*/
    
    public $campo;
    public $busqueda;
    public function ajaxFiltrarPagos(){
        
        $datos = array("item" => $this -> campo,
                        "valor" => $this -> busqueda,
                        "id_almacen" => $_SESSION["almacen_dashboard"]);

        $respuesta = ModeloVentas::mdlFiltrarPago($datos);
        
        echo json_encode($respuesta); 
    }
    
    /*=====  End of FILTRAR PAGOS  ======*/
    
    
    /*================================================
    =            APROBAR DESAPROBAR PAGOS            =
    ================================================*/

    public $idPago;
    public $estadoPago;
    public function ajaxAprobarDesaprobarPago(){

        $tabla = "ventas_pagos";
        $datos= array("id_pago" => $this -> idPago,
                        "estadoPago" => $this -> estadoPago);

        $respuesta = ModeloVentas::mdlActualizarAprobarDesaprobarPago($tabla, $datos);

        echo json_encode($respuesta);

    }
    
    /*=====  End of APROBAR DESAPROBAR PAGOS  ======*/
    
    /*===================================================================
    =             MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS            =
    ===================================================================*/
    
    public $idAlmacenConfig;
    public function ajaxMostrarConfiguracionAlmacen(){
        
        $tabla = "ventas_pagos_configuracion";
        $item = "id_almacen";
        $valor = $this -> idAlmacenConfig;

        $respuesta = ModeloVentas::mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor);

        echo json_encode($respuesta);

    }
    
    /*=====  End of  MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS  ======*/

    /*=============================================================
    =            GUARDAR CONFIGURACION DE VENTAS PAGOS            =
    =============================================================*/
    
    public $idAlmacenConfiguracion;
    public $jsonPagoInicialConfiguracion;
    public $jsonPeriodosConfiguracion;
    public $promocionConfiguracion;
    
    public function ajaxGuardarConfiguracionPagos(){

        $tabla = "ventas_pagos_configuracion";
        $item = "id_almacen";
        $valor = $this -> idAlmacenConfiguracion;
        $datos = array("id_almacen" => $this -> idAlmacenConfiguracion,
                            "pago_inicial" => $this -> jsonPagoInicialConfiguracion,
                            "periodos" => $this -> jsonPeriodosConfiguracion,
                            "promocion_venta" => $this -> promocionConfiguracion);


        $configuracion = ModeloVentas::mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor);

        if ($configuracion == false) {

            $respuesta = ModeloVentas::mdlCrearConfiguracionVentasPagos($tabla, $datos);

        } else {

            $respuesta = ModeloVentas::mdlEditarConfiguracionVentasPagos($tabla, $datos);

        }

        echo json_encode($respuesta);

    }
    /*=====  End of GUARDAR CONFIGURACION DE VENTAS PAGOS  ======*/
    
    /*==========================================================================
    =                   RESTAR MONTO COMPROBANTE DESAPROBADO                   =
    ==========================================================================*/
    public $montoRestarCorte;
	public $idCorteAprobadoActualizar;

	public function ajaxActualizarTotalCorteCaja(){
		date_default_timezone_set("America/Mexico_City");
		$fechaActual = date("Y-m-d H:i:s");
		$tabla = "ventas_cortes";
		$datos = array("montoResta" => $this -> montoRestarCorte,
						"id_corte" => $this -> idCorteAprobadoActualizar,
                        "fecha" => $fechaActual);

		$respuesta = ModeloVentas::mdlActualizarCorteDiaAprobado($tabla,$datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of RESTAR MONTO COMPROBANTE DESAPROBADO  =============*/
    
    /*===========================================================================================
    =                   MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos                   =
    ===========================================================================================*/
    public $idAlmacenMostrarCrote;

	public function ajaxMostrarSiHayCorte(){
		date_default_timezone_set("America/Mexico_City");
		$fechaActual = date("Y-m-d");

		$tabla = "ventas_cortes";
        
		$datos = array("id_almacen" => $this -> idAlmacenMostrarCrote,
						"fecha" => $fechaActual);

        $respuesta = ModeloVentas::mdlMostrarCortesVentasDia($tabla, $datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos   =============*/

    /*=========================================================================
	=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
	=========================================================================*/

    public $folioVentaMostrarPagos;
    public $almacenMostrarPagos;

    public function ajaxMostrarPagosCancelados(){
        $tabla = "ventas_pagos";
        $datos = array("folio" => $this -> folioVentaMostrarPagos,
                        "id_almacen" => $this -> almacenMostrarPagos);

        $respuesta = ModeloVentas::mdlMostrarPagosCanceladosDesaprobados($tabla, $datos);

        echo json_encode($respuesta);
    }

    /*============  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE  =============*/

    /*=============================================================================================
	=                   CAMBIAR ESTADO DE LA VENTA CUANDO SE COMPLETEN SUS PAGOS                   =
	=============================================================================================*/
	public $folioVentaActualizarEstadoPago;
	public $idAlmacenActualizarEstadoPago;
	public function ajaxActualizarEstadoPagoPedido(){
		$tabla ="ventas";
		$folio = $this -> folioVentaActualizarEstadoPago;
		$almacen = $this -> idAlmacenActualizarEstadoPago;

		$respuesta = ModeloVentas::mdlActualizarEstadoPagoVenta($tabla, $folio, $almacen);

		echo json_encode($respuesta);
	}
	
	/*============  End of CAMBIAR ESTADO DE LA VENTA CUANDO SE COMPLETEN SUS PAGOS  =============*/
}

/*======================================
=            MOSTRAR VENTAS            =
======================================*/

if (isset($_POST["folioMostrar"])) {
    $mostrar = new AjaxPagosVentas();
    $mostrar -> folioMostrar = $_POST["folioMostrar"]; 
    $mostrar -> almacenMostrar = $_POST["almacenMostrar"]; 
    $mostrar -> ajaxMostrarPagos();
}

/*=====  End of MOSTRAR VENTAS  ======*/

/*=====================================================================================
=                   MOSTRAR TODOS LOS PAGOS DE UNA VENTA DATA-TABLE                   =
=====================================================================================*/

if (isset($_POST["folioVentaAprobaciones"])) {
	$mostrarPagosDt = new AjaxPagosVentas();
	$mostrarPagosDt -> folioVentaAprobaciones = $_POST["folioVentaAprobaciones"];
	$mostrarPagosDt -> idAlmacen = $_POST["idAlmacen"];
	$mostrarPagosDt -> ajaxMostrarTodosPagosVentas();
	
}

/*============  End of MOSTRAR TODOS LOS PAGOS DE UNA VENTA DATA-TABLE    =============*/

/*===========================================
=            CREAR PAGO DE VENTA            =
===========================================*/

if (isset($_POST["inputPagosMonto"])) {
    $crearPago = new AjaxPagosVentas();
    $crearPago -> inputPagosMonto = $_POST["inputPagosMonto"];
    $crearPago -> selectTipoPago = $_POST["selectTipoPago"];
    $crearPago -> inputUrlPagoFotoComprobante = $_POST["inputUrlPagoFotoComprobante"];
    $crearPago -> folio = $_POST["folio"];
    $crearPago -> almacen = $_POST["almacen"];
    $crearPago -> ajaxCrearPago();
}

/*=====  End of CREAR PAGO DE VENTA  ======*/

/*=====================================
=            FILTRAR PAGOS            =
=====================================*/

if (isset($_POST["campo"])) {
    $filtrar = new AjaxPagosVentas();
    $filtrar -> campo = $_POST["campo"];
    $filtrar -> busqueda = $_POST["busqueda"];
    $filtrar -> ajaxFiltrarPagos();
}

/*=====  End of FILTRAR PAGOS  ======*/

/*================================================
=            APROBAR DESAPROBAR PAGOS            =
================================================*/

if (isset($_POST["estadoPago"])) {
    $ingresar = new AjaxPagosVentas();
    $ingresar -> idPago = $_POST["idPago"];
    $ingresar -> estadoPago = $_POST["estadoPago"];
    $ingresar -> ajaxAprobarDesaprobarPago();
}

/*=====  End of APROBAR DESAPROBAR PAGOS  ======*/


/*==================================================================
=            MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS            =
==================================================================*/

if (isset($_POST["idAlmacenConfig"])) {
    $mostrarConfiguracion = new AjaxPagosVentas();
    $mostrarConfiguracion -> idAlmacenConfig = $_POST["idAlmacenConfig"];
    $mostrarConfiguracion -> ajaxMostrarConfiguracionAlmacen();
}

/*=====  End of MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS  ======*/


/*=============================================================
=            GUARDAR CONFIGURACION DE VENTAS PAGOS            =
=============================================================*/

if (isset($_POST["idAlmacenConfiguracion"])) {
    $guardarConfig = new AjaxPagosVentas();
    $guardarConfig -> idAlmacenConfiguracion = $_POST["idAlmacenConfiguracion"];
    $guardarConfig -> jsonPagoInicialConfiguracion = $_POST["jsonPagoInicialConfiguracion"];
    $guardarConfig -> jsonPeriodosConfiguracion = $_POST["jsonPeriodosConfiguracion"];
    $guardarConfig -> promocionConfiguracion = $_POST["promocionConfiguracion"];
    $guardarConfig -> ajaxGuardarConfiguracionPagos();
}

/*=====  End of GUARDAR CONFIGURACION DE VENTAS PAGOS  ======*/

/*================================================================================
=                   ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO                   =
================================================================================*/

if (isset($_POST["montoRestarCorte"])) {
	$actualizarCorteAprobado = new AjaxPagosVentas();
	$actualizarCorteAprobado -> montoRestarCorte = $_POST["montoRestarCorte"];
	$actualizarCorteAprobado -> idCorteAprobadoActualizar = $_POST["idCorteAprobadoActualizar"];
	$actualizarCorteAprobado -> ajaxActualizarTotalCorteCaja();
}

/*============  End of ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO  =============*/


/*===========================================================================================
=                   MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos                   =
===========================================================================================*/
if (isset($_POST["idAlmacenMostrarCrote"])) {
	$mostrarCorte = new AjaxPagosVentas();
	$mostrarCorte -> idAlmacenMostrarCrote = $_POST["idAlmacenMostrarCrote"];
	$mostrarCorte -> ajaxMostrarSiHayCorte();
}

/*============  End of MOSTRAR SI HAY CORTE REALIZADO en aprobacion de pagos  =============*/

/*=========================================================================
=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
=========================================================================*/

if (isset($_POST["folioVentaMostrarPagos"])) {
	$mostrarPagosCancelados = new AjaxPagosVentas();
	$mostrarPagosCancelados -> folioVentaMostrarPagos = $_POST["folioVentaMostrarPagos"];
	$mostrarPagosCancelados -> almacenMostrarPagos = $_POST["almacenMostrarPagos"];
	$mostrarPagosCancelados -> ajaxMostrarPagosCancelados();
}

/*============  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE  =============*/

/*=============================================================================================
=                   CAMBIAR ESTADO DE LA VENTA CUANDO SE COMPLETEN SUS PAGOS                   =
=============================================================================================*/

if (isset($_POST["folioVentaActualizarEstadoPago"])) {
	$cambiarEstadoPedido = new AjaxPagosVentas();
	$cambiarEstadoPedido -> folioVentaActualizarEstadoPago = $_POST["folioVentaActualizarEstadoPago"];
	$cambiarEstadoPedido -> idAlmacenActualizarEstadoPago = $_POST["idAlmacenActualizarEstadoPago"];
	$cambiarEstadoPedido -> ajaxActualizarEstadoPagoPedido();
}

/*============  End of CAMBIAR ESTADO DE LA VENTA CUANDO SE COMPLETEN SUS PAGOS  =============*/