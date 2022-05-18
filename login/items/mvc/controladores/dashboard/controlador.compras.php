<?php

class ControladorCompras{

    /*=====================================================================
    =                   MOSTRAR CONTENIDO DE LA EMPRESA                   =
    =====================================================================*/
    
    static public function ctrMostrarElementosEmpresa(){

        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuesta = ModeloCompras::mdlMostrarElementosEmpresa($empresa);

        return $respuesta;
    }
    
    /*============  End of MOSTRAR CONTENIDO DE LA EMPRESA  =============*/

    /*===================================================================================
    =                   MOSTRAR REGISTRO DE COMPRA VENDEDORES ALMACEN                   =
    ===================================================================================*/
    
    static public function ctrMostrarComprasVendedoresAlmacen($item, $valor){

        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuesta = ModeloCompras::mdlMostrarComprasVendedoresAlmacen($item, $valor, $empresa);

        return $respuesta;
    }
    
    /*============  End of MOSTRAR REGISTRO DE COMPRA VENDEDORES ALMACEN  =============*/

    /*==========================================================================
    =                   MOSTRAR REGISTRO DE COMPRA ALMACENES                   =
    ==========================================================================*/
    
    static public function ctrMostrarComprasAlmacenes($item, $valor){

        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuesta = ModeloCompras::mdlMostrarComprasAlmacenes($item, $valor, $empresa);

        return $respuesta;
    }
    
    /*============  End of MOSTRAR REGISTRO DE COMPRA ALMACENES  =============*/

    /*======================================================================================
    =                   MOSTRAR REGISTRO DE COMPRA ESPACIOS PRODUCTOS TV                   =
    ======================================================================================*/
    
    static public function ctrMostrarComprasProductosTV(){

        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuesta = ModeloCompras::mdlMostrarComprasProductosTV($empresa);

        return $respuesta;
    }
    
    /*============  End of MOSTRAR REGISTRO DE COMPRA ESPACIOS PRODUCTOS TV  =============*/
    /*=====================================================================
    =                   MOSTRAR COMPRAS CREDITOS                   =
    =====================================================================*/
    
    static public function ctrMostrarComprasCreditos(){

        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuesta = ModeloCompras::mdlMostrarComprasCreditos($empresa);

        return $respuesta;
    }
    
    /*============  End of MOSTRAR COMPRAS CREDITOS  =============*/
}

?>