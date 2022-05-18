<?php

session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.devoluciones.php';
require_once '../../modelos/dashboard/modelo.ventasCedis.php';

class AjaxDevolucion{
    /*========================================
    =           CREAR DEVOLUCION            =
    ========================================*/
    public $idempresa;
    public $folio;
    public $idproduto;
    public $precio;
    public $cantidadProducto;
    public $monto;
    public $montodev;
    public $nota;
    public $metodo;
    public $tipo;
    public $idusuario;

	public function ajaxCrearDevolucion(){
        $datos = array("idempresa" => $this -> idempresa,	
                        "folio" => $this -> folio,
                        "id_producto" => $this -> idproduto,
                        "precio" => $this -> precio,
                        "cantidad" => $this -> cantidadProducto,
                        "monto" => $this -> monto,
                        "montodev" => $this -> montodev,
                        "nota" => $this -> nota,
                        "metodo" => $this -> metodo,
                        "tipo" => $this -> tipo,
                        "usuario" => $this -> idusuario);
        $tabla = "devoluciones";
        $empresa=$_SESSION["idEmpresa_dashboard"];
        $folio = $this -> folio;

        $respuestadev = ModeloDevoluciones::mdlCrearDevolucion($tabla, $datos);
        $checarventa = ModeloDevoluciones::mdlConsultarTotalVenta($empresa, $folio);
        if($checarventa["stockventa"] == $checarventa["cantdev"]){
            //------------------Cambiar estado de la venta a cancelada
            $tabla = "cedis_ventas";
		    $datos2 = array("id_empresa" => $_SESSION["idEmpresa_dashboard"], 
						"folio" => $this -> folio,
						"notaCancelacion" =>"Cancelación por devolucion",
						"estado" => "Cancelada");
            $cancel = ModeloVentasCedis::mdlVentaCancelarpordevolucion($tabla, $datos2);
        }
        // --------------------Registrar pago negativo por devolucion y saldar deuda
        $metodoventa = $this -> metodo;
        $montodevpagos = $this -> montodev;
        if($metodoventa == "Pagos"  AND $montodevpagos > 0){
            $tabla = "cedis_ventas_pagos";
            $datos3 = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                    "id_usuario_plataforma" => $_SESSION["id_dashboard"],
                    "folio" => $this -> folio,
                    "monto" => -$montodevpagos,
                    "estado" => "pagado",
                    "comprobante" => "");

            ModeloVentasCedis::mdlRealizarPago($tabla, $datos3);
            //if($checarventa["stockventa"] == $checarventa["cantdev"]){
                $tabla ="cedis_ventas";
                ModeloVentasCedis::mdlActualizarEstadoPagoVenta($tabla, $folio, $empresa);
            //}
        }

        
        if($datos["tipo"] == "Devolucion"){
            $tabla = "productos";
            $respuestadev = ModeloDevoluciones::mdlregresarstock($tabla, $datos);
        }

        
        echo json_encode($respuestadev);
    }
    /*=====  End of CREAR DEVOLUCION  ======*/
    /*========================================
    =                CHECAR IVA              =
    ========================================*/
	public function ajaxIVA(){
        $tabla = "configuracion_ventas";
        $empresa = $_SESSION["idEmpresa_dashboard"];
        $respuestaiva = ModeloDevoluciones::mdlIVA($tabla, $empresa); 
        
        echo json_encode($respuestaiva);
    }
    /*=====  End of CHECAR IVA  ======*/
    /*===================================================
    =                MOSTRAR DEVOLUCIONES               =
    ===================================================*/
	public $foliodev;
    public function ajaxmostrarDev(){
        $folio = $this -> foliodev;
        $empresa = $_SESSION["idEmpresa_dashboard"];
        $vendedor = NULL;
        $fecha = NULL;
        $respuestaiva = ModeloDevoluciones::mdlMostrarDev($empresa, $folio, $vendedor, $fecha); 
        
        echo json_encode($respuestaiva);
    }
    /*=====  End of MOSTRAR DEVOLUCIONES  ======*/

    
}
/*========================================
=           CREAR DEVOLUCION            =
========================================*/
if (isset($_POST["creardevolucion"])){
    $crearDevolucion = new AjaxDevolucion();
	$crearDevolucion -> idempresa = $_POST["idempresa"];
    $crearDevolucion -> folio = $_POST["folio"];
    $crearDevolucion -> idproduto = $_POST["idproduto"];
    $crearDevolucion -> precio = $_POST["precio"];
    $crearDevolucion -> cantidadProducto = $_POST["cantidadProducto"];
    $crearDevolucion -> monto = $_POST["monto"];
    $crearDevolucion -> montodev = $_POST["montodev"];
    $crearDevolucion -> nota = $_POST["nota"];
    $crearDevolucion -> metodo = $_POST["metodo"];
    $crearDevolucion -> tipo = $_POST["tipo"];
    $crearDevolucion -> idusuario = $_POST["idusuario"];
	$crearDevolucion -> ajaxCrearDevolucion();
}
/*=====  End of CREAR DEVOLUCION  ======*/
// if (isset($_POST['defectuoso'])){
//     /* Aqui harias el insert */
//     var_dump("defectuoso");
// }

/*========================================
=                 CHECAR IVA             =
========================================*/
if (isset($_POST["checariva"])){
    $crearDevolucion = new AjaxDevolucion();
	$crearDevolucion -> ajaxIVA();
}
/*=====  End of CHECAR IVA  ======*/

/*==================================================
=                 MOSTRAR DEVOLUCIONES             =
===================================================*/
if (isset($_POST["folioVentadev"])){
    $crearDevolucion = new AjaxDevolucion();
    $crearDevolucion -> foliodev = $_POST["folioVentadev"];
	$crearDevolucion -> ajaxmostrarDev();
}
/*=====  End of MOSTRAR DEVOLUCIONES  ======*/

?>