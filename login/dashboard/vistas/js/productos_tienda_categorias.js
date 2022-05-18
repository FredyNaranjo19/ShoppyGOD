/*=======================================================
=            MOSTRAR U OCULTAR SUBCATEGORIAS            =
=======================================================*/

$(document).on("click", ".btnCategoria", function(){

	var id = $(this).attr("idC");
	var valor = $(this).attr("valor");

	if (valor == 0) {

		$(".btn-i"+id).addClass("fa-minus");
		$(".btn-i"+id).removeClass("fa-plus");
		$(this).attr("valor",1);
		$("#divSucategoria"+id).show("slow");

	}else{

		$(".btn-i"+id).removeClass("fa-minus");
		$(".btn-i"+id).addClass("fa-plus");
		$(this).attr("valor",0);
		$("#divSucategoria"+id).hide("slow");
	
	}

})

/*=====  End of MOSTRAR U OCULTAR SUBCATEGORIAS  ======*/

/*==================================================
=            SUBIR IMAGEN DE CATEGORIAS            =
==================================================*/

$(document).on("click", "#btnImagenCategoria", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 420, // maximum width
            height: 420 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('viewImagenCategoria').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            FotoCategoria(blob);
        });

    }
    input.click();

})


function FotoCategoria(blob){

    var ImgName = $("#nombreImagenCategoria").val();

    var uploadTask = firebase.storage().ref('categorias/' + ImgName).put(blob);

  	uploadTask.on('state_changed', function (snapshot) {
              var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
              document.getElementById('txtCargaCategoriaImagen').innerHTML = 'Subiendo: ' + progress + '%';
  		},
  		// Handle unsuccessful uploads
	  	function (error) {
	      	alert("Hubo un error al subir imagen");

	  	},
    
    	// Subir link y nombre a base de datos
	  	function () {
	        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
	            ImgUrl = url;

	            firebase.database().ref('categorias/' + ImgName).set({
	                Name: ImgName,
	                Link: ImgUrl
	            });
	            $("#urlImagenCategoria").val(ImgUrl);
	            document.getElementById('txtCargaCategoriaImagen').innerHTML = 'Exitoso!';

        });
  	});

}


/*=====  End of SUBIR IMAGEN DE CATEGORIAS  ======*/

/*=========================================
=            GUARDAR CATEGORIA            =
=========================================*/

$(document).on("submit", "#formCrearCategoria", function(e){
	e.preventDefault();

	var nombre = $("#nombreCategoria").val();
	var imagenNombre = $("#nombreImagenCategoria").val(); 
	var imagen = $("#urlImagenCategoria").val();

	var datos = new FormData();
	datos.append("nombreCrearCategoria", nombre);
	datos.append("imagenNombreCrearCategoria", imagenNombre);
	datos.append("imagenCrearCategoria", imagen);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			window.location = 'tienda-productos';

		}
	});
})

/*=====  End of GUARDAR CATEGORIA  ======*/

/*========================================
=            EDITAR CATEGORIA            =
========================================*/

$(document).on("click",".btnEditarCategoria", function(){

	var id = $(this).attr("idCate");
	var name = $(this).attr("namecate");
	var emp = $(this).attr("emp");
	var conc = "";
	
	var datos = new FormData();
	datos.append("idCategoriaMostrar", id);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			$("#eIdCategoria").val(id);
			$("#eNameCategoria").val(name);

			if (respuesta["nombreImg"] == null) {

				conc = conc.concat("Categoria_"+emp+"_"+respuesta["id_categoria"]);

				$("#eNombreImgCategoria").val(conc);

			} else {

				$("#eNombreImgCategoria").val(respuesta["nombreImg"]);

			}

			if (respuesta["imagen"] != null) {
				$("#eViewImgCategoria").attr("src",respuesta["imagen"]);
				$("#eUrlImgCategoria").val(respuesta["imagen"]);

			} else {

				$("#eUrlImgCategoria").val(null);

			}

		}
	})
})

/*=====  End of EDITAR CATEGORIA  ======*/

/*========================================================
=            SUBIR IMAGEN EN EDITAR CATEGORIA            =
========================================================*/

$(document).on("click", "#eBtnImgCategoria", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], { 
            width: 420, // maximum width
            height: 420 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('eViewImgCategoria').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            FotoCategoriaEditar(blob);
        });

    }
    input.click();

})


function FotoCategoriaEditar(blob){

    var ImgName = $("#eNombreImgCategoria").val();

    var uploadTask = firebase.storage().ref('categorias/' + ImgName).put(blob);

  	uploadTask.on('state_changed', function (snapshot) {
              var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
              document.getElementById('eTxtCargaCategoria').innerHTML = 'Subiendo: ' + progress + '%';
  		},
  		// Handle unsuccessful uploads
	  	function (error) {
	      	alert("Hubo un error al subir imagen");

	  	},
    
    	// Subir link y nombre a base de datos
	  	function () {
	        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
	            ImgUrl = url;

	            firebase.database().ref('categorias/' + ImgName).set({
	                Name: ImgName,
	                Link: ImgUrl
	            });
	            // alert(ImgUrl);
	            $("#eUrlImgCategoria").val(ImgUrl);
	            document.getElementById('eTxtCargaCategoria').innerHTML = 'Exitoso!';

        });
  	});

}

/*=====  End of SUBIR IMAGEN EN EDITAR CATEGORIA  ======*/

/* RECARGAR DIV COM CATEGORIAS
-------------------------------------------------- */

$(document).on("click", "#categorias-tab", function(){
	
	$("#tabs-categorias").load(location.href + " #tabs-categorias");
	
})

/*========================================
=            EDITAR CATEGORIA            =
========================================*/

$(document).on("submit", "#formEditarCategoria", function(e){
	e.preventDefault();

	var idCategoria = $("#eIdCategoria").val();
	var nombre = $("#eNameCategoria").val();
	var imagenNombre = $("#eNombreImgCategoria").val(); 
	var imagen = $("#eUrlImgCategoria").val();

	var datos = new FormData();
	datos.append("idEditarCategoria", idCategoria);
	datos.append("nombreEditarCategoria", nombre);
	datos.append("imagenNombreEditarCategoria", imagenNombre);
	datos.append("imagenEditarCategoria", imagen);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			window.location = 'tienda-productos';

		}
	});
})

/*=====  End of EDITAR CATEGORIA  ======*/

/*==========================================
=            ELIMINAR CATEGORIA            =
==========================================*/

$(document).on("click",".btnEliminarCategoria", function(){
	var id = $(this).attr("idCate");
	var cantidad = $(this).attr("cantidad");

	if (parseInt(cantidad) == 0) {

		Swal.fire({
		  title: 'Estás seguro de eliminar la categoria?',
		  text: "",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Sí, eliminar!'
		}).then((result) => {
			if (result.isConfirmed) {

				var datos = new FormData();
				datos.append("CategoriaEliminarId", id);

				$.ajax({
					url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function(respuesta){
						console.log(respuesta);
						if (respuesta == 'ok') {

							toastr.success('Categoria eliminada exitosamente!');

							setTimeout(() => {
								window.location = 'tienda-productos';
							}, 1500);

						}
						

					}
				})

			    
			}
		})

	} else {

		Swal.fire({
		  icon: 'error',
		  title: 'No puedes eliminar la categoria...',
		  text: 'Modifica los productos que tienen esta categoria!'
		})

	}

})

/*=====  End of ELIMINAR CATEGORIA  ======*/


/*==========================================
=            CREAR SUBCATEGORIA            =
==========================================*/

$(document).on("submit", "#formCrearSubcategoria", function(e){
	e.preventDefault();

	var nombre = $("#nNombreSubcategoria").val();
	var optionCategoria = $("#optionCategoria").val();

	var datos = new FormData();
	datos.append("nombreCrearSubcategoria", nombre);
	datos.append("idCategoriaCrearSubcategoria", optionCategoria);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			window.location = 'tienda-productos';

		}
	});
})

/*=====  End of CREAR SUBCATEGORIA  ======*/

/*===========================================
=            EDITAR SUBCATEGORIA            =
===========================================*/

$(document).on("click",".btnEditarSubcategoria", function(){
	var id = $(this).attr("idSub");

	var name = $(this).attr("nameSub");

	$("#eIdSubcategoria").val(id);
	$("#eNameSubcategoria").val(name);

})

/*=====  End of EDITAR SUBCATEGORIA  ======*/

/*=============================================
=            ELIMINAR SUBCATEGORIA            =
=============================================*/

$(document).on("click",".btnEliminarSubcategoria", function(){
	var id = $(this).attr("idSub");
	var cantidad = $(this).attr("cantidad");

	if (parseInt(cantidad) == 0) {

		Swal.fire({
		  title: 'Estás seguro de eliminar la subcategoria?',
		  text: "",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Sí, eliminar!'
		}).then((result) => {
			if (result.isConfirmed) {

				var datos = new FormData();
				datos.append("SubcategoriaEliminarId", id);

				$.ajax({
					url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "json",
					success: function(respuesta){
						console.log(respuesta)
						if (respuesta == 'ok') {

							toastr.success('Subcategoria eliminada exitosamente!');

							setTimeout(function(){
								window.location = 'tienda-productos';
							},1500)
							

						}
						
					}
				})
			}
		})

	} else {

		Swal.fire({
		  icon: 'error',
		  title: 'No puedes eliminar la subcategoria...',
		  text: 'Modifica los productos que tienen esta subcategoria!'
		})

	}

})

/*=====  End of ELIMINAR SUBCATEGORIA  ======*/

/*==========================================================
=            GUARDAR CAMBIOS DE LA SUBCATEGORIA            =
==========================================================*/

$(document).on("submit", "#formEditarSubcategoria", function(e){
	e.preventDefault();

	var idSubcategoria = $("#eIdSubcategoria").val();
	var nombreSubcategoria = $("#eNameSubcategoria").val();

	var datos = new FormData();
	datos.append("idEditarSubcategoria", idSubcategoria);
	datos.append("nombreEditarSubcategoria", nombreSubcategoria);

	$.ajax({
		url: '../items/mvc/ajax/dashboard/productos-tienda-categorias.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			window.location = 'tienda-productos';

		}
	});
})

/*=====  End of GUARDAR CAMBIOS DE LA SUBCATEGORIA  ======*/

