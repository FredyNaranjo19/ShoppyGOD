/*==========================================================================
=            FUNCION DE AGREGAR CARACTERISTICAS A SELECCIONADOR            =
==========================================================================*/

function funcionForEach(){
	var caracteristica = "";
	var seleccion = $(".selectCaract");

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			for (var i = 0; i < respuesta.length; i++) {

				caracteristica = caracteristica.concat('<option value="'+respuesta[i]["caracteristica"]+'"');

				for (var j = 0; j < seleccion.length; j++) {

					if ($(seleccion[j]).val() == respuesta[i]["caracteristica"]) {

						caracteristica = caracteristica.concat('disabled');

					}

				}

				caracteristica = caracteristica.concat('>'+respuesta[i]["caracteristica"]+'</option>');

			}

			$("#caracteristica"+noCaracteristica).append(caracteristica);
		}
	});
}

/*=====  End of FUNCION DE AGREGAR CARACTERISTICAS A SELECCIONADOR  ======*/

/*==========================================================
=            AGREGAR CARACTERISTICA AL PRODUCTO            =
==========================================================*/

$(document).on("click", ".btnAgregarCaracteristica", function(){
	noCaracteristica++; 

	$(".nCaracteristica").append(
		'<div class="row divCarecContenido" style="margin-bottom: 5px;">'+
			'<div class="col-xs-12 col-lg-6">'+
				'<div class="input-group">'+
				  '<div class="input-group-prepend">'+
	                '<span class="input-group-text">'+
	                  '<button type="button" class="btn btn-danger btn-xs quitarCaract" idPaquete><i class="fa fa-times"></i></button>'+
	                '</span>'+
	              '</div>'+
	              '<select class="form-control selectCaract input-lg" id="caracteristica'+noCaracteristica+'" no="'+noCaracteristica+'" name="nuevoCaracteristica" required>'+
	              		'<option disabled selected>Selecciona la Carateristica</option>'+
	              '</select>'+
	            '</div>'+
			'</div>'+
			'<div class="col-xs-12 col-lg-6 divDato">'+
	             '<input type="text" class="form-control inputCaract input-lg" name="inputCaract" placeholder=""/>'+
			'</div>'+
		'</div>');


	funcionForEach();
})

/*=====  End of AGREGAR CARACTERISTICA AL PRODUCTO  ======*/

/*===============================================
=            ELIMINAR CARACTERISTICA            =
===============================================*/

$(document).on("click","button.quitarCaract",function(){
	$(this).parent().parent().parent().parent().parent().remove();
	listaAgregado();
})

/*=====  End of ELIMINAR CARACTERISTICA  ======*/

/*==============================================================
=            CAMBIO DE CARACTERISTICA SELECCIONADA             =
==============================================================*/

$(document).on("change", "select.selectCaract", function(){

	var inpDato = $(this).parent().parent().parent().children(".divDato").children(".inputCaract");
	var input = $(this).val();

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			for (var i = 0; i < respuesta.length; i++) {

				if (input == respuesta[i]["caracteristica"]) {
					
					$(inpDato).attr("type", respuesta[i]["tipo_input"]);
					$(inpDato).val(null);
					$(inpDato).attr("placeholder", respuesta[i]["placeholder_input"]);
				}

			}
			
		}
	});

	listaAgregado();

})

/*=====  End of CAMBIO DE CARACTERISTICA SELECCIONADA   ======*/

/*===========================================================
=            CAMBIO DE CARACTERISTICA(SELECCION)            =
===========================================================*/

$(document).on("change", "input.inputCaract", function(){

	listaAgregado();

})

/*=====  End of CAMBIO DE CARACTERISTICA(SELECCION)  ======*/

/*===================================================================
=            FUNCION UNIR LAS CARACTERISTICAS PARA INPUT            =
===================================================================*/

function listaAgregado(){

	var listaAgregado = [];

	var listaSelectCarac = $(".selectCaract");
	var listaInputCarac = $(".inputCaract");

	for (var i = 0; i < listaSelectCarac.length; i++) {
		listaAgregado.push({
							"caracteristica" : $(listaSelectCarac[i]).val(),
							"datoCaracteristica"  : $(listaInputCarac[i]).val(),
							"tipoCaracteristica" : $(listaInputCarac[i]).attr("type")
						})
	}

	$("#listaAgregado").val(JSON.stringify(listaAgregado));
}

/*=====  End of FUNCION UNIR LAS CARACTERISTICAS PARA INPUT  ======*/




/* ************************************************************************************************************* */
/*=================================================================================================================
=            *****************************************************************************************            =
=================================================================================================================*/
/* ************************************************************************************************************* */


/* AGREGAR CARACTERISTICA */

$(document).on("click", ".btnAgregarECaracteristica", function(){
	noEditarCaracteristica++;

	$("#caracteristicasEditar").append(
		'<div class="row divCarecContenido" style="margin-bottom: 5px;">'+
			'<div class="col-xs-12 col-lg-6">'+
				'<div class="input-group">'+
				  '<div class="input-group-prepend">'+
	                '<span class="input-group-text">'+
	                  '<button type="button" class="btn btn-danger btn-xs quitarECaract" idPaquete><i class="fa fa-times"></i></button>'+
	                '</span>'+
	              '</div>'+
	              '<select class="form-control selectECaract input-lg" id="eCaracteristica'+noEditarCaracteristica+'" no="'+noEditarCaracteristica+'" required>'+
	              	'<option disabled selected>Selecciona la Carateristica</option>'+
	              '</select>'+
	            '</div>'+
			'</div>'+
			'<div class="col-xs-12 col-lg-6 divDato">'+
	             '<input type="text" class="form-control inputECaract input-lg"/>'+
			'</div>'+
		'</div>');


	funcionForEachEditarAgregar();
	listaAgregadoEditar();
})

/* FUNCION PARA AGREGAR LAS CARACTERISTICAS EN EL SELECT */


function funcionForEachEditar(){		
	var seleccion = $(".selectECaract");

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
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
				$("#eCaracteristica"+j).append(caracteristica);
			}
			
		}
	});
	
}

/* AGREGAR CAMPOS DE CARACTERISTICAS´POR MEDIO DE BOTON AGREGAR */

function funcionForEachEditarAgregar(){

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			var caracteristica = "";
			for (var i = 0; i < respuesta.length; i++) {

				caracteristica = caracteristica.concat('<option value="'+respuesta[i]["caracteristica"]+'">'+respuesta[i]["caracteristica"]+'</option>');	

			}
			$("#eCaracteristica"+noEditarCaracteristica).append(caracteristica);

		}
	});
	
}


/* CAMBIO DE CARACTERISTICA */

$(document).on("change", "select.selectECaract", function(){

	var inpDato = $(this).parent().parent().parent().children(".divDato").children(".inputECaract");
	var input = $(this).val();

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			for (var i = 0; i < respuesta.length; i++) {

				if (input == respuesta[i]["caracteristica"]) {
					
					$(inpDato).attr("type", respuesta[i]["tipo_input"]);
					$(inpDato).val(null);
					$(inpDato).attr("placeholder", respuesta[i]["placeholder_input"]);
				}

			}
			
		}
	});

	listaAgregadoEditar();

})


/* CAMBIO DE VALOR EN LOS INPUTS */

$(document).on("change", "input.inputECaract", function(){

	listaAgregadoEditar();

})


/* ELIMINAR CARACTERISTICA */

$(document).on("click","button.quitarECaract",function(){

	$(this).parent().parent().parent().parent().parent().remove();

	listaAgregadoEditar();

})


/* FUNCION UNIR CARACTERISTICAS EN JSON */

function listaAgregadoEditar(){

	var listaAgregadoEditar = [];

	var listaSelectCarac = $(".selectECaract");
	var listaInputCarac = $(".inputECaract");

	for (var i = 0; i < listaSelectCarac.length; i++) {
		listaAgregadoEditar.push({
							"caracteristica" : $(listaSelectCarac[i]).val(),
							"datoCaracteristica"  : $(listaInputCarac[i]).val(),
							"tipoCaracteristica" : $(listaInputCarac[i]).attr("type")
						});
	}

	$("#listaAgregadoEditar").val(JSON.stringify(listaAgregadoEditar));
}





/* ************************************************************************************************************* */
/*=================================================================================================================
=            *****************************************************************************************            =
=================================================================================================================*/
/* ************************************************************************************************************* */

/* AGREGAR CARACTERISTICA */

$(document).on("click", ".btnAgregarDCaracteristica", function(){
	noDerivadoCaracteristica++;

	$(".dCaracteristica").append(
		'<div class="row divCarecContenido" style="margin-bottom: 5px;">'+
			'<div class="col-xs-12 col-lg-6">'+
				'<div class="input-group">'+
				  '<div class="input-group-prepend">'+
	                '<span class="input-group-text">'+
	                  '<button type="button" class="btn btn-danger btn-xs quitarECaract" idPaquete><i class="fa fa-times"></i></button>'+
	                '</span>'+
	              '</div>'+
	              '<select class="form-control selectDCaract input-lg" id="DCaracteristica'+noDerivadoCaracteristica+'" no="'+noDerivadoCaracteristica+'" required>'+
	              	'<option disabled selected>Selecciona la Carateristica</option>'+
	              '</select>'+
	            '</div>'+
			'</div>'+
			'<div class="col-xs-12 col-lg-6 divDato">'+
	             '<input type="text" class="form-control inputDCaract input-lg"/>'+
			'</div>'+
		'</div>');

	funcionForEachDerivadoAgregar();
	listaAgregadoDerivado();
})

/* FUNCION PARA AGREGAR LAS CARACTERISTICAS EN EL SELECT */


function funcionForEachDerivado(){		
	var seleccion = $(".selectDCaract");

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
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
				$("#DCaracteristica"+j).append(caracteristica);
			}
			
		}
	});
	
}

/* AGREGAR CAMPOS DE CARACTERISTICAS´POR MEDIO DE BOTON AGREGAR */

function funcionForEachDerivadoAgregar(){

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			var caracteristica = "";
			for (var i = 0; i < respuesta.length; i++) {

				caracteristica = caracteristica.concat('<option value="'+respuesta[i]["caracteristica"]+'">'+respuesta[i]["caracteristica"]+'</option>');	

			}
			$("#DCaracteristica"+noDerivadoCaracteristica).append(caracteristica);

		}
	});
	
}


/* CAMBIO DE CARACTERISTICA */

$(document).on("change", "select.selectDCaract", function(){

	var inpDato = $(this).parent().parent().parent().children(".divDato").children(".inputDCaract");
	var input = $(this).val();

	$.ajax({
		url: '../items/mvc/ajax/dashboard/caracteristicas.ajax.php',
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			for (var i = 0; i < respuesta.length; i++) {

				if (input == respuesta[i]["caracteristica"]) {
					
					$(inpDato).attr("type", respuesta[i]["tipo_input"]);
					$(inpDato).val(null);
					$(inpDato).attr("placeholder", respuesta[i]["placeholder_input"]);
				}

			}
			
		}
	});

	listaAgregadoDerivado();

})

/* CAMBIO DE VALOR EN LOS INPUTS */

$(document).on("change", "input.inputDCaract", function(){

	listaAgregadoDerivado();

})

/* ELIMINAR CARACTERISTICA */

$(document).on("click","button.quitarDCaract",function(){

	$(this).parent().parent().parent().parent().parent().remove();

	listaAgregadoDerivado();

})


/* FUNCION UNIR CARACTERISTICAS EN JSON */

function listaAgregadoDerivado(){

	var listaAgregadoDerivado = [];

	var listaSelectCarac = $(".selectDCaract");
	var listaInputCarac = $(".inputDCaract");

	for (var i = 0; i < listaSelectCarac.length; i++) {
		listaAgregadoDerivado.push({
							"caracteristica" : $(listaSelectCarac[i]).val(),
							"datoCaracteristica"  : $(listaInputCarac[i]).val(),
							"tipoCaracteristica" : $(listaInputCarac[i]).attr("type")
						});
	}

	$("#dListaAgregado").val(JSON.stringify(listaAgregadoDerivado));
}