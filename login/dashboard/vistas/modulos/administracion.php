<?php
if ($_SESSION["rol_principal"] == "Administrador" || $_SESSION["rol_principal"] == "Administrador General" ) {
  $deuda = "no";
  ?>
  <script>
  console.log("Admin");
</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row mb-2">
      <div class="col-md-5" style="margin-left: 5%;">
        <h1><?php echo '<b>Hola! </b>'.$_SESSION["nombre_dashboard"] ?></h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6" style="margin-left: 5%;">
        <!-- <div class="card"> -->

          <div class="card-header">
            <h3 class="card-title"><b>Rol de sesión</b></h3>
          </div>

          <div class="card-body">

            <div class="row">
              <div class="mb-3 col-md-12">
                <h5 class="titprod"> Administrador:</h5>
                <div class="input-group">
                  <button class="btn btn-secondary btnAdministradorPlataforma btn-block btnColorCambio">
                      Seleccionar
                    </button>
                  <div class="input-group-prepend"></div>
                </div>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="mb-3 col-md-12">
                <h5 class="titprod"> Administrador <b>Almacén</b>:</h5>

                <div class="input-group">
                  
                  <select id="selectAlmacenAdministrador" class="form-control">
                    <option value="">Seleccionar almacén...</option>

                    <?php 
                      $item = NULL;
                      $valor = NULL;
                      $respuesta = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);

                      foreach ($respuesta as $key => $value) {

                        $item = "id_almacen";
                        $valor = $value["id_almacen"];
                        $almacenes = ControladorCompras::ctrMostrarComprasAlmacenes($item, $valor);

                        if ($almacenes == false) {
                          
                          echo '<option value="'.$value["id_almacen"].'">'.$value["nombre"].'</option>';

                        } else {

                          if (DATE('Y-m-d') > $almacenes['fecha_proximo_pago']) {
                            
                            echo '<option disabled>'.$value["nombre"].' || Pago Pendiente</option>';
                            
                            $deuda = "si";
                          } else {

                            echo '<option value="'.$value["id_almacen"].'">'.$value["nombre"].'</option>';

                          }
                        }
                      }
                    ?>
                  </select>
                  <div class="input-group-prepend">
                    <button class="btn btn-secondary btnAlmacenAdministradorPlataforma btnColorCambio" style="border-radius: 15px; margin-left: 30px;">
                      Seleccionar
                    </button>
                  </div>
                </div>

              </div>
            </div> 

            <hr>
            <?php
              

            ?>
            <div class="row">
              <div class="mb-3 col-md-12">
                <h5 class="titprod"> Vendedor <b>Almacén</b>:</h5>

                  <div class="input-group">
                    
                    <select id="selectAlmacenVendedor" class="form-control">
                      <option value="">Seleccionar Usuario...</option>

                      <?php
                        $tabla = "usuarios_plataforma";
                        $item = NULL;
                        $valor = NULL;
                        $respuesta = ControladorUsuarios::ctrMostrarUsuario($tabla, $item, $valor);

                        foreach ($respuesta as $key => $value) {

                          if ($value["rol"] == "Vendedor Almacen" || $value["rol"] == "Vendedor Almacen ") {                      

                            $item = "id_usuario_plataforma";
                            $valor = $value["id_usuario_plataforma"];
                            $vendedores = ControladorCompras::ctrMostrarComprasVendedoresAlmacen($item, $valor);

                            if ($vendedores == false) {
                            
                              echo '<option value="'.$value["id_usuario_plataforma"].'">'.$value["nombre"].'</option>';
  
                            } else {

                              if (DATE('Y-m-d') > $vendedores['fecha_proximo_pago']) {
                                
                                echo '<option disabled>'.$value["nombre"].' || Pago Pendiente</option>';
                                
                                $deuda = "si";

                              } else {
  
                                echo '<option value="'.$value["id_usuario_plataforma"].'">'.$value["nombre"].'</option>';
  
                              }
                            }
                          }
                        }
                      ?>
                    </select>
                    <div class="input-group-prepend">
                      <button class="btn btn-secondary btnAlmacenVendedorPlataforma btnColorCambio" style="border-radius: 15px; margin-left: 30px;">
                        Seleccionar
                      </button>
                    </div>
                  </div>

              </div>
            </div>
            

            <div class="row">
              <div class="col-md-12" style="text-align:right;">
                <?php
                  if ($deuda == "si") {
                    
                    echo 'Tienes una deuda da <a href="mis-compras">click aqui</a> para ir a mis compras.';

                  }
                ?>
              </div>
            </div>
          </div>

        <!-- </div> -->
      </div>
    </div>
  </div>
</section>
</div>

<?php
    

} else {
  echo '<script>window.location = "inicio";</script>';
  
}
?>