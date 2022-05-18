<?php

class ModeloPlantillasTienda{

	/*==========================================
	=            MOSTRAR PLANTILLAS            =
	==========================================*/
	
	static public function mdlMostrarPlantillas($tabla, $item, $valor){

		if ($item == "id_plantilla") {

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

	/*=====  End of MOSTRAR PLANTILLAS  ======*/

	/*============================================================
	=            MOSTRAR CATEGORIAS DE LAS PLANTILLAS            =
	============================================================*/
	
	static public function mdlMostrarCategoriasPlantillas(){

		$stmt = Conexion::conectar()->prepare("SELECT categoria FROM pppppp GROUP BY categoria");
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR CATEGORIAS DE LAS PLANTILLAS  ======*/

	/*==========================================
	=            CREAR MI PLANTILLA            =
	==========================================*/
	
	static public function mdlCrearMiPlantilla($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_plantilla, estado) VALUES(:id_empresa, :id_plantilla, :estado)");
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_plantilla", $datos["id_plantilla"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREAR MI PLANTILLA  ======*/

	/*==============================================
	=            MOSTRAR MIS PLANTILLAS            =
	==============================================*/
	
	static public function mdlMostrarMisPlantillas($tabla, $item, $valor, $empresa){

		if ($item == "id_misPlantillas") {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();

		} else if ($item == "id_plantilla"){

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

			$stmt -> close();
			$stmt = NULL;

		}
		

	}
	
	/*=====  End of MOSTRAR MIS PLANTILLAS  ======*/

	/*=================================================================
	=            DESACTIVACION DE PLANTILLAS DE LA EMPRESA            =
	=================================================================*/
	
	static public function mdlDeseleccionarPlantilla($tabla, $plantilla, $empresa){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 'desactivado' WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of DESACTIVACION DE PLANTILLAS DE LA EMPRESA  ======*/

	/*================================================
	=            ACTIVACION DE PLANTILLA             =
	================================================*/
	
	static public function mdlSeleccionarPlantilla($tabla, $plantilla, $empresa){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 'activado' WHERE id_empresa = :id_empresa AND id_plantilla = :id_plantilla");
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> bindParam(":id_plantilla", $plantilla, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of ACTIVACION DE PLANTILLA   ======*/
	
	/*=============================================================
	=            MOSTRAR CONFIGURACION DE LA PLANTILLA            =
	=============================================================*/
	
	static public function mdlMostrarConfiguracion($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of MOSTRAR CONFIGURACION DE LA PLANTILLA  ======*/

	/*=================================================================
	=            CREACION DE CONFIGURACION DE MI PLANTILLA            =
	=================================================================*/
	
	static public function mdlCrearConfiguracionPlantilla($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(configuracion, id_misPlantillas) VALUES(:configuracion, :id_misPlantillas)");
		$stmt -> bindParam(":configuracion", $datos["configuracion"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_misPlantillas", $datos["id_misPlantillas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of CREACION DE CONFIGURACION DE MI PLANTILLA  ======*/

	/*============================================================
	=            EDITAR CONFIGURACION DE MI PLANTILLA            =
	============================================================*/
	
	static public function mdlEditarConfiguracionPlantilla($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET configuracion = :configuracion WHERE id_misPlantillas = :id_misPlantillas");
		$stmt -> bindParam(":configuracion", $datos["configuracion"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_misPlantillas", $datos["id_misPlantillas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of EDITAR CONFIGURACION DE MI PLANTILLA  ======*/

	/*=======================================================
	=            GUARDAR IMAGENES PARA PLANTILLA            =
	=======================================================*/
	
	static public function mdlCrearConfiguracionPlantillaImagenes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(imagenes, id_misPlantillas) VALUES(:imagenes, :id_misPlantillas)");
		$stmt -> bindParam(":imagenes", $datos["imagenes"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_misPlantillas", $datos["id_misPlantillas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of GUARDAR IMAGENES PARA PLANTILLA  ======*/
	
	/*======================================================
	=            EDITAR IMAGENES PARA PLANTILLA            =
	======================================================*/
	
	static public function mdlEditarConfiguracionPlantillaImagenes($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET imagenes = :imagenes WHERE id_misPlantillas = :id_misPlantillas");
		$stmt -> bindParam(":imagenes", $datos["imagenes"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_misPlantillas", $datos["id_misPlantillas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR IMAGENES PARA PLANTILLA  ======*/

	/*======================================================
	=            GUARDAR COLORES PARA PLANTILLA            =
	======================================================*/
	
	static public function mdlCrearConfiguracionPlantillaColores($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(colores, id_misPlantillas) VALUES(:colores, :id_misPlantillas)");
		$stmt -> bindParam(":colores", $datos["colores"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_misPlantillas", $datos["id_misPlantillas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of GUARDAR COLORES PARA PLANTILLA  ======*/
	
	/*=====================================================
	=            EDITAR COLORES PARA PLANTILLA            =
	=====================================================*/
	
	static public function mdlEditarConfiguracionPlantillaColores($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET colores = :colores WHERE id_misPlantillas = :id_misPlantillas");
		$stmt -> bindParam(":colores", $datos["colores"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_misPlantillas", $datos["id_misPlantillas"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of EDITAR COLORES PARA PLANTILLA  ======*/



}

?>