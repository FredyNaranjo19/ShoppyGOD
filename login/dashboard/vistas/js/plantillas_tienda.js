/*=========================================
=            PLANTILLAS FILTRO            =
=========================================*/
$(function () {
  $('.filter-container').filterizr({gutterPixels: 3});
  $('.btnPlantilla[data-filter]').on('click', function() {
    $('.btnPlantilla[data-filter]').removeClass('active');
    $(this).addClass('active');
  });
})

/*=====  End of PLANTILLAS FILTRO  ======*/

/*==============================================
=            VIEW DE MIS PLANTILLAS            =
==============================================*/

$(document).on("click", ".btnPlantillaView", function(){
  var Plantilla = $(this).attr("Plantilla");

  window.open(GlobalURL+"items/plantillas/demos/" + Plantilla);

})

/*=====  End of VIEW DE MIS PLANTILLAS  ======*/

/*===============================================
=            CONFIGURACION PLANTILLA            =
===============================================*/

$(document).on("click", ".btnConfigurarPlantilla", function(){

  var plantilla = $(this).attr("idMiPlantilla");

  window.location = "index.php?ruta=tienda-plantillas-configuracion&&mi="+plantilla;

})

/*=====  End of CONFIGURACION PLANTILLA  ======*/

/*=========================================
=            OBTENER PLANTILLA            =
=========================================*/

$(document).on("click", ".btnObtenerPlantilla", function(){

    var idPlantilla = $(this).attr("idPlantilla");

    window.location = 'index.php?ruta=tienda-plantillas-compras&&IdPl='+idPlantilla;
  
})

/*=====  End of OBTENER PLANTILLA  ======*/

/*==================================================
=            OBTENER PLANTILLA GRATUITA            =
==================================================*/

$(document).on("click", ".btnCompraFreePlantilla", function(){

  var ruta = $(this).attr("ruta"); 
  window.location = 'index.php?ruta=tienda-plantillas-successful&'+ruta;

})

/*=====  End of OBTENER PLANTILLA GRATUITA  ======*/

/*=============================================
=            SELECCIONAR PLANTILLA            =
=============================================*/

$(document).on("click", ".btnSeleccionarPlantilla", function(){

  var empresa = $(this).attr("idEmpresa");
  var plantilla = $(this).attr("idPlantilla");

  var datos = new FormData();
  datos.append("idEmpresaS", empresa);
  datos.append("idPlantillaS", plantilla);

  $.ajax({
    url:"../items/mvc/ajax/dashboard/configuracion-tienda-plantilla.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){


      window.location = 'tienda-plantillas';

    }
  })

})

/*=====  End of SELECCIONAR PLANTILLA  ======*/