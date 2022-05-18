<style>
  .custom-file-label::after{
    content: "Seleccionar archivo";
  }
</style>


<div id="preloader">aaaaaa</div>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Subir Productos Masivos</h1>
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

    <div class="container-fluid" onload="doWhatYouNeed();">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <div class="container">
                <div class="row justify-content-md-center">
                  <div class="col-md-5">
                      <a class="btn btn-secondary btnColorCambio btn-sm btn-block" href="../items/extensiones/productos.xlsx" download>
                      <i class="fas fa-download">    Descargar Plantilla</i>
                      </a>
                  </div>
                </div>
              </div>
                <form action="#" method="POST" enctype="multipart/form-data" id="filesForm">

                    <div class="col-md-12">
                      <div class="form-group" style="text-align:center;">
                        <label for="fileContacts">CARGAR PLANTILLA DE PRODUCTOS</label>
                        <div class="input-group shadow">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="fileContacts" id="fileContacts" accept=".xlsx">
                            <label class="custom-file-label lbTextoArchivo" for="fileContacts"></label>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-3 btnColorCambio btn-block">Cargar</button>
                      </div>
                    </div>

                    


                </form>
            </div> 
            <div class="card-body"> 

              <div class="row">
                <div class="col-lg-3">
                  <button class="btn btn-secondary btnColorCambio btn-sm btn-block btnSeleccionarTodosProductos">
                    <i class="fa fa-check"></i> Seleccionar Todos
                  </button>
                </div>

                <div class="col-lg-7">
                  <button class="btn btn-danger btn-sm btnEliminarProductosPrecargados float-right" style="width: 100px;">
                    <i class="fa fa-times"></i> Eliminar
                  </button>
                </div>

                <div class="col-lg-2">
                  <button class="btn btn-secondary btnColorCambio btnSubirProductos btn-sm btn-block">
                  <i class="fas fa-upload"></i> Subir Productos
                  </button>
                </div>
              </div>
              
              <div class="row">
                <div class="col-lg-12 divProductosPrecargados">
                  <table class="table tablaProductosPrecargados">
                    <thead>
                      <tr>
                        <th class="sticky"></th>
                        <th>Modelo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Costo(pza)</th>
                        <th>Folio</th>
                        <th>Proveedor</th>
                        <th>Precio(pza)</th>
                        <th>Promoción</th>
                        <th>Precio sug.</th>
                        <th>Largo(cm)</th>
                        <th>Ancho(cm)</th>
                        <th>Alto(cm)</th>
                        <th>Peso(kg)</th>
                        <th>
                          Características
                        </th>
                        <th>
                          Clave Producto(SAT)
                        </th>
                        <th>
                          Clave Unidad(SAT)
                        </th>
                      </tr>
                    </thead>
                    <tbody id="tbodyPrecarga">
                    <?php
                      $item = NULL;
                      $valor = NULL;
                      $respuesta = ControladorProductosMasivo::ctrMostrarProductosPrecarga($item, $valor);

                      foreach ($respuesta as $key => $value) {
                        echo '<tr class="trProductoPrecarga" idproducto="'.$value['id_precarga'].'">
                                <th class="sticky">                                            
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <div class="input-group-text">
                                        <input type="checkbox" name="productoPrecargado[]" value="'.$value['id_precarga'].'">
                                      </div>
                                    </div>
                                    <div class="input-group-prepend" style="width: 70%;">
                                      <button class="btn btn-danger btn-sm btnEliminarProductoPrecargado"
                                      style="width: 100%;"
                                      idProducto="'.$value['id_precarga'].'">
                                      <i class="fas fa-trash-alt"></i>
                                      </button>
                                    </div>
                                    <div class="input-group-prepend">
                                      <button class="btn btn-secondary btnColorCambio btn-sm btnSubirProductoPrecargado"
                                       idProducto="'.$value['id_precarga'].'">
                                        <i class="fa fa-sync"></i>Subir Producto
                                      </button>
                                    </div>
                                  </div>
                                </th>

                                <td>'.$value['codigo'].'</td>
                                <td>
                                  <input type="text" class="form-control inputTablePrecarga inputPrecarga" campo="nombre" value="'.$value['nombre'].'">
                                </td>
                                <td>
                                  <textarea type="text" class="form-control inputTablePrecarga inputPrecarga" campo="descripcion">'.$value['descripcion'].'</textarea>
                                </td>
                                <td>
                                  <input type="number" class="form-control inputPrecarga" campo="stock" value="'.$value['stock'].'" style="width: 75px;">
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="costo" value="'.$value['costo'].'" style="width: 75px;">
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga inputTablePrecarga" campo="folio" value="'.$value['folio'].'">
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga inputTablePrecarga" campo="proveedor" value="'.$value['proveedor'].'">
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="precio" value="'.$value['precio'].'" style="width: 75px;">  
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="promo" value="'.$value['promo'].'" style="width: 75px;"> 
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="promo" value="'.$value['p_sugerido'].'" style="width: 75px;"> 
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="largo" value="'.$value['largo'].'" style="width: 75px;">   
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="ancho" value="'.$value['ancho'].'" style="width: 75px;">   
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="alto" value="'.$value['alto'].'" style="width: 75px;">  
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="peso" value="'.$value['peso'].'" style="width: 75px;">   
                                </td>
                                <td>';

                                  if ($value['caracteristicas'] != NULL ) {
                                  echo '<div class="row">';                                                    

                                          $viewCaracteristicas = json_decode($value['caracteristicas'], true);

                                          foreach ($viewCaracteristicas as $key => $val) {

                                              if ($val['caracteristica'] == 'Color') {

                                                  echo '<span>'.$val['caracteristica'].': ';

                                                  if ($val['datoCaracteristica'] != "") {

                                                      echo ' <i class="fa fa-circle" style="color: '.$val['datoCaracteristica'].'"></i>';

                                                  }

                                                  echo '</span><br>';
                                                  

                                              } else {

                                                  echo $val['caracteristica'].": ".$val['datoCaracteristica']."<br>";

                                              }

                                          }
                                              
                                  echo '</div>
                                        
                                        <div class="row">
                                              <button class="btn btn-warning btn-block btnDefinirCaracteristicasPrecarga" idProducto="'.$value['id_precarga'].'">
                                                  Editar
                                              </button>
                                        </div>';

                                  }

                          echo '</td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="clvprod" value="'.$value['sat_clave_prod_serv'].'" style="width: 75px;">
                                </td>
                                <td>
                                  <input type="text" class="form-control inputPrecarga" campo="clvunid" value="'.$value['sat_clave_unidad'].'" style="width: 75px;">
                                </td>
                              </tr>';
                        }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <br>
              <div class="row justify-content-md-center">
                <div class="col-lg-2">
                  <button class="btn btn-secondary btnColorCambio btn-sm btn-block btnCaracteristicasPrecargados float-right">
                    Caracteriticas
                  </button>
                </div>
              </div>
              <hr>

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

<!-- *************************************************************************************************************** -->
<!-- *************************************************************************************************************** -->
<!-- MODAL CARGAR CARACTERISTICAS -->

<div id="modalCaracteristicasPrecargo" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCaracteristicaPrecargado" role="form" method="POST" enctype="multipart/form-data">

        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Características de los productos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        
        <!-- CUERPO DEL MODAL -->
        <div class="modal-body">
            <div class="box-body">
                <div class="container">

                    <div class="row">
                        <input type="hidden" id="inputSeleccionadosPrecargaCaracteristicas">
                        <div class="col-md-12" style="text-align: center;">
                            <span style="font-weight: bold;">
                                Selecciona las características que tienen tus productos.
                            </span>
                        </div>
                        <hr>
                    </div>

                    <div class="row justify-content-md-center returnCarcteristicasDiv">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="background: #343A40; color:white;">
            <button type="submit" class="btn btn-success float-right">Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- *************************************************************************************************************** -->
<!-- *************************************************************************************************************** -->
<!-- MODAL MODIFICAR Y DEIFINIR CARACTERISTICAS -->

<div id="modalCaracteristicasDefinir" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formModificacionCaracteristicas" role="form" method="POST" enctype="multipart/form-data">

        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Características del producto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        
        <!-- CUERPO DEL MODAL -->
        <div class="modal-body">
            <div class="box-body">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-md-8" style="text-align: center; text-transform: uppercase;">
                            <span style="font-weight: bold;">
                                Caracteristicas
                            </span>
                            <input type="hidden" class="inputIdPrecargaCarac">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary btn-block btn-sm btnNewCaracteristica">
                                Agregar 
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="container divCarcteristicasPrecarga">
                    
                </div>
            </div>
        </div>

        <div class="modal-footer" style="background: #343A40; color:white;">
            <button type="submit" class="btn btn-success float-right">Guardar</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
  
  $( document ).ready(function() {
      document.getElementById("preloader").classList.add("fadeout");
  });

</script>