<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.configuracion-tienda.php';

class AjaxConfiguracionTienda{

	/*==================================================
	=            GUARDAR LOGO DE LA EMPRESA            =
	==================================================*/
	
	public $LogoEmpresaID;
	public $LogoEmpresaUrl;
	
	public function ajaxGuardarImagenEmpresa(){

		/* VERIFICAR EXISTENCIA */
		$tabla = "tv_configuracion_logo";

		$item = "id_empresa";
		$valor = $this -> LogoEmpresaID;
		$respuestaV = ModeloConfiguracionTienda::mdlMostrarLogo($tabla, $item, $valor);

		if ($respuestaV == false) {
			
			$datos = array("id_empresa" => $this -> LogoEmpresaID,
							"imagen" => $this -> LogoEmpresaUrl);

			$respuesta = ModeloConfiguracionTienda::mdlCrearLogoEmpresa($tabla, $datos);

		} else {

			$respuesta = 'ok';

		}

		echo json_encode($respuesta);

	}	
	
	/*=====  End of GUARDAR LOGO DE LA EMPRESA  ======*/

	/*=================================================
	=            GUARDAR CONFIGURACION SEO            =
	=================================================*/
	
	public $configuracionSEO;
	public function ajaxGuardarConfiguracionSEO(){

		$tabla = "tv_configuracion_seo";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$mostrar = ModeloConfiguracionTienda::mdlMostrarSEO($tabla, $item, $valor);

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"metadatos" => $this -> configuracionSEO);

		if ($mostrar == false) {
			
			$respuesta = ModeloConfiguracionTienda::mdlCrearSEO($tabla, $datos);

		} else {

			$respuesta = ModeloConfiguracionTienda::mdlEditarSEO($tabla, $datos);

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR CONFIGURACION SEO  ======*/

	/*===========================================================
	=            GUARDAR DATOS DE PAGO DE LA EMPRESA            =
	===========================================================*/
	
	public $PagoEfectivoView;
	public $PagoEfectivoTarjeta;
	public $PagoBanco;
	public $PagoPropietario;
	public $PagoMercadoView;
	public $PagoMercadoAccess;
	public $PagoCodigoVerificacion;

	public function ajaxGuardarPagos(){

		/* MOSTRAR EXISTENCIA  */
		$tabla = "tv_configuracion_pagos";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$respuestaMostrar = ModeloConfiguracionTienda::mdlMostrarConfiguracionPago($tabla, $item, $valor);

		/* GUARDAR CONFIGURACION DE PAGO */
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"efectivoView" => $this -> PagoEfectivoView,
						"efectivoTarjeta" => $this -> PagoEfectivoTarjeta,
						"mercadoView" => $this -> PagoMercadoView,
						"mercadoAccess" => $this -> PagoMercadoAccess,
						"banco" => $this -> PagoBanco,
						"propietario" => $this -> PagoPropietario);

		/* INFORMACION DE EMPRESA */
		$tablaEmpresa = "empresas";
		$itemEmpresa = "id_empresa";
		$valorEmpresa = $_SESSION["idEmpresa_dashboard"];
		// $respuestaEmpresa = ModelosEmpresas::mdlMostrarEmpresasAdministracion($tablaEmpresa, $itemEmpresa, $valorEmpresa);
		$codigo = $this -> PagoCodigoVerificacion;

		/* ELIMINAR CODIGO DE VERIFICACION */
		$datosCodigo = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							 "codigoVerificacionPagos" => NULL);

	

		if ($respuestaMostrar == false) {
			
		// 	if ($codigo == $respuestaEmpresa["codigoVerificacionPagos"]) {

				$respuesta = ModeloConfiguracionTienda::mdlCrearConfiguracionPago($tabla, $datos);

				// $respuestaCodigo = ModelosEmpresas::mdlGuardarCodigoVerificacionPago($tablaEmpresa, $datosCodigo);

		// 	} else {
		// 		$respuesta = "No coincide";
		// 	}	

		} else {

		// 	if ($codigo == $respuestaEmpresa["codigoVerificacionPagos"]) {

				$respuesta = ModeloConfiguracionTienda::mdlEditarConfiguracionPago($tabla, $datos);

		// 		$respuestaCodigo = ModelosEmpresas::mdlGuardarCodigoVerificacionPago($tablaEmpresa, $datosCodigo);

		// 	} else {
		// 		$respuesta = "No coincide";
		// 	}
			
		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR DATOS DE PAGO DE LA EMPRESA  ======*/

	/*==============================================
	=            GUARDAR REDES SOCIALES            =
	==============================================*/
	
	public $whats;
	public $numWhats;
	public $textWhats;
	public $messenger;
	public $idPage;
	public $colorPage;
	public $entradaPage;
	public $salidaPage;

	public function ajaxGuardarRedesSociales(){

		$tabla = "tv_configuracion_redes";
		$item =	"id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$mostrar = ModeloConfiguracionTienda::mdlMostrarRedes($tabla, $item, $valor);

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"numero" => $this -> numWhats,
						"textoWhats" => $this -> textWhats,
						"estadoWhats" => $this -> whats,
						"id_page" => $this -> idPage,
						"color" => $this -> colorPage,
						"entrada" => $this -> entradaPage,
						"salida" => $this -> salidaPage,
						"estadoMessenger" => $this -> messenger);

		if ($mostrar == false) {

			$respuesta = ModeloConfiguracionTienda::mdlCrearRedes($tabla, $datos);

		} else {

			$respuesta = ModeloConfiguracionTienda::mdlEditarRedes($tabla, $datos);

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR REDES SOCIALES  ======*/
	
	/*====================================================
	=            GUARDAR TERMINOS Y POLITICAS            =
	====================================================*/
	
	public $empresaTerminosPoliticas;
	public $terminosTextoTerminosPoliticas;
	public $politicasTextoTerminosPoliticas;

	public function ajaxGuardarTerminosPoliticas(){

		$tablaTermino = "tv_terminos_condiciones";
		$datosTermino = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"texto" => $this -> terminosTextoTerminosPoliticas);

		$tablaPolitcas = "tv_politicas_privacidad";
		$datosPoliticas = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"texto" => $this -> politicasTextoTerminosPoliticas);

		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		/* TERMINOS Y CONDICIONES */
		$terminos = ModeloConfiguracionTienda::mdlMostrarTerminosEmpresa($tablaTermino, $item, $valor);
		
		if ($terminos == false) {
		
			$respuestaTermino = ModeloConfiguracionTienda::mdlCrearTerminoEmpresa($tablaTermino, $datosTermino);

		} else {

			$respuestaTermino = ModeloConfiguracionTienda::mdlEditarTerminoEmpresa($tablaTermino, $datosTermino);

		}
		
		/* POLITICAS DE PRIVACIDAD */
		$politicas = ModeloConfiguracionTienda::mdlMostrarPoliticasEmpresa($tablaPolitcas, $item, $valor);

		if ($politicas == false) {
		
			$respuestaPolitica = ModeloConfiguracionTienda::mdlCrearPoliticaEmpresa($tablaPolitcas, $datosPoliticas);

		} else {

			$respuestaPolitica = ModeloConfiguracionTienda::mdlEditarPoliticaEmpresa($tablaPolitcas, $datosPoliticas);

		}

		if ($respuestaTermino == 'ok' || $respuestaPolitica == 'ok') {

			echo json_encode('ok');
			
		}

	}
	
	/*=====  End of GUARDAR TERMINOS Y POLITICAS  ======*/

	/*========================================================
	=            GUARDAR DATOS DE ENTREGA PEDIDOS            =
	========================================================*/
	
	public $EntregasSucursal;
	public $EntregasEnvios;
	public function ajaxGuardarEntregas(){

		/* MOSTRAR EXISTENCIA */
		$tabla = "tv_configuracion_entregas";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$respuestaMostrar = ModeloConfiguracionTienda::mdlMostrarConfiguracionEntregas($tabla, $item, $valor);

		/* GUARDAR CONFIGURACION DE ENTREGAS */
		
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"sucursal" => $this -> EntregasSucursal,
						"envios" => $this -> EntregasEnvios);

		if ($respuestaMostrar == false) {
			
			$respuesta = ModeloConfiguracionTienda::mdlCrearConfiguracionEntregas($tabla, $datos);

		} else {

			$respuesta = ModeloConfiguracionTienda::mdlEditarConfiguracionEntregas($tabla, $datos);

		}

		echo json_encode($respuesta);
	}
	
	
	/*=====  End of GUARDAR DATOS DE ENTREGA PEDIDOS  ======*/

	/*============================================================
	=            GUARDAR NUEVA CONFIGURACION DE ENVIO            =
	============================================================*/
	
	public $configuracionEnvioVolumetrico;
	public $configuracionEnvioPeso;
	public $configuracionEnvioPrecio;

	public function ajaxGuardarConfiguracionEnvio(){

		$tabla = "tv_configuracion_costo_envios";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"peso_volumetrico" => $this -> configuracionEnvioVolumetrico,
						"peso_masa" => $this -> configuracionEnvioPeso,
						"precio" => $this -> configuracionEnvioPrecio);

		$respuesta = ModeloConfiguracionTienda::mdlGuardarConfiguracionEnvio($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR NUEVA CONFIGURACION DE ENVIO  ======*/

		/*=====================================================
	=            EDITAR CONFIGURACION DE ENVIO            =
	=====================================================*/
	
	public $configuracioeEnvioId;
	public $configuracioeEnvioVolumetrico;
	public $configuracioeEnvioPeso;
	public $configuracioeEnvioPrecio;
	
	public function ajaxEditarConfiguracionEnvio(){

		$tabla = "tv_configuracion_costo_envios";

		$datos = array("id_configuracion_envios" => $this -> configuracioeEnvioId,
						"peso_volumetrico" => $this -> configuracioeEnvioVolumetrico,
						"peso_masa" => $this -> configuracioeEnvioPeso,
						"precio" => $this -> configuracioeEnvioPrecio);

		$respuesta = ModeloConfiguracionTienda::mdlEditarConfiguracionEnvio($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of EDITAR CONFIGURACION DE ENVIO  ======*/

	/*=======================================================
	=            ELIMINAR CONFIGURACION DE ENVIO            =
	=======================================================*/
	
	public $idEliminarConfiguracionEnvio;
	public function ajaxEliminarConfiguracionEnvio(){

		$tabla = "tv_configuracion_costo_envios";
		$item = "id_configuracion_envios";
		$valor = $this -> idEliminarConfiguracionEnvio;

		$respuesta = ModeloConfiguracionTienda::mdlEliminarConfiguracionEnvio($tabla, $item, $valor);

		echo json_encode($respuesta);

	}
	
	/*=====  End of ELIMINAR CONFIGURACION DE ENVIO  ======*/

	/*======================================================
	=            GUARDAR CONTACTO DE LA EMPRESA            =
	======================================================*/
	
	public $mailContactoEmpresa;
	public $telContactoEmpresa;
	
	public function ajaxGuardarContactoEmpresa(){

		$tabla = "tv_configuracion_contacto_empresa";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"telefono" => $this -> telContactoEmpresa,
						"mail" => $this -> mailContactoEmpresa);

		$existencia_Contacto = ModeloConfiguracionTienda::mdlMostrarContactoEmpresa($tabla, $item, $valor);

		if ($existencia_Contacto == false) {
			
			$respuesta = ModeloConfiguracionTienda::mdlCrearContactoEmpresa($tabla, $datos);
		
		} else {

			$respuesta = ModeloConfiguracionTienda::mdlEditarContactoEmpresa($tabla, $datos);
		}

		echo json_encode($respuesta);
	}
	
	/*=====  End of GUARDAR CONTACTO DE LA EMPRESA  ======*/

	/*==================================================
	=            GUARDAR MIS REDES SOCIALES            =
	==================================================*/

	public $misRedesFacebook;
	public $misRedesInstagram;
	public $misRedesTwitter;
	public $misRedesYoutube;
	public $misRedesTiktok;
	
	public function ajaxMisRedesGuardar(){

		$tabla = "tv_redes_sociales_empresa";
		$item = "id_empresa";
		$valor = $_SESSION["idEmpresa_dashboard"];

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"facebook" => $this -> misRedesFacebook,
						"instagram" => $this -> misRedesInstagram,
						"twitter" => $this -> misRedesTwitter,
						"youtube" => $this -> misRedesYoutube,
						"tiktok" => $this -> misRedesTiktok);

		$existensiaMisredes = ModeloConfiguracionTienda::mdlMostrarMisRedesSociales($tabla, $item, $valor);

		if ($existensiaMisredes == false) {

			$respuesta = ModeloConfiguracionTienda::mdlCrearMisRedesSociales($tabla, $datos);

		} else {

			$respuesta = ModeloConfiguracionTienda::mdlEditarMisRedesSociales($tabla, $datos);
		}

		echo json_encode($respuesta);

	}

}



/*==================================================
=            GUARDAR LOGO DE LA EMPRESA            =
==================================================*/

if (isset($_POST["LogoEmpresaID"])) {
	$logoGuardar = new AjaxConfiguracionTienda();
	$logoGuardar -> LogoEmpresaID = $_POST["LogoEmpresaID"];
	$logoGuardar -> LogoEmpresaUrl = $_POST["LogoEmpresaUrl"];
	$logoGuardar -> ajaxGuardarImagenEmpresa();
}

/*=====  End of GUARDAR LOGO DE LA EMPRESA  ======*/

/*=================================================
=            GUARDAR CONFIGURACION SEO            =
=================================================*/

if (isset($_POST["configuracionSEO"])) {
	$seoGuardar = new AjaxConfiguracionTienda();
	$seoGuardar -> configuracionSEO = $_POST["configuracionSEO"];
	$seoGuardar -> ajaxGuardarConfiguracionSEO();
}

/*=====  End of GUARDAR CONFIGURACION SEO  ======*/

/*===========================================================
=            GUARDAR DATOS DE PAGO DE LA EMPRESA            =
===========================================================*/

if (isset($_POST["PagoVariable"])) {
	$PagoGuardar = new AjaxConfiguracionTienda();
	$PagoGuardar -> PagoEfectivoView = $_POST["PagoEfectivoView"];
	$PagoGuardar -> PagoEfectivoTarjeta = $_POST["PagoEfectivoTarjeta"];
	$PagoGuardar -> PagoBanco = $_POST["PagoBanco"];
	$PagoGuardar -> PagoPropietario = $_POST["PagoPropietario"];
	$PagoGuardar -> PagoMercadoView = $_POST["PagoMercadoView"];
	$PagoGuardar -> PagoMercadoAccess = $_POST["PagoMercadoAccess"];
	$PagoGuardar -> PagoCodigoVerificacion = $_POST["PagoCodigoVerificacion"];
	$PagoGuardar -> ajaxGuardarPagos();
}

/*=====  End of GUARDAR DATOS DE PAGO DE LA EMPRESA  ======*/

/*==============================================
=            GUARDAR REDES SOCIALES            =
==============================================*/

if (isset($_POST["whats"])) {
	$guardarRedes = new AjaxConfiguracionTienda();
	$guardarRedes -> whats = $_POST["whats"];
	$guardarRedes -> numWhats = $_POST["numWhats"];
	$guardarRedes -> textWhats = $_POST["textWhats"];
	$guardarRedes -> messenger = $_POST["messenger"];
	$guardarRedes -> idPage = $_POST["idPage"];
	$guardarRedes -> colorPage = $_POST["colorPage"];
	$guardarRedes -> entradaPage = $_POST["entradaPage"];
	$guardarRedes -> salidaPage = $_POST["salidaPage"];
	$guardarRedes -> ajaxGuardarRedesSociales();
}

/*=====  End of GUARDAR REDES SOCIALES  ======*/

/*====================================================
=            GUARDAR TERMINOS Y POLITICAS            =
====================================================*/

if (isset($_POST["empresaTerminosPoliticas"])) {
	$terminos_Politicas = new AjaxConfiguracionTienda();
	$terminos_Politicas -> empresaTerminosPoliticas = $_POST["empresaTerminosPoliticas"];
	$terminos_Politicas -> terminosTextoTerminosPoliticas = $_POST["terminosTextoTerminosPoliticas"];
	$terminos_Politicas -> politicasTextoTerminosPoliticas = $_POST["politicasTextoTerminosPoliticas"];
	$terminos_Politicas -> ajaxGuardarTerminosPoliticas();
}

/*=====  End of GUARDAR TERMINOS Y POLITICAS  ======*/

/*===========================================================
=            GUARDAR DATOS DE ENTREGA DE PEDIDOS            =
===========================================================*/

if (isset($_POST["EntregasVariable"])) {
	$EntregasGuardar = new AjaxConfiguracionTienda();
	$EntregasGuardar -> EntregasSucursal = $_POST["EntregasSucursal"];
	$EntregasGuardar -> EntregasEnvios = $_POST["EntregasEnvios"];
	$EntregasGuardar -> ajaxGuardarEntregas();
}

/*=====  End of GUARDAR DATOS DE ENTREGA DE PEDIDOS  ======*/

/*============================================================
=            GUARDAR NUEVA CONFIGURACION DE ENVIO            =
============================================================*/

if (isset($_POST["configuracionEnvioVolumetrico"])) {
	$configuracionEnvio = new AjaxConfiguracionTienda();
	$configuracionEnvio -> configuracionEnvioVolumetrico = $_POST["configuracionEnvioVolumetrico"];
	$configuracionEnvio -> configuracionEnvioPeso = $_POST["configuracionEnvioPeso"];
	$configuracionEnvio -> configuracionEnvioPrecio = $_POST["configuracionEnvioPrecio"];
	$configuracionEnvio -> ajaxGuardarConfiguracionEnvio();
}

/*=====  End of GUARDAR NUEVA CONFIGURACION DE ENVIO  ======*/

/*=====================================================
=            EDITAR CONFIGURACION DE ENVIO            =
=====================================================*/

if (isset($_POST["configuracioeEnvioId"])) {
	$configuracionEditarEnvio = new AjaxConfiguracionTienda();
	$configuracionEditarEnvio -> configuracioeEnvioId = $_POST["configuracioeEnvioId"];
	$configuracionEditarEnvio -> configuracioeEnvioVolumetrico = $_POST["configuracioeEnvioVolumetrico"];
	$configuracionEditarEnvio -> configuracioeEnvioPeso = $_POST["configuracioeEnvioPeso"];
	$configuracionEditarEnvio -> configuracioeEnvioPrecio = $_POST["configuracioeEnvioPrecio"];
	$configuracionEditarEnvio -> ajaxEditarConfiguracionEnvio();
}

/*=====  End of EDITAR CONFIGURACION DE ENVIO  ======*/

/*=======================================================
=            ELIMINAR CONFIGURACION DE ENVIO            =
=======================================================*/

if (isset($_POST["idEliminarConfiguracionEnvio"])) {
	$eliminarconfigEnvio = new AjaxConfiguracionTienda();
	$eliminarconfigEnvio -> idEliminarConfiguracionEnvio = $_POST["idEliminarConfiguracionEnvio"];
	$eliminarconfigEnvio -> ajaxEliminarConfiguracionEnvio();
}

/*=====  End of ELIMINAR CONFIGURACION DE ENVIO  ======*/

/*======================================================
=            GUARDAR CONTACTO DE LA EMPRESA            =
======================================================*/

if (isset($_POST["empresaContactoEmpresa"])) {
	$contactoEmpresa = new AjaxConfiguracionTienda();
	$contactoEmpresa -> mailContactoEmpresa = $_POST["mailContactoEmpresa"];
	$contactoEmpresa -> telContactoEmpresa = $_POST["telContactoEmpresa"];
	$contactoEmpresa -> ajaxGuardarContactoEmpresa();
}

/*=====  End of GUARDAR CONTACTO DE LA EMPRESA  ======*/

/*==================================================
=            GUARDAR MIS REDES SOCIALES            =
==================================================*/

if (isset($_POST["misRedesEmpresa"])) {
	$misRedes = new AjaxConfiguracionTienda();
	$misRedes -> misRedesFacebook = $_POST["misRedesFacebook"];
	$misRedes -> misRedesInstagram = $_POST["misRedesInstagram"]; 
	$misRedes -> misRedesTwitter = $_POST["misRedesTwitter"]; 
	$misRedes -> misRedesYoutube = $_POST["misRedesYoutube"]; 
	$misRedes -> misRedesTiktok = $_POST["misRedesTiktok"];
	$misRedes -> ajaxMisRedesGuardar();
}

/*=====  End of GUARDAR MIS REDES SOCIALES  ======*/

?>