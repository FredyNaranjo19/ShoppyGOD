<?php

class ShProveedores
{
    static public function shMostrarLogo($tabla, $item, $valor){

		$conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$conex -> execute();
		return $conex -> fetch();
		$conex -> close();
		$conex = NULL; 
	}

    public static function shgetProveedores()
    {
        $conex = Conexion::conectar()->prepare("SELECT * FROM proveedores");
        $conex->execute();
        return $conex->fetchAll();
        $conex->close();
        $conex = null;
    }

    public static function shgetProductosCategoria($idProveedor,$idCategoria)
    {
        $conex = Conexion::conectar()->prepare("SELECT * FROM sh_productos
            INNER JOIN productos ON productos.id_producto = sh_productos.id_producto
            WHERE sh_productos.id_proveedor = :id_proveedor AND
            id_sh_categoria = :id_sh_categoria
         ");
        $conex->bindParam(":id_proveedor", $idProveedor, PDO::PARAM_STR);
        $conex->bindParam(":id_sh_categoria", $idCategoria, PDO::PARAM_STR);
        $conex->execute();
        return $conex->fetchAll();
        $conex->close();
        $conex = null;
    }
  


}
