/*=============================================================
=            MOSTRAR DATOS DEL CLIENTE PARA EDITAR            =
=============================================================*/

$(document).on("click", ".btnClienteEditar", function(){

	var id = $(this).attr("idCliente");

	var datos = new FormData();
	datos.append("ClienteMostrarId", id);

	$.ajax({
		url: "../items/mvc/ajax/dashboard/clientes-empresa.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$("#ClienteeId").val(respuesta["id_cliente"]);
			$("#ClienteeNombre").val(respuesta["nombre"]);
			$("#ClienteeCorreo").val(respuesta["email"]);
			$("#ClienteeTelefono").val(respuesta["telefono"]);

		}
	})
})


/*=====  End of MOSTRAR DATOS DEL CLIENTE PARA EDITAR  ======*/

/*=========================================
=            ELIMINAR CLIENTE             =
=========================================*/

$(document).on("click", ".btnClienteEliminar", function(){

	var id = $(this).attr("idCliente");

	var datos = new FormData();
	datos.append("ClienteEliminarId", id);

	Swal.fire({
	  title: 'Estás seguro de eliminar a este cliente?',
	  text: "Una vez eliminado no podra ser recuperado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, eliminar!'
	}).then((result) => {
		if (result.isConfirmed) {	

			$.ajax({
				url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					
					toastr.success("Cliente eliminado exitosamente!");
					window.location = 'clientes';

				}
			})

		    
		}
	})

})

/*=====  End of ELIMINAR CLIENTE   ======*/

/*======================================================================
=            INFORMACION PARA MODAL DIRECCIONES DEL CLIENTE            =
======================================================================*/

$(document).on("click", ".btnDireccionesCliente", function(){

	var idCliente = $(this).attr("idCliente");
	var tablaDirecciones = "";
	var datos = new FormData();
	datos.append("idClienteDom", idCliente);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			

			tablaDirecciones = tablaDirecciones.concat('<table class="table table-bordered table-striped dt-responsive tablas" style="width:100%; text-align:center;">'+
															'<thead>'+
																'<tr>'+
																	'<th>Dirección</th>'+
																	'<th>Municipio</th>'+
																	'<th>Estado</th>'+
																	'<th>'+
																		'<button class="btn btn-secondary btn-block btnNuevaDireccionCliente" idCliente="'+idCliente+'">'+
																			'<i class="fa fa-plus"></i>'+
																		'</button>'+
																	'</th>'+
																'</tr>'+
															'</thead>'+
															'<tbody>');

			if (respuesta == "ninguno") {

			tablaDirecciones = tablaDirecciones.concat('<tr>'+
															'<td colspan="4">No se encontraron direcciones</td>'+
														'</tr>');
			} else {

				for (var i = 0; i < respuesta.length; i++) {

				tablaDirecciones = tablaDirecciones.concat('<tr>'+
																'<td>'+respuesta[i]["calle"]+' '+respuesta[i]["exterior"]+'</td>'+
																'<td>'+respuesta[i]["ciudad"]+'</td>'+
																'<td>'+respuesta[i]["estado"]+'</td>'+
																'<td>'+
																	'<button class="btn btn-warning btnEditarDireccion btn-block" idDireccion="'+respuesta[i]["id_info"]+'"><i class="fa fa-edit"></i></button>'+
																'</td>'+
															'</tr>');
				}

			}
			tablaDirecciones = tablaDirecciones.concat('</tbody>'+
													'</table>');

			
			$(".direccionesTabla").html(tablaDirecciones);
		}
	})
})

/*=====  End of INFORMACION PARA MODAL DIRECCIONES DEL CLIENTE  ======*/

/*===============================================
=            CREAR  NUEVA DIRECCION             =
===============================================*/

$(document).on("click", ".btnNuevaDireccionCliente", function(){

	var idCliente = $(this).attr("idCliente");
	$('#formDireccionClientes').trigger("reset");
	$('#formDireccionClientes').show("slow");

	$("#clienteIdClientes").val(idCliente);
	$("#tipoAccionClientes").val("Crear");

})


/*=====  End of CREAR  NUEVA DIRECCION   ======*/

/*=================================================================
=            MOSTRAR INFORMACION PARA EDITAR DIRECCION            =
=================================================================*/

$(document).on("click", ".btnEditarDireccion", function(){

	var idDireccion = $(this).attr("idDireccion");
	$('#formDireccionClientes').trigger("reset");
	$('#formDireccionClientes').show("slow");


	var datos = new FormData();
	datos.append("idDireccion", idDireccion);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$("#DireccionClientes").val(respuesta["calle"]);
			$("#ExtClientes").val(respuesta["exterior"]);
			$("#IntClientes").val(respuesta["interior"]);
			$("#CPClientes").val(respuesta["cp"]);
			$("#ColoniaClientes").val(respuesta["colonia"]);
			$("#CiudadClientes").val(respuesta["ciudad"]);
			$("#EstadoClientes").val(respuesta["estado"]);
			$("#PaisClientes").val(respuesta["pais"]);
			$("#calle1Clientes").val(respuesta["ConectaCalle1"]);
			$("#calle2Clientes").val(respuesta["ConectaCalle2"]);
			$("#refClientes").val(respuesta["referencias"]);

			$("#idDireccionClientes").val(respuesta["id_info"]);

			$("#tipoAccionClientes").val("Modificar");
		}
	})	
})

/*=====  End of MOSTRAR INFORMACION PARA EDITAR DIRECCION  ======*/

/*=======================================================
=            SOLICITUD DE CREDITO DE CLIENTE            =
=======================================================*/

$(document).on("submit", "#formSolicitudCredito", function(e){
	e.preventDefault();
	var idCliente = $("#idClienteCredito").val();

	var datos = new FormData();
	datos.append("idClienteCredito", idCliente);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			// console.log(respuesta);
			if (respuesta == 'ok') {
				toastr.success("Solicitud realizada exitosamente!");
			} else {

				toastr.warning("Ya se ha realizado una solicitud de este cliente!");

			}
			

		}
	})
})

/*=====  End of SOLICITUD DE CREDITO DE CLIENTE  ======*/

/*========================================================================
=            VISUALIZACION DE SOLICITUD DE CREDIO DEL CLIENTE            =
========================================================================*/

$(document).on("click", ".btnSolicitudCredito", function(){

	var valor = $(this).attr('tipo');
	var idCliente = $(this).attr('idCliente');

	$("#modalCreditoCliente").modal("show");

	/* INFORMACION DEL CLIENTE */
	var infoCliente = "";
	var datos = new FormData();
	datos.append("ClienteMostrarId", idCliente);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			infoCliente = infoCliente.concat('<div class="row">'+
			                '<div class="col-md-4 mb-3">'+
			                  '<h5 class="titprod"> Nombre: </h5>'+
			                  '<div class="input-group">'+
			                    '<input type="text" class="form-control input-lg" readonly value="'+respuesta["nombre"]+'">'+
			                  '</div>'+
			                '</div>'+
			                '<div class="col-md-4 mb-3">'+
			                  '<h5 class="titprod"> Fecha registro: </h5>'+
			                  '<div class="input-group">'+
			                    '<input type="text" class="form-control input-lg" readonly value="'+respuesta["fecha"]+'">'+
			                  '</div>'+
			                '</div>'+
			                '<div class="col-md-4 mb-3">'+
			                  '<h5 class="titprod"> Credito otorgado: </h5>'+
			                  '<div class="input-group">'+
			                    '<input type="text" class="form-control input-lg" readonly value="'+respuesta["credito"]+'">'+
			                  '</div>'+
			                '</div>'+
			              '</div>');							

			$(".divInfoCliente").html(infoCliente);
		}
	})

	/* SECCION DE COMPRAS DEPENDIENDO DE CONDICION DE SI O NO TIENE CREDITO*/
	
	var infoVentasCliente = "";

	var datos = new FormData();
	datos.append("idClienteVentas", idCliente);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/venta.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			infoVentasCliente = infoVentasCliente.concat('<hr>'+
				              '<h3 style="font-weight: bold; text-align: center;">Compras del cliente</h3>'+
				              '<div class="row">'+
				              	'<div class="col-md-3 mb-3">'+
				              		'<h5 class="titprod"> No. compras: </h5>'+
				              		'<div class="input-group">'+
				              			'<input type="text" class="form-control input-lg" readonly value="'+respuesta["noVentas"]+'">'+
				              		'</div>'+
				              	'</div>'+
				              	'<div class="col-md-4 mb-3">'+
				              		'<h5 class="titprod"> Total comprado: </h5>'+
				              		'<div class="input-group">'+
				              			'<input type="text" class="form-control input-lg" readonly value="$'+respuesta["totalVentas"]+'">'+
				              		'</div>'+
				              	'</div>'+
				              	'<div class="col-md-5 mb-3">'+
				              		'<h5 class="titprod"> Fecha ultima compra: </h5>'+
				              		'<div class="input-group">'+
				              			'<input type="text" class="form-control input-lg" readonly value="'+respuesta["fecha"]+'">'+
				              		'</div>'+
				              	'</div>'+
				              '</div>');

			if (valor == "No") {

          		infoVentasCliente = infoVentasCliente.concat('<div class="row justify-content-center">'+
				              	'<div class="col-md-4">'+
				              		'<button type="button" class="btn btn-danger btn-block btnDesprobarCredito" idCliente="'+idCliente+'">'+
				              			'Desaprobar credito'+
				              		'</button>'+
				              	'</div>'+
			              		'<div class="col-md-4">'+
				              		'<button type="button" class="btn btn-secondary btnColorCambio btn-block btnAprobarCredito" idCliente="'+idCliente+'">'+
				              			'Aprobar credito'+
				              		'</button>'+
				              	'</div>'+
				              '</div>');

          	} else {

          		infoVentasCliente = infoVentasCliente.concat('<div class="row justify-content-center">'+
				              	'<div class="col-md-4">'+
				              		'<button type="button" class="btn btn-danger btn-block btnDesprobarCredito" idCliente="'+idCliente+'">'+
				              			'Desaprobar credito'+
				              		'</button>'+
				              	'</div>'+
				              '</div>');

          	}
			
			$(".divInfoVentasCliente").html(infoVentasCliente);
		}
	})
	


})

/*=====  End of VISUALIZACION DE SOLICITUD DE CREDIO DEL CLIENTE  ======*/

/*==================================================
=            APROBAR CREDITO DE CLIENTE            =
==================================================*/

$(document).on("click", ".btnAprobarCredito", function(){

	var idCliente = $(this).attr("idCliente");
	var valorCredito = "Si";

	var datos = new FormData();
	datos.append("idCreditoCliente", idCliente);
	datos.append("valorCreditoCliente", valorCredito);

	Swal.fire({
	  title: 'Estás seguro de aprobar el credito?',
	  text: "",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, aprobar!'
	}).then((result) => {
		if (result.isConfirmed) {	
			
			$.ajax({
				url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){

					window.location = "clientes";
				}
			}) 
		}
	})
})

/*=====  End of APROBAR CREDITO DE CLIENTE  ======*/

/*=====================================================
=            DESAPROBAR CREDITO DE CLIENTE            =
=====================================================*/

$(document).on("click", ".btnDesprobarCredito", function(){

	var idCliente = $(this).attr("idCliente");
	var valorCredito = "No";

	var datos = new FormData();
	datos.append("idCreditoCliente", idCliente);
	datos.append("valorCreditoCliente", valorCredito);

	Swal.fire({
	  title: 'Estás seguro de desaprobar el credito?',
	  text: "",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, desaprobar!'
	}).then((result) => {
		if (result.isConfirmed) {	
			
			$.ajax({
				url: '../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){

					window.location = "clientes";
					
				}
			}) 
		}
	})	
})

/*=====  End of DESAPROBAR CREDITO DE CLIENTE  ======*/
