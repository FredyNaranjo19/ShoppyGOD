/*==========================================================
=            GUARDAR CONFIGURACION DE PLANTILLA            =
==========================================================*/

$(document).on("click", ".btnGuardarConfiguracion", function(){

	var idMiPlantilla = $("#idConfigMiPlantilla").val();
	var listaConfigPersuit = [];

	/* VARIABLES PARA VENTANA INICIO */
	var inicioProductos = $('input:radio[id=PersuitSeccionProducto]:checked').val();
	var inicioProductosTxt = $("#PersuitTxtSeccionProducto").val();
	var inicioEtiqueta = $('input:radio[id=PersuitEtiquetas]:checked').val();
	var inicioEtiquetaTxt = $("#PersuitTxtEtiquetas").val();
	var inicioCategorias = $('input:radio[id=PersuitseccionCategorias]:checked').val();
	var inicioCategoriasTxt = $("#PersuitTxtSeccionCategorias").val();

	/* VARIABLES PARA VENTANA BUSQUEDA */
	
	var busquedaBannerTxt = $("#PersuitTxtBannerBusqueda").val();

	/* VARIABLES PARA VENTANA DETALLE */
	var detalleBannerTxt = $("#PersuitTxtBannerDetalle").val();
	var detalleComentarios = $('input:radio[id=PersuitSeccionComentarios]:checked').val();
	var detalleStock = $('input:radio[id=PersuitseccionStock]:checked').val();
	var detalleCostoEnvio = $('input:radio[id=PersuitseccionCostoEnvio]:checked').val();
	var detalleEnvios = $('input:radio[id=PersuitseccionEnvios]:checked').val();
	var detalleFormasPago = $('input:radio[id=PersuitseccionFormasPago]:checked').val();
	var detalleProductosRelacionados = $('input:radio[id=PersuitseccionProductosRelacionados]:checked').val();
		
	listaConfigPersuit.push({
			"Inicio_SeccionProducto" : inicioProductos,
			"Inicio_SeccionProductoTxt" : inicioProductosTxt,
			"Inicio_Etiqueta" : inicioEtiqueta,
			"Inicio_EtiquetaTxt" : inicioEtiquetaTxt,
			"Inicio_Categoria" : inicioCategorias,
			"Inicio_CategoriaTxt" : inicioCategoriasTxt,
			"Busqueda_BannerTxt" : busquedaBannerTxt,
			"Detalle_BannerTxt" : detalleBannerTxt,
			"Detalle_Comentarios" : detalleComentarios,
			"Detalle_Stock" : detalleStock,
			"Detalle_CostoEnvio" : detalleCostoEnvio,
			"Detalle_Envios" : detalleEnvios,
			"Detalle_FormasPago" : detalleFormasPago,
			"Detalle_ProductosRelacionados" : detalleProductosRelacionados
	})


	var datos = new FormData();
	datos.append("idMiPlantillaConf", idMiPlantilla);
	datos.append("configMiPlantilla", JSON.stringify(listaConfigPersuit));

	$.ajax({
		url: '../items/mvc/ajax/dashboard/configuracion-tienda-plantilla.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			// window.location = "index.php?ruta=configuracionPlantilla&&mi="+idMiPlantilla;

			if (respuesta == "ok") {
        		toastr.success("se guardo la configuración correctamente!");
     		}


		}
	})
})

/*=====  End of GUARDAR CONFIGURACION DE PLANTILLA  ======*/

/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************************************************************** */
/* *************************************  IMAGENES  ************************************* */

/*========================================
=            IMAGEN DE INICIO            =
========================================*/

$(document).on("click", "#btnImagenPersuitInicio", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 1000, // maximum width
            height: 1000 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('PersuitInicio').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            PersuitFotoInicio(blob);
        });

    }
    input.click();

})


function PersuitFotoInicio(blob){

	var idConfig = $("#idConfigPlantillaImagen").val();

    var ImgName = "";

    ImgName = ImgName.concat(idConfig + "-PersuitImagenInicio");

    var uploadTask = firebase.storage().ref('persuit/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('PersuitCargaInicio').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) { 
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('persuitp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });
            $("#PersuitInicioUrl").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('PersuitCargaInicio').innerHTML = 'Exitoso!';
        });
      });

}


/*=====  End of IMAGEN DE INICIO  ======*/

/*======================================
=            IMAGEN BANNERS            =
======================================*/

$(document).on("click", "#btnImagenPersuitBanners", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 1000, // maximum width
            height: 1000 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('PersuitBanners').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            PersuitFotoBanners(blob);
        });

    }
    input.click();

})

function PersuitFotoBanners(blob){

	var idConfig = $("#idConfigPlantillaImagen").val();

    var ImgName = "";

    ImgName = ImgName.concat(idConfig + "-PersuitImagenBanners");

    var uploadTask = firebase.storage().ref('persuit/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('PersuitCargaBanners').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('persuitp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#PersuitBannersUrl").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('PersuitCargaBanners').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of IMAGEN BANNERS  ======*/

/*===============================================
=            IMAGEN INICIO DE SESION            =
===============================================*/

$(document).on("click", "#btnImagenPersuitSesion", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 500, // maximum width
            height: 500 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('PersuitSesion').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            PersuitFotoSesion(blob);
        });

    }
    input.click();

})

function PersuitFotoSesion(blob){

	var idConfig = $("#idConfigPlantillaImagen").val();

    var ImgName = "";

    ImgName = ImgName.concat(idConfig + "-PersuitImagenInicioSesion");

    var uploadTask = firebase.storage().ref('persuit/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('PersuitCargaSesion').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('persuitp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#PersuitSesionUrl").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('PersuitCargaSesion').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of IMAGEN INICIO DE SESION  ======*/

/*=====================================================
=            IMAGEN DE REGISTRO DE USUARIO            =
=====================================================*/

$(document).on("click", "#btnImagenPersuitRegistro", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 500, // maximum width
            height: 500 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('PersuitRegistro').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            PersuitFotoRegistros(blob);
        });

    }
    input.click();

})


function PersuitFotoRegistros(blob){

	var idConfig = $("#idConfigPlantillaImagen").val();

    var ImgName = "";

    ImgName = ImgName.concat(idConfig + "-PersuitImagenRegistro");

    var uploadTask = firebase.storage().ref('persuit/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('PersuitCargaRegistro').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('persuitp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#PersuitRegistroUrl").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('PersuitCargaRegistro').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of IMAGEN DE REGISTRO DE USUARIO  ======*/

/*===============================================================
=            GUARDAR URL DE IMAGENES DE LA PLANTILLA            =
===============================================================*/

$(document).on("click", ".btnGuardarImgPlantilla", function(){

	var PersuitInicioUrl = $("#PersuitInicioUrl").val();
	var PersuitBannersUrl =$("#PersuitBannersUrl").val();
	var PersuitSesionUrl =$("#PersuitSesionUrl").val();
	var PersuitRegistroUrl =$("#PersuitRegistroUrl").val();
	var idConfigPlantillaImagen =$("#idConfigPlantillaImagen").val();

	var datos = new FormData();
	datos.append("PersuitInicioUrl", PersuitInicioUrl);
	datos.append("PersuitBannersUrl", PersuitBannersUrl);
	datos.append("PersuitSesionUrl", PersuitSesionUrl);
	datos.append("PersuitRegistroUrl", PersuitRegistroUrl);
	datos.append("idConfigPlantillaImagen", idConfigPlantillaImagen);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/configuracion-tienda-plantilla.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if (respuesta == "ok") {
        		toastr.success("se guardo la configuración correctamente!");
     		}

		}
	})
})

/*=====  End of GUARDAR URL DE IMAGENES DE LA PLANTILLA  ======*/

/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************************************************************** */
/* ************************************  COLORES  *************************************** */

/*=====================================================================
=            GUARDAR CONFIGURACION DE COLORES DE PLANTILLA            =
=====================================================================*/


$(document).on("click", ".btnGuardarColoresPersuit", function(){

    var listaColoresPersuit = [];

    var idMiPlantilla = $("#idConfigPlantillaColor").val();
    var menu = $("#PersuitMenuFondo").val();
    var submenu = $("#PersuitSubmenuFondo").val();
    var letraM = $("#PersuitLetrasMenu").val();
    var letraMS = $("#PersuitLetrasMenuSobre").val();
    var letraS = $("#PersuitLetrasSubmenu").val();
    var letraSS = $("#PersuitLetrasSubmenuSobre").val();


    listaColoresPersuit.push({
        "MenuFondo" : menu,
        "SubmenuFondo" : submenu,
        "letrasMenu" : letraM,
        "letrasMenuSobre" : letraMS,
        "letrasSubmenu" : letraS,
        "letrasSubmenuSobre" : letraSS
    })

    var variableJson = JSON.stringify(listaColoresPersuit);

    var datos = new FormData();
    datos.append("colorJson", variableJson);
    datos.append("colorIdMiPlantilla", idMiPlantilla);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/configuracion-tienda-plantilla.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if (respuesta == "ok") {
				toastr.success("se guardo la configuración correctamente!");
			}	

		}
	})

})