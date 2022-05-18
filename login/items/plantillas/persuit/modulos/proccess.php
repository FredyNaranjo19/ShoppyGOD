<?php
include 'fix/header.php';

$item = "id_empresa";
$valor = $empresa["id_empresa"];
	
$ConfiguracionPagos = ControladorConfiguracion::ctrMostrarConfiguracionPago($item, $valor);
$ConfiguracionEntregas = ControladorConfiguracion::ctrMostrarConfiguracionEntregas($item, $valor);
$ConfiguracionCostoEnvio = ControladorConfiguracion::ctrMostrarConfiguracionCostoEnvio($item, $valor);

$tipo = " - ";
$tipoEnvio = "";
if (isset($_GET["dir"])) {
     
    $tipo = explode("-", $_GET["dir"]);
    $tipoEnvio = $_GET["dir"];
}

?>

<!--================Categories Banner Area =================-->
<section class="solid_banner_area">
    <div class="container">
        <div class="solid_banner_inner">
            <h3>Procesando Pago</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="#">Checkout</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<!--================Register Area =================-->
<section class="register_area p_100">
    <div class="container">
        <div class="register_inner">
            <?php
                $item = "id_cliente";
                $valor = $_SESSION["id"];
                $clienteTel = ControladorClientes::ctrMostrarClientes($item, $valor, $empresa["id_empresa"]);

            if ($clienteTel["telefono"] == "" || $clienteTel["telefono"] == NULL || $clienteTel["telefono"] == 0) {
            ?>
                <input type="hidden" id="ExistenciaTel" value="0">
                <div class="row">
                    <div class="col-lg-7">
                        <!-- <div class="row"> -->
                            <div class="mb-3">
                                <span class="titprod" style="color: red;">
                                    <b style="color: black; font-size: 2.1em; font-weight: normal;"> 
                                        Telefono: 
                                    </b>
                                    <br>
                                    (Necesitamos tu número de teléfono para notificarte el estado de tu pedido).
                                </span>
                                
                                <div class="input-group">
                                  <input type="number" class="form-control input-lg" maxlength="10" id="telefonoAgregarCliente">
                                  <input type="hidden" id="idAgregarCliente" value="<?php echo $_SESSION["id"] ?>">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <button type="button" class="btn btn-success btnGuardarTelefono float-right">
                            Guardar
                        </button>
                    </div>
                </div>

            <?php
            } else {
            ?>
                <input type="hidden" id="ExistenciaTel" value="1">
            <?php
            }
            ?>

            <div class="row">

                <div class="col-lg-7">
                    <h2 class="reg_title">Detalles de envío</h2>
                    <div id="accordionEntrega" role="tablist" class="price_method">
                        
                        
                        <!-- ************************************************************************************** -->
                        <!-- ************************************************************************************** -->
                        <!-- *****************************  ENTREGA A DOMICILIO  ********************************** -->
                        <!-- ************************************************************************************** -->
                        <!-- ************************************************************************************** -->
                        
                        <div class="card">   

                            <div class="card-header">
                                <h5 class="mb-0">
                                    Envio a Domicilio
                                </h5>
                            </div>
                            <div class="card-body">


                                <div class="col-lg-12 address-details">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?php

                                            $item = "id_cliente";
                                            $valor = $_SESSION["id"];
                                            $direcciónCliente = ControladorClientes::ctrMostrarInformacionCliente($item, $valor);
                                            if ($direcciónCliente != "ninguno") { 
                                            ?>    

                                                <div class="Direcciones">
                                                    <select name="direccionesCliente" class="form-control" id="direccionesCliente">
                                                        <option value="">Selecciona una dirección...</option>
                                                    <?php
                                                    foreach ($direcciónCliente as $key => $val) {
                                                    ?>
                                                        <option value="<?php echo $val['id_info']; ?>" <?php if(isset($_GET["dir"]) && $tipo[1] == $val["id_info"]) echo "selected"; ?>>

                                                            <?php echo $val['calle']." ".$val['exterior'].", ".$val['colonia']; ?>
                                                            
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>

                                            <?php
                                            }
                                            ?>
                                        </div>  

                                        <div class="col-lg-6 contenDireccion">
                                            <?php

                                            if ($direcciónCliente == "ninguno") { 
                                            ?>
                                                
                                                <h4>No tienes registrado alguna dirección</h4>

                                            <?php 
                                            } else {
                                                if (isset($_GET["dir"])) {
                                                    foreach ($direcciónCliente as $key => $value) {
                                                        if ($tipo[1] == $value["id_info"]) {
                                                            
                                                            echo '<p>Calle: '.$value["calle"].' '.$value["exterior"].'<br>
                                                                Colonia: '.$value["colonia"].'</p>';

                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                        </div>
                                                                          
                                    </div>
                                </div>
                                <div class="btn-info-DireccionN col-lg-12">
                                    <button class="btn subs_btn pull-right btnNuevaDireccion">Ingresar Dirección</button>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <hr>

                    <form class="billing_inner row info-DireccionFormulario" method="POST" style="display:none;">

                        <div class="col-lg-12">
                            <i class="pull-right fa fa-times btnCerrarFormDirec"></i>
                            <h4>Nueva dirección</h4>
                        </div>


                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address">Dirección <span>*</span></label>
                                <input type="text" class="form-control" 
                                        id="address" name="nDireccionCliente" 
                                        aria-describedby="address" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="ext">No. Ext. <span>*</span></label>
                                        <input type="text" class="form-control" 
                                            id="ext" name="nExtCliente" aria-describedby="ext" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="int">No. Int.</label>
                                        <input type="text" class="form-control" 
                                                id="int" name="nIntCliente" aria-describedby="int" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="cp">C.P. <span>*</span></label>
                                        <input type="text" class="form-control" 
                                                id="cp" name="nCPCliente" aria-describedby="cp" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="colo">Colonia <span>*</span></label>
                                        <input type="text" class="form-control" 
                                                id="colo" name="nColoniaCliente" aria-describedby="colo" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">Ciudad <span>*</span></label>
                                        <input type="text" class="form-control" 
                                                id="city" name="nCiudadCliente" aria-describedby="city" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="esta">Estado <span>*</span></label>
                                        <input type="text" class="form-control" 
                                                id="esta" name="nEstadoCliente" aria-describedby="esta" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="country">País <span>*</span></label>
                                        <input type="text" class="form-control" 
                                                id="country" name="nPaisCliente" aria-describedby="country" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <p>¿Entre que calles se encuentra la ubicación? (opcional).</p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="cal1">Calle 1</label>
                                        <input type="text" class="form-control" id="cal1" name="nCalle1" aria-describedby="cal1" placeholder="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="cal2">Calle 2</label>
                                        <input type="text" class="form-control" id="cal2" name="nCalle2" aria-describedby="cal2" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="refe">Referencias</label>
                                <textarea class="form-control" name="nReferenciaCliente" id="refe" aria-describedby="refe"rows="5"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <input type="hidden" name="clienteDirId" value="<?php echo $_SESSION["id"]; ?>">
                        
                            <button type="submit" class="btn pull-right subs_btn" style="background:black;color:white;">GUARDAR</button>
                        </div>
                        

                        <?php
                            $guardarDireccion = new ControladorClientes();
                            $guardarDireccion -> ctrCrearInformacionCliente();
                        ?>
                    </form> 

                </div>

                <!-- *************************************************************************************************************************** -->
                <!-- *************************************************************************************************************************** -->
                <!-- *************************************************************************************************************************** -->
                <!-- *************************************************************************************************************************** -->

                <div class="col-lg-5">
                    <div class="order_box_price">
                        <h2 class="reg_title">Su pedido</h2>
                        <?php
                        $totalPagar = 0;
                        $volumen = 0;
                        $peso = 0;
                        $varCostoEnvio = 0;

                        $datos = array("id_cliente" => $_SESSION["id"],
                                       "id_empresa" => $empresa["id_empresa"]);

                        $resultadoAgrupado = ControladorCarrito::ctrMostrarCarritoAgrupado($datos);

                        ?> 
                        <div class="payment_list">
                            <div class="price_single_cost">
                            <?php
                            foreach ($resultadoAgrupado as $key => $value) {

                                /*========================================================
                                =            BUSQUEDA DE PRODUCTOS EN CARRITO            =
                                ========================================================*/
                                
                                $datos = array("modelo" => $value["modelo"],
                                                "id_empresa" => $empresa["id_empresa"],
                                                "id_cliente" => $_SESSION["id"],
                                                "opcion" => 2);

                                $resultado = ControladorCarrito::ctrMostrarCarrito($datos);

                                foreach ($resultado as $key => $carrito) {
                                    $item = "id_producto";
                                    $valor = $carrito['id_producto'];
                                    $producto = ControladorProductos::ctrMostrarProductoInfoCompleta($item, $valor);
                            ?>
                                <h5>
                                    <?php echo $producto['nombre'] ?> 
                                    <span>
                                    <?php
                                        $datos = array("id_empresa" => $empresa["id_empresa"],
                                                       "codigo" => $value["modelo"]);
                                        $preciosResultado = ControladorProductos::ctrMostrarPreciosProducto($datos);


                                        foreach ($preciosResultado as $ka => $listadoPrecios) {

                                            if ($listadoPrecios["activadoPromo"] == "si") {

                                                if ($value["cantidad"] >= $listadoPrecios['cantidad']) { 

                                                    $precio = $listadoPrecios['promo'];

                                                }
                                            
                                            } else {

                                                if ($value["cantidad"] >= $listadoPrecios['cantidad']) { //$value[1] es cantidad sumada de agrupados

                                                    // $total = $value["cantidad"] * $listadoPrecios['precio'];
                                                    $precio = $listadoPrecios['precio'];

                                                }
                                            }
                                        }



                                        $montoProducto = $precio * $carrito['cantidad'];
                                        echo "$".number_format($montoProducto,"2",".",",");

                                        $totalPagar = $totalPagar + $montoProducto;

                                    ?>
                                    </span>
                                </h5>
                            <?php
                                    // if ($ConfiguracionEntregas["envios"] == "habilitado") { 
                                        /*======================================
                                        =            DATOS DE ENVIO            =
                                        ======================================*/
                                        $medidas = json_decode($producto["medidas"], true);
                                        $volumenProducto = floatval($medidas[0]["largo"]) * floatval($medidas[0]["ancho"]) * floatval($medidas[0]["alto"]);

                                        $volumenProducto = floatval($carrito["cantidad"]) * $volumenProducto;

                                        $volumen = floatval($volumen) + floatval($volumenProducto);
                                        $peso = $peso + $producto["peso"];
                                        
                                        /*=====  End of DATOS DE ENVIO  ======*/
                                    // }
                                }
                            }

                            // if ($ConfiguracionEntregas["envios"] == "habilitado") { 

                            //     if ($tipo[0] == "dir") {
                                    


                                    foreach ($ConfiguracionCostoEnvio as $key => $value) {
                                        
                                        if ($varCostoEnvio == 0) {

                                            if ($volumen <= $value["peso_volumetrico"] && $peso <= $value["peso_masa"]) {

                                                $varCostoEnvio = $value["precio"];

                                            }

                                        }        
                                    }

                                    /* SUMAR EL ENVIO A TOTAL A PAGAR */
                                    $totalPagar = $totalPagar + $varCostoEnvio;
                            ?>

                                    <h4>
                                        Envio
                                        <span>
                                            <i class="fa fa-plus pull-left"></i>
                                            <?php echo number_format($varCostoEnvio,"2",".",","); ?>
                                        </span>
                                        <br>
                                    </h4>
                            <?php
                                // }
                            // }

                                $varUrl = $tipoEnvio."-".$totalPagar;
                            ?>
                                <h3>
                                    <span class="normal_text">Total del pedido </span> 
                                    <span> $<?php echo number_format($totalPagar,"2",".",","); ?></span>
                                </h3>
                            </div>

                            <!--========================================================================================
                            =            ------------------------- METODOS DE PAGO -----------------------             =
                            =========================================================================================-->


                            <div id="accordion" role="tablist" class="price_method">
                                <?php if ($ConfiguracionPagos["efectivoView"] == "habilitado") { ?>

                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne">
                                            Deposito o transferencia Bancaria.
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">

                                        <div class="card-body">
                                            Deberá hacer el deposito y subir su ticket de pago en la seccion de mis compras.
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <center>
                                                    <img src="../items/extensiones/TCPDF-master/pdf/images/oxxo.png" style="width: 30%;height: 25px; object-fit: scale-down; padding: 0;margin:0">
                                                    <img src="../items/extensiones/TCPDF-master/pdf/images/seven.png" style="width: 30%;height: 25px; object-fit: scale-down; padding: 0;margin:0">
                                                    <img src="../items/extensiones/TCPDF-master/pdf/images/ahorro.png" style="width: 30%;height: 50px; object-fit: scale-down; padding: 0;margin:0">
                                                </center>
                                            </div>

                                        </div>
                                        <div>
                                            <form method="POST" id="formPagoEfectivo">
                                                <input type="hidden" id="ProccessEmpresa" value="<?php echo $empresa["id_empresa"]; ?>">
                                                <input type="hidden" id="ProcessTotal" value="<?php echo $totalPagar; ?>"/>
                                                <input type="hidden" id="idDireccionInfo" value="<?php echo $tipoEnvio ?>">
                                                <input type="hidden" id="TipoPago" value="Efectivo">


                                                <input type="hidden" id="ProcessCard" value="<?php echo $ConfiguracionPagos['efectivoTarjeta'] ?>">
                                                <button type="submit" value="submit" class="btn subs_btn form-control btnPagoProcess" disabled>Realizar Pedido</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <?php 
                                } 
                                /*===================================================
                                =            METODO DE PAGO MERCADO PAGO            =
                                ===================================================*/
                                if ($ConfiguracionPagos["mercadoView"] == "habilitado") {
                                ?>

                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h5 class="mb-0">
                                          <?php if ($ConfiguracionPagos["efectivoView"] == "habilitado") { ?>
                                            <a class="collapsed" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="true" aria-controls="collapseTwo">
                                                Tarjeta de debito/credito
                                            </a>
                                          <?php } else { ?>
                                            <a data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo">
                                                Tarjeta de debito/credito
                                            </a>
                                          <?php } ?>
                                        </h5>
                                    </div>

                                    <?php if ($ConfiguracionPagos["efectivoView"] == "habilitado") { ?>

                                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" disabled>

                                    <?php } else { ?>

                                    <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" disabled>

                                    <?php } ?>
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <center>
                                                    <img src="../items/extensiones/TCPDF-master/pdf/images/mercadopago.png" style="width: 100%;height: 60px; object-fit: scale-down;">
                                                </center>
                                            </div>
                                        </div>
                                    </div>

                                        
                                    <div>
                                        <!--===========================================
                                        =            DATOS DE MERCADO PAGO            =
                                        ============================================-->
                                        <?php
                                            // SDK de Mercado Pago
                                        require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
                                        // Agrega credenciales
                                        MercadoPago\SDK::setAccessToken($ConfiguracionPagos["mercadoAccess"]);
                                        // // Crea un objeto de preferencia
                                        $preference = new MercadoPago\Preference();
                                        $items = array();
                                        $totalPagar = 0;
                                            
                                        // CONSULTA DB --------- CARRRITO DE COMPRAS AGRUPADO POR LISTA DE PRECIOS
                                            
                                        foreach ($resultadoAgrupado as $key => $value) {
                                            $datos = array("modelo" => $value["modelo"],
                                                                "id_empresa" => $empresa["id_empresa"],
                                                                "id_cliente" => $_SESSION["id"],
                                                                "opcion" => 2);

                                            $resultado = ControladorCarrito::ctrMostrarCarrito($datos);

                                            foreach ($resultado as $key => $carrito) {

                                                $item = "id_producto";
                                                $valor = $carrito['id_producto'];
                                                $producto = ControladorProductos::ctrMostrarProductoInfoCompleta($item, $valor);

                                                $datos = array("id_empresa" => $empresa["id_empresa"],
                                                       "modelo" => $value["modelo"]);
                                                $preciosResultado = ControladorProductos::ctrMostrarPreciosProducto($datos);


                                                foreach ($preciosResultado as $ka => $listadoPrecios) {

                                                    if ($listadoPrecios["activadoPromo"] == "si") {

                                                        if ($value["cantidad"] >= $listadoPrecios['cantidad']) { 
                                                            $precio = $listadoPrecios['promo'];

                                                        }
                                                    
                                                    } else {
                                                        if ($value["cantidad"] >= $listadoPrecios['cantidad']) {
                                                            $precio = $listadoPrecios['precio'];
                                                        }
                                                    }
                                                }

                                                /*=================================================
                                                =            CODIGO MERCADO PAGO ITEMS            =
                                                =================================================*/
                                                    
                                                $itemM = new MercadoPago\Item();
                                                $itemM->title = $producto['nombre'];
                                                $itemM->quantity = $carrito['cantidad'];
                                                $itemM->unit_price = floatval($precio);

                                                array_push($items, $itemM);
                                                    
                                                /*=====  End of CODIGO MERCADO PAGO ITEMS  ======*/

                                            }

                                        }

                                        /*=================================================
                                        =             CODIGO MERCADO PAGO ENVIO           =
                                        =================================================*/
                                                // if ($ConfiguracionEntregas["envios"] == "habilitado") { 

                                                //     if ($tipo[0] == "dir") {
                                                            
                                        $itemM = new MercadoPago\Item();
                                        $itemM->title = 'Envio';
                                        $itemM->quantity = 1;
                                        $itemM->unit_price = floatval($varCostoEnvio);

                                        array_push($items, $itemM);
                                                //     }
                                                // }
                                        /*=====  End of CODIGO MERCADO PAGO ENVIO  ======*/

                                        $preference->items = $items;
                                        $preference->back_urls = array(
                                            "success" => $GlobalUrl.$nombreEmpresa."/index.php?ruta=savePayment&dir=".$varUrl,
                                            "failure" => $GlobalUrl.$nombreEmpresa."/failure.php",
                                            "pending" => $GlobalUrl.$nombreEmpresa."/index.php?ruta=success&dir=".$varUrl
                                        );

                                        $preference->save();     
                                            
                                        ?>
                                        
                                        <!--====  End of DATOS DE MERCADO PAGO  ====-->
                                        

                                        <a class="" href="<?php echo $preference->init_point; ?>">
                                            <button class="btn subs_btn form-control  btnPagoProcess"> Pagar </button>
                                        </a>
                                            
                                    </div>




                                    </div>
                                </div>

                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>