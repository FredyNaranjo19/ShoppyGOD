<?php
session_start();

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.embarcaciones.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.productos-almacen.php';

class AjaxEmbarque{

	/*========================================
	=            MOSTRAR EMBARQUE            =
	========================================*/
	
	public $idEmbarque;
	public function ajaxMostrarEmbarqueDetalle(){

		$tabla = "embarcacion";
		$item = "id_embarcacion";
		$valor = $this -> idEmbarque;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$embarque = ModeloEmbarcacion::mdlMostrarEmbarcaciones($tabla, $item, $valor, $empresa);


		$datos = array("folio" => $embarque["folio"],
						"id_almacen" => $embarque["id_almacen"]);

		$respuesta = ModeloEmbarcacion::mdlMostrarEmbarcacionesDetalle($datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR EMBARQUE  ======*/
	

	/*===============================================
	=            CREAR CARGA DE EMBARQUE            =
	===============================================*/
	
	public $folioCargaEmbarque;
	public $almacenCargaEmbarque;
	public $productosCargaEmbarque;

	public function ajaxCrearEmbarque(){

		$tabla = "embarcacion";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"id_almacen" => $this -> almacenCargaEmbarque,
						"folio" => $this -> folioCargaEmbarque);

		$embarque = ModeloEmbarcacion::mdlCrearEmbarque($tabla, $datos);

		if ($embarque == "ok") {

			$productos = json_decode($this -> productosCargaEmbarque, true);

			foreach ($productos as $key => $value) {

				$tablaDetalle = "embarcacion_detalle";

				$datosDetalle = array("id_almacen" => $this -> almacenCargaEmbarque,
								"folio" => $this -> folioCargaEmbarque,
								"id_producto" => $value["idProducto"],
								"stock" => $value["cantidad"],
								"estado" => "Cargado");

				$respuesta = ModeloEmbarcacion::mdlCrearEmbarqueDetalle($tablaDetalle, $datosDetalle);

				/* MODIFICAR STOCK DE CEDIS */

				$tablaProductos = "productos";
				$datosProductos = array("stock" => $value["cantidad"],
										"id_producto" => $value["idProducto"]);

				$modificar = ModeloProductos::mdlModificarStockDisponibleEmbarque($tablaProductos, $datosProductos);			

			}

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of CREAR CARGA DE EMBARQUE  ======*/
	
	/*=================================================
	=            RECIBIR PRODUCTO DE CARGA            =
	=================================================*/
	
	public $recibirProductoIdEmbarque;

	public function ajaxRecibirProductoCarga(){

		$tabla = "embarcacion_detalle";
		$item = "id_embarcacion_detalle";
		$valor = $this -> recibirProductoIdEmbarque;

		$embarque = ModeloEmbarcacion::mdlMostrarEmbarqueDetalleSimple($tabla, $item, $valor);


		/* CREAR LOTE DEL PRODUCTO EN ALMACEN */

		$tabla = "almacenes_productos_lotes";
		$datos = array("id_almacen" => $embarque["id_almacen"],
					   "id_producto" => $embarque["id_producto"],
					   "cantidad" => $embarque["stock"]);

		$lote = ModeloProductosAlmacen::mdlCrearLoteProducto($tabla, $datos);

		/* MOSTRAR INFORMACION DEL PRODUCTO */

		$tabla = "productos";
		$item = "id_producto";
		$valor = $embarque["id_producto"];
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		/* VERIFICAR EXISTENCIA DEL PRODUCTO EN ALMACEN */	
			
		$tabla = "almacenes_productos";
		$datos = array("id_producto" => $embarque["id_producto"],
					   "id_almacen" => $embarque["id_almacen"]);

		$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

		if ($productoAlmacen == false) {
			
			// CREAR PRODUCTO EN ALMACEN
			$tabla = "almacenes_productos";
			$datos = array("id_almacen" => $embarque["id_almacen"],
							"id_producto" => $embarque["id_producto"],
							"codigo" => $producto["codigo"],
							"stock" => $embarque["stock"]);

			$crearProductoAlmacen = ModeloProductosAlmacen::mdlCrearProductoAlmacen($tabla, $datos);

		} else {

			// EDITAR PRODUCTO EN ALMACEN
			$tabla = "almacenes_productos";
			$datos = array("id_almacen" => $embarque["id_almacen"],
						   "id_producto" => $embarque["id_producto"],
						   "stock" => $embarque["stock"]);

			$crearProductoAlmacen = ModeloProductosAlmacen::mdlEditarProductoAlmacen($tabla, $datos);

		}

		/* MOSTRAR LISTADO DE PRECIOS */
		$tabla = "productos_listado_precios";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"modelo" => $producto["codigo"]);

		$listadoMostrar = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);


		/* VERIFICAR EXISTENCIA DE LISTADO DE PRECIO EN ALMACEN */

		$tabla = "almacenes_productos_listado_precios";
		$datos = array("id_almacen" => $embarque["id_almacen"],
						"codigo" => $producto["codigo"]);

		$listadoAlmacen = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

		if ($listadoAlmacen == false) {
			
			foreach ($listadoMostrar as $key => $value) {
				
				$tabla = "almacenes_productos_listado_precios";
				$datos = array("id_almacen" => $embarque["id_almacen"],
								"codigo" => $producto["codigo"],
								"cantidad" => $value["cantidad"],
								"precio" => $value["precio"],
								"promo" => $value["promo"],
								"activadoPromo" => $value["activadoPromo"]);

				$crearListado = ModeloProductosAlmacen::mdlCrearListadoPrecios($tabla, $datos);

			}

		}

		/* MODIFICAR ESTADO DEL PRODUCTO EN CARGA */

		$tablaModificacion = "embarcacion_detalle";
		$datosModificacion = array("id_embarcacion_detalle" => $this -> recibirProductoIdEmbarque,
									"estado" => "Recibido");

		$estadoProducto = ModeloEmbarcacion::mdlEditarEstadoDetalleCarga($tablaModificacion, $datosModificacion);

		/* ESCRIBIR QUIEN RECIBIO EMBARQUE */

		$tablaRecibido = "embarcacion";
		$datosRecibido = array("folio" => $embarque["folio"],
							"id_almacen" => $embarque["id_almacen"],
							"recibido" => $_SESSION["nombre_dashboard"]);
		
		$respuesta = ModeloEmbarcacion::mdlModificacionRecibidoPor($tablaRecibido, $datosRecibido);

		echo json_encode($respuesta);

	}
	
	/*=====  End of RECIBIR PRODUCTO DE CARGA  ======*/
	
	/*================================================================
	=            RECIBIR PRODUCTOS SELECCIONADOS DE CARGA            =
	================================================================*/
	
	public $recibirProductoIdEmbarqueSelecc;

	public function ajaxRecibirProductosCargaSeleccionados(){

		$ids = json_decode($this -> recibirProductoIdEmbarqueSelecc, true);

		foreach ($ids as $key => $valueIds) {
			

			$tabla = "embarcacion_detalle";
			$item = "id_embarcacion_detalle";
			$valor = $valueIds["id_detalle_embarque"];

			$embarque = ModeloEmbarcacion::mdlMostrarEmbarqueDetalleSimple($tabla, $item, $valor);

			if($key == 0){

				$folio = $embarque["folio"];
				$id_almacen = $embarque["id_almacen"];

			}

			/* CREAR LOTE DEL PRODUCTO EN ALMACEN */

			$tabla = "almacenes_productos_lotes";
			$datos = array("id_almacen" => $embarque["id_almacen"],
						   "id_producto" => $embarque["id_producto"],
						   "cantidad" => $embarque["stock"]);

			$lote = ModeloProductosAlmacen::mdlCrearLoteProducto($tabla, $datos);

			/* MOSTRAR INFORMACION DEL PRODUCTO */

			$tabla = "productos";
			$item = "id_producto";
			$valor = $embarque["id_producto"];
			$empresa = $_SESSION["idEmpresa_dashboard"];

			$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

			/* VERIFICAR EXISTENCIA DEL PRODUCTO EN ALMACEN */	
				
			$tabla = "almacenes_productos";
			$datos = array("id_producto" => $embarque["id_producto"],
						   "id_almacen" => $embarque["id_almacen"]);

			$productoAlmacen = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

			if ($productoAlmacen == false) {
				
				// CREAR PRODUCTO EN ALMACEN
				$tabla = "almacenes_productos";
				$datos = array("id_almacen" => $embarque["id_almacen"],
								"id_producto" => $embarque["id_producto"],
								"codigo" => $producto["codigo"],
								"stock" => $embarque["stock"]);

				$crearProductoAlmacen = ModeloProductosAlmacen::mdlCrearProductoAlmacen($tabla, $datos);

			} else {

				// EDITAR PRODUCTO EN ALMACEN
				$tabla = "almacenes_productos";
				$datos = array("id_almacen" => $embarque["id_almacen"],
							   "id_producto" => $embarque["id_producto"],
							   "stock" => $embarque["stock"]);

				$crearProductoAlmacen = ModeloProductosAlmacen::mdlEditarProductoAlmacen($tabla, $datos);

			}

			/* MOSTRAR LISTADO DE PRECIOS */
			$tabla = "productos_listado_precios";
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"modelo" => $producto["codigo"]);

			$listadoMostrar = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);


			/* VERIFICAR EXISTENCIA DE LISTADO DE PRECIO EN ALMACEN */

			$tabla = "almacenes_productos_listado_precios";
			$datos = array("id_almacen" => $embarque["id_almacen"],
							"codigo" => $producto["codigo"]);

			$listadoAlmacen = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

			if ($listadoAlmacen == false) {
				
				foreach ($listadoMostrar as $key => $value) {
					
					$tabla = "almacenes_productos_listado_precios";
					$datos = array("id_almacen" => $embarque["id_almacen"],
									"codigo" => $producto["codigo"],
									"cantidad" => $value["cantidad"],
									"precio" => $value["precio"],
									"promo" => $value["promo"],
									"activadoPromo" => $value["activadoPromo"]);

					$crearListado = ModeloProductosAlmacen::mdlCrearListadoPrecios($tabla, $datos);

				}

			}

			/* MODIFICAR ESTADO DEL PRODUCTO EN CARGA */

			$tablaModificacion = "embarcacion_detalle";
			$datosModificacion = array("id_embarcacion_detalle" => $valueIds["id_detalle_embarque"],
										"estado" => "Recibido");

			$estadoProducto = ModeloEmbarcacion::mdlEditarEstadoDetalleCarga($tablaModificacion, $datosModificacion);

		}

		/* ESCRIBIR QUIEN RECIBIO EMBARQUE */

		$tablaRecibido = "embarcacion";
		$datosRecibido = array("folio" => $folio,
							"id_almacen" => $id_almacen,
							"recibido" => $_SESSION["nombre_dashboard"]);
		
		$respuesta = ModeloEmbarcacion::mdlModificacionRecibidoPor($tablaRecibido, $datosRecibido);

		echo json_encode($respuesta);

		
	}
	
	/*=====  End of RECIBIR PRODUCTOS SELECCIONADOS DE CARGA  ======*/
	

	/*=====================================
	=            NOTA PROBLEMA            =
	=====================================*/
	
	public $idProblemaEmbarque;
	public $notaProblemaEmbarque;
	
	public function ajaxNotaProblemaCarga(){

		$tabla = "embarcacion_detalle";
		$datos = array("id_embarcacion_detalle" => $this -> idProblemaEmbarque,
						"estado" => "No recibido",
						"nota" => $this -> notaProblemaEmbarque);

		$respuesta = ModeloEmbarcacion::mdlAgregarNotaProblema($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of NOTA PROBLEMA  ======*/

	/*===================================================
	=            RECIBIR RECHAZO DE PRODUCTO            =
	===================================================*/
	
	public $rechazoRecibirIdDetalle;

	public function ajaxRegresarRechazoProducto(){

		$tabla = "embarcacion_detalle";
		$item = "id_embarcacion_detalle";
		$valor = $this -> rechazoRecibirIdDetalle;

		$embarque = ModeloEmbarcacion::mdlMostrarEmbarqueDetalleSimple($tabla, $item, $valor);


		$tablaProducto = "productos";
		$datosProducto = array("id_producto" => $embarque["id_producto"],
								"stock" => $embarque["stock"]);

		$producto = ModeloProductos::mdlModificarStockRechazo($tablaProducto, $datosProducto);

		if ($producto == 'ok') {
			
			$tabla = "embarcacion_detalle";
			$datos = array("id_embarcacion_detalle" => $this -> rechazoRecibirIdDetalle,
							"estado" => "Regresado");

			$respuesta = ModeloEmbarcacion::mdlEditarEstadoDetalleCarga($tabla, $datos);

		} else {

			$respuesta = "error";
		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of RECIBIR RECHAZO DE PRODUCTO  ======*/
	
	
}

/*================================
=            MOSTRAR             =
================================*/

if (isset($_POST["idEmbarque"])) {
	$mostrarEmbarque = new AjaxEmbarque();
	$mostrarEmbarque -> idEmbarque = $_POST["idEmbarque"];
	$mostrarEmbarque -> ajaxMostrarEmbarqueDetalle();
}

/*=====  End of MOSTRAR   ======*/

/*===============================================
=            CREAR CARGA DE EMBARQUE            =
===============================================*/

if (isset($_POST["folioCargaEmbarque"])) {
	$crearEmbarque = new AjaxEmbarque();
	$crearEmbarque -> folioCargaEmbarque = $_POST["folioCargaEmbarque"];
	$crearEmbarque -> almacenCargaEmbarque = $_POST["almacenCargaEmbarque"];
	$crearEmbarque -> productosCargaEmbarque = $_POST["productosCargaEmbarque"];
	$crearEmbarque -> ajaxCrearEmbarque();
}

/*=====  End of CREAR CARGA DE EMBARQUE  ======*/

/*=================================================
=            RECIBIR PRODUCTO DE CARGA            =
=================================================*/

if (isset($_POST["recibirProductoIdEmbarque"])) {
	$recibirCarga = new AjaxEmbarque();
	$recibirCarga -> recibirProductoIdEmbarque = $_POST["recibirProductoIdEmbarque"];
	$recibirCarga -> ajaxRecibirProductoCarga();
}

/*=====  End of RECIBIR PRODUCTO DE CARGA  ======*/

/*================================================================
=            RECIBIR PRODUCTOS SELECCIONADOS DE CARGA            =
================================================================*/

if (isset($_POST["recibirProductoIdEmbarqueSelecc"])) {
	$recibirProductos = new AjaxEmbarque();
	$recibirProductos -> recibirProductoIdEmbarqueSelecc = $_POST["recibirProductoIdEmbarqueSelecc"];
	$recibirProductos -> ajaxRecibirProductosCargaSeleccionados();
}

/*=====  End of RECIBIR PRODUCTOS SELECCIONADOS DE CARGA  ======*/


/*========================================
=            NOTA DE PROBLEMA            =
========================================*/

if (isset($_POST["idProblemaEmbarque"])) {
	$notaCarga = new AjaxEmbarque();
	$notaCarga -> idProblemaEmbarque = $_POST["idProblemaEmbarque"];
	$notaCarga -> notaProblemaEmbarque = $_POST["notaProblemaEmbarque"];
	$notaCarga -> ajaxNotaProblemaCarga();
}

/*=====  End of NOTA DE PROBLEMA  ======*/

/*===================================================
=            RECIBIR RECHAZO DE PRODUCTO            =
===================================================*/

if (isset($_POST["rechazoRecibirIdDetalle"])) {
	$regresarProducto = new AjaxEmbarque();
	$regresarProducto -> rechazoRecibirIdDetalle = $_POST["rechazoRecibirIdDetalle"];
	$regresarProducto -> ajaxRegresarRechazoProducto();
}

/*=====  End of RECIBIR RECHAZO DE PRODUCTO  ======*/

?>