<?php 

class ShPedidos{

    static public function shMostrarPedidos($tabla, $item, $valor, $proveedor){
        if($item != null && $item != "id_empresa"){
            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_proveedor =:id_proveedor ORDER BY fecha DESC");
            $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $conex -> bindParam(":id_proveedor", $proveedor, PDO::PARAM_STR);
            $conex -> execute();
            return $conex -> fetch();
        } else if($item != null && $item =="id_empresa"){

            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item AND id_proveedor = :id_proveedor ORDER BY fecha DESC");
            $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
            $conex -> bindParam(":id_proveedor", $proveedor, PDO::PARAM_STR);
            $conex -> execute();
            return $conex -> fetchAll();
        } else{

            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE AND id_proveedor = :id_proveedor ORDER BY fecha DESC");
            $conex -> bindParam(":id_proveedor", $proveedor, PDO::PARAM_STR);
            $conex -> execute();
            return $conex -> fetchAll();
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarPedidosPaginados($datos){

        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_pedidos AS p INNER JOIN sh_pedidos_entregas AS e ON p.folio = e.folio WHERE p.id_empresa = :id:empresa AND p.id_proveedor = :id_proveedor ORDER BY p.id_pedido DESC LIMIT :inferior, :limite");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":inferior", $datos["inferior"], PDO::PARAM_STR);
        $conex -> bindParam(":limite", $datos["limite"], PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarProductosPedido($tabla, $folio, $empresa){
        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla AS t INNER JOIN productos AS p ON t.id_producto = p.id_producto WHERE folio = :folio AND t.id_proveedor = : id_proveedor");
        $conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
        $conex -> bindParam(":folio", $folio, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarDetallePedido($tabla, $item, $valor, $empresa){

        $conex = Conexion::conectar()->prepare("SELECT d.*, p.nombre, p.codigo FROM $tabla AS d, productos AS p WHERE d.$item= :$item AND d.id_proveedor = :id_proveedor");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarEntregaPedido($tabla, $item, $valor, $empresa){
        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function shCrearDetallePedido($tabla, $datos){
        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, folio, id_producto, cantidad, costo, monto, costo_listado, utilidad)VALUES(:id_proveedor, :folio, :id_producto, :cantidad, :costo, :monto, :costo_listado, :utilidad)");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $conex -> bindParam("id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $conex -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
        $conex -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
        $conex -> bindParam(":costo_listado", $datos["costo_listado"], PDO::PARAM_STR);
        $conex -> bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shCrearPedido($tabla, $datos){
        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla(id_proveedor, folio, id_empresa, metodo_pago, total, estado)VALUES(:id_proveedor, :folio, :id_empresa, :metodo_pago, :total, :estado)");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $datos[":id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
        $conex -> bindParam(":total", $datos["total"], PDO::PARAM_STR);
        $conex -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        } else{
            return "error";
        }

        $conex ->close();
        $conex =NULL;
    }

    static public function shCrearEntregaPedido($tabla, $datos){
        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla(id_proveedor, folio, estado_entrega, id_domicilio, tipo_entrega)VALUES(:id_proveedor, :folio, :estado_entrega, id_domicilio, :tipoEntrega)");
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $conex -> bindParam(":tipoEntrega", $datos["tipoEntrega"], PDO::PARAM_STR);
        $conex -> bindParam(":estado_entrega", $datos["estado_entrega"], PDO::PARAM_STR);
        $conex -> bindParam(":id_domicilio", $datos["id_domicilio"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }
        $conex -> close();
        $conex = NULL;
    }

    static public function shAgregarAnotacion($tabla, $valor1, $valor2){

        $conex = Conexion::conectar()->prepare("UPDATE $tabla SET anotaciones = :anotaciones WHERE folio = :folio");
        $conex -> bindParam(":anotaciones", $valor2, PDO::PARAM_STR);
        $conex -> bindParam(":folio", $valor1, PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shCambioEstadoPedido($tabla, $datos){

        $conex = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE folio = :folio");
        $conex -> bindParam(":estado", $datos["estados"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }
        $conex -> close();
        $conex = NULL;
    }

    static public function shCambioEstadoEntrega($tabla, $datos){
        $conex = Conexion::conectar()->prepare("UPDATE $tabla SET estado_entrega = :estado_entrega WHERE folio = :folio AND id_proveedor = :id_proveedor");
        $conex -> bindParam(":estado_entrega", $datos["estado_entrega"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_empresa"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarComprobanteEfectivo($tabla, $item, $valor, $id_empresa){
        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_proveedor = :id_proveedor");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $id_proveedor, PDO::PARAM_STR);
        $conex -> execute();
        return $conex ->fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function shAgregarFichaPago($tabla, $datos){
        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla(id_proveedor, folio, monto, comprobante, estado)VALUES(:id_proveedor, :folio, :monto, :comprobante, :estado)");
        $conex -> bindParam(":id_proveedor",$datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
        $conex -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
        $conex -> bindParam(":comprobante", $datos["comprobante"], PDO::PARAM_STR);
        $conex -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }
        $conex -> close();
        $conex = NULL;
    }

    static public function shEditarFichaPago($tabla, $datos){

        $conex = Conexion::conectar()->prepare("UPDATE $tabla SET comprobante = :comprobante, estado = :estado WHERE id_proveedor = :id_proveedor AND folio = :folio");
        $conex -> bindParam(":comprobante", $datos["comprobante"], PDO::PARAM_STR);
        $conex -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
        $conex -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarPuntosEntrega($empresa){
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_puntos_entrega WHERE id_proveedor = 2");
        $conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetchAll();
        $conex -> close();
        $conex = NULL;
    }

    static public function shVerificarTipoEntrega($folio, $empresa){
        $conex = Conexion::conectar()->prepare("SELECT tipo_entrega FROM sh_pedidos_entregas WHERE folio = :folio AND id_proveedor = :id_proveedor LIMIT 1");
        $conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
        $conex -> bindParam(":folio", $folio, PDO::PARAM_STR);
        $conex -> execute();
        return $conex ->fetch();
        $conex -> close();
        $conex = NULL;
    }
}