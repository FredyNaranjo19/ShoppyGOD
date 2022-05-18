<?php
class ctrShCarrito{

    static public function shcMostrarCarrito($datos){
        $tabla = "sh_carrito";

        $respuesta = ShCarrito::shMostrarCarrito($tabla, $datos);

        return $respuesta;
    }

    static public function shcMostrarCarritoAgrupado($datos){

        $tabla = "sh_carrito";

        $respuesta = ShCarrito::shMostrarCarritoAgrupado($tabla, $datos);

        return $respuesta;
    }

    static public function shcEliminarProductoCarrito(){

        if(isset($_GET["delIdP"])){

            $valor = $_GET["delIdP"];
            $valor2 = $_GET["delCli"];

            $respuesta = ShCarrito::shEliminarProductoCarrito($valor, $valor2);

            if($respuesta == "ok"){
                echo '<script>
						window.location = "shopping-cart";
					</script>';
            }
        }
    }
}