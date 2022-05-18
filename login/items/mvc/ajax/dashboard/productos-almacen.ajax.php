<?php
session_start();

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.productos-almacen.php';

class AjaxProductosAlmacen{

	/*====================================================
	=            MOSTRAR PRODUCTOS DE ALMACEN            =
	====================================================*/
	
	public function ajaxMostrarProductosAlmacen(){

		//MOSTRAR PRODUCTOS ALMACES
		$tablaPA = "almacenes_productos";
		$datos = ["id_producto" => NULL, "codigo" => NULL, "id_almacen" => $_SESSION["almacen_dashboard"]];
		$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tablaPA,$datos);

		//MOSTRAR INFORMACION DEL PRODUCTO
		$arregloProductos = array();
		$tablaP = "productos";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$item = "id_producto";
		foreach ($productoAlmacen as $key => $value) {
			$valor = $value["id_producto"];
			$productos = ModeloProductos::mdlMostrarProductos($tablaP, $item, $valor,$empresa);

			if ($productos != false) {
				array_push($arregloProductos,array("id_producto" => $productos["id_producto"],
													"codigo" => $value["codigo"],
													"sku" => $productos["sku"],
													"nombre" => $productos["nombre"],
													"descripcion" => $productos["descripcion"],
													"stock" => $value["stock"]
												));
			}
		}

		echo json_encode($arregloProductos);

	}
	
	/*=====  End of MOSTRAR PRODUCTOS DE ALMACEN  ======*/
	
	/*========================================================
	=            MOSTRAR INFORMACION DEL PRODUCTO            =
	========================================================*/
	
	public $idInfoProducto; 
	public function ajaxMostrarInformacionProducto(){

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idInfoProducto;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR INFORMACION DEL PRODUCTO  ======*/
	
	/*========================================================================
	=            MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO            =
	========================================================================*/
	
	public $idInfoProductoCaracteristicas;
	
	public function ajaxMostrarCaracteristicasProducto(){

		$tabla = "productos";
		$item = "id_producto";
		$valor = $this -> idInfoProductoCaracteristicas;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		echo $producto["caracteristicas"];

	}
	
	/*=====  End of MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO  ======*/

/* **************************************************************************************** */
/* **************************************************************************************** */
/* **************************************************************************************** */
//************************ FUNCIONES DE LOTES DE PRODUCTO ************************************

	/*==================================================
	=            MOSTRAR LOTES DEL PRODUCTO            =
	==================================================*/
	
	public $lotesidProductoAlmacen;
	
	public function ajaxMostrarLotesProductos(){

		$tabla = "almacenes_productos_lotes";
		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"id_producto" => $this -> lotesidProductoAlmacen);

		$respuesta = ModeloProductosAlmacen::mdlMostrarLotesProducto($tabla, $datos);

		echo json_encode($respuesta); 
	}
	
	/*=====  End of MOSTRAR LOTES DEL PRODUCTO  ======*/

	/*====================================================================================
	=            CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO            =
	====================================================================================*/
	public $loteCrearIdProducto;
	public $loteCrearPiezas;
	public $loteCrearCosto;
	public $loteCrearProveedor;
	public $loteCrearFactura;
	
	public function ajaxCrearLote(){

		/* CREAR LOTE */
		$tabla = "almacenes_productos_lotes";

		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"id_producto" => $this -> loteCrearIdProducto ,
						"cantidad" => $this -> loteCrearPiezas,
						"costo" => $this -> loteCrearCosto,
						"factura" => $this -> loteCrearFactura,
						"proveedor" => $this -> loteCrearProveedor);

		$respuestaCrearLote = ModeloProductosAlmacen::mdlCrearLoteProducto($tabla, $datos);

		/* VERIFICAR SI EXISTE EL PRODUCTO EN EL ALMACEN */
		$tablaProductosAlmacen = "almacenes_productos";
		$datosProductosAlmacen = array("id_almacen" => $_SESSION["almacen_dashboard"],
										"id_producto" => $this -> loteCrearIdProducto);

		$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tablaProductosAlmacen, $datosProductosAlmacen);

		if ($productoAlmacen != false) {
			
			/* ACTUALIZAR STOCK GENERAL DEL PRODUCTO EN EL ALMACEN */
			$datosProductos =  array("id_almacen" => $_SESSION["almacen_dashboard"],
										"id_producto" => $this -> loteCrearIdProducto,
										"stock" => $this -> loteCrearPiezas);

			$actualizacionProductoAlmacen = ModeloProductosAlmacen::mdlEditarProductoAlmacen($tablaProductosAlmacen, $datosProductos);

		} else {

			/* EXTRAER INFORMACION DEL PRODUCTO */
			$tablaProducto = "productos";
			$item = "id_producto";
			$valor = $this -> loteCrearIdProducto;
			$empresa = $_SESSION["idEmpresa_dashboard"];
			
			$producto = ModeloProductos::mdlMostrarProductos($tablaProducto, $item, $valor, $empresa);

			/*CREAR NUEVO PRODUCTO EN ALMACEN*/

			$datosProductos =  array("id_almacen" => $_SESSION["almacen_dashboard"],
									"id_producto" => $this -> loteCrearIdProducto,
									"codigo" => $producto["codigo"],
									"stock" => $this -> loteCrearPiezas);

			$actualizacionProductoAlmacen = ModeloProductosAlmacen::mdlCrearProductoAlmacen($tablaProductosAlmacen, $datosProductos);

		}



		/* ACTUALIZAR TABLE DE LOTES */
		$tablaLotes = "almacenes_productos_lotes";
		$datosLotes = array("id_almacen" => $_SESSION["almacen_dashboard"],
							"id_producto" => $this -> loteCrearIdProducto);

		$respuesta = ModeloProductosAlmacen::mdlMostrarLotesProducto($tablaLotes, $datosLotes);

		echo json_encode($respuesta);

	}
	/*=====  End of CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO  ======*/

	/*===================================================================
	=            MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL            =
	===================================================================*/
	
	public $LoteEditarId;
	public $LoteEditarIdProducto;
	public $LoteEditarCantidadLote;
	public $LoteEditarCantidadLoteActual;

	public function ajaxEditarLote(){

		$canitdadEscrita = $this -> LoteEditarCantidadLote;
		$cantidadActual = $this -> LoteEditarCantidadLoteActual;


		/* VERIFICAR SI EXISTE EL PRODUCTO EN EL ALMACEN */
		$tablaProducto = "almacenes_productos";
		$datosProducto = array("id_almacen" => $_SESSION["almacen_dashboard"],
								"id_producto" => $this -> LoteEditarIdProducto);

		$producto = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tablaProducto, $datosProducto);

		if (floatval($canitdadEscrita) <= floatval($cantidadActual)) {
			
			$resultado = floatval($cantidadActual) - floatval($canitdadEscrita);
			$resultadoStockGeneral = floatval($producto["stock"]) - floatval($resultado);


		} else {

			$resultado = floatval($canitdadEscrita) - floatval($cantidadActual);
			$resultadoStockGeneral = floatval($producto["stock"]) + floatval($resultado);


		}


		if (floatval($resultadoStockGeneral) >= 0) {

			/* MODIFICAR LOTE */
			$tabla = "almacenes_productos_lotes";
			$datos = array("cantidad" => $this -> LoteEditarCantidadLote,
							"id_almacenes_productos_lotes" => $this -> LoteEditarId);

			$respuesta = ModeloProductosAlmacen::mdlEditarLote($tabla, $datos);
 
			/* MODIFICACION DE STOCK GENERAL DEL PRODUCTO */
			$tablaP = "almacenes_productos";
			$datosP =  array("id_almacen" => $_SESSION["almacen_dashboard"],
							"id_producto" => $this -> LoteEditarIdProducto,
							"stock" => $resultadoStockGeneral);

			$respuestaP = ModeloProductosAlmacen::mdlEditarLoteStockGeneral($tablaP, $datosP);

		} else {

			$respuesta = "menor";
			
		}


		echo json_encode($respuesta);	

		

	}
	
	/*=====  End of MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL  ======*/

	/*================================================================
	=            ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL            =
	================================================================*/
	
	public $LoteEliminarId;
	public $LoteEliminarIdProducto;
	public $LoteEliminarStock;

	public function ajaxEliminarLote(){

		$tabla = "almacenes_productos";
		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"id_producto" => $this -> LoteEliminarIdProducto);

		$producto = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

		$cantidadGeneral = floatval($producto["stock"]) - floatval($this -> LoteEliminarStock);


		if ($cantidadGeneral >= 0) {
			
			/* ELIMINAR LOTE */
			$tablaLote = "almacenes_productos_lotes";
			$item = "id_almacenes_productos_lotes";
			$valor = $this -> LoteEliminarId;

			$respuestaLote = ModeloProductosAlmacen::mdlEliminarLote($tablaLote, $item, $valor);


			/* MODIFICACION DE STOCK GENERAL DEL PRODUCTO */
			$datosProducto = array("id_almacen" => $_SESSION["almacen_dashboard"],
									"id_producto" => $this -> LoteEliminarIdProducto,
									"stock" => $cantidadGeneral);

			$respuestaProducto = ModeloProductosAlmacen::mdlEditarLoteStockGeneral($tabla, $datosProducto);


			/* ACTUALIZAR TABLE DE LOTES */
			$datosLotes = array("id_almacen" => $_SESSION["almacen_dashboard"],
								"id_producto" => $this -> LoteEliminarIdProducto);

			$respuesta = ModeloProductosAlmacen::mdlMostrarLotesProducto($tablaLote, $datosLotes);


		} else {

			$respuesta = "menor";

		}

		echo json_encode($respuesta);
		
	}
	
	/*=====  End of ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL  ======*/

/* *************************************************************************************** */
/* *************************************************************************************** */
/* *************************************************************************************** */
//****************** FUNCIONES DE LISTADO PRECIOS DEL PRODUCTO ******************************
	
	/*=============================================================
	=            MOSTRAR LISTA DE PRECIOS DEL PRODUCTO            =
	=============================================================*/
	
	public $ProductoAlmacenCodigoListado;
	public function ajaxMostrarListadoPreciosProductos(){

		$tabla = "almacenes_productos_listado_precios";

		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"codigo" => $this -> ProductoAlmacenCodigoListado);

		$respuesta = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos); 

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR LISTA DE PRECIOS DEL PRODUCTO  ======*/

	/*=======================================================================
	=            VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO            =
	=======================================================================*/

	public $changeListadoCodigo;
	public $changeListadoCantidad;

	public function ajaxChangeListado(){

		$tabla = "almacenes_productos_listado_precios";

		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"codigo" => $this -> changeListadoModelo,
						"cantidad" => $this -> changeListadoCantidad);

		$respuesta = ModeloProductosAlmacen::mdlChangeListado($tabla, $datos);

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
	
	public $listadoCrearCodigo;
	public $listadoCrearPiezas;
	public $listadoCrearCosto;

	public function ajaxCrearPrecioListado(){

		/* CREAR LISTADO */
		$tabla = "almacenes_productos_listado_precios";
		$activacion = "no";

		$datos = array("id_almacen" => $_SESSION["almacen_dashboard"],
						"codigo" => $this -> listadoCrearCodigo,
						"cantidad" => $this -> listadoCrearPiezas,
						"precio" => $this -> listadoCrearCosto,
						"promo" => $this -> listadoCrearCosto,
						"activadoPromo" => $activacion);

		$respuestaCrear = ModeloProductosAlmacen::mdlCrearListadoPrecios($tabla, $datos);

		/* MOSTRAR LISTA DE PRECIOS */

		$datosMostrar = array("id_almacen" => $_SESSION["idEmpresa_dashboard"],
							  "codigo" => $this -> listadoCrearCodigo);

		$respuesta = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datosMostrar);

		echo json_encode($respuesta);
		
	}	
	
	/*=====  End of CREAR NUEVO PRECIO AL LISTADO DE PRECIOS  ======*/

}

/*====================================================
=            MOSTRAR PRODUCTOS DE ALMACEN            =
====================================================*/

if (isset($_POST["opcionAlmacen"])) {
	$mostrarAlmacen = new AjaxProductosAlmacen();
	$mostrarAlmacen -> ajaxMostrarProductosAlmacen();
}

/*=====  End of MOSTRAR PRODUCTOS DE ALMACEN  ======*/

/*========================================================
=            MOSTRAR INFORMACION DEL PRODUCTO            =
========================================================*/

if (isset($_POST["idInfoProducto"])) {
	$info = new AjaxProductosAlmacen();
	$info -> idInfoProducto = $_POST["idInfoProducto"]; 
	$info -> ajaxMostrarInformacionProducto();
}

/*=====  End of MOSTRAR INFORMACION DEL PRODUCTO  ======*/

/*========================================================================
=            MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO            =
========================================================================*/

if (isset($_POST["idInfoProductoCaracteristicas"])) {
	$infoCaracteristica = new AjaxProductosAlmacen();
	$infoCaracteristica -> idInfoProductoCaracteristicas = $_POST["idInfoProductoCaracteristicas"]; 
	$infoCaracteristica -> ajaxMostrarCaracteristicasProducto();
}

/*=====  End of MOSTRAR INFORMACION CARACTERISTICAS DEL PRODUCTO  ======*/

/* **************************************************************************************** */
/* **************************************************************************************** */
/* **************************************************************************************** */
//************************ FUNCIONES DE LOTES DE PRODUCTO ************************************

/*========================================================
=            MOSTRAR LOTES DEL PRODUCTO (SKU)            =
========================================================*/

if (isset($_POST["lotesidProductoAlmacen"])) {
	$lotesSku = new AjaxProductosAlmacen();
	$lotesSku -> lotesidProductoAlmacen = $_POST["lotesidProductoAlmacen"];
	$lotesSku -> ajaxMostrarLotesProductos();
}

/*=====  End of MOSTRAR LOTES DEL PRODUCTO (SKU)  ======*/

/*====================================================================================
=            CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO            =
====================================================================================*/

if (isset($_POST["loteCrearIdProducto"])) {
	$crearLote = new AjaxProductosAlmacen();
	$crearLote -> loteCrearIdProducto = $_POST["loteCrearIdProducto"];
	$crearLote -> loteCrearPiezas = $_POST["loteCrearPiezas"];
	$crearLote -> loteCrearCosto = $_POST["loteCrearCosto"];
	$crearLote -> loteCrearProveedor = $_POST["loteCrearProveedor"];
	$crearLote -> loteCrearFactura = $_POST["loteCrearFactura"];
	$crearLote -> ajaxCrearLote();
}

/*=====  End of CREAR LOTE DEL PRODUCTO Y ACTUALIZACION DE STOCK EN PRODUCTO  ======*/

/*===================================================================
=            MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL            =
===================================================================*/

if (isset($_POST["LoteEditarId"])) {
	$editarLote = new AjaxProductosAlmacen();
	$editarLote -> LoteEditarId = $_POST["LoteEditarId"];
	$editarLote -> LoteEditarIdProducto = $_POST["LoteEditarIdProducto"];
	$editarLote -> LoteEditarCantidadLote = $_POST["LoteEditarCantidadLote"];
	$editarLote -> LoteEditarCantidadLoteActual = $_POST["LoteEditarCantidadLoteActual"];
	$editarLote -> ajaxEditarLote();
}

/*=====  End of MODIFICAR STOCK DEL LOTE Y PRODUCTO GENERAL  ======*/

/*================================================================
=            ELIMINAR LOTE Y ACTUALIZAR STOCK GENERAL            =
================================================================*/

if (isset($_POST["LoteEliminarId"])) {

	$eliminarLote = new AjaxProductosAlmacen();
	$eliminarLote -> LoteEliminarId = $_POST["LoteEliminarId"];
	$eliminarLote -> LoteEliminarIdProducto = $_POST["LoteEliminarIdProducto"];
	$eliminarLote -> LoteEliminarStock = $_POST["LoteEliminarStock"];
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

if (isset($_POST["ProductoAlmacenCodigoListado"])) {
	$listadoMostrar = new AjaxProductosAlmacen();
	$listadoMostrar -> ProductoAlmacenCodigoListado = $_POST["ProductoAlmacenCodigoListado"];
	$listadoMostrar -> ajaxMostrarListadoPreciosProductos();
}

/*=====  End of MOSTRAR LISTA DE PRECIOS DEL PRODUCTO  ======*/

/*=======================================================================
=            VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO            =
=======================================================================*/

if (isset($_POST["changeListadoCodigo"])) {
	$changeListado = new AjaxProductosAlmacen();
	$changeListado -> changeListadoCodigo = $_POST["changeListadoCodigo"];
	$changeListado -> changeListadoCantidad = $_POST["changeListadoCantidad"];
	$changeListado -> ajaxChangeListado();
}

/*=====  End of VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIO  ======*/

/*================================================================
=            CREAR NUEVO PRECIO AL LISTADO DE PRECIOS            =
================================================================*/

if (isset(($_POST["listadoCrearCodigo"]))) {
	$crearListado = new AjaxProductosAlmacen();
	$crearListado -> listadoCrearCodigo = $_POST["listadoCrearCodigo"];
	$crearListado -> listadoCrearPiezas = $_POST["listadoCrearPiezas"];
	$crearListado -> listadoCrearCosto = $_POST["listadoCrearCosto"];
	$crearListado -> ajaxCrearPrecioListado();
}

/*=====  End of CREAR NUEVO PRECIO AL LISTADO DE PRECIOS  ======*/

?>