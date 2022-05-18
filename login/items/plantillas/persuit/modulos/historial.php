<?php
if (!isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] != "ok"){

    header("Location:login");

}

include 'fix/header.php';


$item = "id_cliente";
$valor = $_SESSION["id"];
$resultado = ControladorPedidos::ctrMostrarPedidos($item, $valor, $empresa["id_empresa"]);

?>

<!--================Categories Banner Area =================-->
<section class="categories_banner_area">
    <div class="container">
        <div class="c_banner_inner">
            <h3>Historias de Compras</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li class="current"><a href="#">Historial de compras</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<!--================Categories Product Area =================-->
<section class="categories_product_main p_80">
    <div class="container">
        <div class="categories_main_inner">
            <div class="row row_disable">
                <div class="col-lg-12">
                    <div class="c_product_grid_details">
					<?php
					foreach ($resultado as $key => $value) {
					$itemDetalle = "folio";
					$valorDetalle = $value['folio'];
					$detalles = ControladorPedidos::ctrMostrarDetallePedido($itemDetalle, $valorDetalle, $empresa["id_empresa"]);

					$itemEntrega = "folio";
					$valorEntrega = $value["folio"];
                    $entregas = ControladorPedidos::ctrMostrarEntregaPedido($itemEntrega, $valorEntrega, $empresa["id_empresa"]);

					?> 
                        <div class="c_product_item">
                            <div class="row">
                                <div class="col-lg-5 col-md-5">
                                    <div class="c_product_img">
                                        <table class="table tblScroll">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Pzas.</th>
                                                    <th>Costo</th>
                                                    <th>Comentario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($detalles as $kei => $producto) {

                                                echo '<tr class="tblProducto">';

                                                /* IMAGEN DE PRODUCTO */
                                                $item = "id_producto";
                                                $valor = $producto["id_producto"];
                                                $tiendaProducto = ControladorProductos::ctrMostrarProductoInfoCompleta($item, $valor);
                                                echo '<td style="width=20%;"><img src="'.$tiendaProducto["imagen"].'" alt="" width="50px" ></td>';


                                                echo '<td>'.$producto["cantidad"].'</td>
                                                    <td>$'.$producto["costo"].'</td>';


                                                $comProducto = $producto["id_producto"];
                                                $comCliente =  $_SESSION["id"];

                                                $comentario = ControladorProductos::ctrMostrarComentariosProducto($comProducto, $comCliente);
                                                
                                                if ($comentario == false) {

                                                    echo '<td style="width=40%;">
                                                        <button class="btn btn-info btn-sm btnComentarioProducto btn-block" idProducto="'.$producto["id_producto"].'" data-toggle="modal" data-target="#modalAgregarComentario">Agregar</button>
                                                    </td>';

                                                }
                                                echo '</tr>';
                                            }
                                            ?>
                                            </tbody>
                                         
                                        </table>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-md-3">
                                    <div class="c_product_text">
                                        <h3><b>Folio: </b><?php echo $value['folio']; ?></h3>
                                        <h5>$<?php echo number_format($value['total'],"2",".",","); ?></h5>
                                        <h6><b>Fecha de pedido: </b> <?php echo $value['fecha']; ?></h6>

                                        <h6><b>Estado:</b> <?php echo $entregas['estado_entrega']; ?></h6>

                                        <div class="row">
                                        	<div class="col-lg-6">
                                        		<?php if($entregas['estado_entrega']=='Enviado'){  ?>
													
													<h6><b>Paqueteria: </b><?php echo $entregas['paqueteria'] ?></h6>
													<h6><b>No. de rastreo: </b><?php echo $entregas['rastreo'] ?></h6>

												<?php } ?>
                                        	</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4">
                                    <div class="c_product_text">
                                        <h5 style="color: black"><b>Forma de pago: </b><?php echo $value["metodo_pago"] ?></h5>
                                        <div>

                                        <?php if ($value["metodo_pago"] == "Efectivo" && $entregas['estado_entrega'] == "Subir Comprobante") { 

                                            $rutaPago = $GlobalUrl."items/extensiones/TCPDF-master/pdf/deposito.php?emp=".$empresa['id_empresa']."&&m0n=".$value['total']."&&f01i0=".$value['folio'];

                                        ?>
                                            

                                            <button type="button" class="btn btn-sm btn-info pull-right btnVaucherEfectivo" folio="<?php echo $value['folio'] ?>" monto="<?php echo $value['total'] ?>" data-toggle="modal" data-target="#modalAgregarVoucherEfectivo" style="margin-left: 10px;">
                                                Subir Comprobante
                                            </button>
                                            
                                            <a class="btn btn-warning btn-sm pull-right" 
                                                href="<?php echo $rutaPago ?>" 
                                                title="Instrucciones de pago" target="_bank">
                                                    Instrucciones
                                            </a>

                                          <?php } else if($value["metodo_pago"] == "Abonos" && $entregas['estado_entrega'] != "Aprobado") {?>

                                            <button type="button" class="btn btn-sm btn-info pull-right btnAbonosDetalles" folio="<?php echo $value['folio'] ?>" monto="<?php echo $value['total'] ?>" data-toggle="modal" data-target="#modalAbonar">
                                                Abonos
                                            </button>

                                          <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                    if ($value["metodo_pago"] == "Efectivo" && $entregas['estado_entrega'] == "Checando Comprobante") { 
                                    $whats = "https://api.whatsapp.com/send?phone=+52".$respuestaRedesSocial['numero']."&text=Verificar el pedido ".$value['folio'];
                                    ?>
                                    <div class="c_product_text">
                                        <div>

                                            <a href="<?php echo $whats ?>" target="_blank" type="button" class="btn btn-success">
                                                <i class="fa fa-whatsapp"></i> Verificar pedido con vendedor
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
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
</section>
<!--================End Categories Product Area =================-->

<?php
	include 'fix/footer.php';
    include 'fix/redes.php';
?>

<!--=========================================
=            MODAL SUBIR VOUCHER            =
==========================================-->

<div id="modalAgregarVoucherEfectivo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST" enctype="multipart/form-data">

        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title" style="font-size: 1.5em">Agregar comprobante de pago</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        
        <!-- CUERPO DEL MODAL -->
        
        <div class="modal-body">

          <div class="box-body">

            <div class="form-group">

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                    <input type="text" class="form-control input-lg" name="nMonto" id="nMonto" placeholder="Ingresa el monto del comprobante" required>
                    <input type="hidden" name="eFolioPago" id="eFolioPago">
                    <input type="hidden" name="empresa" value="<?php echo $empresa["id_empresa"] ?>">
                </div>

            </div>
            <hr>
            <p class="text-center">Peso máximo de la imagen 2 MB.</p>
            <div class="">
                <img src="../items/img/Comprobant2.png" class="img-thumbnail" id="previsualizarPagoNew" style="object-fit: scale-down; height: 200px; width: 100%">
                <div class="card-body">
                  <p>Comprobante de pago</p>
                  <div id="txtCargaHistorial"></div>
                  <button type="button" class="btn btn-secondary btn-block" id="btnComprobantePagoNew">
                    <i class="fas fa-folder-plus"></i>Seleccionar imagen
                  </button>

                  <input type="hidden" id="nTicketCompra" name="nTicketCompra">
                  
                </div>
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary float-right btnGuardarComrpobanteEfectivo" style="display: none">GUARDAR</button>
        </div>
        
        <?php
          
            $agregarComrpobante = new ControladorPedidos();
            $agregarComrpobante -> ctrAgregarFichaPago();
        ?>
          

      </form>
    </div>
  </div>
</div>

<!--====  End of MODAL SUBIR VOUCHER  ====-->

<!--==============================================
=            MODAL AGREGAR COMENTARIO            =
===============================================-->

<div id="modalAgregarComentario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" accept-charset="utf-8">
        
        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Comentar sobre el producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <!--==================================
        =            CUERPO MODAL            =
        ===================================-->
        <div class="modal-body">

          <div class="box-body">

            <!-- COMENTARIO -->
            
            <div class="mb-3">
              <h5 class="titprod"> Comentario: </h5>
              <div class="input-group">
                <textarea name="ComentarionProducto" class="form-control"></textarea>
                <input type="hidden" name="idProductoComentario" id="idProductoComentario">
                
              </div>
            </div>       

            <div class="mb-3">
                <h5 class="titprod"> Valorar </h5>
                <div class="input-group">
                    <select name="ValorarnProducto" i class="form-control">
                        <option value="">Seleccionar puntuación...</option>
                        <option value="5">5 Puntos</option>
                        <option value="4">4 Puntos</option> 
                        <option value="3">3 Puntos</option>
                        <option value="2">2 Puntos</option>
                        <option value="1">1 Puntos</option>                      
                    </select>
                </div>
            </div>


          </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success float-right">Guardar</button>
        </div>
        <?php
            $guardarComentario = new ControladorProductos();
            $guardarComentario -> ctrGuardarComentarioProducto();
        ?>
        </form>
    </div>
  </div>
</div>

<!--====  End of MODAL AGREGAR COMENTARIO  ====-->