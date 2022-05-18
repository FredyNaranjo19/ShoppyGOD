$(document).ready(function(){

	btndisabledPagar();
});

/*============================================
=            CAMBIAR DE DIRECCION            =
============================================*/

$(document).on("change", "#direccionesCliente", function(){
	var sel = $(this).val();
	var datos =  new FormData();
	datos.append("idDireccion", sel);

	window.location = 'index.php?ruta=proccess&dir=dir-'+sel;
})

/*=====  End of CAMBIAR DE DIRECCION  ======*/

/*============================================
=            SELECCIONAR SUCURSAL            =
============================================*/

$(document).on("change","#sucursalSel", function(){

	var sel = $(this).val();

	window.location = 'index.php?ruta=proccess&dir=suc-'+sel;
})

/*=====  End of SELECCIONAR SUCURSAL  ======*/

$(document).on("click",".btnNuevaDireccion", function(){

	$(".btnNuevaDireccion").prop("disabled","disabled");
	$(".info-DireccionNinguno").hide();
	$(".info-DireccionFormulario").show("slow");

})

$(document).on("click",".btnCerrarFormDirec",function(){

	$(".btnNuevaDireccion").prop("disabled",false);
	$(".info-DireccionNinguno").show();
	$(".info-DireccionFormulario").hide("slow");

})

$(document).on("click", "#CambioDireccion", function(){

	var valor = $(this).attr("valor");
	

	if (valor == 0) {
		$(".Direcciones").show("slow");
		$(this).attr("valor",1);
	}else{
		$(".Direcciones").hide("slow");
		$(this).attr("valor",0);
	}
	
})

/*====================================================
=            CARGAR TIPO DE PAGO EN INPUT            =
====================================================*/

$(document).on("click","#headingOne",function(){

	$("#TipoPago").val("Efectivo");
})


$(document).on("click","#headingTwo",function(){

	$("#TipoPago").val("Tarjeta");
})

/*=====  End of CARGAR TIPO DE PAGO EN INPUT  ======*/

$(document).on("change","#idDireccionInfo",function(){

	if ($(this).val() != "" && $("#ExistenciaTel").val() == "1") {

		$(".btnPagoProcess").prop("disabled",false);	

	}else{

		$(".btnPagoProcess").prop("disabled","disabled");	

	}
})


function btndisabledPagar(){

	if ($("#idDireccionInfo").val() != "" && $("#ExistenciaTel").val() == "1") {


		$(".btnPagoProcess").prop("disabled",false);

	}else{

		$(".btnPagoProcess").prop("disabled","disabled");	

	}
}


/*=============================================================
=            GUARDAR NUMERO TELEFONICO DEL CLIENTE            =
=============================================================*/

$(document).on("click", ".btnGuardarTelefono", function(){

	var telefono = $("#telefonoAgregarCliente").val();
	var idCliente = $("#idAgregarCliente").val();

	if (telefono != "") {
		var datos = new FormData();
		datos.append("GuardarTelefonoCliente", telefono);
		datos.append("GuardarTelefonoClienteId", idCliente);

		$.ajax({
			url:'../items/mvc/ajax/tv/clientes.ajax.php',
			method:"POST",
			data:datos,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success:function(respuesta){


				swal({
					type:'success',
					title: 'Teléfono guardado correctamente',
					showConfirmButton: true,
					confirmButtonText: 'Cerrar',
					closeOnConfirm: false
					}).then((result)=>{
						if(result.value){
							
							$("#ExistenciaTel").val("1");
							// btndisabledPagar();
							location.reload();
					}
				});

				

			}

		})

	} else {

		alert("Introduce un numero telefonico");

	}

})

/*=====  End of GUARDAR NUMERO TELEFONICO DEL CLIENTE  ======*/

/*================================================
=            FORM DE PAGO DE EFECTIVO            =
================================================*/

$(document).on("submit", "#formPagoEfectivo", function(e){
	e.preventDefault();

	var Empresa = $("#ProccessEmpresa").val();
	var Total = $("#ProcessTotal").val();
	var Direccion = $("#idDireccionInfo").val();
	var Pago = $("#TipoPago").val();
	var Card = $("#ProcessCard").val();

	var datos = new FormData();
	datos.append("empresaPago", Empresa);
	datos.append("totalPago", Total);
	datos.append("direccionPago", Direccion);
	datos.append("tipoPago", Pago);
	datos.append("cardPago", Card);


	$.ajax({
		url:'../items/mvc/ajax/tv/pagos.ajax.php',
		method:"POST",
		data:datos,
		cache: false,
		contentType: false, 
		processData: false, 
		dataType: "json",
		success:function(respuesta){

			console.log(respuesta);

			if (respuesta != "error") {

				window.open(GlobalURL+'items/extensiones/TCPDF-master/pdf/deposito.php?emp='+Empresa+'&&m0n='+Total+'&&f01i0='+respuesta+'&&t47='+Card);

				window.location='index.php?ruta=successful&folfo='+respuesta;

			}

		}
	})

})

/*=====  End of FORM DE PAGO DE EFECTIVO  ======*/


/*============================================
=            ANOTACION DEL PEDIDO            =
============================================*/

$(document).on("click",".btnGuardarAnotaciones",function(){

	var nota = $("#AnotacionPedido").val();
	var folioNota = $(".folioAnotacionPedido").val();

	var datos = new FormData();
	datos.append("folioNota",folioNota);
	datos.append("nota",nota);

	$.ajax({
		url:'../items/mvc/ajax/tv/pedidos.ajax.php',
		method:"POST",
		data:datos,
		cache: false,
		contentType: false, 
		processData: false,
		dataType: "json",
		success:function(respuesta){
			
			if (respuesta == "ok") {
				swal({
					type:'success',
					title: 'Nota guardada correctamente',
					showConfirmButton: true,
					confirmButtonText: 'Cerrar',
					closeOnConfirm: false
					}).then((result)=>{
						if(result.value){
							 $("#AnotacionPedido").val('');
					}
				});
			}

		}
	})
})

/*=====  End of ANOTACION DEL PEDIDO  ======*/
