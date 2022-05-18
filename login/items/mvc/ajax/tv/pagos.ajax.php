<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/tv/modelo.carrito.php';
require_once '../../modelos/tv/modelo.pedidos.php';
require_once '../../modelos/tv/modelo.productos.php';

class AjaxPagoPedido{

	/*========================================
	=            PAGO EN EFECTIVO            =
	========================================*/
	
	public $empresaPago;
	public $totalPago;
	public $direccionPago;
	public $tipoPago;
	public $cardPago;

	public function ajaxProcesarPago(){

		$tablaPedidos = "tv_pedidos";
		$folio = $_SESSION["id"]."-".rand(100, 100000);
		$metodoPago = "Efectivo";
		$estado_pedido = "Comprobante Pediente";
		$estado_entrega = "Subir Comprobante";
		$tipo = explode("-", $this -> direccionPago);	

		$domicilio = $tipo[1];


		$datosPedido = array("id_empresa" => $this -> empresaPago,
							 "folio" => $folio,
							 "id_cliente" => $_SESSION["id"],
							 "metodo_pago" => $metodoPago,
							 "total" => $this -> totalPago,
							 "estado" => $estado_pedido);

		$tablaEntregaPedido = "tv_pedidos_entregas";

		$datosEntregaPedido = array("id_empresa" => $this -> empresaPago,
									"folio" => $folio,
									"estado_entrega" => $estado_entrega,
									"id_domicilio" => $domicilio);

		$tabla = "tv_carrito";
		$item = "id_cliente";
		$datos = array("id_cliente" => $_SESSION["id"],
                        "id_empresa" => $this -> empresaPago);

		$resultadoAgrupado = ModeloCarrito::mdlMostrarCarritoAgrupado($tabla, $datos);

		foreach ($resultadoAgrupado as $key => $agrupado) {

			$datos = array("modelo" => $agrupado["modelo"],
                            "id_empresa" => $this -> empresaPago,
                            "id_cliente" => $_SESSION["id"],
                            "opcion" => 2);

			$resultado = ModeloCarrito::mdlMostrarCarrito($tabla,$datos);

			foreach ($resultado as $key => $value) {

				$datos = array("id_empresa" => $this -> empresaPago,
                                "codigo" => $agrupado["modelo"]);

				$tablaListadoPrecio = "tv_productos_listado";

				$preciosResultado = ModeloProductos::mdlMostrarPreciosProducto($tablaListadoPrecio, $datos);

				foreach ($preciosResultado as $key => $precio) {

					if ($agrupado["cantidad"] >= $precio["cantidad"]) {

						if ($precio['activadoPromo'] == "si") {

                            $costoProducto = $precio['promo'];

                        } else {

                            $costoProducto = $precio['precio'];

                        } 
					}

				}

				$tablaDetalle = "tv_pedidos_detalle";
				$datosDetalle = array("id_empresa" => $this -> empresaPago,
									"folio" => $folio,
			    					"id_producto" => $value["id_producto"],
			    					"cantidad" => $value["cantidad"],
			    					"costo" => $costoProducto);

				$detalle = ModeloPedidos::mdlCrearDetallePedido($tablaDetalle,$datosDetalle);

				$tablaEditarProducto = "productos";
		    	$datosEditarProducto = array("id_producto" => $value["id_producto"],
		    						 		"cantidad" => $value["cantidad"]);
		    	$editarProducto = ModeloProductos::mdlEditarStock($tablaEditarProducto,$datosEditarProducto);
				
			}
		}

		$pedido = ModeloPedidos::mdlCrearPedido($tablaPedidos, $datosPedido);

		$pedidoEntrega = ModeloPedidos::mdlCrearEntregaPedido($tablaEntregaPedido, $datosEntregaPedido);

			if ($pedido == "ok") {
				$eliminar = ModeloCarrito::mdlEliminarCarrito($tabla, $item, $_SESSION["id"]);

				if ($eliminar == "ok") {
					
					$respuesta = $folio;

				} else {

					$respuesta = "error";

				}

			} else {
				
				$respuesta = "error";

			}


		echo json_encode($respuesta);
	}
	
	/*=====  End of PAGO EN EFECTIVO  ======*/	

}


/*========================================
=            PAGO EN EFECTIVO            =
========================================*/

if (isset($_POST["direccionPago"])) {
	$crearVenta = new AjaxPagoPedido();
	$crearVenta -> empresaPago = $_POST["empresaPago"];
	$crearVenta -> totalPago = $_POST["totalPago"];
	$crearVenta -> direccionPago = $_POST["direccionPago"];
	$crearVenta -> tipoPago = $_POST["tipoPago"];
	$crearVenta -> cardPago = $_POST["cardPago"];
	$crearVenta -> ajaxProcesarPago();
}

/*=====  End of PAGO EN EFECTIVO  ======*/

?>