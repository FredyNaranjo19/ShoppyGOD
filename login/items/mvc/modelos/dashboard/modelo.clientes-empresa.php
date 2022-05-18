<?php

class ModeloClientes{

	/*========================================
	=            MOSTRAR CLIENTES            =
	========================================*/
	
	static public function mdlMostrarClientes($tabla, $item, $valor, $empresa){
		
		if ($item == 'id_cliente') {

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
	
	/*=====  End of MOSTRAR CLIENTES  ======*/

	/*=======================================================
	=            MOSTRAR DOMICILIOS DEL CLIENTE             =
	=======================================================*/
	
	static public function mdlMostrarDomiciliosCliente($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		// if ($stmt -> rowCount() > 0) {
		return $stmt -> fetchAll();

		// }

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR DOMICILIOS DEL CLIENTE   ======*/
	

	/*========================================================
	=            CREAR CLIENTE POR PUNTO DE VENTA            =
	========================================================*/
	
	static public function mdlCrearCliente($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, nombre, usuario, email, password, telefono) VALUES (:id_empresa, :nombre, :usuario, :email, :password, :telefono)");

		$stmt -> bindParam(":id_empresa",$datos["id_empresa"],PDO::PARAM_STR);
		$stmt -> bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
		$stmt -> bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
		$stmt -> bindParam(":email",$datos["email"],PDO::PARAM_STR);
		$stmt -> bindParam(":password",$datos["password"],PDO::PARAM_STR);
		$stmt -> bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);

		if ($stmt -> execute()) {

			return "ok";

		} else {

			return "error";

		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR CLIENTE POR PUNTO DE VENTA  ======*/

	/*======================================================================================
	=            CREAR DIRECCION DE CLIENTE DESDES PUNTO DE VENTA Y RETORNAR ID            =
	======================================================================================*/
	
	static public function mdlCrearDireccion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(calle, exterior, interior, colonia, ciudad, estado, cp, pais, ConectaCalle1, ConectaCalle2, referencias, id_cliente) VALUES (:calle, :exterior, :interior, :colonia, :ciudad, :estado, :cp, :pais, :ConectaCalle1, :ConectaCalle2, :referencias, :id_cliente)");
		$stmt -> bindParam(":calle", $datos["direccion"], PDO::PARAM_STR);
		$stmt -> bindParam(":exterior", $datos["exterior"], PDO::PARAM_STR);
		$stmt -> bindParam(":interior", $datos["interior"], PDO::PARAM_STR);
		$stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt -> bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt -> bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt -> bindParam(":ConectaCalle1", $datos["calle1"], PDO::PARAM_STR);
		$stmt -> bindParam(":ConectaCalle2", $datos["calle2"], PDO::PARAM_STR);
		$stmt -> bindParam(":referencias", $datos["referencia"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["idCliente"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok'; 
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR DIRECCION DE CLIENTE DESDES PUNTO DE VENTA Y RETORNAR ID  ======*/

	/*=====================================================
	=            EDITAR DIRECCION DEL CLIENTE             =
	=====================================================*/
	
	static public function mdlEditarDireccionCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET calle = :calle, exterior = :exterior, interior = :interior, colonia = :colonia, ciudad = :ciudad, estado = :estado, cp = :cp, pais = :pais, ConectaCalle1 = :ConectaCalle1, ConectaCalle2 = :ConectaCalle2, referencias = :referencias WHERE id_info = :id_info");

		$stmt -> bindParam(":calle", $datos["direccion"], PDO::PARAM_STR);
		$stmt -> bindParam(":exterior", $datos["exterior"], PDO::PARAM_STR);
		$stmt -> bindParam(":interior", $datos["interior"], PDO::PARAM_STR);
		$stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt -> bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt -> bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt -> bindParam(":ConectaCalle1", $datos["calle1"], PDO::PARAM_STR);
		$stmt -> bindParam(":ConectaCalle2", $datos["calle2"], PDO::PARAM_STR);
		$stmt -> bindParam(":referencias", $datos["referencia"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_info", $datos["id_info"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR DIRECCION DEL CLIENTE   ======*/

	/*=========================================================================
	=            RETORNAR EL ULTIMO ID DEL CLIENTE EN EL DOMICILIO            =
	=========================================================================*/
	
	static public function mdlMostrarUltimoDomicilio($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT MAX(id_info) FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of RETORNAR EL ULTIMO ID DEL CLIENTE EN EL DOMICILIO  ======*/

	/*====================================================
	=            EDITAR CLIENTE DE LA EMPRESA            =
	====================================================*/
	
	static public function mdlEditarCLiente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, telefono = :telefono WHERE id_cliente = :id_cliente");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR CLIENTE DE LA EMPRESA  ======*/

	/*============================================================
	=            CAMBIAR CAMPO DE CREDITO DEL CLIENTE            =
	============================================================*/
	
	static public function mdlModificarCreditoCliente($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET credito = :credito WHERE id_cliente = :id_cliente");
		$stmt -> bindParam(":credito", $datos["credito"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CAMBIAR CAMPO DE CREDITO DEL CLIENTE  ======*/
	

	/*======================================================
	=            ELIMINAR CLIENTE DE LA EMPRESA            =
	======================================================*/
	
	static public function mdlEliminarCliente($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR CLIENTE DE LA EMPRESA  ======*/
	
	/*====================================================
	=            MOSTRAR DIRECCION DEL PEDIDO            =
	====================================================*/
	
	static public function mdlMostrarDireccion($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT i.*, c.telefono FROM $tabla as i, clientes_empresa as c WHERE $item = :$item AND c.id_cliente = i.id_cliente");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();
		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR DIRECCION DEL PEDIDO  ======*/

	/*======================================================
	=            MOSTRAR SOLICITUDES DE CREDITO            =
	======================================================*/
	
	static public function mdlMostrarSolicitudesCredito($tabla, $item, $valor, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND id_empresa = :id_empresa");
		$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR SOLICITUDES DE CREDITO  ======*/
		

	/*==============================================================
	=            CREAR SOLICITUD DE CREDITO DEL CLIENTE            =
	==============================================================*/
	
	static public function mdlCrearSolicitudCredito($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_cliente) VALUES(:id_empresa, :id_cliente)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR SOLICITUD DE CREDITO DEL CLIENTE  ======*/

	/*=================================================================
	=            ELIMINAR SOLICITUD DE CREDITO DEL CLIENTE            =
	=================================================================*/
	
	static public function mdlEliminarSolicitudCredito($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_empresa = :id_empresa AND id_cliente = :id_cliente");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ELIMINAR SOLICITUD DE CREDITO DEL CLIENTE  ======*/
	
		
}

?>