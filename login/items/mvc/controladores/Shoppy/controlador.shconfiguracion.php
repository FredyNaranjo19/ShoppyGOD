<?php

class ControladorConfiguracion{

    static public function MostrarConfuguracionPago($item, $valor){

        $tabla = "sh_configuracion_pagos";

        $respuesta = ShConfiguracion::MostrarConfiguracionPago($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ShMostrarConfiguracionEntregas($item, $valor){

        $tabla = "sh_configuracion_entregas";

        $respuesta = ShConfiguracion::MostrarConfiguracionEntregas($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ShMostrarConfiguracionCostoEnvio($item, $valor){
        $tabla = "sh_configuracion_costo_envios";

        $respuesta = ShConfiguracion::MostrarConfiguracionCostoEnvio($tabla, $item, $valor);

        return $respuesta;
    }

    static public function ShMostrarInformacionIva($empresa){
        $respuesta = ShConfiguracion::MostrarInformacionIva($empresa);
        return $respuesta;
    }

    static public function MostarInformacionCliente($item, $valor){
        $tabla = "clientes_direccion_empresa";

        $respuesta = ShConfiguracion::MostrarInformacionCliente($tabla, $item, $valor);

        return $respuesta;
    }
}