<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';

class AjaxPagosVentasCedis{

    /*===================================================================
    =             MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS            =
    ===================================================================*/
    

    public function ajaxMostrarConfiguracionAlmacen(){
        
        $tabla = "cedis_ventas_pagos_configuracion";
	    $item = "id_empresa";
	    $valor = $_SESSION['idEmpresa_dashboard'];

        $respuesta = ModeloVentasCedis::mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor);

        echo json_encode($respuesta);

    }
    
    /*=====  End of  MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS  ======*/

    /*=============================================================
    =            GUARDAR CONFIGURACION DE VENTAS PAGOS            =
    =============================================================*/

    public $jsonPagoInicialConfiguracion;
    public $jsonPeriodosConfiguracion;
    public $promocionConfiguracion;
    
    public function ajaxGuardarConfiguracionPagos(){

        $tabla = "cedis_ventas_pagos_configuracion";
        $item = "id_empresa";
        $valor = $_SESSION['idEmpresa_dashboard'];
        $datos = array("id_empresa" => $_SESSION['idEmpresa_dashboard'],
                        "pago_inicial" => $this -> jsonPagoInicialConfiguracion,
                        "periodos" => $this -> jsonPeriodosConfiguracion,
                        "promocion_venta" => $this -> promocionConfiguracion);


        $configuracion = ModeloVentasCedis::mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor);

        if ($configuracion == false) {

            $respuesta = ModeloVentasCedis::mdlCrearConfiguracionVentasPagos($tabla, $datos);

        } else {

            $respuesta = ModeloVentasCedis::mdlEditarConfiguracionVentasPagos($tabla, $datos);

        }

        echo json_encode($respuesta);

    }
    /*=====  End of GUARDAR CONFIGURACION DE VENTAS PAGOS  ======*/

    /*================================================================
    =                   MOSTRAR VENTAS PAGOS CEDIS                    =
    ================================================================*/
    public $vendedorMostrarVentasPagos;
    public function ajaxMostrarVentasPagosAlmacen(){

		$vendedor = $this -> vendedorMostrarVentasPagos;

		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagos($vendedor);

		echo json_encode($respuesta);
	}
    
    /*============  End of MOSTRAR VENTAS PAGOS CEDIS  =============*/

    /*======================================================================
    =                   MOSTRAR VENTAS A PAGOS CEDIS MODAL                 =
    ======================================================================*/
    public $folioVenta;

	public function ajaxMostrarVentasDataTable(){
		$tabla = "cedis_ventas_pagos";
        

        $datos = array("id_usuario_plataforma" => $_SESSION["id_dashboard"],
                        "folio" => $this -> folioVenta,); 

		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagosDataTable($tabla, $datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of MOSTRAR VENTAS A PAGOS CEDIS MODAL  =============*/
    /*======================================================================
    =                   MOSTRAR VENTAS A PAGOS Todos CEDIS MODAL                 =
    ======================================================================*/
    public $folioVentaTodos;

	public function ajaxMostrarVentasDataTableTodos(){
		$tabla = "cedis_ventas_pagos";
        

        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "folio" => $this -> folioVentaTodos,); 

		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagosDataTable($tabla, $datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of MOSTRAR VENTAS A PAGOS Todos CEDIS MODAL  =============*/
     /*======================================================================
    =                   MOSTRAR VENTAS A PAGOS DE UN CLIENTE                 =
    ======================================================================*/
    public $id_cliente;

	public function ajaxMostrarVentasPagosCliente(){
        $metodo = "pagos";
        $estado = "Pendiente";

        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_cliente" => $this -> id_cliente); 

		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagosCliente($datos,$metodo,$estado);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of MOSTRAR VENTAS A PAGOS DE UN CLIENTE  =============*/

         /*======================================================================
    =                   MOSTRAR VENTAS A PAGOS POR FOLIO                        =
    ======================================================================*/
    public $foliovp;

	public function ajaxMostrarVentasPagosFolio(){
        $metodo = "pagos";
        $estado = "Pendiente";
        $foliov = $this -> foliovp;
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "folio" => $foliov); 

		$respuesta = ModeloVentasCedis::mdlMostrarVentasPagosfolio($datos,$metodo,$estado);
        //$respuesta ="ok";
		echo json_encode($respuesta);
	}
    
    
    /*============  End of MOSTRAR VENTAS A PAGOS POR FOLIO  =============*/

    /*=========================================================================
    =                   GUARDAR PAGO DE VENTA A PAGOS EN BD                   =
    =========================================================================*/
    public $montoPagoVentaCedis;
    public $estadoPagoVentaCedis;
    public $comprobantePagoVentaCedis;
    public $vendedor;
    public $folio;

    public function ajaxCrearPagoVentaPagos(){
        $tabla = "cedis_ventas_pagos";
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "monto" => $this -> montoPagoVentaCedis,
                        "estado" => $this -> estadoPagoVentaCedis,
                        "comprobante" => $this -> comprobantePagoVentaCedis,
                        "id_usuario_plataforma" => $this -> vendedor,
                        "folio" => $this-> folio);
        $respuesta = ModeloVentasCedis::mdlRealizarPago($tabla,$datos);
        echo json_encode($respuesta);
    }
    
    /*============  End of GUARDAR PAGO DE VENTA A PAGOS EN BD  =============*/

    /*===========================================================================
    =                   APROBAR / DESAPROBAR PAGO VENTA CEDIS                   =
    ===========================================================================*/
    
    public $idPago;
    public $estadoPago;

    public function ajaxAprobarDesaprobarPago(){
        $tabla = "cedis_ventas_pagos";
        $datos= array("id_pago" => $this -> idPago,
                        "estadoPago" => $this -> estadoPago);
        
        $respuesta = ModeloVentasCedis::mdlActualizarAprobarDesaprobarPago($tabla, $datos);
        
        echo json_encode($respuesta);
    }
    
    /*============  End of APROBAR / DESAPROBAR PAGO VENTA CEDIS  =============*/

    /*==========================================================================
    =                   RESTAR MONTO COMPROBANTE DESAPROBADO                   =
    ==========================================================================*/
    public $montoRestarCorte;
	public $idCorteAprobadoActualizar;

	public function ajaxActualizarTotalCorteCaja(){
		date_default_timezone_set("America/Mexico_City");
		$fechaActual = date("Y-m-d");
		$tabla = "cedis_ventas_corte";
		$datos = array("montoResta" => $this -> montoRestarCorte,
						"id_corte" => $this -> idCorteAprobadoActualizar,
						"fecha" => $fechaActual,
                        "montoSuma" => null);

		$respuesta = ModeloVentasCedis::mdlActualizarCorteDiaAprobado($tabla,$datos);

		echo json_encode($respuesta);
	}
    
    
    /*============  End of RESTAR MONTO COMPROBANTE DESAPROBADO  =============*/

    /*=====================================================================================
	=                   MOSTRAR TODOS LOS PAGOS DE UN PEDIDO DATA-TABLE                   =
	=====================================================================================*/
	
	public $folioPedidoAprobaciones;

	public function ajaxMostrarTodosPagosPedidos(){
		$tabla = "cedis_ventas_pagos";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"folioPedido" => $this -> folioPedidoAprobaciones);

		$respuesta = ModeloVentasCedis::mdlMostrarTodosPagosVentas($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*============  End of MOSTRAR TODOS LOS PAGOS DE UN PEDIDO DATA-TABLE  =============*/
    
    /*=========================================================================
	=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
	=========================================================================*/

    public $folioVentaMostrarPagos;

    public function ajaxMostrarPagosCancelados(){
        $tabla = "cedis_ventas_pagos";
        $datos = array("folio" => $this -> folioVentaMostrarPagos,
                        "vendedor" => $_SESSION["id_dashboard"]);

        $respuesta = ModeloVentasCedis::mdlMostrarPagosCanceladosDesaprobados($tabla, $datos);

        echo json_encode($respuesta);
    }

    /*============  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE  =============*/

    /*=====================================
    =            FILTRAR PAGOS            =
    =====================================*/
    
    public $campo;
    public $busqueda;
    public $usuarioPlataforma;

    public function ajaxFiltrarPagos(){
        
        $datos = array("item" => $this -> campo,
                        "valor" => $this -> busqueda,
                        "id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_usuario" => $this -> usuarioPlataforma);

        $respuesta = ModeloVentasCedis::mdlFiltrarPago($datos);
        
        echo json_encode($respuesta); 
    }
    
    /*=====  End of FILTRAR PAGOS  ======*/
    
}

/*==================================================================
=            MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS            =
==================================================================*/

if (isset($_POST["ConfigPagosCedis"])) {
    $mostrarConfiguracion = new AjaxPagosVentasCedis();
    $mostrarConfiguracion -> ajaxMostrarConfiguracionAlmacen(); 
}

/*=====  End of MOSTRAR CONFIGURACION ALMACEN VENTAS PAGOS  ======*/

/*=============================================================
=            GUARDAR CONFIGURACION DE VENTAS PAGOS            =
=============================================================*/

if (isset($_POST["jsonPagoInicialConfiguracion"])) {
    $guardarConfig = new AjaxPagosVentasCedis();
    $guardarConfig -> jsonPagoInicialConfiguracion = $_POST["jsonPagoInicialConfiguracion"];
    $guardarConfig -> jsonPeriodosConfiguracion = $_POST["jsonPeriodosConfiguracion"];
    $guardarConfig -> promocionConfiguracion = $_POST["promocionConfiguracion"];
    $guardarConfig -> ajaxGuardarConfiguracionPagos();
}

/*=====  End of GUARDAR CONFIGURACION DE VENTAS PAGOS  ======*/

/*===================================================================
=                   MOSTRAR VENTAS PAGOS DE CEDIS                   =
===================================================================*/

if (isset($_POST["vendedorMostrarVentasPagos"])) {
	$ventasAlmacen = new AjaxPagosVentasCedis();
	$ventasAlmacen -> vendedorMostrarVentasPagos = $_POST["vendedorMostrarVentasPagos"]; 
	$ventasAlmacen -> ajaxMostrarVentasPagosAlmacen(); 
}

/*============  End of MOSTRAR VENTAS PAGOS DE CEDIS  =============*/

/*======================================================================
=                   MOSTRAR VENTAS A PAGOS CEDIS MODAL                 =
======================================================================*/

if (isset($_POST["folioVenta"])) {
	$mostrarPagosDt = new AjaxPagosVentasCedis();
	$mostrarPagosDt -> folioVenta = $_POST["folioVenta"];
	$mostrarPagosDt -> ajaxMostrarVentasDataTable();
	
}

/*============  End of MOSTRAR VENTAS A PAGOS CEDIS MODAL  =============*/
/*======================================================================
=                   MOSTRAR VENTAS A PAGOS Todos CEDIS MODAL                 =
======================================================================*/

if (isset($_POST["folioVentaTodos"])) {
	$mostrarPagosDt = new AjaxPagosVentasCedis();
	$mostrarPagosDt -> folioVentaTodos = $_POST["folioVentaTodos"];
	$mostrarPagosDt -> ajaxMostrarVentasDataTableTodos();
	
}

/*============  End of MOSTRAR VENTAS A PAGOS Todos CEDIS MODAL  =============*/
/*======================================================================
=                   MOSTRAR VENTAS A PAGOS DE UN CLIENTE                 =
======================================================================*/

if (isset($_POST["id_cliente"])) {
	$mostrarPagosDt = new AjaxPagosVentasCedis();
	$mostrarPagosDt -> id_cliente = $_POST["id_cliente"];
	$mostrarPagosDt -> ajaxMostrarVentasPagosCliente();
	
}

/*============  End of MOSTRAR VENTAS A PAGOS DE UN CLIENTE  =============*/



/*=========================================================================
=                   GUARDAR PAGO DE VENTA A PAGOS EN BD                   =
=========================================================================*/

if (isset($_POST["montoPagoVentaCedis"])) {
    $crearPagoPedido = new AjaxPagosVentasCedis();
    $crearPagoPedido -> montoPagoVentaCedis = $_POST["montoPagoVentaCedis"];
    $crearPagoPedido -> estadoPagoVentaCedis = $_POST["estadoPagoVentaCedis"];
    $crearPagoPedido -> comprobantePagoVentaCedis = $_POST["comprobantePagoVentaCedis"];
    $crearPagoPedido -> vendedor = $_POST["vendedor"];
    $crearPagoPedido -> folio = $_POST["folio"];
    $crearPagoPedido -> ajaxCrearPagoVentaPagos();

}

/*============  End of GUARDAR PAGO DE VENTA A PAGOS EN BD  =============*/
/*======================================================================
=                   MOSTRAR VENTAS A PAGOS POR FOLIO                   =
======================================================================*/

if (isset($_POST["foliodev"])) {
	$mostrarPagosfolio = new AjaxPagosVentasCedis();
	$mostrarPagosfolio -> foliovp = $_POST["foliodev"];
	$mostrarPagosfolio -> ajaxMostrarVentasPagosFolio();
	
}

/*============  End of MOSTRAR VENTAS A PAGOS POR FOLIO  =============*/

/*===========================================================================
=                   APROBAR / DESAPROBAR PAGO VENTA CEDIS                   =
===========================================================================*/

if (isset($_POST["estadoPago"])) {
    $ingresar = new AjaxPagosVentasCedis();
    $ingresar -> idPago = $_POST["idPago"];
    $ingresar -> estadoPago = $_POST["estadoPago"];
    $ingresar -> ajaxAprobarDesaprobarPago();
}

/*============  End of APROBAR / DESAPROBAR PAGO VENTA CEDIS  =============*/

/*================================================================================
=                   ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO                   =
================================================================================*/

if (isset($_POST["montoRestarCorte"])) {
	$actualizarCorteAprobado = new AjaxPagosVentasCedis();
	$actualizarCorteAprobado -> montoRestarCorte = $_POST["montoRestarCorte"];
	$actualizarCorteAprobado -> idCorteAprobadoActualizar = $_POST["idCorteAprobadoActualizar"];
	$actualizarCorteAprobado -> ajaxActualizarTotalCorteCaja();
}

/*============  End of ACTUALIZAR TOTAL DE CORTE DE CAJA APROBADO  =============*/

/*=====================================================================================
=                   MOSTRAR TODOS LOS PAGOS DE UNA VENTA  DATA-TABLE                   =
=====================================================================================*/

if (isset($_POST["folioPedidoAprobaciones"])) {
	$mostrarPagosDt = new AjaxPagosVentasCedis();
	$mostrarPagosDt -> folioPedidoAprobaciones = $_POST["folioPedidoAprobaciones"];
	$mostrarPagosDt -> ajaxMostrarTodosPagosPedidos();
	
}

/*============  End of MOSTRAR TODOS LOS PAGOS DE UNA VENTA DATA-TABLE    =============*/

/*=========================================================================
=            MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE            =
=========================================================================*/

if (isset($_POST["folioVentaMostrarPagos"])) {
	$mostrarPagosCancelados = new AjaxPagosVentasCedis();
	$mostrarPagosCancelados -> folioVentaMostrarPagos = $_POST["folioVentaMostrarPagos"];
	$mostrarPagosCancelados -> ajaxMostrarPagosCancelados();
}

/*============  End of MOSTRAR PAGOS CANCELADO / DESAPROBADOS DATA TABLE  =============*/

/*=====================================
=            FILTRAR PAGOS            =
=====================================*/

if (isset($_POST["campo"])) {
    $filtrar = new AjaxPagosVentasCedis();
    $filtrar -> campo = $_POST["campo"];
    $filtrar -> busqueda = $_POST["busqueda"];
    $filtrar -> usuarioPlataforma = $_POST["usuarioPlataforma"];
    $filtrar -> ajaxFiltrarPagos();
}

/*=====  End of FILTRAR PAGOS  ======*/
?>