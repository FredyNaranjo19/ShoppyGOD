<?php

class CtrCategoriaSh
{
	static public function ShMostrarCategoriasDestacadas($empresa, $limite){
		
		$tabla ="sh_categorias";

		$respuesta = CategoriasSh::shMostrarCategoriasDestacadas($tabla, $empresa, $limite);
		
		return $respuesta;
	}

	static public function ShMostrarCategorias($item, $valor, $empresa){

		$tabla = "sh_categorias";

		$respuesta = CategoriaSh::shMostrarCategorias($tabla, $item, $valor, $empresa);

		return $respuesta;

	}
	
}

?>