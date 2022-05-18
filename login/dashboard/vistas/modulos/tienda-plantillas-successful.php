<?php
  $empresa = $_GET["empresa"];
  $plantilla = $_GET["plantilla"];
  
  $item = "id_plantilla";
  $valor = $plantilla;

  $existe = ControladorPlantillasTienda::ctrMostrarMisPlantillas($item, $valor);


  if ($existe != false) {
    # code...
  } else {


    $tabla = "tv_mis_plantillas";
    $datos = array("id_empresa" => $empresa,
                    "id_plantilla" => $plantilla,
                    "estado" => "desactivado");

    $respuesta = ModeloPlantillasTienda::mdlCrearMiPlantilla($tabla, $datos);


    $item = "id_plantilla";
    $valor = $plantilla;
    $respuestaPlantilla = ControladorPlantillasTienda::ctrMostrarPlantillas($item, $valor);



    $tablaCompra = "dashboard_registro_compras";
    $datosCompra = array("id_empresa" => $empresa,
                    "descripcion" => "Plantilla",
                    "monto" => $respuestaPlantilla["precio"]);

    $respuestaCompra = ModeloCompras::mdlCrearCompra($tablaCompra, $datosCompra);

  }

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?> ( Compra Exitosa ).</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Compra Exitosa.</li>
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
                
                <div class="col-12">

                  <div class="imgExitoso">
                    <img src="vistas/img/icono-exitoso.png">
                  </div>

                  <div class="tituloExitoso">
                    <h4>Compra exitoso!</h4>
                  </div>

                  <div class="btnExitoso">
                    <a type="button" class="btn btn-success" href="tienda-plantillas">Plantillas</a>
                  </div>
 
                </div>

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