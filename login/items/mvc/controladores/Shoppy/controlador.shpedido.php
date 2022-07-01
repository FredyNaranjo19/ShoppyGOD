<?php 

class CtrPedidosSh
{
	static public function ShMostarPedidos($item, $valor, $empresa){

		$tabla = "sh_pedidos";

		$respuesta = ShPedidos::shMostrarPedidos($tabla, $item, $valor, $empresa);

		return $respuesta;
	}

	static public function ShMostrarPedidosPaginados($datos){

		$respuesta = ShPedidos::shMostrarPedidosPaginados($datos);

		return $respuesta;
	}

	static public function ShMostrarDetallesPedido($item, $valor, $empresa){

		$tabla = "sh_pedidos_detalle";

		$respuesta = ShPedidos::shMostrarDetallePedido($tabla, $item, $valor, $empresa);

		return $respuesta;
	}

	static public function ShMostrarEntregaPedido($item, $valor, $empresa){

		$tabla = "sh_pedidos_entregas";

		$respuesta = ShPedidos::shMostrarEntregaPedido($tabla, $item, $valor, $empresa);

		return $respuesta;
	}

	static public function ShAgregarFichaPago(){

		if(isset($_POST['eFolioPago'])){

			$tabla = "sh_pedidos_comprobante_pago";

			$estadoPedido = "Comprobante subido";
			$estadoEntrega = "Checando comprobante";

			$datos = array("id_proveedor" => $_POST["empresa"], "folio" => $_POST["eFolioPago"],"monto" => $_POST["nMonto"], "comprobante" => $_POST["nTicketCompra"], "estado" => $estadoEntrega);

			$tablaPedidos = "sh_pedidos";
			$datosPedidos = array("folio" => $_POST["eFolioPago"], "estado" => $estadoPedido);

			$respuestaPedido = ShPedidos::shCambioEstadoPedido($tablaPedidos, $datosPedidos);

			$tablaEPedidos = "sh_pedidos_entregas";
			$datosEPedido = array("folio" =>$_POST["eFolioPago"], "estado_entrega" => $estadoEntrega, "id_proveedor" => $_POST["proveedor"]);

			$respuestaEntrega = ShPedidos::shCambioEstadoEntrega($tablaEPedidos, $datosEPedido);

			$item = "folio";
			$valor = $_POST["eFolioPago"];
			$id_proveedor = $_POST["proveedor"];

			$comprobante = ShPedidos::shMostrarComprobanteEfectivo($tabla, $item, $valor, $id_empresa);

			if ($comprobante != false){

				$respuesta = ShPedidos::shEditarFichaPago($tabla, $datos);
			} else {
				$respuesta = ShPedidos::shAgregarFichaPago($tabla, $datos);
			}

		}
	}
}
?>  