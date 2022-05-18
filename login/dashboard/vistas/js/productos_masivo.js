var noCaracteristicaPrecarga = 0;

/*==================================================================
=            CARGAR ARCHIVO Y MOSTRAR DATOS EN PRECARGA            =
==================================================================*/

$(document).on("submit", "#filesForm", function(e){
    e.preventDefault();

    var excel = $("#fileContacts").val();
    if (excel === "") {
        return Swal.fire("Mensaje de advertencia", "Seleccionar un archivo excel", "warning");
    }

    $("#tbodyPrecarga").html("");

    var Form = new FormData($('#filesForm')[0]);
    var tabla = "";
    $.ajax({
        url: "../items/mvc/ajax/dashboard/importar_excel_ajax.php",
        type: "POST",
        data : Form,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data){

            Swal.fire("Carga exitosa","","success");
           

            for (var i = 0; i < data.length; i++) {

                $("#tbodyPrecarga").append("<tr class='trProductoPrecarga' idproducto='"+data[i]["id_precarga"]+"'>"+
                                                "<th class='sticky'>"+
                                                    "<div class='input-group mb-3'>"+
                                                        "<div class='input-group-prepend'>"+
                                                            "<div class='input-group-text'>"+
                                                                "<input type='checkbox' name='productoPrecargado[]' value='"+data[i]["id_precarga"]+"'>"+
                                                            "</div>"+
                                                        "</div>"+
                                                        "<div class='input-group-prepend'>"+
                                                            "<button class='btn btn-danger btn-sm btnEliminarProductoPrecargado' idProducto='"+data[i]["id_precarga"]+"'>"+
                                                                "<i class='fa fa-times'></i>"+
                                                            "</button>"+
                                                        "</div>"+
                                                        "<div class='input-group-prepend'>"+
                                                            "<button class='btn btn-success btn-sm btnSubirProductoPrecargado' idProducto='"+data[i]["id_precarga"]+"'>"+
                                                                "<i class='fa fa-sync'></i> Subir Producto"+
                                                            "</button>"+
                                                        "</div>"+
                                                    "</div>"+
                                                "</th>"+
                                                "<td>"+data[i]["codigo"]+"</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputTablePrecarga inputPrecarga' campo='nombre' value='"+data[i]["nombre"]+"'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<textarea type='text' class='form-control inputTablePrecarga inputPrecarga' campo='descripcion'>"+data[i]["descripcion"]+"</textarea>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='number' class='form-control inputPrecarga' campo='stock' value='"+data[i]["stock"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='costo' value='"+data[i]["costo"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga inputTablePrecarga' campo='folio' value='"+data[i]["folio"]+"'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga inputTablePrecarga' campo='proveedor' value='"+data[i]["proveedor"]+"'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='precio' value='"+data[i]["precio"]+"' style='width: 75px;'> "+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='promo' value='"+data[i]["promo"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='largo' value='"+data[i]["largo"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='ancho' value='"+data[i]["ancho"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='alto' value='"+data[i]["alto"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td>"+
                                                    "<input type='text' class='form-control inputPrecarga' campo='peso' value='"+data[i]["peso"]+"' style='width: 75px;'>"+
                                                "</td>"+
                                                "<td></td>"+
                                                "<td></td>"+
                                            "</tr>");

            } 
            
            $("#fileContacts").val("");

        }
    });

})

/*=====  End of CARGAR ARCHIVO Y MOSTRAR DATOS EN PRECARGA  ======*/

/*=============================================================================================================
=            ----------------------------- GUARDAR CAMBIOS DE LA TABLA ---------------------------            =
=============================================================================================================*/

    /*================================================
    =            CAMBIO DE VALOR EN INPUT            =
    ================================================*/
    
    $(document).on("change", ".inputPrecarga", function(){

        var idProducto = $(this).parent().parent(".trProductoPrecarga").attr("idproducto");
        var campo = $(this).attr("campo");
        var valorInput = $(this).val();

        var datos = new FormData();
        datos.append("inputValorCambio", valorInput);
        datos.append("inputCampoCambio", campo);
        datos.append("inputIdCambio", idProducto);
 
        $.ajax({
            url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){


            }

        })
    })
    
    /*=====  End of CAMBIO DE VALOR EN INPUT  ======*/

/*=======================================================
=            SELECCIONAR TODOS LOS PRODUCTOS            =
=======================================================*/

$(document).on("click", ".btnSeleccionarTodosProductos", function(){

    $("#tbodyPrecarga input[type=checkbox]").prop("checked", true);

})

/*=====  End of SELECCIONAR TODOS LOS PRODUCTOS  ======*/

/*=============================================================================================================================
=            -------------------------------- GUARDAR CARACTERISTICAS DE PRODUCTO --------------------------------            =
=============================================================================================================================*/

    /*================================================================================================
    =            MOSTRAR MODAL DE AGREGAR CARACTERISTICAS TENDRAN PRODUCTOS SELECCIONADOS            =
    ================================================================================================*/
    
    $(document).on("click", ".btnCaracteristicasPrecargados", function(){

        var productosSeleccionados = $('[name="productoPrecargado[]"]:checked').map(function(){
                                            return this.value;
                                        }).get();
        var carct = "";

        if (parseInt(productosSeleccionados.length) > 0) {

            $.ajax({
                url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
                cache: false, 
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta) {
                    
                    for (var i = 0; i < respuesta.length; i++) {

                        carct = carct.concat('<div class="col-md-3">'+
                                                '<input type="checkbox" name="caracteristicasSeleccionadas[]" value="'+respuesta[i]['id_panel_caracteristicas_dashboard']+'"> '+respuesta[i]['caracteristica']+
                                            '</div>');
                        

                    }

                    $(".returnCarcteristicasDiv").html(carct);
                    $("#inputSeleccionadosPrecargaCaracteristicas").val(productosSeleccionados);
                    $("#modalCaracteristicasPrecargo").modal("show");
                }
            });
            

        } else {

            Swal.fire("No se puede realizar esta acción", "Debes seleccionar algun producto.", "error");

        }

    })
    
    /*=====  End of MOSTRAR MODAL DE AGREGAR CARACTERISTICAS TENDRAN PRODUCTOS SELECCIONADOS  ======*/

    /*===========================================================================
    =            CREAR CARACTERISTICAS A LOS PRODUCTOS SELECCIONADOS            =
    ===========================================================================*/
    
    $(document).on("submit", "#formCaracteristicaPrecargado", function(e){
        e.preventDefault();

        var caracteristicasSeleccionados = $('[name="caracteristicasSeleccionadas[]"]:checked').map(function(){
                                            return this.value;
                                        }).get();

        if (parseInt(caracteristicasSeleccionados.length) > 0) {

            /*IDS DE LAS CARACTERISTICAS*/
            var arrayCaracteristicas = [];

            for (var i = 0; i < caracteristicasSeleccionados.length; i++) {
                        
                arrayCaracteristicas.push({"id_carcateristica" : caracteristicasSeleccionados[i]});

            }

            /* IDS DE LOS PRODUCTOS*/
            var arrayIds = [];

            var ids = $("#inputSeleccionadosPrecargaCaracteristicas").val();

            ids = ids.split(",");

            for (var i = 0; i < ids.length; i++) {
                                
                arrayIds.push({"id" : ids[i]});

            }


            /*CREAR VARIABLE DATOS PARA MANDAR A AJAX*/

            var datos = new FormData();
            datos.append("idsProductosCarac", JSON.stringify(arrayIds));
            datos.append("idsCaracteristicas", JSON.stringify(arrayCaracteristicas));

            $.ajax({
                url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    window.location = "productos-masivo";

                }
            })


        } else {

            Swal.fire("No se puede realizar esta acción", "Aún no haz seleccionado alguna caracteristica.", "error");

        }
    })
    
    /*=====  End of CREAR CARACTERISTICAS A LOS PRODUCTOS SELECCIONADOS  ======*/

    /*===========================================================
    =            EDITAR CARACTERISTICAS Y DEFINIRLAS            =
    ===========================================================*/
    
    $(document).on("click", ".btnDefinirCaracteristicasPrecarga", function(){
        noCaracteristicaPrecarga = 0;
        var idProducto = $(this).attr("idProducto");

        var datos = new FormData();
        datos.append("idProductoCaracteristicas", idProducto);

        $.ajax({
            url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $("#modalCaracteristicasDefinir").modal("show");
                for (var i = 0; i < respuesta.length; i++) {
                    noCaracteristicaPrecarga++;

                    $(".divCarcteristicasPrecarga").append('<div class="row" style="margin-bottom: 5px;">'+
                                '<div class="col-xs-12 col-lg-6">'+
                                    '<div class="input-group">'+
                                      '<select class="form-control selectCaracteristica input-lg" id="selectCaracteristica'+noCaracteristicaPrecarga+'" required>'+
                                        '<option value="'+respuesta[i]["caracteristica"]+'" selected>'+respuesta[i]["caracteristica"]+'</option>'+
                                        '<option disabled>Selecciona la Carateristica</option>'+
                                      '</select>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xs-12 col-lg-6 divDato">'+
                                     '<input type="'+respuesta[i]["tipoCaracteristica"]+'" class="form-control inputCaracteristica input-lg" value="'+respuesta[i]["datoCaracteristica"]+'"/ required>'+
                                '</div>'+
                            '</div>');

                }
                $(".inputIdPrecargaCarac").val(idProducto);

                funcionForEachCaracteristicas();

            }
        })

    })
    
    /*=====  End of EDITAR CARACTERISTICAS Y DEFINIRLAS  ======*/

    /*==============================================
    =            AGREGAR CARACTERISTICA            =
    ==============================================*/
    
    $(document).on("click", ".btnNewCaracteristica", function(){

        noCaracteristicaPrecarga++;

        $(".divCarcteristicasPrecarga").append(
            '<div class="row" style="margin-bottom: 5px;">'+
                '<div class="col-xs-12 col-lg-6">'+
                    '<div class="input-group">'+
                      '<select class="form-control selectCaracteristica input-lg" id="selectCaracteristica'+noCaracteristicaPrecarga+'" required>'+
                        '<option disabled selected>Selecciona la Carateristica</option>'+
                      '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-xs-12 col-lg-6 divDato">'+
                    '<input type="text" class="form-control inputCaracteristica input-lg"/ required>'+
                '</div>'+
            '</div>');

        funcionForEachCaracteristicasBoton();
    })
    
    /*=====  End of AGREGAR CARACTERISTICA  ======*/

    /*========================================================
    =            FUNCTION AGREGAR NOTAS DE SELECT            =
    ========================================================*/
    
    function funcionForEachCaracteristicas(){    

        var seleccion = $(".selectCaracteristica");
        var carcteriscasSeleccionadas = []

        for (var i = 0; i < seleccion.length; i++) {
            
           carcteriscasSeleccionadas.push({
                                "caracteristica" : $(seleccion[i]).val()
                                });

        }

        var datos = new FormData();
        datos.append("seleccionadasCarac", JSON.stringify(carcteriscasSeleccionadas));


        $.ajax({
            url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {

                for (var j = 1; j <= seleccion.length; j++) {

                    var caracteristica = "";

                    for (var i = 0; i < respuesta.length; i++) {

                        caracteristica = caracteristica.concat('<option value="'+respuesta[i]["caracteristica"]+'">'+respuesta[i]["caracteristica"]+'</option>');   

                    }

                    $("#selectCaracteristica"+j).append(caracteristica);

                }  

            }
        })
    }
    
    /*=====  End of FUNCTION AGREGAR NOTAS DE SELECT  ======*/

    /*==========================================================================
    =            FUNCTION AGREGAR NOTAS A SELECT AGREGADO POR BOTON            =
    ==========================================================================*/
    
    function funcionForEachCaracteristicasBoton(){    


        var seleccion = $(".selectCaracteristica");
        var carcteriscasSeleccionadas = []

        for (var i = 0; i < seleccion.length; i++) {
            
           carcteriscasSeleccionadas.push({
                                "caracteristica" : $(seleccion[i]).val()
                                });

        }

        var datos = new FormData();
        datos.append("seleccionadasCarac", JSON.stringify(carcteriscasSeleccionadas));

        $.ajax({
            url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {

                var caracteristica = "";

                for (var i = 0; i < respuesta.length; i++) {

                    caracteristica = caracteristica.concat('<option value="'+respuesta[i]["caracteristica"]+'">'+respuesta[i]["caracteristica"]+'</option>');   

                }

                $("#selectCaracteristica"+noCaracteristicaPrecarga).append(caracteristica); 

            }
        })
    }
    
    /*=====  End of FUNCTION AGREGAR NOTAS A SELECT AGREGADO POR BOTON  ======*/

    /*==================================================
    =            CAMBIO DE VALOR DEL SELECT            =
    ==================================================*/
    
    $(document).on("change", "select.selectCaracteristica", function(){
        
        var inpDato = $(this).parent().parent().parent().children(".divDato").children(".inputCaracteristica");
        var inputSelect = $(this).val();

        var datos = new FormData();
        datos.append("inputSeleccion", inputSelect);

        $.ajax({
            url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                        
                $(inpDato).attr("type", respuesta["tipo_input"]);
                $(inpDato).val(null);
                $(inpDato).attr("placeholder", respuesta["placeholder_input"]);
                
            }
        });

    })
    
    /*=====  End of CAMBIO DE VALOR DEL SELECT  ======*/

    /*===========================================================
    =            GUARDAR CARACTERISTICAS AL PRODUCTO            =
    ===========================================================*/
    
    $(document).on("submit", "#formModificacionCaracteristicas", function(e){
        e.preventDefault();

        var idPrecarga = $(".inputIdPrecargaCarac").val();
        var campo = "caracteristicas";
        var caracteristicas = [];


        var carac = $(".selectCaracteristica");
        var valorCarac = $(".inputCaracteristica");

        for (var i = 0; i < carac.length; i++) {
            
            caracteristicas.push({
                                  "caracteristica" : $(carac[i]).val(),
                                  "datoCaracteristica" : $(valorCarac[i]).val(),
                                  "tipoCaracteristica" : $(valorCarac[i]).attr("type")
                            });

        }

        var datos = new FormData();
        datos.append("inputValorCambio", JSON.stringify(caracteristicas));
        datos.append("inputCampoCambio", campo);
        datos.append("inputIdCambio", idPrecarga);

        $.ajax({
            url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                window.location = 'productos-masivo';

            }

        })

    })
    
    /*=====  End of GUARDAR CARACTERISTICAS AL PRODUCTO  ======*/
    

/*=====  End of -------------------------------- GUARDAR CARACTERISTICAS DE PRODUCTO --------------------------------  ======*/


/*===============================================================================================================================
=            -------------------------------- SECCION ELIMINACION PRODUCTO PRECARGA --------------------------------            =
===============================================================================================================================*/

    /*====================================================
    =            ELIMINAR PRODUCTO PRECARGADO            =
    ====================================================*/

    $(document).on("click", ".btnEliminarProductoPrecargado", function(){

        var Producto = $(this).parent().parent().parent().parent();

        Swal.fire({
          title: 'Estás seguro de eliminar el producto?',
          showDenyButton: true,
          confirmButtonText: `Sí, eliminar!`,
          denyButtonText: `Cancelar`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

            var idProducto = $(this).attr("idProducto");

            var datos = new FormData();
            datos.append("idEliminar", idProducto);

            $.ajax({

                url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    Swal.fire("Producto eliminado exitosamente!", "", "success");
                    $(Producto).remove();

                }

            })

          } 

        })
    })

    /*=====  End of ELIMINAR PRODUCTO PRECARGADO  ======*/

    /*=======================================================
    =            ELIMINAR PRODUCTOS SELECCIONADOS           =
    =======================================================*/

    $(document).on("click", ".btnEliminarProductosPrecargados", function(){

        var arrayIds = [];
        var trPrecargados = $(".trProductoPrecarga");
        var productosSeleccionados = $('[name="productoPrecargado[]"]:checked').map(function(){
                                          return this.value;
                                        }).get();

        if (parseInt(productosSeleccionados.length) > 0) {

            Swal.fire({
              title: 'Estás seguro de eliminar los productos?',
              showDenyButton: true,
              confirmButtonText: `Sí, eliminar!`,
              denyButtonText: `Cancelar`,
            }).then((result) => {

                if (result.isConfirmed) {

                    for (var i = 0; i < productosSeleccionados.length; i++) {
                                
                        arrayIds.push({"id" : productosSeleccionados[i]});

                    }

                    var datos = new FormData();
                    datos.append("productosEliminar", JSON.stringify(arrayIds));


                    $.ajax({
                        url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
                        method: "POST",
                        data: datos,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(respuesta){

                            Swal.fire("Producto eliminados exitosamente!", "", "success");

                            for (var i = 0; i < arrayIds.length; i++) {


                                for (var j = 0; j < trPrecargados.length; j++) {

                                    if ($(trPrecargados[j]).attr("idproducto") == productosSeleccionados[i]) {

                                        $(trPrecargados[j]).remove();

                                    }

                                }

                            }

                        }

                    })

                }
            })

        } else {

            Swal.fire("No se puede realizar esta acción", "Debes seleccionar algun producto.", "error");

        }

    })

    /*=====  End of ELIMINAR PRODUCTOS SELECCIONADOS  ======*/

/*=====  End of -------------------------------- SECCION ELIMINACION PRODUCTO PRECARGA --------------------------------  ======*/

/*================================================================================================================================================
=            --------------------------------SECCION SUBIR PRODUCTO O PRODUCTOS A PLATAFORMA OFICIAL --------------------------------            =
================================================================================================================================================*/

    /*===================================================
    =            SUBIR PRODUCTO A PRODUCCION            =
    ===================================================*/

    $(document).on("click", ".btnSubirProductoPrecargado", function(){

        var Producto = $(this).parent().parent().parent().parent();

        Swal.fire({
          title: 'Estás seguro de subir el producto?',
          showDenyButton: true,
          confirmButtonText: `Sí, subir!`,
          denyButtonText: `Cancelar`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

            var idProducto = $(this).attr("idProducto");

            var datos = new FormData();
            datos.append("idSubir", idProducto);

            $.ajax({
                url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    Swal.fire("Producto subido exitosamente!", "", "success");
                    $(Producto).remove();

                }

            })
     
          } 

        })

    })

    /*=====  End of SUBIR PRODUCTO A PRODUCCION  ======*/

    /*=====================================================
    =            SUBIR PRODUCTOS SELECCIONADOS            =
    =====================================================*/

    $(document).on("click", ".btnSubirProductos", function(){

        var arrayIds = [];
        var trPrecargados = $(".trProductoPrecarga");
        var productosSeleccionados = $('[name="productoPrecargado[]"]:checked').map(function(){
                                          return this.value;
                                        }).get();

        if (parseInt(productosSeleccionados.length) > 0) {

            Swal.fire({
              title: 'Estás seguro de subir los productos?',
              showDenyButton: true,
              confirmButtonText: `Sí, subir!`,
              denyButtonText: `Cancelar`,
            }).then((result) => {

                if (result.isConfirmed) {

                    for (var i = 0; i < productosSeleccionados.length; i++) {
                                
                        arrayIds.push({"id" : productosSeleccionados[i]});

                    }


                    var datos = new FormData();
                    datos.append("productosSubirSelect", JSON.stringify(arrayIds));

                    $.ajax({
                        url: '../items/mvc/ajax/dashboard/productos-masivo.ajax.php',
                        method: "POST",
                        data: datos,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(respuesta){

                            Swal.fire("Productos subidos exitosamente!", "", "success");

                            for (var i = 0; i < arrayIds.length; i++) {


                                for (var j = 0; j < trPrecargados.length; j++) {

                                    if ($(trPrecargados[j]).attr("idproducto") == productosSeleccionados[i]) {

                                        $(trPrecargados[j]).remove();

                                    }

                                }

                            }

                        }

                    })

                }
            })

        } else {

            Swal.fire("No se puede realizar esta acción", "Debes seleccionar algun producto.", "error");

        }

    })

    /*=====  End of SUBIR PRODUCTOS SELECCIONADOS  ======*/

/*=====  End of -------------------------------- SECCION SUBIR PRODUCTO O PRODUCTOS A PLATAFORMA OFICIAL -------------------------------- ======*/