<div class="content-wrapper">

	<!-- CONTENIDO HEADER DE LA PÁGINA -->

	<section class="content-header">
		<div class="container-fluid">
		  <div class="row mb-2">
		    <div class="col-sm-8">
		      <h1>Mi Tienda Virtual: Configuración</h1>
		    </div>
		    <div class="col-sm-3 offset-md-1">
		      <ol class="breadcrumb float-sm-right">
		        <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
		        <li class="breadcrumb-item active">Configuración</li>
		      </ol>
		    </div>
		  </div>
		</div>
	</section>

	<section class="content">
    	<div class="container-fluid">
    		<div class="row">

    			<!-- LAYOUT IZQUIERDO -->
    			<div class="col-md-8">
    				<!--================================
      				=            LOGO Y SEO            =
      				=================================-->
    				<div class="row">

							<!--************************** LOGO **************************-->
      				<div class="col-md-4">
	              <div class="card">
	                <div class="card-header">
	                  <h3 class="card-title">Logo</h3>
	                  <div class="card-tools">
	                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                      <i class="fas fa-minus"></i>
	                    </button>
	                  </div>
	                </div>

	                <div class="card-body" style="min-height: 400px;">
	                  <?php
	                    $item = "id_empresa";
	                    $valor = $_SESSION["idEmpresa_dashboard"];

	                    $respuesta = ControladorConfiguracionTienda::ctrMostrarLogo($item, $valor);
	                    $imagen = "../items/img/subirImagen.png";
	                    $viewImagen = "";

	                    if ($respuesta != false) {

	                      $imagen = $respuesta["imagen"];
	                      $viewImagen = $respuesta["imagen"];

	                    }

	                  ?>
	                  <div class="row">
	                    <div class="col-sm-8">
	                      <button type="button" class="btn btn-secondary btn-block" id="btnImagenLogo">
	                        <i class="fas fa-folder-plus"></i>Seleccionar imagen
	                      </button>
	                      <input type="hidden" id="idEmpresaLogo" value="<?php echo $_SESSION["idEmpresa_dashboard"]; ?>">
	                    </div>
	                    <div class="col-sm-4">
	                      <div id="LogotxtCarga"></div>
	                      <input type="hidden" id="urlLogo" value="<?php echo $viewImagen ?>">
	                    </div>   
	                  </div>
	                  <div class="row">
	                    <div style="width: 100%; height: 307px;padding: 10px;">
	                      <img src="<?php echo $imagen ?>" id="previsualizarLogo" style="object-fit: scale-down;width: 100%; height: 100%;">
	                    </div>
	                  </div>
	                </div>
 
	                <div class="card-footer">
	                  <button type="button" class="btn btn-success float-right btnGuardarLogo">Guardar</button>
	                </div>
	              </div>
	            </div>

	            <!--************************** SEO **************************-->
	            <div class="col-md-8">
	              <div class="card">
	                <div class="card-header">
	                  <h3 class="card-title">Información de la Página</h3>
	                  <div class="card-tools">
	                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                      <i class="fas fa-minus"></i></button>
	                  </div>
	                </div> 

	                <?php

	                  $item = "id_empresa";
	                  $valor = $_SESSION["idEmpresa_dashboard"];

	                  $respuesta = ControladorConfiguracionTienda::ctrMostrarSEO($item, $valor);

	                  if ($respuesta != false) {
	                      
	                      $seo = json_decode($respuesta["metadatos"], true);

	                      $descripcion = $seo[0]["SEO_Description"];
	                      $keywords = $seo[0]["SEO_Keywords"];

	                  } else {

	                    $descripcion = NULL;
	                    $keywords = NULL;

	                  }

	                ?>

	                <div class="card-body" style="min-height: 400px;">
	                  <div class="mb-3">
	                    <h5 class="titprod">Descripción general:</h5>
	                    <div class="input-group">
	                      <textarea rows="3" class="form-control" id="seoDescripcion" maxlength="150"><?php echo $descripcion; ?></textarea>
	                    </div>
	                    <div class="row">
	                      <div class="col-sm-12" style="text-align: right;">
	                        <span>
	                          <b>No. caracteres: </b>0 / 150.
	                        </span>
	                      </div>
	                    </div>
	                  </div>

	                  <div class="mb-3">
	                    <h5 class="titprod">Palabras clave de la página:</h5>
	                    <div class="input-group">
	                      <textarea rows="3" class="form-control" id="seoKeywords" maxlength="150" placeholder="Ejemplo: regalo, niños..."><?php echo $keywords; ?></textarea>
	                    </div>
	                    <div class="row">
	                      <div class="col-sm-12" style="text-align: right;">
	                        <span>
	                          <b>No. caracteres:</b> 0 / 150.
	                        </span>
	                      </div>
	                    </div>
	                  </div>
	                </div>

	                <div class="card-footer">
	                  <div class="col-md-12">
	                    <button type="button" class="btn btn-success float-right btnGuardarConfiguracionSEO">
	                      Guardar
	                    </button>
	                  </div>
	                </div>
	              </div>
	            </div>

    				</div>

    				<!--====================================
	          =            FORMAS DE PAGO            =
	          =====================================-->
	          
	          <div class="row">
	            <div class="col-md-12">
	              <div class="card">
	                <div class="card-header">
	                  <h3 class="card-title">Información de pagos</h3>
	                  <div class="card-tools">
	                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                      <i class="fas fa-minus"></i></button>
	                  </div>
	                </div>
	                <div class="card-body">
	                  <?php
	                    $item = "id_empresa";
	                    $valor = $_SESSION["idEmpresa_dashboard"]; 

	                    $respuesta = ControladorConfiguracionTienda::ctrMostrarConfiguracionPago($item, $valor);
	                  ?>
	                  <h4>Efectivo</h4>              

	                  <!-- radio -->
	                  <div class="form-group clearfix">
	                    <?php
	                    if ($respuesta != false) {
	                    ?>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewEfectivo1" name="PagosViewEfectivo" <?php if($respuesta['efectivoView'] == "habilitado") echo "checked"; ?> value="habilitado">
	                        <label for="PagosViewEfectivo1">
	                          Habilitar
	                        </label>
	                      </div>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewEfectivo2" name="PagosViewEfectivo" <?php if($respuesta['efectivoView'] == "deshabilitado") echo "checked"; ?> value="deshabilitado">
	                        <label for="PagosViewEfectivo2">
	                          Deshabilitar
	                        </label>
	                      </div>
	                    <?php
	                    } else {
	                    ?>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewEfectivo1" name="PagosViewEfectivo">
	                        <label for="PagosViewEfectivo1">
	                          Habilitar
	                        </label>
	                      </div>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewEfectivo2" name="PagosViewEfectivo">
	                        <label for="PagosViewEfectivo2">
	                          Deshabilitar
	                        </label>
	                      </div>
	                    <?php
	                    }
	                    ?>
	                  </div>
	                  <div class="row">
	                    <div class="col-md-6 mb-3">
	                      <h5 class="titprod"> No. de tarjeta para depositar:</h5>
	                      <div class="input-group">
	                        <div id="inputname" class="input-group-prepend">
	                          <span class="input-group-text">
	                            <i class="fas fas fa-credit-card"></i>
	                          </span>
	                        </div>
	                        <input type="text" class="form-control input-lg" id="PagosnTarjetaEfectivo" value="<?php if ($respuesta != false) echo $respuesta['efectivoTarjeta'] ?>">
	                      </div>
	                    </div>

	                    <div class="col-md-6 mb-3">
	                      <h5 class="titprod"> Re-escribir no. de tarjeta:</h5>
	                      <div class="input-group">
	                        <div id="inputname" class="input-group-prepend">
	                          <span class="input-group-text">
	                            <i class="fas fas fa-credit-card"></i>
	                          </span>
	                        </div>
	                        <input type="text" class="form-control input-lg" id="PagosnTarjeta2" value="<?php if ($respuesta != false) echo $respuesta['efectivoTarjeta'] ?>">
	                      </div>
	                    </div>
	                  </div>

	                  <div class="row">
	                    <div class="col-md-6 mb-3">
	                      <h5 class="titprod"> Nombre del Banco:</h5>
	                      <div class="input-group">
	                        <div id="inputname" class="input-group-prepend">
	                          <span class="input-group-text">
	                            <i class="fas fas fa-credit-card"></i>
	                          </span>
	                        </div>
	                        <input type="text" class="form-control input-lg" id="PagosBanco" value="<?php if ($respuesta != false) echo $respuesta['banco'] ?>">
	                      </div>
	                    </div>

	                    <div class="col-md-6 mb-3">
	                      <h5 class="titprod"> Nombre del propietario:</h5>
	                      <div class="input-group">
	                        <div id="inputname" class="input-group-prepend">
	                          <span class="input-group-text">
	                            <i class="fas fas fa-credit-card"></i>
	                          </span>
	                        </div>
	                        <input type="text" class="form-control input-lg" id="PagosPropietario" value="<?php if ($respuesta != false) echo $respuesta['propietario'] ?>">
	                      </div>
	                    </div>
	                  </div>

	                  <hr>

	                  <h4>Mercado pago</h4>

	                  <!-- radio -->
	                  <div class="form-group clearfix">
	                    <?php
	                    if ($respuesta != false) {
	                    ?>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewMercado1" name="PagosViewMercado" <?php if($respuesta['mercadoView'] == "habilitado") echo "checked"; ?> value="habilitado">
	                        <label for="PagosViewMercado1">
	                          Habilitar
	                        </label>
	                      </div>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewMercado2" name="PagosViewMercado" <?php if($respuesta['mercadoView'] == "deshabilitado") echo "checked"; ?> value="deshabilitado">
	                        <label for="PagosViewMercado2">
	                          Deshabilitar
	                        </label>
	                      </div>
	                    <?php
	                    } else {
	                    ?>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewMercado1" name="PagosViewMercado">
	                        <label for="PagosViewMercado1">
	                          Habilitar
	                        </label>
	                      </div>
	                      <div class="icheck-primary d-inline">
	                        <input type="radio" id="PagosViewMercado2" name="PagosViewMercado">
	                        <label for="PagosViewMercado2">
	                          Deshabilitar
	                        </label>
	                      </div>
	                    <?php
	                    }
	                    ?>
	                  </div>

	                  <div class="mb-3">
	                    <h5 class="titprod"> AccessToken de tu mercado pago: </h5>
	                    <div class="input-group">
	                      <div id="inputname" class="input-group-prepend">
	                        <span class="input-group-text">
	                          <i class="fas fas fa-credit-card"></i>
	                        </span>
	                      </div>
	                      <input type="text" class="form-control input-lg" id="PagosnTarjetaMercado" value="<?php if ($respuesta != false) echo $respuesta['mercadoAccess'] ?>">
	                    </div>
	                  </div>
	                </div>

	                <div class="card-footer">
	                  <div class="row">
	                        <div class="col-md-12">
	                            <span style="font-size: 0.8em;color: red;"><b>Nota:</b>Para poder guardar los datos, necesitas solicitar un codigo de verificación, este será mandado al correo de la persona que contrato el servicio.</span>
	                        </div>
	                  </div>

	                  <div class="row">
	                    <div class="col-md-5 mb-3">
	                      <div class="input-group">
	                        <div id="inputname" class="input-group-prepend">
	                          <span class="input-group-text">
	                            Codigo de verificación: 
	                          </span>
	                        </div>
	                        <input type="text" class="form-control input-lg" id="codigoVerificacionPago">
	                      </div>
	                    </div>
	                    <div class="col-md-3">
	                      <button type="button" class="btn btn-primary btnSolicitudCodigo btn-block">Solicitar Codigo</button>
	                    </div>
	                  </div>
	                  <div class="row">
	                    <div class="col-md-12">
	                      <button type="button" class="btn btn-success float-right btnGuardarPagos" disabled>Guardar</button>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            </div>  
	          </div>
	          
	          <!--====  End of FORMAS DE PAGO  ====-->


	          <!--==============================================
	          =            CHATS CON REDES SOCIALES            =
	          ===============================================-->
	          
	          <div class="row">
	            <div class="col-md-12">
	              <div class="card">
	                
	                <form id="formConfiguracionRedesSociles">
	                <?php
		                $item = "id_empresa";
		                $valor = $_SESSION["idEmpresa_dashboard"];

		                $resRedes = ControladorConfiguracionTienda::ctrMostrarRedes($item, $valor);
	                ?>

	                  <div class="card-header">
	                    <h3 class="card-title">Chats con Redes Sociales</h3>

	                    <div class="card-tools">
	                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                        <i class="fas fa-minus"></i></button>
	                    </div>
	                  </div>

	                  <div class="card-body">
	                      <div class="row">

	                        <div class="col-md-4">
	                          <h3>WhatsApp</h3>
	                          <div class="mb-3">
	                            <?php if ($resRedes != false) { ?>

	                              <label class="radio-inline">
	                                <input type="radio" name="seccionWhats" value="habilitado" <?php if($resRedes['estadoWhats'] == "habilitado") echo "checked"; ?>>Habilitar
	                              </label>
	                              <label class="radio-inline">
	                                <input type="radio" name="seccionWhats" value="deshabilitado" <?php if($resRedes['estadoWhats'] == "deshabilitado") echo "checked"; ?>>Deshabilitar
	                              </label>

	                            <?php } else { ?>

	                              <label class="radio-inline">
	                                <input type="radio" name="seccionWhats" value="habilitado" checked>Habilitar
	                              </label>
	                              <label class="radio-inline">
	                                <input type="radio" name="seccionWhats" value="deshabilitado" >Deshabilitar
	                              </label>

	                            <?php } ?>

	                          </div>
	                          <div class="mb-3">
	                            <h5 class="titprod"> Número WhatsApp:</h5>
	                            <div class="input-group">
	                              <div class="input-group-prepend">
	                                <span class="input-group-text">
	                                  +52
	                                </span>
	                              </div>
	                              <input type="text" class="form-control input-lg" id="numbWhats"  placeholder="Escribe el número donde recibiras mensajes" value="<?php if ($resRedes != false) echo $resRedes['numero'] ?>">
	                            </div>
	                          </div>

	                          <div class="mb-3">
	                            <h5 class="titprod"> Texto WhatsApp:</h5>
	                            <div class="input-group">
	                              <div class="input-group-prepend">
	                                <span class="input-group-text">
	                                  <i class="fab fa-whatsapp"></i>
	                                </span>
	                              </div>
	                              <input type="text" class="form-control input-lg" id="textWhats"  placeholder="Escribe el mensaje que recibirás..." value="<?php if ($resRedes != false) echo $resRedes['textoWhats'] ?>">
	                            </div>
	                          </div>
	                        </div>

	                        <div class="col-md-8">
	                          <h3>Messenger</h3>
	                          <div class="mb-3">

	                            <?php if ($resRedes != false) { ?>

	                              <label class="radio-inline">
	                                <input type="radio" name="seccionMessenger" value="habilitado" <?php if($resRedes['estadoMessenger'] == "habilitado") echo "checked"; ?>>Habilitar
	                              </label>
	                              <label class="radio-inline">
	                                <input type="radio" name="seccionMessenger" value="deshabilitado" <?php if($resRedes['estadoMessenger'] == "deshabilitado") echo "checked"; ?>>Deshabilitar
	                              </label>

	                            <?php } else { ?>

	                              <label class="radio-inline">
	                                <input type="radio" name="seccionMessenger" value="habilitado" checked>Habilitar
	                              </label>
	                              <label class="radio-inline">
	                                <input type="radio" name="seccionMessenger" value="deshabilitado">Deshabilitar
	                              </label>

	                            <?php } ?>

	                          </div>
	                          <div class="row">
	                            <div class="col-md-6 mb-3">
	                              <h5 class="titprod"> Id Página de Facebook (page_id):</h5>
	                              <div class="input-group">
	                                <div class="input-group-prepend">
	                                  <span class="input-group-text">
	                                    <i class="fab fa-facebook-messenger"></i>
	                                  </span>
	                                </div>
	                                <input type="text" class="form-control input-lg" id="idPage" placeholder="Escribe el id.." value="<?php if ($resRedes != false) echo $resRedes['id_page'] ?>" >
	                              </div>
	                            </div>
	                            <div class="col-md-6 mb-3">
	                              <h5 class="titprod"> Color tema:</h5>
	                              <div class="input-group">
	                                <div class="input-group-prepend">
	                                  <span class="input-group-text">
	                                    <i class="fa fa-edit"></i>
	                                  </span>
	                                </div>
	                                <input type="color" class="form-control input-lg" id="colorPage" value="<?php if ($resRedes != false) echo $resRedes['color'] ?>" >
	                              </div>
	                            </div>
	                          </div>
	                          <div class="row">
	                            <div class="col-md-6 mb-3">
	                              <h5 class="titprod"> Ménsaje de entrada:</h5>
	                              <div class="input-group">
	                                <div class="input-group-prepend">
	                                  <span class="input-group-text">
	                                    <i class="fa fa-envelope"></i>
	                                  </span>
	                                </div>
	                                <input type="text" class="form-control input-lg" id="entradaPage" value="<?php if ($resRedes != false) echo $resRedes['entrada'] ?>" >
	                              </div>
	                            </div>
	                            <div class="col-md-6 mb-3">
	                              <h5 class="titprod"> Ménsaje de Salida:</h5>
	                              <div class="input-group">
	                                <div class="input-group-prepend">
	                                  <span class="input-group-text">
	                                    <i class="fa fa-envelope"></i>
	                                  </span>
	                                </div>
	                                <input type="text" class="form-control input-lg" id="salidaPage" value="<?php if ($resRedes != false) echo $resRedes['salida'] ?>" >
	                              </div>
	                            </div>
	                          </div>
	                        </div>

	                      </div>
	                  </div>

	                  <div class="card-footer">
	                    <button type="submit" class="btn btn-success float-right">Guardar</button>
	                  </div>

	                </form>

	              </div>
	            </div>
	          </div>
	          
	          <!--====  End of CHATS CON REDES SOCIALES  ====-->


	          <!--======================================================
	          =            TERMINOS, CODICIONES Y POLITICAS            =
	          =======================================================-->
	          
	          <div class="row">
	            <div class="col-md-12">
	              <div class="card">
	              	<form id="formTerminosPoliticas">
		                <div class="card-header">
		                  <h3 class="card-title">
		                    Términos, Condiciones y Políticas de privacidad.
		                  </h3>
		                  <?php
		                    $item = "id_empresa";
		                    $valor = $_SESSION["idEmpresa_dashboard"];

		                    $terminos = ControladorConfiguracionTienda::ctrMostrarTerminosEmpresa($item, $valor);
		                    $politicas = ControladorConfiguracionTienda::ctrMostrarPoliticasEmpresa($item, $valor);
		                  ?>
		                  <div class="card-tools">
		                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
		                      <i class="fas fa-minus"></i></button>
		                  </div>
		                </div>
		                <div class="card-body row">
		                  <div class="col-md-6 mb-3">
		                    <h5 class="titprod"> Términos y condiciones: </h5>
		                    <div class="input-group">
		                      <textarea class="form-control" id="terminosEmpresa" rows="7" placeholder="Escribe tus términos y condiciones..."><?php
		                          if ($terminos != false) {
		                            echo $terminos["texto"];
		                          }
		                        ?></textarea>
		                    </div>
		                  </div>

		                  <div class="col-md-6 mb-3">
		                    <h5 class="titprod"> Políticas de privacidad: </h5>
		                    <div class="input-group">
		                      <textarea class="form-control" id="politicasEmpresa" rows="7" placeholder="Escribe tus políticas de privacidad..."><?php
		                          if ($politicas != false) {
		                            echo $politicas["texto"];
		                          }
		                        ?></textarea>
		                    </div>
		                  </div>
		                </div>
		                <div class="card-footer">
		                  <button type="submit" class="btn btn-success float-right" idEmpresa="<?php echo $_SESSION["idEmpresa_dashboard"] ?>">
		                    Guardar
		                  </button>
		                </div>
		              </form>
	              </div>
	            </div>
	          </div>
	          
	          <!--====  End of TERMINOS, CODICIONES Y POLITICAS  ====-->

    			</div>

    			<!-- LAYOUT DERECHO -->

    			<div class="col-md-4">

    				<!--========================================
	          =            METODOS DE ENTREGA            =
	          =========================================-->
	          
	          <div class="card row">
	            <div class="card-header col-md-12">
	              <h3 class="card-title">Entregas</h3>
	              <div class="card-tools">
	                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  <i class="fas fa-minus"></i></button>
	              </div>
	            </div>
	            <div class="card-body col-md-12" style="font-size: .8rem;">
	              <?php
	                $item = "id_empresa";
	                $valor = $_SESSION["idEmpresa_dashboard"]; 

	                $respuesta = ControladorConfiguracionTienda::ctrMostrarConfiguracionEntregas($item, $valor);
	              ?>
	              <h4>Sucursal</h4>
	              <!-- radio -->
	              <div class="form-group clearfix col-md-12">
	                <?php if ($respuesta != false) { ?>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewSucursal1" name="EntregasViewSucursal" <?php if($respuesta['sucursal'] == "habilitado") echo "checked"; ?> value="habilitado" >
	                    <label for="EntregasViewSucursal1">
	                      Habilitar
	                    </label>
	                  </div>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewSucursal2" name="EntregasViewSucursal" <?php if($respuesta['sucursal'] == "deshabilitado") echo "checked"; ?> value="deshabilitado">
	                    <label for="EntregasViewSucursal2">
	                      Deshabilitar
	                    </label>
	                  </div>
	                <?php } else { ?>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewSucursal1" name="EntregasViewSucursal" value="habilitado" >
	                    <label for="EntregasViewSucursal1">
	                      Habilitar
	                    </label>
	                  </div>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewSucursal2" name="EntregasViewSucursal" value="deshabilitado">
	                    <label for="EntregasViewSucursal2">
	                      Deshabilitar
	                    </label>
	                  </div>
	                <?php } ?>
	              </div>

	              <hr>

	              <h4>Envios</h4>

	              <!-- radio -->
	              <div class="form-group clearfix col-md-12">
	                <?php if ($respuesta != false) { ?>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewEnvios1" name="EntregasViewEnvios" <?php if($respuesta['envios'] == "habilitado") echo "checked"; ?> value="habilitado">
	                    <label for="EntregasViewEnvios1">
	                      Habilitar
	                    </label>
	                  </div>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewEnvios2" name="EntregasViewEnvios" <?php if($respuesta['envios'] == "deshabilitado") echo "checked"; ?> value="deshabilitado">
	                    <label for="EntregasViewEnvios2">
	                      Deshabilitar
	                    </label>
	                  </div>
	                <?php } else { ?>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewEnvios1" name="EntregasViewEnvios" value="habilitado">
	                    <label for="EntregasViewEnvios1">
	                      Habilitar
	                    </label>
	                  </div>
	                  <div class="icheck-primary d-inline">
	                    <input type="radio" id="EntregasViewEnvios2" name="EntregasViewEnvios" value="deshabilitado">
	                    <label for="EntregasViewEnvios2">
	                      Deshabilitar
	                    </label>
	                  </div>
	                <?php } ?>


	                  <table class="table table-bordered table-striped dt-responsive" style="margin-top: 10px;width: 100%;">
	                    <thead style="font-size: .8rem;">
	                      <tr>
	                        <th style="width:30%;">Vol(cm^3)</th>
	                        <th style="width:15%;">Kilos</th>
	                        <th style="width:30%;">Precio($)</th>
	                        <th style="width:25%;">
	                          <button type="button" class="btn btn-secondary btn-sm" style="font-size: .7rem; padding: 3px" data-toggle="modal" data-target="#modalAgregarConfiguracionEnvio">
	                            Nuevo 
	                          </button>
	                        </th>
	                      </tr>
	                    </thead>
	                    <tbody>
	                    <?php
	                      $item = "id_empresa";
	                      $valor = $_SESSION["idEmpresa_dashboard"];
	                      $configuracionEnvios = ControladorConfiguracionTienda::ctrMostrarEnvios($item, $valor);

	                      if (sizeof($configuracionEnvios) > 0) {
	                        foreach ($configuracionEnvios as $key => $value) {
	                    ?>

	                      <tr>
	                        <td id="tdVolumetrico">
	                          <input type="text" class="form-control text-center" id="inputTdVolumetrico" style="font-size: .7rem; padding: 4px" value="<?php echo $value["peso_volumetrico"] ?>"> 
	                        </td>
	                        <td id="tdPeso">
	                          <input type="text" class="form-control text-center" id="inputTdPeso" style="font-size: .7rem; padding: 4px" value="<?php echo $value["peso_masa"] ?>">
	                        </td>
	                        <td id="tdPrecio">
	                          <input type="text" class="form-control text-center" id="inputTdPrecio" style="font-size: .7rem; padding: 4px" value="<?php echo $value["precio"] ?>">
	                        </td>
	                        <td>
	                          <button type="button" class="btn btn-warning btnEditarConfiguracionEnvio" style="font-size: .7rem; padding: 3px" idEnvioConfiguracion="<?php echo $value["id_configuracion_envios"]; ?>">
	                            <i class="fa fa-edit"></i>
	                          </button>
	                          <button type="button" class="btn btn-danger btnEliminarConfiguracionEnvio" style="font-size: .7rem; padding: 3px" idEnvioConfiguracion="<?php echo $value["id_configuracion_envios"]; ?>">
	                            <i class="fa fa-times"></i>
	                          </button>
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

	            <div class="card-footer">
	              <button type="button" class="btn btn-success float-right btnGuardarEntregas">
	                Guardar
	              </button>
	            </div>
	          </div>
	          
	          <!--====  End of METODOS DE ENTREGA  ====-->


	          <!--============================================
	          =            CONTACTO DE LA EMPRESA            =
	          =============================================-->
	          
	          <div class="card row">
	            <div class="card-header">
	              <h3 class="card-title">Contacto de la empresa</h3>
	              <div class="card-tools">
	                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  <i class="fas fa-minus"></i></button>
	              </div>
	            </div>

	            <div class="card-body">
	              <?php
	              $item = "id_empresa";
	              $valor = $_SESSION["idEmpresa_dashboard"];
	              $contacto = ControladorConfiguracionTienda::ctrMostrarContactoEmpresa($item, $valor);
	              ?>
	              
	              <div class="mb-3">
	                <h5 class="titprod">Teléfono:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fa fa-phone"></i>
	                    </span>
	                  </div>
	                  <input type="tel" class="form-control input-lg" id="ContactoTelefono"  placeholder="Escribe el telefono de contacto..."
	                        value="<?php if($contacto != false && $contacto['telefono'] != '') echo $contacto['telefono'] ?>">
	                </div>
	              </div>

	              <div class="mb-3">
	                <h5 class="titprod">Correo electrónico:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fa fa-envelope"></i>
	                    </span>
	                  </div>
	                  <input type="email" class="form-control input-lg" id="ContactoEmail"  placeholder="Escribe el correo electronico de contacto..."
	                        value="<?php if($contacto != false && $contacto['mail'] != '') echo $contacto['mail'] ?>">
	                </div>
	              </div>
	            </div>

	            <div class="card-footer">
	              <button type="button" class="btn btn-success float-right btnContactoGuardar">
	                Guardar
	              </button>
	            </div>
	          </div>
	          
	          <!--====  End of CONTACTO DE LA EMPRESA  ====-->

	          <!--========================================
	          =            MIS REDES SOCIALES            =
	          =========================================-->
	          
	          <div class="card row">
	            <div class="card-header">
	              <h3 class="card-title">Mis Redes Sociales</h3>

	              <div class="card-tools">
	                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
	                  <i class="fas fa-minus"></i></button>
	              </div>
	            </div>

	            <div class="card-body">
	              <?php
	                $item = "id_empresa";
	                $valor = $_SESSION["idEmpresa_dashboard"];
	                $misRedesSociales = ControladorConfiguracionTienda::ctrMostrarMisRedesSociales($item, $valor);
	              ?>
	              
	              <!-- MI RED SOCIAL FACEBOOK -->

	              <div class="mb-3">
	                <h5 class="titprod">Facebook:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fab fa-facebook"></i>
	                    </span>
	                  </div> 
	                  <input type="text" class="form-control input-lg" id="misRedesFacebook"  placeholder="Pega el link de tu página de facebook" 
	                        value="<?php if($misRedesSociales != false && $misRedesSociales['facebook'] != '') echo $misRedesSociales['facebook'] ?>">
	                </div>
	              </div>

	              <!-- MI RED SOCIAL INSTAGRAM -->
	              
	              <div class="mb-3">
	                <h5 class="titprod">Instagram:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fab fa-instagram"></i>
	                    </span>
	                  </div>
	                  <input type="text" class="form-control input-lg" id="misRedesInstagram"  placeholder="Pega el link de tu cuenta de Instagram"
	                          value="<?php if($misRedesSociales != false && $misRedesSociales['instagram'] != '') echo $misRedesSociales['instagram'] ?>">
	                </div>
	              </div>
	              
	              <!-- MI RED SOCIAL TWITTER -->
	              
	              <div class="mb-3">
	                <h5 class="titprod">Twitter:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fab fa-twitter"></i>
	                    </span>
	                  </div>
	                  <input type="text" class="form-control input-lg" id="misRedesTwitter"  placeholder="Pega el link de tu cuenta de Twitter"
	                          value="<?php if($misRedesSociales != false && $misRedesSociales['twitter'] != '') echo $misRedesSociales['twitter'] ?>">
	                </div>
	              </div>
	                
	              <!-- MI RED SOCIAL YOUTUBE -->

	              <div class="mb-3">
	                <h5 class="titprod">Youtube:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fab fa-youtube"></i>
	                    </span>
	                  </div>
	                  <input type="text" class="form-control input-lg" id="misRedesYoutube"  placeholder="Pega el link de tu canal de Youtube"
	                        value="<?php if($misRedesSociales != false && $misRedesSociales['youtube'] != '') echo $misRedesSociales['youtube'] ?>">
	                </div>
	              </div>

	              <!-- MI RED SOCIAL tiktok -->
	            
	              <div class="mb-3">
	                <h5 class="titprod">Tiktok:</h5>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text">
	                      <i class="fab fa-tiktok"></i>
	                    </span>
	                  </div>
	                  <input type="text" class="form-control input-lg" id="misRedesTiktok"  placeholder="Pega el link de tu cuenta de TikTok"
	                          value="<?php if($misRedesSociales != false && $misRedesSociales['tiktok'] != '') echo $misRedesSociales['tiktok'] ?>">
	                </div>
	              </div>

	            </div>

	            <div class="card-footer">
	              <button type="button" class="btn btn-success btnMisRedesSociales float-right" idEmpresa="<?php echo $_SESSION["idEmpresa_dashboard"] ?>">
	                Guardar
	              </button>
	            </div>
	          </div>
	          
	          <!--====  End of MIS REDES SOCIALES  ====-->

    			</div>




    		</div>
    	</div>
    </section>

</div>

<!--================================================================
=            MODAL AGREGAR NUEVA CONFIGURACION DE ENVIO            =
=================================================================-->

<div id="modalAgregarConfiguracionEnvio" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formConfiguracionEnvio" enctype="multipart/form-data">

        <div class="modal-header" style="background: #343A40; color:white;">
          <h4 class="modal-title">Agregar Configuración Envío</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <div class="box-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <h5 class="titprod"> Peso Volumetrico (cm): </h5>
                <div class="input-group">
                  <div id="inputname" class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-box"></i>
                    </span>
                  </div> 
                  <input type="text" class="form-control input-lg" id="envionVolumetrico" placeholder="Escribe el peso volumetrico..." required>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <h5 class="titprod"> Peso Físico (kg): </h5>
                <div class="input-group">
                  <div id="inputname" class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-weight"></i>
                    </span>
                  </div> 
                  <input type="text" class="form-control input-lg" id="envionPeso" placeholder="Escribe el peso físico..." required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <h5 class="titprod"> Precio envío </h5>
                <div class="input-group">
                  <div id="inputname" class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                  </div> 
                  <input type="text" class="form-control input-lg" id="envionPrecio" placeholder="Escribe el precio..." required>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        
      </form>
    </div>
  </div>
</div> 

<!--====  End of MODAL AGREGAR NUEVA CONFIGURACION DE ENVIO  ====-->