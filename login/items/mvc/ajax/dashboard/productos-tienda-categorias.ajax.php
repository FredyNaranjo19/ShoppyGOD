<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.categorias.php';

class AjaxCategorias{

	/*============================================
	=            MOSTRAR LA CATEGORIA            =
	============================================*/
	
	public $idCategoriaMostrar;
	
	public function ajaxMostrarCategoria(){

		$tabla = "tv_categorias";
		$item = "id_categoria";
		$valor = $this -> idCategoriaMostrar;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MOSTRAR LA CATEGORIA  ======*/

	/*==========================================================
	=            MOSTRAR SUBCATEGORIAS DE CATEGORIA            =
	==========================================================*/
	
	public $idCategoria;
	
	public function ajaxCambioCategoria(){

		$item = "id_categoria";
		$valor = $this -> idCategoria;
		$tabla = "tv_subcategorias";

		$respuesta = ModeloCategorias::mdlMostrarSubCategorias($tabla, $item, $valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR SUBCATEGORIAS DE CATEGORIA  ======*/
	

	/*=======================================
	=            CREAR CATEGORIA            =
	=======================================*/
	
	public $nombreCrearCategoria;
	public $imagenNombreCrearCategoria;
	public $imagenCrearCategoria;
	public function ajaxCrearCategoria(){

		$tabla = "tv_categorias";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
	 				"nombre" => $this -> nombreCrearCategoria,
	 				"imagen" => $this -> imagenCrearCategoria,
	 				"nombreImg" => $this -> imagenNombreCrearCategoria);

		$respuesta = ModeloCategorias::mdlCrearCategoria($tabla,$datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of CREAR CATEGORIA  ======*/
	
	/*========================================
	=            EDITAR CATEGORIA            =
	========================================*/
	
	public $idEditarCategoria;
	public $nombreEditarCategoria;
	public $imagenNombreEditarCategoria;
	public $imagenEditarCategoria;

	public function ajaxEditarCategoria(){

		$tabla = "tv_categorias";
		$datos = array("nombre" => $this -> nombreEditarCategoria,
						"imagen" => $this -> imagenEditarCategoria,
			 			"nombreImg" => $this -> imagenNombreEditarCategoria,
						"id_categoria" => $this -> idEditarCategoria);

		$respuesta = ModeloCategorias::mdlEditarCategoria($tabla,$datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of EDITAR CATEGORIA  ======*/
	
	/*==========================================
	=            CREAR SUBCATEGORIA            =
	==========================================*/
	
	public $nombreCrearSubcategoria;
	public $idCategoriaCrearSubcategoria;
	public function ajaxCrearSubcategoria(){

		$tabla = "tv_subcategorias";
		$datos = array("nombre" => $this -> nombreCrearSubcategoria,
						"id_categoria" => $this -> idCategoriaCrearSubcategoria);

		$respuesta = ModeloCategorias::mdlCrearSubcategoria($tabla,$datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of CREAR SUBCATEGORIA  ======*/

	/*===========================================
	=            EDITAR SUBCATEGORIA            =
	===========================================*/
	
	public $idEditarSubcategoria;
	public $nombreEditarSubcategoria;
	public function ajaxEditarSubcategoria(){

		$tabla = "tv_subcategorias";
		$datos = array("nombre" => $this -> nombreEditarSubcategoria,
						"id_subcategoria" => $this -> idEditarSubcategoria);

		$respuesta = ModeloCategorias::mdlEditarSubcategoria($tabla,$datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of EDITAR SUBCATEGORIA  ======*/

	/*=============================================
	=            ELIMINAR SUBCATEGORIA            =
	=============================================*/
	
	
	public $SubcategoriaEliminarId;
	public function ajaxEliminarSubcategoria(){


		$tabla = "tv_subcategorias";
		$item = "id_subcategoria";
		$valor = $this -> SubcategoriaEliminarId;

		$respuesta = ModeloCategorias::mdlEliminarSubcategorias($tabla, $item, $valor);

		echo json_encode($respuesta);

	}
	
	/*=====  End of ELIMINAR CATEGORIA  ======*/


	/*=============================================
	=            ELIMINAR CATEGORIA            =
	=============================================*/
	
	public $CategoriaEliminarId;
	public function ajaxEliminarCategoria(){

		$tabla1 = "tv_subcategorias";
		$item = "id_categoria";
		$valor = $this -> CategoriaEliminarId;

		$eliminaSub = ModeloCategorias::mdlEliminarSubcategorias($tabla1, $item, $valor);

		$tabla2 = "tv_categorias";
		
		$respuesta = ModeloCategorias::mdlEliminarCategorias($tabla2, $item, $valor);

		echo json_encode($respuesta);

	}
	
	/*=====  End of ELIMINAR CATEGORIA  ======*/
	
}

/*============================================
=            MOSTRAR LA CATEGORIA            =
============================================*/

if (isset($_POST["idCategoriaMostrar"])) {
	$mostrarCate = new AjaxCategorias();
	$mostrarCate -> idCategoriaMostrar = $_POST["idCategoriaMostrar"];
	$mostrarCate -> ajaxMostrarCategoria();
}

/*=====  End of MOSTRAR LA CATEGORIA  ======*/

/*==========================================================
=            MOSTRAR SUBCATEGORIAS DE CATEGORIA            =
==========================================================*/

if (isset($_POST['idCategoria'])) {
	$cambioSubcategoria = new AjaxCategorias();
	$cambioSubcategoria -> idCategoria = $_POST['idCategoria'];
	$cambioSubcategoria -> ajaxCambioCategoria();
}

/*=====  End of MOSTRAR SUBCATEGORIAS DE CATEGORIA  ======*/


/*========================================
=            CREAR CATEGORIA             =
========================================*/

if (isset($_POST["nombreCrearCategoria"])) {
	$crearCategoria = new AjaxCategorias();
	$crearCategoria -> nombreCrearCategoria = $_POST["nombreCrearCategoria"];
	$crearCategoria -> imagenNombreCrearCategoria = $_POST["imagenNombreCrearCategoria"];
	$crearCategoria -> imagenCrearCategoria = $_POST["imagenCrearCategoria"];
	$crearCategoria -> ajaxCrearCategoria();
}

/*=====  End of CREAR CATEGORIA   ======*/

/*========================================
=            EDITAR CATEGORIA            =
========================================*/

if (isset($_POST["idEditarCategoria"])) {
	$editarCategoria = new AjaxCategorias();
	$editarCategoria -> idEditarCategoria = $_POST["idEditarCategoria"];
	$editarCategoria -> nombreEditarCategoria = $_POST["nombreEditarCategoria"];
	$editarCategoria -> imagenNombreEditarCategoria = $_POST["imagenNombreEditarCategoria"];
	$editarCategoria -> imagenEditarCategoria = $_POST["imagenEditarCategoria"];
	$editarCategoria -> ajaxEditarCategoria();
}

/*=====  End of EDITAR CATEGORIA  ======*/

/*==========================================
=            CREAR SUBCATEGORIA            =
==========================================*/

if (isset($_POST["nombreCrearSubcategoria"])) {
	$crearSubcategoria = new AjaxCategorias();
	$crearSubcategoria -> nombreCrearSubcategoria = $_POST["nombreCrearSubcategoria"];
	$crearSubcategoria -> idCategoriaCrearSubcategoria = $_POST["idCategoriaCrearSubcategoria"];
	$crearSubcategoria -> ajaxCrearSubcategoria();
}

/*=====  End of CREAR SUBCATEGORIA  ======*/

/*===========================================
=            EDITAR SUBCATEGORIA            =
===========================================*/

if (isset($_POST["idEditarSubcategoria"])) {
	$editarSubcategoria = new AjaxCategorias();
	$editarSubcategoria -> idEditarSubcategoria = $_POST["idEditarSubcategoria"];
	$editarSubcategoria -> nombreEditarSubcategoria = $_POST["nombreEditarSubcategoria"];
	$editarSubcategoria -> ajaxEditarSubcategoria();
}


/*=====  End of EDITAR SUBCATEGORIA  ======*/

/*=============================================
=            ELIMINAR SUBCATEGORIA            =
=============================================*/

if (isset($_POST["SubcategoriaEliminarId"])) {
	$categoriaEliminar = new AjaxCategorias(); 
	$categoriaEliminar -> SubcategoriaEliminarId = $_POST["SubcategoriaEliminarId"];
	$categoriaEliminar -> ajaxEliminarSubcategoria();
}

/*=====  End of ELIMINAR SUBCATEGORIA  ======*/

/*=============================================
=            ELIMINAR SUBCATEGORIA            =
=============================================*/

if (isset($_POST["CategoriaEliminarId"])) {
	$categoriaEliminar = new AjaxCategorias(); 
	$categoriaEliminar -> CategoriaEliminarId = $_POST["CategoriaEliminarId"];
	$categoriaEliminar -> ajaxEliminarCategoria();
}

/*=====  End of ELIMINAR SUBCATEGORIA  ======*/



?>