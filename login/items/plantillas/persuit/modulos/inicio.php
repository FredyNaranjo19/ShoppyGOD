<!--======================================
=            INCLUIR MENU FIX            =
=======================================-->

<?php include 'fix/header-fix.php'; ?>   

<!--====  End of INCLUIR MENU FIX  ====-->

<div class="home_left_main_area">
	<!--==========================================
	=            INCLUIR MENU LATERAL            =
	===========================================-->
	
	<?php include 'fix/header-left.php'; ?>
	
	<!--====  End of INCLUIR MENU LATERAL  ====-->

	<div class="right_body">
        <div class="best_summer_banner">
            <img class="img-fluid" src="<?php 
                if($respuestaConfiguracion != false){
                        if($imagenes['PersuitInicioUrl'] != ''){
                            echo $imagenes['PersuitInicioUrl'];
                        } else {
                            echo '../persuit/img/bannerTienda.jpeg';
                        } 
                } else {
                    echo '../persuit/img/bannerTienda.jpeg';
                }?>">                       
        </div>
    

        <!--=========================================
        =            SECCION DE PRODUCTO            =
        ==========================================-->
    
        <?php 
            if ($visualizaciones[0]["Inicio_SeccionProducto"] == "habilitado") { 
        ?>
        
        <div class="latest_product_3steps">
            <div class="s_m_title">
                <h2><?php echo $visualizaciones[0]["Inicio_SeccionProductoTxt"] ?></h2>
            </div>
            <div class="l_product_slider owl-carousel">
                <div class="item">
                <?php
                $noProductos = 8;
                $fila = 1;
                $resultado = ControladorProductos::ctrMostrarProductosAzar($empresa["id_empresa"], $noProductos);
                
                foreach ($resultado as $key => $value) {

                    $item = "id_producto";
                    $valor = $value["id_producto"];
                    $infoProducto = ControladorProductos::ctrMostrarInformacionGeneralProducto($item, $valor);

                    if ($fila > 2) {
                        echo '</div>
                              <div class="item">';
                        $fila = 1;
                    }  
                ?>

                    <div class="l_product_item">
                        <div class="l_p_img">
                            <img src="<?php echo $value["imagen"] ?>" alt="<?php echo $infoProducto["nombre"] ?>">
                            <?php 
                            $datos = array("id_empresa" => $empresa["id_empresa"],
                                            "codigo" => $infoProducto['codigo']);

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
                            ?> 
                        </div> 
                        <div class="l_p_text">
                            <ul>

                                <!-- SECTION BOTTON PARA VER DETALLES DEL PRODUCTO -->
                                <li class="p_icon" >
                                    <a href="#" class="btn-details" id="btnDetalles" idProducto="<?php echo $value['id_producto']; ?>" nombre="<?php echo $infoProducto["nombre"]; ?>" style="cursor: pointer; font-size:1.5em;">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </li>

                                <!-- SECTION BOTTON AGREGAR PRODUCTO AL CARRITO DE COMPRAS -->
                                <li>
                                <?php if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {

                                    if($infoProducto["stock_disponible"] > 0) {
                                        
                                    echo '<a class="add_cart_btn addBtn" href="#" 
                                                idProducto="'.$value["id_producto"].'" 
                                                addVal="0" 
                                                idCliente="'.$_SESSION["id"].'" 
                                                modelo="'.$infoProducto["codigo"].'" 
                                                empresa="'.$value["id_empresa"].'">

                                            <i class="fa fa-shopping-cart"></i> Agregar

                                          </a>';

                                    } else{

                                        echo "<p style='color: red;'>

                                                AGOTADO

                                              </p>";
                                        
                                    } 

                                } else {

                                    if($infoProducto["stock_disponible"] > 0) {
                                        
                                        echo '<a class="add_cart_btn addBtn" 
                                                        href="#" 
                                                        idProducto="'.$value["id_producto"].'" 
                                                        addVal="1">

                                                <i class="fa fa-shopping-cart"></i> Agregar

                                            </a>';

                                    } else{

                                        echo "<p style='color: red;'>

                                            AGOTADO

                                        </p>";

                                    }

                                } ?>
                                </li>

                                <!-- SECTION BOTTON AGREGAR PRODUCTO A MIS FAVORITOS -->

                                <li class="p_icon">

                                <?php
                                if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { 

                                    $datos = array("id_producto" => $value['id_producto'],
                                                    "id_cliente" => $_SESSION["id"]);

                                    $resultadosFavoritos = ControladorProductos::ctrMostrarFavoritos($datos);


                                    if ($resultadosFavoritos != false ) {
                                ?>
                                        <p class="heartsA" Aheart="1" id="btnHeart" 
                                            addVal="1" 
                                            idProducto="<?php echo $value["id_producto"] ?>" 
                                            idCliente="<?php echo $_SESSION["id"] ?>">
                                            
                                                <i class="fa fa-heart"></i>

                                        </p>

                                <?php

                                    } else {

                                ?>

                                       <p class="hearts" Aheart="0" id="btnHeart" 
                                            addVal="1" 
                                            idProducto="<?php echo $value["id_producto"] ?>" 
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

                            <!-- NOMBRE DEL PRODUCTO -->
                            <h4><?php echo $infoProducto["nombre"]; ?></h4>

                            <!-- PRECIO DEL PRODUCTO -->
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



                <?php
                    $fila++;
                }
                ?>

                </div>

            </div>
        </div>

        <?php 
            }
        ?>
        <!--====  End of SECCION DE PRODUCTO  ====-->

        <!--=======================================
        =            SECCION CATEGORIA            =
        ========================================-->

        <?php 
            if ($visualizaciones[0]["Inicio_Categoria"] == "habilitado") { 
        ?>

        <div class="latest_product_3steps">

            <div class="row">

                <div class="peliculas-recomendadas contenedor">
                    <div class="contenedor-titulo-controles col-12">
                        <h3>
                            <?php 
                               echo $visualizaciones[0]["Inicio_CategoriaTxt"];
                            ?>  
                        </h3>
                        <div class="indicadores"></div>
                    </div>

                    <div class="contenedor-principal">
                        <button role="button" id="flecha-izquierda" class="flecha-izquierda"><i class="fa fa-angle-left"></i></button>

                        <div class="contenedor-carousel">
                            <div class="carousel">
                            <?php
                                $item = NULL;
                                $valor = NULL;
                                $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor, $empresa["id_empresa"]);

                            foreach ($categorias as $key => $value) {

                            ?>

                                <div class="pelicula">
                                    <a href="index.php?ruta=extraccion&&ca145te687go=<?php echo $value['nombre']; ?>&&nt4e54sv3=184&&isid45=<?php echo $value['id_categoria'] ?>">
                                        <div style="width: 100%;height: 160px;">
                                            <img src="<?php echo $value['imagen'] ?>" alt="<?php echo $value['nombre'] ?>">
                                        </div>
                                        <p><?php echo $value['nombre'] ?></p>
                                    </a>
                                </div>

                            <?php

                            }

                            ?>
                        
                                
                            </div>
                        </div>

                        <button role="button" id="flecha-derecha" class="flecha-derecha"><i class="fa fa-angle-right"></i></button>
                    </div>
                </div>
            
            </div>
            
        </div>

        <?php 
            } 
        ?>

        <!--====  End of SECCION CATEGORIA  ====-->

        <?php
            include 'fix/redes.php';
            include 'fix/footer-inicio.php';
        ?>
        
    </div>
</div>