<?php

class ControladorConfiguracionTienda{

	/*==================================================
	=            MOSTRAR LOGO DE LA EMPRESA            =
	==================================================*/
	
	static public function ctrMostrarLogo($item, $valor){

		$tabla = "tv_configuracion_logo";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarLogo($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR LOGO DE LA EMPRESA  ======*/

	/*=================================================
	=            MOSTRAR CONFIGURACION SEO            =
	=================================================*/
	
	static public function ctrMostrarSEO($item, $valor){

		$tabla = "tv_configuracion_seo";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarSEO($tabla, $item, $valor);

		return $respuesta;
		
	}
	
	/*=====  End of MOSTRAR CONFIGURACION SEO  ======*/

	/*======================================================
	=            MOSTRAR CONFIGURACION DE PAGOS            =
	======================================================*/
	
	static public function ctrMostrarConfiguracionPago($item, $valor){

		$tabla = "tv_configuracion_pagos";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarConfiguracionPago($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE PAGOS  ======*/
	
	/*==============================================
	=            MOSTRAR REDES SOCIALES            =
	==============================================*/
	
	static public function ctrMostrarRedes($item, $valor){

		$tabla = "tv_configuracion_redes";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarRedes($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR REDES SOCIALES  ======*/

	/*======================================================
	=            MOSTRAR TERMINOS Y CONDICIONES            =
	======================================================*/
	
	static public function ctrMostrarTerminosEmpresa($item, $valor){

		$tabla = "tv_terminos_condiciones";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarTerminosEmpresa($tabla,$item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR TERMINOS Y CONDICIONES  ======*/
	
	/*=======================================================
	=            MOSTRAR POLITICAS DE PRIVACIDAD            =
	=======================================================*/
	
	static public function ctrMostrarPoliticasEmpresa($item, $valor){

		$tabla = "tv_politicas_privacidad";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarPoliticasEmpresa($tabla,$item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR POLITICAS DE PRIVACIDAD  ======*/


	/*=========================================================
	=            MOSTRAR CONFIGURACION DE ENTREGAS            =
	=========================================================*/
	
	static public function ctrMostrarConfiguracionEntregas($item, $valor){

		$tabla = "tv_configuracion_entregas";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarConfiguracionEntregas($tabla, $item, $valor);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE ENTREGAS  ======*/

	/*====================================================
	=            MOSTRAR CONFIGURACION ENVIOS            =
	====================================================*/
	
	static public function ctrMostrarEnvios($item, $valor){

		$tabla = "tv_configuracion_costo_envios";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarEnvios($tabla, $item, $valor);

		return $respuesta;
		
	}
	
	/*=====  End of MOSTRAR CONFIGURACION ENVIOS  ======*/

	/*======================================================================
	=            MOSTRAR INFORMACION DEL CONTACTO DE LA EMPRESA            =
	======================================================================*/
	
	static public function ctrMostrarContactoEmpresa($item, $valor){

		$tabla = "tv_configuracion_contacto_empresa";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarContactoEmpresa($tabla, $item, $valor);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR INFORMACION DEL CONTACTO DE LA EMPRESA  ======*/

	/*==================================================
	=            MOSTRAR MIS REDES SOCIALES            =
	==================================================*/
	
	static public function ctrMostrarMisRedesSociales($item, $valor){

		$tabla = "tv_redes_sociales_empresa";

		$respuesta = ModeloConfiguracionTienda::mdlMostrarMisRedesSociales($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR MIS REDES SOCIALES  ======*/

	
}

?>