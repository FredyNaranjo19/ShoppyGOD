<?php

class ModeloProductos{
    
    	/*===================================================================
	=            ------------ MOSTRAR PRODUCTOS ------------            =
	===================================================================*/
	
	static public function mdlMostrarProductos($tabla, $item, $valor, $empresa){

		if ($item == "id_categoria" || $item == "id_subcategoria") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
 
		} else if ($item == "id_producto" || $item == "sku") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item 
															AND id_empresa = :id_empresa 
															");
			
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND estado IS NULL");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();	

		}
		

		$stmt -> close();
		$stmt = NULL;


	}
	
	/*=====  End of ------------ MOSTRAR PRODUCTOS ------------  ======*/


	/*=================================================================
	=            MOSTRAR INFORMACION COMPLETA DEL PRODUCTO            =
	=================================================================*/
	
	static public function mdlMostrarProductoInfoCompleta($item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT p.*, t.imagen, t.imagen2, t.imagen3, t.id_categoria, t.id_subcategoria 
												FROM tv_productos as t, productos as p 
												WHERE t.$item = :$item 
												AND p.$item = t.$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR INFORMACION COMPLETA DEL PRODUCTO  ======*/
	

	/*================================================
	=            INFORMACION DEL PRODUCTO            =
	================================================*/
	
	static public function mdlMostrarInformacionGeneralProducto($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of INFORMACION DEL PRODUCTO  ======*/

	/*====================================================
	=            MOSTRAR PRECIOS DEL PRODUCTO            =
	====================================================*/
	
	static public function mdlMostrarPreciosProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
												WHERE id_empresa = :id_empresa 
												AND codigo = :codigo 
												ORDER BY cantidad ASC");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRECIOS DEL PRODUCTO  ======*/

	/*=================================================
	=            MOSTRAR PRODUCTOS AL AZAR            =
	=================================================*/
	
	static public function mdlMostrarProductosAzar($tabla, $empresa, $noProductos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE  id_empresa = :id_empresa  ORDER BY rand() Limit $noProductos");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	} 
	
	/*=====  End of MOSTRAR PRODUCTOS AL AZAR  ======*/

	/*===================================================
	=            MOSTRAR PRODUCTOS FAVORITOS            =
	===================================================*/
	
	static public function mdlProductoFavorito($tabla, $datos){

		if ($datos["id_producto"] != NULL) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto AND id_cliente = :id_cliente");
			$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_cliente = :id_cliente");
			$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS FAVORITOS  ======*/

	/*=====================================================
	=            CREAR NUEVO PRODUCTO FAVORITO            =
	=====================================================*/
	
	static public function mdlCrearProductoFavorito($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_cliente, id_producto) VALUES(:id_cliente, :id_producto)");
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		} else {

			return "error";

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR NUEVO PRODUCTO FAVORITO  ======*/

	/*===============================================================
	=            ELIMINAR PRODUCTO DE LISTA DE FAVORITOS            =
	===============================================================*/
	
	static public function mdlEliminarProductoFavorito($tabla,$datos){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_cliente = :id_cliente AND id_producto = :id_producto");
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam("id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR PRODUCTO DE LISTA DE FAVORITOS  ======*/

	/*========================================================
	=            MOSTRAR COMENTARIOS DEL PRODUCTO            =
	========================================================*/
	
	static public function mdlMostrarComentariosProducto($tabla, $comProducto, $comCliente){

		if ($comCliente != '') {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_cliente = :id_cliente AND id_producto = :id_producto");
			$stmt -> bindParam(":id_cliente", $comCliente, PDO::PARAM_STR);
			$stmt -> bindParam(":id_producto", $comProducto, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto");
			$stmt -> bindParam(":id_producto", $comProducto, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR COMENTARIOS DEL PRODUCTO  ======*/

	/*====================================================
	=            MOSTRAR PRODUCTOS DIFERENTES            =
	====================================================*/
	 
	static public function mdlMostrarProductosDiferente($datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos as t, productos as p 
													WHERE t.id_subcategoria = :id_subcategoria
													AND p.id_empresa = :id_empresa
													AND t.id_producto <> :id_producto
													AND p.id_producto = t.id_producto 
													AND p.stock_disponible > 0
													Limit ".$datos['cantidadMostrada']);
													
		$stmt -> bindParam(":id_subcategoria", $datos["id_subcategoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close(); 
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS DIFERENTES  ======*/
	
	/*==============================================================
	=            MOSTRAR PRODUCTOS DERIVADOS DEL MODELO            =
	==============================================================*/
	
	static public function mdlMostrarProductosDerivados($tabla, $datos){

		// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
		// 												WHERE codigo = :codigo 
		// 												AND sku != :sku 
		// 												AND id_empresa = :id_empresa 
		// 												AND stock > 0");

		$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos as t,productos as p
													WHERE p.codigo = :codigo 
													AND p.id_producto != :id_producto
													AND t.id_empresa = :id_empresa
													AND t.id_producto = p.id_producto 
													AND stock > 0");


		
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS DERIVADOS DEL MODELO  ======*/
	

	/*====================================================================
	=            EDITAR STOCK POR COMPRA O VENTA DEL PRODUCTO            =
	====================================================================*/
	
	static public function mdlEditarStock($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible - :stock_disponible WHERE id_producto = :id_producto");
		$stmt -> bindParam(":stock_disponible", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}
  
		$stmt -> close();
		$stmt = NULL;
		
	}

	/*====================================================================================================
	=            ********************* SECCION DE BUSQUEDA DE PRODUCTOS *********************            =
	====================================================================================================*/
	
		/*=========================================================
		=            BUSQUEDA CATEGORIA O SUBCATEGORIA            =
		=========================================================*/
		
		static public function mdlMostrarBusquedaProductos($item, $valor, $empresa){

			if ($item == "id_categoria" || $item == "id_subcategoria") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos WHERE $item = :$item");
				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			} else {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos WHERE id_empresa = :id_empresa");
				$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

			}
				
			$stmt -> execute();
			return $stmt -> fetchAll();

			$stmt -> close();
			$stmt = NULL;
			
		}
		
		/*=====  End of BUSQUEDA CATEGORIA O SUBCATEGORIA  ======*/

		/*======================================================
		=            MOSTRAR PRODUCTOS CON BUSQUEDA            =
		======================================================*/
		
		static public function mdlMostrarProductosBuscados($dato, $empresa){

			$aKeyword = explode(" ", $dato);

			$sql = "SELECT t.* FROM tv_productos as t INNER JOIN productos as p ON t.id_producto = p.id_producto WHERE p.nombre like '%$aKeyword[0]%' OR p.descripcion like '%$aKeyword[0]%'";


			for ($i= 1; $i < count($aKeyword); $i++) { 
				if (!empty($aKeyword[$i])) {
					$sql .= " OR p.nombre like '%$aKeyword[$i]%' OR p.descripcion like '%$aKeyword[$i]%'";
				}
			}

			$sql .= "AND (p.id_empresa = '$empresa')";
			
			$stmt = Conexion::conectar()->prepare($sql);
			$stmt -> execute();

			return $stmt -> fetchAll();
			
			$stmt -> close();
			$stmt = NULL;
		}
		
		/*=====  End of MOSTRAR PRODUCTOS CON BUSQUEDA  ======*/
		

	/*=====  End of ********************* SECCION DE BUSQUEDA DE PRODUCTOS *********************  ======*/
	
	/*=======================================================
	=            GUARDAR COMENTARIO DEL PRODUCTO            =
	=======================================================*/
	
	static public function mdlGuardarComentarioProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_producto, id_cliente, comentario, puntos) VALUES(:id_producto, :id_cliente, :comentario, :puntos)");
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
		$stmt -> bindParam(":puntos", $datos["puntos"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of GUARDAR COMENTARIO DEL PRODUCTO  ======*/
}



?>