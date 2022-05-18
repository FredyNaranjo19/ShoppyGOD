<?php
session_start();
require_once "../../modelos/conexion.php";
require_once "../../modelos/dashboard/modelo.sucursales.php";

class AjaxSucursales{

	/*====================================================
	=            MOSTRAR TODAS LAS SUCURSALES            =
	====================================================*/
	
	public function ajaxMostrarSucursales(){

		$tabla = "sucursales";
		$item = NULL;
		$valor = NULL;
		$empresa = $_SESSION["idEmpresa_dashboard"];
		
		$respuesta = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR TODAS LAS SUCURSALES  ======*/
}

/*====================================================
=            MOSTRAR TODAS LAS SUCURSALES            =
====================================================*/

if (isset($_POST["SucursalesVenta"])) {
	$mSucursales =  new AjaxSucursales();
	$mSucursales -> ajaxMostrarSucursales();
}

/*=====  End of MOSTRAR TODAS LAS SUCURSALES  ======*/

?>