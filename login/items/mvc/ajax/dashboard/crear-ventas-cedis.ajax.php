<?php
session_start();

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';
require_once '../../modelos/dashboard/modelo.clientes-empresa.php';

class AjaxCrearVentaCedis{
    
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

		/* LISTADO DE PRODUCTOS CEDIS */

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

		/* CONFIGURACION GENERAL DE VENTAS */

		$tabla = "configuracion_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$configVentas = ModeloVentasCedis::mdlMostrarConfiguracionGeneralVentas($tabla,$empresa);

		

		$respuesta = array("id_producto" => $producto["id_producto"],
							"id_empresa" => $producto["id_empresa"],
							"codigo" => $producto["codigo"],
							"nombre" => $producto["nombre"],
							"stock" => $producto["stock_disponible"],
							"precio" => $precio,
							"costo" => $costo,
							"promo" => $promo,
							"activadoPromo" => $activado,
							"usar_iva" => $configVentas["usar_iva"],
							"iva_include" => $configVentas["incluido"],
							"sku" => $producto["sku"]);
    
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
			$tabla = "cedis_ventas_pagos_configuracion";
	        $item = "id_empresa";
	        $valor = $_SESSION['idEmpresa_dashboard'];

	        $respuestaCredito = ModeloVentasCedis::mdlMostrarConfiguracionVentasPagos($tabla, $item, $valor);

	        if ($respuestaCredito != false) {
	        	
	        	if ($respuestaCredito["promocion_venta"] == "no") { //SI NO SE TOMA PRECIOS DE PROMOCION

	        		$credito = "no";// ANEXAR A VARIABLE QUE "NO" SE TOMAN

	        	} else {

	        		$credito = "si";// ANEXAR A VARIABLE QUE "SI" SE TOMAN

	        	}

	        } 
		}

		/*=====================================================================
		=                   MOSTRAR CONFIGURACION DE VENTAS                   =
		=====================================================================*/
		
		$tabla = "configuracion_ventas";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$configVentas = ModeloVentasCedis::mdlMostrarConfiguracionGeneralVentas($tabla, $empresa);

		$iva = 0;
		if ($configVentas["usar_iva"] == "si" && $configVentas["incluido"] == "no") { //TOMAR EN CUENTA EL IVA
			$iva = 0.16;
		}

		$porcentajeComisionTD = 0;
		$porcentajeComisionTC = 0;
		$porTD = 1;
		$porTC = 1;
		if ($configVentas["comision_tarjeta"] == 'si') {
			
			//CONVERTIENDO A PORCENTAJE
			$porcentajeComisionTD = $configVentas["porcentajeTD"]/100;
			$porcentajeComisionTC = $configVentas["porcentajeTC"]/100;

			//OBTENIENDO PORCENTAJE PARA DIVIDIR
			$porTD = 1 - $porcentajeComisionTD;
			$porTC = 1 - $porcentajeComisionTC;


		}
		$ivacomision = 1;
		if ($configVentas["iva_comision_tarjeta"] == 'si') {
			$ivacomision = 1.16;
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
			
			$tabla = "productos_listado_precios";
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"modelo" => $result[$i]['modelo']);

			$precioResultados = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);

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

			//CALCULANDO PRECIO CON IVA
			$ivaProducto = $precio * $iva;
			$precioFinal = $precio + $ivaProducto;

			//CALCULANDO COMISION INICIAL
			$comisionTD = $porcentajeComisionTD * $precioFinal * $ivacomision;
			$comisionTC = $porcentajeComisionTC * $precioFinal * $ivacomision;

			
			//CALCULANDO PRECIO FINAL PARA EL CLIENTE
			$comisionFinalTD = (($comisionTD)/$porTD)+$precioFinal;
			$comisionFinalTC = (($comisionTC)/$porTC)+$precioFinal;


			foreach ($productos as $key => $value) {

				

				if ($value["precioEdit"] >= $value["costo"]) {
	
					//CALCULANDO COMISION INICIAL EDIT
					$comisionTD = $porcentajeComisionTD * $value["precioEdit"] * $ivacomision;
					$comisionTC = $porcentajeComisionTC * $value["precioEdit"] * $ivacomision;
	
					//PRECIO FINAL PARA EL CLIENTE
					$comisionFinalTD = (($comisionTD)/$porTD)+$value["precioEdit"];
					$comisionFinalTC = (($comisionTC)/$porTC)+$value["precioEdit"];
	 
					//TOTAL FINAL 
					$totalConComisionTD = floatval($value["cantidad"]) * floatval($comisionFinalTD); //
					$totalConComisionTC = floatval($value["cantidad"]) * floatval($comisionFinalTC); //
				
				}

				
				if ($value["modelo"] == $result[$i]['modelo']) {

					$monto = floatval($value["cantidad"]) * floatval($precioFinal);
					if ($value["precioEdit"] >= $value["costo"]) {
						//NUEVO MONTO DE ACUERDO AL NUEVO PRECIO
						$monto = $value["cantidad"] * $value["precioEdit"];
					}
					$totalConComisionTD = floatval($value["cantidad"]) * floatval($comisionFinalTD); //
					$totalConComisionTC = floatval($value["cantidad"]) * floatval($comisionFinalTC); //

					array_push($productosAgrupados, array("idProducto" => $value["idProducto"],
															"nombre" => $value["nombre"],
															"modelo" => $value["modelo"],
															"sku" => $value["sku"],
															"cantidad" => $value["cantidad"],
															"precio" => $precioFinal,
															"precioEdit" => $value["precioEdit"],
															"costo" => $value["costo"],
															"monto" => $monto,
															"montoEdit" => $monto,
															"stock" => $value["stock"],
															"configVentas" => $configVentas["comision_tarjeta"],
															"pagoTarjetaTD" => $totalConComisionTD,
															"pagoTarjetaTC" => $totalConComisionTC,
														)
					);
				}
			}
		}
		
		/*=====  End of CREAR ARREGLO DE PRODUCTOS  ======*/
		

		echo json_encode($productosAgrupados);
	}
	
	/*=====  End of AGRUPAR PRODUCTOS  ======*/

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

	public function ajaxCrearVentadeCedis(){

		/* VARIABLES PRINCIPALES */
		$metodoPago = $this -> metodoPagoCrearVenta;
		$folioPago = NULL;
		$costo_envio = 0;
		$domicilio = NULL;
		$estadoVenta = 'Aprobado';
		$total = $this -> totalVentaCrearVenta;

		date_default_timezone_set('America/Mexico_City');
		$fecha_aprobacion = date('Y-m-d H:i:s');

		$retorno = 0;
		$productos = json_decode($this -> jsonProductosCrearVenta, true);
		$lote = array();
		foreach ($productos as $key => $value) {

			$tabla = "productos";
            $item = "id_producto";
            $valor = $value["id"];
            $empresa = $_SESSION["idEmpresa_dashboard"];


			$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

			if ($value["cantidad"] > $producto["stock_disponible"]) {

				$retorno = 1;
			
			}

		}

		
		if ($retorno == 0) {
			
			foreach ($productos as $key => $value) {

				/* DETALLE DE VENTAS */
				$tabla = "cedis_venta_detalles";
				//Calcular la utilidad del producto
				$utilidad = ($value["precio"] - $value["costo"]) * $value["cantidad"];

				$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"vendedor" => $_SESSION['id_dashboard'],
								"folio" => $this -> folioCrearVenta,
								"id_producto" => $value["id"],
								"cantidad" => $value["cantidad"],
								"costo" => $value["costo"],
								"precio" => $value["precio"],
								"monto" => $value["Monto"],
								"utilidad" => round($utilidad,6));
				
				$detalle = ModeloVentasCedis::mdlCrearDetalle($tabla, $datos);

				

				/* DISMINUIR STOCK DEL PRODUCTO */
				$tablaProducto = "productos";
				$datosProductos = array("id_producto" => $value["id"],
										"stock" => $value["cantidad"]);

				$respuestaModificacion = ModeloProductos::mdlModificarStockDisponibleEmbarque($tablaProducto, $datosProductos);

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


				$tabla = "cedis_ventas_pagos";
				$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"id_usuario_plataforma" => $_SESSION["id_dashboard"],
								"folio" => $this -> folioCrearVenta,
								"monto" => $montoInicial,
								"estado" => "pagado",
								"comprobante" => "");

				$pago = ModeloVentasCedis::mdlRealizarPago($tabla, $datos);

				$total = $this -> totalCreditoVentaCrearVenta;
				
			}

			/* PRUEBA PARA LINK WEB
			-------------------------------------------------- */
			
			if ($metodoPago == "Link") {
				$estadoVenta = "Sin comprobante";
				$fecha_aprobacion = NULL;

				
			}
			
			/* End of PRUEBA PARA LINK WEB
			-------------------------------------------------- */


			if ($this -> entregaCrearVenta == "Domicilio") {

				$total = $total + $this -> costoEnvioCrearVenta;
				$domicilio = $this -> idDomicilioCrearVenta;
				$costo_envio = $this -> costoEnvioCrearVenta;

			} 


			/* DATOS PARA GUADRA VENTA GENERAL */
			
			$tabla = "cedis_ventas";
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"id_usuario_plataforma" => $_SESSION["id_dashboard"],
							"id_cliente" => $this -> clienteCrearVenta,
							"folio" => $this -> folioCrearVenta,
							"total" => $total,
							"metodo" => $metodoPago,
							"folio_pago_tarjeta" => $folioPago,
							"estado" => $estadoVenta,
							"fecha_aprobacion" => $fecha_aprobacion,
							"entrega_producto" => $this -> entregaCrearVenta,
							"envio" => $costo_envio,
							"id_domicilio" => $domicilio);

			$respuesta = ModeloVentasCedis::mdlCrearVenta($tabla, $datos);

		} else {

			$respuesta = "existencia";

		}

		echo json_encode($respuesta);
	}
	
	/*=====  End of CREAR VENTA   ======*/

	/*============================================================
	=                   MOSTRAR CLIENTE CREADO                   =
	============================================================*/
	
	public $usuarioCreado;
	public function ajaxMostrarClienteCreado(){
		$tabla = "clientes_empresa";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$item = "usuario";
		$valor = $this -> usuarioCreado;

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla,$item,$valor,$empresa);

		echo json_encode($respuesta);

	}	
	
	/*============  End of MOSTRAR CLIENTE CREADO  =============*/

	/*========================================================
	=                   MOSTRAR INFO LOTES                   =
	========================================================*/
	
	public $skuLoteInfo;
	public function ajaxMostrarInfoLotesProducto(){
		$tabla = "productos_lote";
		$sku = $this -> skuLoteInfo;

		$respuesta = ModeloProductos::mdlMostrarUltimosLotesProducto($tabla,$sku);

		echo json_encode($respuesta);

	}
	
	/*============  End of MOSTRAR INFO LOTES  =============*/
}


/*========================================
=            MOSTRAR PRODUCTO            =
========================================*/

if (isset($_POST["idProducto"])) {
	$mostrarProducto = new AjaxCrearVentaCedis();
	$mostrarProducto -> idProducto = $_POST["idProducto"];
	$mostrarProducto -> ajaxMostrarProducto();
}

/*=====  End of MOSTRAR PRODUCTO  ======*/

/*=========================================
=            AGRUPAR PRODUCTOS            =
=========================================*/

if (isset($_POST["productosAgrupados"])) {
	$agruparProductos = new AjaxCrearVentaCedis();
	$agruparProductos -> productosAgrupados = $_POST["productosAgrupados"];
	$agruparProductos -> creditoPreciosAgrupados = $_POST["creditoPreciosAgrupados"];
	$agruparProductos -> ajaxAgruparProductos();
}

/*=====  End of AGRUPAR PRODUCTOS  ======*/

/*===================================
=            CREAR VENTA            =
===================================*/

if (isset($_POST["folioCrearVenta"])) {
	$crearVenta = new AjaxCrearVentaCedis();
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
	$crearVenta -> ajaxCrearVentadeCedis();
}

/*=====  End of CREAR VENTA  ======*/

/*============================================================
=                   MOSTRAR CLIENTE CREADO                   =
============================================================*/

if (isset($_POST["usuarioCreado"])) {
	$mostrarCliente = new AjaxCrearVentaCedis();
	$mostrarCliente -> usuarioCreado = $_POST["usuarioCreado"];
	$mostrarCliente -> ajaxMostrarClienteCreado();
}

/*============  End of MOSTRAR CLIENTE CREADO  =============*/

/*========================================================
=                   MOSTRAR INFO LOTES                   =
========================================================*/

if (isset($_POST["skuLoteInfo"])) {
	$mostrarInfoLote = new AjaxCrearVentaCedis();
	$mostrarInfoLote -> skuLoteInfo = $_POST["skuLoteInfo"];
	$mostrarInfoLote -> ajaxMostrarInfoLotesProducto();
}

/*============  End of MOSTRAR INFO LOTES  =============*/

?>