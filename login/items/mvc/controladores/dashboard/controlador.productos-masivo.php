<?php

class ControladorProductosMasivo{

	/*=====================================================
	=            MOSTRAR PRODUCTOS PRECARGADOS            =
	=====================================================*/
	
	static public function ctrMostrarProductosPrecarga($item, $valor){

		$tabla = "productos_masivos";
		$empresa = $_SESSION['idEmpresa_dashboard'];

		$respuesta = ModeloProductosMasivo::mdlMostrarProductosPrecarga($tabla, $item, $valor, $empresa);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS PRECARGADOS  ======*/

}

?>