<?php

class ControladorVentas{

	/*======================================
	=            MOSTRAR VENTAS            =
	======================================*/
	
	static public function ctrMostrarVentas($item, $valor){

		$tabla = "ventas";
		$almacen = $_SESSION["almacen_dashboard"];

		$respuestas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor, $almacen);

		return $respuestas; 
	}
	
	/*=====  End of MOSTRAR VENTAS  ======*/

	/*===========================================================================
	=            MOSTRAR TODAS LAS VENTAS DEL VENDEDOR DE LA EMPRESA            =
	===========================================================================*/
	
	static public function ctrMostrarVentasVendedor($datos){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlMostrarVentasVendedor($tabla, $datos);

		return $respuesta;
 
	}
	
	/*=====  End of MOSTRAR TODAS LAS VENTAS DEL VENDEDOR DE LA EMPRESA  ======*/

	/*===================================================
	=            MOSTRAR VENTAS SIN FACTURAR            =
	===================================================*/
	
	static public function ctrMostrarVentasSinFacturar($item, $valor){

		$tabla = "ventas";
		$almacen = $_SESSION["almacen_dashboard"];

		$respuesta = ModeloVentas::ctrMostrarVentasSinFacturar($tabla, $item, $valor, $almacen);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR VENTAS SIN FACTURAR  ======*/
	

	/*====================================================
	=            MOSTRAR MONTO TOTAL  DEL DIA            =
	====================================================*/
	
	static public function ctrCorteDia($datos){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlCorteDia($tabla, $datos);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR MONTO TOTAL DEL DIA  ======*/

	/*=================================================================
	=                   MOSTRAR PAGOS EN VENTAS DIA                   =
	=================================================================*/
	
	static public function ctrMostrarVentasPagosCorteDia($datos){
		$respuesta = ModeloVentas::mdlMostrarVentasPagosCorteDia($datos);

		return $respuesta;
	}
	
	
	/*============  End of MOSTRAR PAGOS EN VENTAS DIA  =============*/

//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//**************************************   C O R T E S   **************************************

	/*==============================================
	=            MOSTRAR CORTE DE CAJA            =
	==============================================*/
	
	static public function ctrMostrarCorte($item, $valor, $item2, $valor2){

		$tabla = "ventas_cortes";
		$rol = $_SESSION["rol_dashboard"];

		$respuesta = ModeloVentas::mdlMostrarCorte($tabla, $item, $valor, $item2, $valor2, $rol);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR CORTES DE CAJA  ======*/

	/*================================================
	=            MOSTRAR CORTES DE UN MES            =
	================================================*/
	
	static public function ctrMostrarCortesCaja($datos){

		$tabla = "ventas_cortes";

		$respuesta = ModeloVentas::mdlMostrarCortesCaja($tabla, $datos);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR CORTES DE UN MES  ======*/

	/*============================================================
	=                   MOSTRAR CORTES DEL DIA                   =
	============================================================*/
	static public function ctrMostrarCortesVentasDia($datos){
        $tabla = "ventas_cortes";

        $respuesta = ModeloVentas::mdlMostrarCortesVentasDia($tabla, $datos);

        return $respuesta;
    }
	
	
	/*============  End of MOSTRAR CORTES DEL DIA  =============*/


//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*********************************************************************************************
//*************************** V E N T A S ***** P A G O S   ***********************************

	/*==============================================
	=            INGRESAR PAGO DE VENTA            =
	==============================================*/
		
	static public function ctrCrearPago(){

        if (isset($_POST["inputPagosMonto"])) {
           
            if(preg_match('/^[0-9]+$/',$_POST["inputPagosMonto"]) && $_POST["selectTipoPago"] != ""){
                $tabla = "ventas_pagos";

                $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                            "id_usuario_plataforma" => $_SESSION["id_dashboard"],
                            "monto" => $_POST["inputPagosMonto"],
                            "estado" => $_POST["selectTipoPago"],
                            "comprobante" => $_POST["inputUrlPagoFotoComprobante"],
                );

                $respuesta = ModeloVentas::mdlHacerPago($tabla,$datos);

                if ($respuesta == "ok") {
                    // echo "<script>alert('ok')</script>";
                    // echo "<script>
                    //     //alert('Registro exitoso!');
                        
                    // </script>";
                }
            }else{
                echo "<script>
                    alert('Revisa los datos');
                    window.location = 'ventas-pagos';
                </script>";
            }

            
        }
    }	
		
	/*=====  End of INGRESAR PAGO DE VENTA  ======*/
	
	/*=====================================
	=            MOSTRAR PAGOS            =
	=====================================*/
	
	static public function ctrMostrarPagos($datos){
        $tabla = "ventas_pagos";
		$almacen = $_SESSION["almacen_dashboard"];

		$respuestas = ModeloVentas::mdlMostrarPagos($tabla, $datos, $almacen);

		return $respuestas; 
    }
	
	/*=====  End of MOSTRAR PAGOS  ======*/

	/*===========================================
	=            FILTRO MOSTRAR PAGO            =
	===========================================*/
	
	static public function ctrMostrarPagosHistorial($item, $valor1, $busqueda, $valor2){
        $tabla = "ventas_pagos";

        $respuesta = ModeloVentas::mdlFiltrarPago($tabla,$item,$valor1,$busqueda,$valor2);

        return $respuesta;
    }
	
	/*=====  End of FILTRO MOSTRAR PAGO  ======*/
	
	
}

?>