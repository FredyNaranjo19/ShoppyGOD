<?php
if (!isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] != "ok"){

    header("Location:login");

}

include 'fix/header.php';

$datos = array("id_cliente" => $_SESSION["id"],
                "id_producto" => NULL);
$resultadosFav = ControladorProductos::ctrMostrarFavoritos($datos);

?>

<!--================Categories Banner Area =================-->
<section class="categories_banner_area">
    <div class="container">
        <div class="c_banner_inner">
            <h3>Lista de deseos</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li class="current"><a href="#">Lista de deseos</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<section class="no_sidebar_2column_area">
    <div class="container">
        <div class="two_column_product">
            <div class="row">
<?php
			foreach ($resultadosFav as $key => $value) {
			$item = "id_producto";
			$valor = $value["id_producto"];    

			$producto = ControladorProductos::ctrMostrarProductoInfoCompleta($item, $valor);
?>

			<div class="col-lg-3 col-sm-6">
                    <div class="l_product_item">
                        <div class="l_p_img">
                            <img class="img-fluid" src="<?php echo $producto["imagen"]; ?>" alt="">
                            <?php //if ($visualInicio[5] == "habilitado") {'.$visualInicio[6].'
                            // $item = "sku";
                            // $valor = $producto["sku"];
                            $datos = array("id_empresa" => $empresa["id_empresa"],
                                            "codigo" => $producto['codigo']);

                            $precioProducto = ControladorProductos::ctrMostrarPreciosProducto($datos);

                            foreach ($precioProducto as $keyP => $precioVal) {
                                if ($keyP == 0) {
                                    if($precioVal["activadoPromo"] == "si"){
                                       if ($visualizaciones[0]["Inicio_Etiqueta"] == "habilitado") {
                                            echo '<h5 class="sale">'.$visualizaciones[0]["Inicio_EtiquetaTxt"].'</h5>';
                                        }
                                    }
                                }
                            }
                            	// echo '<h5 class="sale">Sale</h5>';
                            //} ?> 
                        </div>
                        <div class="l_p_text">
                           <ul> 


                                <!-- SECTION BOTTON PARA VER DETALLES DEL PRODUCTO -->
                                <li class="p_icon">
                                	<a href="#" class="btn-details" role="button" idProducto="<?php echo $producto['id_producto']; ?>" nombre="<?php echo $producto['nombre']; ?>">
                                		<i class="fa fa-search"></i>
                                	</a>
                                </li>
                                

                                <!-- SECTION BOTTON AGREGAR PRODUCTO AL CARRITO DE COMPRAS -->
                                <li>

                                	<a class="add_cart_btn addBtn" href="#" idProducto="<?php echo $producto['id_producto'] ?>" addVal="0" idCliente="<?php echo $_SESSION["id"] ?>" listado="<?php echo $producto['sku'] ?>">
                                            <i class="fa fa-shopping-cart"></i> Agregar
                                      </a>

                                
                                </li>
                                
                                <!-- SECTION BOTTON AGREGAR PRODUCTO A MIS FAVORITOS -->
                                <li class="p_icon">
                                        <p href="#" class="heartsA" Aheart="1" id="btnHeart" addVal="1" idProducto="<?php echo $producto['id_producto'] ?>" idCliente="<?php echo $_SESSION["id"] ?>">
                                            <i class="fa fa-heart"></i>
                                        </p>
                                </li>


                            </ul>
                            <h4><?php echo $producto['nombre']; ?></h4>
                            <h5>
                                <?php
                                    
                                foreach ($precioProducto as $keyP => $precioVal) {
                                    if ($keyP == 0) {
                                        if($precioVal["activadoPromo"] == "si"){

                                           echo "<del>$".number_format($precioVal["precio"],2,".",",")."</del> $".number_format($precioVal["promo"],2,".",","); 

                                        } else {

                                            echo "$".number_format($precioVal["precio"],2,".",","); 
                                            
                                        }
                                    }                                          
                                }
                                ?> 
                            </h5>
                        </div>
                    </div>
                </div>



<?php
			}
?>

			</div>
		</div>
    </div>
</section>	

<?php

include 'fix/footer.php';
?>