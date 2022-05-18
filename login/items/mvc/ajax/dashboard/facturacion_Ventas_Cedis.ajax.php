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
	public $tipoComprobante;

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
	
			// $datos['PAC']['usuario'] = 'DEMO700101XXX';
			// $datos['PAC']['pass'] = 'DEMO700101XXX';
			// $datos['PAC']['produccion'] = 'NO';
	
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
			$datos['factura']['tipocomprobante'] = $this -> tipoComprobante;
	
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
				
				switch ($value["claveUnidad"]) {
					case 'H87':
						$datos['conceptos'][$key]['unidad'] = 'Pieza';
						break;
					
					case 'EA':
						$datos['conceptos'][$key]['unidad'] = 'Elemento';
						break;
					
					case 'E48':
						$datos['conceptos'][$key]['unidad'] = 'Unidad de Servicio';
						break;
					
					case 'ACT':
						$datos['conceptos'][$key]['unidad'] = 'Actividad';
						break;
					
					case 'KGM':
						$datos['conceptos'][$key]['unidad'] = 'Kilogramo';
						break;
					
					case 'E51':
						$datos['conceptos'][$key]['unidad'] = 'Trabajo';
						break;
					
					case 'A9':
						$datos['conceptos'][$key]['unidad'] = 'Tarifa';
						break;
					
					case 'MTR':
						$datos['conceptos'][$key]['unidad'] = 'Metro';
						break;
					
					case 'AB':
						$datos['conceptos'][$key]['unidad'] = 'Paquete a granel';
						break;
					
					case 'BB':
						$datos['conceptos'][$key]['unidad'] = 'Caja base';
						break;
					
					case 'KT':
						$datos['conceptos'][$key]['unidad'] = 'Kit';
						break;
					
					case 'SET':
						$datos['conceptos'][$key]['unidad'] = 'Conjunto';
						break;
					
					case 'LTR':
						$datos['conceptos'][$key]['unidad'] = 'Litro';
						break;
					
					case 'XBX':
						$datos['conceptos'][$key]['unidad'] = 'Caja';
						break;
					
					case 'MON':
						$datos['conceptos'][$key]['unidad'] = 'Mes';
						break;
					
					case 'HUR':
						$datos['conceptos'][$key]['unidad'] = 'Hora';
						break;
					
					case 'MTK':
						$datos['conceptos'][$key]['unidad'] = 'Metro cuadrado';
						break;
					
					case '11':
						$datos['conceptos'][$key]['unidad'] = 'Equipos';
						break;
					
					case 'MGM':
						$datos['conceptos'][$key]['unidad'] = 'Miligramo';
						break;
					
					case 'XPK':
						$datos['conceptos'][$key]['unidad'] = 'Paquete';
						break;
					
					case 'XKI':
						$datos['conceptos'][$key]['unidad'] = 'Kit (Conjunto de piezas)';
						break;
					
					case 'AS':
						$datos['conceptos'][$key]['unidad'] = 'Variedad';
						break;
					
					case 'GRM':
						$datos['conceptos'][$key]['unidad'] = 'Gramo';
						break;
					
					case 'PR':
						$datos['conceptos'][$key]['unidad'] = 'Par';
						break;
					
					case 'DPC':
						$datos['conceptos'][$key]['unidad'] = 'Docenas de piezas';
						break;
					
					case 'xun':
						$datos['conceptos'][$key]['unidad'] = 'Unidad';
						break;
					
					case 'DAY':
						$datos['conceptos'][$key]['unidad'] = 'D��a';
						break;
					
					case 'XLT':
						$datos['conceptos'][$key]['unidad'] = 'Lote';
						break;
					
					case '10':
						$datos['conceptos'][$key]['unidad'] = 'Grupos';
						break;
					
					case 'MLT':
						$datos['conceptos'][$key]['unidad'] = 'Mililitro';
						break;
					
					case 'E54':
						$datos['conceptos'][$key]['unidad'] = 'Viaje';
						break;
					default:
						$datos['conceptos'][$key]['unidad'] = 'NA';
						break;
				}
				
				// $datos['conceptos'][$key]['unidad'] = 'NA';
				$datos['conceptos'][$key]['ID'] = $value["id"];//"1726";
				$datos['conceptos'][$key]['descripcion'] = $value["modelo"]." / ".$value["descripcion"];
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

			// DESCONTAR TIMBRES DE LA EMPRESA Y VALIDAR EJECUCION SDK
			$msg = ["codigo" =>$res["codigo_mf_numero"], "text" => $res["codigo_mf_texto"]];

			if ($res["codigo_mf_numero"] == 0 ) {
				$msg += ["timbre" => "Se gasto"];

				/*========================================================================
				=            MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES            =
				========================================================================*/
				
				$modCantTimbres = ModeloFacturacion::mdlEditarFacturasDisponibles($_SESSION["idEmpresa_dashboard"]);

				/*=====  End of MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES  ======*/

				/*============================================
				=            CONVERTIR XML A HTML          =
				============================================*/
				
				$datosHTML['modulo']= "cfdi2html";
				$datosHTML['rutaxml']= '../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.xml';
				$datosHTML['titulo']= $this -> tituloFactura;//"Factura pdf prueba";
				$datosHTML['tipo']= "FACTURA [".$this -> tipoComprobante."]";
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
				
				// $datosPDF['PAC']['usuario'] = 'DEMO700101XXX';
				// $datosPDF['PAC']['pass'] = 'DEMO700101XXX';
				// $datosPDF['PAC']['produccion'] = 'NO';
				
		
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
							$correoEmpresa = $configuracion["correo_facturas"];
						}else{
						// si no existe correo, usa el proporcionado por la empresa en su registro
							$correoEmpresa = $clienteDirecto["email"];
						}
						//email variables
						$mailReceptor = $this -> emailReceptor;
		
						$from = 'yirafacturas@yira.com.mx'; 
						$to = $mailReceptor.",".$correoEmpresa;
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
						$mail = mail($to, $subject, $message, $headers, $returnpath); 
						
					
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
							$correoEmpresa = $configuracion["correo_facturas"];
						}else{
						// si no existe correo, usa el proporcionado por la empresa en su registro
							$correoEmpresa = $clienteDirecto["email"];
						}
						//email variables
						
						$mailReceptor = "";
		
						$from = 'yirafacturas@yira.com.mx';
						$to = $correoEmpresa;
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
						$mail = mail($to, $subject, $message, $headers, $returnpath); 
						
					
						/* End of MANDAR POR CORREO LOS ARCHIVOS GENERADOS
						-------------------------------------------------- */
					}
		
					$folios = json_decode($this -> foliosFacturados, true);
					$foliosGuardar = [];
					foreach ($folios as $key => $valueFolio) {
						array_push($foliosGuardar,$valueFolio["folio"]);
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
											"zona" => "Cedis",
											"folios" => json_encode($foliosGuardar),
											"estado" => "realizada"
											);	
		
					$respuestaRegistro = ModeloFacturacion::mdlCrearRegistroFactura($tablaFactura, $datosFactura);
		
					if ($respuestaRegistro == "ok") {
						
						/*===============================================================================
						=            MODIFICACION DE NUEMERO DE FOLIO EN LA SERIE DE FACTURA            =
						===============================================================================*/
						$datosSerie = array("id_modulo_facturas_series" => $this -> serieFactura,
											"no_folios" => $folioSerie);
		
						$modificacionSerieFolio = ModeloFacturacion::mdlEditarSerieFolioFactura($tablaSerie, $datosSerie);
		
					}
				}
	
	
				$respuesta = ["modCantFacturas" => $modCantTimbres,
						"nombreArchivo" => $nombre_factura,
						"rutas" => $files,
						"correoEmp" => $correoEmpresa,
						"receptor" => $mailReceptor,
						"SDKres" => $msg];

			}else if ($res["codigo_mf_numero"] == 2) {
				// $msg += ["timbre" => "Se gasto"];

				/*========================================================================
				=            MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES            =
				========================================================================*/
				
				$modCantTimbres = ModeloFacturacion::mdlEditarFacturasDisponibles($_SESSION["idEmpresa_dashboard"]);

				/*=====  End of MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES  ======*/

				$respuesta = $res;
			}else{
				// $msg += ["timbre" => "NO se gasto"];

				$respuesta = $res;
			}
			
		}else{
			$respuesta = ["modCantFacturas" => "sin timbres"];
		}


		echo json_encode($respuesta);


		

	}
	
	/*=====  End of REALIZAR FACTURA XML,PDF  ======*/
	
	/*=======================================================
	=            MOSTRAR FACTURAS SEGUN FILTRADO            =
	=======================================================*/
	
	public $opcionBusqueda;
	public $fecha1Buscar;
	public $fecha2Buscar;
	public $serieBuscar;
	public $folioBuscar;
	public $inputBuscar;
	public function ajaxMostrarFacturas(){

		$campo = $this -> opcionBusqueda;

		//CREANDO ARREGLO SEGUN EL CAMPO A BUSCAR
		if ($campo == "fecha") {
			$fecha1 = $this -> fecha1Buscar;
			$fecha2 = $this -> fecha2Buscar;

			$datos = ["campo" => $campo, "fecha1" => $fecha1, "fecha2" => $fecha2];
		}else if ($campo == "serie" || $campo == "folio") {
			$inputBuscar = $this -> inputBuscar;

			$datos = ["campo" => $campo, "busqueda" => $inputBuscar];
		}else if($campo == "serie_folio"){
			$serie = $this -> serieBuscar;
			$folio = $this -> folioBuscar;

			$datos = ["campo" => $campo, "serie" => $serie, "folio" => $folio];
		}else{
			$datos = ["campo" => $campo];
		}

		//CONSULTA PARA MOSTRAR FACTURAS 

		$tabla = "modulo_facturas";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$respuesta = ModeloFacturacion::mdlMostrarFacturasFiltradas($datos, $tabla, $empresa);

		// $respuesta = ["datos" => $datos, "resp" => $respuesta];
		echo json_encode($respuesta);
	}

	/*=====  End of MOSTRAR FACTURAS SEGUN FILTRADO  ======*/
	
	/*========================================
	=            CANCELAR FACTURA            =
	========================================*/
	
	public $cancelacionFactura; 
	public $motivoCancelacionFactura; 
	public $cancelacionFoliosFactura; 
	public $cancelacionIdFactura; 
	public function ajaxCancelarFactura(){

		$tabla = "modulo_facturas_configuracion";
		$item = NULL;
		$valor = NULL;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$configuracion = ModeloFacturacion::mdlMostrarConfiguracion($tabla, $item, $valor, $empresa);

		//PRUEBAS
		// $datos['PAC']['usuario'] = "DEMO700101XXX";
		// $datos['PAC']['pass'] = "DEMO700101XXX";
		// $datos["produccion"]= "NO";
		
		//PRODUCCION
		$datos['PAC']['usuario'] = "DDM180518659";
		$datos['PAC']['pass'] = "MULTIf0489472a2047ba7eeae3451646dd019!";
		$datos["produccion"]= "SI"; 
		
		$datos['modulo']= "cancelacion2022"; 
		$datos['accion']= "cancelar";                                                  
		$datos["motivo"]=$this -> motivoCancelacionFactura;
		$datos["xml"]= "../../../plugins/facturacion/timbrados/xml/".$this -> cancelacionFactura.".xml";
 
		$datos["rfc"] = $configuracion['rfc'];//"EKU9003173C9"; //"LAN7008173R5";
		$datos["password"]= $configuracion['factura_password'];//"12345678a";

		//PRUEBAS
		// $datos["rfc"] ="EKU9003173C9";
		// $datos["password"]="12345678a";

		//PRODUCCION
		$datos["b64Cer"]= '../../../plugins/facturacion/certificados/pruebasTwynco/'.$configuracion['factura_cer'];
		$datos["b64Key"]= '../../../plugins/facturacion/certificados/pruebasTwynco/'.$configuracion['factura_key'];


		$res = mf_ejecuta_modulo($datos);

		if ($res["status"] == "success") {
			//CAMBIAR ESTADO DE LA FACTURA A CANCELADA
			$empresa = $_SESSION["idEmpresa_dashboard"];
			$datos = ["estado" => "cancelada", "id" => $this -> cancelacionIdFactura];
			$cambiarEstadoFactura = ModeloFacturacion::mdlEditarEstadoFactura($empresa, $datos);

			// MODIFICACION DE VENTA SI FUE CANCELADA
			
			if ($this -> cancelacionFoliosFactura != null ) {
				$folios = json_decode($this -> cancelacionFoliosFactura);
				$tablaPedido = "cedis_ventas";
				foreach ($folios as $key => $valueFolio) {
				
					$datosPedido = array("folio" => $valueFolio,
										"id_empresa" => $_SESSION["idEmpresa_dashboard"],
										"factura" => "No");

					$respuestaPedido = ModeloVentasCedis::mdlModificacionFactura($tablaPedido, $datosPedido);

				}
			}
		}
		
		echo json_encode($res);
	}
	
	/*=====  End of CANCELAR FACTURA  ======*/
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
	$crearFactura -> tipoComprobante = $_POST["tipoComprobante"];
	$crearFactura -> ajaxRealizarFactura();
}

/*=====  End of REALIZAR FACTURA XML,PDF  ======*/

/*=======================================================
=            MOSTRAR FACTURAS SEGUN FILTRADO            =
=======================================================*/

if (isset($_POST["opcionBusqueda"])) {
	$mostrarFacturas = new AjaxFacturacionVentasCedis();
	$mostrarFacturas -> opcionBusqueda = $_POST["opcionBusqueda"];
	$mostrarFacturas -> fecha1Buscar = $_POST["fecha1Buscar"];
	$mostrarFacturas -> fecha2Buscar = $_POST["fecha2Buscar"];
	$mostrarFacturas -> serieBuscar = $_POST["serieBuscar"];
	$mostrarFacturas -> folioBuscar = $_POST["folioBuscar"];
	$mostrarFacturas -> inputBuscar = $_POST["inputBuscar"];
	$mostrarFacturas -> ajaxMostrarFacturas();
}

/*=====  End of MOSTRAR FACTURAS SEGUN FILTRADO  ======*/

/*========================================
=            CANCELAR FACTURA            =
========================================*/

if (isset($_POST["cancelacionFactura"])) {
	$cancelarFactura = new AjaxFacturacionVentasCedis();
	$cancelarFactura -> cancelacionFactura = $_POST["cancelacionFactura"];
	$cancelarFactura -> cancelacionIdFactura = $_POST["cancelacionIdFactura"];
	$cancelarFactura -> cancelacionFoliosFactura = $_POST["cancelacionFoliosFactura"];
	$cancelarFactura -> motivoCancelacionFactura = $_POST["motivoCancelacionFactura"];
	$cancelarFactura -> ajaxCancelarFactura();
}

/*=====  End of CANCELAR FACTURA  ======*/
?>