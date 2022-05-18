<?php

class ControladorDashboard{

	/*===================================================
	=            INICIAR PLANTILLA DASHBOARD            =
	===================================================*/
	
	static public function ctrDashboard(){
		
		// $tabla = "servicios_contratados";
		// $fecha = date("Y-m-d");
		// $respuesta = ModeloServicios::mdlMostrarServiciosCarga($tabla, $fecha);

		// /* SI HAY EMPRESAS */
		// if ($respuesta != false) {
			
		// 	foreach ($respuesta as $key => $value) {
				

		// 		$datos = array("estado" => "Desactivado",
		// 						"id_servicios_contratados" => $value["id_servicios_contratados"]);

		// 		$modificar = ModeloServicios::mdlModificarEstadoServicio($tabla, $datos);

		// 	}
		// }


		include 'vistas/dashboard.php';
		
	}
	
	/*=====  End of INICIAR PLANTILLA DASHBOARD  ======*/
	
}

?>