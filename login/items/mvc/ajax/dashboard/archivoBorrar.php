<?php
error_reporting(0);
session_start();
date_default_timezone_set('America/Mexico_City');

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.facturacion.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';
require_once '../../modelos/dashboard/modelo.empresas.php';
require_once '../../../plugins/facturacion/sdk2.php';




class AjaxFacturacionVentasCedis{

    /*=======================================================
	=            AGRUPACION VENTAS SELECCIONADOS            =
	=======================================================*/
	
	public $agrupacionFolios;
	public function ajaxAgrupacionPedidos(){

		$empresa = $_SESSION["idEmpresa_dashboard"];
		$consulta = "";

		$folio = json_decode($this -> agrupacionFolios, true);

		foreach ($folio as $key => $value) {
			
			if ($key == 0) {

				$consulta .= " v.folio = '".$value["folio"]."'";

			} else {

				$consulta .= " OR v.folio = '".$value["folio"]."'";

			}
			
		}

		$respuesta = ModeloVentasCedis::mdlMostrarAgrupacionFolios($consulta, $empresa);

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

		$tabla = "modulo_facturas_compras";
		$item = "";
		$valor = "";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$timbres = ModeloFacturacion::mdlMostrarTimbresEmpresa($tabla,$item,$valor,$empresa);

		if ($timbres["facturas_disponibles"] > 0) {
			# code...
			$tablaFactura = "modulo_facturas";
			
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
			$datos['PAC']['usuario'] = 'DDM180518659';
			$datos['PAC']['pass'] = 'MULTIf0489472a2047ba7eeae3451646dd019!';
			$datos['PAC']['produccion'] = 'SI';
	
			// $datos['PAC']['usuario'] = $configuracion["rfc"];
			// $datos['PAC']['pass'] = $configuracion["factura_password"];
			// $datos['PAC']['produccion'] = 'NO';
	
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
			$datos['factura']['tipocomprobante'] = 'E';
	
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
			// $tabla = "modulo_facturas_compras";
			// $item = null;
			// $valor = null;
	
			// $facturasDisponibles = ModeloFacturacion::mdlMostrarTimbresEmpresa($tabla,$item,$valor,$empresa);
	
	
			//Se ejecuta el SDK
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
			// $datosHTML['enviar_a']= $this -> emailReceptor;  //DESTINATARIO FACTURA
	
			$resHTML = mf_ejecuta_modulo($datosHTML);
			$HTML=$resHTML['html']; 
			
			
			/*============================================
			=            CONVERTIR HTML A PDF            =
			============================================*/
			
			$datosPDF['PAC']['usuario'] = 'DDM180518659';
			$datosPDF['PAC']['pass'] = 'MULTIf0489472a2047ba7eeae3451646dd019!';
			$datosPDF['PAC']['produccion'] = 'SI';
	
			$datosPDF['modulo']="html2pdf";
			$datosPDF['html']="$HTML";
			$datosPDF['archivo_html']="";
			$datosPDF['archivo_pdf']='../../../plugins/facturacion/timbrados/PDF/'.$nombre_factura.'.pdf';
			
			$resPDF = mf_ejecuta_modulo($datosPDF);
	
			
			if ($resPDF == "OK") {
	
				
				
				if ($this -> tipoFactura == "cliente") {
					
					/* MANDAR POR CORREO LOS ARCHIVOS GENERADOS
					-------------------------------------------------- */
					//datos empresa
					$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"]);
					$clienteDirecto = ModelosEmpresas::mdlMostrarClientePorEmpresa($datos);
	
					// si existe un correo en la configuracion lo usa para enviar el correo
					if ($configuracion["correo_facturas"] !== NULL) {
						$correoEmisor = $configuracion["correo_facturas"];
					}else{
					// si no existe correo, usa el proporcionado por la empresa en su registro
						$correoEmisor = $clienteDirecto["email"];
					}
					//email variables
					$mailReceptor = $this -> emailReceptor;
					$mailEmisor = $correoEmisor;
	
					$to = $mailReceptor.",".$mailEmisor;
					$from = $mailEmisor; 
					$from_name = $this -> razonEmisor;
	
					//attachment files path array
					$files = array('../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.xml',
									'../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.png',
									'../../../plugins/facturacion/timbrados/PDF/'.$nombre_factura.'.pdf');
	
					$subject = $nombre_factura; 
					$message = '<h1>Facturación</h1>
								<p>Se han adjuntado los archivos de su factura, una en formato xml y otra en formato pdf</p>
								<p><b>Total adjuntos : </b>'.count($files).' adjuntos</p>';
	
					$remitente = $from_name." <".$from.">"; 
					$headers = "From: $remitente";
	
					// boundary
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	
					// headers for attachment
					$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
	
					// multipart boundary 
					$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
					"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
	
	
					if(count($files) > 0){
						for($i=0;$i<count($files);$i++){
							if(is_file($files[$i])){
								$message .= "--{$mime_boundary}\n";
								$fp =    @fopen($files[$i],"rb");
								$data =  @fread($fp,filesize($files[$i]));
								@fclose($fp);
								$data = chunk_split(base64_encode($data));
								$message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
								"Content-Description: ".basename($files[$i])."\n" .
								"Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
								"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
				
							}
						}
					}
	
					$message .= "--{$mime_boundary}--";
					$returnpath = "-f".$from;
	
					//send email
					$mail = @mail($to, $subject, $message, $headers, $returnpath); 
					
				
					/* End of MANDAR POR CORREO LOS ARCHIVOS GENERADOS
					-------------------------------------------------- */
	
	
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
	
				}else{
					/* MANDAR POR CORREO LOS ARCHIVOS GENERADOS
					-------------------------------------------------- */
					//datos empresa
					$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"]);
					$clienteDirecto = ModelosEmpresas::mdlMostrarClientePorEmpresa($datos);
	
					// si existe un correo en la configuracion lo usa para enviar el correo
					if ($configuracion["correo_facturas"] !== NULL) {
						$correoEmisor = $configuracion["correo_facturas"];
					}else{
					// si no existe correo, usa el proporcionado por la empresa en su registro
						$correoEmisor = $clienteDirecto["email"];
					}
					//email variables
					
					$mailEmisor = $correoEmisor;
					$mailReceptor = "";
	
					$to = $mailEmisor;
					$from = $mailEmisor;
					$from_name = $this -> razonEmisor;
	
					//attachment files path array
					$files = array('../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.xml',
									'../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.png',
									'../../../plugins/facturacion/timbrados/PDF/'.$nombre_factura.'.pdf');
					
					$subject = $nombre_factura; 
					$message = '<h1>Facturación</h1>
								<p>Se han adjuntado los archivos de su factura, una en formato xml y otra en formato pdf</p>
								<p><b>Total adjuntos : </b>'.count($files).' adjuntos</p>';
	
					$remitente = $from_name." <".$from.">"; 
					$headers = "From: $remitente";
	
					// boundary
					$semi_rand = md5(time()); 
					$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
	
					// headers for attachment
					$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
	
					// multipart boundary 
					$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
					"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
	
	
					if(count($files) > 0){
						for($i=0;$i<count($files);$i++){
							if(is_file($files[$i])){
								$message .= "--{$mime_boundary}\n";
								$fp =    @fopen($files[$i],"rb");
								$data =  @fread($fp,filesize($files[$i]));
								@fclose($fp);
								$data = chunk_split(base64_encode($data));
								$message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
								"Content-Description: ".basename($files[$i])."\n" .
								"Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
								"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
				
							}
						}
					}
	
					$message .= "--{$mime_boundary}--";
					$returnpath = "-f" . $from;
	
					//send email
					$mail = @mail($to, $subject, $message, $headers, $returnpath); 
					
				
					/* End of MANDAR POR CORREO LOS ARCHIVOS GENERADOS
					-------------------------------------------------- */
				}
	
				$folios = json_decode($this -> foliosFacturados, true);
	
				foreach ($folios as $key => $valueFolio) {
					
					/*==================================================================
					=            MODIFICACION DE PEDIDO SI YA FUE FACTURADO            =
					==================================================================*/				
					$tablaPedido = "cedis_ventas";
					$datosPedido = array("folio" => $valueFolio["folio"],
										"id_empresa" => $_SESSION["idEmpresa_dashboard"],
										"factura" => "Si");
	
					$respuestaPedido = ModeloVentasCedis::mdlModificacionFactura($tablaPedido, $datosPedido);
	
				}
	
	
				/*==================================================================
				=            CREAR REGISTRO DE FACTURA EN BASE DE DATOS            =
				==================================================================*/
				
				$datosFactura = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
										"serie" => $respuestaSerie["serie"],
										"folio" => $NoFolio,
										"nombre" => $nombre_factura,
										"zona" => "Cedis");	
	
				$respuestaRegistro = ModeloFacturacion::mdlCrearRegistroFactura($tablaFactura, $datosFactura);
	
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
	
	
			$res = ["modCantFacturas" => $respuesta,
					"nombreArchivo" => $nombre_factura,
					"rutas" => $files,
					"emisor" => $mailEmisor,
					"receptor" => $mailReceptor];
		}else{
			$res = ["modCantFacturas" => "sin timbres"];
		}


		echo json_encode($res);


		

	}

	/*=====  End of REALIZAR FACTURA XML,PDF  ======*/
}

/*=====================================================
=            AGRUPAR PEDIDOS SELECCIONADOS            =
=====================================================*/

if (isset($_POST["agrupacionFolios"])) {
	$agrupacion = new AjaxFacturacionVentasCedis();
	$agrupacion -> agrupacionFolios = $_POST["agrupacionFolios"];
	$agrupacion -> ajaxAgrupacionPedidos();
}

/*=====  End of AGRUPAR PEDIDOS SELECCIONADOS  ======*/

/*================================================
=            REALIZAR FACTURA XML,PDF            =
================================================*/

if (isset($_POST["razonEmisor"])) {
	$crearFactura = new AjaxFacturacionVentasCedis();
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