<?php
session_start();
date_default_timezone_set('America/Mexico_City');

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.facturacion.php';


	$archivoCer = $_FILES["fileCERConfiguracionFactura"];
	if ($archivoCer["name"] != "") {

		$nombreCer = $archivoCer["name"];
		$rutaCer = "../../../plugins/facturacion/certificados/pruebasTwynco/".$nombreCer;
		move_uploaded_file($archivoCer["tmp_name"], $rutaCer);

	}
		

	$archivoKey = $_FILES["fileKEYConfiguracionFactura"];
	if ($archivoKey["name"] != "") {

		$nombreKey = $archivoKey["name"];
		$rutaKey = "../../../plugins/facturacion/certificados/pruebasTwynco/".$nombreKey;
		move_uploaded_file($archivoKey["tmp_name"], $rutaKey);

	}


	$archivoLogo = $_FILES["fileLogoFactura"];
	if ($archivoLogo["name"] != "") {
		//elimina archivos actuales
		if (file_exists("../../../img/facturas_empresa/".$_SESSION["idEmpresa_dashboard"]."_logoFactura.jpeg")) {

			unlink("../../../img/facturas_empresa/".$_SESSION["idEmpresa_dashboard"]."_logoFactura.jpeg");

				
			
		}else if(file_exists("../../../img/facturas_empresa/".$_SESSION["idEmpresa_dashboard"]."_logoFactura.png")){
			unlink("../../../img/facturas_empresa/".$_SESSION["idEmpresa_dashboard"]."_logoFactura.png");
				$respuesta = "se elimino png";
			
		}
		
		$nombreLogo = metadatosImg($archivoLogo);

	} else {

		if (file_exists("../../../img/facturas_empresa/".$_SESSION["idEmpresa_dashboard"]."_logoFactura.jpeg")) {

			$nombreLogo = $_SESSION["idEmpresa_dashboard"]."_logoFactura.jpeg";

		} else if (file_exists("../../../img/facturas_empresa/".$_SESSION["idEmpresa_dashboard"]."_logoFactura.png")){

			$nombreLogo = $_SESSION["idEmpresa_dashboard"]."_logoFactura.png";

		} else {

			$nombreLogo = NULL;
		}

		$nombreLogo;

		
	}

	//OBTENER METADATOS DE LA IMAGEN
	function metadatosImg($archivoLogo){
		//obteniendo nombre de archivo
		$filename = $_FILES['fileLogoFactura']['name'];
				
		//extensiones validas 
		$valid_ext = array('png','jpeg','jpg');

		$typeImage = explode("/", $archivoLogo["type"]);
		$nombreLogo = $_SESSION["idEmpresa_dashboard"]."_logoFactura.".$typeImage[1];
		$rutaLogo = "../../../img/facturas_empresa/".$nombreLogo;

		//obtener extension del archivo
		$file_extension = pathinfo($rutaLogo, PATHINFO_EXTENSION);
		$file_extension = strtolower($file_extension); // convierte a minusculas el primer caracter de cada palabra 

		// validar la extension del archivo subido
		if (in_array($file_extension,$valid_ext)) {
			//comprimir la imagen
			//la funcion recibe la imagen, ruta destino y la calidad de la imagen del 1 al 100
			comprimeImagen($_FILES['fileLogoFactura']['tmp_name'], $rutaLogo,10);
		}

		return $nombreLogo;

	}


	//COMPRIMIR IMAGEN 
    function comprimeImagen($imagen, $ruta_destino, $calidad){
        $info = getimagesize($imagen);
        
        // VERIFICAMOS QUE SEAN LOS FORMATOS PERMITIDOS
        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($imagen);
        }elseif ($info['mime'] == 'image/jpg'){
            $image = imagecreatefromjpeg($imagen);

        }elseif ($info['mime'] == 'image/png'){
            $image = imagecreatefrompng($imagen);
        }

        imagejpeg($image, $ruta_destino, $calidad);
    }
	
	
	/*===========================================================
	=            MOSTRAR EXISTENCIA DE CONFIGURACION            =
	===========================================================*/
	
	/* S E  C O M E N T O  T O D O  E S T O
	-------------------------------------------------- */
	

	$tabla = "modulo_facturas_configuracion";
	$item = NULL;
	$valor = NULL;
	$empresa = $_SESSION["idEmpresa_dashboard"];
	$respuestaExistencia = ModeloFacturacion::mdlMostrarConfiguracion($tabla, $item, $valor, $empresa);

	if ($respuestaExistencia == false) {

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"logo" => $nombreLogo,
						"rfc" => $_POST["inputRFCConfiguracionFactura"],
						"razon_social" => $_POST["inputRazonConfiguracionFactura"],
						"factura_cer" => $nombreCer,
						"factura_key" => $nombreKey,
						"factura_password" => $_POST["inputPassConfiguracionFactura"],
						"lugar_expedicion" => $_POST["inputPostalConfiguracionFactura"],
						"color_marco" => $_POST["inputColorMarcoConfiguracionFactura"],
						"color_marco_texto" => $_POST["inputColorTxtMarcoConfiguracionFactura"],
						"color_texto" => $_POST["inputColorTxtConfiguracionFactura"],
						"correo_facturas" => $_POST["inputCorreoConfiguracionFactura"]);

		$respuesta = ModeloFacturacion::mdlCrearConfiguracionFacturacion($tabla, $datos);
	
	} else {

		if ($archivoCer["name"] == "") {

			$nombreCer = $respuestaExistencia["factura_cer"];
			
		}

		if ($archivoKey["name"] == "") {

			$nombreKey = $respuestaExistencia["factura_key"];

		}


		$datos = array("id_modulo_facturas_configuracion" => $respuestaExistencia["id_modulo_facturas_configuracion"],
						"logo" => $nombreLogo,
						"rfc" => $_POST["inputRFCConfiguracionFactura"],
						"razon_social" => $_POST["inputRazonConfiguracionFactura"],
						"factura_cer" => $nombreCer,
						"factura_key" => $nombreKey,
						"factura_password" => $_POST["inputPassConfiguracionFactura"],
						"lugar_expedicion" => $_POST["inputPostalConfiguracionFactura"],
						"color_marco" => $_POST["inputColorMarcoConfiguracionFactura"],
						"color_marco_texto" => $_POST["inputColorTxtMarcoConfiguracionFactura"],
						"color_texto" => $_POST["inputColorTxtConfiguracionFactura"],
						"correo_facturas" => $_POST["inputCorreoConfiguracionFactura"]);

		$respuesta = ModeloFacturacion::mdlEditarConfiguracionFacturacion($tabla, $datos);

	}

	echo json_encode($respuesta);

?>