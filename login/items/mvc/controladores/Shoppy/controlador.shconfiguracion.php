<?php

class CtrConfiguracionSh
{
    static public function ShMostrarConfiguracionPago($item, $valor){

        $tabla = "sh_configuracion_pagos";

        $respuesta = ShConfiguracion::shMostrarConfiguracionPago($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ShMostrarConfiguracionEntregas($item, $valor){

        $tabla = "sh_configuracion_entregas";

        $respuesta = ShConfiguracion::shMostrarConfiguracionEntregas($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ShMostrarConfiguracionCostoEnvio($item, $valor){
        
        $tabla = "sh_configuracion_costo_envios";

        $respuesta = ShConfiguracion::shMostrarConfiguracionCostoEnvio($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ShEmpresas($empresa){
        $respuesta = ShConfiguracion::shEmpresas($empresa);

        return $respuesta;
    }
}