<?php

class ModeloProductosAlmacen{

	/*====================================================
	=            MOSTRAR PRODUCTOS DE ALMACEN            =
	====================================================*/
	 
	static public function mdlMostrarProductosAlmacen($tabla, $datos){

		if ($datos["id_producto"] != NULL) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_producto = :id_producto AND id_almacen = :id_almacen");
			$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();
		
		} else if ($datos["codigo"] != NULL) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo = :codigo AND id_almacen = :id_almacen");
			$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();
		
		} else {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen");
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = NULL;

	}
	 
	/*=====  End of MOSTRAR PRODUCTOS DE ALMACEN  ======*/

	/*=====================================================================
	=                   MOSTRAR ALMACENES DE LA EMPRESA                   =
	=====================================================================*/
	
	static public function mdlMostrarAlmacenesEmpresa($empresa){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM almacenes WHERE id_empresa = :empresa");
		$stmt -> bindParam(":empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR ALMACENES DE LA EMPRESA  =============*/

	/*=============================================================================
	=                   MOSTRAR PRODUCTOS DE ALMACEN POR CODIGO                   =
	=============================================================================*/
	
	static public function mdlMostrarStockProductosAlmacenPorCodigo($codigo, $consulta){
		$stmt = Conexion::conectar()->prepare("SELECT SUM(stock) as stock_almacenes FROM almacenes_productos WHERE codigo = :codigo AND ($consulta)");
		$stmt -> bindParam(":codigo", $codigo, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of MOSTRAR PRODUCTOS DE ALAMCEN POR CODIGO  =============*/

	/*=====================================================================
	=            MOSTRAR EXISTENCIAS DEL PRODUCTO EN ALMACENES            =
	=====================================================================*/
	
	static public function mdlMostrarExistenciasAlmacenes($datos){

		$stmt = Conexion::conectar()->prepare("SELECT a.nombre, a.telefono, p.stock  FROM almacenes_productos as p, almacenes as a 
												WHERE p.id_almacen != :id_almacen 
												AND p.id_producto = :id_producto
												AND a.id_almacen = p.id_almacen");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR EXISTENCIAS DEL PRODUCTO EN ALMACENES  ======*/
	
	
	/*====================================================
	=            CREAR PRODUCTO EN EL ALMACEN            =
	====================================================*/
	
	static public function mdlCrearProductoAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_almacen, id_producto, codigo, stock) 
												VALUES(:id_almacen, :id_producto, :codigo, :stock)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR PRODUCTO EN EL ALMACEN  ======*/
	
	/*=====================================================
	=            EDITAR PRODUCTO EN EL ALMACEN            =
	=====================================================*/
	
	static public function mdlEditarProductoAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = stock + :stock WHERE id_almacen = :id_almacen AND id_producto = :id_producto");
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR PRODUCTO EN EL ALMACEN  ======*/
	

	/*==========================================================
	=            CREAR LOTE DEL PRODUCTO EN ALMACEN            =
	==========================================================*/
	
	static public function mdlCrearLoteProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_almacen, id_producto, cantidad) 
												VALUES(:id_almacen, :id_producto, :cantidad)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR LOTE DEL PRODUCTO EN ALMACEN  ======*/
	
	/*==============================================================
	=            MOSTRAR LOTES DEL PRODUCTO POR ALMACEN            =
	==============================================================*/
	
	static public function mdlMostrarLotesProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen AND id_producto = :id_producto");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR LOTES DEL PRODUCTO POR ALMACEN  ======*/
	
	/*================================================
	=            EDITAR LOTE DEL PRODUCTO            =
	================================================*/
	
	static public function mdlEditarLote($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET cantidad = :cantidad WHERE id_almacenes_productos_lotes = :id_almacenes_productos_lotes");
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacenes_productos_lotes", $datos["id_almacenes_productos_lotes"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR LOTE DEL PRODUCTO  ======*/

	/*=========================================================
	=            EDITAR STOCK GENERAL DEL PRODUCTO            =
	=========================================================*/
	
	static public function mdlEditarLoteStockGeneral($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = :stock WHERE id_almacen = :id_almacen AND id_producto = :id_producto");
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR STOCK GENERAL DEL PRODUCTO  ======*/

	/*==================================================
	=            ELIMINAR LOTE DEL PRODUCTO            =
	==================================================*/
	
	static public function mdlEliminarLote($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR LOTE DEL PRODUCTO  ======*/

	/*=============================================================================
	=            MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO EN EL ALMACEN            =
	=============================================================================*/
	
	static public function mdlMostrarListadoPrecioProductoAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen AND codigo = :codigo ORDER BY cantidad ASC");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO EN EL ALMACEN  ======*/

	

	/*========================================================================
	=            VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIOS            =
	========================================================================*/
	
	static public function mdlChangeListado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_almacen = :id_almacen AND codigo = :codigo AND cantidad = :cantidad");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIOS  ======*/

	/*================================================================
	=            CREAR LISTADO DE PRECIO PARA EL PRODUCTO            =
	================================================================*/
	
	static public function mdlCrearListadoPrecios($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_almacen, codigo, cantidad, precio, promo, activadoPromo) 
															VALUES(:id_almacen, :codigo, :cantidad, :precio, :promo, :activadoPromo)");

		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":promo", $datos["promo"], PDO::PARAM_STR);
		$stmt -> bindParam(":activadoPromo", $datos["activadoPromo"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR LISTADO DE PRECIO PARA EL PRODUCTO  ======*/
	
	/*=================================================================================
	=            MODIFICAR DATOS DE LISTADO DE PRECIO DEL PRODUCTO ALMACEN            =
	=================================================================================*/
	
	static public function mdlModificarListadoPrecioAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET precio = :precio, promo = :promo, activadoPromo = :activadoPromo 
												WHERE id_almacen_productos_listado = :id_almacen_productos_listado");

		$stmt -> bindParam("precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam("promo", $datos["promo"], PDO::PARAM_STR);
		$stmt -> bindParam("activadoPromo", $datos["activadoPromo"], PDO::PARAM_STR);
		$stmt -> bindParam("id_almacen_productos_listado", $datos["id_almacen_productos_listado"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MODIFICAR DATOS DE LISTADO DE PRECIO DEL PRODUCTO ALMACEN  ======*/

	

	/*===============================================================
	=            ELIMINAR REGISTRO DE LISTADO DE PRECIOS            =
	===============================================================*/
	
	static public function mdlEliminarListadoProducto($tabla, $item, $valor, $cantidad){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item AND cantidad = :cantidad");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR REGISTRO DE LISTADO DE PRECIOS  ======*/

	/*======================================================================
	=            EDITAR STOCK DE PRODUCTO DE ALMACEN POR COMPRA            =
	======================================================================*/
	
	static public function mdlEditarStock($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = stock - :stock WHERE id_producto = :id_producto AND id_almacen = :id_almacen");
		$stmt -> bindParam(":stock", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of EDITAR STOCK DE PRODUCTO DE ALMACEN POR COMPRA  ======*/
	
	
}


?>