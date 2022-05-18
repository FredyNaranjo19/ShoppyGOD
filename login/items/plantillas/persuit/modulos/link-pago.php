<?php
include 'fix/header.php';

// $settingsPagos = ModeloConfiguracion::mdlMostrarSettingsPagos();

$item = "folio";
$valor = $_GET["f0l10"];

/* NUEVAS VARIABLES PARA LINK WEB
-------------------------------------------------- */
$venta = ControladorVentasCedis::ctrMostrarVentasEnTVLinkPago($item, $valor, $_GET["v3nd3d0r"]);
$datos = array("folio" => $valor, "id_empresa" => $empresa["id_empresa"], "vendedor" => $_GET["v3nd3d0r"]);
$ventaDetalle = ControladorVentasCedis::ctrMostrarVentasDetallesCedis($datos);

$itemConf = "id_empresa";
$valorConf =  $empresa["id_empresa"];

$ConfiguracionPagos = ControladorConfiguracion::ctrMostrarConfiguracionPago($itemConf, $valorConf);
// $ConfiguracionEntregas = ControladorConfiguracion::ctrMostrarConfiguracionEntregas($itemConf, $valorConf);


/* NUEVAS VARIABLES PARA LINK WEB
-------------------------------------------------- */
$totalPagar = $venta["total"];

/* ANTIGUA VARIABLE
-------------------------------------------------- */

// $totalPagar = $pedido["total"];



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

<!-- SE CAMBIO $entrega["estado_entrega"]  por $venta["estado"] -->
<?php
if ($venta["estado"]  == "Sin comprobante") {
?>
<!--================Register Area =================-->
<section class="register_area p_100">
    <div class="container">
        <div class="register_inner">
            <div class="row">
                <div class="col-lg-7">
                    <h2 class="reg_title">Detalles de envío</h2>
                    <div id="accordionEntrega" role="tablist" class="price_method">
                    	
                    	<!-- ********************************************************************** -->
                        <!-- SE CAMBIO $entrega["tipo_entrega"]  por $venta["entrega_producto"] -->
                    	<?php if ($venta["entrega_producto"] == "Almacen") {?>
                    	<div class="card">
                            <div class="card-header" role="tab" id="headingSuc">
                                <h5 class="mb-0">
                                    
                                    <a  data-toggle="collapse" href="#collapseSuc" role="button" aria-expanded="false" aria-controls="collapseSuc">
                                    Recolección en Sucursal.
                                    </a>
                                    
                                </h5>
                            </div> 

                            <div id="collapseSuc" class="collapse show" role="tabpanel" aria-labelledby="headingSuc" data-parent="#accordionEntrega">

                                <div class="card-body row">
                                    <div class="col-md-7">
                                        <!-- SE MODIFICO ESTA PARTE Y SE USO EL CONTROLADOR DE EMPRESAS -->
                                        <?php
                                            $item = "id_empresa";
                                            $valor = $venta["id_empresa"];

                                            $Sucursal = ControladorEmpresas::ctrMostrarEmpresasAdministracion($item,$valor);
                                        ?>
                                        <h4><?php echo $Sucursal['nombre'] ?></h4>
                                        <p><?php echo $Sucursal['domicilio'] ?></p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    	<?php } ?>
                        <!-- ************************************************************************************** -->
                        <!-- ************************************************************************************** -->
                        <!-- *****************************  ENTREGA A DOMICILIO  ********************************** -->
                        <!-- ************************************************************************************** -->
                        <!-- ************************************************************************************** -->

                        <!-- se cambio $entrega["tipo_entrega"]  por $venta["entrega_producto"] -->
                        <?php if ($venta["entrega_producto"] == "Domicilio") { ?>
                        
                        <div class="card">

                            <div class="card-header" role="tab" id="headingEnv">
                                <h5 class="mb-0">
                                    <a  data-toggle="collapse" href="#collapseEnv" role="button" aria-expanded="false" aria-controls="collapseEnv">
                                        Envio a Domicilio
                                    </a>
                                </h5>
                            </div>
                            <div id="collapseEnv" class="collapse show" role="tabpanel" aria-labelledby="headingEnv" data-parent="#accordionEntrega">


                                <div class="col-lg-12 address-details">
                                    <div class="row">
                                         
                                        <div class="col-lg-6 contenDireccion">
                                            <?php

                                                $item = "id_info";
                                                // se cambio $entrega["id_domicilio"]  por $venta["id_domicilio"]
                                                $valor = $venta["id_domicilio"];
                                                $direcInfo = ControladorClientes::ctrMostrarInformacionCliente($item, $valor);
                                                foreach ($direcInfo as $key => $value) {   
                                            ?>
                                                    <h4><?php echo $value['calle']." ".$value['exterior']; ?></h4>
                                                    <h4><?php echo $value['colonia']; ?></h4>

                                                    <div>
                                                        <p><?php echo $value['estado']."(".$value['cp']."), ".$value['ciudad']; ?></p>
                                                    </div>

                                            <?php
                                                }
                                            ?>
                                        </div>
                                                                           
                                    </div>
                                </div>
                            </div>

                        </div> 
                    	<?php } ?> 
                    </div>
                </div>

<!-- *********************************************************************************************************************************************** -->
<!-- *********************************************************************************************************************************************** -->
<!-- *********************************************************************************************************************************************** -->
<!-- *********************************************************************************************************************************************** -->
<!-- *********************************************************************************************************************************************** -->
                <div class="col-lg-5">
                	<div class="order_box_price">
                		<h2 class="reg_title">Su pedido</h2>
						<div class="payment_list">
							<div class="price_single_cost">
							<?php
							// var_dump($detalle);

							foreach ($ventaDetalle as $key => $detalle) {
                                
							?>
								<h5>
                                	<?php echo $detalle["cantidad"]." ".$detalle['nombre'] ?>  
                                	<span>
                                		<?php
											$montoProducto = $detalle["cantidad"] * $detalle["precio"];
											echo "$".number_format($montoProducto,"2",".",",");
										?>
                                	</span>
                                </h5>

							<?php
								}
							?>


                          		<?php  if ($venta["entrega_producto"] == "Domicilio") {  ?>
								<h4>Envio 
                            		<span>
                            			<i class="fa fa-plus pull-left"></i>
										<?php 
											

											echo "$".number_format($venta["envio"],"2",".",","); 
										?>
									</span>
                            	</h4>
								<?php 
									}

                            // echo $varUrl;

								?>
								<h3><span class="normal_text">Total del pedido </span> <span> $<?php echo number_format($venta["total"],"2",".",","); ?></span></h3>
							</div>
<!--========================================================================================
=            ------------------------- METODOS DE PAGO -----------------------             =
=========================================================================================-->
							<div id="accordion" role="tablist" class="price_method">
							<?php 
                            if ($ConfiguracionPagos["efectivoView"] == "on" || $ConfiguracionPagos["efectivoView"] == "habilitado") { ?>

								<div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne">
                                            Deposito Bancario
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            Deberá hacer el deposito y subir su ticket de pago en este link.
                                        </div>
                                        <div>
                                        	<div class="row">
                                                <div class="col-md-12">    
                                                    <button type="button" class="btn btn-danger btnPDFLink btn-sm btn-block">
                                                        <i class="fa fa-download"></i> FORMATO DE PAGO
                                                    </button>      
                                                </div>
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
                                            <form role="form" method="POST" enctype="multipart/form-data">
                                                <div class="form-group">
    								                <div class="panel">SUBIR Comprobante</div>
                                                    <p class="help-block">Peso máximo de la foto 5 MB.</p>
                                                    <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewLinkComprobante" style="object-fit: scale-down; height: 200px;width: 100%;">

                                                    <div id="DtxtCarga"></div>
                                                    <button type="button" class="btn btn-secondary btn-block" id="btnLinkComprobante">
                                                      <i class="fas fa-folder-plus"></i>Seleccionar imagen
                                                    </button>

    								            </div>
                                                    <input type="hidden" name="urlLinkComprobante" id="urlLinkComprobante">
                                                    <input type="hidden" name="procesarVendedor" id="procesarVendedor" value="<?php echo $_GET["v3nd3d0r"]; ?>">
                                                    <input type="hidden" name="procesarPagoFolio" id="procesarPagoFolio" value="<?php echo $venta["folio"]; ?>">
                                                    <input type="hidden" name="procesarPagoTotal" id="procesarPagoTotal" value="<?php echo $venta["total"]; ?>">
     
                                                    <button type="submit" value="submit" class="btn subs_btn form-control  btnSubirPagoLink" disabled>
                                                        Enviar
                                                    </button>
                                                <?php
                                                    $Procesar = new ControladorPago();
                                                    $Procesar -> ctrGuardarVentaLinkCedis(); 
                                                ?>
                                            </form>
                                        </div>
                                    </div> 
                                </div>
                            <?php 
                        		} 
		/*===================================================
		=            METODO DE PAGO MERCADO PAGO            =
		===================================================*/

                        	if ($ConfiguracionPagos["mercadoView"] == "on" || $ConfiguracionPagos["mercadoView"] == "habilitado") {

                        	?>

                                <div class="card">
                                    <div class="card-header" role="tab" id="headingTwo">
                                        <h5 class="mb-0">
                                          <?php if ($ConfiguracionPagos["efectivoView"] == "on") { ?>
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
                                    <?php if ($ConfiguracionPagos["efectivoView"] == "on") { ?>
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
                                            	$varUrl = $_GET["f0l10"];

                                                /*===========================================
                                                =            CODIGO MERCADO PAGO            =
                                                ===========================================*/
                                                // SDK de Mercado Pago
                                                require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
                                            // Agrega credenciales
                                                MercadoPago\SDK::setAccessToken($ConfiguracionPagos["mercadoAccess"]);
                                                //$settingsPagos["accToken"]);
                                                $items = array();
                                                // Crea un objeto de preferencia
                                                $preference = new MercadoPago\Preference();

                                            	$item = new MercadoPago\Item();
                                            	$item->title = 'Pago total';
                                            	$item->quantity = 1;
                                            	$item->unit_price = floatval($totalPagar);

                                            	array_push($items, $item);
                                                
                                                
                                                $preference->items = $items;
                                                $preference->back_urls = array(
                                                    "success" => $GlobalUrl.$nombreEmpresa."/index.php?ruta=PaymentPV&folio=".$varUrl,
                                                    "failure" => $GlobalUrl.$nombreEmpresa."/failure.php",
                                                    "pending" => $GlobalUrl.$nombreEmpresa."/index.php?ruta=success&dir=".$varUrl
                                                );

                                                $preference->save();
                                                
                                            ?>
                                            
                                            
                                            <!--====  End of DATOS DE MERCADO PAGO  ====-->
                                            

                                            <a class="" href="<?php echo $preference->init_point; ?>">
                                                <button class="btn subs_btn form-control"> Pagar </button>
                                            </a>
                                            
                                        </div>




                                    </div>
                                </div>

                            <?php
                            	}
                            ?>

							</div>

<!--====  End of ------------------------- METODOS DE PAGO -----------------------   ====-->



						</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Register Area =================-->
<?php
} else {
?>

<section class="register_area p_100">
    <div class="container">
        <div class="register_inner">
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <h2>El link de pago ha expirado.</h2>
                    </center>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
}
?>