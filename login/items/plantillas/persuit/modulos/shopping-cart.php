<?php
if (!isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] != "ok"){

    header("Location:login");

}

include 'fix/header.php';

    $datos = array("id_cliente" => $_SESSION["id"],
                    "id_empresa" => $empresa["id_empresa"]);

	$resultadoAgrupado = ControladorCarrito::ctrMostrarCarritoAgrupado($datos);

?>
<!--================Categories Banner Area =================-->
<section class="solid_banner_area">
    <div class="container">
        <div class="solid_banner_inner">
            <h3>Carrito de Compras</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="#">Carrito de Compras</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<?php

if (sizeof($resultadoAgrupado) > 0) {

?>

<section class="shopping_cart_area p_100">
    <div class="container">
        <div class="row">
        	<div class="col-lg-8">
                <div class="cart_items">

                    <h3>Tu carrito de compras</h3>
					<input type="hidden" class="idClienteCarrito" value="<?php echo $_SESSION['id']; ?>" empresa="<?php echo $empresa['id_empresa'] ?>">

                    <div class="table-responsive-md">
                        
                        <?php
                        $mTotal = 0;
						foreach ($resultadoAgrupado as $key => $value) {

                        echo '<table class="table">
                                <tbody>';

                            $datos = array("modelo" => $value["modelo"],
                                            "id_empresa" => $empresa["id_empresa"],
                                            "id_cliente" => $_SESSION["id"],
                                            "opcion" => 2);

							$resultado = ControladorCarrito::ctrMostrarCarrito($datos);

							foreach ($resultado as $kay => $carrito) {

								$item = "id_producto";
								$valor = $carrito['id_producto'];
								$producto = ControladorProductos::ctrMostrarProductoInfoCompleta($item, $valor);

							?>
                                <tr class="trCantidad">
                                    <th scope="row">
                                        <span class="delProducto" idCarrito="<?php echo $carrito['id_carrito']; ?>" style="cursor:pointer; font-size:2em;font-weight: none;">&times;</span>
                                    </th>
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="<?php echo $producto['imagen']; ?>" width="70px" >
                                            </div>
                                            <div class="media-body">
                                                <h4><?php echo $producto['nombre']; ?></h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="quantity">
                                            <h6>Cant. </h6>
                                            <div class="custom">
                                                <button  class="reduced items-count" type="button" id="btn-menos"  <?php if($carrito['cantidad']== 1) echo "disabled"; ?>>
                                                	<i class="icon_minus-06"></i>
                                                </button>

                                                <input type="text" class="input-text qty"
                                                		id="cantCarrito" 
														idProducto="<?php echo $carrito['id_producto'] ?>" 
														modelo = "<?php echo $value['modelo'] ?>"
                                                        pzasAgrupados = "<?php echo $value['cantidad'] ?>"
														value="<?php echo $carrito['cantidad'] ?>" 
														min = "1"
														max="<?php echo $producto['stock'] ?>">


                                                <button class="increase items-count" noI="<?php echo $key; ?>" type="button" id="btn-mas" <?php if($carrito['cantidad'] == $producto['stock']) echo "disabled"; ?> >
                                                	<i class="icon_plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            <?php
                            }

                                $datos = array("id_empresa" => $empresa["id_empresa"],
                                                "codigo" => $value["modelo"]);
								$preciosResultado = ControladorProductos::ctrMostrarPreciosProducto($datos);

								foreach ($preciosResultado as $ka => $precio) {
                                    if ($precio["activadoPromo"] == "si") {
                                        if ($value[1] >= $precio['cantidad']) { //$value[1] es cantidad sumada de agrupados
                                            $total = $value[1] * $precio['promo'];
                                            $precioP = $precio['promo'];
                                        }
                                    
                                    } else {

    									if ($value[1] >= $precio['cantidad']) { //$value[1] es cantidad sumada de agrupados
    										$total = $value[1] * $precio['precio'];
    										$precioP = $precio['precio'];
                                        }
    								}
    							}
                            ?>

                                <tr class="trPrecio">
                                    <th scope="row"></th>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        Precio: 
                                    </td>
                                    <td class="tdPrecio">
                                    	<p id="txt-precio">$<?php echo $precioP ?></p>
                                    </td>
                                </tr>

                                <tr class="trTotal">
                                    <th scope="row"></th>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        Total: 
                                    </td>
                                    <td class="tdTotal">
                                    	<p class="tTotal" id="txt-total" total="<?php echo $total; ?>">
                                    		<?php echo '$'.$total; 
                                            $mTotal = $mTotal + $total;
                                            ?>
                                    	</p>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">
                                    </th>
                                </tr>
							<?php
                    echo '</tbody>
                        </table>';
							}
							?>

                            
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart_totals_area">
                    <h4>Total del Carrito</h4>
                    <div class="cart_t_list">
                    </div>
                    <div class="total_amount row m0 row_disable">
                        <div class="float-left">
                            Total
                        </div>
                        <div class="float-right" id="montoTotal" montoTotal="">
                            <?php echo "$".number_format($mTotal,"2",".",","); ?>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn subs_btn form-control" id="btnMontoTotal" cliente="<?php echo $_SESSION['id'] ?>">Continuar Compra</button>
            </div>
        </div>
    </div>
</section>







<?php
	include 'fix/footer.php';
    $eliminarProductoCarrito = new ControladorCarrito();
    $eliminarProductoCarrito -> ctrEliminarProductoCarrito();

} else {

?>

<!--================login Area =================-->
<section class="emty_cart_area p_100">
    <div class="container">
        <div class="emty_cart_inner">
            <i class="icon-handbag icons"></i>
            <h3>Tu carrito esta vacío</h3>
            <h4>regresar a <a href="inicio">inicio</a>.</h4>
        </div>
    </div>
</section>
<!--================End login Area =================-->

<?php
	include 'fix/footer.php';

}

?>