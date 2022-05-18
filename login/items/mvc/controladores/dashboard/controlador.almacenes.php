<?php

class ControladorAlmacenes{

	/*=========================================
	=            MOSTRAR ALMACENES            =
	=========================================*/
	
	static public function ctrMostrarAlmacenes($item, $valor){

		$tabla = "almacenes";

		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR ALMACENES  ======*/
	
	/*=====================================
	=            CREAR ALMACEN            =
	=====================================*/
	
	static public function ctrCrearAlmacen(){

		if (isset($_POST["nNombreAlmacen"])) {
			
			$tabla = "almacenes";

			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"nombre" => $_POST["nNombreAlmacen"],
							"direccion" => $_POST["nDireccionAlmacen"],
							"telefono" => $_POST["ntelefonoAlmacen"]);

			$respuesta = ModeloAlmacenes::mdlCrearAlmacen($tabla, $datos);

			if ($respuesta == "ok") {
				
				echo '<script>window.location = "almacenes";</script>';

			}
		}
	}
	
	/*=====  End of CREAR ALMACEN  ======*/
	
	/*======================================
	=            EDITAR ALMACEN            =
	======================================*/
	
	static public function ctrEditarAlmacen(){

		if (isset($_POST["eNombreAlmacen"])) {
			
			$tabla = "almacenes";

			$datos = array("id_almacen" => $_POST["eIdAlmacen"],
							"nombre" => $_POST["eNombreAlmacen"],
							"direccion" => $_POST["eDireccionAlmacen"],
							"telefono" => $_POST["eTelefonoAlmacen"]);

			$respuesta = ModeloAlmacenes::mdlEditarAlmacen($tabla, $datos);

			if ($respuesta == "ok") {
				
				echo '<script>window.location = "almacenes";</script>';

			}
		}
	}
	
	/*=====  End of EDITAR ALMACEN  ======*/
	

}

?>