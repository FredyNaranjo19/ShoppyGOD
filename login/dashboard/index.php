<?php
session_start();
date_default_timezone_set('America/Mexico_City');


// C O N T R O L A D O R E S 
require_once '../items/mvc/controladores/dashboard/controlador.almacenes.php';
require_once '../items/mvc/controladores/dashboard/controlador.inicio.php';
require_once '../items/mvc/controladores/dashboard/controlador.dashboard.php';
require_once '../items/mvc/controladores/dashboard/controlador.categorias.php';
require_once '../items/mvc/controladores/dashboard/controlador.clientes-empresa.php';
require_once '../items/mvc/controladores/dashboard/controlador.compras.php';
require_once '../items/mvc/controladores/dashboard/controlador.configuracion-tienda.php';
require_once '../items/mvc/controladores/dashboard/controlador.embarcaciones.php';
require_once '../items/mvc/controladores/dashboard/controlador.empresas.php';
require_once '../items/mvc/controladores/dashboard/controlador.pedidos.php';
require_once '../items/mvc/controladores/dashboard/controlador.plantillas-tienda.php';
require_once '../items/mvc/controladores/dashboard/controlador.productos.php';
require_once '../items/mvc/controladores/dashboard/controlador.productos-almacen.php';
require_once '../items/mvc/controladores/dashboard/controlador.productos-masivo.php';
require_once '../items/mvc/controladores/dashboard/controlador.productos-tienda.php';
require_once '../items/mvc/controladores/dashboard/controlador.proveedores.php';
require_once '../items/mvc/controladores/dashboard/controlador.sucursales.php';
require_once '../items/mvc/controladores/dashboard/controlador.usuarios.php';
require_once '../items/mvc/controladores/dashboard/controlador.ventas.php';
require_once '../items/mvc/controladores/dashboard/controlador.ventasCedis.php';
require_once '../items/mvc/controladores/dashboard/controlador.vendedorext-pedidos.php';
require_once '../items/mvc/controladores/dashboard/controlador.pagos.php';
require_once '../items/mvc/controladores/dashboard/controlador.configuracion-venta.php';
require_once '../items/mvc/controladores/dashboard/controlador.devoluciones.php';


// M O D E L O S
require_once '../items/mvc/modelos/conexion.php';
require_once '../items/mvc/modelos/dashboard/modelo.almacenes.php';
require_once '../items/mvc/modelos/dashboard/modelo.inicio.php';
require_once '../items/mvc/modelos/dashboard/modelo.categorias.php';
require_once '../items/mvc/modelos/dashboard/modelo.clientes-empresa.php';
require_once '../items/mvc/modelos/dashboard/modelo.compras.php';
require_once '../items/mvc/modelos/dashboard/modelo.configuracion-tienda.php';
require_once '../items/mvc/modelos/dashboard/modelo.embarcaciones.php';
require_once '../items/mvc/modelos/dashboard/modelo.empresas.php';
require_once '../items/mvc/modelos/dashboard/modelo.pedidos.php';
require_once '../items/mvc/modelos/dashboard/modelo.plantillas-tienda.php';
require_once '../items/mvc/modelos/dashboard/modelo.proveedores.php';
require_once '../items/mvc/modelos/dashboard/modelo.productos.php';
require_once '../items/mvc/modelos/dashboard/modelo.productos-almacen.php';
require_once '../items/mvc/modelos/dashboard/modelo.productos-masivo.php';
require_once '../items/mvc/modelos/dashboard/modelo.productos-tienda.php';
require_once '../items/mvc/modelos/dashboard/modelo.sucursales.php';
require_once '../items/mvc/modelos/dashboard/modelo.usuarios.php';
require_once '../items/mvc/modelos/dashboard/modelo.ventas.php';
require_once '../items/mvc/modelos/dashboard/modelo.ventasCedis.php';
require_once '../items/mvc/modelos/dashboard/modelo.vendedorext-pedidos.php';
require_once '../items/mvc/modelos/dashboard/modelo.configuracion-venta.php';
require_once '../items/mvc/modelos/dashboard/modelo.devoluciones.php';
require_once '../items/mvc/modelos/dashboard/modelo.pagos.php';



// require_once  '../items/extensiones/mercadoPago/vendor/autoload.php';
// MercadoPago\SDK::setAccessToken("TEST-5978302454328951-051819-26dfdbdddbc7f909145fa8a5d925141a-498835772");

//- - - - - - I N I C I A R - - - - - - D A S H B O A R D - - - - - -

$dashboard = new ControladorDashboard();
$dashboard -> ctrDashboard();

?>