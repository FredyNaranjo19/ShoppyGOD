let prevUrl = document.referrer;

/*===================================================
=            INICIAR SESION CON FACEBOOK            =
===================================================*/

$(document).on("click", ".btnGoogleSesion", function(){

	var provider = new firebase.auth.GoogleAuthProvider();
	firebase.auth()
		.signInWithPopup(provider)
		.then(function(result) {
			guardarDatosGoogle(result.user);
			// $("#root").append('<img src="'+result.user["photoURL"]+'">');
		})

})


function guardarDatosGoogle(user){

	var empresa = $("#ingEmpresa").val();

	var datos = new FormData();
	datos.append("gmailEmpresa", empresa);
	datos.append("gmailNombre", user.displayName);
	datos.append("gmailEmail", user.email);
	datos.append("gmailFoto", user.photoURL);
	datos.append("gmailTelefono", user.phoneNumber);

	$.ajax({
		url: "../items/mvc/ajax/tv/clientes.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			swal({
				type:'success',
				title: 'Bienvenido '+user.displayName+'!!',
				showConfirmButton: true,
				confirmButtonText: 'Cerrar',
				closeOnConfirm: false
				}).then((result)=>{
					if(result.value){
						 // window.location='inicio';

						if(prevUrl.indexOf(window.location.host) !== -1) {
						    // Ir a la página anterior
						    window.history.back();
						} else {
							window.location='inicio'
						}
				}
			});

		}
	})
}

/*=====  End of INICIAR SESION CON FACEBOOK  ======*/




/*===================================================
=            INICIAR SESION CON FACEBOOK            =
===================================================*/

$(document).on("click", ".btnFacebookSesion", function(){

	var provider = new firebase.auth.FacebookAuthProvider();
	firebase.auth()
		.signInWithPopup(provider)
		.then(function(result) {
			console.log(result);
			guardarDatosFacebook(result.user);
			// $("#root").append('<img src="'+result.user["photoURL"]+'">');
		})

})


function guardarDatosFacebook(user){

	var empresa = $("#ingEmpresa").val();

	var datos = new FormData();
	datos.append("facebookEmpresa", empresa);
	datos.append("facebookNombre", user.displayName);
	datos.append("facebookEmail", user.email);
	datos.append("facebookFoto", user.photoURL);
	datos.append("facebookTelefono", user.phoneNumber);

	$.ajax({
		url: "../items/mvc/ajax/tv/clientes.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			swal({
				type:'success',
				title: 'Bienvenido '+user.displayName+'!!',
				showConfirmButton: true,
				confirmButtonText: 'Cerrar',
				closeOnConfirm: false
				}).then((result)=>{
					if(result.value){
						 // window.location='inicio';

						if(prevUrl.indexOf(window.location.host) !== -1) {
						    // Ir a la página anterior
						    window.history.back();
						} else {
							window.location='inicio'
						}
				}
			});

		}
	})
}

/*=====  End of INICIAR SESION CON FACEBOOK  ======*/

/*==================================================================
=            VERIFICAR EXISTENCIA DE CORREO ELECTRONICO            =
==================================================================*/

$(document).on("change", "#nCorreoCliente", function(){

	var mail = $(this).val();
	var idEmpresa = $("#nEmpresaCliente").val();

	var datos = new FormData();
	datos.append("mailRegistroTienda", mail);
	datos.append("idEmpresaRegistroTienda", idEmpresa);

	$.ajax({
		url: "../items/mvc/ajax/tv/clientes.ajax.php", 
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json", 
		success: function(respuesta){
			
			if (respuesta != false) {

				swal({
					type:'error',
					title: 'Ya existe un usuario con este correo electronico!',
					showConfirmButton: true,
					confirmButtonText: 'Cerrar',
					closeOnConfirm: false
					});

				$("#nCorreoCliente").val("");

			}
		}
	})

})

/*=====  End of VERIFICAR EXISTENCIA DE CORREO ELECTRONICO  ======*/

/*===========================================================
=            PASSWORD VERIFICACION AUTENTICACION            =
===========================================================*/

$(document).on("change", "#nPassClienteVerificar", function(){

	var rePass = $(this).val();
	var pass = $("#nPassCliente").val();

	if (rePass != pass) {

		swal({
			type:'error',
			title: 'El password no coincide, escribelo de nuevo!',
			showConfirmButton: true,
			confirmButtonText: 'Cerrar',
			closeOnConfirm: false
		});

		$("#nPassClienteVerificar").val("");

	}
})

/*=====  End of PASSWORD VERIFICACION AUTENTICACION  ======*/

/*=========================================
=            REGISTRAR CLIENTE            =
=========================================*/

$(document).on("submit", "#formRegistroTienda", function(e){
	e.preventDefault();

	var id = $("#nEmpresaCliente").val();
	var nombre = $("#nNombreCliente").val();
	var usuario = $("#nUsuarioCliente").val();
	var email = $("#nCorreoCliente").val();
	var telefono = $("#ntelCliente").val();
	var password = $("#nPassCliente").val();

	var datos = new FormData();
	datos.append("idEmpresaCrearCliente", id);
	datos.append("nombreCrearCliente", nombre);
	datos.append("usuarioCrearCliente", usuario);
	datos.append("emailCrearCliente", email);
	datos.append("telefonoCrearCliente", telefono);
	datos.append("passwordCrearCliente", password);

	$.ajax({
		url: "../items/mvc/ajax/tv/clientes.ajax.php",  
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
			
			if (respuesta == "caracter") {

				swal({
					type:'error',
					title: 'Los campos nombre o email no pueden recibir caracteres especiales!',
					showConfirmButton: true,
					confirmButtonText: 'Cerrar',
					closeOnConfirm: false
				});

			} else if (respuesta == 'ok') {

				swal({
					type:'success',
					title: 'Bienvenido '+nombre+'!',
					showConfirmButton: true,
					confirmButtonText: 'Cerrar',
					closeOnConfirm: false
				}).then((result)=>{
					if(result.value){
						
						window.location='inicio';

					}
				});

			}

		}
	})

})

/*=====  End of REGISTRAR CLIENTE  ======*/