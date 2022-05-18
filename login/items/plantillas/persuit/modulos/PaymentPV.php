<?php

if (!isset($_GET["collection_id"]) || !isset($_GET["collection_status"])) {
        header("Location:inicio");
}else{

    // echo $empresa["id_empresa"];
	/* VARIABLES DE CARRITO DE COMPRAS */
	$tablaPedidos = "pedidos";
	// $estado_pedido = "Aprobado";
	// $estado_entrega = "En preparación";
    // $metodo_pago = "Tarjeta";

    // NUEVAS VARIABLES 
    date_default_timezone_set('America/Mexico_City');
    
    $tablaPedidos = "cedis_ventas";
	$estado_pedido = "En preparacion";
	$fecha_aprobacion = date("Y-m-d H:i:s");
    $folio = $_GET["folio"];

    $datosPedidos = array("id_empresa" => $empresa["id_empresa"],
                        "folio" => $_GET["folio"],
                        "fecha_aprobacion" => $fecha_aprobacion,
                        "comprobante" => "TD-TC",
                        "estado" => $estado_pedido,
                        "pago_tarjeta" => "true");

    $respuestaPedido = ModeloVentasCedis::mdlActualizarComprobanteLink($tablaPedidos, $datosPedidos);


    // $tablaEPedidos = "pedidos_entregas";
    // $datosEPedido = array("id_empresa" => $empresa["id_empresa"],
    //                       "folio" => $folio,
    //                       "estado_entrega" => $estado_entrega);

    // $respuestaEntrega = ModeloPedidos::mdlCambioEstadoEntrega($tablaEPedidos, $datosEPedido);

	
	include 'fix/header.php';
?>


<!--================Categories Banner Area =================-->
<section class="solid_banner_area">
    <div class="container">
        <div class="solid_banner_inner">
            <h3>ESTATUS PAGO</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="#">Estado</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->
<!--================login Area =================-->
<section class="emty_cart_area p_100">

    <?php

    if ($respuestaPedido == "ok") {
    ?>                  
            
        <div class="container">
            <div class="emty_cart_inner">
                <i class="icon_check_alt icons"></i>
                <h3>Pedido finalizado!</h3>
                <h4>volver a <a href="inicio">Inicio</a></h4>
            </div>
        </div>
        <br>
        <!-- <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Anotaciones:</span>
                            <textarea  class="form-control input-lg" id="AnotacionPedido"  placeholder="Escribe anotaciones sobre tu pedido"></textarea>
                            <input type="hidden" class="folioAnotacionPedido" value="<?php echo $folio ?>">
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <button class="btn btn-primary btn-block btnGuardarAnotaciones">Agregar</button>
                </div>
            </div>
        </div> -->
    <?php
        }
    ?>
</section>
<!--================End login Area =================-->

<?php
	include 'fix/footer.php';

}
?>