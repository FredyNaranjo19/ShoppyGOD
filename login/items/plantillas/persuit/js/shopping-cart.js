/*==================================================================
=            CAMBIO DE CANTIDAD POR SUMA EN EL PRODUCTO            =
==================================================================*/

$(document).on("click","#btn-mas",function(){

	var id = $(this).parent().children("#cantCarrito").attr("idProducto");
	var modelo = $(this).parent().children("#cantCarrito").attr("modelo");
	var cliente = $(".idClienteCarrito").val();
	var empresa = $(".idClienteCarrito").attr("empresa");

	var can = $(this).parent().children("#cantCarrito").val();
	var maximo = $(this).parent().children("#cantCarrito").attr("max");


	var precio = $(this).parent().parent().parent().parent().parent().children(".trPrecio").children(".tdPrecio").children("#txt-precio");
	var total = $(this).parent().parent().parent().parent().parent().children(".trTotal").children(".tdTotal").children("#txt-total");

	cantidad = parseInt(can) + parseInt(1);

	var dat = new FormData();
	dat.append("idAgregarProductoEditar",id);
	dat.append("cantidad",cantidad);
	dat.append("cliente",cliente);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:dat,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success:function(respuesta){
				
			}
		});

	var datos = new FormData();
	datos.append("modeloCambio", modelo);
	datos.append("clienteCambio", cliente);
	datos.append("productoCambio", id);
	datos.append("CantidadCambio", cantidad);
	datos.append("empresaCambio", empresa);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(respuesta){

				$(precio).html("$"+respuesta["precio"]);
				$(total).html("$"+parseFloat(respuesta["total"]).toFixed(2));
				$(total).attr("total",parseFloat(respuesta["total"]).toFixed(2));
				sumarTotalProductos();

			}

		});


	$(this).parent().children("#cantCarrito").val(cantidad);

	if (cantidad > 1) {
		$(this).parent().children("#btn-menos").prop('disabled', false);
	} else {
		$(this).parent().children("#btn-menos").prop('disabled', 'disabled');
	}

	if (cantidad < maximo) {
		$(this).prop('disabled', false);
	} else {
		$(this).prop('disabled', 'disabled');
	}
})

/*=====  End of CAMBIO DE CANTIDAD POR SUMA EN EL PRODUCTO  ======*/

/*===================================================================
=            CAMBIO DE CANTIDAD POR RESTA EN EL PRODUCTO            =
===================================================================*/

$(document).on("click","#btn-menos",function(){

	var id = $(this).parent().children("#cantCarrito").attr("idProducto");
	var modelo = $(this).parent().children("#cantCarrito").attr("modelo");
	var cliente = $(".idClienteCarrito").val();
	var empresa = $(".idClienteCarrito").attr("empresa");

	var can = $(this).parent().children("#cantCarrito").val();
	var maximo = $(this).parent().children("#cantCarrito").attr("max");

	var precio = $(this).parent().parent().parent().parent().parent().children(".trPrecio").children(".tdPrecio").children("#txt-precio");
	var total = $(this).parent().parent().parent().parent().parent().children(".trTotal").children(".tdTotal").children("#txt-total");
	// console.log(precio);
	cantidad = parseInt(can) - parseInt(1);

	var dat = new FormData();
		dat.append("idAgregarProductoEditar",id);
		dat.append("cantidad",cantidad);
		dat.append("cliente",cliente);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:dat,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success:function(respuesta){
				
			}
		});

	var datos = new FormData();
		datos.append("modeloCambio", modelo);
		datos.append("clienteCambio", cliente);
		datos.append("productoCambio", id);
		datos.append("CantidadCambio", cantidad);
		datos.append("empresaCambio", empresa);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(respuesta){

				$(precio).html("$"+respuesta["precio"]);
				$(total).html("$"+parseFloat(respuesta["total"]).toFixed(2));
				$(total).attr("total",parseFloat(respuesta["total"]).toFixed(2));
				sumarTotalProductos();

			}

		});


	$(this).parent().children("#cantCarrito").val(cantidad);

	if (cantidad > 1) {
		$(this).prop('disabled', false);

	} else {
		$(this).prop('disabled', 'disabled');
	}


	if (cantidad < maximo) {
		$(this).parent().children("#btn-mas").prop('disabled', false);
	} else {
		$(this).parent().children("#btn-mas").prop('disabled', 'disabled');
	}
})

/*=====  End of CAMBIO DE CANTIDAD POR RESTA EN EL PRODUCTO  ======*/

/*=====================================================================
=            CAMBIO DE CANTIDAD MANUALMENTE EN EL PRODUCTO            =
=====================================================================*/

$(document).on("change","#cantCarrito", function(){
	
	var id = $(this).attr("idProducto");
	var modelo = $(this).attr("modelo");
	var cliente = $(".idClienteCarrito").val();
	var empresa = $(".idClienteCarrito").attr("empresa");

	var cantidad = $(this).val();
	var maximo = $(this).attr("max");
	var cantidadAgrupado = $(this).attr("pzasAgrupados");
	

	if (parseInt(cantidad) > parseInt(maximo)) {

		cantidadDiferente = parseInt(maximo) - parseInt(cantidad);
		cantidadAgrupado = parseInt(cantidadDiferente) + parseInt(cantidadAgrupado);
		cantidad = maximo;
		$(this).val(cantidad);
	}
	if (parseInt(cantidad) <= 0) {
		
		cantidadDiferente = parseInt(cantidad) - parseInt(1);
		cantidadAgrupado = parseInt(cantidadAgrupado) - parseInt(cantidadDiferente);
		cantidad = 1;
		$(this).val(cantidad);

	}

	var precio = $(this).parent().parent().parent().parent().parent().children(".trPrecio").children(".tdPrecio").children("#txt-precio");
	var total = $(this).parent().parent().parent().parent().parent().children(".trTotal").children(".tdTotal").children("#txt-total");

	var dat = new FormData();
		dat.append("idAgregarProductoEditar",id);
		dat.append("cantidad",cantidad);
		dat.append("cliente",cliente);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:dat,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success:function(respuesta){
				
			}
		});

	var datos = new FormData();
		datos.append("modeloCambio", modelo);
		datos.append("clienteCambio", cliente);
		datos.append("productoCambio", id);
		datos.append("CantidadCambio", cantidad);
		datos.append("empresaCambio", empresa);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(respuesta){

				$(precio).html("$"+respuesta["precio"]);
				$(total).html("$"+parseFloat(respuesta["total"]).toFixed(2));
				$(total).attr("total",parseFloat(respuesta["total"]).toFixed(2));
				sumarTotalProductos();

			}

		});


	if (cantidad > 1) {
		$(this).parent().children("#btn-menos").prop('disabled', false);
	} else {
		$(this).parent().children("#btn-menos").prop('disabled', 'disabled');
	}


	if (cantidad < maximo) {
		$(this).parent().children("#btn-mas").prop('disabled', false);
	} else {
		$(this).parent().children("#btn-mas").prop('disabled', 'disabled');
	}
})

/*=====  End of CAMBIO DE CANTIDAD MANUALMENTE EN EL PRODUCTO  ======*/

/*=============================================================
=            FUNCION DE SUMA  DE TODOS LOS TOTALES            =
=============================================================*/

function sumarTotalProductos(){
	var pItem = $(".tTotal");

	var arraySumaTotales = [];

	for (var i = 0; i < pItem.length ; i++) {
		arraySumaTotales.push(Number($(pItem[i]).attr("total")));
	}

	function sumaArrayPrecios(total,numero){
		return total + numero;
	}

	var sumaTotal = arraySumaTotales.reduce(sumaArrayPrecios);

	$("#montoTotal").html("$"+ Number(sumaTotal).toFixed(2));
}

/*=====  End of FUNCION DE SUMA  DE TODOS LOS TOTALES  ======*/

/*==============================================================
=            ELIMINACION DEL PRODUCTO EN EL CARRITO            =
==============================================================*/

$(document).on("click",".delProducto", function(){

	var id = $(this).attr("idCarrito");
	var cliente = $(".idClienteCarrito").val();

	var datos = new FormData();
	datos.append("idProductoEliminar", id);
	datos.append("cliente", cliente);

	swal({
		title: "¿Está seguro de borrar el producto de tu carrito?",
		text: "¡Si no lo esta puede cancelar la acción!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6", 
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "sí, borrar!"
	}).then((result)=>{

		if(result.value){
			window.location = "index.php?ruta=shopping-cart&&delIdP="+id+"&&delCli="+cliente;
		}
	})
})

/*=====  End of ELIMINACION DEL PRODUCTO EN EL CARRITO  ======*/

/*===========================================================
=            PROCESAR CON EL PAGO (BOTTON PAGAR)            =
===========================================================*/

$(document).on("click", "#btnMontoTotal", function(){

	var cliente = $(this).attr("cliente");
	window.location = "index.php?ruta=proccess&&cliente="+cliente;
	
})

/*=====  End of PROCESAR CON EL PAGO (BOTTON PAGAR)  ======*/