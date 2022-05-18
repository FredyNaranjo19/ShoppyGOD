/*===============================================================
=            MOSTRAR INFORMACION PARA EDITAR ALMACEN            =
===============================================================*/

$(document).on("click", ".btnAlmacenEditar", function(){

	var idAlmacen = $(this).attr("idAlmacen");

	var datos = new FormData();
	datos.append("idAlmacen",idAlmacen);

	$.ajax({
		url:"../items/mvc/ajax/dashboard/almacenes.ajax.php",
		method:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType: "json", 
		success:function(respuesta){

			//console.log(respuesta);//

			$("#eNombreAlmacen").val(respuesta["nombre"]);
			$("#eDireccionAlmacen").val(respuesta["direccion"]);
			$("#eTelefonoAlmacen").val(respuesta["telefono"]);
			$("#eIdAlmacen").val(respuesta["id_almacen"]);
			
		}
	})

})

/*=====  End of MOSTRAR INFORMACION PARA EDITAR ALMACEN  ======*/

/*========================================
=            ELIMINAR ALMACEN            =
========================================*/

$(document).on("click", ".btnAlmacenEliminar", function(){

	var idAlmacen = $(this).attr("idAlmacen");

	var datos = new FormData();
	datos.append("idAlmacenEliminar",idAlmacen);

	Swal.fire({
	  title: 'Estás seguro de eliminar el almacén?',
	  text: "Una vez eliminado no podra ser recuperado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, eliminar!'
	}).then((result) => {
		if (result.isConfirmed) {	

			$.ajax({
				url: '../items/mvc/ajax/dashboard/almacenes.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					
					toastr.success("Almacén eliminado exitosamente!");
					window.location = 'almacenes';

				}
			})

		    
		}
	})

})

/*=====  End of ELIMINAR ALMACEN  ======*/

/*================================================================
=                   GUARDAR CAMBIOS DE ALMACEN                   =
================================================================*/

$(document).on("submit", "#formEditarAlmacen", function(e){
	e.preventDefault();

	var nombre = $("#eNombreAlmacen").val();
	var idAlmacen= $("#eIdAlmacen").val();
	var direccion= $("#eDireccionAlmacen").val();
	var telefono= $("#eTelefonoAlmacen").val();

	var datos = new FormData();
	datos.append("nombreAlmacenEditar", nombre);
	datos.append("idAlmacenEditar", idAlmacen);
	datos.append("direccionAlmacenEditar", direccion);
	datos.append("telefonoAlmacenEditar", telefono);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/almacenes.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			toastr.success("Almacén guardado exitosamente!");
			window.location = 'almacenes';

		}
	})
})

/*============  End of GUARDAR CAMBIOS DE ALMACEN  =============*/