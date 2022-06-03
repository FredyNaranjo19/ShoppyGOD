<?php
class ControladorShProductos{



    static public function ctrGetCategoriesProductos(){
        $respuesta = ShProductos::getCategoriesProductos();
        return $respuesta;
    }

    /**
     * Funcion para mostrar un limite definido de productos
     *
     * @return void
     */
    static public function ctrShowLimitProducts(){
        $tabla = "sh_producto";
        $respuesta = ShProductos::ShowLimitProducts($tabla);
        return $respuesta;
    }
   
    /**
     * Funcion para obtener los productos del proveedor
     *
     * @param [type] $idProveedor
     * @return void
     */
    static public function getProveedorProductos($idProveedor){
        $respuesta = ShProductos::getProveedorProductos($idProveedor);
        return $respuesta;
    }
    /** 
    * @param  [type] $idProveedor
    * @return void
    */

    static public function ctrgetProveedorNom($idProveedor){
        $respuesta = ShProductos::getProveedorNom($idProveedor);
        return $respuesta;
    }

    static public function ctrgetProductPrecio($codigo){
        $respuesta =ShProductos::getProductPrecio($codigo);
        return $respuesta;
    }
    static public function ctrgetProductoCategoria($id_sh_categoria){
        $respuesta = ShProductos::getProductoCategoria($id_sh_categoria);
        return $respuesta;
    }
    static public function ctrgetProductoSubcategoria($id_sh_subcategoria){
        $respuesta = ShProductos::getProductoSubategoria($id_sh_subcategoria);
        return $respuesta;
    }

    static public function ShMostrarFavoritos($datos){
        $tabla = "sh_productos_favoritos";

        $respuesta = ShProductos::mdlProductoFavorito($tabla, $datos);

        return $respuesta;
    }

    static public function ShMostrarComentariosProducto($id_producto){
        $respuesta = ShProductos::mdlMostrarComentarioProducto($id_producto);

        return $respuesta;
    }

    static public function ShMostrarProductoDiferente($datos){

        $respuesta = ShProductos::MostrarProductosDiferente($datos);
        
        return $resultado;
    }

    static public function ShMostrarBusquedaProductos($item, $valor, $empresa){
        $respuesta = ShProductos::MostrarBusquedaProductos($item, $valor, $empresa);

        return $respuesta;
    }

    static public function ShMostrarProductosBuscados($dato, $empresa){

    $respuesta = ShProductos::MostrarProductosBuscados($dato, $empresa);

    return $respuesta;
    }

    static public function ShGuardarComentarioProducto(){
        if(isset($_POST["ComentarionProducto"])){
            $tabla = "sh_productos_comentario";

            $datos = array("id_producto" => $_POST["idProductoComentario"], "id_empresa" => $_SESSION["id"], "comentario" => $_POST["ComentarionProducto"], "puntos" => $_POST["ValorarnProducto"]);

            $respuesta = ShProductos::GuardarComentarioProducto($tabla, $datos);

            if($respuesta == "ok"){
                echo '<script>
                window.location =
                "historial";
                </script>';
            }
        }
    }

    static public function ShMostrarDerivadosProductos($datos){

        $respuesta = ShProductos::MostrarDerivadosProductos($datos);
        return $respuesta;
    }

    static public function ShVerificarCompra($datos, $cliente){
        $respuesta = ShProductos::VerificarCompra($datos, $cliente);

        return $respuesta;
    }

    static public function ShComentarioUsuarioProducto($producto, $cliente){
        $respuesta = ShProductos::ComentarioUsuarioProducto($producto, $cliente);
        return $respuesta;
    }

    static public function ShComentariosPaginados($producto, $inferior){
        $respuesta = ShProductos::ComentariosPaginados($producto, $inferior);
        return $respuesta;
    }

    static public function ShPaginacionComentarios($productos){
        $respuesta = ShProductos::PaginacionComentarios($productos);
        return $respuesta;
    }
}
    
?>