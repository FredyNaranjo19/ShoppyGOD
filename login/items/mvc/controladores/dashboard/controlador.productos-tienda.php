<?php

class ControladorProductosTienda{

	/*===========================================================
	=            MOSTRAR PRODUCTOS DE TIENDA VIRTUAL            =
	===========================================================*/
	
	static public function ctrMostrarProductosTienda($item, $valor){

		$tabla = "tv_productos";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductosTienda::mdlMostrarProductosTienda($tabla, $item, $valor, $empresa);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR PRODUCTOS DE TIENDA VIRTUAL  ======*/
	
	/*=================================================================================
	=                   MOSTRAR PRECIOS DE ESPACIOS PRODUCTOS EN TV                   =
	=================================================================================*/
	
	static public function ctrMostrarPreciosEspacioProducto($item, $valor){

		$respuesta = ModeloProductosTienda::mdlMostrarPreciosEspacioProducto($item, $valor);

		return $respuesta;
	}
	
	/*============  End of MOSTRAR PRECIOS DE ESPACIOS PRODUCTOS EN TV  =============*/

	/*===================================================================
	=            MOSTRAR CANTIDAD DE PRODUCTOS POR CATEGORIA            =
	===================================================================*/
	
	static public function ctrMostrarCantidadProductosPorCategoria($item, $valor){

		$tabla = "tv_productos";

		$respuesta = ModeloProductosTienda::mdlMostrarCantidadPorCategoria($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR CANTIDAD DE PRODUCTOS POR CATEGORIA  ======*/
	/*=================================================================================
	=                   MOSTRAR PAQUETE DE EMPRESA Pagos                  =
	=================================================================================*/
	
	static public function ctrMostrarPaqueteProductosTV($paqueteadq){
        $tabla="tv_productos_compras";
        $empresa=$_SESSION["idEmpresa_dashboard"];
        $paqueteadq=NULL;
		$respuesta = ModeloProductosTienda::mdlMostrarPaqueteEmpresa($tabla, $empresa,$paqueteadq);

		return $respuesta;
	}
	
	/*============  End of MOSTRAR PAQUETE DE EMPRESA Pagos  =============*/
}

?>