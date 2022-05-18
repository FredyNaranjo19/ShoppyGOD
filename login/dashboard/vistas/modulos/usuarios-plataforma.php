<?php
$tabla = "usuarios_plataforma";
$item = NULL;
$valor = NULL;
$usuarios = ControladorUsuarios::ctrMostrarUsuario($tabla, $item, $valor);


?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?>(Administrar de Usuarios). </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
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
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <?php
              /* ELEMENTOS DE LA EMPRESA */
              $elementos = ControladorCompras::ctrMostrarElementosEmpresa();

              $Nousuarios = intval($elementos["administrador"]) + intval($elementos["administrador_almacen"]) + intval($elementos["vendedores_almacen"]);
              
              if (sizeof($usuarios) < $Nousuarios) {
              ?>
                <button class="btn btn-secondary btnColorCambio btnCrearUsuario" data-toggle="modal" data-target="#modalAgregarUsuario">
                  Agregar Usuario
                </button>
              <?php
              }
              ?>
              <button type="button" class="btn btn-secondary btnColorCambio float-right" data-toggle="modal" data-target="#modalComprarUsuarios">
                Comprar Usuario
              </button>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                  <tr>
                    <th style="width: 10px;">#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Perfil</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                /*=================================================
                =            MOSTRAR USUARIOS EN TABLA            =
                =================================================*/
              
                  
                  foreach ($usuarios as $key => $value) {

                    echo '<tr>
                            <td>'.($key+1).'</td>
                            <td>'.$value['nombre'].'</td>
                            <td>'.$value['email'].'</td>
                            <td>'.$value['telefono'].'</td>';

                            if ($value["estado"] !=0) {

                              echo '<td><Button class="btn btn-secondary btnColorCambio btn-xs btnEstadoUsuario" idUsuario="'.$value["id_usuario_plataforma"].'" estadoUsuario="0">Activado</Button></td>';

                            }else{

                              echo '<td><Button class="btn btn-danger btn-xs btnEstadoUsuario" idUsuario="'.$value["id_usuario_plataforma"].'" estadoUsuario="1">Desactivado</Button></td>';

                            }
                             

                      echo '<td>'.$value["rol"].'</td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-secondary btnColorCambio btnEditarUs" idrol="'.$value["rol"].'" idUs="'.$value["id_usuario_plataforma"].'" idalmac="'.$value["almacen"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-edit"></i></button>
                                
                              </div>
                            </td>
                          </tr>';

                  } 
                // <button class="btn btn-danger btnEliminarUsuario" idUsuario="'.$value["id_usuario_plataforma"].'"><i class="fa fa-trash"></i></button>
                /*=====  End of MOSTRAR USUARIOS EN TABLA  ======*/

               ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>



            <div class="divAlmacenUsuario" style="display: none;">
              <div class="mb-3">
                <h5 class="titprod"> Almacén:</h5>
                <div class="input-group">
                  <div class="input-group-prepend">
                  </div>
                  <select class="form-control" id="UsuariosnAlmacen">
                    <option value="" selected disabled>Selecciona el almacén...</option>
                    <?php
                      $item = NULL;
                      $valor = NULL;

                      $respuesta = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
                      foreach ($respuesta as $key => $value) {

                        echo '<option value="'.$value["id_almacen"].'">'.$value["nombre"].'</option>';

                      }
                    ?>
                  </select>
                </div>
              </div>
            </div>


          </div>

        </div>

        <div class="modal-footer">
          <!-- <button type="submit" class="btn btn-secondary btnColorCambio">Guardar</button> -->
        </div>
      <!-- </form> -->
    </div>
  </div>
</div>

<!--====  End of MODAL AGREGAR NUEVO USUARIO  ====-->

<!--==========================================
=            MODAL EDITAR USUARIO            =
===========================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarUsuario" method="POST">

        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Editar Usuario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">

          <div class="box-body">

            <div class="mb-3">
              <h5 class="titprod"> Nombre:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                </div>
                <input type="text" class="form-control input-lg" id="UsuarioseNombre" required>
                <input type="hidden" id="UsuarioseID">
              </div>
            </div>


            <div class="mb-3">
              <h5 class="titprod"> Email:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                </div>
                <input type="email" class="form-control input-lg" id="UsuarioseEmail" mail required>
              </div>
            </div>

            <div class="mb-3">
              <h5 class="titprod"> Password:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                </div>
                <input type="password" class="form-control input-lg" id="UsuariosePassword">
                <input type="hidden" id="UsuariospasswordActual">
              </div>
            </div>

            <div class="mb-3">
              <h5 class="titprod"> Teléfono:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                </div>
                <input type="text" class="form-control input-lg" id="UsuarioseTelefono" data-inputmask='"mask": "(999) 999-9999"' data-mask required>
              </div>
            </div>

            <div class="mb-3" id="almacenuseroption">
             

            </div>

          </div>

        </div>

        

        <div class="modal-footer">
          <button type="submit" class="btn btn-secondary btnColorCambio">Modificar</button>
        </div>
        
      </form>
    </div>
  </div>
</div>

<!--====  End of MODAL EDITAR USUARIO  ====-->

<!-- MODAL VER PAGOS VENTAS CEDIS -->
<div class="modal" id="modalComprarUsuarios">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            
            <!-- Modal Header -->
            <div class="modal-header" style="background: #343A40; color:white;">
                <h4 class="modal-title">Agregar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <?php
            require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
            // // Agrega credenciales
            MercadoPago\SDK::setAccessToken($GlobalTokenMercado);
          ?>
                
                <div class="tab-content" id="TabContenidoPagos">
                    <table id="tablaPagosVentaCedis" class="table table-bordered table-striped table-hover" style="width: 100%;">
    
                        <thead>
                            <tr>
                                <th>Usuario/Rol</th>
                                <th>Precio/Anual</th>
                                <th>Comprar</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    $item = NULL;
                    $valor = NULL;
                    $roles = ControladorUsuarios::ctrMostrarRoles($item, $valor);
                    
                    
                  foreach ($roles as $key => $value) {
                    if ($value["rol_nombre"]=="Administrador Almacen" || $value["rol_nombre"]=="Vendedor Almacen" || $value["rol_nombre"]=="Administrador Almacen " || $value["rol_nombre"]=="Vendedor Almacen "){  
                      $item = NULL;
                      $valor = NULL;
                      $almacenes = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);
                      if ($almacenes == True) {
                        ?>
                        <tr id="trEspacio<?php echo $value['id_usuarios_plataforma_roles'] ?>">
                  <td>
                    <?php echo $value["rol_nombre"] ?>
                  </td>
                  <td>
                    $<?php echo $value["precio"] ?>.00 + iva
                  </td>
                  <td>
                      <?php
                      $empresa=$_SESSION["idEmpresa_dashboard"];;
                      $preference = new MercadoPago\Preference();
                          $items = array();
                          $total = $value["precio"]*1.16;
                          $item  = new MercadoPago\Item();
                          $item -> title = $value["rol_nombre"];
                          $item -> quantity = 1;
                          $item -> unit_price = floatval($total);

                          array_push($items, $item);

                          $preference -> items = $items;
                          $preference -> back_urls = array(
                              "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=usuario&serPa=".$value["rol_nombre"]."&prec=".$total,
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
                          echo '<a class="btn btn-success" href="'.$preference -> init_point.'">';
                          echo ' Comprar';
                          echo '</a>';
                      
                    ?> 
                  </td>
                </tr>
                      <?php
                      }
                      
                    }else{
                      ?>
                        <tr id="trEspacio<?php echo $value['id_usuarios_plataforma_roles'] ?>">
                  <td>
                    <?php echo $value["rol_nombre"] ?>
                  </td>
                  <td>
                    $<?php echo $value["precio"] ?>.00 + iva
                  </td>
                  <td>
                      <?php
                      $empresa=$_SESSION["idEmpresa_dashboard"];;
                      $preference = new MercadoPago\Preference();
                          $items = array();
                          $total = $value["precio"]*1.16;
                          $item  = new MercadoPago\Item();
                          $item -> title = $value["rol_nombre"];
                          $item -> quantity = 1;
                          $item -> unit_price = floatval($total);

                          array_push($items, $item);

                          $preference -> items = $items;
                          $preference -> back_urls = array(
                              "success" => $GlobalUrl."dashboard/index.php?ruta=comprasElementosEmpresa&elment=usuario&serPa=".$value["rol_nombre"]."&prec=".$total,
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
                          echo '<a class="btn btn-success" href="'.$preference -> init_point.'">';
                          echo ' Comprar';
                          echo '</a>';
                      
                    ?> 
                  </td>
                </tr>
                      <?php
                    }
                    }
                  ?>  
                        </tbody>
    
                    </table>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>