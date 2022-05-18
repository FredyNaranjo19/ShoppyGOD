<?php

class AjaxOrderMSJ{

    public $folio;
    public $idEmpresa;

    public function crearMensaje(){
        $tablaPedido = "sh_pedidos";
        $tablaPedidosDetalles = "sh_pedidos_detalle";
        $folioPedido = $this -> folio;
        $idEmpresa = $this -> idEmpresa;


        $verificarEnvio = ShPedidos::mdlVerificarTipoEntrega($folioPedido, $idEmpresa);
        $tipoEnvio = $verificarEnvio["tipo_entrega"];
        $impuestos = ShConfig::mdlMostrarInformacionIva($idEmpresa);
        if($tipoEnvio == "domicilio"){
            $pedido = ShPedidos::mdlMostrarPedidoIndividual($tablaPedido, $folioPedido, $idEmpresa);
        }else if($tipoEnvio == "sucursal"){
            $pedido = ShPedidos::mdlMostrarPedidoInduvidualSucursal($tablaPedido, $folioPedido, $idEmpresa);
        }
        $pedidoExpandido = ShPedidos::mdlMostrarProductosPedido($tablaPedidosDetalles, $folioPedido, $idEmpresa);

        $datos = array(
            "pedidoInfo" => $pedido,
            "pedidoExpandido" => $pedidoExpandido,
            "impuestos" => $impuestos
        );
        echo json_encode($datos);
    }
}

if(isset($_POST["folio"])){
    $crearMensaje = new AjaxOrderMSJ();
    $crearMensaje -> folio = $_POST["folio"];
    $crearMensaje -> idEmpresa = $_POST["idEmpresa"];
    $crearMensaje -> crearMensaje();
}