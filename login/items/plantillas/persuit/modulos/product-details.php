<?php
include 'fix/header.php';
$item = "id_producto";
$valor = $_GET["pR06412"];

$producto = ControladorProductos::ctrMostrarProductoInfoCompleta($item, $valor);

?> 

<link itemprop="thumbnailUrl" href="<?php echo $producto['imagen'] ?>"> 
<span itemprop="thumbnail" itemscope itemtype=""> 
  <link itemprop="url" href="<?php echo $producto['imagen'] ?>"> 
</span>

<!--================Categories Banner Area =================-->
<section class="categories_banner_area">
    <div class="container">
        <div class="c_banner_inner">
            <h3><?php echo $visualizaciones[0]["Detalle_BannerTxt"] ?></h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="categorias">Categorias</a></li>
                <li class="current"><a href="#">Detalles</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<!--================Product Details Area =================-->
<section class="product_details_area">
    <div class="container">
        <div class="row">
        	<div class="col-md-5">
                <div class="imgViewNormal">
                        <img src="<?php echo $producto['imagen'] ?>" class="imgView active" no="1" alt="">

                    <?php
                        if($producto['imagen2'] != "" || $producto['imagen2'] != NULL){
                    ?>

                        <img src="<?php echo $producto['imagen2'] ?>" class="imgView desactive" no="2" alt="">

                    <?php
                        }

                        if($producto['imagen3'] != "" || $producto['imagen3'] != NULL){
                    ?>

                        <img src="<?php echo $producto['imagen3'] ?>" class="imgView desactive" no="3" alt="">
                        
                    <?php
                        }
                    ?>
                </div>

                <div class="row">

                        <div class="col-4 imgViewScale">
                            <img src="<?php echo $producto['imagen'] ?>" class="active imgViewS" no="1" alt="">
                        </div>

                    <?php
                        if($producto['imagen2'] != "" || $producto['imagen2'] != NULL){
                    ?>

                        <div class="col-4 imgViewScale">
                            <img src="<?php echo $producto['imagen2'] ?>" class="imgViewS" no="2" alt="">
                        </div>

                    <?php
                        }
                        
                        if($producto['imagen3'] != "" || $producto['imagen3'] != NULL){
                    ?>

                        <div class="col-4 imgViewScale">
                            <img src="<?php echo $producto['imagen3'] ?>" class="imgViewS" no="3" alt="">
                        </div>
                        
                    <?php
                        }
                    ?>
                </div>
            </div>

            <div class="col-md-7">
                <div class="product_details_text">
                	<h3><?php echo $producto['nombre'] ?></h3>

                	<!--=========================================
                    =            SECCION COMENTARIOS            =
                    ==========================================-->
                    <?php 
                    if ($visualizaciones[0]["Detalle_Comentarios"] == "habilitado") { 
                    ?>
                        <ul class="p_rating">

                            <?php
                            if ($producto['comentarios'] != 0) {
                                $nComentarios = $producto['comentarios'];
                                $puntos = $producto['puntos'];

                                $valorMaximo = $nComentarios * 5;
                                $res = ($puntos * 100)/$valorMaximo;
                            }else{
                                $res = 0;
                            }

                            if ($res == 0) {
                                echo '<li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>';
                            }else if ($res > 0 && $res <= 20) {
                                echo '<li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>';
                            } else if ($res > 20 && $res <= 40) {
                                echo '<li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>';
                            } else if ($res > 40 && $res <= 60) {
                                echo '<li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>';
                            } else if ($res > 60 && $res <= 80) {
                                echo '<li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>';
                            } else {
                                echo '<li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#" class="calif"><i class="fa fa-star"></i></a></li>';
                            }

                            ?>

                        </ul>
                        <div class="add_review">
                            <a href="#"><?php echo $producto['comentarios']." comentarios"; ?></a>
                        </div>
                    <?php 
                	}
                	?>

                    <!-- */********************  S T O C K  **************************** -->
                    <?php 
                    if ($visualizaciones[0]["Detalle_Stock"] == "habilitado") { 
                    ?>
 
                        <h6>
                        <?php 
                        if($producto['stock_disponible'] == NULL){

                            echo "<span>Stock</span> Disponible";

                        } else if($producto['stock_disponible'] <= 0){

                            echo "<span>Stock</span> No Disponible";

                        } else {

                            echo $producto['stock_disponible']." pzas. en <span>Stock</span>";

                        }
                        ?>
                        </h6>

                    <?php 
                	}
                	?>

                	<!-- ******************** P R E C I O ******* P R O D U C T O ********************** -->
                    <?php

                    $datos = array("id_empresa" => $producto['id_empresa'],
                                	"codigo" => $producto['codigo']);
                        
                   	$respuesta = ControladorProductos::ctrMostrarPreciosProducto($datos);

                        foreach ($respuesta as $key => $precio) {
                            if ($key == 0) {
                                if ($precio["activadoPromo"] == "si") {
                                    echo "<h4 id='precioMuestraDetalle' style='color: red;'>
                                                <del style='color: gray;'>$ ".number_format($precio["precio"],2,".",",")."</del> 
                                                $".number_format($precio["promo"],2,".",",")." p/pza.
                                        </h4>";
                                } else {
                                    echo "<h4 id='precioMuestraDetalle' style='color: red;'>$ ".number_format($precio["precio"],2,".",",")." p/pza.</h4>";
                                }     
                            }
                        }

                    ?> 

                    <!-- ******************** C A N T I D A D ******* P R O D U C T O ********************** -->

                    <div class="quantity">
                        <div class="custom">
                            <button  class="reduced items-count" type="button" id="signo-menos" disabled>
                                <i class="icon_minus-06"></i>
                            </button>


                            <!--==============================================================
                            =            SECCION DE CANTIDAD DEL PRODUCTO A PEDIR            =
                            ===============================================================-->
                            
                            <?php 
                            if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { 

                                $datos = array("id_producto" => $producto['id_producto'],
                                                "id_cliente" => $_SESSION['id'],
                                                "opcion" => 1);

                                $respuestaStock = ControladorCarrito::ctrMostrarCarrito($datos);
 
                                if (sizeof($respuestaStock) > 0) {
                                    foreach ($respuestaStock as $keyStock => $valueStock) {
                                        if ($keyStock == 0) {
                                            
                                            $piezas =  $producto['stock'] - $valueStock['cantidad'];
                                            
                                        }
                                    }

                            ?> 

                                    <input type="text" name="qty" 
                                		id="cantidad-text" 
                                		max="<?php echo $piezas ?>" 
                                		value="1" 
                                		min="1" 
                                		title="Quantity:" 
                                		listado="<?php echo $producto['codigo'] ?>" 
                                		empresa="<?php echo $empresa['id_empresa'];?>" 
                                		class="input-text qty">

                            <?php

                                }else{

                            ?>

                                    <input type="text" name="qty" 
                                		id="cantidad-text" 
                                		max="<?php echo $producto['stock'] ?>" 
                                		listado="<?php echo $producto['codigo'] ?>" 
                                		empresa="<?php echo $empresa['id_empresa'];?>" 
                                		value="1" 
                                		min="1" 
                                		title="Quantity:" 
                                		class="input-text qty">

                            <?php 

                        		}
                            } else { 

                            ?> 

                                    <input type="text" name="qty" 
                                    	id="cantidad-text" 
                                    	max="<?php echo $producto['stock'] ?>" 
                                    	value="1" 
                                    	min="1" 
                                    	title="Quantity:" 
                                    	listado="<?php echo $producto['codigo'] ?>" 
                                    	empresa="<?php echo $empresa['id_empresa'];?>" 
                                    	class="input-text qty">

                            <?php 
                        	
                        	}

                        	?>
                            
                            <!--====  End of SECCION DE CANTIDAD DEL PRODUCTO A PEDIR  ====-->

                            <button class="increase items-count" type="button" id="signo-mas">
                                <i class="icon_plus"></i>
                            </button>

                        </div>

                        
                        <?php 
                        if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { 
                            if ($producto['stock'] > 0) {
                        ?>
                                
                                <a class="add_cart_btn" href="#" id="btn-agregar" 
                                	cliente="<?php echo $_SESSION['id']; ?>" 
                                	idProducto="<?php echo $producto['id_producto']; ?>" 
                                	listado="<?php echo $producto['sku']; ?>" 
                                	modelo="<?php echo $producto['codigo']; ?>" 
                                	empresa="<?php echo $producto['id_empresa']; ?>" 
                                	style="cursor:pointer;">

                                    <i class="fa fa-shopping-cart"></i> Agregar

                                </a> 

                                <a class="add_cart_btn" href="#" id="btn-comprar" 
                                	cliente="<?php echo $_SESSION['id']; ?>" 
                                	idProducto="<?php echo $producto['id_producto']; ?>" 
                                	listado="<?php echo $producto['sku']; ?>" 
                                	modelo="<?php echo $producto['codigo']; ?>" 
                                	empresa="<?php echo $producto['id_empresa']; ?>" 
                                	style="cursor:pointer;">

                                    <i class="fa fa-money"></i> Comprar

                                </a>
                        
                        <?php
                            }
                        }else{
                        ?>
                                
                                <a class="add_cart_btn" href="#" id="btn-agregar" 
                                	cliente="not" 
                                	idProducto="<?php echo $producto['id_producto']; ?>" 
                                	style="cursor:pointer;">

                                    <i class="fa fa-shopping-cart"></i> Agregar

                                </a>

                                <a class="add_cart_btn" href="#" id="btn-comprar" 
                                	cliente="not" 
                                	idProducto="<?php echo $producto['id_producto']; ?>" 
                                	style="cursor:pointer;">

                                    <i class="fa fa-money"></i> Comprar

                                </a>

                        <?php
                            }
                        ?>
                        
                        <?php

                        include 'fix/posicionamiento.php';

                        ?>


                        <div class="shareing_icon" style="padding-top: 5px;">
	                        <h5>Compartir :</h5>
	                        <ul>
	                            <?php
	                                $host= $_SERVER["HTTP_HOST"];
	                                $url= $_SERVER["REQUEST_URI"];

	                                $Share = "https://" . $host . $url;
	                            ?>

	                            <div class="a2a_kit a2a_kit_size_35 a2a_default_style" data-a2a-url="<?php echo $Share ?>" data-a2a-title=" ">
	                                <a class="a2a_button_whatsapp"></a>
	                            </div>
	                            <script async src="https://static.addtoany.com/menu/page.js"></script>
	                        </ul>
	                    </div>
                    </div>

                    <div class="product_table_details">
	                    <div class="table-responsive-md">
	                        <table class="table" style="width: 100%;">
	                            <tbody>
	                                <?php 
	                                if ($visualizaciones[0]["Detalle_CostoEnvio"] == "habilitado") { 
	                                ?>
	                                    <tr>
	                                        <th scope="row" style="width: 24%">Costo de envio:</th>
	                                        <td id="costoEnvio">
	                                            
	                                            <p style="font-size: 1.1em;margin: 0;padding-top:5px;">
                                                    Depende de la cantidad de productos que compre.
	                                            </p>
	                                        </td>
	                                    </tr>
	                                <?php 
	                            	}

	                                if ($visualizaciones[0]["Detalle_Envios"] == "habilitado") {
	                                ?>
	                                    <tr>
	                                        <th scope="row">Envios:</th>
	                                        <td>
	                                            <p>
	                                                El gasto de envio depende del número de piezas solicitadas.
	                                            </p>
	                                        </td>
	                                    </tr>
	                                <?php 
	                            	}
	                                if ($visualizaciones[0]["Detalle_FormasPago"] == "habilitado") {
	                                ?>
	                                    <tr>
	                                        <th scope="row">Metodos de Pago:</th>
	                                        <td>
	                                            <a href="#"><img src="../items/plantillas/demos/persuit/img/metodos.png" width="200px"></a>
	                                        </td>
	                                    </tr>
	                                <?php 
	                            	}
	                            	?>
	                            </tbody>
	                        </table>
	                    </div>
	                </div>


                </div>
            </div>

        </div>
    </div>
</section>
<!--================End Product Details Area =================-->


<!--================Product Description Area =================-->
<section class="product_description_area">
    <div class="container">
        <nav class="tab_menu">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
            	<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Descripción Producto</a>

                <?php
                if ($visualizaciones[0]["Detalle_Comentarios"] == "habilitado") {
                ?>

                	<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Comentarios</a>

                <?php
                }
                ?>
            </div>
        </nav>  
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <p><?php echo str_replace("\n", "<br>", $producto['descripcion']); ?>.</p>
            </div>

            <?php
            if ($visualizaciones[0]["Detalle_Comentarios"] == "habilitado") {
            ?>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                    <div class="col-md-5 col-xs-12">
                        <h3>Comentarios</h3>
                        <hr>
                        <?php
                        $comProducto = $producto["id_producto"];
                        $comCliente = NULL;
                        $NoComentario = 0;
                        $puntos = 0;
                        $porcentaje = 0;
                        $comentarios = ControladorProductos::ctrMostrarComentariosProducto($comProducto, $comCliente);
                        foreach ($comentarios as $key => $value) {
                            $puntos += $value["puntos"]; 
                        ?>

                            <div class="row">
                                <?php
                                $item = "id_cliente";
                                $valor = $value["id_cliente"];
                                $cliente = ControladorClientes::ctrMostrarClientes($item, $valor, $empresa["id_empresa"]);
                                ?>

                                <div class="col-md-6 col-sm-4 col-xs-2">
                                    <p style="font-weight: bold; font-size: 1.2em"><?php echo $cliente["nombre"] ?></p>
                                </div>
                                <div class="col-md-6 col-sm-8 col-xs-10">
                                    <ul>
                                    <?php

                                    for ($i=0; $i < $value["puntos"]; $i++) { 
                                        
                                    ?>

                                        <li><a href="#"><i class="fa fa-star"></i></a></li>

                                    <?php

                                    }

                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <p><?php echo $value["comentario"]; ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php
                            $NoComentario ++;

                            /* PORCENTAJE DEL PRODUCTO */
                            $valorMaximo = $NoComentario * 5;

                            $porcentaje = ($puntos * 100) / $valorMaximo;
                        }
                        ?>
                        
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div style="text-align: right">
                            <h1><?php echo $porcentaje."%"; ?></h1>
                        </div>
                        <div class="float-right">
                            <ul>
                                <?php if ($porcentaje > 0 && $porcentaje <= 20) {

                                    echo '<li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>';

                                } else if ($porcentaje > 20 && $porcentaje <= 40) {

                                    echo '<li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>';

                                } else if ($porcentaje > 40 && $porcentaje <= 60) {

                                    echo '<li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>';

                                } else if ($porcentaje > 60 && $porcentaje <= 80) {

                                    echo '<li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>';

                                } else if ($porcentaje > 80 && $porcentaje <= 100) {

                                    echo '<li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>
                                          <li><a href="#"><h3><i class="fa fa-star"></i></h3></a></li>';
                                }
                               
                                ?> 
                            </ul>
                        </div>
                    </div>
                </div>
                        
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<!--================End Product Details Area =================-->

<!--================End Related Product Area =================-->
<?php
if ($visualizaciones[0]["Detalle_ProductosRelacionados"] == "habilitado") {
?>

<section class="related_product_area">
    <div class="container">
        <div class="related_product_inner">
            <h2 class="single_c_title">
                Productos similares
            </h2>


            <?php

           $datos = array("id_subcategoria" => $producto['id_subcategoria'],
        					"id_producto" => $producto['id_producto'],
        					"cantidadMostrada" => 12,
                            "id_empresa" =>$empresa['id_empresa']);

            $rows = 0;
            $filas = 0;
 
            $prodSimilares = ControladorProductos::ctrMostrarProductosDiferente($datos);


            foreach ($prodSimilares as $key => $similar) {           
                if ($filas == 0) {
                    if ($rows == 0) {
                        echo '<div class="row" id="rows'.$rows.'" >';
                    } else {
                        echo '<div class="row" id="rows'.$rows.'" style="display:none;">';
                    }
                }
            ?>
                    <div class="col-lg-3 col-sm-6">
                        <div class="l_product_item">
                            <div class="l_p_img">
                                <img class="img-fluid" src="<?php echo $similar['imagen'] ?>" alt="">
                                <?php 

                                $datos = array("id_empresa" => $similar["id_empresa"],
                                                "codigo" => $similar['codigo']);

                                $precioProducto = ControladorProductos::ctrMostrarPreciosProducto($datos);

                                    foreach ($precioProducto as $keyP => $precioVal) {
                                        if ($keyP == 0) {
                                            if ($precioVal["activadoPromo"] == "si") {
                                                if ($visualizaciones[0]["Inicio_Etiqueta"] == "habilitado") {
                                                    echo '<h5 class="sale">'.$visualizaciones[0]["Inicio_EtiquetaTxt"].'</h5>';
                                                }
                                            }                                               
                                       }
                                    }
                                ?> 
                            </div>
                            <div class="l_p_text">


                               <ul> 
                                    <!-- SECTION BOTTON PARA VER DETALLES DEL PRODUCTO -->
                                    <li class="p_icon">
                                        <a href="#" class="btn-details" role="button" idProducto="<?php echo $similar['id_producto']; ?>" nombre="<?php echo $similar[1]; ?>" style="cursor: pointer; font-size:1.5em;">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </li>

                                    <!-- SECTION BOTTON AGREGAR PRODUCTO AL CARRITO DE COMPRAS -->


                                    <li>
                                        <?php if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {

                                        echo '<a class="add_cart_btn addBtn" href="#" id="btn-agregar" idProducto="'.$similar["id_producto"].'" addVal="0" idCliente="'.$_SESSION["id"].'" modelo="'.$similar["codigo"].'" empresa="'.$similar["id_empresa"].'">
                                                    <i class="fa fa-shopping-cart"></i> Agregar
                                              </a>';

                                        } else {

                                        echo '<a class="add_cart_btn addBtn" href="#" id="btn-comprar" idProducto="'.$similar["id_producto"].'" addVal="1">
                                                    <i class="fa fa-shopping-cart"></i> Agregar
                                              </a>';

                                        } ?>
                                    </li>



                                    <!-- SECTION BOTTON AGREGAR PRODUCTO A MIS FAVORITOS -->
                                    <li class="p_icon">
                                    <?php
                                    if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { 


                                        $datos = array("id_producto" => $similar['id_producto'],
                                                    	"id_cliente" => $_SESSION["id"]);

                                        $resultadosFavoritos = ControladorProductos::ctrMostrarFavoritos($datos);


                                        if ($resultadosFavoritos != false ) {
                                    ?>
                                           <p class="heartsA" Aheart="1" id="btnHeart" 
                                           		addVal="1" 
                                           		idProducto="<?php echo $similar["id_producto"] ?>" 
                                           		idCliente="<?php echo $_SESSION["id"] ?>">

                                                <i class="fa fa-heart"></i>

                                            </p>

                                    <?php

                                        } else {

                                    ?>

                                           <p class="hearts" Aheart="0" id="btnHeart" 
                                           		addVal="1" 
                                           		idProducto="<?php echo $similar["id_producto"] ?>" 
                                           		idCliente="<?php echo $_SESSION["id"] ?>">
                                                
                                                	<i class="fa fa-heart"></i>

                                            </p>

                                    <?php 

                                        }

                                    } else {

                                    ?>

                                        <p class="hearts" id="btnHeart" addVal="0">

                                            <i class="fa fa-heart"></i>

                                        </p>

                                <?php

                                    }
                                
                                ?>

                                    </li>
                                </ul>


                                <h4><?php echo $similar['nombre'] ?></h4>
                                <h5>
                                    <?php
                                        foreach ($precioProducto as $keyP => $precioVal) {
                                            if ($keyP == 0) {
                                                if ($precioVal["activadoPromo"] == "si") {
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
                $filas++;
                if ($filas > 3) {
                    echo "</div>";
                    $rows++;
                    $filas = 0;
                }
            }

            if ($filas > 0) {
                echo '</div>';
            }
            ?>

            <nav aria-label="Page navigation example" class="pagination_area">
              <ul class="pagination">

                <?php for ($i=0; $i < $rows ; $i++) { 
                    echo '<li class="page-item"><p class="page-link sectionProdLink" btnLink="'.$i.'">'.($i+1).'</p></li>';
                }
                ?>
              </ul>
            </nav>
        </div>
    </div>
</section>
<?php 
} 
?>
<!--================End Related Product Area =================-->

<?php
    include 'fix/redes.php';
    include 'fix/footer.php';
?>