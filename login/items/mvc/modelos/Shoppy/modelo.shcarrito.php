<?php

class ShCarrito{

    static public function shMostrarCarrito($tabla, $datos){
        
        if($datos["opcion"] == 1){
            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto AND id_empresa = id_empresa");

            $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM-STR);
            $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $conex -> execute();

            return $conex -> fetchAll();

        }else if($datos["opcion"] == 2){
            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_proveedor = :id_proveedor AND id_empresa = :id_empresa AND modelo =:modelo");

            $conex -> bindParam("id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);
            $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $conex -> bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
            $conex -> execute();

            return $conex -> fetchAll();

        }else if($datos["opcion"]==3){
            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
            $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
            $conex -> execute();

            return $conex -> fetchAll();

        }else{

            $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto");
            $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
            $conex -> execute();
        }

        $conex -> close();
        $conex = NULL;

    }

    static public function shMostrarCarritoAgrupado($tabla, $datos){
        $conex = Conexion::conectar()->prepare("SELECT modelo, SUM(cantidad) AS cantidad FROM $tabla WHERE id_empresa = :id_empresa AND id_proveedor = :id_proveedor GROUP BY modelo");
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

        $conex -> execute();

        return $conex -> fetchAll();

        $conex -> close();
        $conex = NULL;
    }

    static public function shAgregarProductoCarrito($tabla, $datos){
        $conex = Conexion::conectar()->prepare("INSERT INTO $tabla(id_producto, id_empresa, cantidad, modelo, id_proveedor) VALUES(:id_producto, :id_empresa, :cantidad, :modelo, :id_proveedor)");

        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $conex -> bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

        if($conex -> execute()){

            return "ok";
        }else{
            return "error";
        }

        $conex ->close();
        $conex = null;
    }

    static public function shModificarProductoCarrito($tabla, $datos){

        $conex = Conexion::conectar()->prepare("UPDATE $tabla SET cantidad = :cantidad WHERE id_producto = :id_producto AND id_empresa = :id_empresa");

        $conex -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarCarritoAgrupadoDif($tabla, $datos){
        $conex = Conexion::conectar()->prepare("SELECT modelo, SUM(cantidad) as cantidad FROM $tabla WHERE id_empresa = :id_empresa AND id_producto <> :id_producto AND id_proveedor = :id_proveedor GROUP BY modelo");

        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

        $conex -> execute();

        return $conex -> fetchAll();

        $conex -> close();
        $conex = NULL;
    }

    static public function shEliminarProductoCarrito($datos){

        $conex = Conexion::conectar()->prepare("DELETE FROM sh_carrito WHERE id_sh_carrito = :pro AND id_proveedor = :id_proveedor");
        $conex -> bindParam(":pro", $datos["id"], PDO::PARAM_STR);
        $conex -> bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = NULL;
    }

    static public function shEliminarCarrito($tabla, $item, $valor){
        $conex = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        if($conex -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $conex -> close();
        $conex = NULL;
    }
}