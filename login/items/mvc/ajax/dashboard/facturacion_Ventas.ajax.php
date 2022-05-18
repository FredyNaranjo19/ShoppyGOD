<?php
error_reporting(0);
session_start();
date_default_timezone_set('America/Mexico_City');

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.facturacion.php';
require_once '../../modelos/dashboard/modelo.ventas.php';
require_once '../../../plugins/facturacion/sdk2.php';

class AjaxFacturacionVentas{

	/*=======================================================
	=            AGRUPACION VENTAS SELECCIONADOS            =
	=======================================================*/
	
	public $agrupacionFolios;
	public function ajaxAgrupacionPedidos(){

		$almacen = $_SESSION["almacen_dashboard"];
		$consulta = "";

		$folio = json_decode($this -> agrupacionFolios, true);

		foreach ($folio as $key => $value) {
			
			if ($key == 0) {

				$consulta .= " v.folio = '".$value["folio"]."'";

			} else {

				$consulta .= " OR v.folio = '".$value["folio"]."'";

			}
			
		}

		$respuesta = ModeloVentas::mdlMostrarAgrupacionFolios($consulta, $almacen);

		echo json_encode($respuesta);

	}
	
	/*=====  End of AGRUPACION VENTAS SELECCIONADOS  ======*/

	/*=================================================
	=            REALIZAR FACTURA XML, PDF            =
	=================================================*/
	
	public $tituloFactura;
	public $serieFactura;
	public $razonEmisor;
	public $rfcEmisor;
	public $regimenFiscalEmisor;
	public $rfcReceptor;
	public $razonReceptor;
	public $cfdiFactura;
	public $tipoFactura;
	public $calleReceptor;
	public $noExtReceptor;
	public $coloniaReceptor;
	public $cpReceptor;
	public $municipioReceptor;
	public $estadoReceptor;
	public $emailReceptor;
	public $monedaFactura;
	public $condicionPagoFactura;
	public $metodoPagoFactura;
	public $formaPagoFactura;
	public $agrupacionFactura;
	public $foliosFacturados;
	public $totalFactura;
	public $subtotalFactura;
	public $ivaFactura;
	public $notasFactura;

	public function ajaxRealizarFactura(){

		$tablaFactura = "modulo_facturas";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$respuestaFactura = ModeloFacturacion::mdlMostrarFacturas($tablaFactura, $empresa);


		/*====================================================
		=            MOSTRAR INFORMACION DE SERIE            =
		====================================================*/

		$nombre_factura = "";
		$tablaSerie = "modulo_facturas_series";
		$itemSerie = "id_modulo_facturas_series";
		$valorSerie = $this -> serieFactura;
		$respuestaSerie = ModeloFacturacion::mdlMostrarConfSeriesFacturacion($tablaSerie, $itemSerie, $valorSerie, $empresa);

		$folioSerie = intval($respuestaSerie["no_folios"]) + intval(1);
		$NoFolio = intval($respuestaSerie["folio_inicial"]) + intval($folioSerie);

		$nombre_factura = "factura-".$_SESSION["aliasEmpresa_dashboard"]."-".$respuestaSerie["serie"].$NoFolio;

		/*============================================================
		=            MOSTRAR CONFIGURACION DE FACTURACION            =
		============================================================*/
		
		$tablaConf = "modulo_facturas_configuracion";
		$itemConf = NULL;
		$valorConf = NULL;

		$configuracion = ModeloFacturacion::mdlMostrarConfiguracion($tablaConf, $itemConf, $valorConf, $empresa);


		/*============================================================
		=            CODIGO PARA CREAR XML DE FACTURACION            =
		============================================================*/

		// Se especifica la version de CFDi 3.3
		$datos['version_cfdi'] = '3.3';

		// Ruta del XML Timbrado
		$datos['cfdi']='../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.xml';

		// Ruta del XML de Debug
		$datos['xml_debug']='../../../plugins/facturacion/timbrados_debug/'.$nombre_factura.'.xml';

		// Credenciales de Timbrado
		$datos['PAC']['usuario'] = 'DEMO700101XXX';
		$datos['PAC']['pass'] = 'DEMO700101XXX';
		$datos['PAC']['produccion'] = 'NO';

		// Rutas y clave de los CSD
		// $datos['conf']['cer'] = '../../../plugins/facturacion/certificados/pruebasTwynco/EKU9003173C9.cer';
		// $datos['conf']['key'] = '../../../plugins/facturacion/certificados/pruebasTwynco/EKU9003173C9.key';
		// $datos['conf']['pass'] = '12345678a';
		$datos['conf']['cer'] = '../../../plugins/facturacion/certificados/pruebasTwynco/'.$configuracion["factura_cer"];
		$datos['conf']['key'] = '../../../plugins/facturacion/certificados/pruebasTwynco/'.$configuracion["factura_key"];
		$datos['conf']['pass'] = $configuracion["factura_password"];

		// Datos de la Factura
		// $datos['factura']['condicionesDePago'] = 'CONDICIONEES';
		$datos['factura']['condicionesDePago'] = $this -> condicionPagoFactura;

		$datos['factura']['descuento'] = '0.00';
		$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);

		// $datos['factura']['folio'] = $NoFolio;
		$datos['factura']['folio'] = $NoFolio;

		// $datos['factura']['forma_pago'] = '01';
		$datos['factura']['forma_pago'] = $this -> formaPagoFactura;

		// $datos['factura']['LugarExpedicion'] = '45079';
		$datos['factura']['LugarExpedicion'] = $configuracion["lugar_expedicion"];

		// $datos['factura']['metodo_pago'] = 'PUE';
		$datos['factura']['metodo_pago'] = $this -> metodoPagoFactura;


		$datos['factura']['moneda'] = 'MXN';

		// $datos['factura']['serie'] = 'A';
		$datos['factura']['serie'] = $respuestaSerie["serie"];

		// $datos['factura']['subtotal'] = 298.00;
		$datos['factura']['subtotal'] = $this -> subtotalFactura;
		// $datos['factura']['subtotal'] = 77.59;

		$datos['factura']['tipocambio'] = 1;
		$datos['factura']['tipocomprobante'] = 'I';

		// $datos['factura']['total'] = 345.68;
		$datos['factura']['total'] = $this -> totalFactura;
		// $datos['factura']['total'] = 90;

		// $datos['factura']['RegimenFiscal'] = '601';
		$datos['factura']['RegimenFiscal'] = $this -> regimenFiscalEmisor;

		// Datos del Emisor
		// $datos['emisor']['rfc'] = 'EKU9003173C9'; //RFC DE PRUEBA
		$datos['emisor']['rfc'] = $configuracion["rfc"]; 
		// $datos['emisor']['nombre'] = 'ACCEM SERVICIOS EMPRESARIALES SC';  // EMPRESA DE PRUEBA
		$datos['emisor']['nombre'] = $configuracion["razon_social"]; 

		// Datos del Receptor
		// $datos['receptor']['rfc'] = 'XAXX010101000';
		// $datos['receptor']['nombre'] = 'Publico en General';
		// $datos['receptor']['UsoCFDI'] = 'G02';

		$datos['receptor']['rfc'] = $this -> rfcReceptor;
		$datos['receptor']['nombre'] = $this -> razonReceptor;
		$datos['receptor']['UsoCFDI'] = $this -> cfdiFactura;

		// Se agregan los conceptos

		$agrupacion = json_decode($this -> agrupacionFactura, true);

		foreach ($agrupacion as $key => $value) {

			// $id = floatval($key) + mt_rand(1000, 9999);

			$datos['conceptos'][$key]['cantidad'] = $value["piezas"];//1.00;
			$datos['conceptos'][$key]['unidad'] = 'NA';
			$datos['conceptos'][$key]['ID'] = $value["id"];//"1726";
			$datos['conceptos'][$key]['descripcion'] = $value["producto"];//"PRODUCTO DE PRUEBA ";
			$datos['conceptos'][$key]['valorunitario'] = $value["precio_sin_iva"];//77.59;//
			$datos['conceptos'][$key]['importe'] = $value["subtotal"];//77.59;//
			$datos['conceptos'][$key]['ClaveProdServ'] = $value["clavePS"];//'01010101';
			$datos['conceptos'][$key]['ClaveUnidad'] = $value["claveUnidad"];//'ACT';

			$datos['conceptos'][$key]['Impuestos']['Traslados'][0]['Base'] = $value["subtotal"];//77.59;//
			$datos['conceptos'][$key]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
			$datos['conceptos'][$key]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
			$datos['conceptos'][$key]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
			$datos['conceptos'][$key]['Impuestos']['Traslados'][0]['Importe'] = $value["iva"];//12.41;//

		}

		// $datos['conceptos'][0]['cantidad'] = 1.00;
		// $datos['conceptos'][0]['unidad'] = 'NA';
		// $datos['conceptos'][0]['ID'] = "1726";
		// $datos['conceptos'][0]['descripcion'] = "PRODUCTO DE PRUEBA 1";
		// $datos['conceptos'][0]['valorunitario'] = 99.00;
		// $datos['conceptos'][0]['importe'] = 99.00;
		// $datos['conceptos'][0]['ClaveProdServ'] = '01010101';
		// $datos['conceptos'][0]['ClaveUnidad'] = 'ACT';

		// $datos['conceptos'][0]['Impuestos']['Traslados'][0]['Base'] = 99.00;
		// $datos['conceptos'][0]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
		// $datos['conceptos'][0]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
		// $datos['conceptos'][0]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
		// $datos['conceptos'][0]['Impuestos']['Traslados'][0]['Importe'] = 15.84;


		// $datos['conceptos'][1]['cantidad'] = 1.00;
		// $datos['conceptos'][1]['unidad'] = 'NA';
		// $datos['conceptos'][1]['ID'] = "1586";
		// $datos['conceptos'][1]['descripcion'] = "PRODUCTO DE PRUEBA 2";
		// $datos['conceptos'][1]['valorunitario'] = 199.00;
		// $datos['conceptos'][1]['importe'] = 199.00;
		// $datos['conceptos'][1]['ClaveProdServ'] = '01010101';
		// $datos['conceptos'][1]['ClaveUnidad'] = 'ACT';


		// $datos['conceptos'][1]['Impuestos']['Traslados'][0]['Base'] = 199.00;
		// $datos['conceptos'][1]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
		// $datos['conceptos'][1]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
		// $datos['conceptos'][1]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
		// $datos['conceptos'][1]['Impuestos']['Traslados'][0]['Importe'] = 31.84;


		// Se agregan los Impuestos
		$datos['impuestos']['translados'][0]['impuesto'] = '002';
		$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
		$datos['impuestos']['translados'][0]['importe'] = $this -> ivaFactura;
		$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';
		$datos['impuestos']['TotalImpuestosTrasladados'] = $this -> ivaFactura;



		// $datos['impuestos']['translados'][0]['impuesto'] = '002';
		// $datos['impuestos']['translados'][0]['tasa'] = '0.160000';
		// $datos['impuestos']['translados'][0]['importe'] = 47.68;
		// $datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';
		// $datos['impuestos']['TotalImpuestosTrasladados'] = 47.68;


		// Se ejecuta el SDK
		$res = mf_genera_cfdi($datos);

		/*============================================
		=            CONVERTIR XML A HTML          =
		============================================*/
		
		$datosHTML['modulo']= "cfdi2html";
		$datosHTML['rutaxml']= '../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.xml';
		$datosHTML['titulo']= $this -> tituloFactura;//"Factura pdf prueba";
		$datosHTML['tipo']= "FACTURA";
		$datosHTML['path_logo']= "../../../img/facturas_empresa/".$configuracion["logo"];//'../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.png';
		$datosHTML['notas']= $this -> notasFactura;
		$datosHTML['color_marco']= $configuracion['color_marco'];//"#000000";
		$datosHTML['color_marco_texto']= $configuracion['color_marco_texto'];//"#FFFFFF";
		$datosHTML['color_texto']= $configuracion['color_texto'];//"#000000";
		$datosHTML['fuente_texto']= "monospace";

		$resHTML = mf_ejecuta_modulo($datosHTML);
		$HTML=$resHTML['html']; 
		
		
		/*============================================
		=            CONVERTIR HTML A PDF            =
		============================================*/
		
		$datosPDF['PAC']['usuario'] = 'DEMO700101XXX';
		$datosPDF['PAC']['pass'] = 'DEMO700101XXX';
		$datosPDF['PAC']['produccion'] = 'NO';

		$datosPDF['modulo']="html2pdf";
		$datosPDF['html']="$HTML";
		$datosPDF['archivo_html']="";
		$datosPDF['archivo_pdf']='../../../plugins/facturacion/timbrados/PDF/'.$nombre_factura.'.pdf';
		
		$resPDF = mf_ejecuta_modulo($datosPDF);

		
		if ($resPDF == "OK") {
			
			if ($this -> tipoFactura == "cliente") {
				
				$tabla = "modulo_facturas_datos";
				$item = "rfc";
				$valor = $this -> rfcReceptor;
				$existencia = ModeloFacturacion::mdlMostrarInfoFacturacionCliente($tabla, $item, $valor, $empresa);

				if ($existencia == false) {
					
					/*================================================================
					=            CREAR DATOS DE FACTURACION DE LA EMPRESA            =
					================================================================*/					
					$datos = array("razon_social" => $this -> razonReceptor,
									"rfc" => $this -> rfcReceptor,
									"calle" => $this -> calleReceptor,
									"noExt" => $this -> noExtReceptor,
									"colonia" => $this -> coloniaReceptor,
									"cp" => $this -> cpReceptor,
									"municipio" => $this -> municipioReceptor,
									"estado" => $this -> estadoReceptor,
									"email" => $this -> emailReceptor,
									"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

					$respuestaFactura = ModeloFacturacion::mdlCrearDatosFacturacionEmpresa($tabla, $datos);

				} else {
					/*====================================================================
					=            MODIFICAR DATOS DE FACTURACION DE LA EMPRESA            =
					====================================================================*/
					$datos = array("razon_social" => $this -> razonReceptor,
									"rfc" => $this -> rfcReceptor,
									"calle" => $this -> calleReceptor,
									"noExt" => $this -> noExtReceptor,
									"colonia" => $this -> coloniaReceptor,
									"cp" => $this -> cpReceptor,
									"municipio" => $this -> municipioReceptor,
									"estado" => $this -> estadoReceptor,
									"email" => $this -> emailReceptor,
									"id_modulo_facturas_datos" => $existencia["id_modulo_facturas_datos"]);

					$respuestaFactura = ModeloFacturacion::mdlEditarDatosFacturacionEmpresa($tabla, $datos);

				}

			}

			$folios = json_decode($this -> foliosFacturados, true);

			foreach ($folios as $key => $valueFolio) {
				
				/*==================================================================
				=            MODIFICACION DE PEDIDO SI YA FUE FACTURADO            =
				==================================================================*/				
				$tablaPedido = "ventas";
				$datosPedido = array("folio" => $valueFolio["folio"],
									"id_almacen" => $_SESSION["almacen_dashboard"],
									"factura" => "Si");

				$respuestaPedido = ModeloVentas::mdlModificacionFactura($tablaPedido, $datosPedido);

			}


			/*==================================================================
			=            CREAR REGISTRO DE FACTURA EN BASE DE DATOS            =
			==================================================================*/
			
			$datosFactura = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
									"serie" => $this -> serieFactura,
									"folio" => $NoFolio,
									"nombre" => $nombre_factura,
									"id_almacen" => $_SESSION["almacen_dashboard"],
									"zona" => "Almacen");

			$respuestaRegistro = ModeloFacturacion::mdlCrearRegistroFacturaAlmacen($tablaFactura, $datosFactura);

			if ($respuestaRegistro == "ok") {
				
				/*===============================================================================
				=            MODIFICACION DE NUEMERO DE FOLIO EN LA SERIE DE FACTURA            =
				===============================================================================*/
				$datosSerie = array("id_modulo_facturas_series" => $this -> serieFactura,
									"no_folios" => $folioSerie);

				$modificacionSerieFolio = ModeloFacturacion::mdlEditarSerieFolioFactura($tablaSerie, $datosSerie);


				/*========================================================================
				=            MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES            =
				========================================================================*/
				
				$respuesta = ModeloFacturacion::mdlEditarFacturasDisponibles($_SESSION["idEmpresa_dashboard"]);

				
				/*=====  End of MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES  ======*/
				

			}
		}

		echo json_encode($respuesta);

	}#formFacturacionAlmacen > div > div.col-md-5 > div:nth-child(2) > div.card-body > input.inputTotalResultado

	/*=====  End of REALIZAR FACTURA XML,PDF  ======*/

}

/*=====================================================
=            AGRUPAR PEDIDOS SELECCIONADOS            =
=====================================================*/

if (isset($_POST["agrupacionFolios"])) {
	$agrupacion = new AjaxFacturacionVentas();
	$agrupacion -> agrupacionFolios = $_POST["agrupacionFolios"];
	$agrupacion -> ajaxAgrupacionPedidos();
}

/*=====  End of AGRUPAR PEDIDOS SELECCIONADOS  ======*/


/*================================================
=            REALIZAR FACTURA XML,PDF            =
================================================*/

if (isset($_POST["razonEmisor"])) {
	$crearFactura = new AjaxFacturacionVentas();
	$crearFactura -> tituloFactura = $_POST["tituloFactura"];
	$crearFactura -> serieFactura = $_POST["serieFactura"];
	$crearFactura -> razonEmisor = $_POST["razonEmisor"];
	$crearFactura -> rfcEmisor = $_POST["rfcEmisor"];
	$crearFactura -> regimenFiscalEmisor = $_POST["regimenFiscalEmisor"];
	$crearFactura -> rfcReceptor = $_POST["rfcReceptor"];
	$crearFactura -> razonReceptor = $_POST["razonReceptor"];
	$crearFactura -> cfdiFactura = $_POST["cfdiFactura"];
	$crearFactura -> tipoFactura = $_POST["tipoFactura"];
	$crearFactura -> calleReceptor = $_POST["calleReceptor"];
	$crearFactura -> noExtReceptor = $_POST["noExtReceptor"];
	$crearFactura -> coloniaReceptor = $_POST["coloniaReceptor"];
	$crearFactura -> cpReceptor = $_POST["cpReceptor"];
	$crearFactura -> municipioReceptor = $_POST["municipioReceptor"];
	$crearFactura -> estadoReceptor = $_POST["estadoReceptor"];
	$crearFactura -> emailReceptor = $_POST["emailReceptor"];
	$crearFactura -> monedaFactura = $_POST["monedaFactura"];
	$crearFactura -> condicionPagoFactura = $_POST["condicionPagoFactura"];
	$crearFactura -> metodoPagoFactura = $_POST["metodoPagoFactura"];
	$crearFactura -> formaPagoFactura = $_POST["formaPagoFactura"];
	$crearFactura -> agrupacionFactura = $_POST["agrupacionFactura"];
	$crearFactura -> foliosFacturados = $_POST["foliosFacturados"];
	$crearFactura -> totalFactura = $_POST["totalFactura"];
	$crearFactura -> subtotalFactura = $_POST["subtotalFactura"];
	$crearFactura -> ivaFactura = $_POST["ivaFactura"];
	$crearFactura -> notasFactura = $_POST["notasFactura"];
	$crearFactura -> ajaxRealizarFactura();
}

/*=====  End of REALIZAR FACTURA XML,PDF  ======*/
?>