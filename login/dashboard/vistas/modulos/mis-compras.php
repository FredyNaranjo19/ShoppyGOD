<?php
require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
// // Agrega credenciales
MercadoPago\SDK::setAccessToken($GlobalTokenMercado);
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mis Compras</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section> 

  <section class="content">
    <h5 class="mt-4 mb-2">Módulos y extenciones contratadas </h5>
        <div class="row">
          <?php
          //=======================Módulo de ventas a pagos===========================
          $respuesta = ControladorPagos::ctrMostrarPaquetePagos($empresa,$paqueteadq);
          foreach ($respuesta as $key => $value) {
            
            /* MOSTRAR CANTIDAD DE PAQUETE */
            $item = "id_creditos_precios";
            $valor = $value["id_creditos_precios"];
            $Precios = ModeloPagos::mdlMostrarPreciosEspacioPagos($item, $valor);
            //echo "<script>console.log($value[5])</script>";
             $fecha1= new DateTime($value[5]);
            $fecha2= new DateTime(date('Y-m-d'));
            $diff = $fecha1->diff($fecha2);
            $diff=$diff->days;
            $diff2=$diff;
            $porcent=($diff*100)/365;
            if($fecha1<$fecha2){
              $porcent=0;
              $diff=0;
            }

              
            echo '<div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-gradient-info">
                      <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Módulo: Ventas Pagos</span>
                        <span class="info-box-number">Espacios: '. $Precios[1] .'</span>
                        <div class="progress">
                          <div class="progress-bar" style="width: '. $porcent .'%"></div>
                        </div>
                        <span class="progress-description">
                        Restan '.$diff.' dias
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                   ';
                   $preference = new MercadoPago\Preference();
                   $items = array();
                   $total = $Precios[2];
                   $item  = new MercadoPago\Item();
            
            //echo "<script>console.log(".$porcent.")</script>";
            if($diff2<=10){
              if($fecha1<$fecha2){
                $item -> title = $Precios[1]." Espacios para manejo de pagos";
                $item -> quantity = 1;
                $item -> unit_price = floatval($total) * 1.16;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=espacios&serPa=".$value["id_creditos_precios"],
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
                  //var_dump($preference);
               // $preference -> payment_methods = $array;
                
                $preference -> save();
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
                $item -> title = "Renovar ".$Precios[1]."  espacios para manejo de pagos";
                $item -> quantity = 1;
                $item -> unit_price = floatval($total) * 1.16;

                array_push($items, $item);

                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=renovar&serPa=".$value["id_creditos_precios"],
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
                echo '<a class="btn btn-danger btndetalle notifibutton" style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Renovar';
                                    echo '</a>';
              }
            }else{
              if($fecha1<$fecha2){
                $item -> title = $Precios[1]." Espacios para manejo de pagos";
                $item -> quantity = 1;
                $item -> unit_price = floatval($total) * 1.16;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=espacios&serPa=".$value["id_creditos_precios"],
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
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
              echo '<a class="btn btn-info btndetalle"style="
              display: block; color: white;margin-bottom:1rem;">';
                                  echo ' En uso  <i class="far fa-calendar-check"></i></i>';
                                  echo '</a>';
              }
            }
          ?>
          
               <!-- /.info-box -->
               </div>  

          <?php
            }
          ?> 
          <!-- ==================== FIN DE Módulo de ventas a pagos ======================== -->
          <?php
          //=======================Módulo de almacenes===========================
          $item = NULL;
          $valor = NULL;
          $almacen = ControladorCompras::ctrMostrarComprasAlmacenes($item, $valor);
          foreach ($almacen as $key => $value) {
            /* MOSTRAR CANTIDAD DE PAQUETE */
            // $item = "almacen";
            // $valor = $value["id_creditos_precios"];
            // $Precios = ModeloPagos::mdlMostrarPreciosEspacioPagos($item, $valor);
            //echo "<script>console.log($value[5])</script>";
            $fecha1= new DateTime($value[5]);
            $fecha2= new DateTime(date('Y-m-d'));
            $diff = $fecha1->diff($fecha2);
            $diff=$diff->days;
            $diff2=$diff;
            $porcent=($diff*100)/365;
            if($fecha1<$fecha2){
              $porcent=0;
              $diff=0;
            }
            $item = "id_almacen";
            $valor = $value["id_almacen"];
            $almacen = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
              
            echo '<div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-gradient-info">
                      <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Almacen: '.substr($almacen[2], 0,15).'</span>
                        <span class="info-box-number">Costo: $800.00 + iva </span>
                        <div class="progress">
                          <div class="progress-bar" style="width: '. $porcent .'%"></div>
                        </div>
                        <span class="progress-description">
                        Restan '.$diff.' dias
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                   ';
                   $preference = new MercadoPago\Preference();
                   $items = array();
                   $item  = new MercadoPago\Item();
            
            //echo "<script>console.log(".$porcent.")</script>";
            if($diff2<=10){
              if($fecha1<$fecha2){
                $item -> title = "1 Almacen";
                $item -> quantity = 1;
                $item -> unit_price = 928;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                  "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=almacen&&id=".$value["id_almacenes_compras"],
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
                  //var_dump($preference);
               // $preference -> payment_methods = $array;
                
                $preference -> save();
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
                $item -> title = "Renovar Almacen";
                $item -> quantity = 1;
                $item -> unit_price = 928;

                array_push($items, $item);

                $preference -> items = $items;
                $preference -> back_urls = array(
                  "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=almacen&&id=".$value["id_almacenes_compras"],
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
                echo '<a class="btn btn-danger btndetalle notifibutton" style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Renovar';
                                    echo '</a>';
              }
            }else{
              if($fecha1<$fecha2){
                $item -> title = "1 Almacen";
                $item -> quantity = 1;
                $item -> unit_price = 928;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                  "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=almacen&&id=".$value["id_almacenes_compras"],
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
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
              echo '<a class="btn btn-info btndetalle"style="
              display: block; color: white;margin-bottom:1rem;">';
                                  echo ' En uso  <i class="far fa-calendar-check"></i></i>';
                                  echo '</a>';
              }
            }
          ?>
               <!-- /.info-box -->
               </div>  
          <?php
            }
          ?> 
          <!-- ==================== FIN DE Módulo de almacenes ======================== -->
          <?php
          //=======================Módulo de Usuarios===========================
          $item = NULL;
          $valor = NULL;
          $vendedores = ControladorCompras::ctrMostrarComprasVendedoresAlmacen($item, $valor);
          foreach ($vendedores as $key => $value) {
            /* MOSTRAR CANTIDAD DE PAQUETE */
            // $item = "almacen";
            // $valor = $value["id_creditos_precios"];
            // $Precios = ModeloPagos::mdlMostrarPreciosEspacioPagos($item, $valor);
            //echo "<script>console.log($value[5])</script>";
            $fecha1= new DateTime($value[5]);
            $fecha2= new DateTime(date('Y-m-d'));
            $diff = $fecha1->diff($fecha2);
            $diff=$diff->days;
            $diff2=$diff;
            $porcent=($diff*100)/365;
            if($fecha1<$fecha2){
              $porcent=0;
              $diff=0;
            }
            $tabla = "usuarios_plataforma";
            $item = "id_usuario_plataforma";
            $valor = $value["id_usuario_plataforma"];
            $usuario = ControladorUsuarios::ctrMostrarUsuario($tabla, $item, $valor);
            $item = "rol_nombre";
            $valor = $usuario[8];
            $precio = ControladorUsuarios::ctrMostrarRoles($item, $valor);
            //var_dump($precio);  
            echo '<div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-gradient-info">
                      <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">'.substr($usuario[8], 0,13).': '.substr($usuario[2], 0,10).'</span>
                        <span class="info-box-number">Costo: $'.$precio["precio"].' + iva </span>
                        <div class="progress">
                          <div class="progress-bar" style="width: '. $porcent .'%"></div>
                        </div>
                        <span class="progress-description">
                        Restan '.$diff.' dias
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                   ';
                   $preference = new MercadoPago\Preference();
                   $items = array();
                   $item  = new MercadoPago\Item();
            
            //echo "<script>console.log(".$porcent.")</script>";
            if($diff2<=10){
              if($fecha1<$fecha2){
                $item -> title = $precio["rol_nombre"];
                $item -> quantity = 1;
                $item -> unit_price = $precio["precio"]*1.16;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                  "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=Administrador General&&id=".$value["id_usuarios_plataforma_compras"]."&&precio=".$precio["precio"],
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
                  //var_dump($preference);
               // $preference -> payment_methods = $array;
                
                $preference -> save();
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
                $item -> title = "Renovar ".$precio["rol_nombre"];
                $item -> quantity = 1;
                $item -> unit_price = $precio["precio"]*1.16;

                array_push($items, $item);

                $preference -> items = $items;
                $preference -> back_urls = array(
                  "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=".$precio["rol_nombre"]."&&id=".$value["id_usuarios_plataforma_compras"]."&&precio=".$precio["precio"],
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
                echo '<a class="btn btn-danger btndetalle notifibutton" style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Renovar';
                                    echo '</a>';
              }
            }else{
              if($fecha1<$fecha2){
                $item -> title = "Renovar Vendedor Almacen";
                $item -> quantity = 1;
                $item -> unit_price = 928;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=vendedor_almacen&id=".$value["id_usuarios_plataforma_compras"],
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
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
              echo '<a class="btn btn-info btndetalle"style="
              display: block; color: white;margin-bottom:1rem;">';
                                  echo ' En uso  <i class="far fa-calendar-check"></i></i>';
                                  echo '</a>';
              }
            }
          ?>
               <!-- /.info-box -->
               </div>  
          <?php
            }
          ?> 
          <!-- ==================== FIN DE Módulo de Usuarios ======================== -->
          <?php
          //=======================Módulo de Productos tienda virtual===========================
          
          $respuesta = ControladorProductosTienda::ctrMostrarPaqueteProductosTV($empresa,$paqueteadq);
          
          foreach ($respuesta as $key => $value) {
            //var_dump($value);
            //echo "<script>console.log($value[0])</script>";
            /* MOSTRAR CANTIDAD DE PAQUETE */
            $item = "id_tv_productos_espacios_precios";
            $valor = $value["id_tv_productos_lista_compras"];
            $Precios = ModeloProductosTienda::mdlMostrarPreciosEspacioProducto($item, $valor);
            //var_dump($Precios);
            //echo "<script>console.log($value[5])</script>";
            $fecha1= new DateTime($value[5]);
            $fecha2= new DateTime(date('Y-m-d'));
            $diff = $fecha1->diff($fecha2);
            $diff=$diff->days;
            $diff2=$diff;
            $porcent=($diff*100)/365;
            if($fecha1<$fecha2){
              $porcent=0;
              $diff=0;
              
            }
            
              
            echo '<div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box bg-gradient-info">
                      <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text">Módulo: Productos TV</span>
                        <span class="info-box-number">Espacios: '. $Precios[1] .'</span>
                        <div class="progress">
                          <div class="progress-bar" style="width: '. $porcent .'%"></div>
                        </div>
                        <span class="progress-description">
                        Restan '.$diff.' dias
                        </span>
                      </div>
                      <!-- /.info-box-content -->
                    </div>
                   ';
                   $preference = new MercadoPago\Preference();
                   $items = array();
                   $total = $Precios[2];
                   $item  = new MercadoPago\Item();
            
            //echo "<script>console.log(".$porcent.")</script>";
            if($diff2<=10){
              if($fecha1<$fecha2){
                $item -> title = $Precios[1]." Espacios para productos Tienda Virtual";
                $item -> quantity = 1;
                $item -> unit_price = floatval($total) * 1.16;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=productos&serPa=".$value["id_tv_productos_lista_compras"],
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
                  //var_dump($preference);
               // $preference -> payment_methods = $array;
                
                $preference -> save();
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
                $item -> title = "Renovar ".$Precios[1]."  espacios para productos Tienda Virtual";
                $item -> quantity = 1;
                $item -> unit_price = floatval($total) * 1.16;

                array_push($items, $item);

                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=renovarElementosEmpresa&elment=productos&precio=".$total."&serPa=".$value["id_tv_productos_compras"],
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
                echo '<a class="btn btn-danger btndetalle notifibutton" style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Renovar';
                                    echo '</a>';
              }
            }else{
              if($fecha1<$fecha2){
                $item -> title = $Precios[1]." Espacios para productos Tienda Virtual";
                $item -> quantity = 1;
                $item -> unit_price = floatval($total) * 1.16;
                array_push($items, $item);
                $preference -> items = $items;
                $preference -> back_urls = array(
                    "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=productos&serPa=".$value["id_tv_productos_lista_compras"],
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
                echo '<a class="btn btndetalle btn-success"style="
                display: block; color: white;margin-bottom:1rem;" href="'.$preference -> init_point.'">';
                                    echo ' Volver a comprar';
                                    echo '</a>';
              }else{
              echo '<a class="btn btn-info btndetalle"style="
              display: block; color: white;margin-bottom:1rem;">';
                                  echo ' En uso  <i class="far fa-calendar-check"></i></i>';
                                  echo '</a>';
              }
            }
          ?>
          
               <!-- /.info-box -->
               </div>  

          <?php
            }
          ?> 
          <!-- ==================== FIN DE Módulo Productos tienda virtual ======================== -->

          
        </div>
        <!-- /.row -->
  </section>
</div>

<!--===============================================================
=                MODAL RENOVAR CONTRATO VENDEDORES                =
================================================================-->

<div id="modalComprarUsuarios" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- ENCABEZADO DEL MODAL -->
      <div class="modal-header" style="background: #343A40; color:white;">
        <h4 class="modal-title">Renovación de Vendedor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      
      <!-- CUERPO DEL MODAL -->
      <div class="modal-body">
        <div class="box-body">
          <?php
            //require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
            // // Agrega credenciales
            //MercadoPago\SDK::setAccessToken($GlobalTokenMercado);
          ?>

          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-striped dt-responsive"  style="width: 100%">
                <thead>
                  <tr>
                    <th>Descripcion</th>
                    <th>Costo</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php
                      $preference = new MercadoPago\Preference();
                      $items = array();
                      $total = 590.00;
          
                      $item  = new MercadoPago\Item();
                      $item -> title = "Renovacion Vendedor";
                      $item -> quantity = 1;
                      $item -> unit_price = floatval($total) * 1.16;
          
                      array_push($items, $item);
          
                      $preference -> items = $items;
                      $preference -> back_urls = array(
                        "success" => $GlobalUrl."dashboard/index.php?ruta=renovacionElementosEmpresa&elment=vendedor_almacen",
                        "failure" => $GlobalUrl."dashboard/mis-compras",
                        "pending" => $GlobalUrl."dashboard/index.php?ruta=modulo-facturas-pending-compra"
                      );
          
                      $preference -> save();
                    ?>
                    <td>1</td>
                    <td>Vendedor Almacén</td>
                    <td>$<?php echo $total ?></td> 
                    <td>
                      <a type="button" class="btn btn-success btn-block" href="<?php echo $preference->init_point; ?>">
                        Comprar
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<!--=======  End of MODAL RENOVAR CONTRATO VENDEDORES  ========-->

