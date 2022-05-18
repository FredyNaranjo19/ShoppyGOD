<?php
if (!isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] != "ok"){

    header("Location:login");

}else{

    $folio = $_GET["folio"];
	// /* VARIABLES DE CARRITO DE COMPRAS */
	// $tablaPedidos = "pedidos";
	// $folio = $_SESSION["id"]."-".rand(100, 1000000);
	// $metodoPago = "Tarjeta";
	// $formsVenta = "SV";
	// $estado_pedido = "Aprobado";
	// $estado_entrega = "En preparación";
	// $cliente = $_SESSION["id"];

	// $separacion = explode("-", $_GET["dir"]);

 //    if ($separacion[0] == "suc") {

 //        $tipo_entrega = "Sucursal";
 //        $sucursal = $separacion[1];
 //        $domicilio = NULL;

 //    } else {

 //        $tipo_entrega = "Envio";
 //        $sucursal = NULL;
 //        $domicilio = $separacion[1];

 //    }

 //    $datosPedido = array("id_empresa" => $empresa["id_empresa"],
 //    					 "folio" => $folio,
	// 					 "id_cliente" => $cliente,
	// 					 "metodo_pago" => $metodoPago,
	// 					 "total" => $separacion[2],
	// 					 "forma_venta" => $formsVenta,
	// 					 "estado" => $estado_pedido);

 //    $tablaEPedidos = "pedidos_entregas";

	// $datosEPedido = array("id_empresa" => $empresa["id_empresa"],
	// 						"folio" => $folio,
	// 						"tipo_entrega" => $tipo_entrega,
	// 						"sucursal" => $sucursal,
	// 						"estado_entrega" => $estado_entrega,
	// 						"id_domicilio" => $domicilio);

	// $tabla = "carrito"; 
	// $item = "id_cliente";

	// $resultadoAgrupado = ModeloCarrito::mdlMostrarCarritoAgrupado($tabla,$item,$cliente);
	// foreach ($resultadoAgrupado as $key => $agrupado) {
	// 	$item2 = "sku";
 //        $valor2 = $agrupado[0];

 //        $resultado = ModeloCarrito::mdlMostrarCarrito($tabla,$item,$cliente,$item2,$valor2);
 //        foreach ($resultado as $key => $value) {
 //            $itemPrecio = "sku";
 //            $valorPrecio = $agrupado[0];
 //            $preciosResultado = ControladorProductos::ctrMostrarPreciosProducto($itemPrecio,$valorPrecio);
 //            $costoProducto = 0;

 //            foreach ($preciosResultado as $key => $precio) {
 //                if ($agrupado[1] >= $precio[2]) {
 //                    $costoProducto = $precio[3];
 //                }
 //            }

 //            $tablaDetalle = "pedido_detalle";
	// 		$datosDetalle = array("id_empresa" => $empresa["id_empresa"],
	// 								"folio" => $folio,
	// 		    					"id_producto" => $value[1],
	// 		    					"cantidad" => $value[3],
	// 		    					"costo" => $costoProducto);

	// 		$detalle = ModeloPedidos::mdlCrearDetallePedido($tablaDetalle,$datosDetalle);

	// 		$tablaEditarProducto = "productos";
	//     	$datosEditarProducto = array("id_producto" => $value[1],
	// 		    						 "cantidad" => $value[3]);
	//     	$editarProducto = ModeloProductos::mdlEditarStock($tablaEditarProducto,$datosEditarProducto);
 //        }
	// }

	// /*=======================================
	// =            FUNCTION NOTIFY            =
	// =======================================*/
	
	// function sendMessage($titulo,$body){

 //        $content = array(
 //            "en" => $body
 //            );
 //        $headings = array(
 //            "en" => $titulo,
 //        );
        
 //        $fields = array(
 //            'app_id' => "4130ac05-fe29-40a1-b83a-520d611699b1",
 //            'include_player_ids' => array("3c20ea18-5567-4bb5-8ac0-22f7234c1237", "3da2bdd5-1cc1-4b3b-83f1-d8a3a834f120"),
 //            'data' => array("foo" => "bar"),
 //            'headings' => $headings,
 //            'contents' => $content,
 //            'app_url' => "https://twynco.com"
 //        );
        
 //        $fields = json_encode($fields);
 //        // print("\nJSON sent:\n");"3da2bdd5-1cc1-4b3b-83f1-d8a3a834f120", 
 //        // print($fields);
        
 //        $ch = curl_init();
 //        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications/$fields['app_id']");
 //        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
 //        curl_setopt($ch, CURLOPT_HEADER, FALSE);
 //        curl_setopt($ch, CURLOPT_POST, TRUE);
 //        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
 //        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

 //        $response = curl_exec($ch);
 //        curl_close($ch);
        
 //        return $response;
 //    }


 //    $titulo = "TwynKids, Compra";   
 //    $body = "Folio ".$folio.", Monto $".number_format($separacion[2],"2",".",","); 
	
	// /*=====  End of FUNCTION NOTIFY  ======*/

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

<!--     <?php

 //    $pedido = ModeloPedidos::mdlCrearPedido($tablaPedidos, $datosPedido);
	// $pedidoEntrega = ModeloPedidos::mdlCrearEntregaPedido($tablaEPedidos, $datosEPedido);

 //    if ($pedido == "ok") {

        
 //        $tablaCarrito = "carrito"; 
 //        $itemCarrito = "id_cliente";
 //        $valorCarrito = $_SESSION["id"];
 //        $eliminar = ModeloCarrito::mdlEliminarCarrito($tablaCarrito,$itemCarrito,$valorCarrito);
        http://auth.mercadolibre.com.mx/authorization?response_type=code&client_id=6332968879254996&redirect_uri=http://localhost/pruebas-facturacion/


        // TG-60946def007d190006792171-222678063
    ?>                  
        -->     
        <div class="container">
            <div class="emty_cart_inner">
                <i class="icon_check_alt icons"></i>
                <h3>Pedido finalizado!</h3>
                <h4>volver a <a href="inicio">Inicio</a></h4>
            </div>
        </div>
        <br>
        <div class="container">
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
                <div class="col-md-3">
                    <?php
                        $whats = "https://api.whatsapp.com/send?phone=+52".$respuestaRedesSocial['numero']."&text=Verificar el pedido ".$folio;
                    ?>
                    <a href="<?php echo $whats ?>" target="_blank" type="button" class="btn btn-success">
                        <i class="fa fa-whatsapp"></i> Verificar pedido con vendedor
                    </a>
                    <!-- <button type="button" class="btn btn-success">
                        <i class="fa fa-whatsApp"></i> Contactar a vendedor
                    </button> -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <button class="btn btn-primary btn-block btnGuardarAnotaciones">Agregar</button>
                </div>
            </div>
        </div>
    <?php
        // }
    ?>
</section>
<!--================End login Area =================-->

<?php
	include 'fix/footer.php';
}
?>