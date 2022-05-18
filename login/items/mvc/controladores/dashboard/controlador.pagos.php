<?php

class ControladorPagos{

    	/*=================================================================================
	=                   MOSTRAR PAQUETE DE EMPRESA Pagos                  =
	=================================================================================*/
	
	static public function ctrMostrarPaquetePagos($paqueteadq){
        $tabla="creditos_compras";
        $empresa=$_SESSION["idEmpresa_dashboard"];
        $paqueteadq=NULL;
		$respuesta = ModeloPagos::mdlMostrarPaquetePagos($tabla, $empresa,$paqueteadq);

		return $respuesta;
	}
	
	/*============  End of MOSTRAR PAQUETE DE EMPRESA Pagos  =============*/
        	/*=================================================================================
	=                   MOSTRAR PRECIOS DE ventas a Pagos                   =
	=================================================================================*/
	
	static public function ctrMostrarPreciosEspacioPagos($item, $valor){

		$respuesta = ModeloPagos::mdlMostrarPreciosEspacioPagos($item, $valor);

		return $respuesta;
	}
	
	/*============  End of MOSTRAR PRECIOS DE ventas a Pagos   =============*/

}
?>