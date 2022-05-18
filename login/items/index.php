<?php
session_start();

require_once 'mvc/modelos/conexion.php';

require_once 'mvc/modelos/Shoppy/modelo.shproductos.php';
require_once 'mvc/modelos/Shoppy/modelo.shcarrito.php';
require_once 'mvc/modelos/Shoppy/modelo.shcategoria.php';
require_once 'mvc/modelos/Shoppy/modelo.shproveedores.php';
require_once 'mvc/modelos/Shoppy/modelo.shpedido.php';

//*Controladores
require_once 'mvc/controladores/Shoppy/controlador.shoppy.php';
require_once 'mvc/controladores/Shoppy/controlador.shproductos.php';
require_once 'mvc/controladores/Shoppy/controlador.shcategoria.php';
require_once 'mvc/controladores/Shoppy/controlador.shproveedores.php';
require_once 'mvc/controladores/Shoppy/controlador.shpedido.php';
require_once 'mvc/controladores/Shoppy/controlador.shcategoria.php';
require_once 'mvc/controladores/Shoppy/controlador.shcarrito.php';


//TODO: Inicializar Plantilla
$c1 = new ControladorPlantilla();
$c1->ctrlPlantilla();