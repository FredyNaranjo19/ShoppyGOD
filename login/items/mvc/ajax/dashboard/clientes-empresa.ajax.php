<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.clientes-empresa.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';
require_once '../../modelos/dashboard/modelo.compras.php';

class AjaxClientes{

	/*======================================================
	=            MOSTRAR DOMICILIOS DEL CLIENTE            =
	======================================================*/
	
	public $idClienteM;

	public function ajaxMostrarDomicilios(){

		$tabla = "clientes_direcciones_empresa";
		$item = "id_cliente";
		$valor = $this -> idClienteM;

		$respuesta = ModeloClientes::mdlMostrarDomiciliosCliente($tabla, $item, $valor);

		echo json_encode($respuesta); 
		
	}
	
	/*=====  End of MOSTRAR DOMICILIOS DEL CLIENTE  ======*/

	/*===================================================================
	=            GUARDAR DIRECCION DEL CLIENTE Y RETORNAR ID            =
	===================================================================*/
	
	public $direccion;
	public $exterior;
	public $interior;
	public $cp;
	public $colonia;
	public $ciudad;
	public $estado;
	public $pais;
	public $calle1;
	public $calle2;
	public $referencia;
	public $idCliente;

	public function ajaxGuardarDireccion(){

		$tabla = "clientes_direcciones_empresa";

		$datos = array("direccion" => $this -> direccion,
						"exterior" => $this -> exterior,
						"interior" => $this -> interior,
						"cp" => $this -> cp,
						"colonia" => $this -> colonia,
						"ciudad" => $this -> ciudad,
						"estado" => $this -> estado,
						"pais" => $this -> pais,
						"calle1" => $this -> calle1,
						"calle2" => $this -> calle2,
						"referencia" => $this -> referencia,
						"idCliente" => $this -> idCliente);

		$respuesta = ModeloClientes::mdlCrearDireccion($tabla, $datos);

		$tablaUltimo = "clientes_direcciones_empresa";
		$item = "id_cliente";
		$valor = $this -> idCliente;

		$retorno = ModeloClientes::mdlMostrarUltimoDomicilio($tabla, $item, $valor);

		echo json_encode($retorno);

	}

	/*=====  End of GUARDAR DIRECCION DEL CLIENTE Y RETORNAR ID  ======*/

	/*=========================================================
	=            MOSTRAR DATOS PARA EDITAR CLIENTE            =
	=========================================================*/
	
	public $ClienteMostrarId;

	public function ajaxMostrarCliente(){

		$empresa = $_SESSION["idEmpresa_dashboard"];
        $elementos = ModeloCompras::mdlMostrarComprasCreditos($empresa);
    	$cantidad =$elementos["ventas_pagos"];
    	$tabla = "cedis_ventas";
		$respuesta2 = ModeloVentasCedis::mdlVentasActivasCedis($tabla,$empresa);
		if ( $cantidad >= $respuesta2[0]){
			$tabla = "clientes_empresa";
			$item = "id_cliente";
			$valor = $this -> ClienteMostrarId;
			$empresa = "";
		 	$respuesta = ModeloClientes::mdlMostrarClientes($tabla, $item, $valor, $empresa);
		  	
		} else  {

			$respuesta["credito"] = "Deshabilitado";
			
		 }
		 echo json_encode($respuesta);

		
	}
	
	/*=====  End of MOSTRAR DATOS PARA EDITAR CLIENTE  ======*/

	/*===================================================
	=            ELIMINAR CLIENTE DE EMPRESA            =
	===================================================*/
	
	public $ClienteEliminarId;

	public function  ajaxEliminarCliente(){

		$tabla = "clientes_empresa";
		$item = "id_cliente";
		$valor = $this -> ClienteEliminarId;

		$respuesta = ModeloClientes::mdlEliminarCliente($tabla, $item, $valor);

		echo json_encode($respuesta);

	}
	
	/*=====  End of ELIMINAR CLIENTE DE EMPRESA  ======*/

	/*====================================================
	=            MOSTRAR DIRECCION DEL PEDIDO            =
	====================================================*/
	
	public $idDireccion;
	public function ajaxMostrarDireccion(){

		$tabla = "clientes_direcciones_empresa";
		$item = "id_info";
		$valor = $this -> idDireccion;

		$respuesta = ModeloClientes::mdlMostrarDireccion($tabla, $item, $valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR DIRECCION DEL PEDIDO  ======*/

	/*==============================================================
	=            CREAR SOLICITUD DE CREDITO DEL CLIENTE            =
	==============================================================*/
	
	public $idClienteCredito;
	public function ajaxCrearSolicitudCredito(){

		$tabla = "clientes_solicitud_credito";
		$item = "id_cliente";
		$valor = $this -> idClienteCredito;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$cliente = ModeloClientes::mdlMostrarSolicitudesCredito($tabla, $item, $valor, $empresa);

		if ($cliente == false) {
			
			$tabla = "clientes_solicitud_credito";
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"id_cliente" => $this -> idClienteCredito);

			$respuesta = ModeloClientes::mdlCrearSolicitudCredito($tabla, $datos);

		} else {

			$respuesta = "En espera";
		}



		echo json_encode($respuesta);

	}
	
	/*=====  End of CREAR SOLICITUD DE CREDITO DEL CLIENTE  ======*/
		
	/*===========================================================
	=            APROBACION DESAPROBACION DE CREDITO            =
	===========================================================*/
	
	public $idCreditoCliente;
	public $valorCreditoCliente;
	public function ajaxCreditoCliente(){

		$tabla = "clientes_empresa";
		$datos = array("credito" => $this -> valorCreditoCliente,
						"id_cliente" => $this -> idCreditoCliente);
		$cambio = ModeloClientes::mdlModificarCreditoCliente($tabla, $datos);
 
		$tabla = "clientes_solicitud_credito";
		$item = "id_cliente";
		$valor = $this -> idCreditoCliente;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$existencia = ModeloClientes::mdlMostrarSolicitudesCredito($tabla, $item, $valor, $empresa);

		if ($existencia != false) {

			$tabla = "clientes_solicitud_credito";
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"id_cliente" => $this -> idCreditoCliente);

			$respuesta = ModeloClientes::mdlEliminarSolicitudCredito($tabla, $datos);

		} else {

			$respuesta = $cambio;
		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of APROBACION DESAPROBACION DE CREDITO  ======*/
}


/*======================================================
=            MOSTRAR DOMICILIOS DEL CLIENTE            =
======================================================*/

if (isset($_POST["idClienteDom"])) {
	$dom = new AjaxClientes();
	$dom -> idClienteM = $_POST["idClienteDom"];
	$dom -> ajaxMostrarDomicilios();
}

/*=====  End of MOSTRAR DOMICILIOS DEL CLIENTE  ======*/

/*===================================================================
=            GUARDAR DIRECCION DEL CLIENTE Y RETORNAR ID            =
===================================================================*/

if (isset($_POST["idCliente"])) {
	$guardarDir = new AjaxClientes();
	$guardarDir -> direccion = $_POST["direccion"];
	$guardarDir -> exterior = $_POST["exterior"];
	$guardarDir -> interior = $_POST["interior"];
	$guardarDir -> cp = $_POST["cp"];
	$guardarDir -> colonia = $_POST["colonia"];
	$guardarDir -> ciudad = $_POST["ciudad"];
	$guardarDir -> estado = $_POST["estado"];
	$guardarDir -> pais = $_POST["pais"];
	$guardarDir -> calle1 = $_POST["calle1"];
	$guardarDir -> calle2 = $_POST["calle2"];
	$guardarDir -> referencia = $_POST["referencia"];
	$guardarDir -> idCliente = $_POST["idCliente"];
	$guardarDir -> ajaxGuardarDireccion();	

}

/*=====  End of GUARDAR DIRECCION DEL CLIENTE Y RETORNAR ID  ======*/

/*=============================================================
=            MOSTRAR DATOS DEL CLIENTE PARA EDITAR            =
=============================================================*/

if (isset($_POST["ClienteMostrarId"])) {
	$mostrarCliente = new AjaxClientes();
	$mostrarCliente -> ClienteMostrarId = $_POST["ClienteMostrarId"];
	$mostrarCliente -> ajaxMostrarCliente();
}

/*=====  End of MOSTRAR DATOS DEL CLIENTE PARA EDITAR  ======*/

/*======================================================
=            ELIMINAR CLIENTE DE LA EMPRESA            =
======================================================*/

if (isset($_POST["ClienteEliminarId"])) {
	$eliminarCliente = new AjaxClientes();
	$eliminarCliente -> ClienteEliminarId = $_POST["ClienteEliminarId"];
	$eliminarCliente -> ajaxEliminarCliente();
}

/*=====  End of ELIMINAR CLIENTE DE LA EMPRESA  ======*/

/*====================================================
=            MOSTRAR DIRECCION DEL PEDIDO            =
====================================================*/

if (isset($_POST["idDireccion"])) {
	$dir = new AjaxClientes();
	$dir -> idDireccion = $_POST["idDireccion"];
	$dir -> ajaxMostrarDireccion();
}

/*=====  End of MOSTRAR DIRECCION DEL PEDIDO  ======*/

/*==============================================================
=            CREAR SOLICITUD DE CREDITO DEL CLIENTE            =
==============================================================*/

if (isset($_POST["idClienteCredito"])) {
	$creditoCrear = new AjaxClientes();
	$creditoCrear -> idClienteCredito = $_POST["idClienteCredito"];
	$creditoCrear -> ajaxCrearSolicitudCredito();
}

/*=====  End of CREAR SOLICITUD DE CREDITO DEL CLIENTE  ======*/

/*=============================================================
=            APROBACION Y DESAPROBACION DE CREDITO            =
=============================================================*/

if (isset($_POST["idCreditoCliente"])) {
	$creditoCliente = new AjaxClientes();
	$creditoCliente -> idCreditoCliente = $_POST["idCreditoCliente"];
	$creditoCliente -> valorCreditoCliente = $_POST["valorCreditoCliente"];
	$creditoCliente -> ajaxCreditoCliente();
}

/*=====  End of APROBACION Y DESAPROBACION DE CREDITO  ======*/
?>