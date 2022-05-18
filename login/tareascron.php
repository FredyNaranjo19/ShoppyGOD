<?php
require_once 'items/mvc/controladores/dashboard/controlador.tareascron.php';
require_once 'items/mvc/modelos/dashboard/modelo.tareascron.php';
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d");
$fecha_ayer = date("Y-m-d",strtotime($fecha_actual."- 1 days"));
//==================================================DESHABILITAR VENTAS A PAGOS VENCIDAS====================
$existenciaPaquete = ControladorPcron::ctrlpcron($fecha_ayer);
//var_dump($fecha_ayer);
foreach ($existenciaPaquete as $key => $value) {
	//echo "<script>console.log(".$value[0].")</script>";
	$idcreditosp=$value[2] ;
	$idempresa=$value[1] ;
	$id_creditos_compras=$value[0] ;
	$respuesta = ControladorPcron::ctrlcostopaquetepagos($idcreditosp);
	$cantidad=$respuesta[0];
	ControladorPcron::ctrleditarcontenidosistemaventaspagos($idempresa,$cantidad);
	ControladorPcron::ctrldesactiv($id_creditos_compras);
	//echo "<script>console.log(".$cantidad.")</script>";
}
//==================================================DESHABILITAR ALMACENES VENCIDOS====================
$existenciaPaquete = ControladorPcron::ctrlpcronalmacenes($fecha_ayer);
foreach ($existenciaPaquete as $key => $value) {
	//echo "<script>console.log(".$value[0].")</script>";
	$id_almacen_compras=$value[0] ;
	ControladorPcron::ctrldesactivalmacen($id_almacen_compras);
}

//==================================================DESHABILITAR USUARIOS VENCIDOS====================
$existenciaPaquete = ControladorPcron::ctrlpcronusuarios($fecha_ayer);
foreach ($existenciaPaquete as $key => $value) {
	//echo "<script>console.log(".$value[0].")</script>";
	$id_usuarios_plataforma_compras=$value[0] ;
	ControladorPcron::ctrldesactivusuario($id_usuarios_plataforma_compras);
}
//==================================================DESHABILITAR ESPACIOS PRODUCTOS TIENDA VIRTUAL VENCIDOS====================
$existenciaPaquete = ControladorPcron::ctrlmostrarespaciosTV($fecha_ayer);
//var_dump($fecha_ayer);
foreach ($existenciaPaquete as $key => $value) {
	$idtvproductp=$value[2] ;
	$idempresa=$value[1] ;
	$id_tv_productos_compras=$value[0] ;
	$respuesta = ControladorPcron::ctrlcostopaqueteTV($idtvproductp);
	$cantidad=$respuesta[0];
	ControladorPcron::ctrleditarcontenidosistemaproductostv($idempresa,$cantidad);
	ControladorPcron::ctrldesactivproductostv($id_tv_productos_compras);
	//echo "<script>console.log(".$cantidad.")</script>";
}

?>
