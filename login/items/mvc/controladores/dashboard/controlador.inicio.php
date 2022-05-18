<?php

class Controladorinicio{


	/*======================================================
	=            MOSTRAR Total Productos            =
	======================================================*/
	
	static public function ctrMostrartotalproductos($item, $valor){

		$tabla = "productos";

		$respuesta = Modeloinicio::mdlMostrartotalproductos($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR Total Productos  ======*/
    /*======================================================
	=            MOSTRAR Total Clientes           =
	======================================================*/
	
	static public function ctrtotalclientes($valor, $fecha){

		$tabla = "clientes_empresa";

		$respuesta = Modeloinicio::mdltotalclientes($tabla, $valor, $fecha);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR Total clientes  ======*/
    /*======================================================
	=            MOSTRAR Ventas Hoy           =
	======================================================*/
	
	static public function ctrventashoy($item, $valor){

		$tabla = "cedis_ventas";

		$respuesta = Modeloinicio::mdlventashoy($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR Ventas Hoy  ======*/
	
    /*======================================================
	=            MOSTRAR productos en TV           =
	======================================================*/
	
	static public function ctrprodentv($valor){

		$tabla = "tv_productos";

		$respuesta = Modeloinicio::mdlprodentv($tabla, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR productos en TV  ======*/




	
}

?>