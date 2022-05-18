<?php

class ControladorProductosAlmacen{

	/*=====================================================
	=            MOSTRAR PRODUCTOS DEL ALMACEN            =
	=====================================================*/
	
	static public function ctrMostrarProductosAlmacen($datos){

		$tabla = "almacenes_productos";

		$respuesta = ModeloProductosAlmacen::mdlMostrarProductosAlmacen($tabla, $datos);

		return $respuesta;
	}

	
	/*=====  End of MOSTRAR PRODUCTOS DEL ALMACEN  ======*/

	/*===========================================================================
	=                   MOSTRAR LISTADO DE PRECIOS DE ALMACEN                   =
	===========================================================================*/
	static public function ctrMostrarListadoPreciosAlmacen($datos){
		$tabla = "almacenes_productos_listado_precios";

		$respuesta = ModeloProductosAlmacen::mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos);

		return $respuesta;
	}
	
	
	/*============  End of MOSTRAR LISTADO DE PRECIOS DE ALMACEN  =============*/
	
}

?>