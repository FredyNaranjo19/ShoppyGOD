/*=======================================
=            SUMAR CANTIDAD             =
=======================================*/

$(document).on("click","#signo-mas",function(){

	var cantidad = $("#cantidad-text").val();
	var maximo = $("#cantidad-text").attr("max");
	var codigo = $("#cantidad-text").attr("listado");
	var empresa = $("#cantidad-text").attr("empresa");
	cantidad = parseInt(cantidad) + parseInt(1);

	$("#cantidad-text").val(cantidad);


	var datos = new FormData();
	datos.append("CantidadDetalleProducto", cantidad);
	datos.append("codigoDetalleProducto", codigo);
	datos.append("empresaDetalleProducto", empresa); 

	$.ajax({
		url:'../ajax/store/carrito.ajax.php',
		method:"POST",
		data:datos,
		cache: false, 
		contentType: false, 
		processData: false,
		dataType: "json",
		success:function(respuesta){
			
			if (respuesta["activado"] == "si") {

				$("#precioMuestraDetalle").html("<del style='color: gray;'>$ "+respuesta["precio"]+"</del> $"+respuesta["promo"]+" p/pza.");

			} else {

				$("#precioMuestraDetalle").html("$ "+respuesta["precio"]+" p/pza.");

			}

			
			$("#costoEnvio").html(respuesta["envio"]);
			
		}
	})
 

	if(cantidad > 1){
		$("#signo-menos").prop('disabled', false);
	}else{
		$("#signo-menos").prop('disabled', 'disabled');
	}
	/* BOTON DE SUMAR DISABLED O FALSE */
	
	if (cantidad < maximo) {
		$("#signo-mas").prop('disabled', false);
	}else{
		$("#signo-mas").prop('disabled', 'disabled');
	}

})

/*=====  End of SUMAR CANTIDAD   ======*/

/*=======================================
=            RESTAR CANTIDAD            =
=======================================*/

$(document).on("click","#signo-menos",function(){

	var cantidad = $("#cantidad-text").val();
	var maximo = $("#cantidad-text").attr("max");
	var codigo = $("#cantidad-text").attr("listado");
	var empresa = $("#cantidad-text").attr("empresa");

	cantidad = parseInt(cantidad) - parseInt(1);

	$("#cantidad-text").val(cantidad);



	var datos = new FormData();
	datos.append("CantidadDetalleProducto", cantidad);
	datos.append("codigoDetalleProducto", codigo); 
	datos.append("empresaDetalleProducto", empresa); 

	$.ajax({
		url:'../items/mvc/ajax/tv/carrito.ajax.php',
		method:"POST",
		data:datos,
		cache: false,
		contentType: false, 
		processData: false,
		dataType: "json",
		success:function(respuesta){
			
			if (respuesta["activado"] == "si") {

				$("#precioMuestraDetalle").html("<del style='color: gray;'>$ "+respuesta["precio"]+"</del> $"+respuesta["promo"]+" p/pza.");

			} else {

				$("#precioMuestraDetalle").html("$ "+respuesta["precio"]+" p/pza.");

			}
			$("#costoEnvio").html(respuesta["envio"]);
		}
	})



	if(cantidad > 1){
		$("#signo-menos").prop('disabled', false);
	}else{
		$("#signo-menos").prop('disabled', 'disabled');
	}
	/* BOTON DE SUMAR DISABLED O FALSE */
	if (cantidad < maximo) {
		$("#signo-mas").prop('disabled', false);
	}else{
		$("#signo-mas").prop('disabled', 'disabled');
	}

})

/*=====  End of RESTAR CANTIDAD  ======*/

/*===========================================
=            CAMBIO DE CANTIDAD             =
===========================================*/

$(document).on("change","#cantidad-text", function(){

	var cantidad = $(this).val();
	var maximo = $(this).attr("max");
	var codigo = $(this).attr("listado");
	var empresa = $(this).attr("empresa");

	if (parseInt(cantidad) >= parseInt(maximo) ) {
		cantidad = maximo;
	}
	if (parseInt(cantidad) <= 0) { 
		cantidad = 1;
	}

	$("#cantidad-text").val(cantidad);



	var datos = new FormData();
	datos.append("CantidadDetalleProducto", cantidad);
	datos.append("codigoDetalleProducto", codigo);
	datos.append("empresaDetalleProducto", empresa); 

	$.ajax({
		url:'../items/mvc/ajax/tv/carrito.ajax.php',
		method:"POST",
		data:datos,
		cache: false,
		contentType: false, 
		processData: false,
		dataType: "json",
		success:function(respuesta){
			
			if (respuesta["activado"] == "si") {

				$("#precioMuestraDetalle").html("<del style='color: gray;'>$ "+respuesta["precio"]+"</del> $"+respuesta["promo"]+" p/pza.");

			} else {

				$("#precioMuestraDetalle").html("$ "+respuesta["precio"]+" p/pza.");

			}
			$("#costoEnvio").html(respuesta["envio"]);
		}
	})


	if(cantidad > 1){
		$("#signo-menos").prop('disabled', false);
	}else{
		$("#signo-menos").prop('disabled', 'disabled');
	}

	/* BOTON DE SUMAR DISABLED O FALSE */
	if (cantidad < maximo) {
		$("#signo-mas").prop('disabled', false);
	}else{
		$("#signo-mas").prop('disabled', 'disabled');
	}

})

/*=====  End of CAMBIO DE CANTIDAD   ======*/

/*==============================================================
=            GUARDAR PRODUCTO EN CARRITO DE COMPRAS            =
==============================================================*/

$(document).on("click","#btn-agregar",function(){
	console.log("Entro");
	var idProducto = $(this).attr("idProducto");
	var cantidad = $("#cantidad-text").val();
	var cliente = $(this).attr("cliente");
	// var sku = $(this).attr("listado");
	var modelo = $(this).attr("modelo");
	var empresa = $(this).attr("empresa");
	var noProductos = $(".noProductos").text();

	if (cliente != "not") {
		var datos = new FormData();
			datos.append("idAgregarProducto", idProducto);
			datos.append("cantidad", cantidad);
			datos.append("cliente", cliente);
			// datos.append("sku", sku);
			datos.append("modelo", modelo);
			datos.append("empresa", empresa);


			$.ajax({
				url:'../items/mvc/ajax/tv/carrito.ajax.php',
				method:"POST",
				data:datos,
				cache: false,
				contentType: false, 
				processData: false,
				dataType: "json",
				success:function(respuesta){
					// console.log(respuesta);
					// if (noProductos == "") {
					// 	noProductos = 0;
					// }
					noProductos = parseInt(noProductos) + 1;
					$(".noProductos").text(noProductos);

					swal({
						type:'success',
						title: 'Producto guardado en tu carrito',
						showConfirmButton: true,
						confirmButtonText: 'Cerrar',
						closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								 window.location='extraccion';
						}
					});
					
				}
			})

	}else{
		window.location = 'login';
	}
	
})

/*=====  End of GUARDAR PRODUCTO EN CARRITO DE COMPRAS  ======*/

/*========================================
=            COMPRAR PRODUCTO            =
========================================*/

$(document).on("click","#btn-comprar",function(){

	var idProducto = $(this).attr("idProducto");
	var cantidad = $("#cantidad-text").val();
	var cliente = $(this).attr("cliente");
	// var sku = $(this).attr("listado");
	var modelo = $(this).attr("modelo");
	var empresa = $(this).attr("empresa");
	var noProductos = $(".noProductos").text();


	if (cliente != "not") {
		var datos = new FormData();
			datos.append("idAgregarProducto",idProducto);
			datos.append("cantidad",cantidad);
			datos.append("cliente",cliente);
			// datos.append("sku", sku);
			datos.append("modelo", modelo);
			datos.append("empresa", empresa);

 
			$.ajax({
				url:'../items/mvc/ajax/tv/carrito.ajax.php',
				method:"POST",
				data:datos,
				cache: false,
				contentType: false, 
				processData: false,
				dataType: "json",
				success:function(respuesta){
					// console.log(respuesta);
					noProductos = parseInt(noProductos) + 1;
					$(".noProductos").text(noProductos);
					
					swal({
						type:'success',
						title: 'Generando compra!',
						showConfirmButton: true,
						confirmButtonText: 'Cerrar',
						closeOnConfirm: false
						}).then((result)=>{
							if(result.value){
								 window.location='shopping-cart';
						}
					});
					
				}
			})

	}else{
		window.location = 'login';
	}
	
})

/*=====  End of COMPRAR PRODUCTO  ======*/

/*==========================================================
=            PAGINACION DE PRODUCTOS DIFERENTES            =
==========================================================*/

$(document).on("click",".sectionProdLink",function(){

	var numero = $(this).attr("btnLink");
	var cantidad = document.getElementsByClassName("sectionProdLink").length;
	

	for (var i = 0; i < cantidad ; i++) {
		
		if(parseInt(i) != parseInt(numero)){

			$("#rows"+i).hide("slow");

		} else {

			$("#rows"+i).show("slow");
		}
	}
})

/*=====  End of PAGINACION DE PRODUCTOS DIFERENTES  ======*/

/*========================================================
=            SELECCION DE OPCION DEL PRODUCTO            =
========================================================*/

$(document).on("click", ".btnViewDerivado", function(){

	idProducto = $(this).attr("pR06412");
	cod = $(this).attr("cod");

	// alert(idProducto);
	window.location = 'index.php?ruta=product-details&&pR06412='+idProducto+'&&nhvds47='+cod;

})

/*=====  End of SELECCION DE OPCION DEL PRODUCTO  ======*/



