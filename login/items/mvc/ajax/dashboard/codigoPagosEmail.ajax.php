<?php
session_start();
 require_once '../../modelos/conexion.php';
 require_once '../../modelos/dashboard/modelo.empresas.php';

if (isset($_POST["CreacionCodigoVerificacion"])) {
	$codigo = $_POST["CreacionCodigoVerificacion"];

	$tabla = "empresas";
	$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
					"codigoVerificacionPagos" => $codigo);
					

	$respuesta = ModelosEmpresas::mdlGuardarCodigoVerificacionPago($tabla, $datos);
	/* SOLICITAR INFORMACION DEL CLIENTE DIRECTO */
	// $datosEmpresa = array("id_empresa" => $_SESSION["idEmpresa_dashboard"]);
	$correoEmpresa = ModelosEmpresas::mdlMostrarClientePorEmpresa($datos);
	/* CONDICION DE CODIGO DE VERIFICACION SÍ GUARDO */
	
	// if ($respuesta == "ok") {
		// /* CODIGO DE MANDAR CORREO */
		
	$nombre = "yira.com.mx";
	$correo = "settings@yira.com.mx";
	$destinatario = $correoEmpresa["email"];
	//$destinatario = "ing.jorge.cardoso@gmail.com"; 

	$asunto = "Codigo de verificación"; 
	$cuerpo = ' 
	<html>
	<body>
	<center> 
		<h1>Solicitud de cambio de datos en Formas de pago</h1> 
		<hr>
	</center>

	<main>
	<h2>Su codigo de verificaion es: '.$codigo.'</h2>
	</main>
	</body> 
	</html>'; 

	//para el envío en formato HTML 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; 

	//dirección del remitente 
	$headers .= "From: ".$nombre." <".$correo.">\r\n"; 
	// mail($destinatario,$asunto,$cuerpo,$headers)
	if(mail($destinatario,$asunto,$cuerpo,$headers)){

	echo json_encode("Exito");

	}else{

	echo json_encode("Error");
	
	}


}

if (isset($_POST["MostrarCodigoVerificacion"])) {
	
	$tabla = "empresas";
	$empresa = $_SESSION["idEmpresa_dashboard"];
	$respuesta = ModelosEmpresas::mdlMostrarCodigoVerificacionPago($tabla,$empresa);

	echo json_encode($respuesta);
}
?>