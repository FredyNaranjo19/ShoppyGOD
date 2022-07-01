<?php

class AjaxProductos{

	public $FavoritoIdProducto;
	public $FavoritoIdCliente;

	public function ajaxProductoFavorito(){

		$tabla = "sh_productos_favoritos";
		
		$datos = array("id_producto" => $this -> FavoritoIdProducto,
						"id_cliente" => $this -> FavoritoIdCliente);

		$consulta= ShProductos::shProductoFavorito($tabla, $datos);

		if ($consulta == false) {
			
			$respuesta = ShProductos::shCrearProductoFavorito($tabla,$datos);

		} else {

			$respuesta = ShProductos::shEliminarProductoFavorito($tabla,$datos);
			
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