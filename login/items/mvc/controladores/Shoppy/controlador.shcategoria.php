<?php

class CtrCategoriaSh{

	static public function ShMostrarCategoriasDestacadas($empresa, $limite){
		$tabla ="sh_categorias";
		$respuesta = CategoriasSh::MostrarCategoriasDestacadas($tabla, $empresa, $limite);
		return $respuesta;
	}
	
}

?>