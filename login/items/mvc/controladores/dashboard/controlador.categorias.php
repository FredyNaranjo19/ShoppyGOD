<?php

class ControladorCategorias{

	/*========================================================
	=            MOSTRAR CATEGORIAS DE LA EMPRESA            =
	========================================================*/
	
	static public function ctrMostrarCategorias($item, $valor){ 

		$tabla = "tv_categorias";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor, $empresa);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR CATEGORIAS DE LA EMPRESA  ======*/
	
	/*=============================================================
	=            MOSTRAR SUBCATEGORIAS DE LA CATEGORIA            =
	=============================================================*/
	
	static public function ctrMostrarSubCategorias($item, $valor){

		$tabla = "tv_subcategorias"; 

		$respuesta = ModeloCategorias::mdlMostrarSubCategorias($tabla, $item, $valor);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR SUBCATEGORIAS DE LA CATEGORIA  ======*/


}

?>