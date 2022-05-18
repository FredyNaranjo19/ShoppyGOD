<?php

class ControladorPlantilla{
	/*======================================================
	=            REDIRECCIONAMIENTO A LA TIENDA            =
	======================================================*/
	
	static public function ctrPlantilla(){

		include 'vistas/plantilla.php';
		
	}
	 
	/*=====  End of REDIRECCIONAMIENTO A LA TIENDA  ======*/
	
	/*===============================
	=            EMPRESA            =
	===============================*/
	
	static public function ctrEmpresa(){

		$empresa = $GLOBALS["global_ID_Empresa"];

		$respuesta = ModeloPlantilla::mdlEmpresa($empresa);

		return $respuesta;

	}
	
	/*=====  End of EMPRESA  ======*/

	/*============================================
	=            MOSTRAR MI PLANTILLA            =
	============================================*/
	
	static public function ctrMostrarMisPlantilla($datos){


		$tabla = "tv_mis_plantillas";

		$respuesta =  ModeloPlantilla::mdlMostrarMisPlantillas($tabla, $datos);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR MI PLANTILLA  ======*/

	/*====================================================
	=            MOSTRAR DETALLE DE PLANTILLA            =
	====================================================*/
	
	static public function ctrMostrarPlantilla($item, $valor){

		$tabla = "tv_plantillas";

		$respuesta = ModeloPlantilla::mdlMostrarPlantilla($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR DETALLE DE PLANTILLA  ======*/

	/*=============================================================
	=            MOSTRAR CONFIGURACION DE LA PLANTILLA            =
	=============================================================*/
	
	static public function ctrMostrarConfiguracionPlantilla($item, $valor){

		$tabla = "tv_configuracion_mis_plantillas";

		$respuesta = ModeloPlantilla::mdlMostrarConfiguracionPlantilla($tabla, $item, $valor);

		return $respuesta;
		
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE LA PLANTILLA  ======*/
	
}

?>