<?php 

class ShProductos{

    static public function getCategoriesProductos(){
        //! Se crea la conexion y el query
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_categoria");
        //! Se asignan datos
        //! Se abre la conexion y se ejecuta el query
        $conex->execute();
        //! Obtener la informacion fetch para uno , fetchAll para todos
        return $conex->fetchAll();
        //!Se cierrra la conexion
        $conex->close();
        $conex = NULL;
    }

    /**
     * Funcion de mostrar productos funcionando
     *
     * @param [type] $tabla
     * @param [type] $idEmpresa
     * @return void
     */
    static public function ShowLimitProducts($tabla){
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_productos 
        INNER JOIN productos ON productos.id_producto = sh_productos.id_producto
        LIMIT 5");
        $conex -> execute();
        return $conex->fetchAll();
        $conex -> close();
        $conex = NULL;
    }

   
    /**
     * Funcion para obtener productos de los proveedores !Debes de cambiar id_empresa por id_proveedor
     *
     * @param [type] $idProveedor
     * @return void
     */
    static public function getProveedorProductos($idProveedor){
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_productos 
        INNER JOIN productos ON productos.id_producto = sh_productos.id_producto
        WHERE sh_productos.id_empresa  = :id_empresa");
        $conex -> bindParam(":id_empresa", $idProveedor, PDO::PARAM_STR);
        $conex->execute();
        return $conex -> fetchAll();
        $conex->close();
        $conex = null;
    }

    static public function getProductoCategoria($id_sh_categoria){
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_productos 
        INNER JOIN productos ON productos.id_sh_categoria = sh.productos.id_sh_categoria
        where sh_productos.id_sh_categorias = :id_sh_categorias");
        $conex -> bindParam(":id_sh_categoria", $id_sh_categoria, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = null;
    }

    static public function getProductoSubcategoria($id_sh_subcategoria){
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_productos 
        INNER JOIN productos ON productos.id_sh_subcategoria = sh_productos.id_sh_subcategoria
        where sh_productos.id_sh_subcategorias = :id_sh_subcategorias");
        $conex -> bindParam(":id_sh_subcategoria", $id_sh_subcategoria, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = null;
    }

    static public function getProveedorNom($idProveedor){
        $conex = Conexion::conectar()->prepare("SELECT * FROM proveedores where id_proveedor = :id_proveedor");
        $conex -> bindParam(":id_proveedor", $idProveedor, PDO::PARAM_STR);
        $conex -> execute();
        return $conex ->fetch();
        $conex ->close();
        $conex = null;

    }

    static public function getProductPrecio($codigo){
        $conex =Conexion::conectar()->prepare("SELECT * FROM sh_producto_listado where codigo = :codigo");
        $conex -> bindParam(":codigo",$codigo, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex =null;
    }

    static public function getProductDescripcion($idProducto){
        $conex =Conexion::conectar()->prepare("SELECT * FROM producto where id_producto = :id_producto");
        $conex -> bindParam(":id_producto",$idProducto, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex =null;
    }

    static public function MostrarProductoInfoCompleta($item, $valor){

		$conex = Conexion::conectar()->prepare("SELECT p.*, t.imagen, t.imagen2, t.imagen3, t.id_sh_categoria, t.id_sh_subcategoria 
		FROM sh_productos as t, productos as p 
		WHERE t.$item = :$item 
		AND p.$item = t.$item");

		$conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$conex -> execute();

		return $conex -> fetch();

		$conex -> close();
		$conex = NULL;
	}

    static public function MostrarInformacionGeneralProducto($tabla, $item, $valor){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $conex -> execute();

        return $conex -> fetch();

        $conex -> close();
        $conex = Null;
    }

    static public function MostrarPreciosProductos($tabla, $datos){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_proveedor = :id_proveedor AND codigo = :codigo ORDER BY cantidad DESC");

        $conex -> bindParam(":id_proveedor", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
        $conex -> execute();

        return $conex -> fetchAll();

        $conex -> close();
        $conex = NULL;
    }

    static public function MostrarCalculosEnvioProducto($tabla, $datos){

        $conex = Conexion::conectar()->prepare("SELECT medidas, peso FROM $tabla WHERE id_producto = :id_producto AND id_proveedor = :id_proveedor");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> execute();
        return  $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function MostrarProductosAzar($tabla, $empresa, $noProductos){
        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_proveedor = :id_proveedor ORDER BY id_producto DESC LIMIT $noProductos");
        $conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
        $conex -> execute();

        return $conex -> fetchAll();

        $conex -> close();
        $conex = NULL;
    }

    static public function MostrarProductosRelacionadosCategoria($tabla, $datos, $noProductos){
        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_sh_categoria = :id_sh_categoria AND id_producto != :id_producto ORDER BY rand(id_producto) limit $noProductos");
        $conex -> bindParam(":id_sh_categoria", $datos["id_sh_categoria"], PDO::PARAM_STR);
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = null;
    }
    
    static public function ProductoFavorito($tabla, $datos){

        if($datos["id_producto"] != NULL){
            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto AND id_empresa = :id_empresa");
            $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
            $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $conex -> execute();
            return $conex -> fetch();
        }else{

            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
            $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $conex -> execute();
            return $conex -> fetchAll();
        }
        $conex -> close();
        $conex  = NULL;
    }

    static public function CrearProductoFavorito($tabla, $datos){
        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, id_producto) VALUES (:id_empresa, id_producto)");
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

        if($conex -> execute()){

            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = null;
    }

    static public function EliminarProductoFavorito($tabla, $datos){
        $conex =Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_empresa = :id_empresa AND id_producto = :id_producto");
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

        if ($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = null;
    }

    static public function MostrarComentariosProducto($dato){
        $conex = Conexion::conectar()->prepare("SELECT nombre, comentario, puntos FROM sh_productos_comentarios AS c INNER JOIN clientes_servicio_plataforma AS e ON c.id_empresa = e.id_empresa WHERE id_producto = :id_producto");
        $conex -> bindParam(":id_producto", $dato, PDO::PARAM_STR);
        $conex -> execute();
        return $conex ->fetchAll();
        $conex ->close();
        $conex = NULL;
    }

    static public function MostrarProductosDiferente($datos){

	$stmt = Conexion::conectar()->prepare("SELECT * FROM sh_producto as t, productos as p 
													WHERE t.id_sh_categoria = :id_sh_categoria
													AND p.id_proveedor = :id_proveedor
													AND t.id_producto <> :id_producto
													AND p.id_producto = t.id_producto 
													AND p.stock_disponible > 0
													Limit ".$datos['cantidadMostrada']);
													
		$conex -> bindParam(":id_sh_categoria", $datos["id_sh_categoria"], PDO::PARAM_STR);
		$conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

		$conex -> execute();

		return $conex -> fetchAll();

		$conex -> close(); 
		$conex = NULL;
	}

    static public function MostrarBusquedaProductos($item, $valor, $empresa){

        if ($item == "id_sh_categoria") {

            $conex = Conexion::conectar()->prepare("SELECT * FROM sh_producto WHERE $item = :$item");
            $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        } else {

            $conex = Conexion::conectar()->prepare("SELECT * FROM sh_producto WHERE id_proveedor = :id_proveedor");
            $conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);

        }
            
        $conex -> execute();
        return $conex -> fetchAll();

        $conex -> close();
        $conex = NULL;
        
    }

    static public function MostrarProductosBuscados($dato, $empresa){

        $aKeyword = explode(" ", $dato);

        $sql = "SELECT t. * FROM sh_producto as t INNER JOIN  productos as p ON t.id_producto = p.id_producto WHERE p.nombre like '%$aKeyword[0]%' OR p.descripcion like '%$aKeyword[0]%'";

        for ($i=1; $i < count($aKeyword); $i++){
            if(!empty($aKeyword[$i])){
                $sql .="OR p.nombre like '%$aKeyword[$i]%' OR p.descripcion like '%$aKeyword[$i]%'";
            }
        }

        $sql .= "AND (p.id_proveedor = '$empresa')";
        $conex = Conexion::conectar()->prepare($sql);
        $conex -> execute();

        return $conex -> fetchAll();

        $conex -> close();
        $conex = NULL;
    }

    static public function GuardarComentarioProducto($tabla, $datos){

        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla (id_producto, id_empresa, comentario, puntos) VALUES (:id_producto, :id_empresa, :comentario, :puntos)");
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
        $conex-> bindParam(":puntos", $datos["puntos"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }

        $conex -> close();
        $conex =NULL;
    }

    static public function UpdateComentarioProducto($datos){

        $conex = Conexion::conectar()->prepare("UPDATE sh_productos_comentarios SET puntos = :puntos, comentario = :comentario WHERE id_producto = :id_producto AND id_empresa = :id_empresa");

        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
        $conex -> bindParam(":puntos", $datos["puntos"], PDO::PARAM_STR);

        if ($conex -> execute()){
            return "ok";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function ObtenerPuntuacionProducto($datos){
        $conex = Conexion::conectar()->prepare("SELECT puntos, comentarios FROM productos WHERE id_producto = :id_producto AND id_proveedor = :id_proveedor");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function PaginacionProductosBusqueda($datos){
        $conex = Conexion::conectar()->prepare("SELECT COUNT (t.id_producto)FROM sh_producto AS t INNER JOIN productos AS p ON t.id_producto = p.id_producto WHERE nombre LIKE :busqueda AND t.id_proveedor = :id_proveedor");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":busqueda", $datos["busqueda"], PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function PaginacionProductos($tabla, $datos){
        $conex = Conexion::conectar()->prepare("SELECT COUNT(id_producto) AS paginacion FROM $tabla WHERE id_proveedor = :id_proveedor");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function PaginacionProductosCategoria($tabla, $datos){
        $conex =Conexion::conectar()->prepare("SELECT COUNT(id_producto) AS paginacion FROM $tabla WHERE id_proveedor = :id_proveedor AND id_sh_categoria = :id_sh_categoria");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":id_sh_categoria", $datos["id_sh_categoria"], PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function MostrarDerivadosProductos($datos){
        $conex = Conexion::conectar()->prepare("SELECT * FROM productos AS p INNER JOIN sh_producto AS t ON p.id_producto = t.id_producto WHERE sku LIKE :skuModificado AND sku :sku AND p.id_empresa = :id_empresa");

        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
        $conex -> bindParam(":skuModificado", $datos["skuModificado"], PDO::PARAM_STR);

        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = NULL;
    }

    static public function ModificarPuntuacionProductos($datos){

        $conex = Conexion::conectar()->prepare("UPDATE productos SET puntos = :puntos, comentarios = :comentarios WHERE id_producto = :id_producto AND id_proveedor = :id_empresa");

        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":comentarios", $datos["comentarios"], PDO::PARAM_STR);
        $conex -> bindParam(":puntos", $datos["puntos"], PDO::PARAM_STR);

        if ($conex -> execute()){
            return "ok";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function VerificarCompra($producto, $cliente){
        $conex = Conexion::conectar()->prepare("SELECT estado FROM sh_pedidos AS p INNER JOIN sh_pedidos_detalle AS d ON p.folio = d.folio WHERE (id_empresa = :id_empresa) AND (id_producto = :id_producto) AND (estado = 'Finalizado' || estado = 'Enviado') LIMIT 1");
        $conex -> bindParam(":id_producto", $producto, PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $cliente, PDO::PARAM_STR);
        $conex -> execute();
        if($conex -> fetch() == "" || $conex ->fetch()==null){
            return "false";
        }else{
            return $conex -> fetch();
        }
        $conex -> close();
        $conex = NULL;
    }

    static public function VerificarComentario($producto, $cliente){
        $conex = Conexion::conectar()->prepare("SELECT id_sh_comentario FROM sh_productos_comentarios WHERE id_empresa =:id_empresa AND id_producto = :id_producto");
        $conex -> bindParam(":id_producto", $producto, PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $cliente, PDO::PARAM_STR);
        $conex -> execute();
        if($conex -> fetch() == null || $conex -> fetch()==""){
            return "false";
        }else{
            $comex -> fetch();
        }
        $conex -> close();
        $conex = NULL;
    }

    static public function ComentariosPaginados($producto, $inferior){
        $conex = Conexion::conectar()->prepare("SELECT nombre, comentario, puntos FROM sh_productos_comentarios AS c INNER JOIN clientes_servicio_plataforma AS e ON c.id_empresa = e.id_empresa WHERE id_producto = :id_producto ORDER BY id_sh_comentario DESC LIMIT :inferior, 5");
        $conex ->bindParam(":id_producto", $producto, PDO::PARAM_STR);
        $conex -> bindParam(":inferior", $inferior, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = null;
    }

    static public function PaginacionComentarios($producto){
        $conex = Conexion::conectar()->prepare("SELECT COUNT(id_sh_comentario) FROM sh_productos_comentarios WHERE id_producto = :id_producto");
        $conex -> bindParam(":id_producto", $producto, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function ComentarioUsuarioProducto($producto, $cliente){
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_productos_comentarios WHERE id_empresa = :id_empresa AND id_producto = :id_producto");
        $conex -> bindParam(":id_producto", $producto, PDO::PARAM_STR);
        $conex -> bindParam("id_empresa", $cliente, PDO::PARAM_STR);
        $conex -> execute();
        if($conex -> fetch()== null || $conex ->fetch()==""){
            return "false";
        }else{
            return $conex -> fetch();
        }
        $conex -> close();
        $conex =NULL;
    }

}

?>