/*============================================================
=            SUBIR LOGO DE LA EMPRESA PARA TIENDA            =
============================================================*/

$(document).on("click", "#btnImagenLogo", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 420, // maximum width
            height: 420 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('previsualizarLogo').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            logoEmpresa(blob);
        });

    }
    input.click();

})

function logoEmpresa(blob){

    var id = $("#idEmpresaLogo").val();

    var ImgName = "";

    ImgName = ImgName.concat(id + "-Logo");

    var uploadTask = firebase.storage().ref('logos/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('LogotxtCarga').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('logosp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#urlLogo").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('LogotxtCarga').innerHTML = 'Exitoso!';
        });
      });

}
/*=====  End of SUBIR LOGO DE LA EMPRESA PARA TIENDA  ======*/

/*=====================================================
=            GUARDAR LOGO EN BASE DE DATOS            =
=====================================================*/

$(document).on("click", ".btnGuardarLogo", function(){

	var id = $("#idEmpresaLogo").val();
	var imagen = $("#urlLogo").val();

	if (imagen != "") {
		var datos = new FormData();
		datos.append("LogoEmpresaID", id);
		datos.append("LogoEmpresaUrl", imagen);

		$.ajax({
			url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				
				toastr.success("se guardo la imagen correctamente!");
			}
		})
	} else {

		toastr.error("Se necesita cargar una imagen...");

	}

})

/*=====  End of GUARDAR LOGO EN BASE DE DATOS  ======*/

/*====================================================
=            GUARDAR CONFIGURACION DE SEO            =
====================================================*/

$(document).on("click", ".btnGuardarConfiguracionSEO", function(){

  	var descripcion = $("#seoDescripcion").val();
  	var keyword = $("#seoKeywords").val();

  	var listaConfigSEO = [];

    listaConfigSEO.push({
        "SEO_Description" : descripcion,
        "SEO_Keywords" : keyword
    })

  	var datos = new FormData();
  	datos.append("configuracionSEO",JSON.stringify(listaConfigSEO));

  	$.ajax({
    	url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
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

/*=====  End of GUARDAR CONFIGURACION DE SEO  ======*/

/*=========================================================
=            COINCIDENCIA DE NUMERO DE TARJETA            =
=========================================================*/

$(document).on("change", "#PagosnTarjetaEfectivo", function(){

  var tarjeta = $(this).val();
  var reTarjeta = $("#PagosnTarjeta2").val();

  if (tarjeta != "") {
    
    if (tarjeta != reTarjeta) {

      $("#PagosnTarjeta2").val("");

      $(".btnGuardarPagos").hide("slow");

    } else {

      $(".btnGuardarPagos").show("slow");

    }

  }

})


$(document).on("change", "#PagosnTarjeta2", function(){


  var reTarjeta = $(this).val();
  var tarjeta = $("#PagosnTarjetaEfectivo").val();

  if (tarjeta != "") {
    
    if (reTarjeta != tarjeta) {

      $(this).val("");

      $(".btnGuardarPagos").hide("slow");

    } else {

      $(".btnGuardarPagos").show("slow");

    }

  }

})

/*=====  End of COINCIDENCIA DE NUMERO DE TARJETA  ======*/

/*=====================================================
=            MANDAR CODIGO DE CONFIRMACION            =
=====================================================*/

$(document).on("click", ".btnSolicitudCodigo", function(){

  max = 9999;
  min = 1000;

  var codigo = Math.round(Math.random() * (max - min) + min);

  var datos = new FormData();
  datos.append("CreacionCodigoVerificacion", codigo);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/codigoPagosEmail.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      // console.log(respuesta);
      
      if (respuesta == "Exito") {

        toastr.success("Email enviado correctamente");

      } else if (respuesta == "Error") {

        toastr.error("Error al enviar email");

      } else if (respuesta == "No-guardo") {

        toastr.error("Error al generar codigo, intenta más tarde...");

      }

    }
  })

})

/*=====  End of MANDAR CODIGO DE CONFIRMACION  ======*/

/*===========================================================================
=            CMABIO DE VALOR CODIGO PARA HABILITAR BOTON GUARDAR            =
===========================================================================*/

$(document).on("change", "#codigoVerificacionPago", function(){

  let datos = new FormData();
  datos.append("MostrarCodigoVerificacion","1")

  $.ajax({
    url: "../items/mvc/ajax/dashboard/codigoPagosEmail.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false, 
    processData: false,
    dataType: "json",
    success: function(respuesta){

      let codigo = $("#codigoVerificacionPago").val();
      
      if(codigo === respuesta[0]){

        $(".btnGuardarPagos").prop("disabled",false);
    
      }else{
        toastr.error("el código no coincide!");
        $(".btnGuardarPagos").prop("disabled","disabled");
      }
    }
  })

})

/*=====  End of CMABIO DE VALOR CODIGO PARA HABILITAR BOTON GUARDAR  ======*/

/*==============================================
=            GUARDAR FORMAS DE PAGO            =
==============================================*/

$(document).on("click", ".btnGuardarPagos", function(){

  	var codigo = $("#codigoVerificacionPago").val();

 	if (codigo != "") {

		var guardarPago = "1";
		var efectivo = $('input:radio[name=PagosViewEfectivo]:checked').val();
		var tarjeta = $("#PagosnTarjetaEfectivo").val();
		var banco = $("#PagosBanco").val();
		var propietario = $("#PagosPropietario").val();

		var mercado = $('input:radio[name=PagosViewMercado]:checked').val();
		var access = $("#PagosnTarjetaMercado").val();

		var datos = new FormData();
		datos.append("PagoVariable", guardarPago);
		datos.append("PagoEfectivoView", efectivo);
		datos.append("PagoEfectivoTarjeta", tarjeta);
		datos.append("PagoBanco", banco);
		datos.append("PagoPropietario", propietario);
		datos.append("PagoMercadoView", mercado);
		datos.append("PagoMercadoAccess", access);
		datos.append("PagoCodigoVerificacion", codigo);

		$.ajax({
			url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
			method: "POST",
			data: datos,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success: function(respuesta){
			  
			  if (respuesta != "No coincide") {

			    toastr.success("se guardo los datos exitosamente!");

			  } else {

			    toastr.error("No coincide el codigo de verificación");
			    
			  }

			  $("#codigoVerificacionPago").val("");
			  $(".btnGuardarPagos").prop("disabled","disabled");

			}
		})
  	
  } else {

    toastr.error("Necesitas escribir el codigo de verificación.");

  }

})

/*=====  End of GUARDAR FORMAS DE PAGO  ======*/

/*==============================================
=            GUARDAR REDES SOCIALES            =
==============================================*/

$(document).on("submit", "#formConfiguracionRedesSociles", function(e){
  e.preventDefault();

  var whats = $('input:radio[name=seccionWhats]:checked').val();
  var numWhats = $("#numbWhats").val();
  var textWhats = $("#textWhats").val();

  var messenger = $('input:radio[name=seccionMessenger]:checked').val();
  var idPage = $("#idPage").val();
  var colorPage = $("#colorPage").val();
  var entradaPage = $("#entradaPage").val();
  var salidaPage = $("#salidaPage").val();


  var datos = new FormData();
  datos.append("whats", whats);
  datos.append("numWhats", numWhats);
  datos.append("textWhats", textWhats);
  datos.append("messenger", messenger);
  datos.append("idPage", idPage);
  datos.append("colorPage", colorPage);
  datos.append("entradaPage", entradaPage);
  datos.append("salidaPage", salidaPage);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false, 
    processData: false,
    dataType: "json",
    success: function(respuesta){

      if (respuesta == 'ok') {

        toastr.success("se guardo los datos exitosamente!");

      }

    }
  })
})

/*=====  End of GUARDAR REDES SOCIALES  ======*/

/*======================================================
=            GUARDAR TERMINOS Y CONDICIONES            =
======================================================*/

$(document).on("submit", "#formTerminosPoliticas", function(e){
  e.preventDefault();

  
  var empresa = "entro";
  var terminos = $("#terminosEmpresa").val();
  var politicas = $("#politicasEmpresa").val();

  var datos = new FormData();
  datos.append("empresaTerminosPoliticas", empresa);
  datos.append("terminosTextoTerminosPoliticas", terminos);
  datos.append("politicasTextoTerminosPoliticas", politicas);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      toastr.success("se guardo los datos exitosamente000!");

    }
  })
})

/*=====  End of GUARDAR TERMINOS Y CONDICIONES  ======*/

/*=========================================================
=            GUARDAR CONFIGURACION DE ENTREGAS            =
=========================================================*/

$(document).on("click", ".btnGuardarEntregas", function(){

  var guardarEntregas = "1";
  var sucursal = $('input:radio[name=EntregasViewSucursal]:checked').val();
  var envios =  $('input:radio[name=EntregasViewEnvios]:checked').val();

  var datos = new FormData();
  datos.append("EntregasSucursal", sucursal);
  datos.append("EntregasEnvios", envios);
  datos.append("EntregasVariable", guardarEntregas);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      
      toastr.success("se guardo los datos exitosamente!");

    }
  })

})

/*=====  End of GUARDAR CONFIGURACION DE ENTREGAS  ======*/

/*=====================================================================
=            GUARDAR CONFIGURACION NUEVA DE COSTO DE ENVIO            =
=====================================================================*/

$(document).on("submit", "#formConfiguracionEnvio", function(e){

  e.preventDefault();

  var empresa = $("#envionEmpresa").val();
  var volumetrico = $("#envionVolumetrico").val();
  var peso = $("#envionPeso").val();
  var precio = $("#envionPrecio").val();

  var datos = new FormData();
  datos.append("configuracionEnvioVolumetrico", volumetrico);
  datos.append("configuracionEnvioPeso", peso);
  datos.append("configuracionEnvioPrecio", precio);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      
      if (respuesta == 'ok') {

        window.location = "tienda-configuracion";

      }

    }
  })

})

/*=====  End of GUARDAR CONFIGURACION NUEVA DE COSTO DE ENVIO  ======*/

/*===========================================================
=            EDITAR CONFIGURACION COSTO DE ENVIO            =
===========================================================*/

$(document).on("click", ".btnEditarConfiguracionEnvio", function(){

  var id = $(this).attr("idEnvioConfiguracion");
  var volumetrico = $(this).parent().parent().children("#tdVolumetrico").children("#inputTdVolumetrico").val();
  var peso = $(this).parent().parent().children("#tdPeso").children("#inputTdPeso").val();
  var precio = $(this).parent().parent().children("#tdPrecio").children("#inputTdPrecio").val();

  var datos = new FormData();
  datos.append("configuracioeEnvioId", id);
  datos.append("configuracioeEnvioVolumetrico", volumetrico);
  datos.append("configuracioeEnvioPeso", peso);
  datos.append("configuracioeEnvioPrecio", precio);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      
      if (respuesta == 'ok') {

        toastr.success("se guardo los datos exitosamente!");

      }

    }
  })

})

/*=====  End of EDITAR CONFIGURACION COSTO DE ENVIO  ======*/

/*=============================================================
=            ELIMINAR CONFIGURACION COSTO DE ENVIO            =
=============================================================*/

$(document).on("click", ".btnEliminarConfiguracionEnvio", function(){

  var id = $(this).attr("idEnvioConfiguracion");



  var datos = new FormData();
  datos.append("idEliminarConfiguracionEnvio", id);

  Swal.fire({
    title: 'Estás seguro de eliminar la configuración de envío?',
    text: "No podra ser recuperado!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {

      $.ajax({
        url: '../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
          if (respuesta == 'ok') {

            window.location = "tienda-configuracion";

          }
        }
      })
    }
  })

})

/*=====  End of ELIMINAR CONFIGURACION COSTO DE ENVIO  ======*/

/*===============================================================
=            GUARDAR INFORMACION DE CONTACTO EMPRESA            =
===============================================================*/

$(document).on("click", ".btnContactoGuardar", function(){

  var empresaContacto = "ContactoEmpresa";
  var mail = $("#ContactoEmail").val();
  var tel = $("#ContactoTelefono").val();
  
  var datos = new FormData();
  datos.append("empresaContactoEmpresa", empresaContacto);
  datos.append("mailContactoEmpresa", mail);
  datos.append("telContactoEmpresa", tel);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){
      toastr.success("se guardo los datos exitosamente!");

    }
  })

})

/*=====  End of GUARDAR INFORMACION DE CONTACTO EMPRESA  ======*/

/*==================================================
=            GUARDAR MIS REDES SOCIALES            =
==================================================*/

$(document).on("click", ".btnMisRedesSociales", function(){

  var empresaMisRedes = "Mis redes";
  var facebook = $("#misRedesFacebook").val();
  var instagram = $("#misRedesInstagram").val();
  var twitter = $("#misRedesTwitter").val();
  var youtube = $("#misRedesYoutube").val();
  var tiktok = $("#misRedesTiktok").val();

  var datos =  new FormData();
  datos.append("misRedesEmpresa", empresaMisRedes);
  datos.append("misRedesFacebook",facebook);
  datos.append("misRedesInstagram",instagram);
  datos.append("misRedesTwitter",twitter);
  datos.append("misRedesYoutube",youtube);
  datos.append("misRedesTiktok",tiktok);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/configuracion-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      toastr.success("se guardo los datos exitosamente!");

    }
  })

})

/*=====  End of GUARDAR MIS REDES SOCIALES  ======*/