<?php
require_once '../../modelos/conexion.php';

/*============================================================
=            MOSTRAR CARACTERISTICAS CONFIGURADAS            =
============================================================*/

$stmt = Conexion::conectar()->prepare("SELECT * FROM caracteristicas_productos");
$stmt -> execute();

$respuesta = $stmt -> fetchAll();

echo json_encode($respuesta);

/*=====  End of MOSTRAR CARACTERISTICAS CONFIGURADAS  ======*/


?>