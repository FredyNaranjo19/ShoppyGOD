<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $_SESSION["nombreEmpresa_dashboard"] ?> ( Administrar Proveedores )</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Proveedores</a></li>
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
              <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalAgregarProveedor">Agregar Proveedor</button>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Contacto</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $item = NULL;
                    $valor = NULL;
                    $respuesta = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                    foreach ($respuesta as $key => $value) {
                      
                      echo '<tr>
                              <td>'.$value["contacto"].'</td>
                              <td>'.$value["nombre"].'</td>
                              <td>'.$value["telefono"].'</td>
                              <td>Calle: '.$value["calle"].'
                                  <br>No. exterior: '.$value["noExt"].'
                                  <br>No. interior: '.$value["noInt"].'
                                  <br>Colonia: '.$value["colonia"].'
                                  <br>C.P.: '.$value["cp"].'
                                  <br>Municipio: '.$value["municipio"].'
                                  <br>Estado: '.$value["estado"].'
                                  <br>País: '.$value["pais"].'
                              </td>
                              <td>
                                <button type="button" class="btn btn-warning btnEditarProvvedor" id_proveedor="'.$value["id_proveedor"].'" data-toggle="modal" data-target="#modalEditarProveedor">
                                  <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btnEliminarProveedor" id_proveedor="'.$value["id_proveedor"].'">
                                  <i class="fa fa-times"></i>
                                </button>
                              </td>
                      </tr>';
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

<!--=============================================
=            AGREGAR NUEVO PROVEEDOR            =
==============================================-->

<div class="modal fade" id="modalAgregarProveedor">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" accept-charset="utf-8">
         
        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Agregar Proveedor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <!-- CUERPO DEL MODAL -->
        <div class="modal-body">

          <div class="row">

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Nombre de la empresa:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-hotel"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornNombre" required>
                <input type="hidden" name="ProveedornEmpresa">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Contacto:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornContacto" required>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Teléfono:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-phone"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornTelefono" data-inputmask='"mask": "(999) 999-9999"' data-mask required>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Calle:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornCalle">
              </div> 
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">No. Exterior:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornNoExt">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">No. Interior:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornNoInt">
              </div> 
            </div>

          </div>

          <div class="row">

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Colonia:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornColonia">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">C.P.:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornCP">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Municipio:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornMunicipio">
              </div> 
            </div>

          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <h5 class="titprod">Estado:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornEstado">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <h5 class="titprod">País:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedornPais">
              </div>
            </div>

          </div>

        </div> 

        <!-- FOOTER DEL MODAL -->
        <div class="modal-footer" style="background: #343A40; color:white;">
          <button type="submit" class="btn btn-primary float-right">Agregar</button>
        </div>

        <?php

          $agregarProveedor = new ControladorProveedores();
          $agregarProveedor -> ctrCrearProveedor();

        ?>
      </form>
    </div>
  </div> 
</div>

<!--====  End of AGREGAR NUEVO PROVEEDOR  ====-->

<!--=============================================
=            EDITAR PROVEEDOR            =
==============================================-->

<div class="modal fade" id="modalEditarProveedor">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" accept-charset="utf-8">
         
        <!-- ENCABEZADO DEL MODAL -->
        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Editar Proveedor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <!-- CUERPO DEL MODAL -->
        <div class="modal-body">

          <div class="row">

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Nombre de la empresa:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-hotel"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreNombre" id="ProveedoreNombre" required>
                <input type="hidden" name="ProveedoreEmpresa" id="ProveedoreEmpresa">
                <input type="hidden" name="ProveedoreId" id="ProveedoreId">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Contacto:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreContacto" id="ProveedoreContacto" required>
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Teléfono:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-phone"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreTelefono" id="ProveedoreTelefono" required>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Calle:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreCalle" id="ProveedoreCalle">
              </div> 
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">No. Exterior:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreNoExt" id="ProveedoreNoExt">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">No. Interior:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreNoInt" id="ProveedoreNoInt">
              </div> 
            </div>

          </div>

          <div class="row">

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Colonia:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreColonia" id="ProveedoreColonia">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">C.P.:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreCP" id="ProveedoreCP">
              </div>
            </div>

            <div class="col-md-4 mb-3">
              <h5 class="titprod">Municipio:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreMunicipio" id="ProveedoreMunicipio">
              </div> 
            </div>

          </div>

          <div class="row">
            
            <div class="col-md-6 mb-3">
              <h5 class="titprod">Estado:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedoreEstado" id="ProveedoreEstado">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <h5 class="titprod">País:</h5>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
                <input type="text" class="form-control input-lg" name="ProveedorePais" id="ProveedorePais">
              </div>
            </div>

          </div>

        </div>

        <!-- FOOTER DEL MODAL -->
        <div class="modal-footer" style="background: #343A40; color:white;">
          <button type="submit" class="btn btn-primary float-right">Editar</button>
        </div>

        <?php

          $editarProveedor = new ControladorProveedores();
          $editarProveedor -> ctrEditarProveedor();

        ?>
      </form>
    </div>
  </div> 
</div>

<!--====  End of EDITAR PROVEEDOR  ====-->
