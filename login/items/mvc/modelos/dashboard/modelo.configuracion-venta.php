<?php

class ModeloConfiguracionventa{

	/*==================================================
	=            MOSTRAR CONFIGURACION VENTA            =
	==================================================*/
	
	static public function mdlMostrarconfig($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION VENTA  ======*/
    /*================================================
	=            CREAR CONFIGURACION COMISION          =
	================================================*/
	
	static public function mdlCrearConfigVentacomision($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, comision_tarjeta, porcentajeTD, porcentajeTC, iva_comision_tarjeta) VALUES(:id_empresa, :comision_tarjeta, :porcentajeTD, :porcentajeTC, :iva_comision_tarjeta)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":comision_tarjeta", $datos["comision_tarjeta"], PDO::PARAM_STR);
		$stmt -> bindParam(":porcentajeTD", $datos["porcentajeTD"], PDO::PARAM_STR);
		$stmt -> bindParam(":porcentajeTC", $datos["porcentajeTC"], PDO::PARAM_STR);
		$stmt -> bindParam(":iva_comision_tarjeta", $datos["iva_comision_tarjeta"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CONFIGURACION COMISION  ======*/
    /*=================================================
	=            EDITAR CONFIGURACION COMISION           =
	=================================================*/
	
	static public function mdlEditarConfigVentacomision($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET comision_tarjeta = :comision_tarjeta, porcentajeTD = :porcentajeTD, porcentajeTC = :porcentajeTC, iva_comision_tarjeta= :iva_comision_tarjeta  WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":comision_tarjeta", $datos["comision_tarjeta"], PDO::PARAM_STR);
		$stmt -> bindParam(":porcentajeTD", $datos["porcentajeTD"], PDO::PARAM_STR);
		$stmt -> bindParam(":porcentajeTC", $datos["porcentajeTC"], PDO::PARAM_STR);
		$stmt -> bindParam(":iva_comision_tarjeta", $datos["iva_comision_tarjeta"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CONFIGURACION COMISION  ======*/

    /*================================================
	=            CREAR CONFIGURACION Vanta IVA          =
	================================================*/
	
	static public function mdlCrearConfigVentaIVA($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, usar_iva, incluido) VALUES(:id_empresa, :usar_iva, :incluido)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":usar_iva", $datos["usar_iva"], PDO::PARAM_STR);
		$stmt -> bindParam(":incluido", $datos["incluido"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CONFIGURACION Vanta IVA ======*/
    /*=================================================
	=            EDITAR CONFIGURACION Vanta IVA          =
	=================================================*/
	
	static public function mdlEditarConfigVentaIVA($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET usar_iva = :usar_iva, incluido = :incluido WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":usar_iva", $datos["usar_iva"], PDO::PARAM_STR);
		$stmt -> bindParam(":incluido", $datos["incluido"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CONFIGURACION Vanta IVA ======*/
	/*=================================================
	=            EDITAR CONFIGURACION PRECIO          =
	=================================================*/
	
	static public function mdlEditarConfigVentaPrecio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET precio_variable = :precio_variable WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio_variable", $datos["precio_variable"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CONFIGURACION Vanta PRECIO ======*/

}

?>