<?php

class ControladorConfiguracionventa{

	/*==================================================
	=            MOSTRAR LOGO DE LA EMPRESA            =
	==================================================*/
	
	static public function ctrMostrarconfig($item, $valor){

		$tabla = "configuracion_ventas";

		$respuesta = ModeloConfiguracionventa::mdlMostrarconfig($tabla, $item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR LOGO DE LA EMPRESA  ======*/



	
}

?>