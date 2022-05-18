<?php

class ModeloDevoluciones{
    /*================================================
	=                  CREAR DEVOLUCION              =
	================================================*/
	
	static public function mdlCrearDevolucion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla( id_empresa, folio, id_producto, precio_unit, cantidad, monto, nota, tipo, usuario, monto_devuelto)
                                            VALUES(:id_empresa, :folio, :id_producto, :precio_unit, :cantidad, :monto, :nota, :tipo, :usuario, :montodev)");

		$stmt -> bindParam(":id_empresa", $datos["idempresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $datos["folio"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
        $stmt -> bindParam(":precio_unit", $datos["precio"], PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt -> bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
        $stmt -> bindParam(":nota", $datos["nota"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
        $stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":montodev", $datos["montodev"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of DEVOLUCION ======*/

    /*================================================
	=                   CHECAR IVA                   =
	================================================*/
	
	static public function mdliva($tabla, $empresa){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa");
        $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

        $stmt -> execute();
		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of CHECAR IVA ======*/

    /*================================================
	=            Descontar de venta detalle          =
	================================================*/
	
	static public function mdlregresarstock($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock_disponible = stock_disponible + :cantidad WHERE id_empresa = :id_empresa AND id_producto = :id_producto");
		$stmt -> bindParam(":id_empresa", $datos["idempresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);


		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of Descontar de venta detalle ======*/
	 /*=======================================================
	=                   MOSTRAR DEVOLUCION                   =
	========================================================*/
	
	static public function mdlMostrarDev($empresa, $folio, $vendedor, $fecha){
		if($vendedor == NULL){

			$stmt = Conexion::conectar()->prepare("SELECT p.codigo, p.nombre, d.cantidad, d.monto, d.nota, d.monto_devuelto 
													FROM productos as p, devoluciones as d 
													WHERE p.id_producto = d.id_producto 
													AND d.id_empresa = :id_empresa 
													AND d.folio = :folio");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":folio", $folio, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetchAll();

			$stmt -> close();
			$stmt = NULL;
		}else{
			
			$stmt = Conexion::conectar()->prepare("SELECT d.folio, p.codigo, p.nombre, d.cantidad, d.monto, d.nota, d.tipo, cv.metodo, d.monto_devuelto  
													FROM productos as p, devoluciones as d, cedis_ventas as cv 
													WHERE p.id_producto = d.id_producto 
													AND cv.folio = d.folio
													AND d.id_empresa = :id_empresa 
													AND d.fecha  LIKE :fecha
													AND d.usuario = :usuario");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
			$stmt -> bindParam(":usuario", $vendedor, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetchAll();

			$stmt -> close();
			$stmt = NULL;

		}

	}
	
	/*=====  End of MOSTRAR DEVOLUCION =========*/
	/*=======================================================
	=              Consultar Total de la venta              =
	========================================================*/
	
	static public function mdlConsultarTotalVenta($empresa, $folio){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(v.cantidad) as stockventa, (SELECT SUM(cantidad) FROM devoluciones WHERE id_producto = v.id_producto AND folio = v.folio) AS cantdev
		FROM cedis_venta_detalles v  
		INNER JOIN productos  p on p.id_producto = v.id_producto AND v.folio = :folio AND v.id_empresa = :id_empresa");
        $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
		$stmt -> bindParam(":folio", $folio, PDO::PARAM_STR);

        $stmt -> execute();
		return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*=====  End of Consultar Total de la venta =========*/
	/*=======================================================
	=                   MOSTRAR DEVOLUCION                   =
	========================================================*/
	
	static public function mdlMostrarTotalDevCorte($empresa, $folio, $vendedor, $fecha, $metodo){
					
			$stmt = Conexion::conectar()->prepare("SELECT  SUM(monto_devuelto)
													FROM devoluciones as d, cedis_ventas as cv 
													WHERE d.id_empresa = :id_empresa 
													AND cv.folio = d.folio
													AND cv.metodo = :metodo
													AND d.fecha  LIKE :fecha
													AND d.usuario = :usuario ");
			$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
			$stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
			$stmt -> bindParam(":usuario", $vendedor, PDO::PARAM_STR);
			$stmt -> bindParam(":metodo", $metodo, PDO::PARAM_STR);

			$stmt -> execute();
			return $stmt -> fetch();

			$stmt -> close();
			$stmt = NULL;

	}
	
	/*=====  End of MOSTRAR DEVOLUCION =========*/

}
?>