<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.proveedores.php';

class AjaxProveedores{

	/*=============================================================
	=            MOSTRAR LA INFORMACION DEL PROVEEDOR             =
	=============================================================*/
	
	public $id_proveedor;

	public function ajaxMostrarInformacionProveedor(){

		$tabla = "proveedores";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$item = "id_proveedor";
		$valor = $this -> idProveedor;

		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR LA INFORMACION DEL PROVEEDOR   ======*/

	/*==========================================
	=            ELIMINAR PROVEEDOR            =
	==========================================*/
	
	public $idProveedorEliminar;

	public function ajaxEliminarProveedor(){

		$tabla = "proveedores";
		$item = "id_proveedor";
		$valor = $this -> idProveedorEliminar;

		$respuesta = ModeloProveedores::mdlEliminarProveedor($tabla, $item, $valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ELIMINAR PROVEEDOR  ======*/
}


/*============================================================
=            MOSTRAR LA INFORMACION DEL PROVEEDOR            =
============================================================*/

if (isset($_POST["idProveedor"])) {
	$mostrarProveedor = new AjaxProveedores();
	$mostrarProveedor -> idProveedor = $_POST["idProveedor"];
	$mostrarProveedor -> ajaxMostrarInformacionProveedor();
}

/*=====  End of MOSTRAR LA INFORMACION DEL PROVEEDOR  ======*/

/*==========================================
=            ELIMINAR PROVEEDOR            =
==========================================*/

if (isset($_POST["idProveedorEliminar"])) {
	$eliminarProveedor = new AjaxProveedores();
	$eliminarProveedor -> idProveedorEliminar = $_POST["idProveedorEliminar"];
	$eliminarProveedor -> ajaxEliminarProveedor();
}

/*=====  End of ELIMINAR PROVEEDOR  ======*/

?>
