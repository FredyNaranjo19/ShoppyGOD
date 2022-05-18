<?php

class ControladorVendedorextPedidos{
    static public function ctrCrearPedido(){ 
        
    }

    /*====================================================
	=            MOSTRAR PEDIDOS VENDEDOR EXT.          =
	====================================================*/

    static public function ctrMostrarPedidos($item, $valor,$vendedor){
        $tabla = "vendedorext_pedidos";
        $id_empresa = $_SESSION["idEmpresa_dashboard"];

        $respuesta = ModeloVendedorextPedidos::mdlMostrarPedidos($tabla, $item, $valor, $id_empresa, $vendedor);

        return $respuesta;
    }
    /*=====  End of MOSTRAR PEDIDOS VENDEDOR EXT. ======*/

    /*============================================================
	=            MOSTRAR TODOS LOS PEDIOS DE LA EMPRESA           =
	============================================================*/

    static public function ctrMostrarVentasEmpresa($item, $valor){
		$tabla = "vendedorext_pedidos";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloVendedorextPedidos::mdlMostrarPedidosEmpresa($tabla, $item, $valor, $empresa);

		return $respuesta;
	}

    /*=====  End of MOSTRAR TODAS LAS VENTAS DE LA EMPRESA  ======*/
    static public function ctrMostrarDetallesPedido($datos){

        $respuesta = ModeloVendedorextPedidos::mdlMostrarDetallesPedido($datos);

        return $respuesta;
    }



    static public function ctrMostrarPedidosPagos($datos){
        $tabla = "vendedorext_pedidos_pagos";

        $id_usuario_plataforma = $_SESSION["id_dashboard"];
        $id_empresa = $_SESSION["idEmpresa_dashboard"];

        $respuesta = ModeloVendedorextPedidos::mdlMostrarPedidosPagos($tabla,$datos,$id_usuario_plataforma, $id_empresa);

        return $respuesta;
    }

    /*=================================================================
	=                   MOSTRAR PAGOS EN VENTAS DIA                   =
	=================================================================*/
	
	static public function ctrMostrarPedidosPagosCorteDia($datos){
        
		$respuesta = ModeloVendedorextPedidos::mdlMostrarVentasPagosCorteDia($datos);

		return $respuesta;
	}
	
	/*============  End of MOSTRAR PAGOS EN VENTAS DIA  =============*/

    /*=================================================================
    =                   MOSTRAR MONTO TOTAL DEL DIA                   =
    =================================================================*/
    static public function ctrCorteDiaVendExt($datos){
        $tabla = "vendedorext_pedidos";

        $respuesta = ModeloVendedorextPedidos::mdlCorteDiaVendExt($tabla, $datos);

        return $respuesta;
    }

    /*=========================================================================
    =                   MOSTRAR CORTES DE CAJA VENDEDOR EXT                   =
    =========================================================================*/
    
    static public function ctrMostrarCortesPedidosVendExt($datos){
        $tabla = "vendedorext_pedidos_cortes";
        $id_empresa = $_SESSION["idEmpresa_dashboard"];

        $respuesta = ModeloVendedorextPedidos::mdlMostrarCortesPedidosVendExt($tabla, $datos, $id_empresa);

        return $respuesta;
    }
    

    
    
    
}

?>