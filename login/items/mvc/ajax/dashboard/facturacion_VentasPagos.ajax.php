<?php
error_reporting(0);
session_start();
date_default_timezone_set('America/Mexico_City');

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.facturacion.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';
require_once '../../modelos/dashboard/modelo.empresas.php';
require_once '../../../plugins/facturacion/sdk2.php';

class AjaxFacturacionVentasPagos{

    /*=====================================================================
    =                   CREAR TABLA CON VENTAS A PAGOS                    =
    =====================================================================*/
    
    public $ventasMesMostrar;
    public function ajaxMostrarTablaVentas(){

        intval($ventasMostrar = $this -> ventasMesMostrar);
        intval($mesActual = Date("m"));

        // $ventasMostrar = $this -> ventasMesMostrar;
        // $mesActual = Date("m");

        if ($ventasMostrar == "0") {
            
            $consulta = "MONTH(cv.fecha) = ".$mesActual;

        }elseif ($ventasMostrar == "todas"){

            $consulta = $ventasMostrar;
        }else{
            $meses = $mesActual-$ventasMostrar;
            $consulta = "(MONTH(cv.fecha) <= ".$mesActual." && MONTH(cv.fecha) >= ".$meses.")";
            
        }

        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuesta = ModeloVentasCedis::mdlMostrarVentasPagosSinFacturar($empresa, $consulta);

        echo json_encode($respuesta);
        
    }
    
    /*============  End of CREAR TABLA CON VENTAS A PAGOS   =============*/


    /*========================================================================
    =                   AGRUPACION PRODUCTOS SELECCIONADOS                   =
    ========================================================================*/
    
    public $agruparProductosFact;
    public function ajaxAgrupacionProductos(){

        $consulta = "";
        $productos = json_decode($this -> agruparProductosFact, true);
        $arregloProducto = [];
        
        
        $empresa = $_SESSION["idEmpresa_dashboard"];
        foreach ($productos as $key => $value) {
            $consulta ="id_producto = '".$value["id_producto"]."'";
            $respuesta = ModeloVentasCedis::mdlMostrarAgrupacionProductos($consulta,$empresa);
            array_push($arregloProducto,["nombre" => $respuesta["nombre"],
                                         "piezas" => $value["piezas"],
                                         "precio" => $value["precio"],
                                        "codigo" => $respuesta["codigo"],
                                        "sat_clave_prod" => $respuesta["sat_clave_prod_serv"],
                                        "sat_clave_unidad" => $respuesta["sat_clave_unidad"],
                                        "id_producto" => $respuesta["id_producto"]]);
        }

        echo json_encode($arregloProducto);
    }
    
    
    /*============  End of AGRUPACION PRODUCTOS SELECCIONADOS  =============*/

    /*===============================================================
    =                   REALIZAR FACTURA XML, PDF                   =
    ===============================================================*/
    
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
	public $idesFacturados;
	public $totalFactura;
	public $subtotalFactura;
	public $ivaFactura;
	public $notasFactura;
	public $folioVentaPagos;

    public function ajaxRealizarFactura(){

        $tabla = "modulo_facturas_compras";
		$item = "";
		$valor = "";
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$timbres = ModeloFacturacion::mdlMostrarTimbresEmpresa($tabla,$item,$valor,$empresa);

		/*==========================================================================
		=                   VALIDAR QUE HAYA TIMBRES DISPONIBLES                   =
		==========================================================================*/
		
		if ($timbres["facturas_disponibles"] > 0) {
            
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

            /* SE ESPECIFICA LA VERSION DEL CFDi 3.3
            -------------------------------------------------- */
			$datos['version_cfdi'] = '3.3';
	
            /* RUTA DEL XML DEBUG
            -------------------------------------------------- */
			$datos['cfdi']='../../../plugins/facturacion/timbrados/xml/'.$nombre_factura.'.xml';
	
			/* RUTA DEL XML DEBUG
            -------------------------------------------------- */
			$datos['xml_debug']='../../../plugins/facturacion/timbrados_debug/'.$nombre_factura.'.xml';

            /* CREDENCIALES DE TIMBRADO
            -------------------------------------------------- */
			$datos['PAC']['usuario'] = 'DDM180518659';
			$datos['PAC']['pass'] = 'MULTIf0489472a2047ba7eeae3451646dd019!';
			$datos['PAC']['produccion'] = 'SI';
	
// 			$datos['PAC']['usuario'] = 'DEMO700101XXX';
// 			$datos['PAC']['pass'] = 'DEMO700101XXX';
// 			$datos['PAC']['produccion'] = 'NO';

            /* RUTAS Y CLAVES DE LOS CSD
            -------------------------------------------------- */

            // $datos['conf']['cer'] = '../../../plugins/facturacion/certificados/pruebasTwynco/EKU9003173C9.cer';
            // $datos['conf']['key'] = '../../../plugins/facturacion/certificados/pruebasTwynco/EKU9003173C9.key';
            // $datos['conf']['pass'] = '12345678a';

            $datos['conf']['cer'] = '../../../plugins/facturacion/certificados/pruebasTwynco/'.$configuracion["factura_cer"];
			$datos['conf']['key'] = '../../../plugins/facturacion/certificados/pruebasTwynco/'.$configuracion["factura_key"];
			$datos['conf']['pass'] = $configuracion["factura_password"];

            /* DATOS DE LA FACTURA
            -------------------------------------------------- */
			$datos['factura']['condicionesDePago'] = $this -> condicionPagoFactura;
	
			$datos['factura']['descuento'] = '0.00';
			$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);

            $datos['factura']['folio'] = $NoFolio;
	
			$datos['factura']['forma_pago'] = $this -> formaPagoFactura;
	
			$datos['factura']['LugarExpedicion'] = $configuracion["lugar_expedicion"];

			$datos['factura']['metodo_pago'] = $this -> metodoPagoFactura;
	

			$datos['factura']['moneda'] = 'MXN';
	
			$datos['factura']['serie'] = $respuestaSerie["serie"];
	
			$datos['factura']['subtotal'] = $this -> subtotalFactura;
	
			$datos['factura']['tipocambio'] = 1;
			$datos['factura']['tipocomprobante'] = 'I';
	
			$datos['factura']['total'] = $this -> totalFactura;
	
			$datos['factura']['RegimenFiscal'] = $this -> regimenFiscalEmisor;
	

            /* Datos del Emisor */

			$datos['emisor']['rfc'] = $configuracion["rfc"]; 
			$datos['emisor']['nombre'] = $configuracion["razon_social"]; 
	
            /* Datos del Receptor */

			// $datos['receptor']['rfc'] = 'XAXX010101000';
			// $datos['receptor']['nombre'] = 'Publico en General';
			// $datos['receptor']['UsoCFDI'] = 'G02';
	
			$datos['receptor']['rfc'] = $this -> rfcReceptor;
			$datos['receptor']['nombre'] = $this -> razonReceptor;
			$datos['receptor']['UsoCFDI'] = $this -> cfdiFactura;

            /* SE AGRUPAN LOS CONCEPTOS
            -------------------------------------------------- */
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

            /* SE AGREGAN LOS IMPUESTOS
            -------------------------------------------------- */

			$datos['impuestos']['translados'][0]['impuesto'] = '002';
			$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
			$datos['impuestos']['translados'][0]['importe'] = $this -> ivaFactura;
			$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';
			$datos['impuestos']['TotalImpuestosTrasladados'] = $this -> ivaFactura;

            /* SE EJECUTA EL SDK
            -------------------------------------------------- */
			$res = mf_genera_cfdi($datos);

			// DESCONTAR TIMBRES DE LA EMPRESA
			$msg = ["codigo" =>$res["codigo_mf_numero"], "text" => $res["codigo_mf_texto"]];
			if ($res["codigo_mf_numero"] == 0 || $res["codigo_mf_numero"] == 2) {

				$msg += ["timbre" => "Se gasto"];

				/*========================================================================
				=            MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES            =
				========================================================================*/
				
				$modCantTimbres = ModeloFacturacion::mdlEditarFacturasDisponibles($_SESSION["idEmpresa_dashboard"]);

				/*=====  End of MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES  ======*/

			}else{
				$msg += ["timbre" => "NO se gasto"];
			}

            /*============================================
			=             CONVERTIR XML A HTML           =
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

            $datosPDF['PAC']['usuario'] = 'DDM180518659';
			$datosPDF['PAC']['pass'] = 'MULTIf0489472a2047ba7eeae3451646dd019!';
			$datosPDF['PAC']['produccion'] = 'SI';
			
// 			$datosPDF['PAC']['usuario'] = 'DEMO700101XXX';
// 			$datosPDF['PAC']['pass'] = 'DEMO700101XXX';
// 			$datosPDF['PAC']['produccion'] = 'NO';
			
	
			$datosPDF['modulo']="html2pdf";
			$datosPDF['html']="$HTML";
			$datosPDF['archivo_html']="";
			$datosPDF['archivo_pdf']='../../../plugins/facturacion/timbrados/PDF/'.$nombre_factura.'.pdf';
			
			$resPDF = mf_ejecuta_modulo($datosPDF);

            if ($resPDF == "OK") {
			
               
                if ($this -> tipoFactura == "cliente") {
					/*================================================================
					=                   MANDAR FACTURAS POR CORREO                   =
					================================================================*/

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
					
					/*============  End of MANDAR FACTURAS POR CORREO   =============*/

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
                    }else{

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
					/*================================================================
					=                   MANDAR FACTURAS POR CORREO                   =
					================================================================*/
					
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
					
					/*============  End of MANDAR FACTURAS POR CORREO  =============*/
				}

                $ides = json_decode($this -> idesFacturados, true);

			    foreach ($ides as $key => $valueID) {
				
                    /*=====================================================================
                    =            MODIFICACION DEL PRODUCTO SI YA FUE FACTURADO            =
                    =====================================================================*/				
                    $tablaDetalle = "cedis_venta_detalles";
                    $datosDetalle = array("id" => $valueID,
                                        "factura" => "Si");

                    $respuestaPedido = ModeloVentasCedis::mdlModificacionProductoFacturado($tablaDetalle, $datosDetalle);

			    }

				/*========================================================================================================
				=                   SI TODOS LOS PRODUCTOS FUERON FACTURADOS CAMBIAR ESTADO DEL PEDIDO                   =
				========================================================================================================*/
				
				/* CONTAR PRODUCTOS SIN FACTURAR
				-------------------------------------------------- */
				$tablaVentaDetalle = "cedis_venta_detalles";
				$datos = ["id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"folio" => $this -> folioVentaPagos,
							"estadoFactura" => 'No'];
				
				$respuestaContar = ModeloVentasCedis::mdlContarProductosFacturados($tablaVentaDetalle,$datos);

				/* SI HAY 0 PRODUCTOS SIN FACTURAR CAMBIA EL ESTADO DE LA VENTA GENERAL
				-------------------------------------------------- */
				
				if ($respuestaContar == 0) {
					$tablaPedido = "cedis_ventas";
					$datosPedido = array("folio" => $this -> folioVentaPagos,
										"id_empresa" => $_SESSION["idEmpresa_dashboard"],
										"factura" => "Si");
	
					$respuestaPedido = ModeloVentasCedis::mdlModificacionFactura($tablaPedido, $datosPedido);
				}

				
				
				/*============  End of SI TODOS LOS PRODUCTOS FUERON FACTURADOS CAMBIAR ESTADO DEL PEDIDO  =============*/

                /*==================================================================
				=            CREAR REGISTRO DE FACTURA EN BASE DE DATOS            =
				==================================================================*/
				$tablaFactura = "modulo_facturas";
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
	
	
					// /*========================================================================
					// =            MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES            =
					// ========================================================================*/
					
					// $respuesta = ModeloFacturacion::mdlEditarFacturasDisponibles($_SESSION["idEmpresa_dashboard"]);
	
					
					// /*=====  End of MODIFICACION DE CANTIDAD DE FACTURAS DISPONIBLES  ======*/
					
	
				}
            }

            
			$res = ["modCantFacturas" => $modCantTimbres,
					"nombreArchivo" => $nombre_factura,
					"rutas" => $files,
					"correoEmp" => $correoEmpresa,
					"receptor" => $mailReceptor,
					"SDKres" => $msg,
					"productosRestantes" => $respuestaContar];

        }else{
            $res = ["modCantFacturas" => "sin timbres"];
        }

		echo json_encode($res);
    }
    
    /*============  End of REALIZAR FACTURA XML, PDF  =============*/
    
}

/*=====================================================================
=                   CREAR TABLA CON VENTAS A PAGOS                    =
=====================================================================*/

if (isset($_POST["ventasMesMostrar"])) {
    $mostrar = new AjaxFacturacionVentasPagos();
    $mostrar -> ventasMesMostrar = $_POST["ventasMesMostrar"];
    $mostrar -> ajaxMostrarTablaVentas();
}

/*=====================================================================
=                   AGRUPAR PRODUCTOS SELECCIONADOS                    =
=====================================================================*/

if (isset($_POST["agruparProductosFact"])) {
	$agrupacion = new AjaxFacturacionVentasPagos();
	$agrupacion -> agruparProductosFact = $_POST["agruparProductosFact"];
	$agrupacion -> ajaxAgrupacionProductos();
}

/*===============================================================
=                   REALIZAR FACTURA XML, PDF                   =
===============================================================*/
    
if (isset($_POST["razonEmisor"])) {
	$crearFactura = new AjaxFacturacionVentasPagos();
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
	$crearFactura -> idesFacturados = $_POST["idesFacturados"];
	$crearFactura -> totalFactura = $_POST["totalFactura"];
	$crearFactura -> subtotalFactura = $_POST["subtotalFactura"];
	$crearFactura -> ivaFactura = $_POST["ivaFactura"];
	$crearFactura -> notasFactura = $_POST["notasFactura"];
	$crearFactura -> folioVentaPagos = $_POST["folioVentaPagos"];
	$crearFactura -> ajaxRealizarFactura();
}    