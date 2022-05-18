<?php
session_start();

class AjaxAdministradorEmpresas{

	/*====================================================================
	=            GUARDAR ID DE EMPRESA EN VARIABLE DE SESSION            =
	====================================================================*/
	
	public $idEmpresa;
	public $empresa;
	public $alias;
	public $domicilio;
	public function ajaxGuardarVariable(){

		$_SESSION["idEmpresa_dashboard"] = $this -> idEmpresa;
		$_SESSION["nombreEmpresa_dashboard"] = $this -> empresa;
		$_SESSION["aliasEmpresa_dashboard"] = $this -> alias;
		$_SESSION["domicilioEmpresa_dashboard"] = $this -> domicilio;

		echo json_encode($_SESSION["idEmpresa_dashboard"]);
	}
	
	/*=====  End of GUARDAR ID DE EMPRESA EN VARIABLE DE SESSION  ======*/
	
}
/*====================================================================
=            GUARDAR ID DE EMPRESA EN VARIABLE DE SESSION            =
====================================================================*/

if (isset($_POST["idEmpresa"])) {
	$id = new AjaxAdministradorEmpresas();
	$id -> idEmpresa = $_POST["idEmpresa"];
	$id -> empresa = $_POST["empresa"];
	$id -> alias = $_POST["alias"];
	$id -> domicilio = $_POST["domicilio"];
	$id -> ajaxGuardarVariable();
}

/*=====  End of GUARDAR ID DE EMPRESA EN VARIABLE DE SESSION  ======*/


?>