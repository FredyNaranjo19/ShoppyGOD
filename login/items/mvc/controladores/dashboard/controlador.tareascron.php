<?php

class ControladorPcron{

	/*========================================================
	=            CHECAR COMPRAS VENCIDAS y activas            =
	==========================================================*/
	
	static public function ctrlpcron($fecha_ayer){

		$respuesta = ModeloPCron::mdlpcron($fecha_ayer);

		return $respuesta; 
	}
	
	/*=====  End of CHECAR COMPRAS VENCIDAS  ======*/
    /*==============================================
	=            CHECAR COMPRAS VENCIDAS            =
	================================================*/
	
	static public function ctrlcostopaquetepagos($idcreditosp){

		$respuesta = ModeloPCron::mdlcostopaquetepagos($idcreditosp);

		return $respuesta; 
	}
	
	/*=====  End of CHECAR COMPRAS VENCIDAS  ======*/
        /*=============================================================================
	=            RESTAR ESPACIOS VENTAS A PAGOS DEL CONTENIDO DE LA EMPRESA            =
	===================================================================================*/
	
	static public function ctrleditarcontenidosistemaventaspagos($idempresa,$cantidad){

		$respuesta = ModeloPCron::mdleditarcontenidosistemaventaspagos($idempresa,$cantidad);

		return $respuesta; 
	}
	
	/*=====  End of RESTAR ESPACIOS VENTAS A PAGOS DEL CONTENIDO DE LA EMPRESA  ======*/
    	/*========================================================
	=            Desactivar paquete ventas a pagos             =
	==========================================================*/
	
	static public function ctrldesactiv($id_creditos_compras){

		$respuesta = ModeloPCron::mdldesactiv($id_creditos_compras);

		return $respuesta; 
	}
	
	/*=====  End of Desactivar paquete ventas a pagos   ======*/
	/*========================================================
	=            CHECAR ALMACENES VENCIDOS y activas            =
	==========================================================*/
	
	static public function ctrlpcronalmacenes($fecha_ayer){

		$respuesta = ModeloPCron::mdlpcronalmacenes($fecha_ayer);

		return $respuesta; 
	}
	
	/*=====  End of CHECAR ALMACENES VENCIDOS  ======*/
		/*========================================================
	=                    Desactivar Almacen                      =
	==========================================================*/
	
	static public function ctrldesactivalmacen($id_almacen_compras){

		$respuesta = ModeloPCron::mdldesactivalmacen($id_almacen_compras);

		return $respuesta; 
	}
	
	/*=====  End of Desactivar  Almacen   ======*/

	/*========================================================
	=            CHECAR USUARIOS VENCIDOS y activos            =
	==========================================================*/
	
	static public function ctrlpcronusuarios($fecha_ayer){

		$respuesta = ModeloPCron::mdlpcronusuarios($fecha_ayer);

		return $respuesta; 
	}
	
	/*=====  End of CHECAR USUARIOS VENCIDOS y activos   ======*/

	/*========================================================
	=                   Desactivar Usuarios                  =
	==========================================================*/
	
	static public function ctrldesactivusuario($id_usuarios_plataforma_compras){

		$respuesta = ModeloPCron::mdldesactivusuarios($id_usuarios_plataforma_compras);

		return $respuesta; 
	}
	
	/*=====         End of Desactivar Usuarios          ======*/
	/*========================================================
	=            CHECAR COMPRAS TV VENCIDAS y activas            =
	==========================================================*/
	
	static public function ctrlmostrarespaciosTV($fecha_ayer){

		$respuesta = ModeloPCron::mdlmostrarespaciosTV($fecha_ayer);

		return $respuesta; 
	}
	
	/*=====  End of CHECAR COMPRAS TV VENCIDAS  ======*/
	/*==============================================
	=            CHECAR COMPRAS VENCIDAS            =
	================================================*/
	
	static public function ctrlcostopaqueteTV($idtvproductp){

		$respuesta = ModeloPCron::mdlcostopaquetetv($idtvproductp);

		return $respuesta; 
	}
	
	/*=====  End of CHECAR COMPRAS VENCIDAS  ======*/
    /*=============================================================================
	=            RESTAR ESPACIOS PRODUCTOS TV DEL CONTENIDO DE LA EMPRESA       =
	==============================================================================*/
	
	static public function ctrleditarcontenidosistemaproductostv($idempresa,$cantidad){

		$respuesta = ModeloPCron::mdleditarcontenidosistemaproductostv($idempresa,$cantidad);

		return $respuesta; 
	}
	
	/*=====  End of RESTAR ESPACIOS PRODUCTOS TV DEL CONTENIDO DE LA EMPRESA  ======*/
	/*========================================================
	=            Desactivar paquete productos TV             =
	==========================================================*/
	
	static public function ctrldesactivproductostv($id_tv_productos_compras){

		$respuesta = ModeloPCron::mdldesactivproductostv($id_tv_productos_compras);

		return $respuesta; 
	}
	
	/*=====  End of Desactivar paquete productos TV    ======*/
}
?>