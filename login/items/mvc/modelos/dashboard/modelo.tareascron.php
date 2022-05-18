<?php
require_once 'items/mvc/modelos/conexion.php';
class ModeloPCron{
	/*====================================================================
	=            MOSTRAR LISTA DE PAQUETES VENCIDOS y activas            =
	=====================================================================*/
	
	static public function mdlpcron($fecha_ayer){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM creditos_compras WHERE fecha_proximo_pago <= :fecha AND estado='activo'");
        $stmt -> bindParam(":fecha", $fecha_ayer, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  MOSTRAR LISTA DE PAQUETES VENCIDOS  ======*/
    /*==========================================
	=            Ver precio paquete pagos contratado =
	==========================================*/
	
	static public function mdlcostopaquetepagos($idcreditosp){

		$stmt = Conexion::conectar()->prepare("SELECT cantidad FROM creditos_precios WHERE id_creditos_precios = :id_creditos_precios");
        $stmt -> bindParam(":id_creditos_precios", $idcreditosp, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Ver precio paquete pagos contratado  ======*/
        /*==========================================
	=            Ver precio paquete pagos contratado =
	==========================================*/
	
	static public function mdleditarcontenidosistemaventaspagos($idempresa,$cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE empresas_contenido_sistema SET ventas_pagos=ventas_pagos-:cantidad WHERE id_empresa=:id_empresa");
        $stmt -> bindParam(":id_empresa", $idempresa, PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Ver precio paquete pagos contratado  ======*/
    	/*====================================================================
	=            Desactivar paquete ventas a pagos            =
	=====================================================================*/
	
	static public function mdldesactiv($id_creditos_compras){

		$stmt = Conexion::conectar()->prepare("UPDATE creditos_compras SET estado='desactivado'  WHERE id_creditos_compras = :id_creditos_compras");
        $stmt -> bindParam(":id_creditos_compras", $id_creditos_compras, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  Desactivar paquete ventas a pagos   ======*/
	/*====================================================================
	=            MOSTRAR LISTA DE ALMACENES VENCIDOS y activos            =
	=====================================================================*/
	
	static public function mdlpcronalmacenes($fecha_ayer){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM almacenes_compras WHERE fecha_proximo_pago <= :fecha AND estado='activo'");
        $stmt -> bindParam(":fecha", $fecha_ayer, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  MOSTRAR LISTA DE ALMACENES VENCIDOS  ======*/
	/*==========================================
	=            Desactivar ALMACEN            =
	==========================================*/
	
	static public function mdldesactivalmacen($id_creditos_compras){

		$stmt = Conexion::conectar()->prepare("UPDATE almacenes_compras SET estado = 'desactivado'  WHERE id_almacenes_compras = :id_almacenes_compras");
        $stmt -> bindParam(":id_almacenes_compras", $id_creditos_compras, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  Desactivar ALMACEN   ======*/

		/*====================================================================
	=            MOSTRAR LISTA DE USUARIOS VENCIDOS y activos            =
	=====================================================================*/
	
	static public function mdlpcronusuarios($fecha_ayer){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM usuarios_plataforma_compras WHERE fecha_proximo_pago <= :fecha AND estado='activo'");
        $stmt -> bindParam(":fecha", $fecha_ayer, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  MOSTRAR LISTA DE USUARIOS VENCIDOS  ======*/
	
	/*==========================================
	=            Desactivar USUARIOS            =
	==========================================*/
	
	static public function mdldesactivusuarios($id_usuarios_plataforma_compras){

		$stmt = Conexion::conectar()->prepare("UPDATE usuarios_plataforma_compras SET estado = 'desactivado'  WHERE id_usuarios_plataforma_compras = :id_usuarios_plataforma_compras");
        $stmt -> bindParam(":id_usuarios_plataforma_compras", $id_usuarios_plataforma_compras, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  Desactivar USUARIOS   ======*/
	/*====================================================================
	=   MOSTRAR LISTA DE ESPACIOS TIENDA VIRTUAL VENCIDOS y activas      =
	=====================================================================*/
	
	static public function mdlmostrarespaciosTV($fecha_ayer){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM tv_productos_compras WHERE fecha_proximo_pago <= :fecha AND estado='activo'");
        $stmt -> bindParam(":fecha", $fecha_ayer, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  MOSTRAR LISTA DE PAQUETES VENCIDOS  ======*/
    /*==========================================
	=    Ver precio paquete TV contratado =
	==========================================*/
	
	static public function mdlcostopaqueteTV($idtvproductp){

		$stmt = Conexion::conectar()->prepare("SELECT cantidad FROM tv_productos_espacios_precios WHERE id_tv_productos_espacios_precios = :id_tv_productos_espacios_precios");
        $stmt -> bindParam(":id_tv_productos_espacios_precios", $idtvproductp, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Ver precio paquete TV contratado  ======*/
	/*==========================================
	=            Ver precio paquete productos tv contratado =
	==========================================*/
	
	static public function mdleditarcontenidosistemaproductostv($idempresa,$cantidad){

		$stmt = Conexion::conectar()->prepare("UPDATE empresas_contenido_sistema SET productos_tv = productos_tv - :cantidad WHERE id_empresa=:id_empresa");
        $stmt -> bindParam(":id_empresa", $idempresa, PDO::PARAM_STR);
        $stmt -> bindParam(":cantidad", $cantidad, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetch();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  End of Ver precio productos tv contratado  ======*/
/*====================================================================
	=            Desactivar paquete productos TV            =
	=====================================================================*/
	
	static public function mdldesactivproductostv($id_tv_productos_compras){

		$stmt = Conexion::conectar()->prepare("UPDATE tv_productos_compras SET estado = 'desactivado'  WHERE id_tv_productos_compras = :id_tv_productos_compras");
        $stmt -> bindParam(":id_tv_productos_compras", $id_tv_productos_compras, PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = NULL;
	}
	
	/*=====  Desactivar paquete productos TV   ======*/
}

?>