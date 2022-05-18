var noVisualizacion = 1;
/*=======================================
=            BOTON DETALLES             =
=======================================*/

$(document).on("click", ".btn-details", function(){

	var id = $(this).attr("idProducto");
	var nombre = $(this).attr("nombre");
	// alert("entrado");
	window.location = 'index.php?ruta=product-details&&pR06412='+id+'&&nhvds47='+nombre;
})

/*=================================================================
=            MOSTRAR PRODUCTO DANDO CLICK EN CARUSELL            =
=================================================================*/

$(document).on("click", ".imgViewS", function(){

	var numero = $(this).attr("no");

	desactiveImg(numero);
	activeImg(numero);

})

function desactiveImg(numero){

	var imgViews = $(".imgView");
	var imgViewsScale = $(".imgViewS");

	for (var i = 0; i < imgViews.length; i++) {

		$(imgViews[i]).removeClass("active");
		$(imgViews[i]).addClass("desactive");
		$(imgViewsScale[i]).removeClass("active");

	}

}

function activeImg(numero){

	var imgViews = $(".imgView");
	var imgViewsScale = $(".imgViewS");

	for (var i = 0; i < imgViews.length; i++) {
		
		if ($(imgViews[i]).attr("no") == numero) {

			$(imgViews[i]).removeClass("desactive");
			$(imgViews[i]).addClass("active");
			$(imgViewsScale[i]).addClass("active");

		}		

	}

}

/*=========================================
=            PRODUCTO FAVORITO            =
=========================================*/

$(document).on("click", "#btnHeart", function(){
	var logeo = $(this).attr("addVal");
	
	if(logeo == 0){
		swal({
			title: "No has iniciado sesión!",
			text: "¿Quieres iniciar sesión?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6", 
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "sí, inciar!"
		}).then((result)=>{

			if(result.value){
				window.location = "login";
			}
		})


	} else {
		
		var heart = $(this).attr("Aheart");
		var id = $(this).attr("idProducto");
		var cliente = $(this).attr("idCliente");

		var datos = new FormData();
		datos.append("FavoritoIdProducto",id);
		datos.append("FavoritoIdCliente", cliente);

		$.ajax({
			url:'../items/mvc/ajax/tv/productos.ajax.php',
			method:"POST",
			data:datos,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success:function(respuesta){
			}

		})

		if (heart == 0) {
			$(this).addClass("heartsA");
			$(this).removeClass("hearts");
			$(this).attr("Aheart",1);
		} else if(heart == 1) {
			
			$(this).addClass("hearts");
			$(this).removeClass("heartsA");
			$(this).attr("Aheart",0);
		}


	}
})

/*====================================================
=            AGREGAR PRODUCTOS AL CARRITO            =
====================================================*/

$(document).on("click",".addBtn",function(){ 

	var addVal = $(this).attr("addVal");
	var idProducto = $(this).attr("idProducto");
	var cliente = $(this).attr("idCliente");
	var modelo = $(this).attr("modelo");
	var empresa = $(this).attr("empresa");
	var cantidad = "1";
	var noProductos = $(".noProductos").text();

	// alert(noProductos);
 
	if (addVal == "0") {
		var datos = new FormData();
			datos.append("idAgregarProducto", idProducto);
			datos.append("cantidad", cantidad);
			datos.append("cliente", cliente);
			datos.append("modelo", modelo);
			datos.append("empresa", empresa);

		$.ajax({
			url:'../items/mvc/ajax/tv/carrito.ajax.php',
			method:"POST",
			data:datos,
			cache: false,
			contentType: false, 
			processData: false,
			dataType: "json",
			success:function(respuesta){

				noProductos = parseInt(noProductos) + 1;
				$(".noProductos").text(noProductos);
				// console.log(respuesta);
				
				swal({
					type:'success',
					title: 'Producto guardado en tu carrito',
					showConfirmButton: true,
					confirmButtonText: 'Cerrar',
					closeOnConfirm: false
					}).then((result)=>{
						if(result.value){
							 window.location='inicio';
					}
				});
			}
		})

	}else{

		 window.location='login';

	}

})

/*=====  End of AGREGAR PRODUCTOS AL CARRITO  ======*/


/*=============================================
=            MOSTRAR MAS PRODUCTOS            =
=============================================*/

$(document).on("click","#btnVermas", function(){
	// alert(noVisualizacion);
	//var noVisualizacion = 1; //Se agrego esta variable si da error quitar
	var cantidadAnterior = 0; // inicial

	var cantidadMostrar = (parseInt(noVisualizacion) * parseInt(12));

	if (noVisualizacion > 1) {
		// alert("entro");
		cantidadAnterior = (parseInt(cantidadMostrar) - parseInt(12));
	}

	var divProductos = "";
    //console.log(arrayJS);
    //alert(arrayJS.length);
	//alert("mostrar "+cantidadMostrar);
    //alert("anterior "+cantidadAnterior);
	for (var i = 0; i < arrayJS.length; i++) {

		if (i >= cantidadAnterior && i < cantidadMostrar) {
			
			divProductos = divProductos.concat('<div class="col-lg-3 col-sm-6">'+
					'<div class="l_product_item">'+
						'<div class="l_p_img">'+
							'<img class="img-fluid" src="'+arrayJS[i]["imagen"]+'" alt="">');


			/* ETIQUETA DE PROMOCION  */
			
			if (arrayJS[i]["tag"] != null) {

			divProductos = divProductos.concat('<h5 class="sale">'+arrayJS[i]["tag"]+'</h5>');

			}

			/* END ETIQUETA DE PROMOCIÓN */
			

			divProductos = divProductos.concat('</div>'+
						'<div class="l_p_text">'+
							'<ul>'+
								'<li class="p_icon">'+
									'<a href="#" class="btn-details" role="button" idProducto="'+arrayJS[i]["idProducto"]+'" nombre="'+arrayJS[i]["nombre"]+'" style="cursor: pointer; font-size:1.5em;">'+
										'<i class="fa fa-search"></i>'+
									'</a>'+
								'</li>'+
								'<li>');

			/* BOTON AGREGAR PRODUCTO */

			if (arrayJS[i]["sesionUser"] == "si") {


				if (parseInt(arrayJS[i]["stock"]) > 0) {

					divProductos = divProductos.concat('<a class="add_cart_btn addBtn" href="#" '+
						'idProducto="'+arrayJS[i]["idProducto"]+'" addVal="0" '+
						'idCliente="'+arrayJS[i]["idCliente"]+'" modelo="'+arrayJS[i]["modelo"]+'" '+
						'empresa="'+arrayJS[i]["empresa"]+'">'+
							'<i class="fa fa-shopping-cart"></i> Agregar'+
						'</a>');

				} else {

					divProductos = divProductos.concat('<p style="color: red;"">AGOTADO</p>');

				}

			} else {

				if (parseInt(arrayJS[i]["stock"]) > 0) {

					divProductos = divProductos.concat('<a class="add_cart_btn addBtn" href="#" idProducto="'+arrayJS[i]["idProducto"]+'" addVal="1">'+
                                                        '<i class="fa fa-shopping-cart"></i> Agregar'+
                                                    '</a>');
                } else {

                	divProductos = divProductos.concat('<p style="color: red;"">AGOTADO</p>');

                }
			}

			/* END BOTON AGREGAR PRODUCTO */


			divProductos = divProductos.concat('</li>'+
								'<li class="p_icon">');


			/*====================================================
			=            SECCION DE PRODUCTO FAVORITO            =
			====================================================*/
			if (arrayJS[i]["sesionUser"] == "si") {


				if (arrayJS[i]["Aheart"] == 1) {

					divProductos = divProductos.concat('<p href="#" class="heartsA" Aheart="1" id="btnHeart" addVal="1"'+
														'idProducto="'+arrayJS[i]["idProducto"]+'"'+
														'idCliente="'+arrayJS[i]["idCliente"]+'">'+
                                                    		'<i class="fa fa-heart"></i>'+
                                                	'</p>');

				} else {

					divProductos = divProductos.concat('<p href="#" class="hearts" Aheart="0" id="btnHeart" addVal="1"'+
														'idProducto="'+arrayJS[i]["idProducto"]+'"'+
														'idCliente="'+arrayJS[i]["idCliente"]+'">'+
                                                    		'<i class="fa fa-heart"></i>'+
                                                	'</p>');

				}

			} else {

				divProductos = divProductos.concat('<p href="#" class="hearts" id="btnHeart" addVal="0">'+
                                                    		'<i class="fa fa-heart"></i>'+
                                                	'</p>');
			}


			/*====================================================
			=            NOMBRE Y PRECIO DEL PRODUCTO            =
			====================================================*/
			divProductos = divProductos.concat('</li>'+
							'</ul>'+
							'<h4>'+arrayJS[i]["nombre"]+'</h4>'+
							'<h5>');

				if (arrayJS[i]["activadoPromo"] == "si") {

					divProductos = divProductos.concat('<del>$'+arrayJS[i]["precio"]+"</del> $"+arrayJS[i]["promo"]);

				} else {

					divProductos = divProductos.concat('$'+arrayJS[i]["precio"]);

				}

			divProductos = divProductos.concat('</h5>'+
						'</div>'+
					'</div>'+
				'</div>');

		}

	}

	$("#divProductosExtrac").append(divProductos);
	noVisualizacion = noVisualizacion + 1;

	if (arrayJS.length >= cantidadMostrar) {

		$(".divButtonMostrarMas").html('<button type="button" class="btn btn-block" id="btnVermas"  style="background: rgba(240,255,255,0.8);cursor: pointer;">Ver más...</button>');

	} else {
		
		$(".divButtonMostrarMas").html('');

	}


})

/*=====  End of MOSTRAR MAS PRODUCTOS  ======*/