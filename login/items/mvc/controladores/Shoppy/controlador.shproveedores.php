<?php
class CtrShProveedores
{
    static public function ShMostrarLogo($item, $valor){

		$tabla = "sh_configuracion_logo";

		$respuesta = ShProveedores::shMostrarLogo($tabla, $item, $valor);

		return $respuesta;
	}

    public static function ShGetProveedores()
    {

        $respuesta = ShProveedores::shgetProveedores();
        
        return $respuesta;
    }

    public static function ShGetProductosCategoria($idProveedor,$idCategoria){

        $respuesta = ShProveedores::shgetProductosCategoria($idProveedor,$idCategoria);
        
        return $respuesta;
    }

}
