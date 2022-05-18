/*========================================================
=            SELECCIONAR ADMINISTRACION CEDIS            =
========================================================*/

$(document).on("click", ".btnAdministradorPlataforma", function(){

	var rol = "Cedis";
	var almacen = null;

	var datos = new FormData();
	datos.append("rolAdministrador", rol);
	datos.append("almacenAdministrador", almacen);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/usuarios.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			window.location = 'inicio';		

		}
	})
})

/*=====  End of SELECCIONAR ADMINISTRACION CEDIS  ======*/

/*==========================================================
=            SELECCIONAR ADMINISTRACION ALMACEN            =
==========================================================*/

$(document).on("click", ".btnAlmacenAdministradorPlataforma", function(){

	var rol = "Administrador Almacen";
	var almacen = $("#selectAlmacenAdministrador").val();

	if (almacen != "") {

		var datos = new FormData();
		datos.append("rolAdministrador", rol);
		datos.append("almacenAdministrador", almacen);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/usuarios.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				window.location = 'inicio';		

			}
		})

	} else {

		toastr.error("DEBES DE SELECCIONAR UN ALMACEN");
	}
})


/*=====  End of SELECCIONAR ADMINISTRACION ALMACEN  ======*/

/*=======================================================
=            SELECCIONAR VENDEDOR DE ALMACEN            =
=======================================================*/

$(document).on("click", ".btnAlmacenVendedorPlataforma", function(){

	var rol = "Vendedor Almacen";
	var almacen = $("#selectAlmacenVendedor").val();

	if (almacen != "") {

		var datos = new FormData();
		datos.append("rolAdministrador", rol);
		datos.append("almacenAdministrador", almacen);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/usuarios.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				window.location = 'inicio';		

			}
		})

	} else {

		toastr.error("DEBES DE SELECCIONAR UN ALMACEN");
	}
})

/*=====  End of SELECCIONAR VENDEDOR DE ALMACEN  ======*/
