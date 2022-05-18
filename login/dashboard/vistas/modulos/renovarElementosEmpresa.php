<?php
if (!isset($_GET["elment"])) {
    
    echo '<script> window.location = "inicio" </script>';

} else {

$empresa = $_SESSION["idEmpresa_dashboard"];
$fecha = DATE("Y-m-d");

    if ($_GET["elment"] == "almacen") {
        
        /*================================================================
        =                   MOSTRAR REGISTRO DE COMPRA                   =
        ================================================================*/
    
        $item = "id_almacenes_compras";
        $valor = $_GET["id"];
        $almacen = ModeloCompras::mdlMostrarComprasAlmacenes($item, $valor, $empresa);

        if($fecha > $almacen["fecha_proximo_pago"]){

            $fecha_proxima = date("Y-m-d",strtotime($fecha."+ 1 year"));

        } else {

            $fecha_proxima = date("Y-m-d",strtotime($almacen["fecha_proximo_pago"]."+ 1 year"));

        }

        /*=================================================================
        =                   GUARDAR DATOS DE RENOVACION                   =
        =================================================================*/
        
        $tabla = "almacenes_compras";
        $datos = array("id_almacenes_compras" => $_GET["id"],
                        "fecha_ultimo_pago" => $fecha,
                        "fecha_proximo_pago" => $fecha_proxima);

        $respuesta = ModeloCompras::mdlRenovarPagoAlmacen($tabla, $datos);
        $tabla = "dashboard_registro_compras";
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                            "descripcion" => "Renovación Almacén",
                            "monto" => "928",
                            "payment_id" => $_GET["payment_id"],
                            "preference_id" => $_GET["preference_id"]
                        );

        $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

        if ($respuesta == "ok") {
            
            echo '<script> window.location = "almacenes" </script>';

        }


    } else if ($_GET["elment"] == "Vendedor Almacen" || $_GET["elment"] == "Administrador Almacen"
                || $_GET["elment"] == "Administrador General" || $_GET["elment"] == "Vendedor Matriz"
                || $_GET["elment"] == "Vendedor Externo"){

        /*================================================================
        =                   MOSTRAR REGISTRO DE COMPRA                   =
        ================================================================*/
        $item = "id_usuarios_plataforma_compras";
        $valor = $_GET["id"];
        $precio = $_GET["precio"];
        $user=$_GET["elment"];
        $vendedor = ModeloCompras::mdlMostrarComprasVendedoresAlmacen($item, $valor, $empresa);


        if($fecha > $vendedor["fecha_proximo_pago"]){

            $fecha_proxima = date("Y-m-d",strtotime($fecha."+ 1 year"));

        } else {

            $fecha_proxima = date("Y-m-d",strtotime($vendedor["fecha_proximo_pago"]."+ 1 year"));

        }

        /*=================================================================
        =                   GUARDAR DATOS DE RENOVACION                   =
        =================================================================*/

        $tabla = "usuarios_plataforma_compras";
        $datos = array("id_usuarios_plataforma_compras" => $_GET["id"],
                        "fecha_ultimo_pago" => $fecha,
                        "fecha_proximo_pago" => $fecha_proxima);

        $respuesta = ModeloCompras::mdlRenovarPagoVendedor($tabla, $datos);
        $tabla = "dashboard_registro_compras";
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                            "descripcion" => $user,
                            "monto" => $precio * 1.16,
                            "payment_id" => $_GET["payment_id"],
                            "preference_id" => $_GET["preference_id"]
                        );

        $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

        if ($respuesta == "ok") {
            
            echo '<script> window.location = "mis-compras" </script>';

        }



    } else if ($_GET["elment"] == "productos"){

        /*================================================================
        =                   MOSTRAR REGISTRO DE COMPRA                   =
        ================================================================*/
        $item = "id_tv_productos_compras";
        $valor = $_GET["serPa"];
        $precio = $_GET["precio"];
        $compra = ModeloCompras::mdlMostrarComprasProductosTV($item, $valor, $empresa);
        //var_dump($compra);
        if($fecha > $compra["fecha_proximo_pago"]){

            $fecha_proxima = date("Y-m-d",strtotime($fecha."+ 1 year"));

        } else {

            $fecha_proxima = date("Y-m-d",strtotime($compra["fecha_proximo_pago"]."+ 1 year"));

        }

        /*=================================================================
        =                   GUARDAR DATOS DE RENOVACION                   =
        =================================================================*/

        $tabla = "tv_productos_compras";
        $datos = array("id_tv_productos_compras" => $_GET["serPa"],
                        "fecha_ultimo_pago" => $fecha,
                        "fecha_proximo_pago" => $fecha_proxima);

        $respuesta = ModeloCompras::mdlRenovarPagoProductos($tabla, $datos);
        $tabla = "dashboard_registro_compras";
        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                            "descripcion" => "Renovación productos en Tienda Virtual",
                            "monto" => $precio * 1.16,
                            "payment_id" => $_GET["payment_id"],
                            "preference_id" => $_GET["preference_id"]
                        );

        $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);
        if ($respuesta == "ok") {
            
            echo '<script> window.location = "mis-compras" </script>';

        }

    }

}
?>