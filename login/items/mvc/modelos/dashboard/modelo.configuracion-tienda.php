<?php

class ModeloConfiguracionTienda{

	/*==================================================
	=            MOSTRAR LOGO DE LA EMPRESA            =
	==================================================*/
	
	static public function mdlMostrarLogo($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR LOGO DE LA EMPRESA  ======*/

	/*================================================
	=            CREAR LOGO DE LA EMPRESA            =
	================================================*/
	
	static public function mdlCrearLogoEmpresa($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, imagen) VALUES(:id_empresa, :imagen)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR LOGO DE LA EMPRESA  ======*/

	/*====================================================
	=            MOSTRAR CONFIGURACION DE SEO            =
	====================================================*/
	
	static public function mdlMostrarSEO($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE SEO  ======*/

	/*===============================================
	=            CREAR CONFIGURACION SEO            =
	===============================================*/
	
	static public function mdlCrearSEO($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, metadatos) VALUES(:id_empresa, :metadatos)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":metadatos", $datos["metadatos"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of CREAR CONFIGURACION SEO  ======*/

	/*================================================
	=            EDITAR CONFIGURACION SEO            =
	================================================*/
	
	static public function mdlEditarSEO($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET metadatos = :metadatos WHERE id_empresa = :id_empresa");

		$stmt -> bindParam(":metadatos", $datos["metadatos"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR CONFIGURACION SEO  ======*/

	/*======================================================
	=            MOSTRAR CONFIGURACION DE PAGOS            =
	======================================================*/
	
	static public function mdlMostrarConfiguracionPago($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE PAGOS  ======*/

	/*====================================================
	=            CREAR CONFIGURACION DE PAGOS            =
	====================================================*/
	
	static public function mdlCrearConfiguracionPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, efectivoView, efectivoTarjeta, mercadoView, mercadoAccess,
			banco, propietario) VALUES(:id_empresa, :efectivoView, :efectivoTarjeta, :mercadoView, :mercadoAccess, :banco, :propietario)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":efectivoView", $datos["efectivoView"], PDO::PARAM_STR);
		$stmt -> bindParam(":efectivoTarjeta", $datos["efectivoTarjeta"], PDO::PARAM_STR);
		$stmt -> bindParam(":mercadoView", $datos["mercadoView"], PDO::PARAM_STR);
		$stmt -> bindParam(":mercadoAccess", $datos["mercadoAccess"], PDO::PARAM_STR);
		$stmt -> bindParam(":banco", $datos["banco"], PDO::PARAM_STR);
		$stmt -> bindParam(":propietario", $datos["propietario"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR CONFIGURACION DE PAGOS  ======*/

	/*=====================================================
	=            EDITAR CONFIGURACION DE PAGOS            =
	=====================================================*/
	
	static public function mdlEditarConfiguracionPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET efectivoView = :efectivoView, efectivoTarjeta = :efectivoTarjeta, mercadoView = :mercadoView, mercadoAccess = :mercadoAccess, banco = :banco, propietario = :propietario WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":efectivoView", $datos["efectivoView"], PDO::PARAM_STR);
		$stmt -> bindParam(":efectivoTarjeta", $datos["efectivoTarjeta"], PDO::PARAM_STR);
		$stmt -> bindParam(":mercadoView", $datos["mercadoView"], PDO::PARAM_STR);
		$stmt -> bindParam(":mercadoAccess", $datos["mercadoAccess"], PDO::PARAM_STR);
		$stmt -> bindParam(":banco", $datos["banco"], PDO::PARAM_STR);
		$stmt -> bindParam(":propietario", $datos["propietario"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR CONFIGURACION DE PAGOS  ======*/

	/*=======================================================
	=            MOSTRAR INFORMACION DE WHATSAPP            =
	=======================================================*/
	
	static public function mdlMostrarRedes($tabla, $item, $valor){

		if ($item == "id_empresa") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR INFORMACION DE WHATSAPP  ======*/

	/*========================================
	=            CREACION DE REDES           =
	========================================*/
	
	static public function mdlCrearRedes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, numero, textoWhats, estadoWhats, id_page, color, entrada, salida, estadoMessenger) VALUES(:id_empresa, :numero, :textoWhats, :estadoWhats, :id_page, :color, :entrada, :salida, :estadoMessenger)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":numero", $datos["numero"], PDO::PARAM_STR);
		$stmt -> bindParam(":textoWhats", $datos["textoWhats"], PDO::PARAM_STR);
		$stmt -> bindParam(":estadoWhats", $datos["estadoWhats"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_page", $datos["id_page"], PDO::PARAM_STR);
		$stmt -> bindParam(":color", $datos["color"], PDO::PARAM_STR);
		$stmt -> bindParam(":entrada", $datos["entrada"], PDO::PARAM_STR);
		$stmt -> bindParam(":salida", $datos["salida"], PDO::PARAM_STR);
		$stmt -> bindParam(":estadoMessenger", $datos["estadoMessenger"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREACION DE REDES ======*/
	
	/*=============================================
	=            EDITAR REDES SOCIALES            =
	=============================================*/
	
	static public function mdlEditarRedes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET numero = :numero, textoWhats = :textoWhats, estadoWhats = :estadoWhats, id_page = :id_page, color = :color, entrada = :entrada, salida = :salida, estadoMessenger = :estadoMessenger WHERE id_empresa = :id_empresa");

		$stmt -> bindParam(":numero", $datos["numero"], PDO::PARAM_STR);
		$stmt -> bindParam(":textoWhats", $datos["textoWhats"], PDO::PARAM_STR);
		$stmt -> bindParam(":estadoWhats", $datos["estadoWhats"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_page", $datos["id_page"], PDO::PARAM_STR);
		$stmt -> bindParam(":color", $datos["color"], PDO::PARAM_STR);
		$stmt -> bindParam(":entrada", $datos["entrada"], PDO::PARAM_STR);
		$stmt -> bindParam(":salida", $datos["salida"], PDO::PARAM_STR);
		$stmt -> bindParam(":estadoMessenger", $datos["estadoMessenger"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR REDES SOCIALES  ======*/

	/*==============================================
	=            TERMINOS Y CONDICIONES            =
	==============================================*/
	
		/* MOSTRAR TERMINOS Y CONDICIONES */

		static public function mdlMostrarTerminosEmpresa($tabla, $item, $valor){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();
			$stmt = NULL;
		}

		/* CREAR TERMINOS Y CONDICIONES */
		
		static public function mdlCrearTerminoEmpresa($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, texto) VALUES(:id_empresa, :texto)");
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> bindParam(":texto", $datos["texto"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt -> close();
			$stmt = NULL;
		}

		/* EDITAR TERMINOS Y CONDICIONES */

		static public function mdlEditarTerminoEmpresa($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET texto = :texto WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":texto", $datos["texto"], PDO::PARAM_STR); 
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt -> close();
			$stmt = NULL;
		}
		
	
	/*=====  End of TERMINOS Y CONDICIONES  ======*/

	/*===============================================
	=            POLITICAS DE PRIVACIDAD            =
	===============================================*/
	
		/* MOSTRAR POLITICAS DE PRIVACIDAD */
		
		static public function mdlMostrarPoliticasEmpresa($tabla, $item, $valor){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();
			$stmt = NULL;

		}

		/* CREAR POLITICAS DE PRIVACIDAD */

		static public function mdlCrearPoliticaEmpresa($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, texto) VALUES(:id_empresa, :texto)");
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> bindParam(":texto", $datos["texto"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt -> close();
			$stmt = NULL;

		}

		/* EDITAR POLITICAS DE PRIVACIDAD */

		static public function mdlEditarPoliticaEmpresa($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET texto = :texto WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":texto", $datos["texto"], PDO::PARAM_STR); 
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR); 

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt -> close();
			$stmt = NULL;

		}
		
	/*=====  End of POLITICAS DE PRIVACIDAD  ======*/

	/*=========================================================
	=            MOSTRAR CONFIGURACION DE ENTREGAS            =
	=========================================================*/
	
	static public function mdlMostrarConfiguracionEntregas($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE ENTREGAS  ======*/

	/*=======================================================
	=            CREAR CONFIGURACION DE ENTREGAS            =
	=======================================================*/
	
	static public function mdlCrearConfiguracionEntregas($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, sucursal, envios) VALUES(:id_empresa, :sucursal, :envios)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":sucursal", $datos["sucursal"], PDO::PARAM_STR);
		$stmt -> bindParam(":envios", $datos["envios"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR CONFIGURACION DE ENTREGAS  ======*/
	
	/*========================================================
	=            EDITAR CONFIGURACION DE ENTREGAS            =
	========================================================*/
	
	static public function mdlEditarConfiguracionEntregas($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET sucursal = :sucursal, envios = :envios WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":sucursal", $datos["sucursal"], PDO::PARAM_STR);
		$stmt -> bindParam(":envios", $datos["envios"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR CONFIGURACION DE ENTREGAS  ======*/

	/*====================================================
	=            MOSTRAR CONFIGURACION ENVIOS            =
	====================================================*/
	
	static public function mdlMostrarEnvios($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR CONFIGURACION ENVIOS  ======*/

	/*============================================================
	=            GUARDAR NUEVA CONFIGURACION DE ENVIO            =
	============================================================*/
	
	static public function mdlGuardarConfiguracionEnvio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, peso_volumetrico, peso_masa, precio) 
														VALUES(:id_empresa, :peso_volumetrico, :peso_masa, :precio)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso_volumetrico", $datos["peso_volumetrico"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso_masa", $datos["peso_masa"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of GUARDAR NUEVA CONFIGURACION DE ENVIO  ======*/

	/*=====================================================
	=            EDITAR CONFIGURACION DE ENVIO            =
	=====================================================*/
	
	static public function mdlEditarConfiguracionEnvio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET peso_volumetrico = :peso_volumetrico, peso_masa = :peso_masa, precio = :precio 
														WHERE id_configuracion_envios = :id_configuracion_envios");

		$stmt -> bindParam(":peso_volumetrico", $datos["peso_volumetrico"], PDO::PARAM_STR);
		$stmt -> bindParam(":peso_masa", $datos["peso_masa"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_configuracion_envios", $datos["id_configuracion_envios"], PDO::PARAM_STR);

		if($stmt -> execute()){
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of EDITAR CONFIGURACION DE ENVIO  ======*/

	/*=======================================================
	=            ELIMINAR CONFIGURACION DE ENVIO            =
	=======================================================*/
	
	static public function mdlEliminarConfiguracionEnvio($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of ELIMINAR CONFIGURACION DE ENVIO  ======*/

	/*===============================================
	=            CONTACTO DE LA EMPRESA             =
	===============================================*/
	
		/* MOSTRAR INFORMACION DE CONTACTO DE LA EMPRESA */
		
		static public function mdlMostrarContactoEmpresa($tabla, $item, $valor){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

			$stmt -> close();
			$stmt = NULL;

		}

		/* CREAR INFORMACION DE CONTACTO DE LA EMPRESA */
		
		static public function mdlCrearContactoEmpresa($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, telefono, mail) VALUES(:id_empresa, :telefono, :mail)");
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
			$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
			$stmt -> bindParam(":mail", $datos["mail"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt = close();
			$stmt = NULL;
		}

		/* EDITAR INFORMACION DE CONTACTO DE LA EMPRESA */

		static public function mdlEditarContactoEmpresa($tabla, $datos){

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET telefono = :telefono, mail = :mail WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
			$stmt -> bindParam(":mail", $datos["mail"], PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

			if ($stmt -> execute()) {
				return 'ok';
			}

			$stmt = close();
			$stmt = NULL;

		}
		
	/*=====  End of CONTACTO DE LA EMPRESA   ======*/

	/*==================================================
	=            MOSTRAR MIS REDES SOCIALES            =
	==================================================*/
	
	static public function mdlMostrarMisRedesSociales($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close(); 
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR MIS REDES SOCIALES  ======*/

	/*================================================
	=            CREAR MIS REDES SOCIALES            =
	================================================*/
	
	static public function mdlCrearMisRedesSociales($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, facebook, instagram, twitter, youtube, tiktok) VALUES(:id_empresa, :facebook, :instagram, :twitter, :youtube, :tiktok)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":facebook", $datos["facebook"], PDO::PARAM_STR);
		$stmt -> bindParam(":instagram", $datos["instagram"], PDO::PARAM_STR);
		$stmt -> bindParam(":twitter", $datos["twitter"], PDO::PARAM_STR);
		$stmt -> bindParam(":youtube", $datos["youtube"], PDO::PARAM_STR);
		$stmt -> bindParam(":tiktok", $datos["tiktok"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR MIS REDES SOCIALES  ======*/
	
	/*=================================================
	=            EDITAR MIS REDES SOCIALES            =
	=================================================*/
	
	static public function mdlEditarMisRedesSociales($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET facebook = :facebook, instagram = :instagram, twitter = :twitter, youtube = :youtube, tiktok = :tiktok WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":facebook", $datos["facebook"], PDO::PARAM_STR);
		$stmt -> bindParam(":instagram", $datos["instagram"], PDO::PARAM_STR);
		$stmt -> bindParam(":twitter", $datos["twitter"], PDO::PARAM_STR);
		$stmt -> bindParam(":youtube", $datos["youtube"], PDO::PARAM_STR);
		$stmt -> bindParam(":tiktok", $datos["tiktok"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR MIS REDES SOCIALES  ======*/
}

?>