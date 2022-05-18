<?php

class ModeloProductosTienda{

	/*===========================================================
	=            MOSTRAR PRODUCTOS DE TIENDA VIRTUAL            =
	===========================================================*/
	
	static public function mdlMostrarProductosTienda($tabla, $item, $valor, $empresa){

		if ($item != NULL) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR PRODUCTOS DE TIENDA VIRTUAL  ======*/
	
	/*=================================================
	=            AGREGAR PRODUCTO A TIENDA            =
	=================================================*/
	
	static public function mdlAgregarProductoTienda($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_producto, codigo, imagen, imagen2, imagen3, id_categoria, id_subcategoria) VALUES(:id_empresa, :id_producto, :codigo, :imagen, :imagen2, :imagen3, :id_categoria, :id_subcategoria)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen2", $datos["imagen2"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen3", $datos["imagen3"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_subcategoria", $datos["id_subcategoria"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of AGREGAR PRODUCTO A TIENDA  ======*/

	/*===================================================
	=            ELIMINAR PRODUCTO DE TIENDA            =
	===================================================*/
	
	static public function mdlEliminarProductoTienda($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR PRODUCTO DE TIENDA  ======*/

	/*====================================================
	=            MODIFICAR PRODUCTO DE TIENDA            =
	====================================================*/
	
	static public function mdlModificarProductoTienda($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET imagen = :imagen, 
																imagen2 = :imagen2, 
																imagen3 = :imagen3, 
																id_categoria = :id_categoria, 
																id_subcategoria = :id_subcategoria
													WHERE id_tv_productos = :id_tv_productos");

		$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen2", $datos["imagen2"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen3", $datos["imagen3"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_subcategoria", $datos["id_subcategoria"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_tv_productos", $datos["id_tv_productos"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MODIFICAR PRODUCTO DE TIENDA  ======*/
				

	/*===============================================================
	=            MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO            =
	===============================================================*/
	
	static public function mdlMostrarListadoPrecioProductoTienda($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE codigo = :codigo AND id_empresa = :id_empresa");
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR LISTADO DE PRECIOS DEL PRODUCTO  ======*/
	
	/*===================================================================
	=            CREAR LISTADO DE PRECIO DEL PRODUCTO TIENDA            =
	===================================================================*/
	
	static public function mdlCrearListadoProductoTienda($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, codigo, cantidad, precio, promo, activadoPromo) 
												VALUES(:id_empresa, :codigo, :cantidad, :precio, :promo, :activadoPromo)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":promo", $datos["promo"], PDO::PARAM_STR);
		$stmt -> bindParam(":activadoPromo", $datos["activadoPromo"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR LISTADO DE PRECIO DEL PRODUCTO TIENDA  ======*/
	
	/*=======================================================================
	=            MODIFICAR LISTADO DE PRECIO DEL PRODUCTO TIENDA            =
	=======================================================================*/
	
	static public function mdlModificarListadoTienda($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET precio = :precio, promo = :promo, activadoPromo = :activadoPromo WHERE id_tv_productos_listado = :id_tv_productos_listado");

		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":promo", $datos["promo"], PDO::PARAM_STR);
		$stmt -> bindParam(":activadoPromo", $datos["activadoPromo"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_tv_productos_listado", $datos["id_tv_productos_listado"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MODIFICAR LISTADO DE PRECIO DEL PRODUCTO TIENDA  ======*/
	
	/*==========================================================
	=            ELIMINAR PRECIO DE PRODUCTO TIENDA            =
	==========================================================*/
	
	static public function mdlEliminarPrecioProductoTienda($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}
		
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR PRECIO DE PRODUCTO TIENDA  ======*/
	
	/*=========================================================================
	=                   MOSTRAR PAQUETES DE PRODUCTOS EN TV                   =
	=========================================================================*/
	
	static public function mdlMostrarPreciosEspacioProducto($item, $valor){

		if ($item != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos_espacios_precios WHERE $item = :item");
			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos_espacios_precios");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of MOSTRAR PAQUETES DE PRODUCTOS EN TV  =============*/

	/*===================================================================================
	=                   MOSTRAR PAQUETE DE EMPRESA PRODUCTOS EN LA TV                   =
	===================================================================================*/
	
	static public function mdlMostrarPaqueteEmpresa($tabla, $empresa, $paqueteadq){

		// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
		// $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		// $stmt -> execute();

		// return $stmt -> fetch();

		// $stmt -> close();
		// $stmt = NULL;

		if($paqueteadq != NULL){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND id_tv_productos_lista_compras = :id_tv_productos_lista_compras");
            $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
            $stmt -> bindParam(":id_tv_productos_lista_compras", $paqueteadq, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetch();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa ORDER BY id_tv_productos_lista_compras ASC");
            $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
            $stmt -> execute();
    
            return $stmt -> fetchAll();  
        }

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of MOSTRAR PAQUETE DE EMPRESA PRODUCTOS EN LA TV  =============*/

	/*========================================================================================
	=                   CREAR REGISTRO DE AQUISION DE ESPACIO DE PRODCUTOS                   =
	========================================================================================*/
	
	static public function mdlCrearRegistroCompraEspacioProductos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_tv_productos_lista_compras, fecha_adquirido, fecha_ultimo_pago, fecha_proximo_pago) 
												VALUES(:id_empresa, :id_tv_productos_lista_compras, :fecha_adquirido, :fecha_ultimo_pago, :fecha_proximo_pago)");
		
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_tv_productos_lista_compras", $datos["id_tv_productos_lista_compras"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_adquirido", $datos["fecha_adquirido"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of CREAR REGISTRO DE AQUISION DE ESPACIO DE PRODCUTOS  =============*/

	/*============================================================================================
	=                   EDITAR REGISTRO DE ADQUISICION DE ESPACIO DE PRODUCTOS                   =
	============================================================================================*/
	
	static public function mdlEditarRegistroCompraEspacioProductos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ultimo_pago = :fecha_ultimo_pago, 
																 fecha_proximo_pago = :fecha_proximo_pago,
																 estado = 'activo'
																 WHERE id_empresa = :id_empresa AND id_tv_productos_lista_compras =:id_tv_productos_lista_compras");
		
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_tv_productos_lista_compras", $datos["id_tv_productos_lista_compras"], PDO::PARAM_STR);

		if ($stmt -> execute()) {

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of EDITAR REGISTRO DE ADQUISICION DE ESPACIO DE PRODUCTOS  =============*/

	/*====================================================================================
	=                   MODIFICAR CONTENIDO DE EMPRESA EN PRODUCTOS TV                   =
	====================================================================================*/
	
	static public function mdlContenidoCompraProductosTV($empresa, $cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE empresas_contenido_sistema SET productos_tv = productos_tv + :productos_tv WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":productos_tv", $cantidad, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			
			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MODIFICAR CONTENIDO DE EMPRESA EN PRODUCTOS TV  =============*/

	/*===================================================================
	=            MOSTRAR CANTIDAD DE PRODUCTOS POR CATEGORIA            =
	===================================================================*/
	
	static public function mdlMostrarCantidadPorCategoria($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(id_categoria) FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CANTIDAD DE PRODUCTOS POR CATEGORIA  ======*/
	/*===================================================
	=         Checar si el producto esta en TV         =
	===================================================*/
	
	static public function mdlcheckenTV($id,$empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos WHERE id_empresa = :id_empresa AND id_producto=:id_producto");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $id, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return $stmt -> fetch();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of  Checar si el producto esta en TV  ======*/
}
?>