<?php

class ModelosEmpresas{

	/*====================================================
	=            MOSTRAR EMPRESAS POR CLIENTE            =
	====================================================*/
	
	static public function mdlMostrarEmpresas($tabla, $item, $valor){

		if ($item == "id_empresa") {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();
			
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt  = NULL;
	}
	
	/*=====  End of MOSTRAR EMPRESAS POR CLIENTE  ======*/
	
	
	/*============================================================================
	=            SOLICITUD DE CODIGO DE VERIFICACION GUARDAR EN CAMPO            =
	============================================================================*/
	
	static public function mdlGuardarCodigoVerificacionPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigoVerificacionPagos = :codigoVerificacionPagos WHERE id_empresa = :id_empresa");
		$stmt -> bINDpARAM(":codigoVerificacionPagos", $datos["codigoVerificacionPagos"], PDO::PARAM_STR);
		$stmt -> bINDpARAM(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of SOLICITUD DE CODIGO DE VERIFICACION GUARDAR EN CAMPO  ======*/

	/*=================================================================
	=                   MOSTRAR CODIGO VERIFICACION                   =
	=================================================================*/
	
	static public function mdlMostrarCodigoVerificacionPago($tabla, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT codigoVerificacionPagos FROM $tabla WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	
	/*============  End of MOSTRAR CODIGO VERIFICACION  =============*/
	/*======================================================================================
	=            MOSTRAR INFORMACION CLIENTE DIRECTO POR MEDIO DE LA ID_EMPRESA            =
	======================================================================================*/
	
	static public function mdlMostrarClientePorEmpresa($datos){

		$stmt = Conexion::conectar()->prepare("SELECT c.* FROM clientes_servicio_plataforma as c, empresas as e 
															WHERE c.id_clienteDirecto = e.id_clienteDirecto
															AND e.id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR INFORMACION CLIENTE DIRECTO POR MEDIO DE LA ID_EMPRESA  ======*/

	/*===================================================================
	=                   CREAR CLIENTE DIRECTO EMPRESA                   =
	===================================================================*/
	
	static public function modeloCrearClienteDirectoEmpresa($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, email, telefono, password, estado) 
												VALUES (:nombre, :correo, :telefono, :password, :estado)");
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		
		if($stmt -> execute()){
			return "ok";
		} else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of CREAR CLIENTE DIRECTO EMPRESA  =============*/
	
	/*=============================================================
	=                   MOSTRAR CLIENTE DIRECTO                   =
	=============================================================*/
	
	static public function modeloMostrarClienteDirectoEmpresa($tabla, $item, $valor){

		if($item == NULL){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC LIMIT 7");
		}

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR CLIENTE DIRECTO  =============*/

	/*===================================================
	=                   CREAR EMPRESA                   =
	===================================================*/
	static public function modeloCrearEmpresa($tabla,$datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_clienteDirecto, rfc, nombre, domicilio, ramo, alias) 
												VALUES (:id_clienteDirecto, :rfc, :nombre, :domicilio, :ramo, :alias)");
		$stmt -> bindParam(":id_clienteDirecto", $datos["id_cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":domicilio", $datos["domicilio"], PDO::PARAM_STR);
		$stmt -> bindParam(":ramo", $datos["ramo"], PDO::PARAM_STR);
		$stmt -> bindParam(":alias", $datos["alias"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		} else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CREAR EMPRESA  =============*/

	/*==================================================================================
	=                   MOSTRAR EMPRESA POR CLIENTE DIRECTO                  =
	==================================================================================*/
	
	static public function modeloMostrarEmpresaPorClienteDirecto($tabla, $item, $valor){

		if($item !== NULL){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetch();

		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR EMPRESA POR CLIENTE DIRECTO  =============*/

	/*=============================================================
	=                   CREAR CONTENIDO EMPRESA                   =
	=============================================================*/

	static public function modeloCrearContenidoEmpresa($tabla,$empresa){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa) 
												VALUES (:id_empresa)");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		if($stmt -> execute()){
			return "ok";
		} else {
			return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CREAR CONTENIDO EMPRESA  =============*/

	/**
	*
	* CREANDO CONFIGURACION DE LA EMPRESA
	*
	*/

	/*=======================================================================
	=                   CREAR CONFIGURACION PAGOS EMPRESA                   =
	=======================================================================*/
	
	static public function modeloCrearConfiguracionesEmpresa($tabla, $empresa){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa) 
												VALUES (:id_empresa)");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		if($stmt -> execute()){
		return "ok";
		} else {
		return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CREAR CONFIGURACION PAGOS EMPRESA  =============*/

	/*========================================================================
	=                   PRUEBA CREAR CONFIGURACION EMPRESA                   =
	========================================================================*/
	
	static public function modeloCrearConfiguracionesPagosEmpresa($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, pago_inicial, periodos) 
												VALUES (:id_empresa, :pago_inicial, :periodos)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":pago_inicial", $datos["pago_inicial"], PDO::PARAM_STR);
		$stmt -> bindParam(":periodos", $datos["periodos"], PDO::PARAM_STR);

		if($stmt -> execute()){
		return "ok";
		} else {
		return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of PRUEBA CREAR CONFIGURACION EMPRESA  =============*/
	
	/*=======================================================================
	=                   CREAR CONFIGURACION PAGOS EMPRESA                   =
	=======================================================================*/
	
	static public function modeloCrearConfiguracionesPagosAlmacen($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_almacen, pago_inicial, periodos) 
												VALUES (:id_almacen, :pago_inicial, :periodos)");
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":pago_inicial", $datos["pago_inicial"], PDO::PARAM_STR);
		$stmt -> bindParam(":periodos", $datos["periodos"], PDO::PARAM_STR);

		if($stmt -> execute()){
		return "ok";
		} else {
		return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CREAR CONFIGURACION PAGOS EMPRESA  =============*/

	/*==========================================================================
	=                   MOSTRAR INFO EMPRESA CLIENTE DIRECTO                   =
	==========================================================================*/
	
	static public function mdlMostrarInfoEmpresaClienteDirecto(){
		$stmt = Conexion::conectar()->prepare("SELECT e.id_empresa, e.nombre as empresa, c.id_clienteDirecto, c.nombre 
												FROM clientes_servicio_plataforma as c, empresas as e 
												WHERE e.id_clienteDirecto = c.id_clienteDirecto ORDER BY e.fecha DESC");

		$stmt -> execute();

		return $stmt->fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR INFO EMPRESA CLIENTE DIRECTO  =============*/

	/*==============================================================
	=                   CREAR USUARIO PLATAFORMA                   =
	==============================================================*/
	
	static public function mdlCrearUsuarioPlataforma($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, nombre, email, password, telefono, almacen, estado, rol) 
												VALUES (:id_empresa, :nombre, :email, :password, :telefono, :almacen, :estado, :rol)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt -> bindParam(":almacen", $datos["almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":rol", $datos["rol"], PDO::PARAM_STR);

		if($stmt -> execute()){
		return "ok";
		} else {
		return "error";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	
	/*============  End of CREAR USUARIO PLATAFORMA  =============*/
	
}

?>