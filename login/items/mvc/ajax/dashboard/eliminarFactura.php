<?php

if (isset($_POST["rutas"])) {
    $rutas = json_decode($_POST["rutas"]);

    foreach ($rutas as $key => $ruta) {
        If (unlink($ruta)) {
            $respuesta = "eliminado";
        } else {
            $respuesta = "error";
        }
    }
    echo json_encode($respuesta);
}