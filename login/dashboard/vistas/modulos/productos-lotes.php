<?php
  
  $separado = explode("-", $_GET["sku"]);

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"]."(Lotes: ".$separado[1].")"; ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Lotes</li>
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
              <table class="table table-bordered table-striped dt-responsive tablas" style="width: 100%">
                <thead>
                  <tr>
                    <th>Modelo</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Factura</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $item = "sku";
                    $valor = $_GET["sku"];

                    $respuesta = ControladorProductos::ctrMostrarTodosLotes($item, $valor);

                    foreach ($respuesta as $key => $value) {
                      
                  ?>
                  <tr>
                    <td><?php echo $separado[1]; ?></td>
                    <td><?php echo $value["cantidad"]; ?></td>
                    <td><?php echo "$".$value["costo"]; ?></td>
                    <td><?php echo $value["factura"]; ?></td>
                    <td><?php echo $value["proveedor"]; ?></td>
                    <td><?php echo $value["fecha"]; ?></td>
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