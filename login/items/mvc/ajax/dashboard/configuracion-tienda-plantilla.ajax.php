<?php

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.plantillas-tienda.php';

class AjaxConfiguracionTiendaPlantilla{

	/*=============================================
	=            SELECCIONAR PLANTILLA            =
	=============================================*/
	
	public $idEmpresa;
	public $idPlantilla;

	public function ajaxSeleccionPlantilla(){

		$tabla = "tv_mis_plantillas";

		$modificarSeleccion = ModeloPlantillasTienda::mdlDeseleccionarPlantilla($tabla, $this -> idPlantilla, $this -> idEmpresa);

		if ($modificarSeleccion == 'ok') {

		 	$respuesta = ModeloPlantillasTienda::mdlSeleccionarPlantilla($tabla, $this -> idPlantilla, $this -> idEmpresa);


		 }

		echo json_encode($respuesta);

	}
	
	/*=====  End of SELECCIONAR PLANTILLA  ======*/

	/*==========================================================
	=            GUARDAR CONFIGURACION DE PLANTILLA            =
	==========================================================*/
	
	public $idMiPlantilla;
	public $configMiPlantilla;
	public function ajaxGuardarConfiguracion(){


		$tabla = "tv_configuracion_mis_plantillas";
		$item = "id_misPlantillas";
		$valor = $this -> idMiPlantilla;

		$mis = ModeloPlantillasTienda::mdlMostrarConfiguracion($tabla, $item, $valor);

		if ($mis == false) {

			$datos = array("configuracion" => $this -> configMiPlantilla,
						   "id_misPlantillas" => $this -> idMiPlantilla);
			
			$respuesta = ModeloPlantillasTienda::mdlCrearConfiguracionPlantilla($tabla, $datos);

		} else {

			$datos = array("configuracion" => $this -> configMiPlantilla,
						   "id_misPlantillas" => $this -> idMiPlantilla);

			$respuesta = ModeloPlantillasTienda::mdlEditarConfiguracionPlantilla($tabla, $datos);

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR CONFIGURACION DE PLANTILLA  ======*/

	/*=====================================================
	=            GUARDAR IMAGENES DE PLANTILLA            =
	=====================================================*/
	
	public $PersuitInicioUrl;
	public $PersuitBannersUrl;
	public $PersuitSesionUrl;
	public $PersuitRegistroUrl;
	public $idConfigPlantillaImagen;
	
	public function ajaxGuardarConfiguracionImagenes(){

		$tabla = "tv_configuracion_mis_plantillas";
		$item = "id_misPlantillas";
		$valor = $this -> idConfigPlantillaImagen;

		$jsonVariable = array("PersuitInicioUrl" => $this -> PersuitInicioUrl,
							  "PersuitBannersUrl" => $this -> PersuitBannersUrl,
							  "PersuitSesionUrl" => $this -> PersuitSesionUrl,
							  "PersuitRegistroUrl" => $this -> PersuitRegistroUrl);
		
		$imagenes = json_encode($jsonVariable);

		$datos = array("imagenes" => $imagenes,
						"id_misPlantillas" => $this -> idConfigPlantillaImagen);


		$respuesta = ModeloPlantillasTienda::mdlMostrarConfiguracion($tabla, $item, $valor);

		if ($respuesta == false) {
			
			$respuesta = ModeloPlantillasTienda::mdlCrearConfiguracionPlantillaImagenes($tabla, $datos);

		} else {

			$respuesta = ModeloPlantillasTienda::mdlEditarConfiguracionPlantillaImagenes($tabla, $datos);

		}

		echo json_encode($respuesta);
	}
	
	/*=====  End of GUARDAR IMAGENES DE PLANTILLA  ======*/
	

	/*========================================================================
	=            GUARDAR CONFIGURACION DE COLORES DE LA PLANTILLA            =
	========================================================================*/
	
	public $jsonColores;
	public $idMiPlantillaColores;
	public function ajaxGuardarConfiguracionColores(){

		$tabla = "tv_configuracion_mis_plantillas";
		$item = "id_misPlantillas";
		$valor = $this -> idMiPlantillaColores;

		$datos = array("colores" => $this -> jsonColores,
						"id_misPlantillas" => $this -> idMiPlantillaColores);


		$existenciaColores = ModeloPlantillasTienda::mdlMostrarConfiguracion($tabla, $item, $valor);

		if ($existenciaColores == false) {

			$respuesta = ModeloPlantillasTienda::mdlCrearConfiguracionPlantillaColores($tabla, $datos);

		} else {

			$respuesta = ModeloPlantillasTienda::mdlEditarConfiguracionPlantillaColores($tabla, $datos);
			
		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR CONFIGURACION DE COLORES DE LA PLANTILLA  ======*/

}

/*=============================================
=            SELECCIONAR PLANTILLA            =
=============================================*/

if (isset($_POST["idEmpresaS"])) {

	$seleccion = new AjaxConfiguracionTiendaPlantilla();
	$seleccion -> idEmpresa = $_POST["idEmpresaS"];
	$seleccion -> idPlantilla = $_POST["idPlantillaS"];
	$seleccion -> ajaxSeleccionPlantilla();

}

/*=====  End of SELECCIONAR PLANTILLA  ======*/

/*==========================================================
=            GUARDAR CONFIGURACION DE PLANTILLA            =
==========================================================*/

if (isset($_POST["idMiPlantillaConf"])) {
	$configuracion = new AjaxConfiguracionTiendaPlantilla();
	$configuracion -> idMiPlantilla = $_POST["idMiPlantillaConf"];
	$configuracion -> configMiPlantilla = $_POST["configMiPlantilla"];
	$configuracion -> ajaxGuardarConfiguracion();
}

/*=====  End of GUARDAR CONFIGURACION DE PLANTILLA  ======*/

/*====================================================
=            GUADRA IMAGENES DE PLANTILLA            =
====================================================*/

if (isset($_POST["idConfigPlantillaImagen"])) {
	$configuracionImagenes = new AjaxConfiguracionTiendaPlantilla();
	$configuracionImagenes -> PersuitInicioUrl = $_POST["PersuitInicioUrl"];
	$configuracionImagenes -> PersuitBannersUrl = $_POST["PersuitBannersUrl"];
	$configuracionImagenes -> PersuitSesionUrl = $_POST["PersuitSesionUrl"];
	$configuracionImagenes -> PersuitRegistroUrl = $_POST["PersuitRegistroUrl"];
	$configuracionImagenes -> idConfigPlantillaImagen = $_POST["idConfigPlantillaImagen"];
	$configuracionImagenes -> ajaxGuardarConfiguracionImagenes();
}

/*=====  End of GUADRA IMAGENES DE PLANTILLA  ======*/

/*========================================================================
=            GUARDAR CONFIGURACION DE COLORES DE LA PLANTILLA            =
========================================================================*/

if (isset($_POST["colorJson"])) {
	$color = new AjaxConfiguracionTiendaPlantilla();
	$color -> jsonColores = $_POST["colorJson"];
	$color -> idMiPlantillaColores = $_POST["colorIdMiPlantilla"];
	$color -> ajaxGuardarConfiguracionColores();
}

/*=====  End of GUARDAR CONFIGURACION DE COLORES DE LA PLANTILLA  ======*/


?>