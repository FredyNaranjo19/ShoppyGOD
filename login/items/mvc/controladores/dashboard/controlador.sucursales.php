<?php

class ControladorSucursales{

	/*==========================================
	=            MOSTRAR SUCURSALES            =
	==========================================*/
	
	static public function ctrMostrarSucursales($item, $valor){

		$tabla = "sucursales";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloSucursales::mdlMostrarSucursales($tabla,$item,$valor,$empresa);

		return $respuesta; 
	}
	
	/*=====  End of MOSTRAR SUCURSALES  ======*/

}
?>