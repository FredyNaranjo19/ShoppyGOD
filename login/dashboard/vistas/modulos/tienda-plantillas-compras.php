<?php

$item = "id_plantilla";
$valor = $_GET["IdPl"];

$respuestas = ControladorPlantillasTienda::ctrMostrarPlantillas($item, $valor);


$ruta = "empresa=".$_SESSION['idEmpresa_dashboard']."&plantilla=".$respuestas['id_plantilla'];

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?> (Obtener plantilla).</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Plantillas</li>
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
              <h3 class="card-title"><CENTER>Compra de plantilla.</CENTER></h3>

            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-4">
                  <img src="<?php echo $respuestas['imagen'] ?>" style="width:100%; object-fit: scale-down;">
                </div>
                <div class="col-3">
                  <h2>Costo: $ <?php echo number_format($respuestas['precio'],"2",".",","); ?></h2>
                </div>
              </div>
            </div>
            <!-- /.card-footer-->
            <div class="card-footer">
              <div class="row"> 
                <div class="col-12">
                  <?php
                    if ($respuestas["tipoPaga"] == "Pago") {
                      require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
                      // Agrega credenciales
                      MercadoPago\SDK::setAccessToken($GlobalTokenMercado);
                      // MercadoPago\SDK::setAccessToken("APP_USR-4569372264265886-073118-6c0504c05802601d9b2620ce1a5d08af-192979879");

                      $preference = new MercadoPago\Preference();
                      $items = array();

                        $item = new MercadoPago\Item();
                        $item->title = "Plantilla ".$respuestas['nombre'];
                        $item->quantity = 1;
                        $item->unit_price = floatval($respuestas['precio']);

                        array_push($items, $item);

                      $preference->items = $items;
                      $preference->back_urls = array(
                          "success" => $GlobalUrl."/dashboard/index.php?ruta=tienda-plantillas-successful&".$ruta,
                          "failure" => $GlobalUrl."/dashboard/mis-compras",
                          "pending" => $GlobalUrl."/dashboard/index.php?ruta=pending&".$ruta
                      );
                      
                      $preference->save();

                  ?>
                      <a class="float-right" href="<?php echo $preference->init_point; ?>">
                        <button class="btn btn-success"> Finalizar pago </button>
                      </a>

                  <?php
                    } else {
                  ?>

                      <button type="button" class="btn btn-success float-right btnCompraFreePlantilla" ruta="<?php echo $ruta ?>"> Finalizar Compra </button>

                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>