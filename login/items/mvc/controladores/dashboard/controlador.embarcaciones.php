<?php

class ControladorEmbarcacion{

	/*=============================================
	=            MOSTRAR EMBARCACIONES            =
	=============================================*/
	
	static public function ctrMostrarEmbarcaciones($item, $valor){

		$tabla = "embarcacion";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloEmbarcacion::mdlMostrarEmbarcaciones($tabla, $item, $valor, $empresa);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR EMBARCACIONES  ======*/

	/*==================================================
	=            MOSTRAR DETALLES EMBARQUES            =
	==================================================*/
	
	static public function ctrMostrarDetallesEmbarques($datos){

		$respuesta = ModeloEmbarcacion::mdlMostrarEmbarcacionesDetalle($datos);

		return $respuesta;
		
	}
	
	/*=====  End of MOSTRAR DETALLES EMBARQUES  ======*/
	
	
}