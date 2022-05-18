<?php

class ControladorPedidos{ 


//***********************************************************************************************************
//***********************************************************************************************************
//***********************************************************************************************************
	
	/*===============================================================
	=            MOSTRAR PEDIDOS CON TODA SU INFORMACION            =
	===============================================================*/
	
	static public function ctrMostrarPedidosEstados($datos){ //ocupo

		$respuesta = ModeloPedidos::mdlMostrarPedidosEstados($datos);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR PEDIDOS CON TODA SU INFORMACION  ======*/

	/*=============================================================================
	=            MOSTRAR PEDIDOS PENDIENTES (METODO DE PAGO: EFECTIVO)            =
	=============================================================================*/
	
	static public function ctrMostrarPedidosPendientesEfectivo($datos){ // ocupo

		$tabla = "tv_pedidos";

		$respuesta = ModeloPedidos::mdlMostrarPedidosPendientesEfectivo($tabla, $datos);

		return $respuesta;
		 
	}
	
	/*=====  End of MOSTRAR PEDIDOS PENDIENTES (METODO DE PAGO: EFECTIVO)  ======*/

	/*=================================================================
	=            CAMBIO DE ESTADO SECCION DE GENERAR GUIAS            =
	=================================================================*/
	
	static public function ctrModificarEstadoGuias(){

		if (isset($_POST["nNoRastreo"])) {
			
			$tabla = "tv_pedidos_entregas";
			$datos = array("folio" => $_POST["folioPedidoGuia"],
							"paqueteria" => $_POST["nPaqueteriaEnvio"],
							"rastreo" => $_POST["nNoRastreo"],
							"estado_entrega" => "Enviado",
							"id_empresa" => $_SESSION["idEmpresa_dashboard"]);

			$respuesta = ModeloPedidos::mdlModificarEstadoGuias($tabla, $datos);

			if ($respuesta == "ok") {
				echo "<script> 
						window.location='tienda-pedidos-guias'; 
					</script>";
			}
			// window.open('https://api.whatsapp.com/send?phone='+tel+'&text="+mensaje);
		}
	}
	
	/*=====  End of CAMBIO DE ESTADO SECCION DE GENERAR GUIAS  ======*/
	
	/*===============================================================
	=            MOSTRAR TODOS LOS PEDIDOS DE LA EMPRESA            =
	===============================================================*/
	
	static public function ctrMostrarPedidosFinalizados($item, $valor){

		$respuesta = ModeloPedidos::mdlMostrarPedidosFinalizados($item, $valor);

		return $respuesta;
	} 
	
	/*=====  End of MOSTRAR TODOS LOS PEDIDOS DE LA EMPRESA  ======*/
	

//***********************************************************************************************************
//***********************************************************************************************************
//***********************************************************************************************************

	/*==========================================================================
	=            MOSTRAR TODOS LOS PEDIDOS CANCELADOS DE LA EMPRESA            =
	==========================================================================*/
	
	static public function ctrMostrarPedidosCancelados($item, $valor){

		$respuesta = ModeloPedidos::mdlMostrarPedidosCancelados($item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR TODOS LOS PEDIDOS CANCELADOS DE LA EMPRESA  ======*/


//***********************************************************************************************************
//***********************************************************************************************************
//***********************************************************************************************************
	
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------
	//  -------------------- CONTROLADORES DE MODULO DE FACTURACION ------------------
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------

		/*============================================================
		=            MOSTRAR PEDIDOS DEL MES SIN FACTURAR            =
		============================================================*/
		
		static public function ctrMostrarPedidosSinFacturar($item, $valor){ //ocupo

			$tabla = "tv_pedidos";
			$empresa = $_SESSION["idEmpresa_dashboard"];

			$respuesta = ModeloPedidos::mdlMostrarPedidosSinFacturar($tabla, $item, $valor, $empresa);

			return $respuesta;

		}
		
		/*=====  End of MOSTRAR PEDIDOS DEL MES SIN FACTURAR  ======*/
}

?>