<div>
	<h2>Ventana de inicio</h2>
</div>

<hr>

<div class="row">

	<div class="col-md-4 col-xs-12">
		<div class="mb-3">
		  <h5 class="titprod">Sección productos:</h5>
		  <?php if ($desencode != "") { ?>

		  	<label class="radio-inline">
			   <input type="radio" name="PersuitSeccionProducto" id="PersuitSeccionProducto" value="habilitado" <?php if($desencode[0]["Inicio_SeccionProducto"] == "habilitado") echo "checked"; ?>>Habilitar
			</label>
			<label class="radio-inline">
			   <input type="radio" name="PersuitSeccionProducto" id="PersuitSeccionProducto" value="deshabilitado" <?php if($desencode[0]["Inicio_SeccionProducto"] == "deshabilitado") echo "checked"; ?>>Deshabilitar
			</label>

		  <?php } else { ?>

		  	<label class="radio-inline">
			   <input type="radio" name="PersuitSeccionProducto" id="PersuitSeccionProducto" value="habilitado" checked>Habilitar
			</label>
			<label class="radio-inline">
			   <input type="radio" name="PersuitSeccionProducto" id="PersuitSeccionProducto" value="deshabilitado">Deshabilitar
			</label>

		  <?php } ?>
		</div>

		<div class="mb-3">
		  <h5 class="titprod">Texto de sección productos:</h5>
		  <div class="input-group">
		    <input type="text" class="form-control input-lg" id="PersuitTxtSeccionProducto" value="<?php if ($desencode != "") echo $desencode[0]['Inicio_SeccionProductoTxt'] ?>" required>
		  </div>
		</div>
	</div>

	<div class="col-md-4 col-xs-12">
		<div class="mb-3">
		  <h5 class="titprod">Etiqueta en foto del producto:</h5>

		  	<?php if ($desencode != "") { ?>

			  <label class="radio-inline">
			    <input type="radio" name="PersuitEtiquetas" id="PersuitEtiquetas" value="habilitado" <?php if($desencode[0]["Inicio_Etiqueta"] == "habilitado") echo "checked"; ?>>Habilitar
			  </label>
			  <label class="radio-inline">
			    <input type="radio" name="PersuitEtiquetas" id="PersuitEtiquetas" value="deshabilitado" <?php if($desencode[0]["Inicio_Etiqueta"] == "deshabilitado") echo "checked"; ?>>Deshabilitar
			  </label>

			<?php } else { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitEtiquetas" id="PersuitEtiquetas" value="habilitado" checked>Habilitar
				</label>
				<label class="radio-inline">
			    	<input type="radio" name="PersuitEtiquetas" id="PersuitEtiquetas" value="deshabilitado">Deshabilitar
				</label>

			<?php } ?>
		</div>

		<div class="mb-3">
		  <h5 class="titprod">Texto de etiqueta de los productos:</h5>
		  <div class="input-group">
		    <input type="text" class="form-control input-lg" id="PersuitTxtEtiquetas" value="<?php if ($desencode != "") echo $desencode[0]['Inicio_EtiquetaTxt'] ?>" required>
		  </div>
		</div>
	</div>

	<div class="col-md-4 col-xs-12">
		<div class="mb-3">
		 	<h5 class="titprod">Sección categorias:</h5>
		  	<?php if ($desencode != "") { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitseccionCategorias" id="PersuitseccionCategorias" value="habilitado" <?php if($desencode[0]["Inicio_Categoria"] == "habilitado") echo "checked"; ?>>Habilitar
				</label>
				<label class="radio-inline">
					<input type="radio" name="PersuitseccionCategorias" id="PersuitseccionCategorias" value="deshabilitado" <?php if($desencode[0]["Inicio_Categoria"] == "deshabilitado") echo "checked"; ?>>Deshabilitar
				</label>

			<?php } else { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitseccionCategorias" id="PersuitseccionCategorias" value="habilitado" checked>Habilitar
				</label>
				<label class="radio-inline">
					<input type="radio" name="PersuitseccionCategorias" id="PersuitseccionCategorias" value="deshabilitado">Deshabilitar
				</label>

			<?php } ?>

		</div>

		<div class="mb-3">
		  <h5 class="titprod">Texto de sección categorias:</h5>
		  <div class="input-group">
		    <input type="text" class="form-control input-lg" id="PersuitTxtSeccionCategorias" value="<?php if ($desencode != "") echo $desencode[0]['Inicio_CategoriaTxt'] ?>" required>
		  </div>
		</div>
	</div>
</div>

<!-- ********************************************************************************************* -->
<div>
	<h2>Ventana de busqueda de productos</h2>
</div>

<hr>

<div class="row">
	<div class="col-md-4 col-xs-12">
		<div class="mb-3">
		  <h5 class="titprod">Texto del banner:</h5>
		  <div class="input-group">
		    <input type="text" class="form-control input-lg" id="PersuitTxtBannerBusqueda" value="<?php if ($desencode != "") echo $desencode[0]['Busqueda_BannerTxt'] ?>" required>
		  </div>
		</div>
	</div>
</div>

<!-- ********************************************************************************************* -->

<div>
	<h2>Ventana detalle producto</h2>
</div>

<hr>

<div class="row">
	<div class="col-md-4 col-xs-12">
		<div class="mb-3">
		  <h5 class="titprod">Texto del banner:</h5>
		  <div class="input-group">
		    <input type="text" class="form-control input-lg" id="PersuitTxtBannerDetalle" value="<?php if ($desencode != "") echo $desencode[0]['Detalle_BannerTxt'] ?>" required>
		  </div>
		</div>
	</div>
</div>

<div class="row">

	<div class="col-md-2 col-xs-12">
		<div class="mb-3">
		  	<h5 class="titprod">Mostrar comentarios:</h5>
		  	<?php if ($desencode != "") { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitSeccionComentarios" id="PersuitSeccionComentarios" value="habilitado" <?php if($desencode[0]["Detalle_Comentarios"] == "habilitado") echo "checked"; ?>>Habilitar
				</label>
				<label class="radio-inline">
					<input type="radio" name="PersuitSeccionComentarios" id="PersuitSeccionComentarios" value="deshabilitado" <?php if($desencode[0]["Detalle_Comentarios"] == "deshabilitado") echo "checked"; ?>>Deshabilitar
				</label>

			<?php } else { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitSeccionComentarios" id="PersuitSeccionComentarios" value="habilitado" checked>Habilitar
				</label>
				<label class="radio-inline">
					<input type="radio" name="PersuitSeccionComentarios" id="PersuitSeccionComentarios" value="deshabilitado">Deshabilitar
				</label>

			<?php } ?> 
		</div>
	</div>

	<div class="col-md-2 col-xs-12">
		<div class="mb-3">
			<h5 class="titprod">Mostrar stock:</h5>
			<?php if ($desencode != "") { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitseccionStock" id="PersuitseccionStock" value="habilitado" <?php if($desencode[0]["Detalle_Stock"] == "habilitado") echo "checked";?>>Habilitar
				</label>
				<label class="radio-inline">
					<input type="radio" name="PersuitseccionStock" id="PersuitseccionStock" value="deshabilitado" <?php if($desencode[0]["Detalle_Stock"] == "deshabilitado") echo "checked";?>>Deshabilitar
				</label>

			<?php } else { ?>

				<label class="radio-inline">
					<input type="radio" name="PersuitseccionStock" id="PersuitseccionStock" value="habilitado" checked>Habilitar
				</label>
				<label class="radio-inline">
					<input type="radio" name="PersuitseccionStock" id="PersuitseccionStock" value="deshabilitado">Deshabilitar
				</label>

			<?php } ?>

		</div>
	</div>

	<div class="col-md-2 col-xs-12">
		<div class="mb-3">
		  	<h5 class="titprod">Mostrar costo de envío:</h5>
		  	<?php if ($desencode != "") { ?>

			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionCostoEnvio" id="PersuitseccionCostoEnvio" value="habilitado" <?php if($desencode[0]["Detalle_CostoEnvio"] == "habilitado") echo "checked";?>>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionCostoEnvio" id="PersuitseccionCostoEnvio" value="deshabilitado" <?php if($desencode[0]["Detalle_CostoEnvio"] == "deshabilitado") echo "checked";?>>Deshabilitar
			  	</label>

			<?php } else { ?>

				<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionCostoEnvio" id="PersuitseccionCostoEnvio" value="habilitado" checked>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionCostoEnvio" id="PersuitseccionCostoEnvio" value="deshabilitado">Deshabilitar
			  	</label>

			<?php } ?>
		</div>

	</div>

	<div class="col-md-2 col-xs-12">

		<div class="mb-3">
		  	<h5 class="titprod">Mostrar envios:</h5>

		  	<?php if ($desencode != "") { ?>

			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionEnvios" id="PersuitseccionEnvios" value="habilitado" <?php if($desencode[0]["Detalle_Envios"] == "habilitado") echo "checked";?>>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionEnvios" id="PersuitseccionEnvios" value="deshabilitado" <?php if($desencode[0]["Detalle_Envios"] == "deshabilitado") echo "checked";?>>Deshabilitar
			  	</label>

			<?php } else { ?>

				<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionEnvios" id="PersuitseccionEnvios" value="habilitado" checked>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionEnvios" id="PersuitseccionEnvios" value="deshabilitado">Deshabilitar
			  	</label>

			<?php } ?>

		</div>

	</div>

	<div class="col-md-2 col-xs-12">
		
		<div class="mb-3">
		  	<h5 class="titprod">Mostrar formas de pago:</h5>
		  	<?php if ($desencode != "") { ?>

			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionFormasPago" id="PersuitseccionFormasPago" value="habilitado" <?php if($desencode[0]["Detalle_FormasPago"] == "habilitado") echo "checked";?>>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionFormasPago" id="PersuitseccionFormasPago" value="deshabilitado" <?php if($desencode[0]["Detalle_FormasPago"] == "deshabilitado") echo "checked";?>>Deshabilitar
			  	</label>

			<?php } else { ?>

				<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionFormasPago" id="PersuitseccionFormasPago" value="habilitado" checked>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionFormasPago" id="PersuitseccionFormasPago" value="deshabilitado">Deshabilitar
			  	</label>

			<?php } ?>
		</div>

	</div>

	<div class="col-md-2 col-xs-12">
		
		<div class="mb-3">
		  	<h5 class="titprod">Mostrar productos relacionados:</h5>
		  	<?php if ($desencode != "") { ?>

			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionProductosRelacionados" id=PersuitseccionProductosRelacionados value="habilitado" <?php if($desencode[0]["Detalle_ProductosRelacionados"] == "habilitado") echo "checked";?>>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionProductosRelacionados" id=PersuitseccionProductosRelacionados value="deshabilitado" <?php if($desencode[0]["Detalle_ProductosRelacionados"] == "deshabilitado") echo "checked";?>>Deshabilitar
			  	</label>

			<?php } else { ?>

				<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionProductosRelacionados" id=PersuitseccionProductosRelacionados value="habilitado" checked>Habilitar
			  	</label>
			  	<label class="radio-inline">
			    	<input type="radio" name="PersuitseccionProductosRelacionados" id=PersuitseccionProductosRelacionados value="deshabilitado">Deshabilitar
			  	</label>

			<?php } ?>
		</div>

	</div>

</div>

<div class="row">
	<div class="col-12">
		<input type="hidden" id="idConfigMiPlantilla" value="<?php echo $plantilla[0] ?>">
		<input type="hidden" id="jsonConfigPlantillaInput" value="<?php echo $configuracion[1] ?>">
		<button type="button" class="btn btn-success btnGuardarConfiguracion float-right">Guardar</button>
	</div>	
</div>


<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->

<div>
	<h2>Imagenes</h2>
</div>

<hr>

<div class="row">

	<div class="col-md-3 col-xs-12">
		<div class="tituloImgPlantilla">
			<h3>Principal Inicio</h3>
		</div>
		<div class="imgConfigView">
			<img src="<?php 
						if($configuracion != false && $configuracion['imagenes'] != '') {
							if($desencodeImagenes['PersuitInicioUrl'] != ''){
								echo $desencodeImagenes['PersuitInicioUrl'];
							} else {
								echo '../persuit/img/bannerTienda.jpeg';
							}
						} else {
							echo '../persuit/img/bannerTienda.jpeg';		
						} ?>" 
				id="PersuitInicio">
		</div>
		<div id="PersuitCargaInicio"></div>
        <div>
        	<button type="button" class="btn btn-secondary btn-block" id="btnImagenPersuitInicio">
            	<i class="fas fa-folder-plus"></i>Seleccionar imagen
          	</button>
          	<input type="hidden" id="PersuitInicioUrl" name="PersuitInicioUrl" value="<?php if($configuracion != false && $configuracion['imagenes'] != '') echo $desencodeImagenes['PersuitInicioUrl'] ?>">
        </div>
	</div>

	<div class="col-md-3 col-xs-12">
		<div class="tituloImgPlantilla">
			<h3>Banner</h3>
		</div>
		<div class="imgConfigView">
        	<img src="<?php
        				if($configuracion != false && $configuracion['imagenes'] != ''){
        					
        					if($desencodeImagenes['PersuitBannersUrl'] != ''){
        						 echo $desencodeImagenes['PersuitBannersUrl'];
        					} else {
        						echo '../persuit/img/principalBanner.jpeg';	
        					}

        				} else {
        						echo '../persuit/img/principalBanner.jpeg';	
        				}?>" 
        		id="PersuitBanners">

        </div>
        <div id="PersuitCargaBanners"></div>
        <div>
        	<button type="button" class="btn btn-secondary btn-block" id="btnImagenPersuitBanners">
            	<i class="fas fa-folder-plus"></i>Seleccionar imagen
          	</button>
          	<input type="hidden" id="PersuitBannersUrl" name="PersuitBannersUrl" value="<?php if($configuracion != false && $configuracion['imagenes'] != '') echo $desencodeImagenes['PersuitBannersUrl'] ?>">
        </div>
	</div>

	<div class="col-md-3 col-xs-12">
		<div class="tituloImgPlantilla">
			<h3>Inicio de sesión</h3>
		</div>
		<div class="imgConfigView">
        	<img src="<?php 
        				if($configuracion != false && $configuracion['imagenes'] != ''){ 
        					if($desencodeImagenes['PersuitSesionUrl'] != ''){
        						 echo $desencodeImagenes['PersuitSesionUrl'];
        					} else {
        						echo '../persuit/img/login.jpeg';
        					}
        				} else {
        					echo '../persuit/img/login.jpeg';
        				} ?>" 
        		id="PersuitSesion">
        </div>
        <div id="PersuitCargaSesion"></div>
        <div>
        	<button type="button" class="btn btn-secondary btn-block" id="btnImagenPersuitSesion">
            	<i class="fas fa-folder-plus"></i>Seleccionar imagen
          	</button>
          	<input type="hidden" id="PersuitSesionUrl" name="PersuitSesionUrl" value="<?php if($configuracion != false && $configuracion['imagenes'] != '') echo $desencodeImagenes['PersuitSesionUrl'] ?>">
        </div>
	</div>

	<div class="col-md-3 col-xs-12">
		<div class="tituloImgPlantilla">
			<h3>Registro</h3>
		</div>
		<div class="imgConfigView">
        	<img src="<?php 
        				if($configuracion != false && $configuracion['imagenes'] != ''){ 
        					if($desencodeImagenes['PersuitRegistroUrl'] != ''){
        						 echo $desencodeImagenes['PersuitRegistroUrl'];
        					} else {
        						echo '../persuit/img/registro.jpeg';
        					}
        				} else {
        					echo '../persuit/img/registro.jpeg';
        				}?>" 
        			id="PersuitRegistro">
        </div>
        <div id="PersuitCargaRegistro"></div>
        <div>
        	<button type="button" class="btn btn-secondary btn-block" id="btnImagenPersuitRegistro">
            	<i class="fas fa-folder-plus"></i>Seleccionar imagen
          	</button>
          	<input type="hidden" id="PersuitRegistroUrl" name="PersuitRegistroUrl" value="<?php if($configuracion != false && $configuracion['imagenes'] != '') echo $desencodeImagenes['PersuitRegistroUrl'] ?>">
        </div>
	</div>

</div>

<div class="row">
	<div class="col-12 mb-3">
		<input type="hidden" name="idConfigPlantillaImagen" id="idConfigPlantillaImagen" value="<?php echo $plantilla[0] ?>">
		<button type="button" class="btn btn-success float-right btnGuardarImgPlantilla">Guardar</button>
	</div>
</div>


<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->
<!-- ************************************************************************************************** -->

<div>
	<h2>Colores</h2>
</div>

<hr>

<!--================================================================================================
=            CODIGO PARA VISUALIZACION DE CONFIGURACION DE COLORES EN EL MENU Y SUBMENU            =
=================================================================================================-->

<div class="row">
	<div class="col-md-6 col-xs-12">
		<table class="table">
	        <tr>
	          <th style="width: 70%;">Menu Fondo</th>
	          <td>
	          	<input type="color" class="form-control" id="PersuitMenuFondo" value="<?php if($configuracion != false && $configuracion['colores'] != '') echo $desencodeColores[0]['MenuFondo'] ?>">
	          </td>
	        </tr>
	        <tr>
	          <th style="width: 70%;">Submenu Fondo</th>
	          <td>
	          	<input type="color" class="form-control" id="PersuitSubmenuFondo" value="<?php if($configuracion != false && $configuracion['colores'] != '') echo $desencodeColores[0]['SubmenuFondo'] ?>">
	          </td>
	        </tr>
	        <tr>
	          <th style="width: 70%;">Letra Menu</th>
	          <td>
	            <input type="color" class="form-control" id="PersuitLetrasMenu" value="<?php if($configuracion != false && $configuracion['colores'] != '') echo $desencodeColores[0]['letrasMenu'] ?>">
	          </td>
	        </tr>
	        <tr>
	          <th style="width: 70%;">Letra Menu (sobrepuesto).</th>
	          <td>
	            <input type="color" class="form-control" id="PersuitLetrasMenuSobre" value="<?php if($configuracion != false && $configuracion['colores'] != '') echo $desencodeColores[0]['letrasMenuSobre'] ?>">
	          </td>
	        </tr>
	        <tr>
	          <th style="width: 70%;">Letra Submenu</th>
	          <td>
	            <input type="color" class="form-control" id="PersuitLetrasSubmenu" value="<?php if($configuracion != false && $configuracion['colores'] != '') echo $desencodeColores[0]['letrasSubmenu'] ?>">
	          </td>
	        </tr>
	        <tr>
	          <th style="width: 70%;">Letra Submenu (sobrepuesto)</th>
	          <td>
	            <input type="color" class="form-control" id="PersuitLetrasSubmenuSobre" value="<?php if($configuracion != false && $configuracion['colores'] != '') echo $desencodeColores[0]['letrasSubmenuSobre'] ?>">
	          </td>
	        </tr>
	        <input type="hidden" id="idConfigPlantillaColor" value="<?php echo $plantilla[0] ?>">
	        <tr>
	        	<th colspan="2">
	        		<button type="button" class="btn btn-success btnGuardarColoresPersuit float-right">Guardar</button>
	        	</th>
	    	</tr>
	    </table>
	</div>
</div>

<!--====  End of CODIGO PARA VISUALIZACION DE CONFIGURACION DE COLORES EN EL MENU Y SUBMENU  ====-->