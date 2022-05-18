<?php
$elementos = ControladorCompras::ctrMostrarElementosEmpresa();

?>
<!-- <script>
    console.log("land");
</script> -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mi Tienda Virtual: Productos</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12"> 
          <div class="card">
            <div class="card-body">

            <div class="row">
              <div class="col-md-4">
                <button class="btn btn-success btnComprarEspaciosTV" data-toggle="modal" data-target="#modalCompraProductos">
                  Adquirir más espacio
                </button>
                <input style="visibility:hidden" type="text" class="contentEmpresaProd" value="<?php echo $elementos['productos_tv'] ?>">
              </div>

              <?php
                $item = NULL;
                $valor = NULL;
                $registro = 0;

                $respuesta = ControladorPlantillasTienda::ctrMostrarMisPlantillas($item, $valor);

                if ($respuesta != false) {
                  foreach ($respuesta as $key => $value) {
                    if($value[$value["estado"] == "activado"]){
              ?>
                      
                        <div class="col-md-8" style="text-align: right;">
                          <a class="btn btn-secondary" href="<?php echo $GlobalUrl.$_SESSION["aliasEmpresa_dashboard"] ?>" style="color:red;" target="_blank">Ver Tienda</a>
                        </div>
                      
              <?php
                    }
                  }
                }
              ?>

              </div>
              <br>

              <nav class="w-100 col-lg-12 navcl">
                <div class="nav nav-tabs" id="product-tab" role="tablist">
                  <a class="nav-item nav-link active" id="categorias-tab" data-toggle="tab" href="#tabs-categorias" role="tab" aria-controls="categorias-tabs" aria-selected="true">
                    Categorías
                  </a>
                  <a class="nav-item nav-link" id="product-tienda-tab" data-toggle="tab" href="#product-tienda" role="tab" aria-controls="product-tienda" aria-selected="true">
                    Productos en Tienda
                  </a>
                </div>
              </nav>

              <div class="tab-content col-lg-12 navcl" id="nav-tabContent">

                <div class="tab-pane fade show active" id="tabs-categorias" role="tabpanel" aria-labelledby="categorias-tab">
                  
                  <div class="card col-lg-12"> 

                    <div class="card-header">
                      <button type="button" class="btn btn-secondary btncs " data-toggle="modal" data-target="#modalAgregarCategoria">
                        Agregar Categoria
                      </button>
                      <button type="button" class="btn btn-secondary btncs" data-toggle="modal" data-target="#modalAgregarSubcategoria">
                        Agregar Subcategoria
                      </button>
                    </div>
                    
                    <div class="collapse show" id="collapseExample">
                      <div class="card-body">
                        
                        <div class="container">
                        <?php
                          $item = null;
                          $valor = null;
                          $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                          foreach ($respuesta as $key => $val) { 

                            $itemProductoS = "id_categoria";
                            $valorProductoS = $val['id_categoria'];

                            $respuestaProducto = ControladorProductosTienda::ctrMostrarCantidadProductosPorCategoria($itemProductoS, $valorProductoS);
                            
                        ?>

                          <div class="row div-categoria">
                            <table class="table table-hover" style="width: 100%;">
                              <tr>
                                <td width="10%">
                                  <button class="btn btn-sm pull-left btnCategoria" idC="<?php echo $val['id_categoria']; ?>" valor="0">
                                    <i class="fas fa-plus <?php echo 'btn-i'.$val['id_categoria']; ?>"></i>
                                  </button>
                                </td>

                                <td width="80%">
                                  <p><?php echo $val['nombre']; ?></p>
                                </td>
                                <td class="btnCatTable" width="10%">
                                  <div class="btn-group">
                                    <button class="btn btn-warning btn-sm btnEditarCategoria" data-toggle="modal" data-target="#modalEditarCategoria" idCate="<?php echo $val['id_categoria']; ?>" emp="<?php echo $_SESSION["idEmpresa_dashboard"] ?>" nameCate="<?php echo $val['nombre']; ?>">
                                      <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btnEliminarCategoria" idCate="<?php echo $val['id_categoria']; ?>" cantidad="<?php echo $respuestaProducto[0]; ?>">
                                      <i class="fas fa-times"></i>
                                    </button>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </div>

                          <div id="<?php echo 'divSucategoria'.$val['id_categoria']; ?>" class="ocultoDiv row">
                            <table class="table" style="width: 100%">
                            <?php

                              $item2 = "id_categoria";
                              $valor2 = $val['id_categoria'];
                              $res = ControladorCategorias::ctrMostrarSubCategorias($item2, $valor2);
                              foreach ($res as $key => $value) {

                                  $itemProductoS = "id_subcategoria";
                                  $valorProductoS = $value['id_subcategoria'];

                                  $respuestaProductoS = ControladorProductosTienda::ctrMostrarCantidadProductosPorCategoria($itemProductoS, $valorProductoS);
                                  
                            ?>
                              <tr>
                                <td width="80%">
                                  <?php echo $value['nombre']; ?>
                                </td>
                                <td width="20%">
                                  <div class="btn-group">
                                    <button class="btn btn-warning btn-sm btnEditarSubcategoria" data-toggle="modal" data-target="#modalEditarSubcategoria" idSub="<?php echo $value['id_subcategoria']; ?>" nameSub="<?php echo $value['nombre']; ?>">
                                      <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btnEliminarSubcategoria" idSub="<?php echo $value['id_subcategoria']; ?>" cantidad="<?php echo $respuestaProductoS[0]; ?>">
                                      <i class="fa fa-times"></i>
                                    </button>
                                  </div>
                                </td>
                              </tr>
                            <?php
                              }
                            ?>
                            </table> 
                          </div>
                        <?php
                          }
                        ?>
                        </div>
                      </div>
                    </div>
                    
                  </div>

                </div>

                <div class="tab-pane fade" id="product-tienda" role="tabpanel" aria-labelledby="product-tienda-tab">
                  
                  <div class="row">
                    

                    <div class="col-md-12 ">
                      <div class="card">
                        <div class="card-header">
                          <h4>
                            Productos en punto de venta
                          </h4>
                        </div>
                        <div class="card-body">
                          <table   class="table table-striped table-bordered tablas dt-responsive" style="width: 100%;">
                            <thead>
                              <tr>
                                <th>Agregar</th>
                                <th>Modelo</th>
                                <th>Nombre</th>
                                <th>Stock</th>                                
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $item = NULL;
                                $valor = NULL;
                                $respuesta = ControladorProductosTienda::ctrMostrarProductosTienda($item, $valor);
  
                                $cantidadProductos = sizeof($respuesta);
  
                                $disponiblesTV = intval($elementos['productos_tv']) - intval($cantidadProductos);

                                ////////////////////////////////////////////////////////////////////////////////////////////

                                $item = NULL;
                                $valor = NULL;

                                $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

                                foreach ($respuesta as $key => $value) {
                              ?>
                              <tr id="trProductos<?php echo $value['id_producto'] ?>">
                              <td  class="tdButtonAgregarProducto">
                                  <?php
                                    $item = "id_producto";
                                    $valor = $value['id_producto'];
                                    $existenciaTV = ControladorProductosTienda::ctrMostrarProductosTienda($item, $valor);

                                    if (intval($cantidadProductos) <  intval($elementos["productos_tv"])) {

                                      if ($existenciaTV == false) {

                                  ?>

                                      <button style="font-size:.8rem;" class="btn btn-secondary btnAgregarProductoTienda recuperarBtnProducto" idProducto="<?php echo $value['id_producto'] ?>" sku="<?php echo $value["sku"] ?>" codigo="<?php echo $value["codigo"] ?>">
                                      <i class="fas fa-share-square"></i>
                                      </button>

                                  <?php
                                      } else {

                                        echo '<i class="far fa-check-circle"></i>';

                                      }
                                    
                                    } else {

                                      if ($existenciaTV == false) {
                                  ?>

                                      <button style="font-size:.8rem;" class="btn btn-default recuperarBtnProducto" idProducto="<?php echo $value['id_producto'] ?>" sku="<?php echo $value["sku"] ?>" codigo="<?php echo $value["codigo"] ?>">
                                      <i class="fas fa-share-square"></i>
                                      </button>

                                  <?php

                                      } else {

                                        echo '<i class="far fa-check-circle"></i>';

                                      }

                                    }

                                  ?>
                                </td>
                                <td>
                                  <?php echo $value['codigo']; ?>
                                </td>
                                <td>
                                  <?php 
                                    echo $value['nombre'];
                                    $carcateristicas = "";
                                    if ($value["caracteristicas"] != NULL) {
                                      
                                      $caracJson = json_decode($value["caracteristicas"],true);
                                      $carcateristicas = "<br>";
                                      foreach ($caracJson as $k => $val) {
                                        if ($k <= 2) {
                                            
                                          if ($val["caracteristica"] == "Color") {

                                            $carcateristicas .= $val["caracteristica"].': <i class="fas fa-circle" style="color:'.$val["datoCaracteristica"].';"></i>, ';
                                          
                                          } else {

                                            $carcateristicas .= $val["caracteristica"].': '.$val["datoCaracteristica"].', ';

                                          }

                                        }
                                      }

                                      $carcateristicas = substr($carcateristicas, 0, -2);
                                    }

                                    echo $carcateristicas; 
                                  ?>
                                </td>
                                <td>
                                  <?php
                                    if ($value["stock_disponible"] == 0) {
                                      echo "Agotado";
                                    }else{

                                      echo $value["stock_disponible"];
                                    }
                                  ?>
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

                    <div class="col-md-12 ">
                      <div class="card">
                        <div class="card-header">
                          <h4>
                            Productos en Tienda
                          </h4>
                          
                          <span>
                            <?php 
                              

                              echo "Espacios de productos disponibles en Tienda Virtual: <b id='bProductosDisponiblesTV'>".$disponiblesTV."</b> / <b>".$elementos['productos_tv']."</b>";
                            ?>
                          </span>
                        </div>
                        <div class="container">
                          <div class="row">
                            <div class="col-md-12">
                            <table id="tablaProductosEnTV" class="table table-striped table-bordered tablas dt-responsive" style="width:100%">
                                <thead>
                                  <tr>
                                    <th>
                                      Acciones
                                    </th>
                                    <th>
                                      Modelo
                                    </th>
                                    <th>
                                      Nombre
                                    </th>
                                    <th>
                                      Desc.
                                    </th>
                                    <th>
                                      stock disponible
                                    </th>

                                  </tr>
                                </thead>
                                <tbody id="tbodyProductosTienda">
                                
                                </tbody>
                              </table>
                            </div>
                              
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script>
          
          
        </script>

<!--====================================================================
=                COMPRAR ESPACIO DE PRODUCTOS EN TIENDA                =
=====================================================================-->

<div id="modalCompraProductos" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- ENCABEZADO DEL MODAL -->
      <div class="modal-header" style="background: #343A40; color:white;">
        <h4 class="modal-title">Compra de Espacios para productos en tienda virtual</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      
      <!-- CUERPO DEL MODAL -->
      <div class="modal-body">
        <div class="box-body">
          <?php
            require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
            // // Agrega credenciales
            MercadoPago\SDK::setAccessToken($GlobalTokenMercado);
            // MercadoPago\SDK::setAccessToken("APP_USR-4569372264265886-073118-6c0504c05802601d9b2620ce1a5d08af-192979879");
          ?>

          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-striped dt-responsive tblComprasProductos"  style="width: 100%">
                <thead>
                  <tr>
                    <th>No. Productos</th>
                    <th>Costo Anual</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $item = NULL;
                    $valor = NULL;
                    $respuesta = ControladorProductosTienda::ctrMostrarPreciosEspacioProducto($item, $valor);

                    foreach ($respuesta as $key => $value) {

                      $preference = new MercadoPago\Preference();
                      $items = array();

                      $total = $value["precio"] * 1.16;

                      $item  = new MercadoPago\Item();
                      $item -> title = $value["cantidad"]." productos";
                      $item -> quantity = 1;
                      $item -> unit_price = floatval($total);

                      array_push($items, $item);

                      $preference -> items = $items;
                      $preference -> back_urls = array(
                        "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=productos&serPa=".$value["id_tv_productos_espacios_precios"],
                        "failure" => $GlobalUrl."dashboard/mis-compras",
                        "pending" => $GlobalUrl."dashboard/index.php?ruta=modulo-facturas-pending-compra"
                      );
                      $preference -> auto_return ="approved";

                      $preference->payment_methods = array(
                        "excluded_payment_methods" => array(
                          array("id" => "master"),
                          array("id" => "digital_wallet")
                        ),
                        "excluded_payment_types" => array(
                          array("id" => "ticket"),
                          array("id" => "atm")
                        )
                      );

                      $preference -> save();
                    
                  ?>

                  <tr id="trEspacio<?php echo $value['id_tv_productos_espacios_precios'] ?>">
                    <td>
                      <?php echo $value["cantidad"] ?>
                    </td>
                    <td>
                      <?php echo $value["precio"]." + iva" ?>
                    </td>
                    <td>
                      <a class="btn btn-success" href="<?php echo $preference -> init_point; ?>">
                        Comprar
                      </a>
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
</div>

<!--=======  End of COMPRAR ESPACIO DE PRODUCTOS EN TIENDA  ========-->


<!--============================================
=            MODAL AGREGAR PRODUCTO            =
=============================================-->

<div class="modal fade" id="modalAgregarInformacionProductoTienda">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formCrearProductoTienda" accept-charset="utf-8" enctype="multipart/form-data">
         
        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Información Solicitada</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <!-- CUERPO DEL MODAL -->
        <div class="modal-body">     

          <input type="hidden" id="inputIdProductoPV" sku="" codigo="">

          <div class="row">
            <div class="col-md-6 mb-3">
              <h5 class="titprod"> Categoria:</h5>
              <div class="input-group">
                <select class="form-control input-lg" id="ProductonCategoria" required>
                  <option value="">Selecciona una categoria</option>
                  <?php
                    $item = NULL;
                    $valor = NULL;

                    $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                    foreach ($respuesta as $key => $value) {
                      echo '<option value="'.$value["id_categoria"].'">'.$value["nombre"].'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <h5 class="titprod"> Sub-Categoria:</h5>
              <div class="input-group">
                <select class="form-control input-lg" id="ProductonSubcategoria" required>
                  <option value="">Selecciona la subcategoria</option>
                </select>
              </div>
            </div>
          </div>
          
          <hr>
          <h4 class="card-text text-center">Imagenes</h4>
          <div class="container">
            <p class="card-text text-center">Peso máximo de la imagen 2 MB.</p>
          </div>

          <div class="row">
            <div class="col-md-4">
              <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenProducto1" style="object-fit: scale-down; height: 100px; width: 100%;">
              <div class="card-body">
                <h5 class="tittle-sec">Imagen 1</h5>
                <div id="txtCargaImagenProducto1"></div>
                <button type="button" class="btn btn-secondary btn-block" id="btnImagenProducto1New">
                  <i class="fas fa-folder-plus"></i>Seleccionar imagen
                </button>
                <input type="hidden" id="nombreImagenProducto1">
              </div>
            </div>


            <div class="col-md-4">
              <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenProducto2" style="object-fit: scale-down; height: 100px; width: 100%;">
              <div class="card-body">
                <h5 class="tittle-sec">Imagen 2</h5>
                <div id="txtCargaImagenProducto2"></div>
                <button type="button" class="btn btn-secondary btn-block" id="btnImagenProducto2New">
                  <i class="fas fa-folder-plus"></i>Seleccionar imagen
                </button>
                <input type="hidden" id="nombreImagenProducto2">
              </div>
            </div>

            <div class="col-md-4">
              <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenProducto3" style="object-fit: scale-down; height: 100px; width: 100%;">
              <div class="card-body">
                <h5 class="tittle-sec">Imagen 3</h5>
                <div id="txtCargaImagenProducto3"></div>
                <button type="button" class="btn btn-secondary btn-block" id="btnImagenProducto3New">
                  <i class="fas fa-folder-plus"></i>Seleccionar imagen
                </button>
                <input type="hidden" id="nombreImagenProducto3">
              </div>
            </div>
          </div>

          <div class="divPrecioProducto" existencia>
          </div>

        </div> 

        <!-- FOOTER DEL MODAL -->
        <div class="modal-footer justify-content-between" style="background: #343A40; color:white;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>
    </div>
  </div> 
</div>

<!--====  End of MODAL AGREGAR PRODUCTO  ====-->

<!--===================================================================
=            MODAL MOSTRAR INFORMACION DEL PRODUCTO TIENDA            =
====================================================================-->
  
<div id="modalMostrarInformacionPreciosTienda" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
 
      <div class="modal-header" style="background: #343A40; color:white;">
        <h4 class="modal-title">Mostrar información del producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>

      <div class="modal-body">
 
        <!-- CODIGO PESTAÑAS -->
        <nav class="w-100 col-lg-12 navcl mt-2">
          <div class="nav nav-tabs" id="productedt-tab" role="tablist">
            <a class="nav-item nav-link active" id="product-info-tab" data-toggle="tab" href="#product-info" role="tab" aria-controls="product-info" aria-selected="true">Información</a>
            
            <a class="nav-item nav-link" id="product-listado-tab" data-toggle="tab" href="#product-listado" role="tab" aria-controls="product-listado" aria-selected="false">Listado Precios</a>
          </div>
        </nav>
        <div class="tab-content col-lg-12 navcl" id="nav-tabContentEditar">
          <div class="tab-pane fade show active" id="product-info" role="tabpanel" aria-labelledby="product-info-tab"> 

            <div class="row" style="margin-top: 10px;">
              <!-- Modelo -->
              <div class="col-md-6 mb-3">
                <h5 class="titprod"> Modelo:</h5>
                <div class="input-group">
                  <div id="inputname" class="input-group-prepend">
                  </div>
                  <input type="text" class="form-control input-lg" id="modeloProductoTienda" readonly>
                </div>
              </div>

              <!-- Nombre -->
              <div class="col-md-6 mb-3">
                <h5 class="titprod"> Nombre:</h5>
                <div class="input-group">
                  <div class="input-group-prepend">
                  </div>
                  <input type="text" class="form-control input-lg" id="nombreProductoTienda" readonly>
                </div>
              </div>
            </div> 


            <form id="formEditarProductoTienda">
              <input type="hidden" id="idProductoTienda" sku>
              <!-- Categorias y subcategorias -->
              <div class="row">
                <div class="col-md-6 mb-3">
                  <h5 class="titprod"> Categoria:</h5>
                  <div class="input-group">
                    <select class="form-control input-lg" id="categoriaProductoTienda">
                      <option value="" id="categoriaProductoTiendaSeleccion"></option>
                      <option value="" disabled readonly style="background: gray; color: white;">Selecciona una categoria</option>
                      <?php
                        $item = NULL;
                        $valor = NULL;

                        $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                        foreach ($respuesta as $key => $value) {
                          echo '<option value="'.$value["id_categoria"].'">'.$value["nombre"].'</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <h5 class="titprod"> Subcategoria:</h5>
                  <div class="input-group">
                    <select class="form-control input-lg" id="subcategoriaProductoTienda">
                      <option value="" id="subcategoriaProductoTiendaSeleccion">Selecciona una subcategoria</option>
                      
                    </select>
                  </div>
                </div>
              </div>



              <hr>
              <h4 class="card-text text-center">Imagenes</h4>
              <div class="container">
                <p class="card-text text-center">Peso máximo de la imagen 2 MB.</p>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenInfoProducto1" style="object-fit: scale-down; height: 100px; width: 100%;">
                  <div class="card-body">
                    <h5 class="tittle-sec">Imagen 1</h5>
                    <div id="txtCargaInfoImagenProducto1"></div>
                    <button type="button" class="btn btn-secondary btn-block" id="btnImagenInfoProducto1New">
                      <i class="fas fa-folder-plus"></i>Seleccionar imagen
                    </button>
                    <input type="hidden" id="nombreInfoImagenProducto1">
                  </div>
                </div>


                <div class="col-md-4">
                  <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenInfoProducto2" style="object-fit: scale-down; height: 100px; width: 100%;">
                  <div class="card-body">
                    <h5 class="tittle-sec">Imagen 2</h5>
                    <div id="txtCargaInfoImagenProducto2"></div>
                    <button type="button" class="btn btn-secondary btn-block" id="btnImagenInfoProducto2New">
                      <i class="fas fa-folder-plus"></i>Seleccionar imagen
                    </button>
                    <input type="hidden" id="nombreInfoImagenProducto2">
                  </div>
                </div>

                <div class="col-md-4">
                  <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenInfoProducto3" style="object-fit: scale-down; height: 100px; width: 100%;">
                  <div class="card-body">
                    <h5 class="tittle-sec">Imagen 3</h5>
                    <div id="txtCargaInfoImagenProducto3"></div>
                    <button type="button" class="btn btn-secondary btn-block" id="btnImagenInfoProducto3New">
                      <i class="fas fa-folder-plus"></i>Seleccionar imagen
                    </button>
                    <input type="hidden" id="nombreInfoImagenProducto3">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <button class="btn btn-primary btn-block" type="submit">
                    Guardar
                  </button>
                </div>
              </div>

            </form>

          </div>

          <!-- Edicion de lista de precios -->
          <div class="tab-pane fade" id="product-listado" role="tabpanel" aria-labelledby="product-listado-tab">
            <br>
            <div class="row">
              <div class="col-md-12">
                <table style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Cantidad</th>
                      <th>Precio Unidad</th>
                      <th>Precio Promoción</th>
                      <th>Activar promo</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="bodyListadoPreciosTienda">
                  </tbody>
                </table>
              </div>
            </div>
 
            <hr>

            <button type="button" class="btn btn-info btn-block btnListadoAgregarTienda mt-2" >Agregar precio a lista de precios</button>

            <div>
              <form id="formPrecioTienda" accept-charset="utf-8" style="display: none;">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <h5 class="titprod"> Número de piezas:</h5>
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="piezasListadoTienda" required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <h5 class="titprod"> Precio de venta por pieza:</h5>
                    <div class="input-group">
                      <input type="text" class="form-control input-lg" id="costoListadoTienda" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <button type="submit" class="btn btn-block btn-success btnNuevoPrecioTienda" codigo="">GUARDAR</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div> -
  
<!--====  End of MODAL MOSTRAR INFORMACION DEL PRODUCTO TIENDA  ====-->
  


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
      <!--=================================================================
      =            CODIGO PARA SECCION DE CATEGORIAS Y MODALES            =
      ==================================================================-->

<!--=============================================
=            AGREGAR NUEVA CATEGORIA            =
==============================================-->

<div id="modalAgregarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCrearCategoria" enctype="multipart/form-data">

        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Agregar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <?php
        $item = null;
        $valor = null;
        $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);
                
        ?>
        <div class="modal-body">
          <div class="box-body">

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Nombre :
                </span>
              </div>
              <input type="text" class="form-control input-lg" id="nombreCategoria" placeholder="Escribe el nombre de la categoria" required>
            </div>
            <?php

              if (sizeof($respuesta) == 0) {
                $digito = 1;
              } else {
                $digito = intval(sizeof($respuesta)) + 1;
              }
              

              $nombreCategoriaIMG = "categoria_".$_SESSION["idEmpresa_dashboard"]."_".$digito;
            ?>

            <input type="hidden" id="nombreImagenCategoria" value="<?php echo $nombreCategoriaIMG ?>">

            <p class="card-text text-center">Peso máximo de la imagen 2 MB.</p>
            <div class="mb-3">
              <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="viewImagenCategoria" style="object-fit: scale-down; height: 100px; width: 100%;">
              <div class="card-body">
                <h5 class="tittle-sec">Imagen Categoria</h5>
                <div id="txtCargaCategoriaImagen"></div>
                <button type="button" class="btn btn-secondary btn-block" id="btnImagenCategoria"> 
                  <i class="fas fa-folder-plus"></i>Seleccionar imagen
                </button>

                <input type="hidden" id="urlImagenCategoria">
                
              </div>
            </div>


          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>


      </form>
    </div>
  </div>
</div>

<!--====  End of AGREGAR NUEVA CATEGORIA  ====-->

<!--======================================
=            EDITAR CATEGORIA            =
=======================================-->

<div id="modalEditarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarCategoria" enctype="multipart/form-data">

        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Editar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                Categoria
              </span> 
            </div>
            <input type="text" class="form-control input-lg" id="eNameCategoria" required>
            <input type="hidden" id="eIdCategoria">
          </div>

          <input type="hidden" id="eNombreImgCategoria" value="<?php echo $nombreCategoriaIMG ?>">

          <p class="card-text text-center">Peso máximo de la imagen 2 MB.</p>
          <div class="mb-3">
            <img src="../items/img/subirImagen.png" class="card-img-top galeria img-thumbnail" id="eViewImgCategoria" style="object-fit: scale-down; height: 100px; width: 100%;">
            <div class="card-body">
              <h5 class="tittle-sec">Imagen Categoria</h5>
              <div id="eTxtCargaCategoria"></div>
              <button type="button" class="btn btn-secondary btn-block" id="eBtnImgCategoria">
                <i class="fas fa-folder-plus"></i>Seleccionar imagen
              </button>

              <input type="hidden" id="eUrlImgCategoria">
              
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

<!--====  End of EDITAR CATEGORIA  ====-->

<!--================================================
=            AGREGAR NUEVA SUBCATEGORIA            =
=================================================-->

<div id="modalAgregarSubcategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCrearSubcategoria" enctype="multipart/form-data">

        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Agregar Subcategoria</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="text" class="form-control input-lg" id="nNombreSubcategoria" placeholder="Escribe el nombre de la subcategoria" required>
          </div>

          <div class="input-group mb-3">
            <select class="form-control input-lg" id="optionCategoria">
              <option value="">Selecciona la categoria...</option>
              <?php
                $item = NULL;
                $valor = NULL;

                $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                foreach ($respuesta as $key => $value) {
                  echo '<option value="'.$value['id_categoria'].'">'.$value['nombre'].'</option>';
                }
              ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>

<!--====  End of AGREGAR NUEVA SUBCATEGORIA  ====-->

<!--=========================================
=            EDITAR SUBCATEGORIA            =
==========================================-->

<div id="modalEditarSubcategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarSubcategoria" enctype="multipart/form-data">

        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Editar Categoria</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  Subcategoria
                </span>
              </div>
              <input type="text" class="form-control input-lg" id="eNameSubcategoria" required>
              <input type="hidden" id="eIdSubcategoria">
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Modificar</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

<!--====  End of EDITAR SUBCATEGORIA  ====-->