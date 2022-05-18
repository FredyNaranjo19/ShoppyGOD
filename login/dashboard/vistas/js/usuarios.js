/*==========================================================================
=                   MOSTRAR ROLES DE USUARIO DISPONIBLES                   =
==========================================================================*/

$(document).on("click", ".btnCrearUsuario", function(){

	var datosSelect = "";

	var datos = new FormData();
	datos.append("rolesDisponibles", "1");

	$.ajax({
		url: "../items/mvc/ajax/dashboard/usuarios.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			// console.log(respuesta);

			datosSelect = datosSelect.concat('<option value="" selected disabled>Selecciona el rol...</option>');

			if(respuesta["administrador"] > 0){
				datosSelect = datosSelect.concat('<option value="1">Administrador</option>');
			}

			if(respuesta["administrador_almacen"] > 0){
				datosSelect = datosSelect.concat('<option value="2">Administrador Almacen</option>');
			}

			if(respuesta["vendedores_almacen"] > 0){
				datosSelect = datosSelect.concat('<option value="3">Vendedor Almacen</option>');
			}

			if(respuesta["vendedores_externos"] > 0){
				datosSelect = datosSelect.concat('<option value="4">Vendedor Externo</option>');
			}

			$("#UsuariosnRol").html(datosSelect);
		}
	})

	// $('#modalAgregarUsuario').modal({backdrop: 'static', keyboard: false})
	// $('#modalAgregarUsuario').modal({backdrop: 'static', keyboard: false})
})

/*============  End of MOSTRAR ROLES DE USUARIO DISPONIBLES  =============*/

/*=========================================================
=            CAMBIO DE VALOR EN ROL DE USUARIO            =
=========================================================*/

$(document).on("change", "#UsuariosnRol", function(){

	var dato = $(this).val();

	if (dato == "2" || dato == "3") {

		$(".divAlmacenUsuario").show("slow");

	} else {

		$(".divAlmacenUsuario").hide("slow");
		$("#UsuariosnAlmacen").val("");

	}
})

/*=====  End of CAMBIO DE VALOR EN ROL DE USUARIO  ======*/

/*===================================================
=            CREAR USUARIO DE PLATAFORMA            =
===================================================*/

$(document).on("submit", "#formCrearUsuario", function(e){
	e.preventDefault();

	var UsuariosnNombre= $("#UsuariosnNombre").val();
	var UsuariosnEmail= $("#UsuariosnEmail").val();
	var UsuariosnTelefono= $("#UsuariosnTelefono").val();
	var UsuariosnPassword= $("#UsuariosnPassword").val();
	var UsuariosnRol= $("#UsuariosnRol").val();

	if (UsuariosnRol == "2" || UsuariosnRol == "3") {

		var UsuariosnAlmacen = $("#UsuariosnAlmacen").val();

	} else {

		var UsuariosnAlmacen = null;

	}

	var datos = new FormData();
	datos.append("crearUsuarioNombre", UsuariosnNombre);
	datos.append("crearUsuarioEmail", UsuariosnEmail);
	datos.append("crearUsuarioTelefono", UsuariosnTelefono);
	datos.append("crearUsuarioPassword", UsuariosnPassword);
	datos.append("crearUsuarioRol", UsuariosnRol);
	datos.append("crearUsuarioAlmacen", UsuariosnAlmacen);

	$.ajax({
		url: "../items/mvc/ajax/dashboard/usuarios.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			window.location = 'usuarios-plataforma';
		}
	})

}) 

/*=====  End of CREAR USUARIO DE PLATAFORMA  ======*/

/*===================================================================
=            MOSTRAR INFORMACION DEL USUARIO PARA EDITAR            =
===================================================================*/

$(document).on("click",".btnEditarUs",function(){
	
	var idUsuario = $(this).attr("idUs");
	var rol = $(this).attr("idrol");
	var almac = $(this).attr("idalmac");
	var datosSelect = "";
	var datos = new FormData();
	datos.append("idUsuarioAlmacen",idUsuario);
	
	
	if(rol == "Vendedor Almacen" || rol == "Administrador Almacen"  ){
		Mostrarusuarioplataform(idUsuario);
		var datos = new FormData();
		datos.append("Almacenes",almac);
		$.ajax({
			url: "../items/mvc/ajax/dashboard/almacenes.ajax.php", 
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
					//console.log(respuesta);
					datosSelect = datosSelect.concat(
					'<h5 class="titprod" id="remove"> Asignar a Almacen:</h5>'+
					'<div class="input-group" id="remove2">'+
					'<div class="input-group-prepend">'+
					'</div>'+
					'<select class="form-control" id="almacen" required>'
													
					);
					if(almac == "0"){
						datosSelect = datosSelect.concat(
							'<option value="" selected disabled >Selecciona un almacen</option>'
						);
					}else{
						resultado = respuesta.find( almacen => almacen.id_almacen === almac );
						datosSelect = datosSelect.concat(
							'<option value="'+resultado["id_almacen"]+'" selected disabled >'+resultado["nombre"]+'</option>'
						);
					}
	
					for (i = 0; i < respuesta.length; i++) {
						datosSelect = datosSelect.concat(
						'<option value='+respuesta[i]["id_almacen"]+'>'+respuesta[i]["nombre"]+'</option>;'
						);
					}
						
					datosSelect = datosSelect.concat(
							'</select>'+
							'</div>'+
						'</div>'
					);
				$("#almacenuseroption").html(datosSelect);
			}
		})
		
	}
	 if(rol == "Vendedor Almacen " || rol == "Administrador Almacen " ){
		Mostrarusuarioplataform(idUsuario);
		var datos = new FormData();
		datos.append("Almacenes",almac);
		$.ajax({
			url: "../items/mvc/ajax/dashboard/almacenes.ajax.php", 
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta2){
					//console.log("respuesta");
					resultado = respuesta2.find( almacen => almacen.id_almacen === almac );
					datosSelect = datosSelect.concat(
					
					'<h5 class="titprod" id="remove">Incluido en Almacen:'+
					'<spam style="font-size:1.2rem; font-weight: bold">  '+resultado["nombre"]+'</spam></h5>'																	
					);											
					
				$("#almacenuseroption").html(datosSelect);
			}
		})
		
	}else{
		Mostrarusuarioplataform(idUsuario);
		$('#remove').remove();
		$('#remove2').remove();
		
	}
	function Mostrarusuarioplataform(idUsuario){
		var datos2 = new FormData();
		datos2.append("idUsuario",idUsuario);
		$.ajax({
			url: "../items/mvc/ajax/dashboard/usuarios.ajax.php", 
			method: "POST",
			data: datos2,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respu){
				$('#UsuarioseNombre').val(respu["nombre"]);
				$('#UsuarioseID').val(respu["id_usuario_plataforma"]);
				$('#UsuarioseEmail').val(respu["email"]);
				$('#UsuarioseEmail').attr("mail", respu["email"]);
				$("#UsuariosePassword").val(respu["password"]);
				$('#UsuariospasswordActual').val(respu["password"]);
				$('#UsuarioseTelefono').val(respu["telefono"]);
				
			}
		})
		//return respu;
	}
})

/*=====  End of MOSTRAR INFORMACION DEL USUARIO PARA EDITAR  ======*/

/*=============================================================
=            GUARDAR CAMBIOS DE EDICION DE USUARIO            =
=============================================================*/

$(document).on("submit", "#formEditarUsuario", function(e){
	e.preventDefault();

	var nombre = $("#UsuarioseNombre").val();
	var id = $("#UsuarioseID").val();
	var email = $("#UsuarioseEmail").val();
	var pass = $("#UsuariosePassword").val();
	var telefono = $("#UsuarioseTelefono").val(); 
	var almacen = $("#almacen").val();

	var datos = new FormData();
	datos.append("editarUsuarioNombre", nombre);
	datos.append("editarUsuarioId", id);
	datos.append("editarUsuarioEmail", email);
	datos.append("editarUsuarioPass", pass);
	datos.append("editarUsuarioTelefono", telefono);
	datos.append("editarUsuarioAlmacen", almacen);

	$.ajax({
		url: "../items/mvc/ajax/dashboard/usuarios.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			if (respuesta == 'ok') {

				window.location = "usuarios-plataforma";
			
			}
		}
	});

})

/*=====  End of GUARDAR CAMBIOS DE EDICION DE USUARIO  ======*/

/*=====================================================================
=            ESTADO DEL USUARIO PARA INGRESAR A PLATAFORMA            =
=====================================================================*/

$(document).on("click",".btnEstadoUsuario",function(){

	var id = $(this).attr("idUsuario");
	var estado = $(this).attr("estadoUsuario");

	var datos = new FormData();
	datos.append("UsuarioActivarId",id);
	datos.append("UsuarioActivarEstado",estado);

	$.ajax({
			url: "../items/mvc/ajax/dashboard/usuarios.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			success:function(respuesta){
				// console.log(respuesta);
				if (window.matchMedia("(max-width:767px)").matches) {
					Swal.fire({
						title: "El usuario ha sido actualizado",
						type: "success",
						confirmButtonText: "¡Cerrar!"
					}).then(function(result){
						if (result.value) {

							window.location = "usuarios-plataforma";

						}
					})
				}
				
			}
	})

	if(estado == 0){

		$(this).removeClass("btnColorCambio");
		$(this).addClass("btn-danger");
		$(this).html("Desactivado");
		$(this).attr("estadoUsuario",1);

	} else {

		$(this).addClass("btnColorCambio");
		$(this).removeClass("btn-danger");
		$(this).html("Activado");
		$(this).attr("estadoUsuario",0);

	}

})

/*=====  End of ESTADO DEL USUARIO PARA INGRESAR A PLATAFORMA  ======*/

/*==================================================
=            ELIMINAR USUARIO DASHBOARD            =
==================================================*/

$(document).on("click",".btnEliminarUsuario", function(){

	var id = $(this).attr("idUsuario");

	var datos = new FormData();
	datos.append("usuariosEliminarId", id);

	Swal.fire({
	  title: 'Estás seguro de eliminar el usuario?',
	  text: "El usuario no podra ser recuperado!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sí, eliminar!'
	}).then((result) => {
		if (result.isConfirmed) {

			$.ajax({
				url: '../items/mvc/ajax/dashboard/usuarios.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					// console.log(respuesta);
					if (respuesta == 'ok') {

						toastr.success('Usuario eliminado exitosamente!');
						window.location = 'usuarios-plataforma';

					}
					

				}
			})

		    
		}
	})

})

/*=====  End of ELIMINAR USUARIO DASHBOARD  ======*/