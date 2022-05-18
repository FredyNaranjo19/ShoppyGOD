<?php

class AjaxProductos{

	public $FavoritoIdProducto;
	public $FavoritoIdCliente;

	public function ajaxProductoFavorito(){

		$tabla = "sh_productos_favoritos";
		
		$datos = array("id_producto" => $this -> FavoritoIdProducto,
						"id_cliente" => $this -> FavoritoIdCliente);

		$consulta= ModeloProductos::mdlProductoFavorito($tabla, $datos);

		if ($consulta == false) {
			
			$respuesta = ModeloProductos::mdlCrearProductoFavorito($tabla,$datos);

		} else {

			$respuesta = ModeloProductos::mdlEliminarProductoFavorito($tabla,$datos);
			
		}

		echo json_encode($respuesta);
	}

}

if (isset($_POST["FavoritoIdProducto"])) {

	$favoritos = new AjaxProductos();
	$favoritos -> FavoritoIdProducto = $_POST["FavoritoIdProducto"];
	$favoritos -> FavoritoIdCliente = $_POST["FavoritoIdCliente"];
	$favoritos -> ajaxProductoFavorito();

}

?>