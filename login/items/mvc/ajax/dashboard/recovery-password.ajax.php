<?php

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.usuarios.php';
/* INFORMACION DE REMITENTE */

$nombre = "Twynco.store";
$correo = "password@twynco.store";
$destinatario = $_POST["emailRecovery"];

$tabla = "clientes_servicio_plataforma";
$item = "email";
$valor = $destinatario;
$respuesta = ModelosUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

if ($respuesta != false) {

  $asunto = "Solicitud cambio de contraseña"; 

  $cuerpo = '<html>
<body>
  <center> 
    <h1>Solicitud de cambio de contraseña</h1> 
    <hr>
  </center>

<main>
  <h2>Correo: '.$destinatario.'</h2>
  <a href="'.$GlobalUrl.'dashboard/index.php?ruta=login-password&&iusserd='.$respuesta['id_clienteDirecto'].'">Cambiar contraseña</a>
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

    echo json_encode("ok");

  }

}

?>