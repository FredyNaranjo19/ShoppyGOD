/*=======================================================================================
=                   MOSTRAR PRECIOS DE PAQUETES DE PRODUTOS EN TIENDA                   =
=======================================================================================*/

$(document).on("click", ".btnComprarEspaciosTV", function(){

  var datos = new FormData();
  datos.append("paqueteObtenido", "1");
  // alert("entro");

  $.ajax({
    url: "../items/mvc/ajax/dashboard/productos-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      if(respuesta != false){

        for (var i = 1; i <= respuesta["id_tv_productos_lista_compras"]; i++) {
          
          $("#trEspacio"+i).remove();
          
        }

        if(respuesta["id_tv_productos_lista_compras"] == 5){

          $(".tblComprasProductos tbody").append("<tr><td colspan='3'>Ya tienes el ultimo paquete</td></tr>");

        }

      }

    }
  })

})

/*============  End of MOSTRAR PRECIOS DE PAQUETES DE PRODUTOS EN TIENDA  =============*/

/*=====================================================================================
=            MOSTRAR MODAL AGREGAR INFORMACION PARA SUBIR A TIENDA VIRTUAL            =
=====================================================================================*/

$(document).on("click", ".btnAgregarProductoTienda", function(){

  /* Limpiar imagenes si no se agrega el producto
  -------------------------------------------------- */
  
  $("#nombreImagenProducto1").val("");
  $("#viewImagenProducto1").attr("src","../items/img/subirImagen.png");
  $("#txtCargaImagenProducto1").html("");
  
  $("#nombreImagenProducto2").val("");
  $("#viewImagenProducto1").attr("src","../items/img/subirImagen.png");
  $("#txtCargaImagenProducto1").html("");
  
  $("#nombreImagenProducto3").val("");
  $("#viewImagenProducto1").attr("src","../items/img/subirImagen.png");
  $("#txtCargaImagenProducto1").html("");

  
  /* Limpiar imagenes si no se agrega el producto
  -------------------------------------------------- */
  
	var idProducto = $(this).attr("idProducto");
  var sku = $(this).attr("sku");
  var codigo = $(this).attr("codigo");

	$("#modalAgregarInformacionProductoTienda").modal("show");

	$("#inputIdProductoPV").val(idProducto);
  $("#inputIdProductoPV").attr("sku", sku);
  $("#inputIdProductoPV").attr("codigo", codigo);

  $("#precioProductoTienda").val("");
  $("#precioPromoProductoTienda").val("");

  var datos = new FormData();
  datos.append("codigoProducto", codigo);

  $.ajax({
    url: "../items/mvc/ajax/dashboard/productos-tienda.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      if (respuesta.length > 0) {

        $(".divPrecioProducto").attr("existencia", "1");
        $(".divPrecioProducto").html("");

      } else {

        $(".divPrecioProducto").attr("existencia", "0");
        $(".divPrecioProducto").html('<hr>'+
            '<h4 class="card-text text-center">Precio del producto</h4>'+
            '<div class="row">'+
              '<div class="col-md-6 mb-3">'+
                '<h5 class="titprod"> Precio por pieza:</h5>'+
                '<div class="input-group">'+
                  '<input type="text" class="form-control" id="precioProductoTienda" required>'+
                '</div>'+
              '</div>'+

              '<div class="col-md-6 mb-3">'+
                '<h5 class="titprod"> Precio de Promoción:</h5>'+
                '<div class="input-group">'+
                  '<input type="text" class="form-control" id="precioPromoProductoTienda" required>'+
                '</div>'+
              '</div>'+
            '</div>');

      }

    }
  })

})
 
/*=====  End of MOSTRAR MODAL AGREGAR INFORMACION PARA SUBIR A TIENDA VIRTUAL  ======*/

/*==========================================================
=            MOSTRAR SUBCATEGORIAS DE CATEGORIA            =
==========================================================*/

$(document).on("change", "#ProductonCategoria", function(){

  var idCategoria = $(this).val();

  $("#ProductonSubcategoria").children().remove();

  var datos = new FormData();
  datos.append("idCategoria", idCategoria);
  var slec = "";

  $.ajax({
    url: "../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      $("#ProductonSubcategoria").append('<option value="">Seleccionar subcategoria</option>');

      for (var i = 0; i < respuesta.length; i++) {
        
        $("#ProductonSubcategoria").append('<option value="'+ respuesta[i]["id_subcategoria"] +'">'+ respuesta[i]["nombre"] +'</option>');

      }

    }
  })

})

/*=====  End of MOSTRAR SUBCATEGORIAS DE CATEGORIA  ======*/

/*===================================================
=            SUBIR IMAGEN 1 DEL PRODUCTO            =
===================================================*/

$(document).on("click", "#btnImagenProducto1New", function(e){

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
            document.getElementById('viewImagenProducto1').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            primeraFotoProducto(blob);
        });

    }
    input.click();

})


function primeraFotoProducto(blob){

    var sku = $("#inputIdProductoPV").attr("sku");

    var ImgName = "";

    ImgName = ImgName.concat(sku + "-Primera");

    var uploadTask = firebase.storage().ref('imagenes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaImagenProducto1').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('imagenesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nombreImagenProducto1").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaImagenProducto1').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of SUBIR IMAGEN 1 DEL PRODUCTO  ======*/

/*===================================================
=            SUBIR IMAGEN 2 DEL PRODUCTO            =
===================================================*/

$(document).on("click", "#btnImagenProducto2New", function(e){

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
            document.getElementById('viewImagenProducto2').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            segundaFotoProducto(blob);
        });

    }
    input.click();

})


function segundaFotoProducto(blob){

    var sku = $("#inputIdProductoPV").attr("sku");

    var ImgName = "";

    ImgName = ImgName.concat(sku + "-Segunda");

    var uploadTask = firebase.storage().ref('imagenes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaImagenProducto2').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('imagenesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nombreImagenProducto2").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaImagenProducto2').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of SUBIR IMAGEN 2 DEL PRODUCTO  ======*/

/*===================================================
=            SUBIR IMAGEN 3 DEL PRODUCTO            =
===================================================*/

$(document).on("click", "#btnImagenProducto3New", function(e){

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
            document.getElementById('viewImagenProducto3').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            terceraFotoProducto(blob);
        });

    }
    input.click();

})


function terceraFotoProducto(blob){

    var sku = $("#inputIdProductoPV").attr("sku");

    var ImgName = "";

    ImgName = ImgName.concat(sku + "-Tercera");

    var uploadTask = firebase.storage().ref('imagenes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaImagenProducto3').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('imagenesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nombreImagenProducto3").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaImagenProducto3').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of SUBIR IMAGEN 3 DEL PRODUCTO  ======*/



/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/


/*=========================================================================
=            MOSTRAR INFORMACION DE PRODUCTO EN TIENDA VIRTUAL            =
=========================================================================*/

$(document).on("click", ".btnProductoInfoTienda", function(){
  
  var idProductoTienda = $(this).attr("idProducto");
  var codigo = $(this).attr("codigo");
  var mostrarTable = "";

  $("#modalMostrarInformacionPreciosTienda").modal("show");

  var datos = new FormData();
  datos.append("idProductoTienda", idProductoTienda);

  $.ajax({
    url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      $("#idProductoTienda").val(respuesta["id_tv_productos"]);
      $("#idProductoTienda").attr("sku", respuesta["sku"]);

      $("#modeloProductoTienda").val(respuesta["codigo"]);
      $("#nombreProductoTienda").val(respuesta["nombre"]);

      $("#categoriaProductoTiendaSeleccion").val(respuesta["idCategoria"]);
      $("#categoriaProductoTiendaSeleccion").html(respuesta["nombreCategoria"]);

      $("#subcategoriaProductoTiendaSeleccion").val(respuesta["idSubcategoria"]);
      $("#subcategoriaProductoTiendaSeleccion").html(respuesta["nombreSubcategoria"]);

      /* IMAGENES  PRIMERA*/
      if (respuesta["imagen1"] == null || respuesta["imagen1"] == "") {

        $("#viewImagenInfoProducto1").attr("src", "../items/img/subirImagen.png");
        $("#nombreInfoImagenProducto1").val("");

      } else {

        $("#viewImagenInfoProducto1").attr("src", respuesta["imagen1"]);
        $("#nombreInfoImagenProducto1").val(respuesta["imagen1"]);

      }

      /* IMAGENES SEGUNDA */
      if (respuesta["imagen2"] == null || respuesta["imagen2"] == "") {

        $("#viewImagenInfoProducto2").attr("src", "../items/img/subirImagen.png");
        $("#nombreInfoImagenProducto2").val("");

      } else {

        $("#viewImagenInfoProducto2").attr("src", respuesta["imagen2"]);
        $("#nombreInfoImagenProducto2").val(respuesta["imagen2"]);

      }

      /* IMAGENES TERCERA */
      if (respuesta["imagen3"] == null || respuesta["imagen3"] == "") {

        $("#viewImagenInfoProducto3").attr("src", "../items/img/subirImagen.png");
        $("#nombreInfoImagenProducto3").val("");

      } else {

        $("#viewImagenInfoProducto3").attr("src", respuesta["imagen3"]);
        $("#nombreInfoImagenProducto3").val(respuesta["imagen3"]);

      }
    }
  })

  var datosListado = new FormData();
  datosListado.append("codigoProducto", codigo);

  $.ajax({
    url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
    method: "POST",
    data: datosListado,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      if (respuesta.length > 0) {

        for (var i = 0; i < respuesta.length; i++) {
          
          if (i == 0) {

            mostrarTable = mostrarTable.concat("<tr>"+
              "<td id='tdCantidad'>"+
                respuesta[i]['cantidad']+
              "</td>"+
              "<td id='tdPrecio'>"+
                "<input type='text' id='inputPrecioTienda' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
              "</td>"+
              "<td id='tdPromo'>"+
                "<input type='text' id='inputPrecioPromoTienda' precioPromoListado='"+respuesta[i]['promo']+"' value='"+respuesta[i]['promo']+"' style='width: 100%;'>"+
              "</td>");

            if (respuesta[i]['activadoPromo'] == "si") {

              mostrarTable = mostrarTable.concat("<td id='tdPromoCheck'>"+
                            "<input type='checkbox' id='checkPromoTienda' checked>"+
                          "</td>");

            }else{
          
              mostrarTable = mostrarTable.concat("<td id='tdPromoCheck'>"+
                            "<input type='checkbox' id='checkPromoTienda'>"+
                          "</td>");

            } 

            mostrarTable = mostrarTable.concat("<td>"+
                "<div class='input-group-prepend'>"+
                              "<button type='button' class='btn btn-warning btnGuardarCambioListadoTienda' idListado='"+respuesta[i]['id_tv_productos_listado']+"' modelo='"+respuesta[i]['codigo']+"' can='"+respuesta[i]['cantidad']+"'>"+
                                "<i class='far fa-save'></i>"+
                              "</button>"+
                            "</div>"+
              "</td>"+
            "</tr>");

          } else {

            mostrarTable = mostrarTable.concat("<tr>"+
                "<td id='tdCantidad'>"+
                  respuesta[i]['cantidad']+
                "</td>"+
                "<td id='tdPrecio'>"+
                  "<input type='text' id='inputPrecioTienda' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
                "</td>"+
                "<td id='tdPromo'></td>"+
                "<td id='tdPromoCheck'></td>"+
                
                "<td>"+
                  "<div class='input-group-prepend'>"+
                    "<button type='button' class='btn btn-warning btnGuardarCambioListadoTienda' idListado='"+respuesta[i]['id_tv_productos_listado']+"'>"+
                      "<i class='far fa-save'></i>"+
                    "</button>"+

                    "<button type='button' class='btn btn-danger btnEliminarListadoTienda' idListado='"+respuesta[i]['id_tv_productos_listado']+"' modelo='"+respuesta[i]['codigo']+"'>"+
                      "<i class='fa fa-times'></i>"+
                    "</button>"+

                  "</div>"+
                "</td>"+
              "</tr>");
          }

        }

      } else {

        mostrarTable = mostrarTable.concat("<tr>"+
                "<td colspan='5'>"+
                  "No tienes stock registrado en este almacén para ver el listado de precios del producto."+
                "</td>"+
              "</tr>");

      }

      $("#bodyListadoPreciosTienda").html(mostrarTable);
      $(".btnNuevoPrecioTienda").attr("codigo", codigo);

    }
  })

})

/*=====  End of MOSTRAR INFORMACION DE PRODUCTO EN TIENDA VIRTUAL  ======*/

/*====================================================================
=            GUARDAR MODIFICACION DE LISTADO DEL PRODUCTO            =
====================================================================*/

$(document).on("click", ".btnGuardarCambioListadoTienda", function(){

    var idListado = $(this).attr("idListado");
    var precio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecioTienda").val();
    var promo = $(this).parent().parent().parent().children("#tdPromo").children("#inputPrecioPromoTienda").val();

    var activadoPromo = "no";

    if ($(this).parent().parent().parent().children("#tdPromoCheck").children('#checkPromoTienda').is(':checked')) {

      activadoPromo = 'si';

    }

    var datos = new FormData();
    datos.append("idEditarListadoTienda", idListado);
    datos.append("precioEditarListadoTienda", precio);
    datos.append("promoEditarListadoTienda", promo);
    datos.append("activarEditarListadoTienda", activadoPromo);

    $.ajax({
      url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){

        toastr.success('Se han guardado los datos correctamente!');

      }
    })

  })

/*=====  End of GUARDAR MODIFICACION DE LISTADO DEL PRODUCTO  ======*/

/*=======================================================================
=            MOSTRAR FORMULARIO DE AGREGAR LISTADO DE PRECIO            =
=======================================================================*/

$(document).on("click", ".btnListadoAgregarTienda", function(){

  $("#formPrecioTienda").show("slow");

})

/*=====  End of MOSTRAR FORMULARIO DE AGREGAR LISTADO DE PRECIO  ======*/

/*======================================================================
=            CREAR NUEVO PRECIO LISTADO DEL PRODUCTO TIENDA            =
======================================================================*/

$(document).on("submit", "#formPrecioTienda", function(e){
  e.preventDefault();

  var codigo = $(".btnNuevoPrecioTienda").attr("codigo"); 
  var piezas = $("#piezasListadoTienda").val();
  var costo = $("#costoListadoTienda").val();
  var mostrarTable = "";

  var datos = new FormData();
  datos.append("codigoCrearListadoTienda", codigo);
  datos.append("piezasCrearListadoTienda", piezas);
  datos.append("costoCrearListadoTienda", costo);

  $.ajax({
    url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      toastr.success('Se han guardado los datos correctamente!');

      if (respuesta.length > 0) {

        for (var i = 0; i < respuesta.length; i++) {
          
          if (i == 0) {

            mostrarTable = mostrarTable.concat("<tr>"+
              "<td id='tdCantidad'>"+
                respuesta[i]['cantidad']+
              "</td>"+
              "<td id='tdPrecio'>"+
                "<input type='text' id='inputPrecioTienda' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
              "</td>"+
              "<td id='tdPromo'>"+
                "<input type='text' id='inputPrecioPromoTienda' precioPromoListado='"+respuesta[i]['promo']+"' value='"+respuesta[i]['promo']+"' style='width: 100%;'>"+
              "</td>");

            if (respuesta[i]['activadoPromo'] == "si") {

              mostrarTable = mostrarTable.concat("<td id='tdPromoCheck'>"+
                            "<input type='checkbox' id='checkPromoTienda' checked>"+
                          "</td>");

            }else{
          
              mostrarTable = mostrarTable.concat("<td id='tdPromoCheck'>"+
                            "<input type='checkbox' id='checkPromoTienda'>"+
                          "</td>");

            } 

            mostrarTable = mostrarTable.concat("<td>"+
                "<div class='input-group-prepend'>"+
                              "<button type='button' class='btn btn-warning btnGuardarCambioListadoTienda' idListado='"+respuesta[i]['id_tv_productos_listado']+"' modelo='"+respuesta[i]['codigo']+"' can='"+respuesta[i]['cantidad']+"'>"+
                                "<i class='far fa-save'></i>"+
                              "</button>"+
                            "</div>"+
              "</td>"+
            "</tr>");

          } else {

            mostrarTable = mostrarTable.concat("<tr>"+
                "<td id='tdCantidad'>"+
                  respuesta[i]['cantidad']+
                "</td>"+
                "<td id='tdPrecio'>"+
                  "<input type='text' id='inputPrecioTienda' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
                "</td>"+
                "<td id='tdPromo'></td>"+
                "<td id='tdPromoCheck'></td>"+
                
                "<td>"+
                  "<div class='input-group-prepend'>"+
                    "<button type='button' class='btn btn-warning btnGuardarCambioListadoTienda' idListado='"+respuesta[i]['id_tv_productos_listado']+"'>"+
                      "<i class='far fa-save'></i>"+
                    "</button>"+

                    "<button type='button' class='btn btn-danger btnEliminarListadoTienda' idListado='"+respuesta[i]['id_tv_productos_listado']+"' modelo='"+respuesta[i]['codigo']+"'>"+
                      "<i class='fa fa-times'></i>"+
                    "</button>"+

                  "</div>"+
                "</td>"+
              "</tr>");
          }

        }

      } else {

        mostrarTable = mostrarTable.concat("<tr>"+
                "<td colspan='5'>"+
                  "No tienes stock registrado en este almacén para ver el listado de precios del producto."+
                "</td>"+
              "</tr>");

      }

      $("#bodyListadoPreciosTienda").html(mostrarTable);
      $("#formPrecioTienda").hide("slow");
      $("#formPrecioTienda").trigger("reset");
    }
  })

})

/*=====  End of CREAR NUEVO PRECIO LISTADO DEL PRODUCTO TIENDA  ======*/

/*===========================================================
=            ELIMINAR PRECIO DEL PRODUCTO TIENDA            =
===========================================================*/

$(document).on("click", ".btnEliminarListadoTienda", function(){

  var idListado = $(this).attr("idListado");
  var modelo = $(this).attr("modelo");
  var trTabla = $(this).parent().parent().parent();

  Swal.fire({
    title: 'Estás de eliminar el precio del producto?',
    text: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {

      var datos = new FormData();
      datos.append("idListadoEliminar", idListado);
      datos.append("codigoListadoEliminar", modelo);

      $.ajax({
        url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

          if (respuesta == 'ok') {

            $(trTabla).remove();
            toastr.success('Se eliminado exitosamente!');

          }
          
        }
      })

    }
  })


})

/*=====  End of ELIMINAR PRECIO DEL PRODUCTO TIENDA  ======*/


/*============================================================
=            SUBIR IMAGEN 1 DEL PRODUCTO EN TIENDA           =
============================================================*/

$(document).on("click", "#btnImagenInfoProducto1New", function(e){

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
            document.getElementById('viewImagenInfoProducto1').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            primeraFotoProductoTienda(blob);
        });

    }
    input.click();

})


function primeraFotoProductoTienda(blob){

    var sku = $("#idProductoTienda").attr("sku");

    var ImgName = "";

    ImgName = ImgName.concat(sku + "-Primera");

    var uploadTask = firebase.storage().ref('imagenes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaInfoImagenProducto1').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('imagenesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nombreInfoImagenProducto1").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaInfoImagenProducto1').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of SUBIR IMAGEN 1 DEL PRODUCTO EN TIENDA  ======*/

/*============================================================
=            SUBIR IMAGEN 2 DEL PRODUCTO EN TIENDA           =
============================================================*/

$(document).on("click", "#btnImagenInfoProducto2New", function(e){

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
            document.getElementById('viewImagenInfoProducto2').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            segundaFotoProductoTienda(blob);
        });

    }
    input.click();

})


function segundaFotoProductoTienda(blob){

    var sku = $("#idProductoTienda").attr("sku");

    var ImgName = "";

    ImgName = ImgName.concat(sku + "-Segunda");

    var uploadTask = firebase.storage().ref('imagenes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaInfoImagenProducto2').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('imagenesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nombreInfoImagenProducto2").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaInfoImagenProducto2').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of SUBIR IMAGEN 2 DEL PRODUCTO EN TIENDA  ======*/

/*============================================================
=            SUBIR IMAGEN 3 DEL PRODUCTO EN TIENDA           =
============================================================*/

$(document).on("click", "#btnImagenInfoProducto3New", function(e){

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
            document.getElementById('viewImagenInfoProducto3').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            terceraFotoProductoTienda(blob);
        });

    }
    input.click();

})


function terceraFotoProductoTienda(blob){

    var sku = $("#idProductoTienda").attr("sku");

    var ImgName = "";

    ImgName = ImgName.concat(sku + "-Tercera");

    var uploadTask = firebase.storage().ref('imagenes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaInfoImagenProducto3').innerHTML = 'Subiendo: ' + progress + '%';
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('imagenesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nombreInfoImagenProducto3").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaInfoImagenProducto3').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of SUBIR IMAGEN 3 DEL PRODUCTO EN TIENDA  ======*/

/*===========================================================
=            GUARDAR CAMBIOS DEL PRODUCTO TIENDA            =
===========================================================*/

$(document).on("submit", "#formEditarProductoTienda", function(e){
  e.preventDefault();

  var idPorducto = $("#idProductoTienda").val();
  var categoria = $("#categoriaProductoTienda").val();
  var subcategoria = $("#subcategoriaProductoTienda").val();
  var imagen1 = $("#nombreInfoImagenProducto1").val();
  var imagen2= $("#nombreInfoImagenProducto2").val();
  var imagen3 = $("#nombreInfoImagenProducto3").val();

  var datos = new FormData();
  datos.append("idProductoModificacionProducto", idPorducto);
  datos.append("categoriaModificacionProducto", categoria);
  datos.append("subcategoriaModificacionProducto", subcategoria);
  datos.append("imagen1ModificacionProducto", imagen1);
  datos.append("imagen2ModificacionProducto", imagen2);
  datos.append("imagen3ModificacionProducto", imagen3); 

  $.ajax({
    url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      if (respuesta == 'ok') {
        toastr.success("Producto modificado correctamente!");
        $("#txtCargaInfoImagenProducto1").html("");
        $("#txtCargaInfoImagenProducto2").html("");
        $("#txtCargaInfoImagenProducto3").html("");

      }
      

    }
  })

})

/*=====  End of GUARDAR CAMBIOS DEL PRODUCTO TIENDA  ======*/

/*==========================================================
=            MOSTRAR SUBCATEGORIAS DE CATEGORIA  config    =
==========================================================*/

$(document).on("change", "#categoriaProductoTienda", function(){

  var idCategoria = $(this).val();

  $("#subcategoriaProductoTienda").children().remove();

  var datos = new FormData();
  datos.append("idCategoria", idCategoria);
  var slec = "";

  $.ajax({
    url: "../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php", 
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      $("#subcategoriaProductoTienda").append('<option value="">Seleccionar subcategoria</option>');

      for (var i = 0; i < respuesta.length; i++) {
        
        $("#subcategoriaProductoTienda").append('<option value="'+ respuesta[i]["id_subcategoria"] +'">'+ respuesta[i]["nombre"] +'</option>');

      }

    }
  })

})

/*=====  End of MOSTRAR SUBCATEGORIAS DE CATEGORIA  ======*/

/*==============================================================
=                   DIBUJAR TABLA DATA TABLE                   =
==============================================================*/

window.addEventListener('DOMContentLoaded', function(ev) {
  let opcion = 1;
    tablaProductosEnTV = $('#tablaProductosEnTV').DataTable({  
      
      "destroy": true,
      "responsive": true,
      "language":{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ ",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "No hay productos en tu tienda",
        "sInfo":           "Viendo del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty":      "Viendo del 0 al 0 de un total de 0",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ )",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "ajax":{            
        "url": "../items/mvc/ajax/dashboard/productos-tienda.ajax.php", 
        "method": 'POST',
        "data":{opcion:opcion},
        "dataSrc":""
      },
      "columns":[
        {
          sortable:false,
          render: function(data,type,full,meta){
            let idProducto = full.id_producto;
            let codigo = full.codigo;
            let idTvProducto = full.id_producto_tienda;
            let img1 = full.img1;
            let img2 = full.img2;
            let img3 = full.img3;
            let sku = full.sku;
  
            
            return '<div class="btn-group">'+
                      '<button class="btn btn-primary btnProductoInfoTienda" idProducto="'+idTvProducto+'" codigo="'+codigo+'"><i class="fa fa-eye"></i></button>'+
                      '<button class="btn btn-danger btnEliminarProductoTienda" codigo="'+codigo+'" id_producto="'+idProducto+'" id_producto_tv="'+idTvProducto+'" img1="'+img1+'" img2="'+img2+'" img3="'+img3+'" sku="'+sku+'"><i class="fa fa-times"></i></button>'+
                    '</div>';
          }
        },
        {"data": "codigo"},
        {"data":"nombre"},
        {"data": "descripcion"},
        {"data": "stock_disponible",
            sortable: false,
          render: function(data){
            if (data == "0") {
              return "Agotado";
            }else{
              return data;
            }
          }
        }
        
        
        
      ]
  
    });
})

/*============  End of DIBUJAR TABLA DATA TABLE  =============*/



/*========================================================
=            CREAR PRODUCTO EN TIENDA VIRTUAL            =
========================================================*/

$(document).on("submit", "#formCrearProductoTienda", function(e){
  e.preventDefault();
  var contenidoEmpresa = $(".contentEmpresaProd").val();

  var idProducto = $("#inputIdProductoPV").val();
  var categoria = $("#ProductonCategoria").val();
  var subcategoria = $("#ProductonSubcategoria").val();
  var imagen1 = $("#nombreImagenProducto1").val();
  var imagen2 = $("#nombreImagenProducto2").val();
  var imagen3 = $("#nombreImagenProducto3").val();
  var codigo = $("#inputIdProductoPV").attr("codigo");

  var existencia = $(".divPrecioProducto").attr("existencia");
  var precio = 0;
  var promo = 0;

  if (parseInt(existencia) == 0) {

    var precio = $("#precioProductoTienda").val();
    var promo = $("#precioPromoProductoTienda").val();

  } 


  var datos = new FormData();
  datos.append("idCrearProductoTV", idProducto);
  datos.append("categoriaCrearProductoTV", categoria);
  datos.append("subcategoriaCrearProductoTV", subcategoria);
  datos.append("imagen1CrearProductoTV", imagen1);
  datos.append("imagen2CrearProductoTV", imagen2);
  datos.append("imagen3CrearProductoTV", imagen3);
  datos.append("codigoCrearProductoTV", codigo);
  datos.append("precioCrearProductoTV", precio);
  datos.append("promoCrearProductoTV", promo);

  $.ajax({
    url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      tablaProductosEnTV.ajax.reload();

      $("#trProductos"+idProducto)
          .children(".tdButtonAgregarProducto")
          .html('<i class="far fa-check-circle"></i>');
        
      let espaciosDisp = respuesta.length;
      let espaciosActuales = parseInt(contenidoEmpresa) - espaciosDisp;

      console.log(espaciosActuales)
     
      if (espaciosActuales <= 0) {

        $("button.recuperarBtnProducto").removeClass("btnAgregarProductoTienda btn-secondary");
        $("button.recuperarBtnProducto").addClass("btn-default");

        Swal.fire({
          icon: 'success',
          title: 'Espacios ocupados',
          text: 'has ocupado todo stus espacios disponibles en tienda virtual'
        })

        setTimeout(function(){
          window.location = 'tienda-productos';
        },2000)
        
        
      }
      // if(respuesta.length >= parseFloat(contenidoEmpresa)){


      // }

      $("#txtCargaImagenProducto1").html("");
      $("#txtCargaImagenProducto2").html("");
      $("#txtCargaImagenProducto3").html("");
      $("#viewImagenProducto1").attr("src","../items/img/subirImagen.png");
      $("#viewImagenProducto2").attr("src","../items/img/subirImagen.png");
      $("#viewImagenProducto3").attr("src","../items/img/subirImagen.png");
      $("#formCrearProductoTienda").trigger("reset");
      $("#modalAgregarInformacionProductoTienda").modal("hide");

      /* ACTUALIZAR TEXTO ESPACIOS DISPONIBLES
      -------------------------------------------------- */
      
      $("#bProductosDisponiblesTV").html(espaciosActuales);

      

    }
  })
})

/*=====  End of CREAR PRODUCTO EN TIENDA VIRTUAL  ======*/


/*===========================================================
=            ELIMINAR PRODUCTO EN TIENDA VIRTUAL            =
===========================================================*/

$(document).on("click", ".btnEliminarProductoTienda", function(){

  let idProductoTV = $(this).attr("id_producto_tv");
  let idProducto = $(this).attr("id_producto");
  let sku = $(this).attr("sku");
  let codigo = $(this).attr("codigo");
  let img1 =  $(this).attr("img1")
  let img2 =  $(this).attr("img2")
  let img3 =  $(this).attr("img3")

  Swal.fire({
    title: 'Estás seguro de eliminar el producto de tienda?',
    text: "",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {
      
      if (img1 !== "") {
        EliminarImagen(img1);
      }
      if (img2!== "") {
        EliminarImagen(img2);
      }
      if (img3 !== "") {
        EliminarImagen(img3);
      }
      
        
      var datos = new FormData();
      datos.append("idEliminarProductoTV", idProductoTV);
    
      $.ajax({
        url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){
          if(respuesta == "ok"){

            tablaProductosEnTV.ajax.reload();

            $("#trProductos"+idProducto)
              .children(".tdButtonAgregarProducto")
              .html('<button class="btn btn-secondary btnAgregarProductoTienda recuperarBtnProducto"'+
                      'idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'">'+
                        '<i class="fas fa-share-square"></i>'+
                    '</button>');
    
            
    
            if($(".recuperarBtnProducto").hasClass("btn-default")){
    
              $("button.recuperarBtnProducto").removeClass("btn-default");
              $("button.recuperarBtnProducto").addClass("btnAgregarProductoTienda btn-secondary");
    
            }

            /* ACTUALIZAR TEXTO ESPACIOS DISPONIBLES
            -------------------------------------------------- */
            let productosEnTV = $("#bProductosDisponiblesTV").html();
            let espaciosActuales = parseInt(productosEnTV) + 1;
             
            $("#bProductosDisponiblesTV").html(espaciosActuales);


          }
        }
      })

      function EliminarImagen(img){
        //metodo para eliminar por URL del archivo
        var imagen = firebase.storage().refFromURL(img);

        // Delete the file
        imagen.delete().then(function() {
        // File deleted successfully
            console.log("ok")
            
        }).catch(function(error) {
            console.log("error")
        });
      }

    }
  })

  
  
})

/*=====  End of ELIMINAR PRODUCTO EN TIENDA VIRTUAL  ======*/