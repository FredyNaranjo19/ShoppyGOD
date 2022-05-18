<?php
if (!isset($_GET["elment"])) {
    
    echo '<script> window.location = "inicio" </script>';

} else {


    if($_GET["elment"] == "almacen"){

        /*=========================================================
        =                   CREAR ALMACEN VACIO                   =
        =========================================================*/
        
        $tabla = "almacenes";

        $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "nombre" => "Nombre almacen",
                        "direccion" => "Direción almacen",
                        "telefono" => "(000) 000 0000");

        $respuesta = ModeloAlmacenes::mdlCrearAlmacen($tabla, $datos);

        if ($respuesta == "ok") {
            
            /*===================================================================
            =                   MOSTRAR ULTIMO ALMACEN CREADO                   =
            ===================================================================*/
            
            $item = NULL;
            $valor = NULL;
            $empresa = $_SESSION["idEmpresa_dashboard"];

            $mostrar =  ModeloAlmacenes::mdlMostrarAlmacenes($tabla, $item, $valor, $empresa);

            foreach ($mostrar as $key => $value) {
                $almacenId = $value["id_almacen"];
            }

            /*========================================================================================
            =                   GUARDAR FECHAS DE ADQUISICION Y PROXIMO DE ALMACEN                   =
            ========================================================================================*/
            
            
            $adquirido = date('Y-m-d');
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));

            $tabla = "almacenes_compras";
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                            "id_almacen" => $almacenId,
                            "fecha_adquirido" => $adquirido,
                            "fecha_ultimo_pago" => $adquirido,
                            "fecha_proximo_pago" => $proximo_pago,
                            "estado" => "activo"
                        );
            
            $respuesta = ModeloAlmacenes::mdlCrearRegistroCompraAlmacen($tabla, $datos);

            /*================================================================
            =                   GUARDAR CONTENIDO CONTRADO                   =
            ================================================================*/

            $empresa = $_SESSION["idEmpresa_dashboard"];
            $contenido = ModeloCompras::mdlContenidoCompraAlmacen($empresa);

            if ($contenido == "ok") {

                /*================================================================
                =                   GUARDAR REGISTRO DE COMPRA                   =
                ================================================================*/

                $tabla = "dashboard_registro_compras";
                $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                                    "descripcion" => "Compra Almacén",
                                    "monto" => "928",
                                    "payment_id" => $_GET["payment_id"],
                                    "preference_id" => $_GET["preference_id"]
                                );

                $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

                echo '<script> window.location = "index.php?ruta=proporcionar-datos&&tip=Almacen&&al='.$almacenId.'"</script>';

            }
            
            /*================================================================
            =  GUARDAR USUARIOS 1 ADMIN ALMACEN Y 1 VENDEDOR ALMACEN         =
            ================================================================*/
            // //=============Consultar el ID del Almacen creado=============\\
            // $tabla = "almacenes";
            // $empresa = $_SESSION["idEmpresa_dashboard"];
            // $item=NULL;
            // $valor=NULL;

            // $almacen = ModeloAlmacenes::mdlUltimoAlmacenes($tabla, $empresa);
                            /*========================
                            =      Administrador      =
                            =========================*/
        $rol= "Administrador Almacen ";
        $prec= 0;
        $tabla = "usuarios_plataforma";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"nombre" => "Nombre del Administrador del almacen",
						"email" => "Correo de acceso",
						"password" => NULL,
						"telefono" => "(000) 000 0000",
						"almacen" => $almacenId,
                        "estado"=>1,
						"rol" => $rol);
        
        $respuesta = ModelosUsuarios::mdlCrearUsuarioPlataforma($tabla, $datos);
                            /*========================
                            =    Vendedor Almacen     =
                            =========================*/
        $rol= "Vendedor Almacen ";
        $prec= 0;
        $tabla = "usuarios_plataforma";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"nombre" => "Nombre del Vendedor Almacen",
						"email" => "Correo de acceso",
						"password" => NULL,
						"telefono" => "(000) 000 0000",
						"almacen" => $almacenId,
                        "estado"=>1,
						"rol" => $rol);
        
        $respuesta = ModelosUsuarios::mdlCrearUsuarioPlataforma($tabla, $datos);

        }



    } else if($_GET["elment"] == "usuario"){


        /*====================================================
        =                   CREAR USUARIO                   =
        ====================================================*/
        $rol= $_GET["serPa"];
        $prec= $_GET["prec"];
        $tabla = "usuarios_plataforma";
		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"nombre" => NULL,
						"email" => NULL,
						"password" => NULL,
						"telefono" => NULL,
						"almacen" => NULL,
                        "estado"=>1,
						"rol" => $rol);
        
        $respuesta = ModelosUsuarios::mdlCrearUsuarioPlataforma($tabla, $datos);

        if ($respuesta == 'ok') {

            /*=================================================================================
            =                   MOSTRAR ULTIMO USUARIO CREADO DE LA EMPRESA                   =
            =================================================================================*/
            $tabla = "usuarios_plataforma";
            $item = NULL;
            $valor = NULL;
            $empresa = $_SESSION["idEmpresa_dashboard"];
            $usuarios = ModelosUsuarios::MdlMostrarUsuarios($tabla, $item, $valor, $empresa);

            foreach ($usuarios as $key => $value) {
                $usuarioId = $value["id_usuario_plataforma"];
            }

            /*=========================================================================================
            =                   GUARDAR FECHAS DE ADQUISICION Y PROXIMO DE VENDEDOR                   =
            =========================================================================================*/
        
            $adquirido = date('Y-m-d');
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));

            $tabla = "usuarios_plataforma_compras";
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                            "id_usuario_plataforma" => $usuarioId,
                            "fecha_adquirido" => $adquirido,
                            "fecha_ultimo_pago" => $adquirido,
                            "fecha_proximo_pago" => $proximo_pago,
                            "tipo_usuario" => $rol,
                            "estado" => "activo"
                        );

            $respuesta = ModelosUsuarios::mdlCrearRegistroCompraVendedor($tabla, $datos);

            /*================================================================
            =                   GUARDAR CONTENIDO CONTRADO                   =
            ================================================================*/
            
            // $empresa = $_SESSION["idEmpresa_dashboard"];
            // $contenido = ModeloCompras::mdlContenidoCompraVendedorAlmacen($empresa);

            // if ($contenido == "ok") {

                /*================================================================
                =                   GUARDAR REGISTRO DE COMPRA                   =
                ================================================================*/
                
                $tabla = "dashboard_registro_compras";
                $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                                    "descripcion" => $rol,
                                    "monto" => $prec,
                                    "payment_id" => $_GET["payment_id"],
                                    "preference_id" => $_GET["preference_id"]
                                );

                $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

                echo '<script> window.location = "index.php?ruta=proporcionar-datos&&tip='.$rol.'&&ven='.$usuarioId.'"</script>';

            //}

        }

      
        
    
    } else if ($_GET["elment"] == "productos") {
        
        /* MOSTRAR EXISTENCIA DE PAQUETE EN LA EMPRESA */
        $tabla = "tv_productos_compras";
		$empresa = $_SESSION["idEmpresa_dashboard"];
        $paqueteadq= $_GET["serPa"];
		$existenciaPaquete = ModeloProductosTienda::mdlMostrarPaqueteEmpresa($tabla, $empresa, $paqueteadq);
        if ($existenciaPaquete == false) {
            
            /* GUARDAR REGISTRO DE ADQUISICION Y PROXIMO PAGO DE LOS PRODUCTOS */
            $tabla = "tv_productos_compras";
            $adquirido = date('Y-m-d');
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));
            
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_tv_productos_lista_compras" => $_GET["serPa"],
                        "fecha_adquirido" => $adquirido,
                        "fecha_ultimo_pago" => $adquirido,
                        "fecha_proximo_pago" => $proximo_pago,
                        "estado" => "activo");
            
            $respuesta = ModeloProductosTienda::mdlCrearRegistroCompraEspacioProductos($tabla, $datos);

        } else {
            /* GUARDAR REGISTRO DE ADQUISICION Y PROXIMO PAGO DE LOS PRODUCTOS */
            $tabla = "tv_productos_compras";
            $adquirido = date('Y-m-d');
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));
            
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_tv_productos_lista_compras" => $_GET["serPa"],
                        "fecha_adquirido" => $adquirido,
                        "fecha_ultimo_pago" => $adquirido,
                        "fecha_proximo_pago" => $proximo_pago,
                        "estado" => "activo");
            
            $respuesta = ModeloProductosTienda::mdlEditarRegistroCompraEspacioProductos($tabla, $datos);

        }

        /* MOSTRAR CANTIDAD DE PAQUETE */
        $item = "id_tv_productos_espacios_precios";
        $valor = $_GET["serPa"];
        $Precios = ModeloProductosTienda::mdlMostrarPreciosEspacioProducto($item, $valor);

        
        /* GUARDAR CONTENIDO CONTRADO */
        $empresa = $_SESSION["idEmpresa_dashboard"];
        $cantidad = $Precios["cantidad"];
        $contenido = ModeloProductosTienda::mdlContenidoCompraProductosTV($empresa, $cantidad);

        if ($contenido == "ok") {

            /* GUARDAR REGISTRO DE COMPRA */
            $tabla = "dashboard_registro_compras";
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                                "descripcion" => "Espacios de ".$Precios["cantidad"]." Productos en TV",
                                "monto" => $Precios["precio"] * 1.16,
                                "payment_id" => $_GET["payment_id"],
                                "preference_id" => $_GET["preference_id"]);

            $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

            echo '<script> window.location = "mis-compras" </script>';

        }

    }else if ($_GET["elment"] == "espacios") {
        
        /* MOSTRAR EXISTENCIA DE PAQUETE EN LA EMPRESA */
        $tabla = "creditos_compras";
		$empresa = $_SESSION["idEmpresa_dashboard"];
        $paqueteadq= $_GET["serPa"];

		$existenciaPaquete = ModeloPagos::mdlMostrarPaquetePagos($tabla, $empresa,$paqueteadq);
        
        if ($existenciaPaquete == false) {
            echo "<script>console.log('no existe')</script>";
            /* GUARDAR REGISTRO DE ADQUISICION Y PROXIMO PAGO DE LOS PRODUCTOS */
            $tabla = "creditos_compras";
            $adquirido = date('Y-m-d');
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));
            
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_creditos_precios" => $_GET["serPa"],
                        "fecha_adquirido" => $adquirido,
                        "fecha_ultimo_pago" => $adquirido,
                        "fecha_proximo_pago" => $proximo_pago);
            
            $respuesta = ModeloPagos::mdlCrearRegistroCompraEspacioPagos($tabla, $datos);

        } else {//echo "<script>console.log('si existe')</script>";

            /* GUARDAR REGISTRO DE ADQUISICION Y PROXIMO PAGO DE LOS PRODUCTOS */
  
            $tabla = "creditos_compras";
            $adquirido = date('Y-m-d');
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));
            
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_creditos_precios" => $_GET["serPa"],
                        "fecha_adquirido" => $adquirido,
                        "fecha_ultimo_pago" => $adquirido,
                        "fecha_proximo_pago" => $proximo_pago);
            $respuesta = ModeloPagos::mdlEditarRegistroCompraEspacioPpagos($tabla, $datos);

        }

        /* MOSTRAR CANTIDAD DE PAQUETE */
        $item = "id_creditos_precios";
        $valor = $_GET["serPa"];
        $Precios = ModeloPagos::mdlMostrarPreciosEspacioPagos($item, $valor);

        
        /* GUARDAR CONTENIDO CONTRADO */
        $empresa = $_SESSION["idEmpresa_dashboard"];
        $cantidad = $Precios["cantidad"];
        $contenido = ModeloPagos::mdlContenidoCompraVentasPagos($empresa, $cantidad);

        if ($contenido == "ok") {

            /* GUARDAR REGISTRO DE COMPRA */
            $tabla = "dashboard_registro_compras";
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                                "descripcion" => $Precios["cantidad"]." Manejos de ventas a pagos",
                                "monto" => $Precios["precio"] * 1.16,
                                "payment_id" => $_GET["payment_id"],
                                "preference_id" => $_GET["preference_id"]);

            $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

            echo '<script> window.location = "mis-compras" </script>';

        }

    }else if ($_GET["elment"] == "renovar") {
        
        /* MOSTRAR EXISTENCIA DE PAQUETE EN LA EMPRESA */
        $tabla = "creditos_compras";
		$empresa = $_SESSION["idEmpresa_dashboard"];
        $paqueteadq= $_GET["serPa"];

		$existenciaPaquete = ModeloPagos::mdlMostrarPaquetePagos($tabla, $empresa,$paqueteadq);
        
        //echo "<script>console.log('renovar')</script>";

            /* GUARDAR REGISTRO DE ADQUISICION Y PROXIMO PAGO DE LOS PRODUCTOS */
  
            $tabla = "creditos_compras";
            $adquirido = $existenciaPaquete['fecha_adquirido'];
            $proximo_pago = date("Y-m-d",strtotime($adquirido."+ 1 year"));
            
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                        "id_creditos_precios" => $_GET["serPa"],
                        "fecha_adquirido" => $adquirido,
                        "fecha_ultimo_pago" => $adquirido,
                        "fecha_proximo_pago" => $proximo_pago);
            $respuesta = ModeloPagos::mdlEditarRegistroCompraEspacioPpagos($tabla, $datos);

        /* MOSTRAR CANTIDAD DE PAQUETE */
        $item = "id_creditos_precios";
        $valor = $_GET["serPa"];
        $Precios = ModeloPagos::mdlMostrarPreciosEspacioPagos($item, $valor);

        

            /* GUARDAR REGISTRO DE COMPRA */
            $tabla = "dashboard_registro_compras";
            $datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
                                "descripcion" => $Precios["cantidad"]." Manejos de ventas a pagos",
                                "monto" => $Precios["precio"] * 1.16,
                                "payment_id" => $_GET["payment_id"],
                                "preference_id" => $_GET["preference_id"]);

            $respuestaCompra = ModeloCompras::mdlCrearCompra($tabla, $datos);

            echo '<script> window.location = "mis-compras" </script>';

        

    }

}


    

?>