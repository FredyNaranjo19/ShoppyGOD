<?php

class ControladorConfiguracion{

    static public function shMostrarConfiguracionPago($item, $valor){

        $tabla = "sh_configuracion_pagos";

        $respuesta = ShConfiguracion::shMostrarConfiguracionPago($tabla, $item, $valor);

        return $respuesta;
    }

    static public function shMostrarConfiguracionEntregas($item, $valor){

        $tabla = "sh_configuracion_entregas";

        $respuesta = ShConfiguracion::shMostrarConfiguracionEntregas($tabla, $item, $valor);

        return $respuesta;
    }

    static public function shMostrarConfiguracionCostoEnvio($item, $valor){
        $tabla = "sh_configuracion_costo_envios";

        $respuesta = ShConfiguracion::shMostrarConfiguracionCostoEnvio($tabla, $item, $valor);

        return $respuesta;
    }

    static public function shEmpresas($empresa){
        $respuesta = ShConfiguracion::shEmpresas($empresa);

        return $respuesta;
    }
}