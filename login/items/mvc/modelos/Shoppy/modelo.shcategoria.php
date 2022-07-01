<?php

class CategoriaSh{

	static public function shMostrarCategorias($tabla, $item , $valor, $empresa){

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