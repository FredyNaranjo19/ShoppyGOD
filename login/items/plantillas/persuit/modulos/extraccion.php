<?php
	include 'fix/header.php';

    // $tituloCategorias = $visualCategorias[1];
    $tituloCategorias = "";
    
	if (isset($_GET["ca145te687go"])) {

        $item = "id_categoria";
        $valor = $_GET["isid45"];
        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $empresa["id_empresa"]);
        


    } else if (isset($_GET["sub244ca747te"])) {

        $item = "id_subcategoria";
        $valor = $_GET["isSubid"];
        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor, $empresa["id_empresa"]);


    } else if (isset($_GET["s36a7r5c43"])) {
        
        $dato = $_GET["found789"];
        $respuesta = ControladorProductos::ctrMostrarProductosBuscados($dato, $empresa["id_empresa"]);

  
    } else {

        $item = null;
        $valor = null;

        $respuesta = ControladorProductos::ctrMostrarProductos($item,$valor, $empresa["id_empresa"]);
       
    } 
    //var_dump($respuesta);
?> 

<!--================Categories Banner Area =================-->
<section class="categories_banner_area">
    <div class="container">
        <div class="c_banner_inner">
            <h3><?php echo $visualizaciones[0]['Busqueda_BannerTxt'] ?></h3>
            <!-- <h3>Categorias</h3> -->
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li class="current"><a href="#">Categorias</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<!--================Categories Product Area =================-->
<section class="no_sidebar_2column_area">
    <div class="container">
        <div class="two_column_product">
            <div class="row">
            <?php
            if (sizeof($respuesta) > 0) {
                $arrayProductos = array();

                foreach ($respuesta as $key => $pValue) {
                    
                    if ($key <= 11) {
                        $item = "id_producto";
                        $valor = $pValue["id_producto"];
                        $producto = ControladorProductos::ctrMostrarInformacionGeneralProducto($item, $valor);
                        

            ?>
                        <div class="col-lg-3 col-sm-6">
                            <div class="l_product_item">
                                <div class="l_p_img">
                                    <img class="img-fluid" src="<?php echo $pValue["imagen"]; ?>" alt="<?php echo $producto["nombre"]; ?>">
                                    <?php 
                                        
                                        $datos = array("id_empresa" => $pValue["id_empresa"],
                                                        "codigo" => $pValue['codigo']);

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
                                            <a href="#" class="btn-details" role="button" idProducto="<?php echo $pValue['id_producto']; ?>" nombre="<?php echo $producto["nombre"]; ?>" style="cursor: pointer; font-size:1.5em;">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </li>
                                        

                                        <!-- SECTION BOTTON AGREGAR PRODUCTO AL CARRITO DE COMPRAS -->
                                        <li>
                                        <?php if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {
                                            
                                            if ($producto["stock_disponible"] > 0) {
                                                
                                                echo '<a class="add_cart_btn addBtn" href="#" idProducto="'.$pValue["id_producto"].'" addVal="0" idCliente="'.$_SESSION["id"].'" modelo="'.$pValue["codigo"].'" empresa="'.$pValue["id_empresa"].'">
                                                    <i class="fa fa-shopping-cart"></i> Agregar
                                                </a>';

                                            } else {
                                                
                                                echo "<p style='color: red;'>AGOTADO</p>";

                                            } 

                                         

                                        } else {
                                            
                                            if ($producto["stock_disponible"] > 0) { //SE CAMBIO $pValue por $producto

                                                echo '<a class="add_cart_btn addBtn" href="#" idProducto="'.$pValue[0].'" addVal="1">
                                                            <i class="fa fa-shopping-cart"></i> Agregar
                                                      </a>';

                                            } else{

                                                echo "<p style='color: red;'>AGOTADO</p>";

                                            } 

                                        } ?>
                                        </li>
                                        
                                        <!-- SECTION BOTTON AGREGAR PRODUCTO A MIS FAVORITOS -->
                                        <li class="p_icon">
                                            <?php
                                            if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { 

                                            $datos = array("id_cliente" => $_SESSION["id"],
                                                            "id_producto" => $pValue['id_producto']);

                                            $resultadosFav = ControladorProductos::ctrMostrarFavoritos($datos);

                                                if ($resultadosFav != false ) {
                                            ?>
                                                <p href="#" class="heartsA" Aheart="1" id="btnHeart" addVal="1" idProducto="<?php echo $pValue['id_producto'] ?>" idCliente="<?php echo $_SESSION["id"] ?>">
                                                    <i class="fa fa-heart"></i>
                                                </p>

                                            <?php
                                                } else {
                                            ?>

                                                <p href="#" class="hearts" Aheart="0" id="btnHeart" addVal="1" idProducto="<?php echo $pValue['id_producto'] ?>" idCliente="<?php echo $_SESSION["id"] ?>">
                                                    <i class="fa fa-heart"></i>
                                                </p>

                                            <?php 
                                                }
                                            } else {
                                            ?>

                                                <p href="#" class="hearts" id="btnHeart" addVal="0">
                                                    <i class="fa fa-heart"></i>
                                                </p>

                                            <?php
                                            }
                                            ?>
                                        </li>


                                    </ul>
                                    <h4><?php echo $producto["nombre"]; ?></h4>
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
                    }

                    if ($key >= 12) {
                        $item = "id_producto";
                        $valor = $pValue["id_producto"];
                        $producto = ControladorProductos::ctrMostrarInformacionGeneralProducto($item, $valor);
                        
                        /* INICIANDO VARIABLES */
                        $tag = NULL;
                        $addVal = NULL;
                        $codigo = NULL;
                        $empresa = NULL;
                        $idCliente = NULL;
                        $Aheart = NULL;

                        $datos = array("id_empresa" => $pValue["id_empresa"],
                                        "codigo" => $pValue['codigo']);

                        $precioProducto = ControladorProductos::ctrMostrarPreciosProducto($datos);
                        //echo var_dump($precioProducto);
                        foreach ($precioProducto as $keyP => $precioVal) {
                            if ($keyP == 0) {
                                $activadoPromo = $precioVal["activadoPromo"];
                                $precio = $precioVal["precio"];
                                $promo = $precioVal["promo"];

                                if ($precioVal["activadoPromo"] == "si") {
                                    if ($visualizaciones[0]["Inicio_Etiqueta"] == "habilitado") {
                                        
                                        $tag = $visualizaciones[0]["Inicio_EtiquetaTxt"];

                                    }
                                }                                          
                           }
                        }

                        

                        if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {
                            $sesionUser = "si";
                            $idCliente = $_SESSION["id"];

                            /* SECCION DE AGREGAR */
                            if ($pValue["stock"] > 0) {

                                $addVal = 0;
                                $modelo = $pValue["codigo"];
                                $empresa = $pValue["id_empresa"];

                            } 

                            /* PRODUCTO FAVORITO */
                            
                            $valorFavC = $_SESSION["id"]; 
                            $valorFavP = $pValue[0];

                            $resultadosFav = ControladorProductos::ctrMostrarFavoritos($valorFavC,$valorFavP);

                            if ($resultadosFav != false ) {

                                $Aheart = 1;
                                $addValFavorito = 1;

                            } else {

                                $Aheart = 0;
                                $addValFavorito = 1;

                            }

                        } else {

                            $sesionUser = "no";

                            /* SECCION DE AGREGAR */
                            if ($pValue["stock"] > 0) {
                                $addVal = 1;  
                            } else {
                                $addVal = NULL;
                            } 

                            /* PRODUCTO FAVORITO */
                            $addValFavorito = 0;



                        }
                        
                        array_push($arrayProductos, array('imagen' => $pValue['imagen'],
                                                          'activadoPromo' => $activadoPromo,
                                                          'precio' => $precio,
                                                          'promo' => $promo,
                                                          'tag' => $tag,
                                                          'sesionUser' => $sesionUser,
                                                          'idCliente' => $idCliente,
                                                          'idProducto' => $pValue['id_producto'],
                                                          'nombre' => $producto["nombre"], // se cambio $pValue por $producto
                                                          'stock' => $producto["stock_disponible"], // se cambio $pValue por $producto
                                                          'addVal' => $addVal,
                                                          'modelo' => $pValue['codigo'],
                                                          'empresa' => $pValue['id_empresa'],
                                                          'Aheart' => $Aheart,
                                                          'addValFavorito' => $addValFavorito));
                                                          

                    }
                }
                //var_dump($arrayProductos);
            } else {
            
            ?>

                <h3>No se encontraron resultados.</h3>

            <?php
            }
            ?>
            </div>

            <div class="row" id="divProductosExtrac">

            </div>

            <div class="row">
               <div class="col-md-12 divButtonMostrarMas">
                <?php
                    if (sizeof($respuesta) >= 12) {
                ?>
                    <button type="button" class="btn btn-block" id="btnVermas"  style="background: rgba(240,255,255,0.8);cursor: pointer;">Ver más...</button>

                <?php
                
                    }
                ?>
                </div> 
            </div>
            
        </div>
    </div>
    
</section>
<!--================End Categories Product Area =================-->

<?php
    include 'fix/redes.php';
    include 'fix/footer.php';
?>


<script type="text/javascript">

    const arrayJS= <?php echo json_encode($arrayProductos);?>;

</script>
