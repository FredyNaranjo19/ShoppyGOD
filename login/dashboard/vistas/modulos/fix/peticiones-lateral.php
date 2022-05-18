<?php 

session_start();
require_once '../../../../items/mvc/modelos/conexion.php';
require_once '../../../../items/mvc/controladores/dashboard/controlador.ventasCedis.php';
require_once '../../../../items/mvc/modelos/dashboard/modelo.ventasCedis.php';


class notificaciones{

    public function notificacionesPedidosPorEmpresa(){
        
        $menuPorValorar = 0;
        $menuSinComprobante = 0;
        $menuEnPreparacion = 0;
        $menuEnGuia = 0;
        $menuListoSucursal = 0;
        $menuEnviado = 0;
        
        $menuTotal = 0;

        $item = "id_empresa";
        $valor = $_SESSION["idEmpresa_dashboard"];

        $respuesta = ControladorVentasCedis::ctrMostrarCantidadPedidosPorEstado($item, $valor);

        foreach ($respuesta as $key => $value) {
            if ($value["estado"] == "Sin comprobante") {
                $menuSinComprobante = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            if ($value["estado"] == "Por valorar") {
                $menuPorValorar = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            if ($value["estado"] == "En preparacion") {
                $menuEnPreparacion = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            if ($value["estado"] == "En guia") {
                $menuEnGuia = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            if ($value["estado"] == "Listo en sucursal") {
                $menuListoSucursal = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            // if ($value["estado"] == "Enviado") {
            //     $menuEnviado = $value["cantidad"];
            //     $menuTotal += $value["cantidad"];
            // }
        }

        $datos = array("sinComprobante" => $menuSinComprobante,
                "porValorar" => $menuPorValorar,
                "enPreparacion" => $menuEnPreparacion,
                "enGuia" => $menuEnGuia,
                "enSucursal" => $menuListoSucursal,
                // "enviado" => $menuEnviado,
                "total" => $menuTotal);

        echo json_encode($datos);
    }

    public function notificacionesPedidosPorVendedorCedis(){
        
        $menuEnPreparacion = 0;
        $menuEnGuia = 0;
        $menuListoSucursal = 0;
        
        $menuTotal = 0;

        $item = "id_usuario_plataforma";
        $valor = $_SESSION["id_dashboard"];

        $respuesta = ControladorVentasCedis::ctrMostrarCantidadPedidosPorEstado($item, $valor);

        foreach ($respuesta as $key => $value) {
            
            if ($value["estado"] == "En preparacion") {
                $menuEnPreparacion = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            if ($value["estado"] == "En guia") {
                $menuEnGuia = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
            if ($value["estado"] == "Listo en sucursal") {
                $menuListoSucursal = $value["cantidad"];
                $menuTotal += $value["cantidad"];
            }
        }

        $datos = array(
                "enPreparacion" => $menuEnPreparacion,
                "enGuia" => $menuEnGuia,
                "enSucursal" => $menuListoSucursal,
                // "enviado" => $menuEnviado,
                "total" => $menuTotal);

        echo json_encode($datos);
    }
}

/*================================================================
=                   NOTIFICACIONES POR EMPRESA                   =
================================================================*/

if (isset($_POST["empresa"])) {
    $notificacion = new notificaciones();
    $notificacion -> notificacionesPedidosPorEmpresa();
}

/*============  End of NOTIFICACIONES POR EMPRESA  =============*/

/*=======================================================================
=                   NOTIFICACIONES POR VENDEDOR CEDIS                   =
=======================================================================*/

if (isset($_POST["vendedorCedis"])) {
    $notificacion = new notificaciones();
    $notificacion -> notificacionesPedidosPorVendedorCedis();
}

/*============  End of NOTIFICACIONES POR VENDEDOR CEDIS  =============*/