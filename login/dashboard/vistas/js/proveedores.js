/*=================================================================
=            MOSTRAR INFORMACION PARA EDITAR PROVEEDOR            =
=================================================================*/

$(document).on("click", ".btnEditarProvvedor", function(){
	
	var idProveedor = $(this).attr("id_proveedor");

	var datos = new FormData();
	datos.append("idProveedor", idProveedor);

	$.ajax({
		url:"../items/mvc/ajax/dashboard/proveedores.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$("#ProveedoreId").val(respuesta["id_proveedor"]);
			$("#ProveedoreEmpresa").val(respuesta["id_empresa"]);
			$("#ProveedoreNombre").val(respuesta["nombre"]);
			$("#ProveedoreContacto").val(respuesta["contacto"]);
			$("#ProveedoreTelefono").val(respuesta["telefono"]);
			$("#ProveedoreCalle").val(respuesta["calle"]);
			$("#ProveedoreNoExt").val(respuesta["noExt"]);
			$("#ProveedoreNoInt").val(respuesta["noInt"]);
			$("#ProveedoreColonia").val(respuesta["colonia"]);
			$("#ProveedoreCP").val(respuesta["cp"]);
			$("#ProveedoreMunicipio").val(respuesta["municipio"]);
			$("#ProveedoreEstado").val(respuesta["estado"]);
			$("#ProveedorePais").val(respuesta["pais"]);

		}
	})

})

/*=====  End of MOSTRAR INFORMACION PARA EDITAR PROVEEDOR  ======*/

/*========================================== 
=            ELIMINAR PROVEEDOR            =
==========================================*/

$(document).on("click", ".btnEliminarProveedor", function(){

	var id = $(this).attr("id_proveedor");

	var datos = new FormData();
	datos.append("idProveedorEliminar", id);

	Swal.fire({
	  title: 'Estás seguro de eliminar el proveedor?',
	  text: "El usuario no podra ser recuperado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, eliminar!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url: '../items/mvc/ajax/dashboard/proveedores.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					
					if (respuesta == 'ok') {

						toastr.success('Proveedor eliminado exitosamente!');
						window.location = 'proveedores';

					}
					

				}
			})

		    
		}
	})
})

/*=====  End of ELIMINAR PROVEEDOR  ======*/