<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.productos-almacen.php';
require_once '../../modelos//dashboard/modelo.ventas.php';

class AjaxCrearVenta{

	/*========================================
	=            MOSTRAR PRODUCTO            =
	========================================*/
	
	public $idProducto;

	public function ajaxMostrarProducto(){

		/* INFORMACION DEL PRODUCTO */

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idProducto;
		$empresa = $_SESSION['idEmpresa_dashboard'];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		/* LISTADO DE PRODUCTO DE ALMACEN */

		$tabla = "almacenes_productos_listado_precios";
		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"codigo" => $producto["codigo"]);

		$listado = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

		foreach ($listado as $key => $value) {

			if ($key == 0) {

				$precio = $value["precio"];
				$promo = $value["promo"];
				$activado = $value["activadoPromo"];

			}

		}

		/* CONSULTAR EL COSTO DEL PRODUCTO EN CEDIS */

		$tabla = "productos_listado_precios";
		$datos = array("id_empresa" => $_SESSION['idEmpresa_dashboard'],
						"modelo" => $producto["codigo"]);
		$listadoCedis = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);

		/* PRODUCTO DE ALMACEN */

		$tabla = "almacenes_productos";
		$datos = array("id_producto" => $this -> idProducto,
						"id_almacen" => $_SESSION["almacen_dashboard"]);

		$almacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);


		$respuesta = array("id_producto" => $producto["id_producto"],
						 "id_empresa" => $producto["id_empresa"],
						 "codigo" => $producto["codigo"],
						 "sku" => $producto["sku"],
						 "nombre" => $producto["nombre"],
						 "stock" => $almacen["stock"],
						 "precio" => $precio,
						 "costo" => $listadoCedis[0]["costo"],
						 "promo" => $promo,
						 "activadoPromo" => $activado);
    
		echo json_encode($respuesta);

	} 
	
	/*=====  End of MOSTRAR PRODUCTO  ======*/

	/*=========================================
	=            AGRUPAR PRODUCTOS            =
	=========================================*/
	
	public $productosAgrupados;
	public $creditoPreciosAgrupados;
	public function ajaxAgruparProductos(){

		/*===================================================================
		=            MOSTRAR CONFIGURACION DE CREDITO DE ALMACEN            =
		===================================================================*/
		$valorObtenidoCredito = $this -> creditoPreciosAgrupados;
		$credito = "si"; // INICIAR VARIABLE CON "si" DE SI SE TOMAN PRECIOS DE PROMOCION

		if ($valorObtenidoCredito == "Si") {
			$tabla = "ventas_pagos_configuracion";
	        $item = "id_almacen";
	        $valor = $_SESSION["almacen_dashboard"];

	        $respuestaCredito = ModeloVentas::mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor);

	        if ($respuestaCredito != false) {
	        	
	        	if ($respuestaCredito["promocion_venta"] == "no") { //SI NO SE TOMA PRECIOS DE PROMOCION

	        		$credito = "no";// ANEXAR A VARIABLE QUE "NO" SE TOMAN

	        	} else {

	        		$credito = "si";// ANEXAR A VARIABLE QUE "SI" SE TOMAN

	        	}

	        } 
		}

		/*=========================================
		=            AGRUPAR PRODUCTOS            =
		=========================================*/
		$productos = json_decode($this -> productosAgrupados, true);

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
			
			$tabla = "almacenes_productos_listado_precios";
			$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
							"codigo" => $result[$i]['modelo']);

			$precioResultados = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

			foreach ($precioResultados as $key => $value) {
				
				if ($result[$i]['cantidad'] >= $value["cantidad"]) {

					if ($credito == "si") { //TOMAR EN CUENTA PRECIOS PROMOCION

						if ($value["activadoPromo"] == 'si') {

							$precio = $value["promo"];

						} else {

							$precio = $value["precio"];

						}

					} else { //NO TOMAR EN CUENTA PRECIOS PROMOCION

						$precio = $value["precio"];

					}

				}
			}


			foreach ($productos as $key => $value) {
				
				if ($value["modelo"] == $result[$i]['modelo']) {
					
					$monto = floatval($value["cantidad"]) * floatval($precio);

					array_push($productosAgrupados, array("idProducto" => $value["idProducto"],
															"nombre" => $value["nombre"],
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
	
	/*=====  End of AGRUPAR PRODUCTOS  ======*/
	
	/*====================================================================
	=            MOSTRAR EXISTENCIA DE PRODUCTOS EN ALMACENES            =
	====================================================================*/
	
	public $idProductoExistencia;

	public function ajaxMostrarExistenciasAlmacenes(){

		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"id_producto" => $this -> idProductoExistencia);

		$respuesta = ModeloProductosAlmacen::mdlMostrarExistenciasAlmacenes($datos);

		echo json_encode($respuesta); 

	}
	
	/*=====  End of MOSTRAR EXISTENCIA DE PRODUCTOS EN ALMACENES  ======*/

	/*====================================
	=            CREAR VENTA             =
	====================================*/
	
	public $folioCrearVenta;
	public $clienteCrearVenta;
	public $jsonProductosCrearVenta;
	public $totalVentaCrearVenta;
	public $metodoPagoCrearVenta;
	public $transaccionCrearVenta;
	public $totalCreditoVentaCrearVenta; 
	public $pagoInicialCreditoVentaCrearVenta;
	public $entregaCrearVenta;
	public $costoEnvioCrearVenta;
	public $idDomicilioCrearVenta;

	public function ajaxCrearVentaAlmacen(){

		/* VARIABLES PRINCIPALES */
		$metodoPago = $this -> metodoPagoCrearVenta;
		$folioPago = NULL;
		$costo_envio = 0;
		$domicilio = NULL;
		$estadoVenta = 'Aprobado';
		$total = $this -> totalVentaCrearVenta;

		$retorno = 0;
		$productos = json_decode($this -> jsonProductosCrearVenta, true);

		foreach ($productos as $key => $value) {

			$tabla = "almacenes_productos";
			$datos = array("id_producto" => $value["id"],
							"codigo" => NULL,
							"id_almacen" => $_SESSION["almacen_dashboard"]);

			$producto = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

			if ($value["cantidad"] > $producto["stock"]) {

				$retorno = 1;
			
			}

		}

		if ($retorno == 0) {
			
			foreach ($productos as $key => $value) {

				/* DETALLE DE VENTAS */
				$tabla = "ventas_detalle";
				//Calcular la utilidad del producto
				$utilidad = ($value["precio"] - $value["costo"]) * $value["cantidad"];

				$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],	
								"folio" => $this -> folioCrearVenta,
								"id_producto" => $value["id"],
								"cantidad" => $value["cantidad"],
								"costo" => $value["costo"],
								"precio" => $value["precio"],
								"monto" => $value["Monto"],
								"utilidad" => round($utilidad,6));
				
				$detalle = ModeloVentas::mdlCrearDetalle($tabla, $datos);

				/* DISMINUIR STOCK DEL PRODUCTO */
				$tablaProducto = "almacenes_productos";
				$datosProductos = array("id_almacen" => $_SESSION["almacen_dashboard"],
										"id_producto" => $value["id"],
										"cantidad" => $value["cantidad"]);

				$respuestaModificacion = ModeloProductosAlmacen::mdlEditarStock($tablaProducto,$datosProductos);

			}


			if ($metodoPago == "TD" || $metodoPago == "TC") {
				
				$folioPago = $this -> metodoPagoCrearVenta."-".$this -> transaccionCrearVenta;

			}

			if ($metodoPago == "Pagos") {
				$estadoVenta = "Pendiente";
				$montoInicial = $this -> pagoInicialCreditoVentaCrearVenta;

				if ($this -> entregaCrearVenta == "Domicilio") {

					$montoInicial = $montoInicial + $this -> costoEnvioCrearVenta;
					
				}


				$tabla = "ventas_pagos";
				$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
								"id_usuario_plataforma" => $_SESSION["id_dashboard"],
								"folio" => $this -> folioCrearVenta,
								"monto" => $montoInicial,
								"estado" => "pagado",
								"comprobante" => "");

				$pago = ModeloVentas::mdlHacerPago($tabla, $datos);

				$total = $this -> totalCreditoVentaCrearVenta;
				
			}


			if ($this -> entregaCrearVenta == "Domicilio") {

				$total = $total + $this -> costoEnvioCrearVenta;
				$domicilio = $this -> idDomicilioCrearVenta;
				$costo_envio = $this -> costoEnvioCrearVenta;

			} 




			/* DATOS PARA GUADRA VENTA GENERAL */
			$tabla = "ventas";
			$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
							"id_usuario_plataforma" => $_SESSION["id_dashboard"],
							"id_cliente" => $this -> clienteCrearVenta,
							"folio" => $this -> folioCrearVenta,
							"total" => $total,
							"metodo" => $metodoPago,
							"folio_pago_tarjeta" => $folioPago,
							"estado" => $estadoVenta,
							"entrega_producto" => $this -> entregaCrearVenta,
							"envio" => $costo_envio,
							"id_domicilio" => $domicilio);

			$respuesta = ModeloVentas::mdlCrearVenta($tabla, $datos);

		} else {

			$respuesta = "existencia";

		}

		echo json_encode($respuesta);
	}
	
	/*=====  End of CREAR VENTA   ======*/
	
	
}

/*========================================
=            MOSTRAR PRODUCTO            =
========================================*/

if (isset($_POST["idProducto"])) {
	$mostrarProducto = new AjaxCrearVenta();
	$mostrarProducto -> idProducto = $_POST["idProducto"];
	$mostrarProducto -> ajaxMostrarProducto();
}

/*=====  End of MOSTRAR PRODUCTO  ======*/

/*=========================================
=            AGRUPAR PRODUCTOS            =
=========================================*/

if (isset($_POST["productosAgrupados"])) {
	$agruparProductos = new AjaxCrearVenta();
	$agruparProductos -> productosAgrupados = $_POST["productosAgrupados"];
	$agruparProductos -> creditoPreciosAgrupados = $_POST["creditoPreciosAgrupados"];
	$agruparProductos -> ajaxAgruparProductos();
}

/*=====  End of AGRUPAR PRODUCTOS  ======*/

/*====================================================================
=            MOSTRAR EXISTENCIA DE PRODUCTOS EN ALMACENES            =
====================================================================*/

if (isset($_POST["idProductoExistencia"])) {
	$existencias = new AjaxCrearVenta();
	$existencias -> idProductoExistencia = $_POST["idProductoExistencia"];
	$existencias -> ajaxMostrarExistenciasAlmacenes();
}

/*=====  End of MOSTRAR EXISTENCIA DE PRODUCTOS EN ALMACENES  ======*/

/*===================================
=            CREAR VENTA            =
===================================*/

if (isset($_POST["folioCrearVenta"])) {
	$crearVenta = new AjaxCrearVenta();
	$crearVenta -> folioCrearVenta = $_POST["folioCrearVenta"];
	$crearVenta -> clienteCrearVenta = $_POST["clienteCrearVenta"];
	$crearVenta -> jsonProductosCrearVenta = $_POST["jsonProductosCrearVenta"];
	$crearVenta -> totalVentaCrearVenta = $_POST["totalVentaCrearVenta"];
	$crearVenta -> metodoPagoCrearVenta = $_POST["metodoPagoCrearVenta"];
	$crearVenta -> transaccionCrearVenta = $_POST["transaccionCrearVenta"];
	$crearVenta -> totalCreditoVentaCrearVenta = $_POST["totalCreditoVentaCrearVenta"];
	$crearVenta -> pagoInicialCreditoVentaCrearVenta = $_POST["pagoInicialCreditoVentaCrearVenta"];
	$crearVenta -> entregaCrearVenta = $_POST["entregaCrearVenta"];
	$crearVenta -> costoEnvioCrearVenta = $_POST["costoEnvioCrearVenta"];
	$crearVenta -> idDomicilioCrearVenta = $_POST["idDomicilioCrearVenta"];
	$crearVenta -> ajaxCrearVentaAlmacen();
}

/*=====  End of CREAR VENTA  ======*/


?>