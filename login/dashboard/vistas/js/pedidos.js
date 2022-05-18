/*==================================================
=            MOSTRAR DETALLE DEL PEDIDO            =
==================================================*/

$(document).on("click",".btnDetallePedido", function(){

	var folio = $(this).attr("folio");
	var anotacion = $(this).parent().children("#anotacionInputPedido").val();


	var datos = new FormData();
	datos.append("folioPedido", folio);
 
	$.ajax({
		url:"../items/mvc/ajax/dashboard/pedidos.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json", 
		success: function(respuesta){
			
			var tabla = "<table class='table' style='width: 100%; text-align: center;'>"+
              "<tr>"+
                "<th style='background: black; color: white;'>"+
                  "Modelo"+
                "</th>"+ 
                "<th style='background: black; color: white;'>"+
                  "Nombre"+
                "</th>"+
                "<th style='background: black; color: white;'>"+
                  "Cantidad"+
                "</th>"+
              "</tr>";

             for (var i = 0; i < respuesta.length; i++) {
             	tabla +="<tr>"+
             			"<td style='border: 1px solid black;'>"+respuesta[i]['codigo']+"</td>"+
		                "<td style='border: 1px solid black;'>"+respuesta[i]['nombre']+"</td>"+
		                "<td style='border: 1px solid black;'>"+respuesta[i]['cantidad']+"</td>"+
		                "</tr>";

             }

             tabla +="</tr>"+
            			"</table>";

			$(".bodyModalPedidoPendiente").html(tabla);
		}
	
	}) 

	$(".detalleAnotacion").html(anotacion);

})

/*=====  End of MOSTRAR DETALLE DEL PEDIDO  ======*/

//*******************************************************************

/*============================================================
=            MOSTRAR COMPROBANTE DE PAGO EFECTIVO            =
============================================================*/

$(document).on("click", ".btnComprobanteEfectivo", function(){

	var folio = $(this).attr("folioPedido");
	var tel =$(this).attr("tel");

	var datos = new FormData();
	datos.append("PedidentesfolioComprobanteEfectivo", folio);

	$.ajax({
		url:"../items/mvc/ajax/dashboard/pedidos.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType: "json", 
		success:function(respuesta){

			$(".imgComprobanteEfectivo").attr("src",respuesta['comprobante']);
			$(".btnAprobarEfectivo").attr("folio", folio);
			$(".btnDesaprobarEfectivo").attr("folio", folio);

			$(".btnAprobarEfectivo").attr("tel", tel);
			$(".btnDesaprobarEfectivo").attr("tel", tel);
			
		}
	})
})

/*=====  End of MOSTRAR COMPROBANTE DE PAGO EFECTIVO  ======*/

/*=================================================
=            APROBACION DE COMPROBANTE            =
=================================================*/

$(document).on("click", ".btnAprobarEfectivo", function(){

	var folio = $(this).attr("folio");
	var estado =  "Aprobado";
	var tel = $(this).attr("tel");

	var datos = new FormData();
	datos.append("folioAprobacionEfectivo", folio);
	datos.append("estadoAprobacionEfectivo", estado);


	Swal.fire({
	  title: 'Estás seguro de aprobar el comprobante?',
	  text: "Notifica al cliente de la aprobación!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, aprobar!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url:"../items/mvc/ajax/dashboard/pedidos.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType: "json", 
				success:function(respuesta){

					window.location = "pedidos-pendientes";
					window.open("https://api.whatsapp.com/send?phone=+52"+tel+"&text=El comprobante del pedido "+folio+" fue aprobado");
					
				}
			}) 

		}
	})
		
})

/*=====  End of APROBACION DE COMPROBANTE  ======*/

/*====================================================
=            DESAPROBACION DE COMPROBANTE            =
====================================================*/

$(document).on("click", ".btnDesaprobarEfectivo", function(){

	var folio = $(this).attr("folio");
	var estado =  "Subir Comprobante";
	var tel = $(this).attr("tel");

	var datos = new FormData();
	datos.append("folioAprobacionEfectivo", folio);
	datos.append("estadoAprobacionEfectivo", estado);

	Swal.fire({
	  title: 'Estás seguro de desaprobar el comprobante?',
	  text: "Notifica al cliente de la desaprobación!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, desaprobar!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url:"../items/mvc/ajax/dashboard/pedidos.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType: "json", 
				success:function(respuesta){

					window.location = "tienda-pedidos-pendientes";
					window.open("https://api.whatsapp.com/send?phone=+52"+tel+"&text=El comprobante del pedido "+folio+" fue desaprobado");

				}
			})   

		}
	})
		
})

/*=====  End of DESAPROBACION DE COMPROBANTE  ======*/


//*******************************************************

/*======================================================================
=            CCAMBIO DE ESTADO EN SECCION DE EN PREPARACION            =
======================================================================*/

$(document).on("click", ".btnStatusPreparacion", function(){


	var folio = $(this).attr("folioPedido");
	var  estadoEntrega = 'Generando Guía';
	var mensaje = "Se esta generado la guia del pedido "+folio;



	var datos = new FormData();
	datos.append("folioStatusPreparacion", folio);
	datos.append("entregaStatusPreparacion", estadoEntrega);

 
	Swal.fire({
	  title: 'El pedido esta preparado?',
	  text: "Notifica al cliente pedido listo para entregar!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, listo!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url:"../items/mvc/ajax/dashboard/pedidos.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType: "json", 
				success:function(respuesta){

					window.location = "tienda-pedidos-preparacion";
					window.open("https://api.whatsapp.com/send?phone=+52"+tel+"&text="+mensaje);

				}
			})   

		}
	})

})

/*=====  End of CCAMBIO DE ESTADO EN SECCION DE EN PREPARACION  ======*/

//*******************************************************

/*==============================================================
=            CAMBIO DE ESTADO EN GENERACION DE GUIA            =
==============================================================*/

$(document).on("click",".btnStatusGuias", function(){

	var folio = $(this).attr("folioPedido");
	var dir = $(this).attr("direccion");

	var dat = new FormData();
	dat.append("idDireccion", dir);

	$.ajax({ 
		url:'../items/mvc/ajax/dashboard/clientes-empresa.ajax.php',
		method:"POST",
		data:dat,
		cache: false,
		contentType: false, 
		processData: false,
		dataType: "json",
		success:function(respuesta){

			$("#calle").html(respuesta['calle']);
			$("#colonia").html(respuesta['colonia']);
			$("#exterior").html(respuesta['exterior']);
			$("#interior").html(respuesta['interior']);
			$("#codigoPostal").html(respuesta['cp']);
			$("#ciudad").html(respuesta['ciudad']);
			$("#estado").html(respuesta['estado']);
			$("#pais").html(respuesta['pais']);
			$("#calle1").html(respuesta['ConectaCalle1']);
			$("#calle2").html(respuesta['ConectaCalle2']);
			$("#referencia").html(respuesta['referencias']);
			$("#telefono").html(respuesta['telefono']);


			$("#folioPedidoGuia").val(folio);
		}

	});
})

/*=====  End of CAMBIO DE ESTADO EN GENERACION DE GUIA  ======*/


//*******************************************************

/*=================================================
=            PEDIDO ENTREGADO SUCURSAL            =
=================================================*/

$(document).on("click", ".btnEntregadoSucursal", function(){

	var folio = $(this).attr("folio");
	var estado = "Entregado";
	var tel = $(this).attr("tel");
	var tipo = $(this).attr("tipo");

	// alert(tipo);

	var datos = new FormData();
	datos.append("folioStatusEntregado", folio);
	datos.append("estadoEntregadoPedido", estado);
	datos.append("tipoPedidoEntregado", tipo);

	Swal.fire({
	  title: 'El pedido fue entregado?',
	  text: "Notifica al cliente la entrega!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, entregado!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url:"../items/mvc/ajax/dashboard/pedidos.ajax.php",
				method:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType: "json", 
				success:function(respuesta){
					// console.log(respuesta);
					window.location = "pedidos-sucursal";
					window.open("https://api.whatsapp.com/send?phone=+52"+tel+"&text=El pedido "+folio+" fue entregado exitosamente");

				}
			})   

		}
	})
})

/*=====  End of PEDIDO ENTREGADO SUCURSAL  ======*/

//*******************************************************

/*===============================================
=            BOTON CANCELAR PEDIDOS             =
===============================================*/

$(document).on("click", ".btnCancelarPedido", function(){

	var folio = $(this).attr("folio");
	var retorno = $(this).attr("retorno");

	var datos = new FormData();
	datos.append("folioPedidoCancelar", folio); 

	Swal.fire({ 
	  title: 'Estás seguro de cancelar el pedido?', 
	  text: "No podras restaurar el pedido",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, cancelar!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url: '../items/mvc/ajax/dashboard/pedidos.ajax.php',
				method: "POST",
				data: datos,  
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					
					if (respuesta == 'ok') {

						toastr.success('Pedido cancelado!');
						window.location = retorno;
					}
					

				}
			})

		    
		}
	})
})

/*=====  End of BOTON CANCELAR PEDIDOS   ======*/