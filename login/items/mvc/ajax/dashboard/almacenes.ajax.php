<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.almacenes.php';

class AjaxAlmacenes{

	/*======================================================
	=            MOSTRAR INFORMACION DE ALMACEN            =
	======================================================*/
	
	public $idAlmacen;
	public function ajaxMostrarInformacionAlmacen(){

		$tabla = "almacenes";

		$item = "id_almacen";
		$valor = $this -> idAlmacen;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR INFORMACION DE ALMACEN  ======*/
	
	/*========================================
	=            ELIMINAR ALMACEN            =
	========================================*/
	
	public $idAlmacenEliminar;
	public function ajaxEliminarAlmacen(){

		$tabla = "almacenes";
		$item = "id_almacen";
		$valor = $this -> idAlmacenEliminar;

		$respuesta = ModeloAlmacenes::mdlEliminarAlmacenes($tabla, $item, $valor);

		echo json_encode($respuesta);
		
	}
	
	/*=====  End of ELIMINAR ALMACEN  ======*/
	
	/*================================================================
	=                   GUARDAR CAMBIOS DE ALMACEN                   =
	================================================================*/
	
	public $idAlmacenEditar;
	public $nombreAlmacenEditar;
	public $direccionAlmacenEditar;
	public $telefonoAlmacenEditar;
	
	public function ajaxEditarAlmacen(){

		$tabla = "almacenes";
		$datos = array("id_almacen" => $this -> idAlmacenEditar,
						"nombre" => $this -> nombreAlmacenEditar,
						"direccion" => $this -> direccionAlmacenEditar,
						"telefono" => $this -> telefonoAlmacenEditar);

		$respuesta = ModeloAlmacenes::mdlEditarAlmacen($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*============  End of GUARDAR CAMBIOS DE ALMACEN  =============*/
	
		/*======================================================
	=            MOSTRAR ALMACENES DE UNA EMPRESA            =
	======================================================*/
	
	public function ajaxMostrarAlmacenes(){

		$tabla = "almacenes";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$item=NULL;
		$valor=NULL;

		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR INFORMACION DE ALMACEN  ======*/

	/*======================================================================
	=                   MOSTRAR ALMACENES DE UNA EMPRESA                   =
	======================================================================*/
	public $empresaRegistroUsuario;
	public function ajaxMostrarAlmacenesEmpresa(){

		$tabla = "almacenes";
		$empresa = $this->empresaRegistroUsuario;
		$item=NULL;
		$valor=NULL;

		$respuesta = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*============  End of MOSTRAR ALMACENES DE UNA EMPRESA  =============*/

}

/*======================================================
=            MOSTRAR INFORMACION DE ALMACEN            =
======================================================*/

if (isset($_POST["idAlmacen"])) {
	$mostrarAlmacen = new AjaxAlmacenes();
	$mostrarAlmacen -> idAlmacen = $_POST["idAlmacen"];
	$mostrarAlmacen -> ajaxMostrarInformacionAlmacen();

}

/*=====  End of MOSTRAR INFORMACION DE ALMACEN  ======*/

/*========================================
=            ELIMINAR ALMACEN            =
========================================*/

if (isset($_POST["idAlmacenEliminar"])) {
	$eliminarAlmacen = new AjaxAlmacenes();
	$eliminarAlmacen -> idAlmacenEliminar = $_POST["idAlmacenEliminar"];
	$eliminarAlmacen -> ajaxEliminarAlmacen();
}

/*=====  End of ELIMINAR ALMACEN  ======*/

/*=============================================
=                   GUARDAR CAMBIOS DE ALMACEN                   =
=============================================*/

if(isset($_POST["idAlmacenEditar"])){
	$editarAlmacen = new AjaxAlmacenes();
	$editarAlmacen -> idAlmacenEditar = $_POST["idAlmacenEditar"];
	$editarAlmacen -> nombreAlmacenEditar = $_POST["nombreAlmacenEditar"];
	$editarAlmacen -> direccionAlmacenEditar = $_POST["direccionAlmacenEditar"];
	$editarAlmacen -> telefonoAlmacenEditar = $_POST["telefonoAlmacenEditar"];
	$editarAlmacen -> ajaxEditarAlmacen();
}

/*============  End of GUARDAR CAMBIOS DE ALMACEN  =============*/
/*======================================================
=            MOSTRAR TODOS LOS ALMACENES DE EMPRESA           =
======================================================*/

if (isset($_POST["Almacenes"])) {
	$mostrarAlmacen = new AjaxAlmacenes();
	$mostrarAlmacen -> ajaxMostrarAlmacenes();

}

/*=====  End of MOSTRAR TODOS LOS ALMACENES DE EMPRESA  ======*/

/*======================================================
=            MOSTRAR TODOS LOS ALMACENES DE EMPRESA registro usuario          =
======================================================*/

if (isset($_POST["empresaRegistroUsuario"])) {
	$mostrarAlmacen = new AjaxAlmacenes();
	$mostrarAlmacen -> empresaRegistroUsuario = $_POST["empresaRegistroUsuario"];
	$mostrarAlmacen -> ajaxMostrarAlmacenesEmpresa();

}

/*=====  End of MOSTRAR TODOS LOS ALMACENES DE EMPRESA  ======*/
?>