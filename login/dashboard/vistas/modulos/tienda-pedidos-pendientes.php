<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?>(Pedidos Pendientes)</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Pedidos Pendientes</li>
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
                    <th style="width: 10px;">Folio</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Detalles</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $datos = array("metodo_pago" => "Efectivo",
                                    "estado" => "Comprobante subido",
                                    "id_empresa" => $_SESSION["idEmpresa_dashboard"]);

                    $resultado = ControladorPedidos::ctrMostrarPedidosPendientesEfectivo($datos);

                    
                    foreach ($resultado as $key => $value) {
                      if ($value['id_cliente'] != 1) {
                        $item = "id_cliente";
                        $valor = $value['id_cliente']; 
                        $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

                        $nombreCliente = $cliente['nombre'];
                      }else{
                        $nombreCliente = "Público en general";
                      }

                  ?>

                      <tr>
                        <td><?php echo $value['folio']; ?></td>
                        <td><?php echo $nombreCliente; ?></td>
                        <td><?php echo "$".$value['total']; ?></td>
                        <td><?php echo $value['fecha']; ?></td>
                        <td>
                          
                          <button class="btn btn-info btnDetallePedido" folio="<?php echo $value['folio']; ?>" data-toggle="modal" data-target="#modalInfoPedido">
                            Detalles
                          </button>

                        </td>
                        <td>
                          <button class="btn btn-primary btnComprobanteEfectivo" folioPedido="<?php echo $value['folio'] ?>" data-toggle="modal" data-target="#modalComprobanteEfectivo" tel="<?php echo $cliente['telefono'] ?>">
                            <?php echo $value["estado"]; ?>
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
            <div class="row bodyModalPedidoPendiente"></div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Salir</button>
        </div>
    </div>
  </div>
</div>

<!--====  End of INFORMACION DE PEDIDO  ====-->

<!--=====================================================================
=            MOSTRAR COMPROBANTE DE PAGO POR METODO EFECTIVO            =
======================================================================-->

<div id="modalComprobanteEfectivo" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Comprobantes de pago</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <!-- CUERPO DEL MODAL -->
        <div class="modal-body">

          <div class="box-body">
            <div>
              <img class="imgComprobanteEfectivo" src="" style="width: 100%; height: 300%;">
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btnAprobarEfectivo pull-right" folio tel>Aprobar</button>
          <button type="button" class="btn btn-danger btnDesaprobarEfectivo pull-left" folio tel>Desaprobar</button>
        </div>
    </div>
  </div>
</div>
  
<!--====  End of MOSTRAR COMPROBANTE DE PAGO POR METODO EFECTIVO  ====--> 