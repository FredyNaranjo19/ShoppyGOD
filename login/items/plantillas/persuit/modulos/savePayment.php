<?php

	/* VARIABLES DE CARRITO DE COMPRAS */
	$tablaPedidos = "tv_pedidos";
	$folio = $_SESSION["id"]."-".rand(100, 1000000);
	$metodoPago = "Tarjeta";
	$estado_pedido = "Aprobado";
	$estado_entrega = "En preparación";
	$cliente = $_SESSION["id"];
	$separacion = explode("-", $_GET["dir"]);

    $domicilio = $separacion[1];

    

    $datosPedido = array("id_empresa" => $empresa["id_empresa"],
    					 "folio" => $folio,
						 "id_cliente" => $cliente,
						 "metodo_pago" => $metodoPago,
						 "total" => $separacion[2],
						 "estado" => $estado_pedido);

    $tablaEPedidos = "tv_pedidos_entregas";

	$datosEPedido = array("id_empresa" => $empresa["id_empresa"],
							"folio" => $folio,
							"estado_entrega" => $estado_entrega,
							"id_domicilio" => $domicilio);

	$tabla = "tv_carrito"; 
	$datos = array("id_cliente" => $cliente,
                   "id_empresa" => $empresa["id_empresa"]);

	$resultadoAgrupado = ModeloCarrito::mdlMostrarCarritoAgrupado($tabla,$datos);

	foreach ($resultadoAgrupado as $key => $agrupado) {


        $datos = array("modelo" => $agrupado["modelo"],
                        "id_empresa" => $empresa["id_empresa"],
                        "id_cliente" => $_SESSION["id"],
                        "opcion" => 2);

        $resultado = ModeloCarrito::mdlMostrarCarrito($tabla,$datos);
        foreach ($resultado as $key => $value) {
            // $itemPrecio = "sku";
            // $valorPrecio = $agrupado[0];

            $datos = array("id_empresa" => $empresa["id_empresa"],
                            "codigo" => $agrupado["modelo"]);

            $preciosResultado = ControladorProductos::ctrMostrarPreciosProducto($datos);

            // foreach ($preciosResultado as $key => $precio) {
            //     if ($agrupado[1] >= $precio[2]) {
            //         $costoProducto = $precio[3];
            //     }
            // }

            // var_dump($preciosResultado);

            foreach ($preciosResultado as $key => $precio) {

				if ($agrupado["cantidad"] >= $precio["cantidad"]) {

					if ($precio['activadoPromo'] == "si") {

                        $costoProducto = $precio['promo'];

                    } else {

                        $costoProducto = $precio['precio'];

                    } 
				}

			}

			echo $costoProducto."<br>";


            $tablaDetalle = "tv_pedidos_detalle";
			$datosDetalle = array("id_empresa" => $empresa["id_empresa"],
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

	$nuevaURL = "index.php?ruta=successfulPayment&&folio=".$folio;

	$pedido = ModeloPedidos::mdlCrearPedido($tablaPedidos, $datosPedido);
	$pedidoEntrega = ModeloPedidos::mdlCrearEntregaPedido($tablaEPedidos, $datosEPedido);

    if ($pedido == "ok") {

        $tablaCarrito = "carrito"; 
        $itemCarrito = "id_cliente";
        $valorCarrito = $_SESSION["id"];
        $eliminar = ModeloCarrito::mdlEliminarCarrito($tablaCarrito,$itemCarrito,$valorCarrito);

        echo '<script> window.location="index.php?ruta=successfulPayment&&folio='.$folio.'"</script>';

    }

?>