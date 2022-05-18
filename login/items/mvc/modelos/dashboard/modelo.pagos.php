<?php

class ModeloPagos{
	/*=========================================================================
	=                   MOSTRAR PAQUETES DE ventas a Pagos                  =
	=========================================================================*/
	
	static public function mdlMostrarPreciosEspacioPagos($item, $valor){

        if ($valor != NULL) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM creditos_precios WHERE $item = :item");
			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM creditos_precios");
			$stmt -> execute();
			return $stmt -> fetchAll();
        }

		$stmt -> close();
		$stmt = NULL;

	}
	
	/*============  End of MOSTRAR PAQUETES DE ventas a Pagos   =============*/
    	/*===================================================================================
	=                   MOSTRAR PAQUETE DE EMPRESA Pagos                   =
	===================================================================================*/
	
	static public function mdlMostrarPaquetePagos($tabla, $empresa,$paqueteadq){

        if($paqueteadq != NULL){
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa AND id_creditos_precios = :id_creditos_precios");
            $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
            $stmt -> bindParam(":id_creditos_precios", $paqueteadq, PDO::PARAM_STR);
            $stmt -> execute();

            return $stmt -> fetch();
        }else{
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa = :id_empresa ORDER BY id_creditos_compras DESC");
            $stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
            $stmt -> execute();
    
            return $stmt -> fetchAll();  
        }

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MOSTRAR PAQUETE DE EMPRESA Pagos  =============*/
    /*========================================================================================
	=                   CREAR REGISTRO DE ADQUISION DE ESPACIO DE VENTAS A PAGOS                   =
	========================================================================================*/
	
	static public function mdlCrearRegistroCompraEspacioPagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empresa, id_creditos_precios, fecha_adquirido, fecha_ultimo_pago, fecha_proximo_pago, estado) 
												VALUES(:id_empresa, :id_creditos_precios, :fecha_adquirido, :fecha_ultimo_pago, :fecha_proximo_pago, 'activo')");
		
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_creditos_precios", $datos["id_creditos_precios"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_adquirido", $datos["fecha_adquirido"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);

		if ($stmt -> execute()) {
			return 'ok';
		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of CREAR REGISTRO DE AQUISION DE ESPACIO DE VENTAS A PAGOS   =============*/
    	/*====================================================================================
	=                   MODIFICAR CONTENIDO DE EMPRESA EN Ventas Pagos                   =
	====================================================================================*/
	
	static public function mdlContenidoCompraVentasPagos($empresa, $cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE empresas_contenido_sistema SET ventas_pagos = ventas_pagos+:ventas_pagos WHERE id_empresa = :id_empresa");
		$stmt -> bindParam(":ventas_pagos", $cantidad, PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);

		if ($stmt -> execute()) {
			
			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of MODIFICAR CONTENIDO DE EMPRESA EN Ventas Pagos    =============*/
    /*============================================================================================
	=                   EDITAR REGISTRO DE ADQUISICION DE ESPACIO DE VENTAS A PAGOS                   =
	============================================================================================*/
	
	static public function mdlEditarRegistroCompraEspacioPpagos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_ultimo_pago = :fecha_ultimo_pago, 
																fecha_proximo_pago = :fecha_proximo_pago,
                                                                estado = 'activo'
														WHERE id_empresa = :id_empresa AND id_creditos_precios =:id_creditos_precios ");
		
		
		$stmt -> bindParam(":fecha_ultimo_pago", $datos["fecha_ultimo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_proximo_pago", $datos["fecha_proximo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $stmt -> bindParam(":id_creditos_precios", $datos["id_creditos_precios"], PDO::PARAM_STR);

		if ($stmt -> execute()) {

			return 'ok';

		}

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*============  End of EDITAR REGISTRO DE ADQUISICION DE VENTAS A PAGOS   =============*/

}
?>