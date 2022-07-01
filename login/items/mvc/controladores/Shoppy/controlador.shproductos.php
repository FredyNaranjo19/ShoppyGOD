<?php
class CtrProductosSh
{
    static public function ShGetCategoriesProductos(){

        $respuesta = ShProductos::shgetCategoriesProductos();

        return $respuesta;
    }

    static public function ShShowLimitProducts(){

        $tabla = "tv_producto";

        $respuesta = ShProductos::shShowLimitProducts($tabla);

        return $respuesta;
    }
   
    static public function ShProveedorProductos($idProveedor){

        $respuesta = ShProductos::shgetProveedorProductos($idProveedor);

        return $respuesta;
    }

    static public function ShgetProveedorNom($idProveedor){

        $respuesta = ShProductos::shgetProveedorNom($idProveedor);

        return $respuesta;
    }

    static public function ShgetProductPrecio($codigo){

        $respuesta =ShProductos::shgetProductPrecio($codigo);

        return $respuesta;
    }
    static public function ShgetProductoCategoria($id_sh_categoria){

        $respuesta = ShProductos::shgetProductoCategoria($id_sh_categoria);

        return $respuesta;
    }
    static public function ShgetProductoSubcategoria($id_sh_subcategoria){

        $respuesta = ShProductos::shgetProductoSubategoria($id_sh_subcategoria);
        
        return $respuesta;
    }

    static public function ShMostrarFavoritos($datos){
        $tabla = "sh_productos_favoritos";

        $respuesta = ShProductos::shProductoFavorito($tabla, $datos);

        return $respuesta;
    }

    static public function ShMostrarComentariosProducto($id_producto){
        $respuesta = ShProductos::shMostrarComentarioProducto($id_producto);

        return $respuesta;
    }

    static public function ShMostrarProductoDiferente($datos){

        $respuesta = ShProductos::shMostrarProductosDiferente($datos);
        
        return $resultado;
    }

    static public function ShMostrarBusquedaProductos($item, $valor, $empresa){
        $respuesta = ShProductos::shMostrarBusquedaProductos($item, $valor, $empresa);

        return $respuesta;
    }

    static public function ShMostrarProductosBuscados($dato, $empresa){

    $respuesta = ShProductos::shMostrarProductosBuscados($dato, $empresa);

    return $respuesta;
    }

    static public function ShGuardarComentarioProducto(){
        if(isset($_POST["ComentarionProducto"])){
            $tabla = "sh_productos_comentario";

            $datos = array("id_producto" => $_POST["idProductoComentario"], "id_empresa" => $_SESSION["id"], "comentario" => $_POST["ComentarionProducto"], "puntos" => $_POST["ValorarnProducto"]);

            $respuesta = ShProductos::shGuardarComentarioProducto($tabla, $datos);

            if($respuesta == "ok"){
                echo '<script>
                window.location =
                "historial";
                </script>';
            }
        }
    }

    static public function ShMostrarDerivadosProductos($datos){

        $respuesta = ShProductos::shMostrarDerivadosProductos($datos);
        return $respuesta;
    }

    static public function ShVerificarCompra($datos, $cliente){

        $respuesta = ShProductos::shVerificarCompra($datos, $cliente);

        return $respuesta;
    }

    static public function ShComentarioUsuarioProducto($producto, $cliente){

        $respuesta = ShProductos::shComentarioUsuarioProducto($producto, $cliente);

        return $respuesta;
    }

    static public function ShComentariosPaginados($producto, $inferior){

        $respuesta = ShProductos::shComentariosPaginados($producto, $inferior);

        return $respuesta;
    }

    static public function ShPaginacionComentarios($productos){

        $respuesta = ShProductos::shPaginacionComentarios($productos);

        return $respuesta;
    }
}
    
?>