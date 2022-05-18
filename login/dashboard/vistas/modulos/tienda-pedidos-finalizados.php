<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?>(Pedidos Finalizados).</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Pedidos</li>
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
            <div class="card-header">
               <h3>EXITOSOS</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  
                  $item = "id_empresa";
                  $valor = $_SESSION["idEmpresa_dashboard"];
                  
                  $respuesta = ControladorPedidos::ctrMostrarPedidosFinalizados($item, $valor);

                  foreach ($respuesta as $key => $value) {
                    $item = "id_cliente";
                    $valor = $value["id_cliente"];
                    $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);
                ?>

                  <tr>
                  
                    <td><?php echo $value["folio"] ?></td>
                    <td><?php echo $cliente["nombre"] ?></td>
                    <td><?php echo "$".number_format($value["total"],"2",".",","); ?></td>
                    <td><?php echo $value["fecha"] ?></td>
                    <td>
                      <button class="btn btn-info btnDetallePedido" folio="<?php echo $value['folio']; ?>" data-toggle="modal" data-target="#modalInfoPedido">
                        Detalles
                      </button>
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


  <section class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
               <h3>CANCELADOS</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                <thead>
                  <tr>
                    <th>Folio</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  
                  $item = "id_empresa";
                  $valor = $_SESSION["idEmpresa_dashboard"];
                  
                  $respuesta = ControladorPedidos::ctrMostrarPedidosCancelados($item, $valor);

                  foreach ($respuesta as $key => $value) {
                    $item = "id_cliente";
                    $valor = $value["id_cliente"];
                    $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);
                ?>

                  <tr>
                  
                    <td><?php echo $value["folio"] ?></td>
                    <td><?php echo $cliente["nombre"] ?></td>
                    <td><?php echo "$".number_format($value["total"],"2",".",","); ?></td>
                    <td><?php echo $value["fecha"] ?></td>
                    <td>
                      <button class="btn btn-info btnDetallePedido" folio="<?php echo $value['folio']; ?>" data-toggle="modal" data-target="#modalInfoPedido">
                        Detalles
                      </button>
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