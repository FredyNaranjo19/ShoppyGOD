<?php
 
class ModeloFacturacion{

	/*===================================================================
	=            MOSTRAR INFORMACION DE TIMBRE DE LA EMPRESA            =
	===================================================================*/
	
	static public function mdlMostrarTimbresEmpresa($tabla, $item, $valor, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetch();

	}
	
	/*=====  End of MOSTRAR INFORMACION DE TIMBRE DE LA EMPRESA  ======*/

	/*===========================================================
	=            CREAR REGISTRO DE COMPRA DE TIMBRES            =
	===========================================================*/
	
	static public function mdlCrearRegistroCompraTimbres($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, facturas_compradas, 
																facturas_disponibles, fecha_compra, 
																fecha_caducidad) 
												VALUES(:id_empresa, :facturas_compradas, 
														:facturas_disponibles, :fecha_compra, 
														:fecha_caducidad)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":facturas_compradas", $datos["facturas_compradas"], PDO::PARAM_STR);
		$stmt -> bindParam(":facturas_disponibles", $datos["facturas_disponibles"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_compra", $datos["fecha_compra"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_caducidad", $datos["fecha_caducidad"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
	} 
	
	/*=====  End of CREAR REGISTRO DE COMPRA DE TIMBRES  ======*/

	/*============================================================
	=            EDITAR REGISTRO DE COMPRA DE TIMBRES            =
	============================================================*/
	
	static public function mdlEditarRegistroCompraTimbres($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla 
												SET facturas_compradas = :facturas_compradas, facturas_disponibles = :facturas_disponibles,
													fecha_compra = :fecha_compra, fecha_caducidad = :fecha_caducidad
												WHERE id_empresa = :id_empresa");
		
		$stmt -> bindParam(":facturas_compradas", $datos["facturas_compradas"], PDO::PARAM_STR);
		$stmt -> bindParam(":facturas_disponibles", $datos["facturas_disponibles"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_compra", $datos["fecha_compra"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_caducidad", $datos["fecha_caducidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return "ok";
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR REGISTRO DE COMPRA DE TIMBRES  ======*/
	
		
	/*==========================================================
	=            MOSTRAR LISTADO DE PRECIOS TIMBRES            =
	==========================================================*/
	
	static public function mdlMostrarListadoPreciosTimbrados($tabla, $item, $valor){

		if ($item != NULL) {

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
	
	/*=====  End of MOSTRAR LISTADO DE PRECIOS TIMBRES  ======*/
	

	/*===================================================
	=            MOSTRAR FACTURAS REALIZADAS            =
	===================================================*/
	
	static public function mdlMostrarFacturas($tabla, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR FACTURAS REALIZADAS  ======*/

	/*=====================================================
	=            CREAR REGISTRO DE FACTURACION            =
	=====================================================*/
	
	static public function mdlCrearRegistroFactura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, serie, folio, nombre, zona, folios) VALUES(:id_empresa, :serie, :folio, :nombre, :zona, :folios)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
		$stmt -> bindParam(":folios", $datos["folios"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR REGISTRO DE FACTURACION  ======*/	

	/*===============================================================
	=            CREAR REGISTRO DE FACTURA DESDE ALMACEN            =
	===============================================================*/
	
	static public function mdlCrearRegistroFacturaAlmacen($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_empresa, serie, folio, nombre, id_almacen, zona) 
															VALUES(:id_empresa, :serie, :folio, :nombre, :id_almacen, :zona)");
		
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_almacen", $datos["id_almacen"], PDO::PARAM_STR);
		$stmt -> bindParam(":zona", $datos["zona"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR REGISTRO DE FACTURA DESDE ALMACEN  ======*/
		

	/*==============================================================
	=            MOSTRAR INFORMACION FACTURACION CLIENTE           =
	==============================================================*/
	
	static public function mdlMostrarInfoFacturacionCliente($tabla, $item, $valor, $empresa){

		if($item !== null && $valor !== null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item  AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
	
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();
	
			return $stmt -> fetchAll();
		}

		$stmt -> close(); 
		$stmt = NULL;
	} 
	
	/*=====  End of MOSTRAR INFORMACION FACTURACION CLIENTE ======*/
	
	/*=============================================================
	=            CREAR DATOS DE FACTURACION DE EMPRESA            =
	=============================================================*/
	
	static public function mdlCrearDatosFacturacionEmpresa($tabla, $datos){

		$stmt = COnexion::conectar()->prepare("INSERT INTO $tabla(razon_social, rfc, calle, noExt, colonia, cp, municipio, estado, email, id_empresa) VALUES(:razon_social, :rfc, :calle, :noExt, :colonia, :cp, :municipio, :estado, :email, :id_empresa)");

		$stmt -> bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
		$stmt -> bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt -> bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt -> bindParam(":noExt", $datos["noExt"], PDO::PARAM_STR);
		$stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt -> bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR DATOS DE FACTURACION DE EMPRESA  ======*/

	/*==============================================================
	=            EDITAR DATOS DE FACTURACION DE EMPRESA            =
	==============================================================*/
	
	static public function mdlEditarDatosFacturacionEmpresa($tabla, $datos){

		$stmt = COnexion::conectar()->prepare("UPDATE $tabla SET razon_social = :razon_social, rfc = :rfc, calle = :calle, noExt = :noExt, colonia = :colonia, cp = :cp, municipio = :municipio, estado = :estado, email = :email WHERE id_modulo_facturas_datos = :id_modulo_facturas_datos");

		$stmt -> bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
		$stmt -> bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt -> bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt -> bindParam(":noExt", $datos["noExt"], PDO::PARAM_STR);
		$stmt -> bindParam(":colonia", $datos["colonia"], PDO::PARAM_STR);
		$stmt -> bindParam(":cp", $datos["cp"], PDO::PARAM_STR);
		$stmt -> bindParam(":municipio", $datos["municipio"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_modulo_facturas_datos", $datos["id_modulo_facturas_datos"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}
 
		$stmt -> close();
		$stmt = NULL;
		
	}
	
	/*=====  End of EDITAR DATOS DE FACTURACION DE EMPRESA  ======*/
	
	/*========================================================
	=            MOSTRAR CONFIGURACION DE FACTURA            =
	========================================================*/
	
	static public function mdlMostrarConfiguracion($tabla, $item, $valor, $empresa){

		if ($item != NULL) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE FACTURA  ======*/

	/*==========================================================
	=            CREAR CONFIGURACION DE FACTURACION            =
	==========================================================*/
	
	static public function mdlCrearConfiguracionFacturacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, logo, rfc, razon_social, factura_cer, factura_key, factura_password, 
										lugar_expedicion, color_marco, color_marco_texto, color_texto, correo_facturas) 
										VALUES(:id_empresa, :logo,  :rfc, :razon_social, :factura_cer, :factura_key, :factura_password, :lugar_expedicion, :color_marco, :color_marco_texto, :color_texto, :correo_facturas)");

		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":logo", $datos["logo"], PDO::PARAM_STR);
		$stmt -> bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt -> bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura_cer", $datos["factura_cer"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura_key", $datos["factura_key"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura_password", $datos["factura_password"], PDO::PARAM_STR);
		$stmt -> bindParam(":lugar_expedicion", $datos["lugar_expedicion"], PDO::PARAM_STR);
		$stmt -> bindParam(":color_marco", $datos["color_marco"], PDO::PARAM_STR);
		$stmt -> bindParam(":color_marco_texto", $datos["color_marco_texto"], PDO::PARAM_STR);
		$stmt -> bindParam(":color_texto", $datos["color_texto"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo_facturas", $datos["correo_facturas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CREAR CONFIGURACION DE FACTURACION  ======*/
	
	/*===========================================================
	=            EDITAR CONFIGURACION DE FACTURACION            =
	===========================================================*/
	
	static public function mdlEditarConfiguracionFacturacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET logo = :logo, rfc = :rfc, razon_social = :razon_social, factura_cer = :factura_cer, factura_key = :factura_key, factura_password = :factura_password, lugar_expedicion = :lugar_expedicion, color_marco = :color_marco, color_marco_texto = :color_marco_texto, color_texto = :color_texto, correo_facturas = :correo_facturas WHERE id_modulo_facturas_configuracion = :id_modulo_facturas_configuracion");

		$stmt -> bindParam(":logo", $datos["logo"], PDO::PARAM_STR);
		$stmt -> bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt -> bindParam(":razon_social", $datos["razon_social"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura_cer", $datos["factura_cer"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura_key", $datos["factura_key"], PDO::PARAM_STR);
		$stmt -> bindParam(":factura_password", $datos["factura_password"], PDO::PARAM_STR);
		$stmt -> bindParam(":lugar_expedicion", $datos["lugar_expedicion"], PDO::PARAM_STR);
		$stmt -> bindParam(":color_marco", $datos["color_marco"], PDO::PARAM_STR);
		$stmt -> bindParam(":color_marco_texto", $datos["color_marco_texto"], PDO::PARAM_STR);
		$stmt -> bindParam(":color_texto", $datos["color_texto"], PDO::PARAM_STR);
		$stmt -> bindParam(":correo_facturas", $datos["correo_facturas"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_modulo_facturas_configuracion", $datos["id_modulo_facturas_configuracion"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}


		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR CONFIGURACION DE FACTURACION  ======*/

	/*===================================================================
	=            MOSTRAR SERIES DE CONFIGURACION DE FACTURAS            =
	===================================================================*/
	
	static public function mdlMostrarConfSeriesFacturacion($tabla, $item, $valor, $empresa){

		if ($item != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND id_empresa = :id_empresa");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
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
	
	/*=====  End of MOSTRAR SERIES DE CONFIGURACION DE FACTURAS  ======*/
	

	/*==================================================
	=            CREAR SERIE DE FACTURACION            =
	==================================================*/
	
	static public function mdlCrearConfiguracionSerieFactura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, serie, significado, folio_inicial) 
													VALUES(:id_empresa, :serie, :significado, :folio_inicial)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt -> bindParam(":significado", $datos["significado"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio_inicial", $datos["folio_inicial"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR SERIE DE FACTURACION  ======*/

	/*===================================================
	=            EDITAR SERIE DE FACTURACION            =
	===================================================*/
	
	static public function mdlEditarConfiguracionSerieFactura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET serie = :serie, significado = :significado WHERE id_modulo_facturas_series = :id_modulo_facturas_series");
		$stmt -> bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt -> bindParam(":significado", $datos["significado"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_modulo_facturas_series", $datos["id_modulo_facturas_series"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR SERIE DE FACTURACION  ======*/


	/*============================================================================
	=            MODIFICACION DE NUEMRO DE FOLIO POR SERIE DE FACTURA            =
	============================================================================*/
	
	static public function mdlEditarSerieFolioFactura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET no_folios = :no_folios 
												WHERE id_modulo_facturas_series = :id_modulo_facturas_series");
		$stmt -> bindParam(":no_folios", $datos["no_folios"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_modulo_facturas_series", $datos["id_modulo_facturas_series"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MODIFICACION DE NUEMRO DE FOLIO POR SERIE DE FACTURA  ======*/
		
	

	/*=================================================================
	=            MOSTRAR FACTURAS REALIZADAS DE LA EMPRESA            =
	=================================================================*/
	
	static public function mdlMostrarFacturasRealizadas($tabla, $item, $valor, $empresa){

		if ($item != NULL) {
			
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
	
	/*=====  End of MOSTRAR FACTURAS REALIZADAS DE LA EMPRESA  ======*/

	/*====================================================================
	=            MODIFICAR FACTURAS DISPONIBLES DE LA EMPRESA            =
	====================================================================*/
	
	static public function mdlEditarFacturasDisponibles($empresa){

		$stmt = Conexion::conectar()->prepare("UPDATE modulo_facturas_compras 
												SET facturas_disponibles = facturas_disponibles - 1 
												WHERE id_empresa = :id_empresa");

		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MODIFICAR FACTURAS DISPONIBLES DE LA EMPRESA  ======*/
			
	/*======================================================
	=            MODIFICAR ESTADO DE LA FACTURA            =
	======================================================*/

	static public function mdlEditarEstadoFactura($empresa,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE modulo_facturas 
												SET estado = :estado 
												WHERE id_empresa = :id_empresa AND id_modulo_facturas = :id" );

		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_STR);
		
		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}

	/*=====  End of MODIFICAR ESTADO DE LA FACTURA ======*/
	
	/*===========================================================
	=            MOSTRAR FACTURAS SEGUN LA BUSQUEDA             =
	===========================================================*/	

	static public function mdlMostrarFacturasFiltradas($datos, $tabla, $empresa){
		if ($datos["campo"] == "fecha") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND DATE(fecha) BETWEEN '".$datos['fecha1']."' AND '".$datos['fecha2']."'");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

		} elseif ($datos["campo"] == "serie") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND serie = :serie");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":serie", $datos["busqueda"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();

			// return "serie O folio";
		} elseif($datos["campo"] == "folio"){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND folio = :folio");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":folio", $datos["busqueda"], PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();
		}elseif($datos["campo"] == "serie_folio"){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND folio = :folio AND serie = :serie");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
			$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
			$stmt -> execute();
			
			return $stmt -> fetchAll();

		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND DATE_FORMAT(fecha, '%Y%m') = DATE_FORMAT(CURDATE(), '%Y%m')");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetchAll();
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR FACTURAS SEGUN LA BUSQUEDA  ======*/
	
}

?>