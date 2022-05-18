<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.configuracion-venta.php';

class AjaxConfiguracionTarjeta{
/*==================================================
	=      GUARDAR CONFIGURACIÓN COMISION          =
	==================================================*/

	public $comisionrequerida;
    public $porcentajecomisionTD;
	public $porcentajecomisionTC;
	public $IVAcomisionrequerida;
	
	public function ajaxConfigTarjeta(){

		$tabla = "configuracion_ventas";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"comision_tarjeta" => $this -> comisionrequerida,
						"porcentajeTD" => $this -> porcentajecomisionTD,
						"porcentajeTC" => $this -> porcentajecomisionTC,
						"iva_comision_tarjeta" => $this -> IVAcomisionrequerida);

		$configventa = ModeloConfiguracionventa::mdlMostrarconfig($tabla, $item, $valor);

		if ($configventa == false) {

			$respuesta = ModeloConfiguracionventa::mdlCrearConfigVentacomision($tabla, $datos);

		} else {

			$respuesta = ModeloConfiguracionventa::mdlEditarConfigVentacomision($tabla, $datos);
		}

		echo json_encode($respuesta);

	}

}
/*==================================================
	=      GUARDAR CONFIGURACIÓN COMISION          =
	==================================================*/
    class AjaxConfiguracionIVA{
	public $ivarequerido;
    public $ivaincluido;
	
	public function ajaxConfigIVA(){

		$tabla = "configuracion_ventas";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"usar_iva" => $this -> ivarequerido,
						"incluido" => $this -> ivaincluido);

		$existensiaMisredes = ModeloConfiguracionventa::mdlMostrarconfig($tabla, $item, $valor);

		if ($existensiaMisredes == false) {

			$respuesta = ModeloConfiguracionventa::mdlCrearConfigVentaIVA($tabla, $datos);

		} else {

			$respuesta = ModeloConfiguracionventa::mdlEditarConfigVentaIVA($tabla, $datos);
		}

		echo json_encode($respuesta);

	}
}

/*==================================================
	=      GUARDAR CONFIGURACIÓN PRECIO          =
	==================================================*/
    class AjaxConfiguracionPrecio{
		public $preciovariable;
		
		public function ajaxConfigPrecio(){
	
			$tabla = "configuracion_ventas";
			$item = "id_empresa";
			$valor = $_SESSION["idEmpresa_dashboard"];
	
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"precio_variable" => $this -> preciovariable);

	
			$respuesta = ModeloConfiguracionventa::mdlEditarConfigVentaPrecio($tabla, $datos);
	
			echo json_encode($respuesta);
	
		}
	

}
/*==================================================
=         GUARDAR CONFIGURACIÓN COMISION           =
==================================================*/

if (isset($_POST["comisionrequerida"])) {
	$config = new AjaxConfiguracionTarjeta();
	$config -> comisionrequerida = $_POST["comisionrequerida"];
    $config -> porcentajecomisionTD = $_POST["porcentajecomisionTD"];
	$config -> porcentajecomisionTC = $_POST["porcentajecomisionTC"];
	$config -> IVAcomisionrequerida = $_POST["IVAcomisionrequerida"];

	$config -> ajaxConfigTarjeta();
}

/*=====  End of GUARDAR CONFIGURACIÓN COMISION  ======*/
/*==================================================
=         GUARDAR CONFIGURACIÓN IVA           =
==================================================*/

if (isset($_POST["ivarequerido"])) {
	$config = new AjaxConfiguracionIVA();
	$config -> ivarequerido = $_POST["ivarequerido"];
    $config -> ivaincluido = $_POST["ivaincluido"];

	$config -> ajaxConfigIVA();
}

/*=====  End of GUARDAR CONFIGURACIÓN IVA  ======*/
/*==================================================
=         GUARDAR CONFIGURACIÓN PRECIO           =
==================================================*/

if (isset($_POST["preciovariable"])) {
	$config = new AjaxConfiguracionPrecio();
	$config -> preciovariable = $_POST["preciovariable"];

	$config -> ajaxConfigPrecio();
}

/*=====  End of GUARDAR CONFIGURACIÓN PRECIO  ======*/
?>