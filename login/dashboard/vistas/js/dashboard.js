$(document).ready(function(){

	
	ActualizacionNotificacionesMenu();
	setInterval(ActualizacionNotificacionesMenu, 10000);
	

});


/*=============================================
=                 Data Table                  =
=============================================*/

$('.tablas').DataTable({
	"language":{
	    "sProcessing":     "Procesando...",
	    "sLengthMenu":     "Mostrar _MENU_ registros",
	    "sZeroRecords":    "No se encontraron resultados",
	    "sEmptyTable":     "Ningún dato disponible en esta tabla",
	    "sInfo":           "Viendo del _START_ al _END_ de un total de _TOTAL_",
	    "sInfoEmpty":      "Viendo del 0 al 0 de un total de 0",
	    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	    "sInfoPostFix":    "",
	    "sSearch":         "Buscar:",
	    "sUrl":            "",
	    "sInfoThousands":  ",",
	    "sLoadingRecords": "Cargando...",
	    "oPaginate": {
	        "sFirst":    "Primero",
	        "sLast":     "Último",
	        "sNext":     "Siguiente",
	        "sPrevious": "Anterior"
	    },
	    "oAria": {
	        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	    }
	}

});

/*================================
=            SELECT 2            =
================================*/

$('.select2').select2({
	theme: 'bootstrap4'
});



//Money Euro
$('[data-mask]').inputmask();


function ActualizacionNotificacionesMenu(){

	/* OBTENIENDO EL NUMERO DE PEDIDOS ACTUALES
	-------------------------------------------------- */
	
	var menuVentas = $(".menuVentas").text();
	var menuPorValorar = $(".menuPorValorar").text();
	var menuEnPreparacion = $(".menuEnPreparacion").text();
	var menuEnGuia = $(".menuEnGuia").text();
	var menuListoSucursal = $(".menuListoSucursal").text();
	// var menuEnviado = $(".menuEnviado").text();
	var menuSinComprobante = $(".menuSinComprobante").text();
	
	/* End of OBTENIENDO EL NUMERO DE PEDIDOS ACTUALES
	-------------------------------------------------- */
	
	var tipoUsuario = $(".inputTipoUsuario").val();

	if (tipoUsuario == "Cedis") {

		let datos = new FormData();

		datos.append("empresa",1)
		$.ajax({
			url: '../dashboard/vistas/modulos/fix/peticiones-lateral.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json", 
			success: function(respuesta){
				//console.log(respuesta);

				if (respuesta["total"] > 0) {
					$(".menuNotiLink").html('<i style="color: #00b4d8ff; size: 7x;" class="fas fa-circle"></i>');
				}
	
				/* ASIGNAR LOS VALORES DE respuesta AL MENU LATERAL */

				$(".menuVentas").html(respuesta["total"]);
				$(".menuPorValorar").html(respuesta["porValorar"]);
				$(".menuEnPreparacion").html(respuesta["enPreparacion"]);
				$(".menuEnGuia").html(respuesta["enGuia"]);
				$(".menuListoSucursal").html(respuesta["enSucursal"]);
				$(".menuEnviado").html(respuesta["enviado"]);
				$(".menuSinComprobante").html(respuesta["sinComprobante"]);
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuVentas.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["total"] !== parseInt(menuVentas)) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
					}
				}

				
				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuPorValorar.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["porValorar"].toString() !== menuPorValorar) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("por valorar");
						$(".spanPorValorar").html(respuesta["porValorar"]);
					}
				}
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuEnPreparacion.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["enPreparacion"].toString() !== menuEnPreparacion) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("en preparacion");
						$(".spanEnPreparacion").html(respuesta["enPreparacion"]);
					}
				}
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuEnGuia.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["enGuia"].toString() !== menuEnGuia) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("en guía");
						$(".spanEnGuia").html(respuesta["enGuia"]);
					}
				}
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuListoSucursal.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["enSucursal"].toString() !== menuListoSucursal) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("en Sucursal");
						$(".spanEnSucursal").html(respuesta["enSucursal"]);
					}
				}
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				// if (!menuEnviado.trim()) {
				// }else{
				// 	/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
				// 	if (respuesta["enviado"].toString() !== menuEnviado) {
				// 		/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
				// 		MandarNotificacion("enviados");
				// 	}
				// }
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuSinComprobante.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["sinComprobante"].toString() !== menuSinComprobante) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("sin comprobante");
						$(".spanSinComprobante").html(respuesta["sinComprobante"]);
					}
				}
				
			}
		})
		
	}else if (tipoUsuario == "Vendedor Cedis") {
		let datos = new FormData();

		datos.append("vendedorCedis",1)
		$.ajax({
			url: '../dashboard/vistas/modulos/fix/peticiones-lateral.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json", 
			success: function(respuesta){
				// console.log(respuesta);

				if (respuesta["total"] > 0) {
					$(".menuNotiLink").html('<i style="color: #00b4d8ff; size: 7x;" class="fas fa-circle"></i>');
					
				}

				$(".menuVentas").html(respuesta["total"]);
				$(".menuEnPreparacion").html(respuesta["enPreparacion"]);
				$(".menuEnGuia").html(respuesta["enGuia"]);
				$(".menuListoSucursal").html(respuesta["enSucursal"]);


				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuEnPreparacion.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["enPreparacion"].toString() !== menuEnPreparacion) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("en preparacion");
						$(".spanEnPreparacion").html(respuesta["enPreparacion"]);
					}
				}
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuEnGuia.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["enGuia"].toString() !== menuEnGuia) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("en guía");
						$(".spanEnGuia").html(respuesta["enGuia"]);
					}
				}
				

				/* REVISA QUE EL VALOR DE LA VARIABLE NO ESTE VACIA DEVUELVE UN true SI ESTA VACIA*/
				if (!menuListoSucursal.trim()) {
				}else{
					/* SI LA VARIABLE TIENE UN VALOR COMPARA EL VALOR CON LA VARIABLE respuesta */
					if (respuesta["enSucursal"].toString() !== menuListoSucursal) {
						/* SI LAS VARIABLES SON DIFERENTES ACTIVA LA NOTIFICACION */
						MandarNotificacion("en Sucursal");
						$(".spanEnSucursal").html(respuesta["enSucursal"]);
					}
				}
			}
		})
	}

}

function MandarNotificacion(venta){
	
	toastr.success("Hay cambios en pedidos " +venta);
	
}


