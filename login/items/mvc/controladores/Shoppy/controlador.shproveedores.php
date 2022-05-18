<?php
class CtrShProveedores
{
    static public function ShMostrarLogo($item, $valor){

		$tabla = "sh_configuracion_logo";

		$respuesta = ShProveedores::MostrarLogo($tabla, $item, $valor);

		return $respuesta;
	}

    public static function ctrGetProveedores()
    {
        $respuesta = ShProveedores::getProveedores();
        return $respuesta;
    }

    public static function ctrGetProductosCategoria($idProveedor,$idCategoria){
        $respuesta = ShProveedores::getProductosCategoria($idProveedor,$idCategoria);
        return $respuesta;
    }

}
