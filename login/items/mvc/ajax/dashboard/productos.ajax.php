<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';
require_once '../../modelos/dashboard/modelo.ventas.php';
require_once '../../modelos/dashboard/modelo.productos-almacen.php';
require_once '../../modelos/dashboard/modelo.almacenes.php';

class AjaxProductos{

	/*=======================================================
	=            MOSTRAR PRODUCTOS EN DATA TABLE            =
	=======================================================*/

	public function ajaxMostrarInicioProductos(){
 
		$tabla = "productos";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlMostrarProductosDataTable($tabla, $empresa);

		echo json_encode($respuesta); 
	} 

	/*=====  End of MOSTRAR PRODUCTOS EN DATA TABLE  ======*/
		/*=======================================================
	=            MOSTRAR PRODUCTOS EN DATA TABLE            =
	=======================================================*/

	public function ajaxMostrarInicioProductosPapelera(){
 
		$tabla = "productos";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlMostrarProductosPapeleraDataTable($tabla, $empresa);

		echo json_encode($respuesta); 
	} 

	/*=====  End of MOSTRAR PRODUCTOS EN DATA TABLE  ======*/

	/*======================================================
	=            VERIFICAR EXISTENCIA DE MODELO            =
	======================================================*/
	
	public $existenciaModeloProducto;

	public function ajaxVerificarExisteciaModelo(){

		$tabla = "productos"; 

		$datos = array("codigo" => $this -> existenciaModeloProducto,
						"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

		$respuesta = ModeloProductos::mdlExistenciaModelo($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of VERIFICAR EXISTENCIA DE MODELO  ======*/

	/*============================================
	=            CREAR PRODUCTO NUEVO            =
	============================================*/
	
	public $productoCrearModelo;
	public $productoCrearAleatorio;
	public $productoCrearNombre;
	public $productoCrearDescripcion;
	public $productoCrearStock;
	public $productoCrearCosto;
	public $productoCrearPrecioSugerido;
	public $productoCrearPrecio;
	public $productoCrearPrecioPromo;
	public $productoCrearCaracteristicas;
	public $productoCrearMedidas;
	public $productoCrearPeso;
	public $productoCrearFactura;
	public $productoCrearProveedor;
	public $productoCrearClaveProdServ;
	public $productoCrearClaveUnidad;


	public function ajaxCrearProducto(){
		/*================================
		=            PRODUCTO            =
		================================*/
		
		$tabla = "productos";
		/* SKU */
		$sku = $_SESSION["idEmpresa_dashboard"];
		$sku .= "-"; 
		$sku .= $this -> productoCrearModelo;
		$sku .= "-";
		$sku .= $this -> productoCrearAleatorio;

		/*============================
		=            LOTE            =
		============================*/
		
		$tablaLote = "productos_lote";
		$datosLote = array("sku" => $sku,
							"cantidad" => $this -> productoCrearStock,
							"costo" => $this -> productoCrearCosto,
							"precioSugerido" => $this -> productoCrearPrecioSugerido,
							"factura" => $this -> productoCrearFactura,
							"proveedor" => $this -> productoCrearProveedor,
							"costo_prom_ant" => 0,
							"stock_ant_disp" => 0,
							"no_lote" => 1);

		$respuestaLote = ModeloProductos::mdlCrearLote($tablaLote, $datosLote);
		
		/*=====  End of LOTE  ======*/
		

		/*=============================================
		=                   PRODUCTO                   =
		=============================================*/
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"codigo" => $this -> productoCrearModelo, 
						"sku" => $sku,
						"nombre" => $this -> productoCrearNombre, 
						"descripcion" => $this -> productoCrearDescripcion,
						"stock" => $this -> productoCrearStock,
						"caracteristicas" => $this -> productoCrearCaracteristicas,
						"medidas" => $this -> productoCrearMedidas,
						"peso" => $this -> productoCrearPeso,
						"sat_clave_prod_serv" => $this -> productoCrearClaveProdServ,
						"sat_clave_unidad" => $this -> productoCrearClaveUnidad
					);
 
		$respuesta = ModeloProductos::mdlCrearProducto($tabla,$datos);
		
		
		/*============  End of PRODUCTO  =============*/


		/*===============================
		=            LISTADO            =
		===============================*/

		$tablaListado = "productos_listado_precios";
		$datosListado = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							  "modelo" => $this -> productoCrearModelo,
							  "cantidad" => 1,
							  "costo" => $this -> productoCrearCosto,
							  "precio" => $this -> productoCrearPrecio,
							  "promo" => $this -> productoCrearPrecio,
							  "activadoPromo" => "no");

		$respuestaListado = ModeloProductos::mdlCrearListadoPrecios($tablaListado, $datosListado);
		
		/*=====  End of LISTADO  ======*/
		

		echo json_encode($respuestaListado);

	}
	
	/*=====  End of CREAR PRODUCTO NUEVO  ======*/

	/*========================================================
	=            MOSTRAR INFORMACION DEL PRODUCTO            =
	========================================================*/
	
	public $infoMostrar; 
	public function ajaxMostrarInfoProducto(){

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> infoMostrar;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR INFORMACION DEL PRODUCTO  ======*/

	/*========================================================================
	=            MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO            =
	========================================================================*/
	
	public $idInfoCaracteristicas;
	
	public function ajaxMostrarCaracteristicasProducto(){

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idInfoCaracteristicas;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		echo $producto["caracteristicas"];

	}
	
	/*=====  End of MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO  ======*/

	/*==========================================================
	=            MOSTRAR INFORMACION DATOS DE ENVIO            =
	==========================================================*/
	
	public $idInfoDatosEnvio;

	public function ajaxMostrarEnvio(){

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idInfoDatosEnvio;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		$respuesta = array("medidas" => json_decode($producto["medidas"], true),
							"peso" => $producto["peso"]);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR INFORMACION DATOS DE ENVIO  ======*/

	/*=======================================================
	=            EDITAR INFORMACION DEL PRODUCTO            =
	=======================================================*/
	
	public $ProductoEditarIdInfo;
	public $ProductoEditarNombreInfo;
	public $ProductoEditarDescripcionInfo;
	public $ProductoEditarCaracteristicasInfo;
	public $ProductoEditarMedidasInfo;
	public $ProductoEditarPesoInfo;
	public $ProductoEditarClaveProdServInfo;
	public $ProductoEditarClaveUnidadInfo;

	public function ajaxEditarInfoProducto(){

		$tabla = "productos";

		$datos = array("id_producto" => $this -> ProductoEditarIdInfo,
						"nombre" => $this -> ProductoEditarNombreInfo,
						"descripcion" => $this -> ProductoEditarDescripcionInfo,
						"caracteristicas" => $this -> ProductoEditarCaracteristicasInfo,
						"medidas" => $this -> ProductoEditarMedidasInfo,
						"peso" => $this -> ProductoEditarPesoInfo,
						"sat_clave_prod_serv" => $this -> ProductoEditarClaveProdServInfo,
						"sat_clave_unidad" => $this -> ProductoEditarClaveUnidadInfo);

		$respuesta = ModeloProductos::mdlEditarInfoProducto($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of EDITAR INFORMACION DEL PRODUCTO  ======*/

/* **************************************************************************************** */
/* **************************************************************************************** */
/* **************************************************************************************** */
//************************ FUNCIONES DE LOTES DE PRODUCTO ************************************

	/*==================================================
	=            MOSTRAR LOTES DEL PRODUCTO            =
	==================================================*/
	
	public $lotesMostrar;
	
	public function ajaxMostrarLotesProductos(){

		$tabla = "productos_lote";
		$item = "sku";
		$valor = $this -> lotesMostrar;

		$respuesta = ModeloProductos::mdlMostrarLotesProducto($tabla, $item, $valor);

		echo json_encode($respuesta); 
	}
	
	/*=====  End of MOSTRAR LOTES DEL PRODUCTO  ======*/

	/*====================================================================================
	=            CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO            =
	====================================================================================*/
	public $loteCrearSku;
	public $loteCrearCodigo;
	public $loteCrearPiezas;
	public $loteCrearCosto;
	public $LoteCrearPrecioSugerido;
	public $loteCrearProveedor;
	public $loteCrearFolio;
	
	public function ajaxCrearLote(){

		/* ACTUALIZAR COSTO DE PRODUCTO (COSTO PROMEDIO)
		-------------------------------------------------- */

		/* se obtiene el costo actual del producto */
		$tablaListado = "productos_listado_precios";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"modelo" => $this -> loteCrearCodigo);

		$respuestaListado = ModeloProductos::mdlMostrarPreciosProducto($tablaListado,$datos);

        /* se obtiene el STOCK  actual del producto en CEDIS*/
		$tablaProductos = "productos";
		$item = "sku";
		$valor = $this -> loteCrearSku;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuestaProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $empresa);

		
		/* OBTENER ALMACENES DE EMPRESA Y STOCK DE ALMACENES
		-------------------------------------------------- */
		
		$almacenesEmpresa = ModeloProductosAlmacen::mdlMostrarAlmacenesEmpresa($_SESSION["idEmpresa_dashboard"]);
		
		if ($almacenesEmpresa != false) {
			$consulta = "";
			foreach ($almacenesEmpresa as $key => $almacen) {
				/* CONSULTAR STOCK DEL PRODUCTO EN LOS ALMACENES DE LA EMPRESA */

				if ($key == 0) {
					/* SI SOLO ES UN ALMACEN */
					$consulta .= " id_almacen = '".$almacen["id_almacen"]."'";
	
				} else {
					/* SI HAY MAS DE UN ALMACEN */
					$consulta .= " OR id_almacen = '".$almacen["id_almacen"]."'";
	
				}

				$respuestaStockAlmacenes = ModeloProductosAlmacen::mdlMostrarStockProductosAlmacenPorCodigo($this -> loteCrearCodigo,$consulta);
			}
		}
		
		/* End of OBTENER ALMACENES DE EMPRESA Y STOCK DE ALMACENES
		-------------------------------------------------- */
		
		/* valida si existe o no stock del producto en almacenes*/

		if ($respuestaStockAlmacenes["stock_almacenes"] == NULL) {
			$stockAlmacenes = 0;
		}else{
			$stockAlmacenes = $respuestaStockAlmacenes["stock_almacenes"];
		}

		/****  Variables para calcular promedio (COSTO PROMEDIO)****/
		
		// Se calcula el valor actual del stock disponible
		$totalStockActual = $respuestaProducto["stock_disponible"] + $stockAlmacenes;
		$valorInventario = $respuestaListado[0]["costo"] * ($totalStockActual); //150
		// Se calcula el valor total del numero de piezas que entran
		$valorEntrada = $this -> loteCrearCosto * $this -> loteCrearPiezas; //195
		//Se suma el stock disponible y el stock en almacenes con el el numero de piezas que entra
		$existenciaTotal = $this -> loteCrearPiezas + $totalStockActual;

		//Se calcula el costo promedio de las piezas
		$costoPromedio = ($valorInventario + $valorEntrada)/$existenciaTotal;

		//Cambiar el costo en listado de precios CEDIS
		$datos = ["costo" => round($costoPromedio,6), "modelo" => $this -> loteCrearCodigo, "empresa" => $_SESSION["idEmpresa_dashboard"]];
		$respuestaCambioCosto = ModeloProductos::mdlEditarCostoListadoPrecios($tablaListado,$datos);

		/* CREAR LOTE
		-------------------------------------------------- */

		/* Consultar cantidad de lotes para asignar un numero de lote */
		
		$tabla = "productos_lote";
		$item = "sku";
		$valor = $this -> loteCrearSku;
		$respCantLotes = ModeloProductos::mdlMostrarCantidadLotesProducto($tabla, $item, $valor);
		
		/* Crear lote */
		$datos = array("sku" => $this -> loteCrearSku ,
						"cantidad" => $this -> loteCrearPiezas,
						"costo" => $this -> loteCrearCosto,
						"precioSugerido" => $this -> LoteCrearPrecioSugerido,
						"factura" => $this -> loteCrearFolio,
						"proveedor" => $this -> loteCrearProveedor,
						"costo_prom_ant" => $respuestaListado[0]["costo"],
						"stock_ant_disp" => $totalStockActual,
						"no_lote" => $respCantLotes[0]+1);

		$respuestaCrearLote = ModeloProductos::mdlCrearLote($tabla, $datos);

        /* ACTUALIZAR STOCK GENERAL
		-------------------------------------------------- */
		$tablaProductos = "productos";

		$respuestaStocks = ModeloProductos::mdlMostrarStocksProductoPorSKU($tablaProductos,$this -> loteCrearSku);

		$cantidad = $respuestaStocks["stock"] + $this -> loteCrearPiezas;
		$disponible = $respuestaStocks["stock_disponible"] + $this -> loteCrearPiezas;

		$tablaProductos = "productos";
		$datosProductos =  array("sku" => $this -> loteCrearSku,
							"stock" => $cantidad,
							"stock_disponible" => $disponible);
 
		$respuestaProducto = ModeloProductos::mdlEditarLoteStockGeneral($tablaProductos, $datosProductos);


		/* ACTUALIZAR TABLE DE LOTES
		-------------------------------------------------- */
		
		$item = "sku";
		$valor = $this -> loteCrearSku;

		$respuesta = ModeloProductos::mdlMostrarLotesProducto($tabla, $item, $valor);
		echo json_encode($respuesta);

	}
	/*=====  End of CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO  ======*/

	/*===================================================================
	=            MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL            =
	===================================================================*/
	
	public $LoteEditarId;
	public $LoteEditarSkuGeneral;
	public $LoteEditarCantidadInput;
	public $LoteEditarFecha;
	public $LoteEditarModelo;
	public $LoteEditarCostoInput;

	public function ajaxEditarLote(){

		$loteId = $this -> LoteEditarId;
		$loteSku = $this -> LoteEditarSkuGeneral;
		$loteCantidadInput = $this -> LoteEditarCantidadInput;
		$loteModelo = $this -> LoteEditarModelo;
		$loteFecha = $this -> LoteEditarFecha;
		$loteCostoInput = $this -> LoteEditarCostoInput;

		/* CONSULTAR INFO DE LOTE ACTUAL A EDITAR */

		$tablaLotes = "productos_lote";
		$datos = ["fecha" => $loteFecha,
					"sku" => $loteSku];

		$respuestaLoteActual = ModeloProductos::mdlMostrarLoteProductoXFechaSku($tablaLotes, $datos);


		/* VALIDAR QUE LA CANTIDAD INGRESADA SEA DIFERENTE DE LA CONTENIDA EN EL LOTE ACTUAL */

		if ($loteCantidadInput !== $respuestaLoteActual["cantidad"] || $loteCostoInput !== $respuestaLoteActual["costo"]) {
			
			
			/* VERIFICA QUE NO HAYA MAS DE UN LOTE SIN COSTO PROMEDIO ANTERIOR
				SI HAY MAS DE UN LOTE SIN COSTO PROMEDIO NO PODRA SER EDITADO
			-------------------------------------------------- */
			
			$item = "sku";
			$respuestaLotes = ModeloProductos::mdlMostrarLotesProducto($tablaLotes, $item, $loteSku);

			$masDeUnLote = "no";

			if ($respuestaLoteActual["costo_prom_ant"] == 0 && sizeof($respuestaLotes) > 1) {
				$masDeUnLote = "si";
			}


			if ($masDeUnLote !== 'si') {
				
				/* CONSULTAR STOCK ACTUAL DISPONIBLE
				-------------------------------------------------- */
				$tablaProductos = 'productos';
		
				$respuestaStocks = ModeloProductos::mdlMostrarStocksProductoPorSKU($tablaProductos,$loteSku);
	
				/* IDENTIFICAR SI ES UN NUMERO MAYOR O MENOR
				-------------------------------------------------- */
				if ($loteCantidadInput <= $respuestaLoteActual["cantidad"]) {
					/* SI LA CANTIDAD ES UN NUMERO MENOR A LA CANTIDAD DEL LOTE ACTUAL */

					$resta = $respuestaLoteActual["cantidad"] - $loteCantidadInput;
					$newStockGral = $respuestaStocks["stock"] - $resta;
					$newStockDisp = $respuestaStocks["stock_disponible"] - $resta;
					
				}else{
					/* SI LA CANTIDAD ES UN NUMERO MAYOR A LA CANTIDAD DEL LOTE ACTUAL */

					$suma = $loteCantidadInput - $respuestaLoteActual["cantidad"];
					$newStockGral = $respuestaStocks["stock"] + $suma;
					$newStockDisp = $respuestaStocks["stock_disponible"] + $suma;
		
				}


				/**
				* AL SER EL PRIMER LOTE Y NO HABER UN COSTO ANTERIOR, MIENTRAS EL COSTO SEAL EL MISMO
				* Y EL NUEVO STOCK DISPONIBLE SEA MENOR 0 
				* SE CAMBIA EL COSTO CON EL INGRESADO POR EL USUARIO
				*/

				if ($respuestaLoteActual["costo_prom_ant"] !== 0  ) { //&& $newStockDisp >= 0 && $loteCostoInput !== $respuestaLoteActual["costo"] 
					// $accion="OK ";
					$respuesta="";
					/*  SI EL STOCK DISPONIBLE ES UN NUMERO NEGATIVO, TOMAR LA CANTIDAD ACTUAL DEL LOTE
						Y NO LA INGRESADA POR EL USUARIO  */

					if ($newStockDisp < 0) {
						$loteCantidadInput = $respuestaLoteActual["cantidad"] ;
					}

					/* RECALCULANDO COSTO PROM SIEMPRE
					-------------------------------------------------- */
					
					// Se calcula el valor actual del stock disponible
					$valorInventario = $respuestaLoteActual["costo_prom_ant"] * $respuestaLoteActual["stock_ant_disp"];
					// Se calcula el valor total del numero de piezas que entran
					$valorEntrada = $loteCantidadInput * $loteCostoInput;
					//Se obtiene el stock total
					$existenciaTotal = $respuestaLoteActual["stock_ant_disp"] + $loteCantidadInput ;
	
					//Se calcula el costo promedio de las piezas
					$costoPromedio = ($valorInventario + $valorEntrada) / $existenciaTotal;
	
					$newCosto = round($costoPromedio,6);
					
					/* MOSTRAR VENTAS HECHAS DESPUES DE AGREGAR EL LOTE SIEMPRE
					-------------------------------------------------- */
					
					$datosConsulta = ["sku" => $loteSku,
					"fecha" => $loteFecha];
	
					$respuestaVentas = ModeloProductos::mdlMostrarVentasPorFechaSkuDeLote($datosConsulta);
	
					if ($respuestaVentas != false ) {
						
						/* EDITAR COSTO Y UTILIDAD DE LAS VENTAS
						-------------------------------------------------- */
	
						$tablaDetalleVenta = "cedis_venta_detalles";
	
						foreach ($respuestaVentas as $key => $value) {
	
							$costoTotal = $value["cantidad"] * $newCosto;
	
							$newUtilidad = $value["monto"] - $costoTotal;
	
							$datos = ["costo" => $newCosto, 
										"utilidad" => round($newUtilidad,6),
										"id_cedis_ventas_detalles" => $value["id_cedis_ventas_detalles"]];
	
							$edicionCostUtil = ModeloProductos::mdlEditarCostoUtilidadDetalleVenta($tablaDetalleVenta,$datos);
	
						}
						
	
					}


					/* MOSTRAR VENTAS HECHAS ALMACEN DESPUES DE AGREGAR EL LOTE
					-------------------------------------------------- */

					$respuestaVentasAlmacen = ModeloVentas::mdlMostrarVentasPorSKUAlmacen($datosConsulta);

					if ($respuestaVentasAlmacen != false ) {
						
						/* EDITAR COSTO Y UTILIDAD DE LAS VENTAS
						-------------------------------------------------- */
	
						$tablaDetalleVenta = "ventas_detalle";
	
						foreach ($respuestaVentasAlmacen as $key => $value) {
	
							$costoTotal = $value["cantidad"] * $newCosto;
	
							$newUtilidad = $value["monto"] - $costoTotal;
	
							$datos = ["costo" => $newCosto, 
										"utilidad" => round($newUtilidad,6),
										"id_detalle" => $value["id_detalle"]];
	
							$costUtilAlmacen = ModeloVentas::mdlEditarCostoUtilidadDetalleVenta($tablaDetalleVenta,$datos);
	
						}
						
	
					}
	
					/* EDITAR COSTO EN LISTA DE PRECIOS SIEMPRE
					-------------------------------------------------- */
					$tablaListado = "productos_listado_precios";
					$datosListado = ["costo" => $newCosto,
									 "modelo" => $loteModelo,
									 "empresa" => $_SESSION["idEmpresa_dashboard"]];
	
					$editarCostoListaPrecios = ModeloProductos::mdlEditarCostoListadoPrecios($tablaListado,$datosListado);
					
					/* MODIFICAR COSTO DEL LOTE SIEMPRE
					-------------------------------------------------- */
					
					$tabla = "productos_lote";
					$item = "costo";
					$valor = $loteCostoInput;
		
					$respuesta = ModeloProductos::mdlEditarLote($tabla, $item, $valor, $loteId);

					
					if ($newStockDisp >= 0) {
						
						/* MODIFICACION DE STOCK GENERAL Y DISPONIBLE DEL PRODUCTO
						-------------------------------------------------- */
						
						$tablaProducto = "productos";
						$datosProducto =  ["sku" => $loteSku,
											"stock" => $newStockGral,
											"stock_disponible" => $newStockDisp];
			
						$respuestaProducto = ModeloProductos::mdlEditarLoteStockGeneral($tablaProducto, $datosProducto);
						
						/* MODIFICAR LOTE
						-------------------------------------------------- */
						
						$tabla = "productos_lote";
						$item = "cantidad";
						$valor = $loteCantidadInput;
			
						$respuestaLotes = ModeloProductos::mdlEditarLote($tabla, $item, $valor, $loteId);

						$respuesta = "modCantidad";
					}

					$respuesta .= "modCosto";
					
				}else{

					$respuesta = "error";

				}
				

			}else{
				$respuesta = "problema utilidad";
			}

		}else{
			
			$respuesta = "igual";
		}


		echo json_encode($respuesta);

	}
	
	/*=====  End of MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL  ======*/


	/*================================================================
	=            ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL            =
	================================================================*/
	
	public $LoteEliminarId;
	public $LoteEliminarSku;
	public $LoteEliminarCantidad;
	public $LoteEliminarFecha;
	public $LoteEliminarCostoAnterior;
	public $LoteEliminarModelo;

	public function ajaxEliminarLote(){

		$fecha = $this->LoteEliminarFecha;
		$costoAnterior = $this->LoteEliminarCostoAnterior;
		$modelo = $this->LoteEliminarModelo;
		$sku = $this -> LoteEliminarSku;

		/* SE OBTIENE EL STOCK  ACTUAL DEL PRODUCTO EN ALMACENES
		-------------------------------------------------- */
		
		$almacenesEmpresa = ModeloProductosAlmacen::mdlMostrarAlmacenesEmpresa($_SESSION["idEmpresa_dashboard"]);
		
		/* SI LA EMPRESA NO CUENTA CON ALMACENES, EL STOCK ES DE 0 */
		
		$stockAlmacenes = 0;

		if ($almacenesEmpresa != false) {
			$consulta = "";
			foreach ($almacenesEmpresa as $key => $almacen) {
				/* CONSULTAR STOCK DEL PRODUCTO EN LOS ALMACENES DE LA EMPRESA */

				if ($key == 0) {
					/* SI SOLO ES UN ALMACEN */
					$consulta .= " id_almacen = '".$almacen["id_almacen"]."'";
	
				} else {
					/* SI HAY MAS DE UN ALMACEN */
					$consulta .= " OR id_almacen = '".$almacen["id_almacen"]."'";
	
				}

				$respuestaStockAlmacenes = ModeloProductosAlmacen::mdlMostrarStockProductosAlmacenPorCodigo($modelo,$consulta);
			}

			/* VALIDANDO QUE HAYA STOCK EN LOS ALMACENES */
			
			if ($respuestaStockAlmacenes[0] !== null) {

				$stockAlmacenes = $respuestaStockAlmacenes[0];
			}
		}


		/* CONSULTAR STOCK ACTUAL EN CEDIS Y OBTENIENDO STOCK TOTAL DISPONIBLE
		-------------------------------------------------- */

		$tabla = 'productos';

		$respuestaStock = ModeloProductos::mdlMostrarStocksProductoPorSKU($tabla, $sku);

		$stockTotalDisponible = $stockAlmacenes + $respuestaStock["stock_disponible"];
		
		
		/* VALIDAR QUE LA CANTIDAD A ELIMINAR SEA MENOR AL STOCK DISPONIBLE
		-------------------------------------------------- */
		
		// if ($respuestaStock["stock_disponible"] >= $this -> LoteEliminarCantidad) {
		if ($stockTotalDisponible >= $this -> LoteEliminarCantidad) {


			/* MOSTRAR SI HAY MAS DE UN LOTE CON COSTO DE 0
			-------------------------------------------------- */
			
			if ($costoAnterior == 0) {

				/* REVISAR SI HAY MAS DE UN LOTE CON COSTO ANTERIOR DE 0
				SI ES EL SEGUNDO LOTE TOMAR EL COSTO DEL PRIMERO Y SI SON MAS
				NO PERMITIR ELIMINAR EL LOTE
				-------------------------------------------------- */

				$tablaLotes = "productos_lote";
				$item = "sku";
	
				$respuestaLotes = ModeloProductos::mdlMostrarLotesProducto($tablaLotes, $item, $sku);

				if (sizeof($respuestaLotes) == 2 ) {
					$costoAnterior = $respuestaLotes[1]["costo"];
				}else if(sizeof($respuestaLotes) == 1){
					$costoAnterior = 0;
				}else{
					$costoAnterior = -1;
				}
			}

			if($costoAnterior !== -1){

			
				$stockGeneralRestante =  $respuestaStock["stock"]- $this -> LoteEliminarCantidad;
		
				$stockDispRestante = $respuestaStock["stock_disponible"] - $this -> LoteEliminarCantidad;
		
				
				
				if ($stockDispRestante > 0 ) {

					/* MODIFICACION DE STOCK GENERAL Y DISPONIBLE DEL PRODUCTO CEDIS
					-------------------------------------------------- */

		
					$tablaProducto = "productos";
					$datosProducto =  ["sku" => $this -> LoteEliminarSku,
										"stock" => $stockGeneralRestante,
										"stock_disponible" => $stockDispRestante];
		
					$respuestaProducto = ModeloProductos::mdlEditarLoteStockGeneral($tablaProducto, $datosProducto);

					/* EDITAR COSTO EN LISTA DE PRECIOS
					-------------------------------------------------- */
					$tablaListado = "productos_listado_precios";
					$datosListado = ["costo" => $costoAnterior,
									"modelo" => $modelo,
									"empresa" => $_SESSION["idEmpresa_dashboard"]];
		
					$editarCostoListaPrecios = ModeloProductos::mdlEditarCostoListadoPrecios($tablaListado,$datosListado);


					$array = ["stockAlmacen" => $stockAlmacenes, 
								"stockCedis" => $respuestaStock["stock_disponible"], 
								"stockAntesDeModificar" => $stockTotalDisponible,
								"stockDispResCedis" => $stockDispRestante, 
								"stockGeneralRestante" => $stockGeneralRestante,
								"costoAnt" => $costoAnterior];

					$respuestaFin = $array;


					/* MOSTRAR VENTAS HECHAS DESPUES DE AGREGAR EL LOTE
					-------------------------------------------------- */
					$datosConsulta = ["sku" => $sku,
										"fecha" => $fecha];
					
					$respuestaVentas = ModeloProductos::mdlMostrarVentasPorFechaSkuDeLote($datosConsulta);
		
					if ($respuestaVentas !== false ) {
		
						/* EDITAR COSTO Y UTILIDAD DE LAS VENTAS
						-------------------------------------------------- */
						
						$tablaDetalleVenta = "cedis_venta_detalles";
						
						foreach ($respuestaVentas as $key => $value) {
							
							$costoTotal = $value["cantidad"] * $costoAnterior;
		
							$newUtilidad = $value["monto"] - $costoTotal;
		
							$datos = ["costo" => $costoAnterior, 
										"utilidad" => round($newUtilidad,6),
										"id_cedis_ventas_detalles" => $value["id_cedis_ventas_detalles"]];
		
							$edicionCostUtil = ModeloProductos::mdlEditarCostoUtilidadDetalleVenta($tablaDetalleVenta,$datos);
							
						}
		
						
					}

					/* MOSTRAR VENTAS ALMACEN HECHAS DESPUES DE AGREGAR EL LOTE 
					-------------------------------------------------- */
					$datosConsulta = ["sku" => $sku,
										"fecha" => $fecha];
					
					$respuestaVentasAlmacen = ModeloVentas::mdlMostrarVentasPorSKUAlmacen($datosConsulta);
		
					if ($respuestaVentasAlmacen !== false ) {
		
						/* EDITAR COSTO Y UTILIDAD DE LAS VENTAS
						-------------------------------------------------- */
						
						$detalleVenta = "ventas_detalle";
						
						foreach ($respuestaVentasAlmacen as $key => $value) {
							
							$costoTotal = $value["cantidad"] * $costoAnterior;
		
							$newUtilidad = $value["monto"] - $costoTotal;
		
							$datos = ["costo" => $costoAnterior, 
										"utilidad" => round($newUtilidad,6),
										"id_detalle" => $value["id_detalle"]];
		
							$costUtilAlmacen = ModeloVentas::mdlEditarCostoUtilidadDetalleVenta($detalleVenta,$datos);
							
						}
		
						
					}

					

					/* ELIMINAR LOTE
					-------------------------------------------------- */
		
					$tabla = "productos_lote";
					$item = "id_lote";
					$valor = $this -> LoteEliminarId;
		
					$respuestaLote = ModeloProductos::mdlEliminarLote($tabla, $item, $valor);
		
				
					/* CONSULTAR LOTES PARA ACTUALIZAR TABLE DE LOTES 
					-------------------------------------------------- */
		
					$itemRetorno = "sku";
		
					$respuestaFin = ModeloProductos::mdlMostrarLotesProducto($tabla, $itemRetorno, $sku);
					
				}else{
					/* SI EL STOCK DISPONIBLE RESTANTE ES UN NUMERO NEGATIVO, INDICA QUE EL STOCK DE CEDIS 
					   NO ES SUFICIENTE ASI QUE PUEDE MOVER STOCK DE SUS ALMACENES
					-------------------------------------------------- */

					$respuestaFin = "stock almacenes";
				}
		
			}else{
				$respuestaFin = "problema utilidad";
			}


		}else{
			$respuestaFin = "fallo";
		}
	
		echo json_encode($respuestaFin);

	}
	
	/*=====  End of ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL  ======*/

/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
//****************** FUNCIONES DE LISTADO PRECIOS DEL PRODUCTO ******************************
	
	/*=============================================================
	=            MOSTRAR LISTA DE PRECIOS DEL PRODUCTO            =
	=============================================================*/
	
	PUBLIC $ProductoCodigoListado;
	public function ajaxMostrarListadoPreciosProductos(){

		$tabla = "productos_listado_precios";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"modelo" => $this -> ProductoCodigoListado);

		$respuesta = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR LISTA DE PRECIOS DEL PRODUCTO  ======*/

	/*=======================================================================
	=            VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO            =
	=======================================================================*/

	public $changeListadoCantidad;
	public $changeListadoModelo;

	public function ajaxChangeListado(){

		$tabla = "productos_listado_precios";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"modelo" => $this -> changeListadoModelo,
						"cantidad" => $this -> changeListadoCantidad);

		$respuesta = ModeloProductos::mdlChangeListado($tabla, $datos);

		if($respuesta == false){

			$cambio = "";

		} else {

			$cambio = "existe";

		}

		echo json_encode($cambio);
	}
	
	/*=====  End of VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO  ======*/

	/*================================================================
	=            CREAR NUEVO PRECIO AL LISTADO DE PRECIOS            =
	================================================================*/
	
	public $listadoCrearModelo;
	public $listadoCrearPiezas;
	public $listadoCrearCosto;

	public function ajaxCrearPrecioListado(){
		$tabla = "productos_listado_precios";
		/* MOSTRAR COSTO PRODUCTO */

		$datos = ["id_empresa" => $_SESSION["idEmpresa_dashboard"], "modelo" => $this -> listadoCrearModelo];
		$respuestaListado = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);

		$costo = $respuestaListado[0]["costo"];

		/* CREAR LISTADO */
		
		$activacion = "no";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"modelo" => $this -> listadoCrearModelo,
						"cantidad" => $this -> listadoCrearPiezas,
						"costo" => $costo,
						"precio" => $this -> listadoCrearCosto,
						"promo" => $this -> listadoCrearCosto,
						"activadoPromo" => $activacion);

		$respuestaCrear = ModeloProductos::mdlCrearListadoPrecios($tabla, $datos);

		/*===============================================
		=                   ALMACENES                   =
		===============================================*/
		$tabla = "almacenes";
		$item = NULL;
		$valor = NULL;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$almacenes = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);

		if ($almacenes != false) {
			
			foreach ($almacenes as $key => $value) {
				if ($key == 0) {
				
					/* VER EXISTENCIA DE PRODUCTO EN ALMACEN */
					$tabla = "almacenes_productos";
					$datos = array("id_producto" => NULL,
									"codigo" => $this -> listadoCrearModelo,
									"id_almacen" => $value["id_almacen"]);

					$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

					if ($productoAlmacen != false) {
						
						/* CREAR LISTADO A PRODUCTO ALMACEN */
						$tabla = "almacenes_productos_listado_precios";
						$datos = array("id_almacen" => $value["id_almacen"],
										"codigo" => $this -> listadoCrearModelo,
										"cantidad" => $this -> listadoCrearPiezas,
										"costo" => $costo,
										"precio" => $this -> listadoCrearCosto,
										"promo" => $this -> listadoCrearCosto,
										"activadoPromo" => $activacion);

						$respuestaCrearAlmacen = ModeloProductosAlmacen::mdlCrearListadoPrecios($tabla, $datos);

					}

				}

			}

		}

		/* MOSTRAR LISTA DE PRECIOS */
		$tabla = "productos_listado_precios";
		$datosMostrar = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"modelo" => $this -> listadoCrearModelo);

		$respuesta = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datosMostrar);

		echo json_encode($respuesta); 
		
	}	
	
	/*=====  End of CREAR NUEVO PRECIO AL LISTADO DE PRECIOS  ======*/

	/*===================================================
	=            EDITAR LISTADO DEL PRODUCTO            =
	===================================================*/
	
	public $ListadoEditarId;
	public $ListadoEditarCantidad;
	public $ListadoEditarPrecio;
	public $ListadoEditarPrecioPromo;
	public $ListadoEditarPromoActivado;

	public function ajaxEditarListado(){

		$tabla = "productos_listado_precios";
		$datos = array("cantidad" => $this -> ListadoEditarCantidad,
						"precio" => $this -> ListadoEditarPrecio,
						"promo" => $this -> ListadoEditarPrecioPromo,
						"activadoPromo" => $this -> ListadoEditarPromoActivado,
						"id_listado" => $this -> ListadoEditarId);

		$respuesta = ModeloProductos::mdlEditarListadoPrecios($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of EDITAR LISTADO DEL PRODUCTO  ======*/

	/*==================================================
	=            ELIMINAR PRECIO DE LISTADO            =
	==================================================*/

	public $ListadoEliminarId;
	public $ListadoEliminarModelo;
	public $ListadoEliminarCantidad;

	public function ajaxEliminarListado(){

		/* ELIMINAR PRECIO DEL LISTADO */
		$tabla = "productos_listado_precios";
		$itemEliminar = "id_listado";
		$valorEliminar = $this -> ListadoEliminarId;

		$respuestaE = ModeloProductos::mdlEliminarListadoProducto($tabla, $itemEliminar, $valorEliminar);

		/* ELIMINAR PRECIO DEL LISTADO DE ALMACEN */

		$tabla = "almacenes_productos_listado_precios";
		$item = "codigo";
		$valor = $this -> ListadoEliminarModelo;
		$cantidad = $this -> ListadoEliminarCantidad;

		$resEliminarlistAlmacen = ModeloProductosAlmacen::mdlEliminarListadoProducto($tabla, $item, $valor, $cantidad);

		/* MOSTRAR LISTADO DE PRECIOS */
		
		$datosMostrar = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"modelo" => $this -> ListadoEliminarModelo);

		$respuesta = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datosMostrar);

		echo json_encode($respuesta);

	}
	
	/*=====  End of ELIMINAR PRECIO DE LISTADO  ======*/

/* ****************************************************************************** */
/* ****************************************************************************** */
/* ****************************************************************************** */
// ***************** FUNCIONES PARA RPODUCTO DERIVADO ******************************
	
	/*===============================================
	=            CREAR PRODUCTO DERIVADO            =
	===============================================*/
	
	public $DproductoCrearModelo;
	public $DproductoCrearEmpresa;
	public $DproductoCrearAleatorio;
	public $DproductoCrearNombre;
	public $DproductoCrearDescripcion;
	public $DproductoCrearStock;
	public $DproductoCrearCosto;
	public $DproductoCrearCaracteristicas;
	public $DproductoCrearMedidas;
	public $DproductoCrearPeso;
	public $DproductoCrearFactura;
	public $DproductoCrearProveedor;
	public $DproductoCrearClaveProdServ;
	public $DproductoCrearClaveUnidad;

	public function ajaxCrearProductoDerivado(){
		/*================================
		=            PRODUCTO            =
		================================*/
		
		$tabla = "productos";
		/* SKU */
		$sku = $this -> DproductoCrearEmpresa;
		$sku .= "-";
		$sku .= $this -> DproductoCrearModelo;
		$sku .= "-D";
		$sku .= $this -> DproductoCrearAleatorio;

		$datos = array("id_empresa" => $this -> DproductoCrearEmpresa,
						 "codigo" => $this -> DproductoCrearModelo, 
						 "sku" => $sku,
						 "nombre" => $this -> DproductoCrearNombre, 
						 "descripcion" => $this -> DproductoCrearDescripcion,
						 "stock" => $this -> DproductoCrearStock,
						 "caracteristicas" => $this -> DproductoCrearCaracteristicas,
						 "medidas" => $this -> DproductoCrearMedidas,
						 "peso" => $this -> DproductoCrearPeso,
						 "sat_clave_prod_serv" => $this -> DproductoCrearClaveProdServ,
						 "sat_clave_unidad" => $this -> DproductoCrearClaveUnidad);


		$respuestaProducto = ModeloProductos::mdlCrearProducto($tabla,$datos);
		
		/*=====  End of PRODUCTO  ======*/
		
		/*============================
		=            LOTE            =
		============================*/
		
		$tablaLote = "productos_lote";
		$datosLote = array("sku" => $sku ,
							"cantidad" => $this -> DproductoCrearStock,
							"costo" => $this -> DproductoCrearCosto,
							"factura" => $this -> DproductoCrearFactura,
							"proveedor" => $this -> DproductoCrearProveedor,
							"costo_prom_ant" => 0,
							"stock_ant_disp" => 0,
							"no_lote" => 1);

		$respuestaLote = ModeloProductos::mdlCrearLote($tablaLote, $datosLote);
		
		/*=====  End of LOTE  ======*/		

		echo json_encode($respuestaProducto);

	}
	
	/*=====  End of CREAR PRODUCTO DERIVADO  ======*/

/*===================================================================================================================================
=            ------------------------------------------- PRODUCTOS EN ALMACEN ------------------------------------------            =
===================================================================================================================================*/
	
	/*=================================================
	=            MOSTRAR PRODUCTOS ALMACEN            =
	=================================================*/
	
	public $idAlmacenProductos;

	public function ajaxMostrarProductosAlmacen(){

		// $tabla = "productos";
		// $empresa = $_SESSION["idEmpresa_dashboard"];
		// $arregloProductos = array();

		// $productos = ModeloProductos::mdlMostrarProductosDataTable($tabla, $empresa);

		// foreach ($productos as $key => $value) {
			
		// 	$tabla = "almacenes_productos";
		// 	$datos = array("id_producto" => $value["id_producto"],
		// 					"id_almacen" => $this -> idAlmacenProductos);

		// 	$stock = 0;

		// 	$almacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

		// 	if ($almacen != false) {
		// 		$stock = $almacen["stock"];
		// 	}

		// 	array_push($arregloProductos, array("id_producto" => $value["id_producto"],
		// 										"codigo" => $value["codigo"],
		// 										"sku" => $value["sku"],
		// 										"nombre" => $value["nombre"],
		// 										"descripcion" => $value["descripcion"],
		// 										"stock" => $stock));
		// }

		// echo json_encode($arregloProductos);

		//MOSTRAR PRODUCTOS ALMACES
		$tablaPA = "almacenes_productos";
		$datos = ["id_producto" => NULL, "codigo" => NULL, "id_almacen" => $this -> idAlmacenProductos];
		$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tablaPA,$datos);

		//MOSTRAR INFORMACION DEL PRODUCTO
		$arregloProductos = array();
		$tablaP = "productos";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$item = "id_producto";
		foreach ($productoAlmacen as $key => $almacen) {
			$valor = $almacen["id_producto"];
			$producto = ModeloProductos::mdlMostrarProductos($tablaP, $item, $valor,$empresa);

			if ($producto != false) {
				array_push($arregloProductos,array("id_producto" => $producto["id_producto"],
													"codigo" => $almacen["codigo"],
													"sku" => $producto["sku"],
													"nombre" => $producto["nombre"],
													"descripcion" => $producto["descripcion"],
													"stock" => $almacen["stock"]
												));
			}
		}

		echo json_encode($arregloProductos);
		
	}
	
	/*=====  End of MOSTRAR PRODUCTOS ALMACEN  ======*/

	/*==========================================================
	=            CREAR LOTE DEL PRODUCTO EN ALMACEN            =
	==========================================================*/
	
	public $idProductoLoteGuardar;
	public $idAlmacenLoteGuardar;
	public $stockLoteGuardar;
	
	public function ajaxCrearLoteProducto(){

		/* CREAR LOTE DEL PRODUCTO EN ALMACEN */

		$tabla = "almacenes_productos_lotes";
		$datos = array("id_almacen" => $this -> idAlmacenLoteGuardar,
					   "id_producto" => $this -> idProductoLoteGuardar,
					   "cantidad" => $this -> stockLoteGuardar);

		$lote = ModeloProductosAlmacen::mdlCrearLoteProducto($tabla, $datos);

		/* MOSTRAR INFORMACION DEL PRODUCTO */

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idProductoLoteGuardar;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		/* VERIFICAR EXISTENCIA DEL PRODUCTO EN ALMACEN */	
			
		$tabla = "almacenes_productos";
		$datos = array("id_producto" => $this -> idProductoLoteGuardar,
					   "id_almacen" => $this -> idAlmacenLoteGuardar);

		$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

		if ($productoAlmacen == false) {
			
			// CREAR PRODUCTO EN ALMACEN
			$tabla = "almacenes_productos";
			$datos = array("id_almacen" => $this -> idAlmacenLoteGuardar,
							"id_producto" => $this -> idProductoLoteGuardar,
							"codigo" => $producto["codigo"],
							"stock" => $this -> stockLoteGuardar);

			$crearProductoAlmacen = ModeloProductosAlmacen::mdlCrearProductoAlmacen($tabla, $datos);

		} else {

			// EDITAR PRODUCTO EN ALMACEN
			$tabla = "almacenes_productos";
			$datos = array("id_almacen" => $this -> idAlmacenLoteGuardar,
						   "id_producto" => $this -> idProductoLoteGuardar,
						   "stock" => $this -> stockLoteGuardar);

			$crearProductoAlmacen = ModeloProductosAlmacen::mdlEditarProductoAlmacen($tabla, $datos);

		}

		/* MODIFICAR STOCK DE PRODUCTO GENERAL */
		$stock_disponible = floatval($producto["stock_disponible"]) - floatval($this -> stockLoteGuardar);

		$tabla = "productos";
		$datos = array("stock_disponible" => $stock_disponible,
					   "sku" => $producto["sku"]);

		$stockProductoGeneral = ModeloProductos::mdlEditarStockDisponible($tabla, $datos);


		/* MOSTRAR LISTADO DE PRECIOS */
		$tabla = "productos_listado_precios";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"modelo" => $producto["codigo"]);

		$listadoMostrar = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);


		/* VERIFICAR EXISTENCIA DE LISTADO DE PRECIO EN ALMACEN */

		$tabla = "almacenes_productos_listado_precios";
		$datos = array("id_almacen" => $this -> idAlmacenLoteGuardar,
						"codigo" => $producto["codigo"]);

		$listadoAlmacen = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

		if ($listadoAlmacen == false) {
			
			foreach ($listadoMostrar as $key => $value) {
				
				$tabla = "almacenes_productos_listado_precios";
				$datos = array("id_almacen" => $this -> idAlmacenLoteGuardar,
								"codigo" => $producto["codigo"],
								"cantidad" => $value["cantidad"],
								"precio" => $value["precio"],
								"promo" => $value["promo"],
								"activadoPromo" => $value["activadoPromo"]);

				$respuesta = ModeloProductosAlmacen::mdlCrearListadoPrecios($tabla, $datos);

			}
		} else {

			$respuesta = "ok";

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of CREAR LOTE DEL PRODUCTO EN ALMACEN  ======*/

	/*=============================================================================
	=            MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO EN EL ALMACEN            =
	=============================================================================*/
	
	public $idAlmacenListadoAlmacen;
	public $codigoListadoAlmacen;

	public function ajaxMostrarListadoProductoAlmacen(){

		$tabla = "almacenes_productos_listado_precios";
		$datos = array("id_almacen" => $this -> idAlmacenListadoAlmacen,
						"codigo" => $this -> codigoListadoAlmacen);

		$respuesta = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO EN EL ALMACEN  ======*/

	/*===========================================================================
	=            MODIFICAR LISTADO DE PRECIO DEL PRODUCTO EN ALMACEN            =
	===========================================================================*/
	
	public $idEditarListadoAlmacen;
	public $precioEditarListadoAlmacen;
	public $promoEditarListadoAlmacen;
	public $activarEditarListadoAlmacen;

	public function ajaxEditarListadoAlmacen(){

		$tabla = "almacenes_productos_listado_precios";

		$datos = array("id_almacen_productos_listado" => $this -> idEditarListadoAlmacen,
						"precio" => $this -> precioEditarListadoAlmacen,
						"promo" => $this -> promoEditarListadoAlmacen,
						"activadoPromo" => $this -> activarEditarListadoAlmacen);

		$respuesta = ModeloProductosAlmacen::mdlModificarListadoPrecioAlmacen($tabla, $datos);

		echo json_encode($datos);

	}
	
	/*=====  End of MODIFICAR LISTADO DE PRECIO DEL PRODUCTO EN ALMACEN  ======*/
	/*========================================================
	=         Consulta si Eliminar un producto               =
	========================================================*/
	
	public $eliminar; 
	public function ajaxconsultaEliminarProducto(){

		$tabla = "cedis_venta_detalles";
		$item = "id_producto";
		$valor = $this -> eliminar;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlconsultaeliminarprod($tabla, $item, $valor, $empresa);
		
		echo json_encode($respuesta);
	}
	
	/*=====  End of Consulta si Eliminar un producto  ======*/
		/*========================================================
	=         Eliminar un producto               =
	========================================================*/
	
	public $elim; 
	public function ajaxEliminarProducto(){
		
		$idp = $this -> elim;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdleliminarprod( $idp,$empresa);
		
		echo json_encode($respuesta);
	}
	
	/*=====  End of Eliminar un producto  ======*/
	/*========================================================
	=               Enviar producto a papelera               =
	========================================================*/
	
	public $papelera; 
	public function ajaxProductoaPapelera(){
		
		$idp = $this -> papelera;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlproductoapapelera( $idp,$empresa);
		
		echo json_encode($respuesta);
	}
	
	/*=====  End of Enviar producto a papelera  ======*/
	/*========================================================
	=               Enviar producto a papelera               =
	========================================================*/
	
	public $reciclar; 
	public function ajaxProductoaReciclar(){
		
		$idp = $this -> reciclar;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlproductoreciclar( $idp,$empresa);
		
		echo json_encode($respuesta);
	}
	
	/*=====  End of Enviar producto a papelera  ======*/

	
}

/*=======================================================
=            MOSTRAR PRODUCTOS EN DATA TABLE            =
=======================================================*/

if (isset($_POST["opcion"])) {
	$mostrarInicio = new AjaxProductos();
	$mostrarInicio -> ajaxMostrarInicioProductos();
}

/*=====  End of MOSTRAR PRODUCTOS EN DATA TABLE  ======*/
/*=======================================================
=            MOSTRAR PRODUCTOS EN DATA TABLE            =
=======================================================*/

if (isset($_POST["opcion2"])) {
	$mostrarInicio = new AjaxProductos();
	$mostrarInicio -> ajaxMostrarInicioProductosPapelera();
}

/*=====  End of MOSTRAR PRODUCTOS EN DATA TABLE  ======*/

/*======================================================
=            VERIFICAR EXISTENCIA DE MODELO            =
======================================================*/

if (isset($_POST["existenciaModeloProducto"])) {
	$verificarExistencia = new AjaxProductos();
	$verificarExistencia -> existenciaModeloProducto = $_POST["existenciaModeloProducto"];
	$verificarExistencia -> ajaxVerificarExisteciaModelo();
}

/*=====  End of VERIFICAR EXISTENCIA DE MODELO  ======*/

/*============================================
=            CREAR PRODUCTO NUEVO            =
============================================*/

if (isset($_POST["productoCrearModelo"])) {
	$crearProducto = new AjaxProductos();
	$crearProducto -> productoCrearModelo = $_POST["productoCrearModelo"];
	$crearProducto -> productoCrearAleatorio = $_POST["productoCrearAleatorio"];
	$crearProducto -> productoCrearNombre = $_POST["productoCrearNombre"];
	$crearProducto -> productoCrearDescripcion = $_POST["productoCrearDescripcion"];
	$crearProducto -> productoCrearStock = $_POST["productoCrearStock"];
	$crearProducto -> productoCrearCosto = $_POST["productoCrearCosto"];
	$crearProducto -> productoCrearPrecioSugerido = $_POST["productoCrearPrecioSugerido"];
	$crearProducto -> productoCrearPrecio = $_POST["productoCrearPrecio"];
	$crearProducto -> productoCrearCaracteristicas = $_POST["productoCrearCaracteristicas"];
	$crearProducto -> productoCrearMedidas = $_POST["productoCrearMedidas"];
	$crearProducto -> productoCrearPeso = $_POST["productoCrearPeso"];
	$crearProducto -> productoCrearFactura = $_POST["productoCrearFactura"];
	$crearProducto -> productoCrearProveedor = $_POST["productoCrearProveedor"];
	$crearProducto -> productoCrearClaveProdServ = $_POST["productoCrearClaveProdServ"];
	$crearProducto -> productoCrearClaveUnidad = $_POST["productoCrearClaveUnidad"];
	$crearProducto -> ajaxCrearProducto();
}

/*=====  End of CREAR PRODUCTO NUEVO  ======*/

/*========================================================
=            MOSTRAR INFORMACION DEL PRODUCTO            =
========================================================*/

if (isset($_POST["idInfo"])) {
	$info = new AjaxProductos();
	$info -> infoMostrar = $_POST["idInfo"]; 
	$info -> ajaxMostrarInfoProducto();
}

/*=====  End of MOSTRAR INFORMACION DEL PRODUCTO  ======*/

/*========================================================================
=            MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO            =
========================================================================*/

if (isset($_POST["idInfoCaracteristicas"])) {
	$info = new AjaxProductos();
	$info -> idInfoCaracteristicas = $_POST["idInfoCaracteristicas"]; 
	$info -> ajaxMostrarCaracteristicasProducto();
}

/*=====  End of MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO  ======*/

/*==========================================================
=            MOSTRAR INFORMACION DATOS DE ENVIO            =
==========================================================*/

if (isset($_POST["idInfoDatosEnvio"])) {
	$info = new AjaxProductos();
	$info -> idInfoDatosEnvio = $_POST["idInfoDatosEnvio"]; 
	$info -> ajaxMostrarEnvio();
}

/*=====  End of MOSTRAR INFORMACION DATOS DE ENVIO  ======*/

/*=======================================================
=            EDITAR INFORMACION DEL PRODUCTO            =
=======================================================*/

if (isset($_POST["ProductoEditarIdInfo"])) {
	$editarInfoProducto = new AjaxProductos();
	$editarInfoProducto -> ProductoEditarIdInfo = $_POST["ProductoEditarIdInfo"];
	$editarInfoProducto -> ProductoEditarNombreInfo = $_POST["ProductoEditarNombreInfo"];
	$editarInfoProducto -> ProductoEditarDescripcionInfo = $_POST["ProductoEditarDescripcionInfo"];
	$editarInfoProducto -> ProductoEditarCaracteristicasInfo = $_POST["ProductoEditarCaracteristicasInfo"];
	$editarInfoProducto -> ProductoEditarMedidasInfo = $_POST["ProductoEditarMedidasInfo"];
	$editarInfoProducto -> ProductoEditarPesoInfo = $_POST["ProductoEditarPesoInfo"];
	$editarInfoProducto -> ProductoEditarClaveProdServInfo =$_POST["ProductoEditarClaveProdServInfo"];
	$editarInfoProducto -> ProductoEditarClaveUnidadInfo =$_POST["ProductoEditarClaveUnidadInfo"];
	$editarInfoProducto -> ajaxEditarInfoProducto();
}

/*=====  End of EDITAR INFORMACION DEL PRODUCTO  ======*/

/* **************************************************************************************** */
/* **************************************************************************************** */
/* **************************************************************************************** */
//************************ FUNCIONES DE LOTES DE PRODUCTO ************************************

/*========================================================
=            MOSTRAR LOTES DEL PRODUCTO (SKU)            =
========================================================*/

if (isset($_POST["skuLotes"])) {
	$lotesSku = new AjaxProductos();
	$lotesSku -> lotesMostrar = $_POST["skuLotes"];
	$lotesSku -> ajaxMostrarLotesProductos();
}

/*=====  End of MOSTRAR LOTES DEL PRODUCTO (SKU)  ======*/

/*====================================================================================
=            CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO            =
====================================================================================*/

if (isset($_POST["loteCrearSku"])) {
	$crearLote = new AjaxProductos();
	$crearLote -> loteCrearSku = $_POST["loteCrearSku"];
	$crearLote -> loteCrearCodigo = $_POST["loteCrearCodigo"];
	$crearLote -> loteCrearPiezas = $_POST["loteCrearPiezas"];
	$crearLote -> loteCrearCosto = $_POST["loteCrearCosto"];
	$crearLote -> LoteCrearPrecioSugerido = $_POST["LoteCrearPrecioSugerido"];
	$crearLote -> loteCrearProveedor = $_POST["loteCrearProveedor"];
	$crearLote -> loteCrearFolio = $_POST["loteCrearFolio"];
	$crearLote -> ajaxCrearLote();
}

/*=====  End of CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO  ======*/

/*===================================================================
=            MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL            =
===================================================================*/

if (isset($_POST["LoteEditarId"])) {
	$editarLote = new AjaxProductos();
	$editarLote -> LoteEditarId = $_POST["LoteEditarId"];
	$editarLote -> LoteEditarSkuGeneral = $_POST["LoteEditarSkuGeneral"];
	$editarLote -> LoteEditarCantidadInput = $_POST["LoteEditarCantidadInput"];
	$editarLote -> LoteEditarFecha = $_POST["LoteEditarFecha"];
	$editarLote -> LoteEditarModelo = $_POST["LoteEditarModelo"];
	$editarLote -> LoteEditarCostoInput = $_POST["LoteEditarCostoInput"];

	/// OLD VARIABLES
	// $editarLote -> LoteEditarId = $_POST["LoteEditarId"];
	// $editarLote -> LoteEditarSkuGeneral = $_POST["LoteEditarSkuGeneral"];
	// $editarLote -> LoteEditarCantidad = $_POST["LoteEditarCantidad"];
	// $editarLote -> LoteEditarCantidadGeneral = $_POST["LoteEditarCantidadGeneral"];
	// $editarLote -> LoteEditarCantidadDisponible = $_POST["LoteEditarCantidadDisponible"];

	$editarLote -> ajaxEditarLote();
}

/*=====  End of MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL  ======*/


/*================================================================
=            ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL            =
================================================================*/

if (isset($_POST["LoteEliminarId"])) {
	$eliminarLote = new AjaxProductos();
	$eliminarLote -> LoteEliminarId = $_POST["LoteEliminarId"];
	$eliminarLote -> LoteEliminarSku = $_POST["LoteEliminarSku"];
	$eliminarLote -> LoteEliminarCantidad = $_POST["LoteEliminarCantidad"];
	$eliminarLote -> LoteEliminarFecha = $_POST["LoteEliminarFecha"];
	$eliminarLote -> LoteEliminarCostoAnterior = $_POST["LoteEliminarCostoAnterior"];
	$eliminarLote -> LoteEliminarModelo = $_POST["LoteEliminarModelo"];
	$eliminarLote -> ajaxEliminarLote();
}

/*=====  End of ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL  ======*/


/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
//****************** FUNCIONES DE LISTADO PRECIOS DEL PRODUCTO ******************************

/*=============================================================
=            MOSTRAR LISTA DE PRECIOS DEL PRODUCTO            =
=============================================================*/

if (isset($_POST["ProductoCodigoListado"])) {
	$listadoMostrar = new AjaxProductos();
	$listadoMostrar -> ProductoCodigoListado = $_POST["ProductoCodigoListado"];
	$listadoMostrar -> ajaxMostrarListadoPreciosProductos();
}

/*=====  End of MOSTRAR LISTA DE PRECIOS DEL PRODUCTO  ======*/

/*=======================================================================
=            VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO            =
=======================================================================*/

if (isset($_POST["changeListadoCantidad"])) {
	$changeListado = new AjaxProductos();
	$changeListado -> changeListadoCantidad = $_POST["changeListadoCantidad"];
	$changeListado -> changeListadoModelo = $_POST["changeListadoModelo"];
	$changeListado -> ajaxChangeListado();
}

/*=====  End of VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO  ======*/

/*================================================================
=            CREAR NUEVO PRECIO AL LISTADO DE PRECIOS            =
================================================================*/

if (isset(($_POST["listadoCrearModelo"]))) {
	$crearListado = new AjaxProductos();
	$crearListado -> listadoCrearModelo = $_POST["listadoCrearModelo"];
	$crearListado -> listadoCrearPiezas = $_POST["listadoCrearPiezas"];
	$crearListado -> listadoCrearCosto = $_POST["listadoCrearCosto"];
	$crearListado -> ajaxCrearPrecioListado();
}

/*=====  End of CREAR NUEVO PRECIO AL LISTADO DE PRECIOS  ======*/

/*===================================================
=            EDITAR LISTADO DEL PRODUCTO            =
===================================================*/

if (isset($_POST["ListadoEditarId"])) {
	$listadoEditar = new AjaxProductos();
	$listadoEditar -> ListadoEditarId = $_POST["ListadoEditarId"];
	$listadoEditar -> ListadoEditarCantidad = $_POST["ListadoEditarCantidad"];
	$listadoEditar -> ListadoEditarPrecio = $_POST["ListadoEditarPrecio"];
	$listadoEditar -> ListadoEditarPrecioPromo = $_POST["ListadoEditarPrecioPromo"];
	$listadoEditar -> ListadoEditarPromoActivado = $_POST["ListadoEditarPromoActivado"];
	$listadoEditar -> ajaxEditarListado();
}

/*=====  End of EDITAR LISTADO DEL PRODUCTO  ======*/

/*==================================================
=            ELIMINAR PRECIO DE LISTADO            =
==================================================*/

if (isset($_POST["ListadoEliminarId"])) {
	$listadoEliminar = new AjaxProductos();
	$listadoEliminar -> ListadoEliminarId = $_POST["ListadoEliminarId"];
	$listadoEliminar -> ListadoEliminarModelo = $_POST["ListadoEliminarModelo"];
	$listadoEliminar -> ListadoEliminarCantidad = $_POST["ListadoEliminarCantidad"];
	$listadoEliminar -> ajaxEliminarListado();
}

/*=====  End of ELIMINAR PRECIO DE LISTADO  ======*/

/* ****************************************************************************** */
/* ****************************************************************************** */
/* ****************************************************************************** */
//****************** FUNCIONES PARA RPODUCTO DERIVADO ******************************

/*===============================================
=            CREAR PRODUCTO DERIVADO            =
===============================================*/

if (isset($_POST["DproductoCrearModelo"])) {
	$DcrearProducto = new AjaxProductos();
	$DcrearProducto -> DproductoCrearModelo = $_POST["DproductoCrearModelo"];
	$DcrearProducto -> DproductoCrearEmpresa = $_POST["DproductoCrearEmpresa"];
	$DcrearProducto -> DproductoCrearAleatorio = $_POST["DproductoCrearAleatorio"];
	$DcrearProducto -> DproductoCrearNombre = $_POST["DproductoCrearNombre"];
	$DcrearProducto -> DproductoCrearDescripcion = $_POST["DproductoCrearDescripcion"];
	$DcrearProducto -> DproductoCrearStock = $_POST["DproductoCrearStock"];
	$DcrearProducto -> DproductoCrearCosto = $_POST["DproductoCrearCosto"];
	$DcrearProducto -> DproductoCrearCaracteristicas = $_POST["DproductoCrearCaracteristicas"];
	$DcrearProducto -> DproductoCrearMedidas = $_POST["DproductoCrearMedidas"];
	$DcrearProducto -> DproductoCrearPeso = $_POST["DproductoCrearPeso"];
	$DcrearProducto -> DproductoCrearFactura = $_POST["DproductoCrearFactura"];
	$DcrearProducto -> DproductoCrearProveedor = $_POST["DproductoCrearProveedor"];
	$DcrearProducto -> DproductoCrearClaveProdServ = $_POST["DproductoCrearClaveProdServ"];
	$DcrearProducto -> DproductoCrearClaveUnidad = $_POST["DproductoCrearClaveUnidad"];
	$DcrearProducto -> ajaxCrearProductoDerivado();
}

/*=====  End of CREAR PRODUCTO DERIVADO  ======*/


/*===================================================================================================================================
=            ------------------------------------------- PRODUCTOS EN ALMACEN ------------------------------------------            =
===================================================================================================================================*/

/*==================================================
=            MOSTRAR PRODUCTOS ALMACEN             =
==================================================*/

if (isset($_POST["idAlmacenProductos"])) {
	$mostrarProductosAlmacen = new AjaxProductos();
	$mostrarProductosAlmacen -> idAlmacenProductos = $_POST["idAlmacenProductos"];
	$mostrarProductosAlmacen -> ajaxMostrarProductosAlmacen();
}

// =====  End of MOSTRAR PRODUCTOS ALMACEN   ======

/*==========================================================
=            CREAR LOTE DEL PRODUCTO EN ALMACEN            =
==========================================================*/

if (isset($_POST["idProductoLoteGuardar"])) {
	$crearLoteProducto = new AjaxProductos();
	$crearLoteProducto -> idProductoLoteGuardar = $_POST["idProductoLoteGuardar"];
	$crearLoteProducto -> idAlmacenLoteGuardar = $_POST["idAlmacenLoteGuardar"];
	$crearLoteProducto -> stockLoteGuardar = $_POST["stockLoteGuardar"];
	$crearLoteProducto -> ajaxCrearLoteProducto();

}

// /*=====  End of CREAR LOTE DEL PRODUCTO EN ALMACEN  ======*/

/*=============================================================================
=            MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO EN EL ALMACEN            =
=============================================================================*/

if (isset($_POST["idAlmacenListadoAlmacen"])) {
	$mostrarListado = new AjaxProductos();
	$mostrarListado -> idAlmacenListadoAlmacen = $_POST["idAlmacenListadoAlmacen"];
	$mostrarListado -> codigoListadoAlmacen = $_POST["codigoListadoAlmacen"];
	$mostrarListado -> ajaxMostrarListadoProductoAlmacen();
}

/*=====  End of MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO EN EL ALMACEN  ======*/

/*===========================================================================
=            MODIFICAR LISTADO DE PRECIO DEL PRODUCTO EN ALMACEN            =
===========================================================================*/

if (isset($_POST["idEditarListadoAlmacen"])) {
	$editarListadoAlmacen = new AjaxProductos();
	$editarListadoAlmacen -> idEditarListadoAlmacen = $_POST["idEditarListadoAlmacen"];
	$editarListadoAlmacen -> precioEditarListadoAlmacen = $_POST["precioEditarListadoAlmacen"];
	$editarListadoAlmacen -> promoEditarListadoAlmacen = $_POST["promoEditarListadoAlmacen"];
	$editarListadoAlmacen -> activarEditarListadoAlmacen = $_POST["activarEditarListadoAlmacen"];
	$editarListadoAlmacen -> ajaxEditarListadoAlmacen();
}

/*=====  End of MODIFICAR LISTADO DE PRECIO DEL PRODUCTO EN ALMACEN  ======*/
/*========================================================
=            Consulta para Eliminar un producto                        =
========================================================*/

if (isset($_POST["iddel"])) {
	$info = new AjaxProductos();
	$info -> eliminar = $_POST["iddel"]; 
	$info -> ajaxconsultaEliminarProducto();
}

/*=====  End of Consulta para Eliminar un producto  ======*/
/*========================================================
=            Eliminar un producto                        =
========================================================*/

if (isset($_POST["iddelate"])) {
	$info2 = new AjaxProductos();
	$info2 -> elim = $_POST["iddelate"]; 
	$info2 -> ajaxEliminarProducto();
}

/*=====  End of Eliminar un producto  ======*/
/*========================================================
=            Producto a papelera                        =
========================================================*/

if (isset($_POST["idpapelera"])) {
	$info3 = new AjaxProductos();
	$info3 -> papelera = $_POST["idpapelera"]; 
	$info3 -> ajaxProductoaPapelera();
}

/*=====  End of Producto a papelera   ======*/
/*========================================================
=            Producto a papelera                        =
========================================================*/

if (isset($_POST["idreciclar"])) {
	$info3 = new AjaxProductos();
	$info3 -> reciclar = $_POST["idreciclar"]; 
	$info3 -> ajaxProductoaReciclar();
}

/*=====  End of Producto a papelera   ======*/

?>