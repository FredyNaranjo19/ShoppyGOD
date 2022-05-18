<?php

class ModeloProductos{

	/*=========================================
	=            MOSTRAR PRODUCTOS            =
	=========================================*/
	
	static public function mdlMostrarProductos($tabla, $item, $valor, $empresa){ //uso
		
		if ($item == "id_producto" || $item == "sku") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else if($item == "estado_producto"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		} else if($item == "codigo"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		} else { 

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS  ======*/
		/*=========================================
	=            MOSTRAR PRODUCTOS Papelera           =
	=========================================*/
	
	static public function mdlMostrarProductosPapelera($tabla, $item, $valor, $empresa){ //uso
		
		if ($item == "id_producto" || $item == "sku") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND estado = 'papelera'");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else if($item == "estado_producto"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		} else if($item == "codigo"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();

		} else { 

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND estado = 'papelera'");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
			
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS Papelera ======*/
	/*=========================================
	=   Consulta si Eliminar producto         =
	=========================================*/
	
	static public function mdlconsultaeliminarprod($tabla, $item, $valor, $empresa){ //uso
		
		
			$stmt = Conexion::conectar()->prepare("SELECT COUNT(1) FROM `cedis_venta_detalles` WHERE id_producto = :id_producto AND id_empresa= :id_empresa UNION ALL
			SELECT COUNT(1) FROM `tv_productos` WHERE id_producto = :id_producto AND id_empresa= :id_empresa UNION ALL
			SELECT COUNT(1) FROM `almacenes_productos` WHERE id_producto = :id_producto UNION ALL
			SELECT COUNT(1) FROM `vendedorext_pedidos_detalles` WHERE id_producto = :id_producto AND id_empresa= :id_empresa UNION ALL
			SELECT COUNT(1) FROM `ventas_detalle` WHERE id_producto = :id_producto");
			$stmt -> bindParam(":id_producto",$valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa",$empresa, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchall();
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Consulta si Eliminar producto  ======*/
	/*=========================================
	=             Eliminar producto           =
	=========================================*/
	
	static public function mdleliminarprod($id,$empresa){ //uso
		
		
		$stmt = Conexion::conectar()->prepare("DELETE FROM `productos` WHERE id_producto = :id_producto AND id_empresa= :id_empresa");
		$stmt -> bindParam(":id_producto",$id, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchall();
	$stmt -> close();
	$stmt = NULL;
}

/*=====  End of  Eliminar producto  ======*/
/*=========================================
	=   Envia el producto a papelera        =
	=========================================*/
	
	static public function mdlproductoapapelera($id,$empresa){ //uso
		$stmt = Conexion::conectar()->prepare("UPDATE productos SET estado = 'papelera' WHERE id_producto = :id_producto AND id_empresa= :id_empresa");

		$stmt -> bindParam(":id_producto", $id, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		

		if ($stmt -> execute()) {

				return "ok";

		}

		$stmt -> close();
		$stmt = NULL;
		
		
}

/*=====  End of mdlproductoapapelera  ======*/
/*=========================================
	=          Recicla el producto          =
	=========================================*/
	
	static public function mdlproductoreciclar($id,$empresa){ //uso
		$stmt = Conexion::conectar()->prepare("UPDATE productos SET estado = NULL WHERE id_producto = :id_producto AND id_empresa= :id_empresa");

		$stmt -> bindParam(":id_producto", $id, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		

		if ($stmt -> execute()) {

				return "ok";

		}

		$stmt -> close();
		$stmt = NULL;
		
		
}

/*=====  End of Recicla el producto  ======*/

	/*====================================================
	=            MOSTRAR PRODUCTOS DATA TABLE            =
	====================================================*/
	
	static public function mdlMostrarProductosDataTable($tabla, $empresa){ //uso

		$stmt = Conexion::conectar()->prepare("SELECT id_producto, codigo, sku, nombre, descripcion, stock_disponible FROM $tabla WHERE id_empresa = :id_empresa AND estado IS NULL");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS DATA TABLE  ======*/
		/*====================================================
	=            MOSTRAR PRODUCTOS Papelera DATA TABLE            =
	====================================================*/
	
	static public function mdlMostrarProductosPapeleraDataTable($tabla, $empresa){ //uso

		$stmt = Conexion::conectar()->prepare("SELECT id_producto, codigo, sku, nombre, descripcion, stock_disponible FROM $tabla WHERE id_empresa = :id_empresa AND estado='papelera'");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS Papelera DATA TABLE  ======*/

	/*============================================
	=            CREAR NUEVO PRODUCTO            =
	============================================*/
	
	static public function mdlCrearProducto($tabla,$datos){ //uso

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, codigo, sku, nombre, descripcion, stock, stock_disponible, caracteristicas, medidas, peso, sat_clave_prod_serv, sat_clave_unidad) VALUES(:id_empresa, :codigo, :sku, :nombre, :descripcion, :stock, :stock_disponible, :caracteristicas, :medidas, :peso, :sat_clave_prod_serv, :sat_clave_unidad)"); 
 		
 		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock_disponible", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":caracteristicas", $datos["caracteristicas"], PDO::PARAM_STR);
		$stmt -> bindParam(":medidas", $datos["medidas"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
		$stmt -> bindParam(":sat_clave_prod_serv", $datos["sat_clave_prod_serv"], PDO::PARAM_STR);
		$stmt -> bindParam(":sat_clave_unidad", $datos["sat_clave_unidad"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR NUEVO PRODUCTO  ======*/

	/*===================================================================
	=            VERIFICAR EXISTENCIA DE MODELO DEL PRODUCTO            =
	===================================================================*/
	
	static public function mdlExistenciaModelo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo = :codigo AND id_empresa = :id_empresa");
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of VERIFICAR EXISTENCIA DE MODELO DEL PRODUCTO  ======*/

	/*=======================================
	=            EDITAR PRODUCTO            =
	=======================================*/
	
	static public function mdlEditarInfoProducto($tabla,$datos){ //uso

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, descripcion = :descripcion, caracteristicas = :caracteristicas, medidas = :medidas, peso = :peso, sat_clave_prod_serv = :sat_clave_prod_serv, sat_clave_unidad = :sat_clave_unidad WHERE id_producto = :id_producto");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":caracteristicas", $datos["caracteristicas"], PDO::PARAM_STR);
		$stmt -> bindParam(":medidas", $datos["medidas"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso", $datos["peso"], PDO::PARAM_STR);
		$stmt -> bindParam(":sat_clave_prod_serv", $datos["sat_clave_prod_serv"], PDO::PARAM_STR);
		$stmt -> bindParam(":sat_clave_unidad", $datos["sat_clave_unidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {

				return "ok";

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR PRODUCTO  ======*/

	/*=========================================================
	=            EDITAR STOCK GENERAL DEL PRODUCTO            =
	=========================================================*/
	
	static public function mdlEditarLoteStockGeneral($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = :stock, stock_disponible = :stock_disponible WHERE sku = :sku");
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock_disponible", $datos["stock_disponible"], PDO::PARAM_STR);
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		} 

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR STOCK GENERAL DEL PRODUCTO  ======*/

	/*=============================================================================
	=            MODIFICAR STOCK DISPONIBLE POR DISTRIBUCION A ALMACEN            =
	=============================================================================*/
	
	static public function mdlEditarStockDisponible($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = :stock_disponible WHERE sku = :sku");
		$stmt -> bindParam(":stock_disponible", $datos["stock_disponible"], PDO::PARAM_STR);
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MODIFICAR STOCK DISPONIBLE POR DISTRIBUCION A ALMACEN  ======*/
	
	/*==============================================================================
	=            MODIFICAR STOCK DISPONIBLE DESDE EMBARQUE DE PRODUCTOS            =
	==============================================================================*/
		
	static public function mdlModificarStockDisponibleEmbarque($tabla, $datos){ //uso

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible - :stock WHERE id_producto = :id_producto");
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			
			return 'ok';
		
		}	

		$stmt -> close();
		$stmt = NULL;

	}
		
	/*=====  End of MODIFICAR STOCK DISPONIBLE DESDE EMBARQUE DE PRODUCTOS  ======*/
			
	/*============================================================================
	=            MODIFICAR STOCK POR RECHAZO DE PRODUCTOS EN EMBARQUE            =
	============================================================================*/
	
	static public function mdlModificarStockRechazo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible + :stock WHERE id_producto = :id_producto");
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MODIFICAR STOCK POR RECHAZO DE PRODUCTOS EN EMBARQUE  ======*/
	

	/*============================================
	=            PREELIMINAR PRODUCTO            =
	============================================*/
	
	static public function mdlPreeliminarProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado_producto = :estado_producto WHERE id_producto = :id_producto");
		$stmt -> bindParam(":estado_producto", $datos["estado_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {

				return "ok";

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of PREELIMINAR PRODUCTO  ======*/


	/*==================================================================================================
	=            --------------------------- FUNCIONES DE LOTES ---------------------------            =
	==================================================================================================*/
	
	/*==============================================================================
	=                   MOSTRAR CANTIDAD DE LOTES DE UN PRODUCTO                   =
	==============================================================================*/
	static public function mdlMostrarCantidadLotesProducto($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(id_lote) FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of MOSTRAR CANTIDAD DE LOTES DE UN PRODUCTO  =============*/


	/*==========================================================
	=            MOSTRAR LOTES DEL PRODUCTO POR SKU            =
	==========================================================*/
	
	static public function mdlMostrarLotesProducto($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY fecha DESC");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	
	}
	
	/*=====  End of MOSTRAR LOTES DEL PRODUCTO POR SKU  ======*/


	/*===============================================
	=            CREAR LOTE DEL PRODUCTO            =
	===============================================*/
	
	static public function mdlCrearLote($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (sku, cantidad, costo, p_sugerido, factura, proveedor, costo_prom_ant, stock_ant_disp, no_lote) VALUES(:sku, :cantidad, :costo, :p_sugerido, :factura, :proveedor, :costo_prom_ant, :stock_ant_disp, :no_lote)");

		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt -> bindParam(":p_sugerido", $datos["precioSugerido"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura", $datos["factura"], PDO::PARAM_STR);
		$stmt -> bindParam(":proveedor", $datos["proveedor"], PDO::PARAM_STR);
		$stmt -> bindParam(":costo_prom_ant", $datos["costo_prom_ant"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock_ant_disp", $datos["stock_ant_disp"], PDO::PARAM_STR);
		$stmt -> bindParam(":no_lote", $datos["no_lote"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		} else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR LOTE DEL PRODUCTO  ======*/

	/*================================================
	=            EDITAR LOTE DEL PRODUCTO            =
	================================================*/
	
	static public function mdlEditarLote($tabla, $item,$valor,$id_lote){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE id_lote = :id_lote");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_lote", $id_lote, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR LOTE DEL PRODUCTO  ======*/

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

	/*==================================================================
	=            MOSTRAR ULTIMOS LOTES DEL PRODUCTO POR SKU            =
	==================================================================*/
	
	static public function mdlMostrarUltimosLotesProducto($tabla, $sku){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE sku = :sku ORDER BY fecha DESC LIMIT 4");
		$stmt -> bindParam(":sku", $sku, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	
	}
	
	/*=====  End of MOSTRAR ULTIMOS LOTES DEL PRODUCTO POR SKU  ======*/


	/*===================================================================================================
	=            --------------------- FUNCIONES DE LISTADO DE PRECIOS ---------------------            =
	===================================================================================================*/


	/*====================================================
	=            MOSTRAR PRECIOS DEL PRODUCTO            =
	====================================================*/
	 
	static public function mdlMostrarPreciosProducto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND modelo = :modelo ORDER BY cantidad ASC");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR PRECIOS DEL PRODUCTO  ======*/
	
	/*================================================================
	=            CREAR LISTADO DE PRECIO PARA EL PRODUCTO            =
	================================================================*/
	
	static public function mdlCrearListadoPrecios($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, modelo, cantidad, costo, precio, promo, activadoPromo) 
															VALUES(:id_empresa, :modelo, :cantidad, :costo, :precio, :promo, :activadoPromo)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
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
	
	/*========================================================================
	=            VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIOS            =
	========================================================================*/
	
	static public function mdlChangeListado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND modelo = :modelo AND cantidad = :cantidad");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of VERIFICACION DE EXISTENCIA EN LISTADO DE PRECIOS  ======*/
	
	/*===========================================================
	=            EDITAR PRECIO DE LISTADO DE PRECIOS            =
	===========================================================*/
	
	static public function mdlEditarListadoPrecios($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla 
												SET cantidad = :cantidad, 
													precio = :precio,
													promo = :promo,
													activadoPromo = :activadoPromo
												WHERE id_listado = :id_listado");

		$stmt -> bindParam(":cantidad",$datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio",$datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":promo",$datos["promo"], PDO::PARAM_STR);
		$stmt -> bindParam(":activadoPromo",$datos["activadoPromo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_listado",$datos["id_listado"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of EDITAR PRECIO DE LISTADO DE PRECIOS  ======*/

	/*======================================================================
	=                   EDITAR COSTO DE LISTA DE PRECIOS                   =
	======================================================================*/
	
	static public function mdlEditarCostoListadoPrecios($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla 
												SET costo = :costo
												WHERE modelo = :modelo AND 
												id_empresa = :id_empresa");

		$stmt -> bindParam(":costo",$datos["costo"], PDO::PARAM_STR);
		$stmt -> bindParam(":modelo",$datos["modelo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa",$datos["empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	
	/*============  End of EDITAR COSTO DE LISTA DE PRECIOS  =============*/

	/*===============================================================
	=            ELIMINAR REGISTRO DE LISTADO DE PRECIOS            =
	===============================================================*/
	
	static public function mdlEliminarListadoProducto($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR REGISTRO DE LISTADO DE PRECIOS  ======*/

	/*================================================================
	=            MOSTRAR LOTE DEL PRODUCTO POR SKU Y FECHA           =
	================================================================*/
	
	static public function mdlMostrarLoteProductoXFechaSku($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha = :fecha AND sku = :sku");
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	
	}
	
	/*=====  End of MOSTRAR LOTES DEL PRODUCTO POR SKU  ======*/

	/*===========================================================================================
	=                   CONSULTAR STOCK_G, STOCK_DISP, STOCK_ANT DEL PRODUCTO                   =
	===========================================================================================*/
	
	static public function mdlMostrarStocksProductoPorSKU($tabla, $sku){
		$stmt = Conexion::conectar() -> prepare("SELECT stock, stock_disponible FROM $tabla 
										WHERE sku = :sku");
		$stmt -> bindParam(":sku", $sku, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of CONSULTAR STOCK_G, STOCK_DISP DEL PRODUCTO  ========================*/

	/*=======================================================================================================
	=                   MOSTRAR LAS VENTAS HECHAS EN O DESPUES DE LA FECHA DEL LOTE                   =
	=======================================================================================================*/
	
	static public function mdlMostrarVentasPorFechaSkuDeLote($datos){
		$stmt = Conexion::conectar() -> prepare("SELECT p.codigo, cvd.* FROM 
													cedis_venta_detalles as cvd, cedis_ventas as cv, productos as p
													WHERE cv.folio = cvd.folio AND cvd.id_producto = p.id_producto AND p.sku = :sku 
													AND cv.fecha >= :fecha");
		$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR LAS VENTAS HECHAS EN LA EN O DESPUES DE LA FECHA DEL LOTE  =============*/

	/*====================================================================================
	=                   EDITAR COSTO Y UTILIDAD EN DETALLE DE LA VENTA                   =
	====================================================================================*/
	static public function mdlEditarCostoUtilidadDetalleVenta($tabla,$datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET costo= :costo, utilidad = :utilidad WHERE id_cedis_ventas_detalles = :id_cedis_ventas_detalles");
		$stmt -> bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt -> bindParam(":utilidad", $datos["utilidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cedis_ventas_detalles", $datos["id_cedis_ventas_detalles"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		} 

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of EDITAR COSTO Y UTILIDAD EN DETALLE DE LA VENTA  =============*/

	/*===========================================================================================
	=            ----------------------- FUNCIONES ALMACENES -----------------------            =
	===========================================================================================*/
	
		/*=================================================
		=            CREAR PRODUCTO EN ALMACEN            =
		=================================================*/
		
		static public function mdlCrearProductoAlmacen($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_almacen, sku, stock) 
													VALUES(:id_almacen, :sku, :stock)");

			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
			$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt -> close();
			$stmt = NULL;

		}
		
		/*=====  End of CREAR PRODUCTO EN ALMACEN  ======*/

		/*=======================================================
		=            CREAR STOCK PRODUCTO EN ALMACEN            =
		=======================================================*/
		
		static public function mdlCrearLoteAlmacen($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(sku, id_almacen, cantidad) 
													VALUES(:sku, :id_almacen, :cantidad)");

			$stmt -> bindParam(":sku", $datos["sku"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
			$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt -> close();
			$stmt = NULL;
		}
		
		/*=====  End of CREAR STOCK PRODUCTO EN ALMACEN  ======*/
		/*====================================================
	=            MOSTRAR PRODUCTOS            =
	====================================================*/
	
	static public function mdlMostrarProductoPOS($idEmpresa,$producto){ 
		$stmt = Conexion::conectar()->prepare("SELECT * FROM productos 
		WHERE `id_empresa` = :id_empresa AND (`codigo` Like :producto OR `nombre`LIKE :producto) AND estado IS NULL ");
		
		$stmt -> bindParam(":id_empresa", $idEmpresa, PDO::PARAM_STR);
		$stmt -> bindParam(":producto", $producto, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchall();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS  ======*/

			/*====================================================
	=            MOSTRAR Lista de precios de PRODUCTOS            =
	====================================================*/
/*====================================================
	=            MOSTRAR PRECIOS DEL PRODUCTO            =
	====================================================*/
	 
	static public function mdlMostrarLDPProductoPOS($idEmpresa, $modelo){
		$tabla="productos_listado_precios";
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND modelo = :modelo");
		$stmt -> bindParam(":id_empresa", $idEmpresa, PDO::PARAM_STR);
		$stmt -> bindParam(":modelo", $modelo, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of MOSTRAR PRECIOS DEL PRODUCTO  ======*/
	
	/*=====  End of MOSTRAR Lista de precios de PRODUCTOS  ======*/
		
		
	
	/*=====  End of ----------------------- FUNCIONES ALMACENES -----------------------  ======*/
	

	
}

?>