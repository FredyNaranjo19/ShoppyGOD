<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos-tienda.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.categorias.php';

class AjaxProductosTienda{

	/*===============================================================
	=            MOSTRAR INFORMACION DEL PRODUCTO TIENDA            =
	===============================================================*/
	
	public $idProductoTienda;
	
	public function ajaxMostrarProductoTienda(){

		/* PRODUCTO TIENDA */
		$tabla = "tv_productos";
		$item = "id_tv_productos"; 
		$valor = $this -> idProductoTienda;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$tienda = ModeloProductosTienda::mdlMostrarProductosTienda($tabla, $item, $valor, $empresa);

		/* Producto informacion */
		$tabla = "productos";
		$item = "id_producto";
		$valor = $tienda["id_producto"];

		$producto = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);

		/* Categoria informacion */
		$tabla = "tv_categorias";
		$item = "id_categoria";
		$valor = $tienda["id_categoria"];
		$categoria = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor, $empresa);

		/* Subcategoria informacion */
		$tabla = "tv_subcategorias";
		$item = "id_subcategoria";
		$valor = $tienda["id_subcategoria"];
		$subcategoria = ModeloCategorias::mdlMostrarSubCategorias($tabla, $item, $valor);

		$respuesta = array("id_tv_productos" => $tienda["id_tv_productos"],
							"id_producto" => $tienda["id_producto"],
							"codigo" => $tienda["codigo"],
							"nombre" => $producto["nombre"],
							"sku" => $producto["sku"],
							"imagen1" => $tienda["imagen"],
							"imagen2" => $tienda["imagen2"],
							"imagen3" => $tienda["imagen3"],
							"idCategoria" => $tienda["id_categoria"],
							"idSubcategoria" => $tienda["id_subcategoria"],
							"nombreCategoria" => $categoria["nombre"],
							"nombreSubcategoria" => $subcategoria["nombre"]);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR INFORMACION DEL PRODUCTO TIENDA  ======*/
	
	/*==================================================
	=            AGREGAR PRODUCTO A TIENDA             =
	==================================================*/
	
	public $idCrearProductoTV;
	public $categoriaCrearProductoTV;
	public $subcategoriaCrearProductoTV;
	public $imagen1CrearProductoTV;
	public $imagen2CrearProductoTV;
	public $imagen3CrearProductoTV;
	public $codigoCrearProductoTV;
	public $precioCrearProductoTV;
	public $promoCrearProductoTV;

	public function ajaxAgregarProductoTienda(){

		$tabla = "tv_productos"; 
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"id_producto" => $this -> idCrearProductoTV,
						"codigo" => $this -> codigoCrearProductoTV,
						"imagen" => $this -> imagen1CrearProductoTV,
						"imagen2" => $this -> imagen2CrearProductoTV,
						"imagen3" => $this -> imagen3CrearProductoTV,
						"id_categoria" => $this -> categoriaCrearProductoTV,
						"id_subcategoria" => $this -> subcategoriaCrearProductoTV);

		$respuestaIngresar = ModeloProductosTienda::mdlAgregarProductoTienda($tabla, $datos);

		if ($respuestaIngresar == "ok") {

			/* 	CONSULTA DE LISTADO Y CREACION DE LISTADO DE PRECIOS DEL PRODUCTO */

			$tabla = "tv_productos_listado";
			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
							"codigo" => $this -> codigoCrearProductoTV);

			$listado = ModeloProductosTienda::mdlMostrarListadoPrecioProductoTienda($tabla, $datos);

			if ($listado == false) {
				
				$tabla = "tv_productos_listado";
				$promo = $this -> promoCrearProductoTV;
				$activado = "no";

				//if (floatval($this -> promoCrearProductoTV) < floatval($this -> precioCrearProductoTV)) {

					//$promo = $this -> promoCrearProductoTV;
					//$activado = "si";

				//}

				$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"codigo" => $this -> codigoCrearProductoTV,
								"cantidad" => 1,
								"precio" => $this -> precioCrearProductoTV,
								"promo" => $promo,
								"activadoPromo" => $activado);

				$respuestaListado = ModeloProductosTienda::mdlCrearListadoProductoTienda($tabla, $datos);

			}

			/* MOSTRAR INFORMACION DE PRODUCTOS EN TIENDA */

			$tabla = "tv_productos";
			$item = NULL;
			$valor = NULL;
			$empresa = $_SESSION["idEmpresa_dashboard"];
			$mostrar = ModeloProductosTienda::mdlMostrarProductosTienda($tabla, $item, $valor, $empresa);

			$respuesta = array();
			
			foreach ($mostrar as $key => $value) {

				$tablaProducto = "productos";
				$itemProducto = "id_producto";
				$valorProducto = $value["id_producto"];

				$producto = ModeloProductos::mdlMostrarProductos($tablaProducto, $itemProducto, $valorProducto, $empresa);
				
				array_push($respuesta, array("id_tv_productos" => $value["id_tv_productos"],
											"id_producto" => $producto["id_producto"],
											"codigo" => $producto["codigo"],
											"nombre" => $producto["nombre"],
											"descripcion" => $producto["descripcion"]));
			}
		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of AGREGAR PRODUCTO A TIENDA   ======*/

	/*===================================================
	=            ELIMINAR PRODUCTO DE TIENDA            =
	===================================================*/
	
	public $idEliminarProductoTV;

	public function ajaxEliminarProductoTienda(){

		$tabla = "tv_productos";
		$item = "id_tv_productos";
		$valor = $this -> idEliminarProductoTV;

		$respuesta = ModeloProductosTienda::mdlEliminarProductoTienda($tabla, $item, $valor);

		echo json_encode($respuesta);
		
	}
	
	/*=====  End of ELIMINAR PRODUCTO DE TIENDA  ======*/
	
	/*========================================================
	=            LISTADO DE PRECIO TIENDA VIRTUAL            =
	========================================================*/
	
	public $codigoProducto;

	public function ajaxListadoPreciosProductoTienda(){

		$tabla = "tv_productos_listado";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"codigo" => $this -> codigoProducto);

		$respuesta = ModeloProductosTienda::mdlMostrarListadoPrecioProductoTienda($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of LISTADO DE PRECIO TIENDA VIRTUAL  ======*/
	
	/*==================================================================
	=            MODIFICACION DE PRODUCTO GENERAL DE TIENDA            =
	==================================================================*/
	
	public $idProductoModificacionProducto;
	public $categoriaModificacionProducto;
	public $subcategoriaModificacionProducto;
	public $imagen1ModificacionProducto;
	public $imagen2ModificacionProducto;
	public $imagen3ModificacionProducto;
	
	public function ajaxModificarProductoTienda(){

		$tabla = "tv_productos";
		$datos = array("id_tv_productos" => $this -> idProductoModificacionProducto,
					"id_categoria" => $this -> categoriaModificacionProducto,
					"id_subcategoria" => $this -> subcategoriaModificacionProducto,
					"imagen" => $this -> imagen1ModificacionProducto,
					"imagen2" => $this -> imagen2ModificacionProducto,
					"imagen3" => $this -> imagen3ModificacionProducto);

		$respuesta = ModeloProductosTienda::mdlModificarProductoTienda($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MODIFICACION DE PRODUCTO GENERAL DE TIENDA  ======*/
	
	/*===============================================================
	=            MODIFICAR PRECIO DEL PRODUCTO DE TIENDA            =
	===============================================================*/
	
	public $idEditarListadoTienda;
	public $precioEditarListadoTienda;
	public $promoEditarListadoTienda;
	public $activarEditarListadoTienda;
	
	public function ajaxModificarListadoTienda(){

		$tabla = "tv_productos_listado";

		$datos = array("id_tv_productos_listado" => $this -> idEditarListadoTienda,
						"precio" => $this -> precioEditarListadoTienda,
						"promo" => $this -> promoEditarListadoTienda,
						"activadoPromo" => $this -> activarEditarListadoTienda);

		$respuesta = ModeloProductosTienda::mdlModificarListadoTienda($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of MODIFICAR PRECIO DEL PRODUCTO DE TIENDA  ======*/
		
	/*==================================================
	=            CREAR LISTADO DEL PRODUCTO            =
	==================================================*/
	
	public $codigoCrearListadoTienda;
	public $piezasCrearListadoTienda;
	public $costoCrearListadoTienda;

	public function ajaxCrearListadoTienda(){

		$tabla = "tv_productos_listado";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"codigo" => $this -> codigoCrearListadoTienda,
						"cantidad" => $this -> piezasCrearListadoTienda,
						"precio" => $this -> costoCrearListadoTienda,
						"promo" => $this -> costoCrearListadoTienda,
						"activadoPromo" => "no");

		$listado = ModeloProductosTienda::mdlCrearListadoProductoTienda($tabla, $datos);


		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"codigo" => $this -> codigoCrearListadoTienda);

		$respuesta = ModeloProductosTienda::mdlMostrarListadoPrecioProductoTienda($tabla, $datos);

		echo json_encode($respuesta);

	}

	
	/*=====  End of CREAR LISTADO DEL PRODUCTO  ======*/
	
	/*===========================================================
	=            ELIMINAR PRECIO DE LISTADO PRODUCTO            =
	===========================================================*/
	
	public $idListadoEliminar;
	public $codigoListadoEliminar;
	
	public function ajaxEliminarPrecioListado(){

		$tabla = "tv_productos_listado";
		$item = "id_tv_productos_listado";
		$valor = $this -> idListadoEliminar;

		$respuesta = ModeloProductosTienda::mdlEliminarPrecioProductoTienda($tabla, $item, $valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ELIMINAR PRECIO DE LISTADO PRODUCTO  ======*/

	/*==============================================================================================
	=                   MOSTRAR QUE PAQUETES TIENE LA EMPRESA DE PRODUCTOS EN TV                   =
	==============================================================================================*/
	
	public function ajaxMostrarPaqueteProductosEmpresa(){

		$tabla = "tv_productos_compras";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductosTienda::mdlMostrarPaqueteEmpresa($tabla, $empresa);

		echo json_encode($respuesta);

	}
	
	/*============  End of MOSTRAR QUE PAQUETES TIENE LA EMPRESA DE PRODUCTOS EN TV  =============*/
	
	public function ajaxMostrarProductosDataTable(){
		$tabla = "tv_productos";
		$item = null;
		$valor = null;

		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductosTienda::mdlMostrarProductosTienda($tabla, $item, $valor, $empresa);


		$tablaProductos = "productos";
		$array = [];
		$arrayPrueba = [];
		$arrayCodigo = [];
		foreach ($respuesta as $key => $value) {
		
			
			$item = "id_producto";
			$valor = $value["id_producto"];
			

			$producto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor, $empresa);
			
			array_push($array, $arrayPrueba= array("codigo" => $producto["codigo"],
													"nombre" => $producto["nombre"],
													"descripcion" => $producto["descripcion"],
													"id_producto" => $producto["id_producto"],
													"id_producto_tienda" => $value["id_tv_productos"],
													"img1" => $value["imagen"],
													"img2" => $value["imagen2"],
													"img3" => $value["imagen3"],
													"sku" => $producto["sku"],
													"stock_disponible" => $producto["stock_disponible"]));

			
		}

		echo json_encode($array);
	}
	/*========================================================
	=         Checar producto en TV               			 =
	========================================================*/
	
	public $idproductotocheck; 
	public function ajaxcheckptv(){
		
		$idproducto = $this -> idproductotocheck;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProductosTienda::mdlcheckenTV( $idproducto,$empresa);
		
		echo json_encode($respuesta);
	}
	
	/*=====  Checar producto en TV  ======*/
}

/*==============================================================
=            MOSTRAR INFORMACION DE PRODUCTO TIENDA            =
==============================================================*/

if (isset($_POST["idProductoTienda"])) {
	$mostrarProducto = new AjaxProductosTienda();
	$mostrarProducto -> idProductoTienda = $_POST["idProductoTienda"];
	$mostrarProducto -> ajaxMostrarProductoTienda();
}

/*=====  End of MOSTRAR INFORMACION DE PRODUCTO TIENDA  ======*/


/*========================================================
=            LISTADO DE PRECIO TIENDA VIRTUAL            =
========================================================*/

if (isset($_POST["codigoProducto"])) {
	$mostrarListado = new AjaxProductosTienda();
	$mostrarListado -> codigoProducto = $_POST["codigoProducto"];
	$mostrarListado -> ajaxListadoPreciosProductoTienda();
}
 
/*=====  End of LISTADO DE PRECIO TIENDA VIRTUAL  ======*/


/*=================================================
=            AGREGAR PRODUCTO A TIENDA            =
=================================================*/

if (isset($_POST["idCrearProductoTV"])) {
	$agregarProducto = new AjaxProductosTienda();
	$agregarProducto -> idCrearProductoTV = $_POST["idCrearProductoTV"];
	$agregarProducto -> categoriaCrearProductoTV = $_POST["categoriaCrearProductoTV"];
	$agregarProducto -> subcategoriaCrearProductoTV = $_POST["subcategoriaCrearProductoTV"];
	$agregarProducto -> imagen1CrearProductoTV = $_POST["imagen1CrearProductoTV"];
	$agregarProducto -> imagen2CrearProductoTV = $_POST["imagen2CrearProductoTV"];
	$agregarProducto -> imagen3CrearProductoTV = $_POST["imagen3CrearProductoTV"];
	$agregarProducto -> codigoCrearProductoTV = $_POST["codigoCrearProductoTV"];
	$agregarProducto -> precioCrearProductoTV = $_POST["precioCrearProductoTV"];
	$agregarProducto -> promoCrearProductoTV = $_POST["promoCrearProductoTV"];
	$agregarProducto -> ajaxAgregarProductoTienda();
}

/*=====  End of AGREGAR PRODUCTO A TIENDA  ======*/

/*===================================================
=            ELIMINAR PRODUCTO DE TIENDA            =
===================================================*/

if (isset($_POST["idEliminarProductoTV"])) {
	$eliminarProducto = new AjaxProductosTienda();
	$eliminarProducto -> idEliminarProductoTV = $_POST["idEliminarProductoTV"];
	$eliminarProducto -> ajaxEliminarProductoTienda();
}

/*=====  End of ELIMINAR PRODUCTO DE TIENDA  ======*/

/*==================================================================
=            MODIFICACION DE PRODUCTO GENERAL DE TIENDA            =
==================================================================*/

if (isset($_POST["idProductoModificacionProducto"])) {
	$modificarProducto = new AjaxProductosTienda();
	$modificarProducto -> idProductoModificacionProducto = $_POST["idProductoModificacionProducto"];
	$modificarProducto -> categoriaModificacionProducto = $_POST["categoriaModificacionProducto"];
	$modificarProducto -> subcategoriaModificacionProducto = $_POST["subcategoriaModificacionProducto"];
	$modificarProducto -> imagen1ModificacionProducto = $_POST["imagen1ModificacionProducto"];
	$modificarProducto -> imagen2ModificacionProducto = $_POST["imagen2ModificacionProducto"];
	$modificarProducto -> imagen3ModificacionProducto = $_POST["imagen3ModificacionProducto"];
	$modificarProducto -> ajaxModificarProductoTienda();
}

/*=====  End of MODIFICACION DE PRODUCTO GENERAL DE TIENDA  ======*/

/*===============================================================
=            MODIFICAR PRECIO DEL PRODUCTO DE TIENDA            =
===============================================================*/

if (isset($_POST["idEditarListadoTienda"])) {
	$modificarListado = new AjaxProductosTienda();
	$modificarListado -> idEditarListadoTienda = $_POST["idEditarListadoTienda"];
	$modificarListado -> precioEditarListadoTienda = $_POST["precioEditarListadoTienda"];
	$modificarListado -> promoEditarListadoTienda = $_POST["promoEditarListadoTienda"];
	$modificarListado -> activarEditarListadoTienda = $_POST["activarEditarListadoTienda"];
	$modificarListado -> ajaxModificarListadoTienda();
}

/*=====  End of MODIFICAR PRECIO DEL PRODUCTO DE TIENDA  ======*/

/*=================================================
=            CREAR LISTADO DE PRODUCTO            =
=================================================*/

if (isset($_POST["codigoCrearListadoTienda"])) {
	$crearListado = new AjaxProductosTienda();
	$crearListado -> codigoCrearListadoTienda = $_POST["codigoCrearListadoTienda"];
	$crearListado -> piezasCrearListadoTienda = $_POST["piezasCrearListadoTienda"];
	$crearListado -> costoCrearListadoTienda = $_POST["costoCrearListadoTienda"];
	$crearListado -> ajaxCrearListadoTienda();
}

/*=====  End of CREAR LISTADO DE PRODUCTO  ======*/

/*===========================================================
=            ELIMINAR PRECIO DE LISTADO PRODUCTO            =
===========================================================*/

if (isset($_POST["idListadoEliminar"])) {
	$eliminarListado = new AjaxProductosTienda();
	$eliminarListado -> idListadoEliminar = $_POST["idListadoEliminar"];
	$eliminarListado -> codigoListadoEliminar = $_POST["codigoListadoEliminar"];
	$eliminarListado -> ajaxEliminarPrecioListado();
}

/*=====  End of ELIMINAR PRECIO DE LISTADO PRODUCTO  ======*/

/*=============================================================================================
=                   MOSTRAR QUE PAQUETE TIENE LA EMPRESA DE PRODUCTOS EN TV                   =
=============================================================================================*/

if(isset($_POST["paqueteObtenido"])){

	$paqueteMostrar = new AjaxProductosTienda();
	$paqueteMostrar -> ajaxMostrarPaqueteProductosEmpresa();

}

/*============  End of MOSTRAR QUE PAQUETE TIENE LA EMPRESA DE PRODUCTOS EN TV  =============*/

/*=================================================================
=                   MOSTRAR PRODCTOS DATA TABLE                   =
=================================================================*/

if (isset($_POST["opcion"])) {
	$mostrarDataTable = new AjaxProductosTienda();
	$mostrarDataTable -> ajaxMostrarProductosDataTable();
}


/*============  End of MOSTRAR PRODCTOS DATA TABLE  =============*/
/*========================================================
=            Checar producto en TV                        =
========================================================*/

if (isset($_POST["checktvtodel"])) {
	$checkprod = new AjaxProductosTienda();
	$checkprod -> idproductotocheck = $_POST["checktvtodel"];
	$checkprod -> ajaxcheckptv();
}

/*=====  Checar producto en TV   ======*/

?>