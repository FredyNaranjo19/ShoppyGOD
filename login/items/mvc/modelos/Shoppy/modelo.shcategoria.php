<?php

class CategoriaSh{

	static public function MostrarCategoriasDestacadas($tabla,$empresa ,$limite){
		$conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_proveedor = :id_proveedor ORDER BY id_sh_categoria DESC LIMIT $limite");
		$conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
		$conex-> execute();
		return $conex ->fetchAll();
	}

	static public function MostrarCategorias($tabla, $item , $valor, $empresa){

		if($item == "id_sh_categoria"){
			$conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$conex -> execute();

			return $conex -> fetch();

		}else {
			$conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_proveedor = :id_proveedor");
			$conex -> bindParam(":id_proveedor", $empresa, PDO::PARAM_STR);
			$conex -> execute();

			return $conex -> fetchAll();

			$conex -> close();
			$conex = NULL;
		}
	}
		
}
 
?>