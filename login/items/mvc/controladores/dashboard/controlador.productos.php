<?php

class ControladorProductos{

	/*=========================================
	=            MOSTRAR PRODUCTOS            =
	=========================================*/
	
	static public function ctrMostrarProductos($item, $valor){

		$tabla = "productos";

		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		return $respuesta; 

	}  
 
	/*=====  End of MOSTRAR PRODUCTOS  ======*/
		/*=========================================
	=            MOSTRAR PRODUCTOS   Papelera          =
	=========================================*/
	
	static public function ctrMostrarProductosPapelera($item, $valor){

		$tabla = "productos";

		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductos::mdlMostrarProductosPapelera($tabla, $item, $valor, $empresa);

		return $respuesta; 

	}  
 
	/*=====  End of MOSTRAR PRODUCTOS Papelera  ======*/


	/*=============================================================================================================================
	=            ------------------------------- FUNCIONES DE LOTES DEL PRODUCTO -------------------------------------            =
	=============================================================================================================================*/
	
	/*============================================================
	=            MOSTRAR TODOS LOS LOTES DEL PRODUCTO            =
	============================================================*/
	
	static public function ctrMostrarTodosLotes($item, $valor){

		$tabla = "productos_lote";

		$respuesta = ModeloProductos::mdlMostrarLotesProducto($tabla, $item, $valor);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR TODOS LOS LOTES DEL PRODUCTO  ======*/

	/*=============================================================================
    =                   MOSTRAR LISTADO DE PRECIOS DE PRODUCTOS                   =
    =============================================================================*/

    static public function ctrMostrarListadoPreciosProducto($datos){
        $tabla = "productos_listado_precios";

        $respuesta = ModeloProductos::mdlMostrarPreciosProducto($tabla, $datos);

        return $respuesta;

    }
	/*=====  End of MOSTRAR LISTADO DE PRECIOS DE PRODUCTOS  ======*/
}

?>