<?php

class AjaxMakeOrder
{

    public $empresaPago;
    public $totalPago;
    public $direccionPago;
    public $tipoPago;
    public $cardPago;
    public $tipoEnvio;

    public function procesarPedido()
    {

        $tabla_pedidos = "sh_pedidos";
        $tablaEntregaPedido = "sh_pedidos_entregas";
        $tablaCarrito = "sh_carrito";
        $tablaListadoPrecio = "sh_producto_listado";
        $tablaDetalle = "sh_pedidos_detalle";
        $tablaProductos = "sh_productos";

        $folio = $_SESSION["id"] . "-" . rand(100, 100000);
        $metodoPago = "Whatsapp";
        $estado_pedido = "Comprobante Pendiente";
        $estado_entrega = "Subir Comprobante";
        $tipo = $this->direccionPago;
        $tipoEnvio = $this->tipoEnvio;
        $domicilio = $tipo;
        $item = "id_cliente";
        $volumenTotalCarrito = 0;
        $pesoTotalCarrito = 0;

        $datosPedido = array(
            "id_empresa" => $this->empresaPago,
            "folio" => $folio,
            "id_cliente" => $_SESSION["id"],
            "metodo_pago" => $metodoPago,
            "total" => $this->totalPago,
            "estado" => $estado_pedido
        );

        if ($tipoEnvio == "domicilio") {

            $datosEntregaPedido = array(
                "id_empresa" => $this->empresaPago,
                "folio" => $folio,
                "estado_entrega" => $estado_entrega,
                "id_domicilio" => $domicilio,
                "tipoEntrega" => $tipoEnvio
            );
        } else if ($tipoEnvio == "sucursal") {
            $datosEntregaPedido = array(
                "id_empresa" => $this->empresaPago,
                "folio" => $folio,
                "estado_entrega" => $estado_entrega,
                "id_punto_entrega" => $domicilio,
                "tipoEntrega" => $tipoEnvio
            );
        }
        $configEnvio = ModeloConfiguracion::mdlMostrarConfiguracionCostoEnvio("sh_configuracion_costo_envios", "id_empresa", $this->empresaPago);
        $pedido = ShPedidos::mdlCrearPedido($tabla_pedidos, $datosPedido);
        $iva = ModeloConfiguracion::mdlMostrarInformacionIva($this->empresaPago);

        if ($pedido == 'ok') {
            $datos = array("id_cliente" => $_SESSION["id"], "id_empresa" => $this->empresaPago);
            $resultadoAgrupado = ShCarrito::mdlMostrarCarritoAgrupado($tablaCarrito, $datos);
            foreach ($resultadoAgrupado as $key => $agrupado) {
                $datos = array(
                    "modelo" => $agrupado["modelo"],
                    "id_empresa" => $this->empresaPago,
                    "id_cliente" => $_SESSION["id"],
                    "opcion" => 2
                );
                $resultado = ShCarrito::mdlMostrarCarrito($tablaCarrito, $datos);
                foreach ($resultado as $key => $value) {
                    $datos = array(
                        "id_empresa" => $this->empresaPago,
                        "codigo" => $agrupado["modelo"]
                    );

                    $datosCalculo = array(
                        "id_empresa" => $this->empresaPago,
                        "id_producto" => $value["id_producto"]
                    );
                    $tablaCalculo = "productos";
                    $calculoInfo = ShProductos::mdlMostrarCalculosEnvioProducto($tablaCalculo, $datosCalculo);

                    $medidas = json_decode($calculoInfo["medidas"], true);
                    $volumenProducto = floatval($medidas[0]["largo"]) * floatval($medidas[0]["ancho"]) * floatval($medidas[0]["alto"]);
                    $volumenProductoTotal = $volumenProducto * $value['cantidad'];
                    $pesoProductoTotal = $calculoInfo['peso'] * $value["cantidad"];

                    $volumenTotalCarrito = $volumenTotalCarrito + $volumenProductoTotal;
                    $pesoTotalCarrito = $pesoTotalCarrito + $pesoProductoTotal;

                    $precioResultado = ShProductos::mdlMostrarPreciosProducto($tablaListadoPrecio, $datos);

                    if (count($precioResultado) > 1) {

                        foreach ($precioResultado as $key => $precio) {
                            if ($value["cantidad"] >= $precio["cantidad"]) {

                                $costoProducto = $precio['precio'];
                                $costoBase = $precio['costo'];

                                break;
                            }
                        }
                    } else {
                        foreach ($precioResultado as $key => $precio) {


                            if ($precio['activadoPromo'] == "si") {

                                $costoProducto = $precio['promo'];
                                $costoBase = $precio['costo'];
                            } else {

                                $costoProducto = $precio['precio'];
                                $costoBase = $precio['costo'];
                            }
                        }
                    }
                  
                    if ($iva["usar_iva"] == "si") {
                        if ($iva["incluido"] == "si") {
                            $costoProducto == "si";
                        } else {
                        }
                    } else {
                    }

                    $montoTotal= $value["cantidad"] * $costoProducto;
                    $montoBase= $value["cantidad"] * $costoBase;

                    $datosDetalle = array(
                        "id_empresa" => $this->empresaPago,
                        "folio" => $folio,
                        "id_producto" => $value["id_producto"],
                        "monto" =>$montoTotal,
                        "cantidad" => $value["cantidad"],
                        "costo" => $costoProducto,
                        "costo_listado" => $costoBase,
                        "utilidad" => $montoTotal - $montoBase
                    );

                    $detalle = ShPedidos::mdlCrearDetallePedido($tablaDetalle, $datosDetalle);

                    $tablaEditarProducto = "productos";
                    $datosEditarProducto = array(
                        "id_producto" => $value["id_producto"],
                        "cantidad" => $value["cantidad"]
                    );
                    $editarProducto = ShProductos::mdlEditarStock($tablaEditarProducto, $datosEditarProducto);
                }
            }

            if ($tipoEnvio == "domicilio") {
                foreach ($configEnvio  as $key => $costosValor) {

                    if ($volumenTotalCarrito <= $costosValor['peso_volumetrico'] && $costosValor["peso_masa"]) {
                        $costoEnvioTotal = $costosValor["precio"];
                        break;
                    }
                }
            } else {
                $costoEnvioTotal = 0;
            }
            $dataCosto = array(
                "envio" => $costoEnvioTotal,
                "folio" => $folio,
                "id_empresa" => $this->empresaPago
            );
            $insertarCostoEnvio = ShPedidos::mdlinsertarCostoEnvio("sh_pedidos", $dataCosto);
            $eliminar = ShCarrito::mdlEliminarCarrito($tablaCarrito, $item, $_SESSION["id"]);


            if ($tipoEnvio == "domicilio") {
                $pedidoEntrega = ShPedidos::mdlCrearEntregaPedido($tablaEntregaPedido, $datosEntregaPedido);
            } else if ($tipoEnvio == "sucursal") {
                $pedidoEntrega = ShPedidos::mdlCrearEntregaPedidoSucursal($tablaEntregaPedido, $datosEntregaPedido);
            }

            $respuesta = $folio;
        } else {

            $respuesta = "error";
        }


        echo json_encode($respuesta);
    }
}


if (isset($_POST["direccionPago"])) {
    $crearVenta = new AjaxMakeOrder();
    $crearVenta->empresaPago = $_POST["empresaPago"];
    $crearVenta->tipoEnvio = $_POST["tipoEnvio"];
    $crearVenta->totalPago = $_POST["totalPago"];
    $crearVenta->direccionPago = $_POST["direccionPago"];
    $crearVenta->tipoPago = $_POST["tipoPago"];
    $crearVenta->cardPago = $_POST["cardPago"];
    $crearVenta->procesarPedido();
}
    