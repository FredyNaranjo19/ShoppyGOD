<?php
session_start();
$GLOBALS["global_ID_Empresa"] = "1";

// CONTROLADORES 

require_once '../items/mvc/controladores/tv/controlador.carrito.php';
require_once '../items/mvc/controladores/tv/controlador.categorias.php';
require_once '../items/mvc/controladores/tv/controlador.clientes.php';
require_once '../items/mvc/controladores/tv/controlador.configuracion.php';
require_once '../items/mvc/controladores/tv/controlador.pedidos.php';
require_once '../items/mvc/controladores/tv/controlador.plantilla.php';
require_once '../items/mvc/controladores/tv/controlador.productos.php';
require_once '../items/mvc/controladores/tv/controlador.pago.php';

/* CONTROLADORES PARA LINK WEB
-------------------------------------------------- */
require_once '../items/mvc/controladores/dashboard/controlador.ventasCedis.php';
require_once '../items/mvc/controladores/dashboard/controlador.empresas.php';



// MODELOS

require_once '../items/mvc/modelos/conexion.php';
require_once '../items/mvc/modelos/tv/modelo.carrito.php';
require_once '../items/mvc/modelos/tv/modelo.categorias.php';
require_once '../items/mvc/modelos/tv/modelo.clientes.php';
require_once '../items/mvc/modelos/tv/modelo.configuracion.php';
require_once '../items/mvc/modelos/tv/modelo.pedidos.php';
require_once '../items/mvc/modelos/tv/modelo.plantilla.php';
require_once '../items/mvc/modelos/tv/modelo.productos.php';

/* MODELOS PARA LINK WEB
-------------------------------------------------- */
require_once '../items/mvc/modelos/dashboard/modelo.ventasCedis.php';
require_once '../items/mvc/modelos/dashboard/modelo.empresas.php';




// INICIALIZAR LA TIENDA

$c1 = new ControladorPlantilla();
$c1 -> ctrPlantilla();

?>