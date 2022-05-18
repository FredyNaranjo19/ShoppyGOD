<?php

class ControladorPlantillasTienda{

	/*==========================================
	=            MOSTRAR PLANTILLAS            =
	==========================================*/
	
	static public function ctrMostrarPlantillas($item, $valor){

		$tabla = "tv_plantillas";

		$respuesta = ModeloPlantillasTienda::mdlMostrarPlantillas($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR PLANTILLAS  ======*/

	/*==============================================
	=            MOSTRAR MIS PLANTILLAS            =
	==============================================*/
	
	static public function ctrMostrarMisPlantillas($item, $valor){

		$tabla = "tv_mis_plantillas";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloPlantillasTienda::mdlMostrarMisPlantillas($tabla, $item, $valor, $empresa);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR MIS PLANTILLAS  ======*/

	/*=============================================================
	=            MOSTRAR CONFIGURACION DE LA PLANTILLA            =
	=============================================================*/
	
	static public function ctrMostrarConfiguracion($item, $valor){

		$tabla = "tv_configuracion_mis_plantillas";

		$respuesta = ModeloPlantillasTienda::mdlMostrarConfiguracion($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE LA PLANTILLA  ======*/
	
}

?>