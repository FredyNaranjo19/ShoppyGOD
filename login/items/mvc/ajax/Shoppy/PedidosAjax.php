<?php

class AjaxPedidos{
    public $folioNota;
    public $nota;
    public function ajaxAgregarAnotacion(){

        $tabla = "sh_pedidos";
        $valor1 = $this -> folioNota;
        $valor2 = $this -> nota;

        $respuesta = PedidosSh::AgregarAnotacion($tabla, $valor1, $valor2);

        echo json_encode($respuesta);

        }

    }

    if(isset($_POST["folioNota"])){
        $agregarNota = new AjaxPedidos();
        $agregarNota -> folioNota = $_POST["folioNota"];
        $agregarNota -> nota = $_POST["nota"];
        $agregarNota -> ajaxAgregarAnotacion();
    }
