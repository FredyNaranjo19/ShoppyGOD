
	
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="#" class="brand-link">

    <!-- <div class="row">
      <div class="col-md-4"> -->
        <img src="../items/img/Logo blanco.svg"
          alt="Yira Logo"
          class="brand-image img-circle elevation-3">
      <!-- </div>
      <div class="col-md-8"> -->
        <!-- <div style="width: 100%; height: 50px;"> -->
          <img class="brand-text" src="../items/img/yira_txt.png" style="width:50%; height:25px;object-fit: scale-down;"> 
        <!-- </div>   -->
      <!-- </div> -->
    <!-- </div> -->

  
    
    <!-- <span class="brand-text font-weight-light" style="width: 100%; max-height: 50px;"> -->
      
    <!-- </span> -->
	</a>

  <style>
    /* img{
      width:100%; 
      height:10px; 
      object-fit: scale-down;
    } */
  </style>

	<div class="sidebar" style="background-color: #00b4d8ff; padding:0">
    <nav class="mt-2" style="background-color: #000; "> 
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
      <?php
      if (isset($_SESSION["rol_dashboard"])) {
        
        echo '<input type="hidden" class="inputTipoUsuario" empresa="'.$_SESSION["idEmpresa_dashboard"].'" value="'.$_SESSION["rol_dashboard"].'">';

        /* CONSULTAR LOS ELEMENTOS QUE TIENE CONTRATADOS LA EMPRESA
				-------------------------------------------------- */
				
				$empresa = $_SESSION["idEmpresa_dashboard"];
        $respuestaEmpresaContenido = ModeloCompras::mdlMostrarElementosEmpresa($empresa);
        

        
        /* End of CONSULTAR LOS ELEMENTOS QUE TIENE CONTRATADOS LA EMPRESA
        -------------------------------------------------- */

      ?>

        <li class="nav-item">
          <a href="inicio" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>
              INICIO
            </p>
          </a>
        </li>

        

        <?php
          if ($_SESSION["rol_dashboard"] == "Cedis") {
            
        ?>
          <!-- <li class="nav-item">
            <a href="productos" class="nav-link">
              <i class="nav-icon fas fa-gift"></i>
              <p>
                PRODUCTOS
              </p>
            </a>
          </li> -->


          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>
                MI TIENDA VIRTUAL
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              
            <!-- clase text-center -->
              <li class="nav-item "> 
                <a href="tienda-productos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Mis productos</p>
                </a>
              </li>

              <!-- clase text-center -->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Pedidos
                      <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                    <a href="tienda-pedidos-sin-comprobante" class="nav-link  ml-4">
                      <i class="fas fa-circle fa-w-1" style="color:#EAEAEA;"></i>
                      <p>Sin Comprobantes</p>
                      <!-- <span class="badge badge-info right menuSin"></span> -->
                    </a>
                  </li>

                  <li class="nav-item ">
                    <a href="tienda-pedidos-pendientes" class="nav-link ml-4">
                      <i class="fas fa-circle fa-w-1" style="color:#EAEAEA;"></i>
                      <p class="text-left">Por valorar</p>
                      <!-- <span class="badge badge-info right menuComprobante"></span> -->
                    </a>
                  </li>
                
                  <li class="nav-item">
                    <a href="tienda-pedidos-preparacion" class="nav-link ml-4">
                      <i class="fas fa-circle fa-w-1" style="color:#EAEAEA;"></i>
                      <p>En Preparación</p>
                      <!-- <span class="badge badge-info right menuPreparacion"></span> -->
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="tienda-pedidos-guias" class="nav-link ml-4">
                      <i class="fas fa-circle fa-w-1" style="color:#EAEAEA;"></i>
                      <p>En Guias</p>
                      <!-- <span class="badge badge-info right menuGuias"></span> -->
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="tienda-pedidos-finalizados" class="nav-link ml-4">
                      <i class="fas fa-circle fa-w-1" style="color:#EAEAEA;"></i>
                      <p>Finalizados</p>
                    </a>
                  </li>

                </ul>
              

              </li>

              <!-- <li class="nav-item">
                <a href="tienda-plantillas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                    <p>Plantillas</p>
                </a>
              </li> -->

              <!-- <li class="nav-item">
                <a href="tienda-configuracion" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                    <p>Configuración</p>
                </a>
              </li> -->
                  

            </ul>
          </li>

          <li class="nav-item">
          <a href="tienda-proveedores" class="nav-link">
            <i class="nav-icon fas fa-store"></i>
            <p>
              TIENDA PROVEEDORES
            </p>
          </a>
        </li>
            
          <?php
            if ($respuestaEmpresaContenido["vendedores_externos"] !== "0") {
              // echo "HAY vendedores externos";
            
          ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-user-tag nav-icon"></i>
              <p>
                VENDEDOR EXT.
                <i class="right fas fa-angle-left"></i>
                <span class="badge badge-info right menuTotal"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="vendedorExt-pedidos-generar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Pedidos Solicitados</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vendedorExt-pedidos-pagos-aprobar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Pagos Aprobación</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vendedorExt-pedidos-cancelaciones" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Pedidos Cancelaciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vendedorExt-pedidos-cortes" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Pedidos Cortes</p>
                </a>
              </li>

              <?php
                if ($respuestaEmpresaContenido["vendedores_externos"] !== "0") {
                  // echo "HAY vendedores externos";
                
              ?>
              <li class="nav-item">
                <a href="vendedorext-pedidos-pagos-configuracion" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                    <p>Configuración pagos</p>
                </a>
              </li>
              <?php
                }
              ?>

            </ul>

          </li>

          <?php
            }
          ?>


        <?php 
        } else if ($_SESSION["rol_dashboard"] == "Administrador Almacen" || $_SESSION["rol_dashboard"] == "Administrador Almacen ") {
        
        ?>

        

          <li class="nav-item">
            <a href="embarques-almacen" class="nav-link">
              <i class="nav-icon fas fa-truck-loading"></i>
              <p>
                EMBARCACIONES
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="productos-almacen" class="nav-link">
              <i class="nav-icon fas fa-gift"></i>
              <p>
                PRODUCTOS ALMACÉN
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                VENTAS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="ventas-nueva" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Crear Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ventas-dia" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Ventas del día</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Administración 
                      <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="ventas-cortes" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                        <p>Cortes de caja</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="ventas-cancelaciones" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                        <p>Cancelaciones</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="ventas" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                        <p>Todas las ventas</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-check-alt"></i>
                <p>
                  PAGOS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="ventas-pagos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                      <p>Ventas Pagos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="ventas-pagos-historial" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                      <p>Pagos Historial</p>
                  </a>
                </li>
              </ul>
            </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                FACTURACIÓN A
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="facturacion-almacen" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Mis Facturas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="facturacion-almacen-nueva" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Nueva Factura</p>
                </a>
              </li>
            </ul>
          </li>

        <?php
        } else if($_SESSION["rol_dashboard"] == "Vendedor Almacen" || $_SESSION["rol_dashboard"] == "Vendedor Almacen "){
        ?>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                VENTAS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="ventas-nueva" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Crear Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ventas-dia" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Ventas del día</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="ventas-pagos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Pagos</p>
                </a>
              </li>
            </ul>
          </li>

      <?php
        } else if ($_SESSION["rol_dashboard"] == "Vendedor Externo") {      
      ?>
          <li class="nav-item">
            <a href="vendedorExt-pedidos" class="nav-link">
                <i class="fas fa-box nav-icon"></i>
                <p>PEDIDOS</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="vendedorExt-entregas" class="nav-link">
              <i class="fas fa-truck nav-icon"></i>
                <p>ENTREGAS</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="vendedorExt-cancelacion" class="nav-link">
              <i class="fas fa-ban nav-icon"></i>
                <p>CANCELACIONES</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="vendedorExt-pedidos-pagos" class="nav-link">
              <i class="fas fa-money-bill nav-icon"></i>
                <p>PAGOS</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="vendedorext-pedidos-dia" class="nav-link">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>PEDIDOS DEL DÍA</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="vendedorExt-pedidos-pagos-historial" class="nav-link">
              <i class="fas fa-history nav-icon"></i>
                <p>PAGOS HISTORIAL</p>
            </a>
          </li>


      <?php
        }else if ($_SESSION["rol_dashboard"] == "Vendedor Matriz"){
      ?>  
          <!-- P E S T A Ñ A   V E N T A S -->

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                VENTAS
                <i class="right fas fa-angle-left"></i>
                <span style="background-color: #00b4d8ff; color: #FFFFFF" class="badge right menuVentas"></span>
                <span class="menuEnPreparacion" hidden></span>
                <span class="menuEnGuia" hidden></span>
                <span class="menuListoSucursal" hidden></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="cedis-crear-venta" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Crear Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cedis-ventas-dia" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Ventas del día</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cedis-ventas" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Todas las ventas</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cedis-ventas-link" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>
                      Pedidos LinkWeb
                      <span class="badge right menuNotiLink"></span>
                    </p>
                </a>
              </li>

            </ul>
            
                
          </li>

          <!-- P E S T A Ñ A   P A G O S  -->

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                PAGOS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="cedis-ventas-pagos-clientes" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Ventas pagos</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cedis-ventas-pagos-historial" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                    <p>Pagos historial</p>
                </a>
              </li>

            </ul>
          </li>

           <!-- P E S T A Ñ A   F A C T U R A C I O N  -->

           <li class="nav-item">
            <a href="facturacion-cedis-nueva" class="nav-link">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                FACTURACION
              </p>
            </a>
            
          </li>
      
      
      <?php

        } 
      }

      ?>
        
        
      </ul>
    </nav>
	</div>
</aside>

<?php
//--------------->Checar Renovaciones o compras <---------------\\
  //--------------->Checar Renovaciones o compras de espacios Ventas a Pagos <---------------\\
  $item = NULL;
  $valor = NULL;
  $respuesta = ControladorPagos::ctrMostrarPreciosEspacioPagos($item, $valor);                    
  foreach ($respuesta as $key => $value) {
    $paqueteadq = $value["id_creditos_precios"];
    $tabla="creditos_compras";
    $empresa=$_SESSION["idEmpresa_dashboard"];;
    $existenciaPaque = ModeloPagos::mdlMostrarPaquetePagos($tabla, $empresa,$paqueteadq);
    if($existenciaPaque != false){
      $fecha1= new DateTime($existenciaPaque["fecha_proximo_pago"]);
      $fecha2= new DateTime(date('Y-m-d'));
      $diff = $fecha1->diff($fecha2);
      $diff=$diff->days;
      if($diff<=10){
        if($fecha1<$fecha2){
          
        }else{
          echo "<script>
            document.getElementById('notif').style.visibility='visible';
            document.getElementById('notif2').style.visibility='visible';
          </script>";
        }
      }
    }
  }
  //--------------->FIN DE Checar Renovaciones o compras de espacios Ventas a Pagos <---------------\\

  //--------------->Checar Renovaciones o compras de Usuarios <---------------\\
  
    
    $tabla="usuarios_plataforma_compras";
    $empresa=$_SESSION["idEmpresa_dashboard"];
    $item=NULL;
    $valor=NULL;
    $existenciausuarios = ModelosUsuarios::mdlMostrarUsuarios($tabla, $item, $valor, $empresa);
    foreach ($existenciausuarios as $key => $value) {
      if($value != false){
        $fecha1= new DateTime($value["fecha_proximo_pago"]);
        $fecha2= new DateTime(date('Y-m-d'));
        $diff = $fecha1->diff($fecha2);
        $diff=$diff->days;
        if($diff<=10){
          if($fecha1<$fecha2){
            
          }else{
            echo "<script>
              document.getElementById('notif').style.visibility='visible';
              document.getElementById('notif2').style.visibility='visible';
            </script>";
          }
        }
      }
    }
  //--------------->FIN DE Checar Renovaciones o compras de Usuarios <---------------\\
  //--------------->Checar Renovaciones o compras de Almacenes <---------------\\
  
    
  $tabla="almacenes_compras";
  $empresa=$_SESSION["idEmpresa_dashboard"];
  $item=NULL;
  $valor=NULL;
  $existenciausuarios = ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);
  foreach ($existenciausuarios as $key => $value) {
    if($value != false){
      $fecha1= new DateTime($value["fecha_proximo_pago"]);
      $fecha2= new DateTime(date('Y-m-d'));
      $diff = $fecha1->diff($fecha2);
      $diff=$diff->days;
      if($diff<=10){
        if($fecha1<$fecha2){
          
        }else{
          echo "<script>
            document.getElementById('notif').style.visibility='visible';
            document.getElementById('notif2').style.visibility='visible';
          </script>";
        }
      }
    }
  }
//--------------->FIN DE Checar Renovaciones o compras de Almacenes <---------------\\
//--------------->Checar Renovaciones o compras de espacios TV <---------------\\
$item = NULL;
$valor = NULL;
$respuesta = ControladorProductosTienda::ctrMostrarPreciosEspacioProducto($item, $valor);                    
foreach ($respuesta as $key => $value) {
  $paqueteadq = $value["id_tv_productos_espacios_precios"];
  $tabla="tv_productos_compras";
  $empresa=$_SESSION["idEmpresa_dashboard"];;
  $existenciaPaque = ModeloProductosTienda::mdlMostrarPaqueteEmpresa($tabla, $empresa,$paqueteadq);
  if($existenciaPaque != false){
    $fecha1= new DateTime($existenciaPaque["fecha_proximo_pago"]);
    $fecha2= new DateTime(date('Y-m-d'));
    $diff = $fecha1->diff($fecha2);
    $diff=$diff->days;
    if($diff<=10){
      if($fecha1<$fecha2){
        
      }else{
        echo "<script>
          document.getElementById('notif').style.visibility='visible';
          document.getElementById('notif2').style.visibility='visible';
        </script>";
      }
    }
  }
}
//--------------->FIN DE Checar Renovaciones o compras de espacios TV <---------------\\
?>
