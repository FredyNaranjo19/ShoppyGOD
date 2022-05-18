<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?>(Pedidos en Guías)</h1>
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
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                    <th>Estado</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $datos = array("estado_entrega" => "Generando Guía",
                                    "id_empresa" => $_SESSION["idEmpresa_dashboard"]);
                    
                    $resultado = ControladorPedidos::ctrMostrarPedidosEstados($datos);

                    foreach ($resultado as $key => $value) {
                          $item = "id_cliente";
                          $valor = $value["id_cliente"];
                          $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);
                  ?> 

                  <tr>
                    <td><?php echo $value['folio']; ?></td>
                    <td><?php echo $cliente['nombre'] ?></td>
                    <td><?php echo $value['fecha']; ?></td>
                    <td>
                      
                      <button class="btn btn-info btnDetallePedido" folio="<?php echo $value['folio']; ?>" data-toggle="modal" data-target="#modalInfoPedido">
                        Detalles
                      </button>

                    </td>
                    <td> 
                      <div class="btn-group">
                        <button class="btn btn-primary btnStatusGuias" folioPedido="<?php echo $value['folio'] ?>" direccion="<?php echo $value['id_domicilio'] ?>"  data-toggle="modal" data-target="#modalStatusPago">
                          <?php echo $value["estado_entrega"]; ?>
                        </button>

                        <?php
                        if ($value["estado"] != "Cancelada") {
                          echo '<button class="btn btn-danger btnCancelarPedido" folio="'.$value['folio'].'" retorno="tienda-pedidos-guias">
                                Cancelar
                            </button>';
                        }

                        ?>
                      </div>
                        
                    </td>
                  </tr>
                  <?php
                    }
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

<!--===========================================
=            INFORMACION DE PEDIDO            =
============================================-->
<div id="modalInfoPedido" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">


        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Detalles del pedido</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <!-- CUERPO DEL MODAL -->

        <div class="modal-body">

          <div class="box-body">
            <div class="bodyModalPedidoPendiente"></div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Salir</button>
        </div>
    </div>
  </div>
</div>

<!--====  End of INFORMACION DE PEDIDO  ====-->

<!--=================================================================
=            CAMBIO STATUS Y REGISTRO DE RASTREO DE GUIA            =
==================================================================-->

<div id="modalStatusPago" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="POST">

        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Seguimiento de Pedido</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <!-- CUERPO DEL MODAL -->

        <div class="modal-body">

          <div class="box-body">  

            <div class="row">
              <table class="table" style="width: 100%">
                <tr>
                  <th>Calle</th>
                  <td id="calle"></td>
                  <th>Colonia</th>
                  <td id="colonia"></td>
                </tr>
                <tr>
                  <th>No. exterior</th>
                  <td id="exterior"></td>
                  <th>No. Interior</th>
                  <td id="interior"></td>
                </tr>
                <tr>
                  <th>Codigo Postal</th>
                  <td id="codigoPostal"></td>
                  <th>Ciudad</th>
                  <td id="ciudad"></td>
                </tr>
                <tr>
                  <th>Estado</th>
                  <td id="estado"></td>
                  <th>País</th>
                  <td id="pais"></td>
                </tr>
                <tr>
                  <th>Calle referencia 1</th>
                  <td id="calle1"></td>
                  <th>Calle referencia 2</th>
                  <td id="calle2"></td>
                </tr>
                <tr>
                  <th>Referencias</th>
                  <td colspan="3" id="referencia"></td>
                </tr>
                <tr>
                  <th colspan="2">Telefono</th>
                  <td colspan="2" id="telefono"></td>
                </tr>
              </table>
            </div>

            <div class="mb-3">
              <h5 class="titprod"> No. de rastreo:</h5>
              <div class="input-group">
                <div id="inputname" class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fa fa-hashtag"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="nNoRastreo" required>
                <input type="hidden" id="folioPedidoGuia" name="folioPedidoGuia">
              </div>
            </div>

            <div class="mb-3">
              <h5 class="titprod"> Paqueteria de envío:</h5>
              <div class="input-group">
                <select class="form-control input-lg" name="nPaqueteriaEnvio">
                  <option value="">Seleccionar Paqueteria...</option>
                  <option value="DHL">DHL</option>
                  <option value="Fedex">FEDEX</option>
                  <option value="Estafeta">ESTAFETA</option>
                  <option value="UPS">UPS</option>
                  <option value="REDPACK">REDPACK</option>
                  <option value="PAQUETEXPRESS">PAQUETEXPRESS</option>
                  option
                </select>
              </div>
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success pull-right">Guardar y Cambiar estado</button>
        </div>
        <?php
          $guia = new ControladorPedidos();
          $guia -> ctrModificarEstadoGuias();

        ?>
      </form>
    </div>
  </div>
</div>

<!--====  End of CAMBIO STATUS Y REGISTRO DE RASTREO DE GUIA  ====-->