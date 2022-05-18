<?php

class ModelosUsuarios{

	/*================================================
	=            CREAR USUARIO PLATAFORMA            =
	================================================*/
	
	static public function mdlCrearUsuarioPlataforma($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, nombre, email, password, telefono, almacen, estado, rol) 
															VALUES(:id_empresa, :nombre, :email, :password, :telefono, :almacen, :estado, :rol)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":almacen", $datos["almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":rol", $datos["rol"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR USUARIO PLATAFORMA  ======*/
	

	/*=================================================
	=            MOSTRAR CLIENTES DIRECTOS            =
	=================================================*/
	
	static public function mdlMostrarUsuarios($tabla, $item, $valor, $empresa){
 
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
	
	/*=====  End of MOSTRAR CLIENTES DIRECTOS  ======*/

	/*========================================================================
	=                   MOSTRAR USUARIOS AGRUPADOS POR ROL                   =
	========================================================================*/
	
	static public function mdlMostrarUsuariosAgrupados($empresa){

		$stmt = Conexion::conectar()->prepare("SELECT rol, COUNT(*) as cantidad FROM usuarios_plataforma WHERE id_empresa = :id_empresa GROUP BY rol");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of MOSTRAR USUARIOS AGRUPADOS POR ROL  =============*/

	/*================================================================
	=            CAMBIO DE CONTRASEÑA DEL CLIENTE DIRECTO            =
	================================================================*/
	
	static public function mdlRecoveryDashboard($tabla, $datos){

		$stmt = Conexion::conectar()-> prepare("UPDATE $tabla SET password = :password WHERE id_clienteDirecto = :id_clienteDirecto");
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_clienteDirecto", $datos["id_clienteDirecto"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CAMBIO DE CONTRASEÑA DEL CLIENTE DIRECTO  ======*/

	/*================================================
	=            MOSTRAR ROLES DE USUARIO            =
	================================================*/
	
	static public function mdlMostrarRoles($item, $valor){

		if ($item != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios_plataforma_roles WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios_plataforma_roles");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR ROLES DE USUARIO  ======*/

	/*======================================
	=            EDITAR USUARIO            =
	======================================*/
	
	static public function mdlEditarUsuarioPlataforma($tabla,$datos){

	 	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, telefono = :telefono, almacen = :almacen, password = :password WHERE id_usuario_plataforma = :id_usuario_plataforma");

 		$stmt -> bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":email",$datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono",$datos["telefono"], PDO::PARAM_STR);		
		$stmt -> bindParam(":password",$datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma",$datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":almacen",$datos["almacen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}else{
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR USUARIO  ======*/
	
	/*=================================================================
	=            ESTADO DE USUARIO(ACTIVADO O DESACTIVADO)            =
	=================================================================*/
	
	static public function mdlHabilitarUsuarioDashboard($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id_usuario_plataforma = :id_usuario_plataforma");
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ESTADO DE USUARIO(ACTIVADO O DESACTIVADO)  ======*/

	/*=====================================================
	=            ELIMINAR USUARIO DE DASHBOARD            =
	=====================================================*/
	
	static public function mdlEliminarUsuario($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of ELIMINAR USUARIO DE DASHBOARD  ======*/

	/*============================================================================
	=                   GUARDAR REGISTRO DE COMPRA DE VENDEDOR                   =
	============================================================================*/
	
	static public function mdlCrearRegistroCompraVendedor($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_usuario_plataforma, fecha_adquirido, fecha_ultimo_pago, fecha_proximo_pago, tipo_usuario, estado) 
													VALUES(:id_empresa, :id_usuario_plataforma, :fecha_adquirido, :fecha_ultimo_pago, :fecha_proximo_pago, :tipo_usuario, :estado)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario_plataforma", $datos["id_usuario_plataforma"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_adquirido", $datos["fecha_adquirido"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":tipo_usuario", $datos["tipo_usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of GUARDAR REGISTRO DE COMPRA DE VENDEDOR  =============*/

	/*=================================================
	=            MOSTRAR CLIENTES DIRECTOS            =
	=================================================*/
	
	static public function mdlMostrarUsuariosenalmacen($id_usuario_plataforma){
 

			//$stmt = Conexion::conectar()->prepare("SELECT up.*, a.nombre FROM usuarios_plataforma as up, almacenes as a WHERE up.id_usuario_plataforma = :id_usuario_plataforma  AND up.almacen = a.id_almacen");
			$stmt = Conexion::conectar()->prepare("SELECT up.*, a.nombre FROM usuarios_plataforma as up, almacenes as a WHERE up.id_usuario_plataforma = :id_usuario_plataforma  AND up.almacen = a.id_almacen");
			$stmt -> bindParam(":id_usuario_plataforma", $id_usuario_plataforma, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		

		$stmt -> close();
		$stmt = NULL; 
	}
	
	/*=====  End of MOSTRAR CLIENTES DIRECTOS  ======*/

}

?>