var noCaracteristica = 0;
var noEditarCaracteristica = 0;
var noDerivadoCaracteristica = 0;

/*==================================================
=            MOSTRAR TABLA DE PRODUCTOS            =
==================================================*/

$(document).ready(function() {
var pantalla = $(window).width();
var opcion = 1;
if (parseFloat(pantalla) > 540) {

	tablaProductos = $('#tablaProductos').DataTable({  
		"responsive": false,
		"pagingType": "simple",
		"dom": 'Bfrtip',
        "buttons": [
            {
                extend:'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                tittleAttr: 'Exportar a Excel',
                className: 'btn-success',
                title: 'Productos'

            },
            {
                extend:'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i>',
                tittleAttr: 'Exportar a PDF',
                className: 'btn-danger',
                title: 'Productos'

            }
        ],
		"language":{
		    "sProcessing":     "Procesando...",
		    "sLengthMenu":     "Mostrar _MENU_ ",
		    "sZeroRecords":    "No se encontraron resultados",
		    "sEmptyTable":     "Ningún dato disponible en esta tabla",
		    "sInfo":           "_START_ al _END_ de un total de _TOTAL_",
		    "sInfoEmpty":      "0 al 0 de un total de 0",
		    "sInfoFiltered":   "(filtrado de un total de _MAX_ )",
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
		},
	    "ajax":{            
	        "url": "../items/mvc/ajax/dashboard/productos.ajax.php", 
	        "method": 'POST',
	        "data":{opcion:opcion},
	        "dataSrc":""
	    },
	    "columns":[
	    	{"data": "codigo"},
	        {"data": "nombre"},
	        {"data": "descripcion"},
			{"data": "stock_disponible",
				sortable: false,
				render: function(data){
					if (data == "0") {
						return "agotado";
					}else{
						return data;
					}
				}
			    
			},
	        {
	        	sortable: false,
	        	"render":function ( data, type, full, meta ) {
                    var idProducto = full.id_producto;
                    var codigo = full.codigo;
                    var sku = full.sku;
                    return '<div class="btn-group"><button class="btn btn-info btnDetalle" idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'"><i class="fa fa-eye"></i></button></div>'+
					'<div class="btn-group"><button style="margin:0.1rem" class="btn btn-danger btnDel" idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'"><i class="fas fa-trash-alt"></i></button></div>';
                 }
            }

	    ] 

	}); 


} else {

	tablaProductos = $('#tablaProductos').DataTable({  
		"responsive": true,
		"pagingType": "simple",
		"dom": 'Bfrtip',
		"buttons": [
            {
                extend:'excelHtml5',
                text: '<i class="fas fa-file-excel"></i>',
                tittleAttr: 'Exportar a Excel',
                className: 'btn-success',
                title: 'Productos'

            },
            {
                extend:'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i>',
                tittleAttr: 'Exportar a PDF',
                className: 'btn-danger',
                title: 'Productos'

            }
        ],
		"language":{
		    "sProcessing":     "Procesando...",
		    "sLengthMenu":     "Mostrar _MENU_ ",
		    "sZeroRecords":    "No se encontraron resultados",
		    "sEmptyTable":     "Ningún dato disponible en esta tabla",
		    "sInfo":           "_START_ al _END_ de un total de _TOTAL_",
		    "sInfoEmpty":      "0 al 0 de un total de 0",
		    "sInfoFiltered":   "(filtrado de un total de _MAX_ )",
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
		},
	    "ajax":{            
	        "url": "../items/mvc/ajax/dashboard/productos.ajax.php", 
	        "method": 'POST',
	        "data":{opcion:opcion},
	        "dataSrc":""
	    },
	    "columns":[
	    	{"data": "codigo"},
	        {"data": "nombre"},
	        {"data": "descripcion"},
			{"data": "stock_disponible"},
	        {
	        	sortable: false,
	        	"render":function ( data, type, full, meta ) {
                    var idProducto = full.id_producto;
                    var codigo = full.codigo;
                    var sku = full.sku;

                    return '<div class="btn-group"><button class="btn btn-info btnDetalle" idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'"><i class="fa fa-eye"></i></button></div>'+
					'<div class="btn-group"><button style="margin:0.1rem" class="btn btn-danger btnDel" idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'"><i class="fas fa-trash-alt"></i></button></div>';
                 }
            }
	    ],
	    "columnDefs": [
	    	{ responsivePriority: 1, "targets": 0},
	    	{ responsivePriority: 2, "targets": 1}
		]
	});
}
}); 

/*=====  End of MOSTRAR TABLA DE PRODUCTOS  ======*/
/*==================================================
=     MOSTRAR TABLA DE PRODUCTOS  PAPELERA         =
==================================================*/

$(document).ready(function() {
	var pantalla = $(window).width();
	var opcion = 1;
	if (parseFloat(pantalla) > 540) {
	
		tablaProductospapelera = $('#tablaProductospapelera').DataTable({  
			"responsive": false,
			"language":{
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ ",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "_START_ al _END_ de un total de _TOTAL_",
				"sInfoEmpty":      "0 al 0 de un total de 0",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ )",
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
			},
			"ajax":{            
				"url": "../items/mvc/ajax/dashboard/productos.ajax.php", 
				"method": 'POST',
				"data":{opcion2:opcion},
				"dataSrc":""
			},
			"columns":[
				{"data": "codigo"},
				{"data": "nombre"},
				{"data": "descripcion"},
				{"data": "stock_disponible"},
				{
					sortable: false,
					"render":function ( data, type, full, meta ) {
						var idProducto = full.id_producto;
						var codigo = full.codigo;
						var sku = full.sku;
						return '<div class="btn-group"><button class="btn btn-info btnrecy" idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'"><i class="fas fa-recycle"></i></button></div>';
					 }
				}
	
			] 
	
		}); 
	
	
	} else {
	
		tablaProductospapelera = $('#tablaProductospapelera').DataTable({  
			"responsive": true,
			"language":{
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ ",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "_START_ al _END_ de un total de _TOTAL_",
				"sInfoEmpty":      "0 al 0 de un total de 0",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ )",
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
			},
			"ajax":{            
				"url": "../items/mvc/ajax/dashboard/productos.ajax.php", 
				"method": 'POST',
				"data":{opcion2:opcion},
				"dataSrc":""
			},
			"columns":[
				{"data": "codigo"},
				{"data": "nombre"},
				{"data": "descripcion"},
				{"data": "stock_disponible"},
				{
					sortable: false,
					"render":function ( data, type, full, meta ) {
						var idProducto = full.id_producto;
						var codigo = full.codigo;
						var sku = full.sku;
	
						return '<div class="btn-group"><button class="btn btn-info btnrecy" idProducto="'+idProducto+'" sku="'+sku+'" codigo="'+codigo+'"><i class="fas fa-recycle"></i></button></div>';
					 }
				}
			],
			"columnDefs": [
				{ responsivePriority: 1, "targets": 0},
				{ responsivePriority: 2, "targets": 1}
			]
		});
	}
	}); 
	
	/*=====  End of MOSTRAR TABLA DE PRODUCTOS PAPELERA  ======*/



/*============================================================================
=            --------------- CODIGO PARA PRODUCTOS --------------            =
============================================================================*/

	//  funcion crear numero aleatorio para el producto
	function NumeroAleatorioCrear(min, max) {

		var num = Math.round(Math.random() * (max - min) + min);
		$('#aleatorio').val(num);
		$('#ProductodAleatorio').val(num);

	}
	
	/*==================================================
	=            BOTON CREAR NUEVO PRODUCTO            =
	==================================================*/

	$(document).on("click", ".btnNewProducto", function(){
		noCaracteristica = 0;
		NumeroAleatorioCrear(100, 1000000);
		$(".nCaracteristica").html("");
		funcionForEach();

	})

	/*=====  End of BOTON CREAR NUEVO PRODUCTO  ======*/
	
	/*==================================================
	=            VERIFICACION DE CARACTERES            =
	==================================================*/

	$('#ProductonModelo').bind('keyup input',function()
	{       
	   if (this.value.match(/[^a-zA-Z0-9--]/g)) 
	   {
	       this.value = this.value.replace(/[^a-zA-Z0-9--]/g, '');
	   }
	});

	/*=====  End of VERIFICACION DE CARACTERES  ======*/

	/*=============================================================
	=            VERIFICACION DE EXISTENCIA DEL MODELO            =
	=============================================================*/
	
	$(document).on("change", "#ProductonModelo", function(){
	
		var codigo = $(this).val();

		var datos = new FormData();
		datos.append("existenciaModeloProducto", codigo);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				if (respuesta.length != 0) {

					Swal.fire(
					  'Este modelo ya existe.',
					  'crea un derivado de este modelo.',
					  'error'
					)
					$("#ProductonModelo").val("");
				}
			}
		})
	})
	
	/*=====  End of VERIFICACION DE EXISTENCIA DEL MODELO  ======*/
	

	/*========================================
	=            GUARDAR PRODUCTO            =
	========================================*/
		
	$(document).on("submit", "#formCrearProducto", function(e){
		e.preventDefault();

		var modelo = $("#ProductonModelo").val();
		var aleatorio = $("#aleatorio").val();
		var nombre = $("#ProductonNombre").val();
		var descripcion = $("#ProductonDescripcion").val();
		var stock = $("#ProductonStock").val();
		var costo = $("#ProductonCosto").val();
		var precioSugerido = $("#ProductoPrecioSugerido").val();
		var precio = $("#ProductonPrecio").val();
		var caracteristicas = $("#listaAgregado").val();
		var medidas = [{
						"largo" : $("#ProductonMedidasLargo").val(),
						"ancho"  : $("#ProductonMedidasAncho").val(),
						"alto" : $("#ProductonMedidasAlto").val()
						}];

		medidas = JSON.stringify(medidas);

		var peso = $("#ProductonPeso").val();
		if(peso == ""){
			peso = 0;
		}
		var factura = $("#ProductonFactura").val();
		var proveedor = $("#ProductonProveedor").val();

		var claveProdSer = $("#ProductonClaveProdServ").val();
		var claveUnidad = $("#ProductonClaveUnidad").val();



		var datos = new FormData();
		datos.append("productoCrearModelo", modelo);
		datos.append("productoCrearAleatorio", aleatorio);
		datos.append("productoCrearNombre", nombre);
		datos.append("productoCrearDescripcion", descripcion);
		datos.append("productoCrearStock", stock);
		datos.append("productoCrearCosto", costo);
		datos.append("productoCrearPrecioSugerido", precioSugerido);
		datos.append("productoCrearPrecio", precio);
		datos.append("productoCrearCaracteristicas", caracteristicas);
		datos.append("productoCrearMedidas", medidas);
		datos.append("productoCrearPeso", peso);
		datos.append("productoCrearFactura", factura);
		datos.append("productoCrearProveedor", proveedor);
		datos.append("productoCrearClaveProdServ", claveProdSer);
		datos.append("productoCrearClaveUnidad", claveUnidad);

		// console.log("productoCrearModelo: "+ modelo);
		// console.log("productoCrearAleatorio: "+ aleatorio);
		// console.log("productoCrearNombre: "+ nombre);
		// console.log("productoCrearDescripcion: "+ descripcion);
		// console.log("productoCrearStock: "+ stock);
		// console.log("productoCrearCosto: "+ costo);
		// console.log("productoCrearPrecio: "+ precio);
		// console.log("productoCrearCaracteristicas", caracteristicas);
		// console.log("productoCrearMedidas: "+ medidas);
		// console.log("productoCrearPeso: "+ peso);
		// console.log("productoCrearFactura: "+ factura);
		// console.log("productoCrearProveedor: "+ proveedor);
		// console.log("productoCrearClaveProdServ: "+ claveProdSer);
		// console.log("productoCrearClaveUnidad: "+ claveUnidad);
		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				console.log(respuesta);
				toastr.success('Producto creado exitosamente!');
				tablaProductos.ajax.reload(null, false);
			}
		});

		$("#formCrearProducto").trigger("reset");
		$(".nCaracteristica").html("");
		$("#listaAgregado").val("");
		$('#modalAgregarProducto').modal('hide');	

	})

	/*=====  End of GUARDAR PRODUCTO  ======*/


	/*=====================================================
	=            MOSTRAR DETALLES DEL PRODUCTO            =
	=====================================================*/
	
	$(document).on("click", "button.btnDetalle", function(){

		$("#formNuevoLote").hide();
		noEditarCaracteristica = 0;
		noDerivadoCaracteristica = 0;
		$("#caracteristicasEditar").html("");
		$("#ProductoeMedidasLargo").html("");
		$("#ProductoeMedidasAncho").html("");
		$("#ProductoeMedidasAlto").html("");
		$("#ProductoePeso").html("");
		$("#ProductoeClaveProdServ").val("");
		$('#ProductoeClaveUnidad option:selected').removeAttr("selected");

		$('#modalMostrarInfo').modal('show');
		

  		var idInfo = $(this).attr("idProducto");
    	var codigo = $(this).attr("codigo");	
    	var sku = $(this).attr("sku");

		/* INFORMACION GENERAL DEL PRODUCTO */

		var datos = new FormData();
		datos.append("idInfo", idInfo);	

			$.ajax({
				url: '../items/mvc/ajax/dashboard/productos.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					// console.log(respuesta);

					$(".btnEditarInformacionProducto").attr("ideProducto", respuesta['id_producto']);
					$(".btnEditarImagenesProducto").attr("ideProducto", respuesta['id_producto']);
					$("#ProductoeModelo").val(respuesta['codigo']);
					$("#ProductoeNombre").val(respuesta['nombre']);
					$("#ProductoeDescripcion").val(respuesta['descripcion']);

					var separado = respuesta["sku"].split("-");

					$("#eProductoEmpresa").val(separado[0]);
					$("#eProductoAleatorio").val(separado[2]);


					// $("#stockProductoGeneral").val(respuesta["stock"]); //// no
					// $("#stockProductoGeneral").attr("dispon",respuesta["stock_disponible"]); /// no
					$(".btnNuevoLote").attr("sku", respuesta["sku"]);
					$(".btnNuevoLote").attr("cod", respuesta["codigo"]);
					$(".btnMostrarTodosLotes").attr("sku", respuesta["sku"]);
					$(".btnNuevoListado").attr("modelo", respuesta["codigo"]);
					$(".btnModalDerivado").attr("idProducto",idInfo);
					$(".btnEliminarProducto").attr("idProducto",idInfo);

					listaAgregadoEditar();


					$("#ProductoeClaveProdServ").val(respuesta["sat_clave_prod_serv"]);
					$("#ProductoeClaveUnidad option[value="+ respuesta["sat_clave_unidad"] +"]").attr("selected",true);

				}
			})
			// console.log("Caracteristicas");

		/* INFORMACION DE CARACTERISTICAS DEL PRODUCTO */
			
		var datos = new FormData();
		datos.append("idInfoCaracteristicas", idInfo);	

			$.ajax({
				url: '../items/mvc/ajax/dashboard/productos.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					for (var i = 0; i < respuesta.length; i++) {
						noEditarCaracteristica++;
						
						$("#caracteristicasEditar").append(
							'<div class="row divCarecContenido" style="margin-bottom: 5px;">'+
								'<div class="col-xs-12 col-lg-6">'+
									'<div class="input-group">'+
									  '<div class="input-group-prepend">'+
						                '<span class="input-group-text">'+
						                  '<button type="button" class="btn btn-danger btn-xs quitarECaract" idPaquete><i class="fa fa-times"></i></button>'+
						                '</span>'+
						              '</div>'+
						              '<select class="form-control selectECaract input-lg" id="eCaracteristica'+noEditarCaracteristica+'" no="'+noEditarCaracteristica+'" required>'+
						              	'<option value="'+respuesta[i]["caracteristica"]+'">'+respuesta[i]["caracteristica"]+'</option>'+
						              	'<option disabled>Selecciona la Carateristica</option>'+
						              '</select>'+
						            '</div>'+
								'</div>'+
								'<div class="col-xs-12 col-lg-6 divDato">'+
						             '<input type="'+respuesta[i]["tipoCaracteristica"]+'" class="form-control inputECaract input-lg" value="'+respuesta[i]["datoCaracteristica"]+'"/>'+
								'</div>'+
							'</div>');


					}

					funcionForEachEditar();
					listaAgregadoEditar();
				}
			})

		/* INFORMACION DE DATOS DE ENVIO */
		// console.log("envio");
		var datos = new FormData();
		datos.append("idInfoDatosEnvio", idInfo);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				// console.log(respuesta);

				$("#ProductoeMedidasLargo").val(respuesta["medidas"][0]["largo"]);
				$("#ProductoeMedidasAncho").val(respuesta["medidas"][0]["ancho"]);
				$("#ProductoeMedidasAlto").val(respuesta["medidas"][0]["alto"]);

				$("#ProductoePeso").val(respuesta["peso"]);

				funcionForEachEditar();
				listaAgregadoEditar();
			}
		})	

		/* INFORMACION SOBRE LOTES DEL PRODUCTO */
			
		var datosLotes = new FormData();
		datosLotes.append("skuLotes", sku);
		var contenidoLotes = "";

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datosLotes,
			cache: false, 
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				// console.log(respuesta)
				for (var i = 0; i < respuesta.length; i++) {
					if (i <= 2) {
						if (i == 0 ) {
							$("#infoLoteProducto").attr("costo_ant", respuesta[i]["costo_prom_ant"]);
							$("#infoLoteProducto").attr("stock_ant", respuesta[i]["stock_ant_disp"]);
							$("#infoLoteProducto").attr("fecha", respuesta[i]["fecha"]);
							$("#infoLoteProducto").attr("cant", respuesta[i]["cantidad"]);
	
							contenidoLotes = contenidoLotes.concat("<tr>"+
																"<td id='ocultarTDfecha'>"+respuesta[i]['fecha']+"</td>"+
																"<td>"+respuesta[i]['proveedor']+"</td>"+
																// "<td>"+respuesta[i]['costo']+"</td>"+
																"<td id='tdCosto'>"+
																	"<input type='text' id='inputCostoEditCedis' costoLote="+respuesta[i]['costo']+" value='"+respuesta[i]['costo']+"' style='width: 80px;'>"+
																"</td>"+
																"<td id='tdStock'>"+
																	"<input type='text' id='inputStock' stockLote='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 50px;'>"+
																"</td>"+
																"<td>"+
																	"<div class='input-group-prepend'>"+
																	  "<button type='button' class='btn btn-warning btnSaveLoteCedis' idLote='"+respuesta[i]['id_lote']+"' sku='"+respuesta[i]['sku']+"'>"+
																		"<i class='far fa-save'></i>"+
																	  "</button>"+
																	  "<button type='button' class='btn btn-danger btnTrashLoteCedis' idLote='"+respuesta[i]['id_lote']+"' sku='"+respuesta[i]['sku']+"'>"+
																		"<i class='fas fa-trash-alt'></i>"+
																	  "</button>"+
																	"</div>"+
																"</td>"+
															"</tr>");
						}else{
							contenidoLotes = contenidoLotes.concat("<tr>"+
																"<td id='ocultarTDfecha'>"+respuesta[i]['fecha']+"</td>"+
																"<td>"+respuesta[i]['proveedor']+"</td>"+
																"<td>"+respuesta[i]['costo']+"</td>"+
																"<td id='tdStock'>"+
																	"<input type='text' id='inputStock' stockLote='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 50px;' readonly>"+
																"</td>"+
																"<td>"+
																	
																"</td>"+
															"</tr>");
						}
						
						
					}
				}
				
				$("#bodyLotes").html(contenidoLotes);
			}
		})

		/* INFORMACION DEL LISTADO DE PRECIOS DEL PRODUCTO */
			
		var datosListado = new FormData();
		datosListado.append("ProductoCodigoListado", codigo);
		var contenidoListadoUnitario = ''; 
		var contenidoListado = '';

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datosListado,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				for (var i = 0; i < respuesta.length; i++) {

					if (i == 0) {
						contenidoListadoUnitario = contenidoListadoUnitario.concat("<tr>"+
													"<td id='tdCantidad'>"+
														"<input type='text' id='inputCantidad' stockListado='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' readonly style='width: 100%;'>"+
													"</td>"+
													"<td id='tdPrecio'>"+
														"<input type='text' id='inputPrecio' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
													"</td>"+
													"<td id='tdPromo'>"+
														"<input type='text' id='inputPrecioPromo' precioPromoListado='"+respuesta[i]['promo']+"' value='"+respuesta[i]['promo']+"' style='width: 100%;'>"+
													"</td>");

						if (respuesta[i]['activadoPromo'] == "si") {

							contenidoListadoUnitario = contenidoListadoUnitario.concat("<td id='tdPromo'>"+
														"<input type='checkbox' id='checkPromo' checked>"+
													"</td>");

						}else{
					
							contenidoListadoUnitario = contenidoListadoUnitario.concat("<td id='tdPromo'>"+
														"<input type='checkbox' id='checkPromo'>"+
													"</td>");

						}	

						contenidoListadoUnitario = contenidoListadoUnitario.concat("<td>"+
														"<div class='input-group-prepend'>"+
								                          "<button type='button' class='btn btn-warning btnSaveListadoUnitario' idListado='"+respuesta[i]['id_listado']+"' modelo='"+respuesta[i]['modelo']+"' can='"+respuesta[i]['cantidad']+"'>"+
								                            "<i class='far fa-save'></i>"+
								                          "</button>"+
								                        "</div>"+
													"</td>"+
												"</tr>");
					} else {

						contenidoListado = contenidoListado.concat("<tr>"+
													"<td id='tdCantidad'>"+
														"<input type='text' id='inputCantidad' stockListado='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 100%;'>"+
													"</td>"+
													"<td id='tdPrecio'>"+
														"<input type='text' id='inputPrecio' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
													"</td>"+
													
													"<td>"+
														"<div class='input-group-prepend'>"+
								                          "<button type='button' class='btn btn-warning btnSaveListado' idListado='"+respuesta[i]['id_listado']+"' modelo='"+respuesta[i]['modelo']+"' can='"+respuesta[i]['cantidad']+"'>"+
								                            "<i class='far fa-save'></i>"+
								                          "</button>"+
								                          "<button type='button' class='btn btn-danger btnTrashListado' idListado='"+respuesta[i]['id_listado']+"' modelo='"+respuesta[i]['modelo']+"' can='"+respuesta[i]['cantidad']+"'>"+
								                            "<i class='fas fa-trash-alt'></i>"+
								                          "</button>"+
								                        "</div>"+
													"</td>"+
												"</tr>");
					}
			
				}

				$("#bodyListadoUnitario").html(contenidoListadoUnitario);
				$("#bodyListado").html(contenidoListado);
			}
		})




		
	})
	
	/*=====  End of MOSTRAR DETALLES DEL PRODUCTO  ======*/

	/*=====================================================
	=                  Eliminar Producto                  =
	=====================================================*/
	
	$(document).on("click", "button.btnDel", function(){

		
  		var iddel = $(this).attr("idProducto");
		var codigo = $(this).attr("codigo");
		/* INFORMACION GENERAL DEL PRODUCTO */

		var datos = new FormData();
		datos.append("iddel", iddel);	
		var sumar=0;
			$.ajax({
				url: '../items/mvc/ajax/dashboard/productos.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					for(var i=0;i<respuesta.length; i++){
						sumar=sumar+parseFloat(respuesta[i]["COUNT(1)"]);
					}
					
					if(sumar<1){
						Swal.fire({
							title: '¿Desea eliminar el producto?',
							text: "",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#00b4d8ff',
							cancelButtonColor: '#de5f6c',
							cancelButtonText: 'Cancelar',
							confirmButtonText: 'Eliminar'
						}).then((result) => {

							if (result.isConfirmed) {
								eliminarelproducto(iddel);
							  }
							  
						})
					}else{
						Swal.fire({
							title: '¿Desea mandar el producto a papelera?',
							text: "Este producto no se puede eliminar completamente, ya se realizaron operaciones con él, se dejara de mostrar al crear una venta y se eliminara de la tienda virtual",
							icon: 'warning',
							showCancelButton: true,
							confirmButtonColor: '#00b4d8ff',
							cancelButtonColor: '#de5f6c',
							cancelButtonText: 'Cancelar',
							confirmButtonText: 'A papelera'
						}).then((result) => {
							if (result.isConfirmed) {
								checarentvtodel(iddel);
								papeleraproducto(iddel);
							  }
						})
					}
					
				}
			})
		
	})

	function eliminarelproducto(idtodel){
		var datos2 = new FormData();
		datos2.append("iddelate", idtodel);	
		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos2,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(){
			tablaProductos.ajax.reload(null,false);
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'El producto ha sido eliminado!',
				showConfirmButton: false,
				timer: 1500
				})
			}
		})
	}
	function checarentvtodel(iddel){
		//console.log(codigo);
		var datos3 = new FormData();
		datos3.append("checktvtodel", iddel);	
		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
			method: "POST",
			data: datos3,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				if(respuesta!=false){
					idProductoTV = respuesta[0];
					//idProducto = respuesta[2];
					//codigo = respuesta[3];
					img1 =  respuesta[4];
					img2 =  respuesta[5];
					img3 =  respuesta[6];
						
					if (img1 !== "") {
						EliminarImagen(img1);
					}
					if (img2!== "") {
						EliminarImagen(img2);
					}
					if (img3 !== "") {
						EliminarImagen(img3);
					}
						
					var datos = new FormData();
					datos.append("idEliminarProductoTV", idProductoTV);
					
					$.ajax({
						url: '../items/mvc/ajax/dashboard/productos-tienda.ajax.php',
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						// success: function(respuesta){
						
						// }
					})

						function EliminarImagen(img){
							//metodo para eliminar por URL del archivo
							var imagen = firebase.storage().refFromURL(img);

							// Delete the file
							imagen.delete().then(function() {
							// File deleted successfully
								console.log("ok")
								
							}).catch(function(error) {
								console.log("error")
							});
						}

						console.log("eliminado de TV");
					
				}else{
					console.log("No se encontro en TV");
				}
				
			}
		})
	}
	function papeleraproducto(idtopapelera){
		var datos2 = new FormData();
		datos2.append("idpapelera", idtopapelera);	
		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos2,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				//console.log(respuesta);
			tablaProductos.ajax.reload(null,false);
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'El producto se envio a papelera!',
				showConfirmButton: false,
				timer: 1500
			  })
			}
		})
	}
	
	/*=====  End of MOSTRAR DETALLES DEL PRODUCTO  ======*/
	/*=====================================================
	=                  Reciclar Producto                 =
	=====================================================*/
	$(document).on("click", "button.btnrecy", function(){
		Swal.fire({
			title: '¿Desea recuperar este producto?',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#00b4d8ff',
			cancelButtonColor: '#de5f6c',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Recuperar'
		}).then((result) => {
			if (result.isConfirmed) {
				var iddel = $(this).attr("idProducto");
				var datos = new FormData();
				datos.append("idreciclar", iddel);
				$.ajax({
					url: '../items/mvc/ajax/dashboard/productos.ajax.php',
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function(respuesta){
						tablaProductospapelera.ajax.reload(null,false);
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'El producto ha sido recuperado!',
							showConfirmButton: false,
							timer: 1500
							})
					}
				})
			}
		})
		
			
	  
  })
	
/*=====           End of Reciclar Producto          ======*/
	/*=====================================================
	=                  Atualizar tablas Productos                =
	=====================================================*/
$("#product-tab").click(function(){
	tablaProductos.ajax.reload(null, false);
	tablaProductospapelera.ajax.reload(null, false);
 })
 	/*=====  End of Atualizar tablas Productos  ======*/
	/*========================================================
	=            GUARDAR INFORMACION DEL PRODUCTO            =
	========================================================*/
	
	$(document).on("click", ".btnEditarInformacionProducto", function(){

		var id = $(this).attr("ideProducto");
		var nombre = $("#ProductoeNombre").val();
		var descripcion = $("#ProductoeDescripcion").val();
		var caracteristicas = $("#listaAgregadoEditar").val();

		var medidas = [{
						"largo" : $("#ProductoeMedidasLargo").val(),
						"ancho"  : $("#ProductoeMedidasAncho").val(),
						"alto" : $("#ProductoeMedidasAlto").val()
						}];

		medidas = JSON.stringify(medidas);
		var peso = $("#ProductoePeso").val();
		var claveProdSer = $("#ProductoeClaveProdServ").val();
		var claveUnidad = $("#ProductoeClaveUnidad").val();


		var datos = new FormData();
		datos.append("ProductoEditarIdInfo", id);
		datos.append("ProductoEditarNombreInfo", nombre);
		datos.append("ProductoEditarDescripcionInfo", descripcion);
		datos.append("ProductoEditarCaracteristicasInfo", caracteristicas);
		datos.append("ProductoEditarMedidasInfo", medidas);
		datos.append("ProductoEditarPesoInfo", peso);
		datos.append("ProductoEditarClaveProdServInfo", claveProdSer);
		datos.append("ProductoEditarClaveUnidadInfo", claveUnidad);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				tablaProductos.ajax.reload(null, false);

				toastr.success('Se han guardado cambios exitosamente!');

			}
		})

	})
	
	/*=====  End of GUARDAR INFORMACION DEL PRODUCTO  ======*/

/*==========================================================================================
=            --------------- CODIGO PARA LOTES DE LOS PRODUCTOS ---------------            =
==========================================================================================*/
	
	/*===============================================
	=            MOSTRAR FORMULARIO LOTE            =
	===============================================*/
	
	$(document).on("click", ".btnLoteAgregar", function(){

		$("#formNuevoLote").show("slow");

		toastr.error("Recuerde que una vez agregado un nuevo lote, no podra editar el anterior","Atención")


	})
	
	/*=====  End of MOSTRAR FORMULARIO LOTE  ======*/

	/*=====================================================
	=            CREAR NUEVO LOTE DEL PRODUCTO            =
	=====================================================*/
	
	$(document).on("submit", "#formNuevoLote", function(e){
			e.preventDefault();

			Swal.fire({
				title: '¿Desea Crear el nuevo lote?',
				text: "Asegurese de revisar los datos ingresados del lote",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#00b4d8ff',
				cancelButtonColor: '#de5f6c',
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Si, son correctos'
			}).then((result) => {

				if (result.isConfirmed) {
					
					var sku = $(".btnNuevoLote").attr("sku");
					var codigo = $(".btnNuevoLote").attr("cod");
					var piezas = $("#LotenPiezas").val();
					var costo = parseFloat($("#LotenCosto").val());
					var precioSug = parseFloat($("#p_sugerido").val());
					var proveedor = $("#LotenProveedor").val();
					var folio = $("#LotenFactura").val();
					
					var contenidoLotes = "";
		
					
					var datos = new FormData();
					datos.append("loteCrearSku", sku);
					datos.append("loteCrearCodigo", codigo);
					datos.append("loteCrearPiezas", piezas);
					datos.append("loteCrearCosto", costo);
					datos.append("LoteCrearPrecioSugerido", precioSug);
					datos.append("loteCrearProveedor", proveedor);
					datos.append("loteCrearFolio", folio);
					$.ajax({ 
						url: '../items/mvc/ajax/dashboard/productos.ajax.php',
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){
							// console.log(respuesta);
							tablaProductos.ajax.reload(null, false);
		
							toastr.success('Se ha creado exitosamente!');

							for (var i = 0; i < respuesta.length; i++) {
								if (i <= 2) {
									if (i == 0 ) {
										$("#infoLoteProducto").attr("costo_ant", respuesta[i]["costo_prom_ant"]);
										$("#infoLoteProducto").attr("stock_ant", respuesta[i]["stock_ant_disp"]);
										$("#infoLoteProducto").attr("fecha", respuesta[i]["fecha"]);
										$("#infoLoteProducto").attr("cant", respuesta[i]["cantidad"]);

										contenidoLotes = contenidoLotes.concat("<tr>"+
																			"<td>"+respuesta[i]['fecha']+"</td>"+
																			"<td>"+respuesta[i]['proveedor']+"</td>"+
																			// "<td>"+respuesta[i]['costo']+"</td>"+
																			"<td id='tdCosto'>"+
																				"<input type='text' id='inputCostoEditCedis' costoLote="+respuesta[i]['costo']+" value='"+respuesta[i]['costo']+"' style='width: 80px;'>"+
																			"</td>"+
																			"<td id='tdStock'>"+
																				"<input type='text' id='inputStock' stockLote='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 50px;'>"+
																			"</td>"+
					
																			"<td>"+
																				"<div class='input-group-prepend'>"+
																				  "<button type='button' class='btn btn-warning btnSaveLoteCedis' idLote='"+respuesta[i]['id_lote']+"' sku='"+respuesta[i]['sku']+"'>"+
																					"<i class='far fa-save'></i>"+
																				  "</button>"+
																				  "<button type='button' class='btn btn-danger btnTrashLoteCedis' idLote='"+respuesta[i]['id_lote']+"' sku='"+respuesta[i]['sku']+"'>"+
																					"<i class='fas fa-trash-alt'></i>"+
																				  "</button>"+
																				"</div>"+
																			"</td>"+
																		"</tr>");
									}else{
										contenidoLotes = contenidoLotes.concat("<tr>"+
																			"<td>"+respuesta[i]['fecha']+"</td>"+
																			"<td>"+respuesta[i]['proveedor']+"</td>"+
																			"<td>"+respuesta[i]['costo']+"</td>"+
																			"<td id='tdStock'>"+
																				"<input type='text' id='inputStock' stockLote='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 50px;' readonly>"+
																			"</td>"+
					
																			"<td>"+
																			"</td>"+
																		"</tr>");
									}
								}
		
							}

						
		
							$("#bodyLotes").html(contenidoLotes);
							
							$("#LotenPiezas").val("");
							$("#LotenProveedor").val("");
							$("#LotenFactura").val("");
							$("#LotenCosto").val("");
							$("#p_sugerido").val("");
		
							$("#formNuevoLote").hide("slow");
						}
					})
				}
				  
			})

	})

	
	/*=====  End of CREAR NUEVO LOTE DEL PRODUCTO  ======*/


	/*=======================================================
	=                   NUEVO EDITAR LOTE                   =
	=======================================================*/
	$(document).on("click", ".btnSaveLoteCedis", function(){

		let id = $(this).attr("idLote");
		let sku = $(this).attr("sku");
		let fecha = $("#infoLoteProducto").attr("fecha");
		let stockInput = $(this).parent().parent().parent().children("#tdStock").children("#inputStock").val(); // valor del input
		let stockLote = $(this).parent().parent().parent().children("#tdStock").children("#inputStock").attr("stockLote");// valor del atributo
		let modelo = $(".btnSaveListadoUnitario").attr("modelo");
		let costoLoteInput = $("#inputCostoEditCedis").val();
		let costoLote = $("#inputCostoEditCedis").attr("costoLote");
		
		console.log(stockInput)
		console.log(costoLoteInput)

		/* VALIDAR QUE NO ACEPTE NUMEROS NEGATIVOS
		-------------------------------------------------- */
		
		if (parseInt(stockInput) >= 0 && parseFloat(costoLoteInput) > 0) {
			let datos = new FormData();
			datos.append("LoteEditarId", id);
			datos.append("LoteEditarSkuGeneral", sku);
			datos.append("LoteEditarCantidadInput", stockInput);
			datos.append("LoteEditarFecha", fecha);
			datos.append("LoteEditarModelo", modelo);
			datos.append("LoteEditarCostoInput", costoLoteInput);
			/* IDENTIFICAR SI ES UN NUMERO MAYOR O MENOR
			-------------------------------------------------- */
			$.ajax({
				url: '../items/mvc/ajax/dashboard/productos.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					console.log(respuesta);

					if (respuesta == "error") {
						/* SI LA RESTA CON EL STOCK GENERAL ES MENOR A 0 */
						toastr.error('No tienes suficientes piezas existentes de este producto!, no se modifico la cantidad, ni el costo');
						$("#inputStock").val(stockLote);
					}else if(respuesta == "igual"){
						toastr.error('Ingrese cantidades diferentes para editar el lote');
					}else if(respuesta == "problema utilidad"){
						Swal.fire(
							'No se puede eliminar',
							'Si edita este o los anteriores lotes, el costo tendria un valor de CERO, por lo tanto la utilidad seria de CERO... Los lotes agregados despues de este si podran ser editados',
							'error'
						);
						$("#inputStock").val(stockLote);
					}else if(respuesta == "modCosto"){
						toastr.success('Costo modificado exitosamente!');
						toastr.error('No tienes suficientes piezas existentes de este producto!, no se modifico la cantidad');

						$("#inputCostoEditCedis").val(costoLoteInput);
						$("#inputCostoEditCedis").attr("costolote", costoLoteInput);
						$("#inputStock").val(stockLote);
					}else{
						tablaProductos.ajax.reload(null, false);

						toastr.success('Cantidad y costo modificados exitosamente!');

						// ACTUALIZAR DATOS DEL STOCK
						$("#inputStock").val(stockInput);
						$("#inputStock").attr("stockLote", stockInput);
						$("#infoLoteProducto").attr("cant",stockInput);

						//ACTUALIZAR DATOS DEL COSTO
						$("#inputCostoEditCedis").val(costoLoteInput);
						$("#inputCostoEditCedis").attr("costolote", costoLoteInput);

					}
				}
			})

			// if (parseInt(stockInput) <= parseInt(stockLote)) {
			// 	alert("cantidad menor a la actual")
			// }else{
			// 	alert("cantidad mayor a la actual")
			// }
		
		}else{
			toastr.error('No se permite registrar números negativos!');

			if (parseFloat(costoLoteInput) <= 0) {
				toastr.error('El costo debe ser mayor a 0');
				$(this).parent().parent().parent().children("#tdCosto").children("#inputCostoEditCedis").val(costoLote);
			}else if(parseInt(stockInput) < 0){

				$(this).parent().parent().parent().children("#tdStock").children("#inputStock").val(stockLote);
			}
			// $("#inputCostoEditCedis").attr("costoLote",costoLote);
			return;

		}
	
	})
	/*============  End of NUEVO EDITAR LOTE  =============*/

	/*==============================================================
	=            ELIMINAR LOTE Y ACTUALIZACION DE TABLA            =
	==============================================================*/
	
	$(document).on("click", ".btnTrashLoteCedis", function(){

		Swal.fire({
			title: '¿Desea eliminar el lote?',
			text: "Asegurese de tener stock disponible para poder eliminarlo",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#00b4d8ff',
			cancelButtonColor: '#de5f6c',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Sí, Eliminar'
		}).then((result) => {

			if (result.isConfirmed) {

				let id = $(this).attr("idLote");
				let sku = $(this).attr("sku");
				let fecha = $("#infoLoteProducto").attr("fecha");
				let cantidadLote = $("#infoLoteProducto").attr("cant");
				let costoAnterior = $("#infoLoteProducto").attr("costo_ant");
				let modelo = $(".btnSaveListadoUnitario").attr("modelo");
		
				var contenidoLotes = "";
		
				var datos = new FormData();
				datos.append("LoteEliminarId", id);
				datos.append("LoteEliminarSku", sku);
				datos.append("LoteEliminarCantidad", cantidadLote);
				datos.append("LoteEliminarFecha", fecha);
				datos.append("LoteEliminarCostoAnterior", costoAnterior);
				datos.append("LoteEliminarModelo", modelo);
		
				$.ajax({
					url: '../items/mvc/ajax/dashboard/productos.ajax.php',
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function(respuesta){
						console.log(respuesta)
						if (respuesta == "fallo") {
							
							toastr.error('No puedes eliminar este lote, ya que el stock disponible es menor a la cantida del lote');
						}else if (respuesta == "problema utilidad"){
							Swal.fire(
								'No se puede eliminar',
								'Si elimina este o los anteriores lotes, el costo tendria un valor de CERO, por lo tanto la utilidad seria de CERO',
								'error'
							);
						}else if(respuesta == "stock almacenes"){
							Swal.fire(
								'No se puede eliminar',
								'No tienes suficiente stock aqui, puedes mover stock de tus almacenes para eliminarlo',
								'warning'
							);
						}else{
		
							tablaProductos.ajax.reload(null, false);
			
							toastr.success('Se ha eliminado exitosamente!');
			
							
		
		
							for (var i = 0; i < respuesta.length; i++) {
								if (i <= 2) {
									if (i == 0 ) {
										$("#infoLoteProducto").attr("costo_ant", respuesta[i]["costo_prom_ant"]);
										$("#infoLoteProducto").attr("stock_ant", respuesta[i]["stock_ant_disp"]);
										$("#infoLoteProducto").attr("fecha", respuesta[i]["fecha"]);
										$("#infoLoteProducto").attr("cant", respuesta[i]["cantidad"]);
				
										contenidoLotes = contenidoLotes.concat("<tr>"+
																			"<td id='ocultarTDfecha'>"+respuesta[i]['fecha']+"</td>"+
																			"<td>"+respuesta[i]['proveedor']+"</td>"+
																			// "<td>"+respuesta[i]['costo']+"</td>"+
																			"<td id='tdCosto'>"+
																				"<input type='text' id='inputCostoEditCedis' costoLote="+respuesta[i]['costo']+" value='"+respuesta[i]['costo']+"' style='width: 80px;'>"+
																			"</td>"+
																			"<td id='tdStock'>"+
																				"<input type='text' id='inputStock' stockLote='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 50px;'>"+
																			"</td>"+
																			"<td>"+
																				"<div class='input-group-prepend'>"+
																				  "<button type='button' class='btn btn-warning btnSaveLoteCedis' idLote='"+respuesta[i]['id_lote']+"' sku='"+respuesta[i]['sku']+"'>"+
																					"<i class='far fa-save'></i>"+
																				  "</button>"+
																				  "<button type='button' class='btn btn-danger btnTrashLoteCedis' idLote='"+respuesta[i]['id_lote']+"' sku='"+respuesta[i]['sku']+"'>"+
																					"<i class='fas fa-trash-alt'></i>"+
																				  "</button>"+
																				"</div>"+
																			"</td>"+
																		"</tr>");
									}else{
										contenidoLotes = contenidoLotes.concat("<tr>"+
																			"<td id='ocultarTDfecha'>"+respuesta[i]['fecha']+"</td>"+
																			"<td>"+respuesta[i]['proveedor']+"</td>"+
																			"<td>"+respuesta[i]['costo']+"</td>"+
																			"<td id='tdStock'>"+
																				"<input type='text' id='inputStock' stockLote='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 50px;' readonly>"+
																			"</td>"+
																			"<td>"+
																				
																			"</td>"+
																		"</tr>");
									}
									
									
								}
							}
			
							$("#bodyLotes").html(contenidoLotes);
						}
							
					}
				})
			}
		})
		

	})
	
	/*=====  End of ELIMINAR LOTE Y ACTUALIZACION DE TABLA  ======*/


	/*===============================================
	=            MOSTRAR TODOS LOS LOTES            =
	===============================================*/
	
	$(document).on("click", ".btnMostrarTodosLotes",  function(){

		var sku = $(this).attr("sku");

		window.location = 'index.php?ruta=productos-lotes&&sku='+sku;
	})
	
	/*=====  End of MOSTRAR TODOS LOS LOTES  ======*/

/*=====  End of --------------- CODIGO PARA LOTES DE LOS PRODUCTOS ---------------  ======*/

/*=======================================================================================================
=            --------------- CODIGO PARA LISTADO DE PRECIOS DE LOS PRODUCTOS ---------------            =
=======================================================================================================*/
	
	/*===============================================================
	=            MOSTRAR FORMULARIO CREAR PRECIO LISTADO            =
	===============================================================*/
	
	$(document).on("click", ".btnListadoAgregar", function(){

		$("#formNuevoPrecioListadoProducto").show("slow");

	})
	
	/*=====  End of MOSTRAR FORMULARIO CREAR PRECIO LISTADO  ======*/

	/*==========================================================
	=            VERIFICAR SI YA EXISTE LA CANTIDAD            =
	==========================================================*/
	
	$(document).on("change", "#ListadonPiezas", function(){

		var modelo = $(".btnNuevoListado").attr("modelo");
		var cantidad = $(this).val();

		var datos = new FormData();
		datos.append("changeListadoModelo", modelo);
		datos.append("changeListadoCantidad", cantidad);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				if (respuesta == "existe") {

					toastr.error("Ya existe la cantidad en el listado de precios");
					$("#ListadonPiezas").val("");

				}

			}
		})

	})
	
	/*=====  End of VERIFICAR SI YA EXISTE LA CANTIDAD  ======*/

	/*===============================================================
	=            CREAR NUEVO PRECIO A LISTADO DE PRECIOS            =
	===============================================================*/
	
	$(document).on("submit", "#formNuevoPrecioListadoProducto", function(e){
		e.preventDefault();


		var modelo = $(".btnNuevoListado").attr("modelo");
		var piezas = $("#ListadonPiezas").val();
		var costo = $("#ListadonCosto").val();
		var contenidoListado = "";
		
		var datos = new FormData();
		datos.append("listadoCrearModelo", modelo);
		datos.append("listadoCrearPiezas", piezas);
		datos.append("listadoCrearCosto", costo);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				// console.log(respuesta);
				toastr.success('Se ha creado exitosamente!');

				for (var i = 0; i < respuesta.length; i++) {

					if (i != 0) {

					contenidoListado = contenidoListado.concat("<tr>"+
													"<td id='tdCantidad'>"+
														"<input type='text' id='inputCantidad' stockListado='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 100%;'>"+
													"</td>"+
													"<td id='tdPrecio'>"+
														"<input type='text' id='inputPrecio' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
													"</td>"+
													"<td>"+
														"<div class='input-group-prepend'>"+
								                          "<button type='button' class='btn btn-warning btnSaveListado' idListado='"+respuesta[i]['id_listado']+"' can='"+respuesta[i]['cantidad']+"'>"+
								                            "<i class='far fa-save'></i>"+
								                          "</button>"+
								                          "<button type='button' class='btn btn-danger btnTrashListado' modelo='"+respuesta[i]['modelo']+"' idListado='"+respuesta[i]['id_listado']+"' can='"+respuesta[i]['cantidad']+"'>"+
								                            "<i class='fas fa-trash-alt'></i>"+
								                          "</button>"+
								                        "</div>"+
													"</td>"+
												"</tr>");
					}
			
				}

				$("#bodyListado").html(contenidoListado);
				$("#ListadonPiezas").val("");
				$("#ListadonCosto").val("");
				$("#formNuevoPrecioListadoProducto").hide("slow");
			}
		})
	})
	
	/*=====  End of CREAR NUEVO PRECIO A LISTADO DE PRECIOS  ======*/

	/*=======================================================
	=            MODIFICACION DE PRECIO UNITARIO            =
	=======================================================*/
	
	$(document).on("click", ".btnSaveListadoUnitario", function(){
		
		var id = $(this).attr("idListado");
		var canButton = $(this).attr("can");

		var cantidad = $(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad").val();
		var attrCantidad = $(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad").attr("stockListado");
		var actCantidad = $(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad");

		var precio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").val();
		var attrPrecio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").attr("precioListado");
		var actPrecio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio");//actualizar 

		var promo = $(this).parent().parent().parent().children("#tdPromo").children("#inputPrecioPromo").val();
		var attrPrecio = $(this).parent().parent().parent().children("#tdPromo").children("#inputPrecioPromo").attr("preciopromolistado");
		var actPromo = $(this).parent().parent().parent().children("#tdPromo").children("#inputPrecioPromo");//actualizar 

		var activadoPromo = "no";
		if ($('#checkPromo').is(':checked')) {
			activadoPromo = 'si';
		}

		var datos = new FormData();
		datos.append("ListadoEditarId", id);
		datos.append("ListadoEditarCantidad", cantidad);
		datos.append("ListadoEditarPrecio", precio);
		datos.append("ListadoEditarPrecioPromo", promo);
		datos.append("ListadoEditarPromoActivado", activadoPromo);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				
				toastr.success('Se ha modificado correctamente!');

				$(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").val(precio);
				actPrecio.attr("precioListado", precio);

				$(this).parent().parent().parent().children("#tdPromo").children("#inputPrecioPromo").val(promo);
				actPromo.attr("preciopromolistado", promo);

			}
		})

	})
	
	/*=====  End of MODIFICACION DE PRECIO UNITARIO  ======*/

	/*======================================================================
	=            MODIFICACION DE DATOS EN EL LISTADO DE PRECIOS            =
	======================================================================*/
	
	$(document).on("click", ".btnSaveListado", function(){
		
		var id = $(this).attr("idListado");
		var canButton = $(this).attr("can");


		var cantidad = $(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad").val();
		var attrCantidad = $(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad").attr("stockListado");
		
		var actCantidad = $(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad");

		var precio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").val();
		var attrPrecio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").attr("precioListado");
		var actPrecio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio");


		var activadoPromo = 'no';
		// if (parseInt(canButton) != 1) {

			if (parseInt(cantidad) != 1) {

				var datos = new FormData();
				datos.append("ListadoEditarId", id);
				datos.append("ListadoEditarCantidad", cantidad);
				datos.append("ListadoEditarPrecio", precio);
				datos.append("ListadoEditarPrecioPromo", precio);
				datos.append("ListadoEditarPromoActivado", activadoPromo);

				$.ajax({
					url: '../items/mvc/ajax/dashboard/productos.ajax.php',
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function(respuesta){
						
						toastr.success('Se ha modificado correctamente!');

						$(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad").val(cantidad);
						actCantidad.attr("stockListado", cantidad);

						$(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").val(precio);
						actPrecio.attr("precioListado", precio);

					}
				})

			} else {

				$(this).parent().parent().parent().children("#tdCantidad").children("#inputCantidad").val(attrCantidad);
				return;

			}
	})
	
	/*=====  End of MODIFICACION DE DATOS EN EL LISTADO DE PRECIOS  ======*/

	/*========================================
	=            ELIMINAR LISTADO            =
	========================================*/
	
	$(document).on("click", ".btnTrashListado", function(){

		var id = $(this).attr("idListado");
		var modelo = $(this).attr("modelo");
		var cantidad = $(this).attr("can");
		var contenidoListado = "";

		var datos = new FormData();
		datos.append("ListadoEliminarId", id);
		datos.append("ListadoEliminarModelo", modelo);
		datos.append("ListadoEliminarCantidad", cantidad);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				toastr.success('Se ha eliminado exitosamente!');

				for (var i = 0; i < respuesta.length; i++) {

					if (i != 0) {
					

					contenidoListado = contenidoListado.concat("<tr>"+
							"<td id='tdCantidad'>"+
								"<input type='text' id='inputCantidad' stockListado='"+respuesta[i]['cantidad']+"' value='"+respuesta[i]['cantidad']+"' style='width: 100%;'>"+
							"</td>"+
							"<td id='tdPrecio'>"+
								"<input type='text' id='inputPrecio' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
							"</td>"+
							"<td>"+
								"<div class='input-group-prepend'>"+
		                          "<button type='button' class='btn btn-warning btnSaveListado' modelo='"+respuesta[i]['modelo']+"' idListado='"+respuesta[i]['id_listado']+"' can='"+respuesta[i]['cantidad']+"'>"+
		                            "<i class='far fa-save'></i>"+
		                          "</button>"+
		                          "<button type='button' class='btn btn-danger btnTrashListado' modelo='"+respuesta[i]['modelo']+"' idListado='"+respuesta[i]['id_listado']+ "' can='"+respuesta[i]['cantidad']+"'>"+
		                            "<i class='fas fa-trash-alt'></i>"+
		                          "</button>"+
		                        "</div>"+
							"</td>"+
						"</tr>");
					}
				}

				$("#bodyListado").html(contenidoListado);

			}
		})
	})
	
	/*=====  End of ELIMINAR LISTADO  ======*/

/*=====  End of --------------- CODIGO PARA LISTADO DE PRECIOS DE LOS PRODUCTOS ---------------  ======*/

/*================================================================
=            JS PARA ACCIONES DE UN PRODUCTO DERIVADO            =
================================================================*/
	
	/*==========================================================
	=            MOSTRAR MODAL DE PRODUCTO DERIVADO            =
	==========================================================*/
	
	$(document).on("click", ".btnModalDerivado", function(e){
		e.preventDefault();
		var id = $(this).attr("idProducto");
		$(".dCaracteristica").html("");
		$('#ProductodClaveUnidad option:selected').removeAttr("selected");


		$("#modalMostrarInfo").modal("hide").on('hidden.bs.modal', function (e) { 
				$("#modalAgregarDerivado").modal("show"); 
				$(this).off('hidden.bs.modal');
		}); 

		var datos = new FormData();
		datos.append("idInfo", id);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(resultado){
				// console.log(resultado);
				$("#ProductodModelo").val(resultado["codigo"]);
				$("#ProductodNombre").val(resultado["nombre"]);
				$("#ProductodDescripcion").html(resultado["descripcion"]);

				$("#ProductodClaveProdServ").val(resultado["sat_clave_prod_serv"]);
				$("#ProductodClaveUnidad option[value="+ resultado["sat_clave_unidad"] +"]").attr("selected",true);

				NumeroAleatorioCrear(100, 1000000);
			}
		})


		var datos = new FormData();
		datos.append("idInfoCaracteristicas", id);	

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				// console.log(respuesta);
				for (var i = 0; i < respuesta.length; i++) {
					noDerivadoCaracteristica++;
					
					$(".dCaracteristica").append(
						'<div class="row divCarecContenido" style="margin-bottom: 5px;">'+
							'<div class="col-xs-12 col-lg-6">'+
								'<div class="input-group">'+
								  '<div class="input-group-prepend">'+
					                '<span class="input-group-text">'+
					                  '<button type="button" class="btn btn-danger btn-xs quitarDCaract" idPaquete><i class="fa fa-times"></i></button>'+
					                '</span>'+
					              '</div>'+
					              '<select class="form-control selectDCaract input-lg" id="DCaracteristica'+noDerivadoCaracteristica+'" no="'+noDerivadoCaracteristica+'" required>'+
					              	'<option selected value="'+respuesta[i]["caracteristica"]+'">'+respuesta[i]["caracteristica"]+'</option>'+
					              	'<option disabled >Selecciona la Carateristica</option>'+
					              '</select>'+
					            '</div>'+
							'</div>'+
							'<div class="col-xs-12 col-lg-6 divDato">'+
					             '<input type="'+respuesta[i]["tipoCaracteristica"]+'" class="form-control inputDCaract input-lg"/>'+
							'</div>'+
						'</div>');


				}

				funcionForEachDerivado();
				listaAgregadoDerivado();
			}
		})

		/* INFORMACION DE DATOS DE ENVIO */
		
		var datos = new FormData();
		datos.append("idInfoDatosEnvio", id);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				$("#ProductodMedidasLargo").val(respuesta["medidas"][0]["largo"]);
				$("#ProductodMedidasAncho").val(respuesta["medidas"][0]["ancho"]);
				$("#ProductodMedidasAlto").val(respuesta["medidas"][0]["alto"]);

				$("#ProductodPeso").val(respuesta["peso"]);

				funcionForEachDerivado();
				listaAgregadoDerivado();
			}
		})

	})
	
	/*=====  End of MOSTRAR MODAL DE PRODUCTO DERIVADO  ======*/

	/*=====================================================
	=            CREAR NUEVO PRODUCTO DERIVADO            =
	=====================================================*/
	
	$(document).on("submit", "#formCrearProductoDerivado", function(e){
		e.preventDefault();

		var modelo = $("#ProductodModelo").val();
		var empresa = $("#ProductodIdEmpresa").val();
		var aleatorio = $("#ProductodAleatorio").val();
		var nombre = $("#ProductodNombre").val();
		var descripcion = $("#ProductodDescripcion").val();
		var stock = $("#ProductodStock").val();
		var costo = $("#ProductodCosto").val();

		var medidas = [{
						"largo" : $("#ProductodMedidasLargo").val(),
						"ancho"  : $("#ProductodMedidasAncho").val(),
						"alto" : $("#ProductodMedidasAlto").val()
						}];

		medidas = JSON.stringify(medidas);

		var peso = $("#ProductodPeso").val();
		var caracteristicas = $("#dListaAgregado").val();
		var factura = $("#ProductodFactura").val();
		var proveedor = $("#ProductodProveedor").val();
		var claveProdSer = $("#ProductodClaveProdServ").val();
		var claveUnidad = $("#ProductodClaveUnidad").val();

		var datos = new FormData();
			datos.append("DproductoCrearModelo", modelo);
			datos.append("DproductoCrearEmpresa", empresa);
			datos.append("DproductoCrearAleatorio", aleatorio);
			datos.append("DproductoCrearNombre", nombre);
			datos.append("DproductoCrearDescripcion", descripcion);
			datos.append("DproductoCrearStock", stock);
			datos.append("DproductoCrearCosto", costo);
			datos.append("DproductoCrearCaracteristicas", caracteristicas);
			datos.append("DproductoCrearMedidas", medidas);
			datos.append("DproductoCrearPeso", peso);
			datos.append("DproductoCrearFactura", factura);
			datos.append("DproductoCrearProveedor", proveedor);
			datos.append("DproductoCrearClaveProdServ", claveProdSer);
			datos.append("DproductoCrearClaveUnidad", claveUnidad);

			$.ajax({
				url: '../items/mvc/ajax/dashboard/productos.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					toastr.success('Se ha creado el producto exitosamente!');
					tablaProductos.ajax.reload(null, false);

				}
			});

			$("#formCrearProductoDerivado").trigger("reset");
			$(".dCaracteristica").html("");
			$("#dListaAgregado").val("");
			$('#modalAgregarDerivado').modal('hide');	
	})
	
	/*=====  End of CREAR NUEVO PRODUCTO DERIVADO  ======*/
	

/*=====  End of JS PARA ACCIONES DE UN PRODUCTO DERIVADO  ======*/

/*================================================================
=            MOSTRAR PANEL SUBIDA MASIVA DE PRODUCTOS            =
================================================================*/

$(document).on("click", ".btnNewMasiveProducts", function(){

	window.location = "productos-masivo";

})

/*=====  End of MOSTRAR PANEL SUBIDA MASIVA DE PRODUCTOS  ======*/


/*====================================================================================================================================
=            --------------------------------------- CODIGO PRODUCTOS ALMACEN -------------------------------------------            =
====================================================================================================================================*/

	/*==================================================
	=            MOSTRAR TABLA DE PRODUCTOS            =
	==================================================*/

	$(document).on("click", ".btnMostrarProductosAlmacen", function(){

		var idAlmacenProductos = $("#almacenesProductosSelect").val();
		let datos = new FormData();
		datos.append("idAlmacenProductos",idAlmacenProductos);
		$.ajax({
			url: "../items/mvc/ajax/dashboard/productos.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				console.log(respuesta)
			}
		})
		var pantalla = $(window).width();
		
		if (parseFloat(pantalla) > 540) {

			tablaProductosAlmacen = $('#tablaProductosAlmacen').DataTable({  
				"responsive": false,
				"destroy": true,//permite que la tabla se vuelva a dibujar
				"language":{
				    "sProcessing":     "Procesando...",
				    "sLengthMenu":     "Mostrar _MENU_ ",
				    "sZeroRecords":    "No se encontraron resultados",
				    "sEmptyTable":     "Ningún dato disponible en esta tabla",
				    "sInfo":           "_START_ al _END_ de un total de _TOTAL_",
				    "sInfoEmpty":      "0 al 0 de un total de 0",
				    "sInfoFiltered":   "(filtrado de un total de _MAX_ )",
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
				},
			    "ajax":{            
			        "url": "../items/mvc/ajax/dashboard/productos.ajax.php", 
			        "method": 'POST',
			        "data":{idAlmacenProductos:idAlmacenProductos},
			        "dataSrc":""
			    },
			    "columns":[
			    	{"data": "codigo"},
			        {"data": "nombre"},
			        {"data": "descripcion"},
			        {"data": "stock"},
			        {
			        	sortable: false,
			        	"render":function ( data, type, full, meta ) {
		                    var idProducto = full.id_producto;
		                    var codigo = full.codigo;
		                    var sku = full.sku;

		                    return '<div class="btn-group">'+
		                    	'<button class="btn btn-secondary btnColorCambio btnListadoProductoView" idAlmacen="'+idAlmacenProductos+'" codigo="'+codigo+'" data-toggle="modal" data-target="#modalListadoPrecioAlmacen">'+
		                    		'Precios'+
		                    	'</button>'+

		                    '</div>';
		                 }
		            }

			    ]

			}); 


		} else {

			tablaProductosAlmacen = $('#tablaProductosAlmacen').DataTable({  
				"responsive": true,
				"destroy": true,//permite que la tabla se vuelva a dibujar
				"language":{
				    "sProcessing":     "Procesando...",
				    "sLengthMenu":     "Mostrar _MENU_ ",
				    "sZeroRecords":    "No se encontraron resultados",
				    "sEmptyTable":     "Ningún dato disponible en esta tabla",
				    "sInfo":           "_START_ al _END_ de un total de _TOTAL_",
				    "sInfoEmpty":      "0 al 0 de un total de 0",
				    "sInfoFiltered":   "(filtrado de un total de _MAX_ )",
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
				},
			    "ajax":{            
			        "url": "../items/mvc/ajax/dashboard/productos.ajax.php", 
			        "method": 'POST',
			        "data":{idAlmacenProductos:idAlmacenProductos},
			        "dataSrc":""
			    },
			    "columns":[
			    	{"data": "codigo"},
			        {"data": "nombre"},
			        {"data": "descripcion"},
			        {"data": "stock"},
			        {
			        	sortable: false,
			        	"render":function ( data, type, full, meta ) {
		                    var idProducto = full.id_producto;
		                    var codigo = full.codigo;
		                    var sku = full.sku;

		                    return '<div class="btn-group">'+
		                    	'<button class="btn btn-secondary btnListadoProductoView" idAlmacen="'+idAlmacenProductos+'" codigo="'+codigo+'" data-toggle="modal" data-target="#modalListadoPrecioAlmacen">'+
		                    		'Precios'+
		                    	'</button>'+

		                    '</div>';
		                 }
		            }
			    ],
			    "columnDefs": [
			    	{ responsivePriority: 1, "targets": 0},
			    	{ responsivePriority: 2, "targets": 1}
				]
			});
		}

	}); 

	/*=====  End of MOSTRAR TABLA DE PRODUCTOS  ======*/
	
	/*==================================================
	=            MOSTRAR LISTADO DE PRECIOS            =
	==================================================*/
	
	$(document).on("click", ".btnListadoProductoView", function(){

		var idAlmacen = $(this).attr("idAlmacen");
		var codigo = $(this).attr("codigo");
		var mostrarTable = "";

		var datos = new FormData();
		datos.append("idAlmacenListadoAlmacen", idAlmacen);
		datos.append("codigoListadoAlmacen", codigo);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){

				if (respuesta.length > 0) {

					for (var i = 0; i < respuesta.length; i++) {
						
						if (i == 0) {

							mostrarTable = mostrarTable.concat("<tr>"+
								"<td id='tdCantidad'>"+
									respuesta[i]['cantidad']+
								"</td>"+
								"<td id='tdPrecio'>"+
									"<input type='text' id='inputPrecio' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
								"</td>"+
								"<td id='tdPromo'>"+
									"<input type='text' id='inputPrecioPromo' precioPromoListado='"+respuesta[i]['promo']+"' value='"+respuesta[i]['promo']+"' style='width: 100%;'>"+
								"</td>");

							if (respuesta[i]['activadoPromo'] == "si") {

								mostrarTable = mostrarTable.concat("<td id='tdPromoCheck'>"+
															"<input type='checkbox' id='checkPromo' checked>"+
														"</td>");

							}else{
						
								mostrarTable = mostrarTable.concat("<td id='tdPromoCheck'>"+
															"<input type='checkbox' id='checkPromo'>"+
														"</td>");

							}	

							mostrarTable = mostrarTable.concat("<td>"+
									"<div class='input-group-prepend'>"+
			                          "<button type='button' class='btn btn-warning btnGuardarCambioListadoAlmacen' idListado='"+respuesta[i]['id_almacen_productos_listado']+"' modelo='"+respuesta[i]['modelo']+"' can='"+respuesta[i]['cantidad']+"'>"+
			                            "<i class='far fa-save'></i>"+
			                          "</button>"+
			                        "</div>"+
								"</td>"+
							"</tr>");

						} else {

							mostrarTable = mostrarTable.concat("<tr>"+
									"<td id='tdCantidad'>"+
										respuesta[i]['cantidad']+
									"</td>"+
									"<td id='tdPrecio'>"+
										"<input type='text' id='inputPrecio' precioListado='"+respuesta[i]['precio']+"' value='"+respuesta[i]['precio']+"' style='width: 100%;'>"+
									"</td>"+
									"<td id='tdPromo'></td>"+
									"<td id='tdPromoCheck'></td>"+
									
									"<td>"+
										"<div class='input-group-prepend'>"+
				                          "<button type='button' class='btn btn-warning btnGuardarCambioListadoAlmacen' idListado='"+respuesta[i]['id_almacen_productos_listado']+"'>"+
				                            "<i class='far fa-save'></i>"+
				                          "</button>"+
				                        "</div>"+
									"</td>"+
								"</tr>");
						}

					}

				} else {

					mostrarTable = mostrarTable.concat("<tr>"+
									"<td colspan='5'>"+
										"No tienes stock registrado en este almacén para ver el listado de precios del producto."+
									"</td>"+
								"</tr>");

				}


				$("#tbodyListadoAlmacen").html(mostrarTable);

			}
		})


	})
	
	/*=====  End of MOSTRAR LISTADO DE PRECIOS  ======*/
	
	/*==========================================================================
	=            GUARDAR MODIFICACION DEL LISTADO DE PRECIO ALMACEN            =
	==========================================================================*/
	
	$(document).on("click", ".btnGuardarCambioListadoAlmacen", function(){
		
		var idListado = $(this).attr("idListado");
		var precio = $(this).parent().parent().parent().children("#tdPrecio").children("#inputPrecio").val();
		var promo = $(this).parent().parent().parent().children("#tdPromo").children("#inputPrecioPromo").val();
		
		var activadoPromo = "no";
		if ($(this).parent().parent().parent().children("#tdPromoCheck").children('#checkPromo').is(':checked')) {

			activadoPromo = 'si';

		}

		if(promo == undefined){
			promo = precio;
		}

		var datos = new FormData();
		datos.append("idEditarListadoAlmacen", idListado);
		datos.append("precioEditarListadoAlmacen", precio);
		datos.append("promoEditarListadoAlmacen", promo);
		datos.append("activarEditarListadoAlmacen", activadoPromo);

		$.ajax({
			url: '../items/mvc/ajax/dashboard/productos.ajax.php',
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta){
				console.log(respuesta)
				toastr.success('Se han guardado los datos correctamente!');

			}
		})

	})
	
	/*=====  End of GUARDAR MODIFICACION DEL LISTADO DE PRECIO ALMACEN  ======*/
	

/*=====  End of --------------------------------------- CODIGO PRODUCTOS ALMACEN -------------------------------------------  ======*/


/*===========================================================================================================================================
=            --------------------------------------- CODIGO PARA EMBARCACION DE PRODUCTO ---------------------------------------            =
===========================================================================================================================================*/

	/*======================================================
	=            AGREGAR PRODUCTO A EMBARCACIÓN            =
	======================================================*/
	
	$(document).on("click", ".btnAgregarEmbarcacion", function(){

		var almacen = $("#almacenesSelect").val();

		if (almacen == "") {

			toastr.error("Necesitas seleccionar un almacén");
			return;

		} else {

			var idProducto = $(this).attr("idProducto");
			$("#modalAgregarProductoEmbarcación").modal("show");

			var datos = new FormData();
			datos.append("idInfo", idProducto);

			$.ajax({
				url: '../items/mvc/ajax/dashboard/productos.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){

					$("#ProductoStockAlmacen").attr("stockDisponible", respuesta["stock_disponible"]);
					$("#ProductoStockAlmacen").attr("idAlmacen", almacen);
					$("#ProductoStockAlmacen").attr("idProducto", idProducto);

					$("#stockDisponibleTXT").html("El stock disponible de este producto es de: "+ respuesta["stock_disponible"]);

					if (parseFloat(respuesta["stock_disponible"]) > 0) {

						$("#ProductoStockAlmacen").val("1");

					} else {

						$("#ProductoStockAlmacen").val("0");

					}

				
				}
			})

		}

	})
	
	/*=====  End of AGREGAR PRODUCTO A EMBARCACIÓN  ======*/
	
	/*==================================================
	=            CARGAR PRODUCTO A EMBARQUE            =
	==================================================*/
	
	$(document).on("click", ".btnCargarProductoEmbarque", function(){

		var idProducto = $("#ProductoStockAlmacen").attr("idProducto");
		var idAlmacen = $("#ProductoStockAlmacen").attr("idAlmacen");
		var stockDisponible = $("#ProductoStockAlmacen").attr("stockDisponible");
		var stock = $("#ProductoStockAlmacen").val();

		
		
	})
	
	/*=====  End of CARGAR PRODUCTO A EMBARQUE  ======*/
	

/*=====  End of --------------------------------------- CODIGO PARA EMBARCACION DE PRODUCTO ---------------------------------------  ======*/
