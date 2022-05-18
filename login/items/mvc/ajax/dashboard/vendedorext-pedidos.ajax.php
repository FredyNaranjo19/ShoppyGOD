<?php

use Doctrine\Common\Collections\Expr\Value;

use function PHPSTORM_META\type;

session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.vendedorext-pedidos.php';

class AjaxVendedorExtPedidos{
    // =============================================================================
    // MOSTRAR PRODUCTOS EN PEDIDOS DE VENDEDOR
    // =============================================================================
    public $idProducto;

    public function ajaxMostrarProductos(){
        
        /* --------------------- INFORMACION DE PRODUCTOS CEDIS --------------------- */

        $tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idProducto;
		$empresa = $_SESSION['idEmpresa_dashboard'];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

        /* ------------------------ LISTADO PRECIOS PRODUCTOS ----------------------- */

        $tabla = "productos_listado_precios";
		$datos = array("id_empresa" => $_SESSION['idEmpresa_dashboard'],
						"modelo" => $producto["codigo"]);

		$listado = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);
        

        foreach ($listado as $key => $value) {

			if ($key == 0) {
				$precio = $value["precio"];
				$costo = $value["costo"];
				$promo = $value["promo"];
				$activado = $value["activadoPromo"];

			}

		}
        

        $respuesta = array("id_producto" => $producto["id_producto"],
						    "id_empresa" => $producto["id_empresa"],
						    "codigo" => $producto["codigo"],
						    "sku" => $producto["sku"],
						    "nombre" => $producto["nombre"],
						    "stock" => $producto["stock_disponible"],
                            "precio" => $precio,
                            "costo" => $costo,
                            "promo" => $promo,
                            "activadoPromo" => $activado);
        
        echo json_encode($respuesta);
        
    }

    /*=======================================================
    =                   AGRUPAR PRODUCTOS                   =
    =======================================================*/
    public $productosAgrupados;
	public function ajaxAgruparProductos(){

		$productos = json_decode($this -> productosAgrupados, true);

		/*=========================================
		=            AGRUPAR PRODUCTOS            =
		=========================================*/
		
		$result = array();
		foreach($productos as $t) {
			$repeat=false;
			for($i=0;$i<count($result);$i++)
			{
				if($result[$i]['modelo']==$t['modelo'])
				{
					$result[$i]['cantidad']+= intval($t['cantidad']);
					$repeat=true;
					break;
				}
			}
			if($repeat==false)
				$result[] = array('modelo' => $t['modelo'], 'cantidad' => intval($t['cantidad']));
		}
		
		/*=====  End of AGRUPAR PRODUCTOS  ======*/
		
		/*==================================================
		=            CREAR ARREGLO DE PRODUCTOS            =
		==================================================*/
		$productosAgrupados = array();

		for ($i=0; $i < count($result); $i++) { 
			
			$tabla = "productos_listado_precios";
			$datos = array("id_empresa" => $_SESSION['idEmpresa_dashboard'],
							"modelo" => $result[$i]['modelo']);

			$precioResultados = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);

			foreach ($precioResultados as $key => $value) {
				
				if ($result[$i]['cantidad'] >= $value["cantidad"]) {

					if ($value["activadoPromo"] == 'si') {

						$precio = $value["promo"];

					} else {

						$precio = $value["precio"];

					}
				}
			}


			foreach ($productos as $key => $value) {
				
				if ($value["modelo"] == $result[$i]['modelo']) {
					
					$monto = floatval($value["cantidad"]) * floatval($precio);

					array_push($productosAgrupados, array("idProducto" => $value["idProducto"],
															"nombre" => $value["nombreProducto"],
															"modelo" => $value["modelo"],
															"cantidad" => $value["cantidad"],
															"precio" => $precio,
															"costo" => $value["costo"],
															"monto" => $monto,
															"stock" => $value["stock"]
														)
					);
				}
			}
		}
		
		/*=====  End of CREAR ARREGLO DE PRODUCTOS  ======*/
		

		echo json_encode($productosAgrupados);
	}
    
    /*============  End of AGRUPAR PRODUCTOS  =============*/

	/*==================================================
	=                   CREAR PEDIDO                   =
	==================================================*/
	public $clienteCrearPedido;
	public $jsonProductosCrearPedido;
	public $totalPedidoCrearPedido;
	public $inputFolioPedido;
	

	public function ajaxCrearPedido(){

		$estadoPedido = "solicitado";
		$retorno = 0;
		$total = $this -> totalPedidoCrearPedido;

	
		$productos = json_decode($this -> jsonProductosCrearPedido, true);

		foreach ($productos as $key => $value) {
			$tabla = "productos";
			$item = "id_producto";
			$valor = $value["id"];
			$empresa = $_SESSION["idEmpresa_dashboard"];

			$respuestaProducto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

			if ($value["cantidad"] > $respuestaProducto["stock_disponible"]) {

				$retorno = 1;
			
			}
		}

		if ($retorno == 0) {
		
			foreach ($productos as $key => $value) {

				/* REGISTRAR DETALLE DEL PEDIDO EN LA BD  
				-------------------------------------------------- */

				$tablaDetallesPedido = "vendedorext_pedidos_detalles";
				//Calcular la utilidad del producto
				$utilidad = ($value["precio"] - $value["costo"]) * $value["cantidad"];

				$datosDetallePedido = array("id_cliente" => $this -> clienteCrearPedido,
											"id_usuario_plataforma" => $_SESSION["id_dashboard"],
											"id_empresa" => $_SESSION["idEmpresa_dashboard"],
											"folio" => $this -> inputFolioPedido,
											"id_producto" => $value["id"],
											"cantidad" => $value["cantidad"],
											"costo" => $value["costo"],
											"precio" => $value["precio"],
											"monto" => $value["monto"],
											"utilidad" => round($utilidad,6));

				$crearDetallePedido = ModeloVendedorextPedidos::mdlCrearDetallePedido($tablaDetallesPedido, $datosDetallePedido);

				/* EDITAR STOCK DE PRODUCTOS
				-------------------------------------------------- */

				$tablaProductos = "productos";
				$datosProductos = array("id_producto" => $value["id"],
										"id_empresa" => $_SESSION["idEmpresa_dashboard"],
										"cantidad" => $value["cantidad"]);
				
				$crearModificacion = ModeloVendedorextPedidos::mdlEditarStock($tablaProductos, $datosProductos);
			}
			
			/* REGISTRAR PEDIDO EN LA BD   
			-------------------------------------------------- */

			$tablaPedido = "vendedorext_pedidos";
			$datosPedido = array("id_cliente" => $this -> clienteCrearPedido,
							"id_usuario_plataforma" => $_SESSION["id_dashboard"],
							"id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"folio" => $this -> inputFolioPedido,
							"estado_pedido" => $estadoPedido,
							"total" => $total );
		
			$respuesta = ModeloVendedorextPedidos::mdlCrearPedido($tablaPedido, $datosPedido);
		}else{

			$respuesta = "existencia";
		}

		echo json_encode($respuesta);
			
	}
	
	/*============  End of CREAR PEDIDO  =============*/

	/*=====================================================
	=                   CANCELAR PEDIDO                   =
	=====================================================*/
	
	public $folioPedido;
	public $notaCancelacionPedido;
	public $vendedorCancelarPedido;

	public function ajaxCancelarPedido(){

		/* CAMBIAR ESTADO DEL PEDIDO Y AGREGAR NOTA DE CANCELACION
		-------------------------------------------------- */
		
		$tabla = "vendedorext_pedidos";
		$datos = array("id_usuario_plataforma" => $_SESSION["id_dashboard"],
						"folio" => $this -> folioPedido,
						"estado" => "Por cancelar",
						"nota_cancelacion" => $this -> notaCancelacionPedido);

		$respuesta = ModeloVendedorextPedidos::mdlCancelarPedido($tabla, $datos);


		echo json_encode($respuesta);
	}
	
	
	/*============  End of CANCELAR PEDIDO  =============*/

	/*===================================================================
	=                   CANCELACION DEFINITIVA PEDIDO                   =
	===================================================================*/
	public $folioCancelarDefinitivo;
	public $vendedorCancelarDefinitivo;
	public function ajaxCancelarPedidoDefinitivo(){
		
		/* CAMBIAR ESTADO DEL PEDIDO 
		-------------------------------------------------- */
		
		$tabla = "vendedorext_pedidos";
		$datos = array("vendedor" => $this -> vendedorCancelarDefinitivo,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"folio" => $this -> folioCancelarDefinitivo,
						"estado" => "cancelado");

		$respuesta = ModeloVendedorextPedidos::mdlPedidoCancelarDefinitivo($tabla, $datos);

		/* OBTENER CANTIDAD DE PRODUCTOS DEL PEDIDO
		-------------------------------------------------- */
		
		$datos = array("folio" => $this -> folioCancelarDefinitivo,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $this -> vendedorCancelarDefinitivo);
		
		$detallePedido = ModeloVendedorextPedidos::mdlMostrarDetallesPedido($datos);

		foreach ($detallePedido as $key => $value) {
			$tabla = "productos";
			$datos = array("stock" => $value["cantidad"],
							"id_producto" => $value["id_producto"]);
			
			$retorno = ModeloVendedorextPedidos::mdlActualizaStockProductosCancelacion($tabla,$datos);
		}

		echo json_encode($retorno);
	}
	
	/*============  End of CANCELACION DEFINITIVA PEDIDO  =============*/

	/*===================================================
	=                   EDITAR PEDIDO                   =
	===================================================*/
	
	public $folioPedidoVendExt;
	public $vendedorExt;
	public function ajaxEditarPedido(){
		// si ahy error agregar "id_usuario_plataforma" => $_SESSION["id_dashboard"]
		$datos = array("folio" => $this -> folioPedidoVendExt,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $this -> vendedorExt);
		
		$detallePedido = ModeloVendedorextPedidos::mdlMostrarDetallesPedido($datos);

		echo json_encode($detallePedido);
	}
	
	
	/*============  End of EDITAR PEDIDO  =============*/
	

	/*==============================================================
	=                   EDITAR ESTADO DEL PEDIDO                   =
	==============================================================*/
	
	public $folioPedidoEditEstado;
    public $estadoPedidoEditEstado;
    public $vendedorPedidoEditEstado;

    public function ajaxEditarEstadoPedido(){
        $tabla = "vendedorext_pedidos";
        $datos = array("folio" => $this -> folioPedidoEditEstado,
                        "estado_pedido" => $this -> estadoPedidoEditEstado,
                        "id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"vendedor" => $this -> vendedorPedidoEditEstado);

        $respuesta = ModeloVendedorextPedidos::mdlActualizarEstadoPedido($tabla, $datos);

        echo json_encode($respuesta);
    }
	
	/*============  End of EDITAR ESTADO DEL PEDIDO  =============*/

	/*======================================================================
	=                   MOSTRAR VENTAS PAGOS DE VENDEDOR                   =
	======================================================================*/
	
	public $idVendedorExt;
	public function ajaxMostrarVentasPagosVendedor(){
		$vendedor = $this -> idVendedorExt;

		$respuesta = ModeloVendedorextPedidos::mdlMostrarVentasPagosVendedor($vendedor);

		echo json_encode($respuesta);
	}
	
	/*============  End of MOSTRAR VENTAS PAGOS DE VENDEDOR  =============*/

	/*======================================================================
	=                   MOSTRAR PAGOS PAGADOS DATA-TABLE                   =
	======================================================================*/
	
	public $folioPedidoAprobar;
	public $idVendedorAprobar;

	public function ajaxMostrarPedidosDataTable(){
		$tabla = "vendedorext_pedidos_pagos";
		$datos = array("id_usuario_plataforma" => $this -> idVendedorAprobar,
						"folioPedido" => $this -> folioPedidoAprobar);

		$respuesta = ModeloVendedorextPedidos::mdlMostrarPagosPedidosDataTable($tabla, $datos);

		echo json_encode($respuesta);
	}
	/*============  End of MOSTRAR VENTAS PAGOS DATA TABLE  =============*/

	/*=====================================================================================
	=                   MOSTRAR TODOS LOS PAGOS DE UN PEDIDO DATA-TABLE                   =
	=====================================================================================*/
	
	public $folioPedidoAprobaciones;
	public $idVendedor;

	public function ajaxMostrarTodosPagosPedidos(){
		$tabla = "vendedorext_pedidos_pagos";
		$datos = array("id_usuario_plataforma" => $this -> idVendedor,
						"folioPedido" => $this -> folioPedidoAprobaciones);

		$respuesta = ModeloVendedorextPedidos::mdlMostrarTodosPagosPedidos($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*============  End of MOSTRAR TODOS LOS PAGOS DE UN PEDIDO DATA-TABLE  =============*/

	/*==============================================================================
	=                   GUARDAR PAGO DE PEDIDO UNA VEZ ENTREGADO                   =
	==============================================================================*/
	public $folioPedidoPagoEntregado;//YA NO
	public $totalPedido;
	public $metodoPagoCrearPedido;//YA NO
	public $transaccionCrearPedido; //YA NO
	public $totalCreditoPedidoCrearPedido; //YA NO
	public $pagoInicialCreditoPedidoCrearPedido; //YA NO

	public function ajaxHacerPagoPedidoEntrega(){
		
		$metodoPago = $this -> metodoPagoCrearPedido;
		$estadoPago_VEPP = "Pagado"; //vendedorext_pedidos_pagos
		$estadoPago_VEP = "Pagado"; //vendedorext_pedidos
		$estadoPedido = "entregado";
		$folioPagoTarjeta = NULL;

		$total = $this -> totalPedido;
		
		/* GUARDAR PAGO INICIAL EN LOS PEDIDOS A PAGOS
		-------------------------------------------------- */
	
		if ($metodoPago == "TD" || $metodoPago == "TC"){
			$folioPagoTarjeta = $this -> metodoPagoCrearPedido."-".$this -> transaccionCrearPedido;
			$estadoPago_VEPP = "Pendiente";
		}

		if ($metodoPago == "Pagos") {
			$estadoPago_VEP = "Pendiente";

			$estadoPago_VEPP = "Pagado";

			$montoInicial = $this -> pagoInicialCreditoPedidoCrearPedido;
			
			$tablaPedidosPagos = "vendedorext_pedidos_pagos";
			$datosPedido = array("id_usuario_plataforma" => $_SESSION["id_dashboard"],
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"folio" => $this -> folioPedidoPagoEntregado,
						"monto" => $montoInicial,
						"comprobante" => "",
						"estado_pago" => $estadoPago_VEPP);
			
			$pago = ModeloVendedorextPedidos::mdlHacerPago($tablaPedidosPagos, $datosPedido);

			$total = $this -> totalCreditoPedidoCrearPedido;
		}
		
		/* EDITAR/AGREGAR PAGO Y FECHA A INFO. DEL PEDIDO
		-------------------------------------------------- */
		
		date_default_timezone_set('America/Mexico_City');

		$tabla = "vendedorext_pedidos";
		$vendedor = $_SESSION["id_dashboard"];
		$fechaEntrega = date("Y-m-d H:i:s");

		$datos = array("estado_pedido" => $estadoPedido,
						"total" => $total,
						"tipo_pago" =>$this -> metodoPagoCrearPedido,
						"folio_pago_tarjeta" => $folioPagoTarjeta,
						"estado_pago" => $estadoPago_VEP,
						"fecha_entrega" => $fechaEntrega,
						"id_usuario_plataforma" => $vendedor,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"folio" => $this -> folioPedidoPagoEntregado);
		
		$respuesta = ModeloVendedorextPedidos::mdlGuardarPagoPedidoEntregado($tabla, $datos);

		echo json_encode($respuesta);

	}

	
	
	/*============  End of MOSTRAR PAGOS DATA-TABLE  =============*/

	/*==================================================================
	=                   CREAR CORTE VENDEDOR EXTERNO                   =
	==================================================================*/
	public $totalCortePedidosVE;
	public $fechaCortePedidosVE;
	public $idCorteActualizar;

	public function ajaxCrearCortePedidosVendExt(){
		date_default_timezone_set("America/Mexico_City");
		$tabla = "vendedorext_pedidos_cortes";

		if ($this->idCorteActualizar != 0) {
			$datos = array("total" => $this -> totalCortePedidosVE, 
							"fecha_corte" => $this -> fechaCortePedidosVE,
							"id_corte" => $this -> idCorteActualizar);
			$respuesta =ModeloVendedorextPedidos::mdlActualizarCorteDiaVendExt($tabla, $datos);

		}else{
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"id_usuario_plataforma" => $_SESSION["id_dashboard"],
							"total" => $this -> totalCortePedidosVE, 
							"fecha_corte" => $this -> fechaCortePedidosVE);

			$respuesta = ModeloVendedorextPedidos::mdlCrearCorteDiaPedidosVendExt($tabla, $datos);
		}
		
		

		echo json_encode($respuesta);
	}
	
	/*============  End of CREAR CORTE VENDEDOR EXTERNO  =============*/

	/*=====================================================================
	=                   APROBAR / DESAPROBAR CORTE CAJA                   =
	=====================================================================*/
	
	public $idCorteCajaVE;
	public $estadoCorteCajaVE;

	public function ajaxAprobarDesaprobarCorte(){
		$tabla = "vendedorext_pedidos_cortes";
		$datos = array("id_corte" => $this -> idCorteCajaVE,
						"estado" => $this -> estadoCorteCajaVE);

		$respuesta = ModeloVendedorextPedidos::mdlAprobarDesaprobarCorte($tabla, $datos);

		echo json_encode($respuesta);


	}
	
	/*============  End of APROBAR / DESAPROBAR CORTE CAJA  =============*/

	/*==============================================================================
	=                   DIBUJAR DATA TABLE DE PEDIDOS ENTREGADOS                   =
	==============================================================================*/
	public $campo;
	public $valor;
	public $vendedor;
	public function ajaxDataTablePedEntregados(){
		$item = $this -> campo;
		$valor = $this -> valor;
		$tabla = "vendedorext_pedidos";
        $id_empresa = $_SESSION["idEmpresa_dashboard"];
        $id_vendedor = $this -> vendedor;

        $respuesta = ModeloVendedorextPedidos::mdlMostrarPedidos($tabla, $item, $valor, $id_empresa,$id_vendedor);

        echo json_encode($respuesta);
	}
	
	
	/*============  End of DIBUJAR DATA TABLE DE PEDIDOS ENTREGADOS  =============*/

	/*=============================================================================================
	=                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
	=============================================================================================*/
	public $folioPedidoActualizarEstadoPago;
	public $vendedorActualizarEstadoPago;
	public function ajaxActualizarEstadoPagoPedido(){
		$tabla ="vendedorext_pedidos";
		$folio = $this -> folioPedidoActualizarEstadoPago;
		$id_empresa = $_SESSION["idEmpresa_dashboard"];
		$vendedor = $this -> vendedorActualizarEstadoPago;

		$respuesta = ModeloVendedorextPedidos::mdlActualizarEstadoPagoPedido($tabla, $folio, $id_empresa, $vendedor);

		echo json_encode($respuesta);
	}
	
	/*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/
}


/*============================================================================
=                   MOSTRAR PRODUCTOS EN PEDIDOS DE VENDEDOR            =
============================================================================*/

if (isset($_POST["idProducto"])) {
    $mostrarProducto = new AjaxVendedorExtPedidos();
    $mostrarProducto -> idProducto = $_POST["idProducto"];
    $mostrarProducto -> ajaxMostrarProductos();
}

/*============  End of MOSTRAR PRODUCTOS EN PEDIDOS DE VENDEDOR  =============*/

/*=======================================================
=                   AGRUPAR PRODUCTOS                   =
=======================================================*/

if (isset($_POST["productosAgrupados"])) {
	$agruparProductos = new AjaxVendedorExtPedidos();
	$agruparProductos -> productosAgrupados = $_POST["productosAgrupados"];
	$agruparProductos -> ajaxAgruparProductos();
}

/*============  End of AGRUPAR PRODUCTOS  =============*/

/*==================================================
=                   CREAR PEDIDO                   =
==================================================*/

if (isset($_POST["inputFolioPedido"])) {
	$crearPedido = new AjaxVendedorExtPedidos();
	$crearPedido -> clienteCrearPedido = $_POST["clienteCrearPedido"];
	$crearPedido -> jsonProductosCrearPedido = $_POST["jsonProductosCrearPedido"];
	$crearPedido -> totalPedidoCrearPedido = $_POST["totalPedidoCrearPedido"];
	$crearPedido -> inputFolioPedido = $_POST["inputFolioPedido"];
	$crearPedido -> ajaxCrearPedido();
}

/*============  End of CREAR PEDIDO  =============*/

/*=====================================================
=                   CANCELAR PEDIDO                   =
=====================================================*/

if (isset($_POST["folioPedido"])) {
	$cancelarPedido = new AjaxVendedorExtPedidos();
	$cancelarPedido -> folioPedido = $_POST["folioPedido"];
	$cancelarPedido -> notaCancelacionPedido = $_POST["notaCancelacion"];
	$cancelarPedido -> vendedorCancelarPedido = $_POST["vendedorCancelarPedido"];
	$cancelarPedido -> ajaxCancelarPedido();
}

/*============  End of CANCELAR PEDIDO  =============*/

/*==========================================================
=            CANCELACION DEFINITIVA PEDIDO             =
==========================================================*/

if (isset($_POST["folioCancelarDefinitivo"])) {
	$cancelarDefinitivo = new AjaxVendedorExtPedidos();
	$cancelarDefinitivo -> folioCancelarDefinitivo = $_POST["folioCancelarDefinitivo"];
	$cancelarDefinitivo -> vendedorCancelarDefinitivo = $_POST["vendedorCancelarDefinitivo"];
	$cancelarDefinitivo -> ajaxCancelarPedidoDefinitivo();
}

/*=====  End of CANCELACION DEFINITIVA PEDIDO   ======*/

/*===================================================
=                   EDITAR PEDIDO                   =
===================================================*/
	
if (isset($_POST["folioPedidoVendExt"])) {
	$editarPedido = new AjaxVendedorExtPedidos();
	$editarPedido -> folioPedidoVendExt = $_POST["folioPedidoVendExt"];
	$editarPedido -> vendedorExt = $_POST["vendedorExt"];
	$editarPedido -> ajaxEditarPedido();
}	
	
/*============  End of EDITAR PEDIDO  =============*/


/*==============================================================
=                   EDITAR ESTADO DEL PEDIDO                   =
==============================================================*/

if (isset($_POST["folioPedidoEditEstado"])) {
    $actualizarEstado = new AjaxVendedorExtPedidos();
    $actualizarEstado -> folioPedidoEditEstado = $_POST["folioPedidoEditEstado"];
    $actualizarEstado -> estadoPedidoEditEstado = $_POST["estadoPedidoEditEstado"];
    $actualizarEstado -> vendedorPedidoEditEstado = $_POST["vendedorPedidoEditEstado"];
    $actualizarEstado -> ajaxEditarEstadoPedido();
}

/*============  End of EDITAR ESTADO DEL PEDIDO  =============*/

/*=======================================================
=            MOSTRAR VENTAS PAGOS DE VENDEDOR           =
=======================================================*/

if (isset($_POST["idVendedorExt"])) {
	$ventasAlmacen = new AjaxVendedorExtPedidos();
	$ventasAlmacen -> idVendedorExt = $_POST["idVendedorExt"];
	$ventasAlmacen -> ajaxMostrarVentasPagosVendedor();
}

/*=====  End of MOSTRAR VENTAS PAGOS DE VENDEDOR  ======*/

/*======================================================================
=                   MOSTRAR PAGOS PAGADOS DATA-TABLE                   =
======================================================================*/

if (isset($_POST["folioPedidoAprobar"])) {
	$mostrarPagosDt = new AjaxVendedorExtPedidos();
	$mostrarPagosDt -> folioPedidoAprobar = $_POST["folioPedidoAprobar"];
	$mostrarPagosDt -> idVendedorAprobar = $_POST["idVendedorAprobar"];
	$mostrarPagosDt -> ajaxMostrarPedidosDataTable();
	
}

/*============  End of MOSTRAR PAGOS PAGADOS DATA-TABLE   =============*/

/*=====================================================================================
=                   MOSTRAR TODOS LOS PAGOS DE UN PEDIDO DATA-TABLE                   =
=====================================================================================*/

if (isset($_POST["folioPedidoAprobaciones"])) {
	$mostrarPagosDt = new AjaxVendedorExtPedidos();
	$mostrarPagosDt -> folioPedidoAprobaciones = $_POST["folioPedidoAprobaciones"];
	$mostrarPagosDt -> idVendedor = $_POST["idVendedor"];
	$mostrarPagosDt -> ajaxMostrarTodosPagosPedidos();
	
}

/*============  End of MOSTRAR TODOS LOS PAGOS DE UN PEDIDO DATA-TABLE    =============*/


/*==============================================================================
=                   GUARDAR PAGO DE PEDIDO UNA VEZ ENTREGADO                   =
==============================================================================*/

if (isset($_POST["folioPedidoPagoEntregado"])) {
	$pagoPedidoEntrega = new AjaxVendedorExtPedidos();
	$pagoPedidoEntrega -> folioPedidoPagoEntregado = $_POST["folioPedidoPagoEntregado"];
	$pagoPedidoEntrega -> totalPedido = $_POST["totalPedido"];
	$pagoPedidoEntrega -> metodoPagoCrearPedido = $_POST["metodoPagoCrearPedido"];
	$pagoPedidoEntrega -> transaccionCrearPedido = $_POST["transaccionCrearPedido"];
	$pagoPedidoEntrega -> totalCreditoPedidoCrearPedido = $_POST["totalCreditoPedidoCrearPedido"];
	$pagoPedidoEntrega -> pagoInicialCreditoPedidoCrearPedido = $_POST["pagoInicialCreditoPedidoCrearPedido"];
	$pagoPedidoEntrega -> ajaxHacerPagoPedidoEntrega();
}

/*============  End of GUARDAR PAGO DE PEDIDO UNA VEZ ENTREGADO  =============*/

/*==================================================================
=                   CREAR CORTE VENDEDOR EXTERNO                   =
==================================================================*/

if (isset($_POST["totalCortePedidosVE"])) {
	$crearCorte = new AjaxVendedorExtPedidos();
	$crearCorte -> totalCortePedidosVE = $_POST["totalCortePedidosVE"];
	$crearCorte -> fechaCortePedidosVE = $_POST["fechaCortePedidosVE"];
	$crearCorte -> idCorteActualizar = $_POST["idCorteActualizar"];
	$crearCorte -> ajaxCrearCortePedidosVendExt();
}

/*============  End of CREAR CORTE VENDEDOR EXTERNO  =============*/

/*=====================================================================
=                   APROBAR / DESAPROBAR CORTE CAJA                   =
=====================================================================*/

if (isset($_POST["idCorteCajaVE"])) {
	$aprobarDesaporbar = new AjaxVendedorExtPedidos();
	$aprobarDesaporbar -> idCorteCajaVE = $_POST["idCorteCajaVE"];
	$aprobarDesaporbar -> estadoCorteCajaVE = $_POST["estadoCorteCajaVE"];
	$aprobarDesaporbar -> ajaxAprobarDesaprobarCorte();
}

/*============  End of APROBAR / DESAPROBAR CORTE CAJA  =============*/

/*==============================================================================
=                   DIBUJAR DATA TABLE DE PEDIDOS ENTREGADOS                   =
==============================================================================*/

if (isset($_POST["campo"])) {
	$dataTablePentregados = new AjaxVendedorExtPedidos();
	$dataTablePentregados -> campo = $_POST["campo"];
	$dataTablePentregados -> valor = $_POST["valor"];
	$dataTablePentregados -> vendedor = $_POST["vendedor"];
	$dataTablePentregados -> ajaxDataTablePedEntregados();
}


/*============  End of DIBUJAR DATA TABLE DE PEDIDOS ENTREGADOS  =============*/


/*=============================================================================================
=                   CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS                   =
=============================================================================================*/

if (isset($_POST["folioPedidoActualizarEstadoPago"])) {
	$cambiarEstadoPedido = new AjaxVendedorExtPedidos();
	$cambiarEstadoPedido -> folioPedidoActualizarEstadoPago = $_POST["folioPedidoActualizarEstadoPago"];
	$cambiarEstadoPedido -> vendedorActualizarEstadoPago = $_POST["vendedorActualizarEstadoPago"];
	$cambiarEstadoPedido -> ajaxActualizarEstadoPagoPedido();
}

/*============  End of CAMBIAR ESTADO DEL PEDIDO CUANDO SE COMPLETEN SUS PAGOS  =============*/