<?php

class ControladorDevoluciones{

    /*====================================================
	=            MOSTRAR VENTAS VENDEDOR CEDIS           =
	====================================================*/
	
	static public function ctrMostrarDevolucionidauser(){
        $empresa = $_SESSION["idEmpresa_dashboard"];
		$vendedor = $_SESSION["id_dashboard"];
        $folio = NULL;
        date_default_timezone_set("America/Mexico_City");
        $fecha = '%'.date("Y-m-d").'%';

		$respuestas = ModeloDevoluciones::mdlMostrarDev($empresa, $folio, $vendedor, $fecha);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR VENTAS VENDEDOR CEDIS  ======*/
    /*====================================================
	=            MOSTRAR TOTAL DEVOLUCIÓN CORTE           =
	====================================================*/
	
	static public function ctrMostrarTotalDevocorte($metodo){
        $empresa = $_SESSION["idEmpresa_dashboard"];
		$vendedor = $_SESSION["id_dashboard"];
        $folio = NULL;
        date_default_timezone_set("America/Mexico_City");
        $fecha = '%'.date("Y-m-d").'%';

		$respuestas = ModeloDevoluciones::mdlMostrarTotalDevCorte($empresa, $folio, $vendedor, $fecha, $metodo);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR TOTAL DEVOLUCIÓN CORTE   ======*/
	

}
 
?>