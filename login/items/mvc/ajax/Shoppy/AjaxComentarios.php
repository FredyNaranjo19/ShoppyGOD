<?php

class AjaxComentarios{

    public $ratingProducto;
    public $comentarioProducto;
    public $empresaProducto;
    public $idProducto;
    public $idUsuarioProducto;


    public function ajaxCrearComentario(){

        $tabla = "sh_productos_comentarios";

        $datos = array(
            "id_producto" => $this -> idProducto,
            "id_cliente" => $this -> idUsuarioProducto,
            "comentario" => $this -> comentarioProducto,
            "puntos" => $this -> ratingProducto
        );

        $verificarComentario = ShProductos::shVerficarComentario($this->idProducto, $this -> idUsuarioProducto);

        $datosConsulta = array(
            "id_empresa" => $this -> empresaProducto,
            "id_producto" => $this -> idProducto
        );

        $puntuacionInfo = ShProductos::shObtenerPuntuacionProducto($datosConsulta);

        if($verificarComentario == "false"){
            if($puntuacionInfo["comentarios"] == 0){
                $datosUpdate =  array(
                    "id_empresa" => $this->empresaProducto,
                    "id_producto" => $this->idProducto,
                    "puntos" => $this->ratingProducto,
                    "comentarios" =>1
                );
                $actualizarPuntaje = ShProductos::shModificarPuntuacionProducto($datosUpdate);
            }else{
                $comentariosAux = $puntuacionInfo["comentarios"];
                $puntuacionAux = ($puntuacionInfo ["puntos"] * $comentariosAux)+ $this ->ratingProducto;
                $comentariosCalc = $comentariosAux + 1;
                $puntuacionEdit = round($puntuacionAux / $comentariosCalc);

                $datosUpdate = array(
                    "id_empresa" => $this ->empresaProducto,
                    "id_producto" => $this ->idProducto,
                    "puntos" => $puntuacionEdit,
                    "comentarios" =>$comentariosCalc
                );

                $actualizarPuntuaje = ShProductos::shModificarPuntuacionProducto($datosUpdate);
            }
            $comentar = ShProductos::shGuardarComentarioProducto($tabla, $datos);
        }else{
            $comentariosAux = $puntuacionInfo["comentarios"];
            $puntuacionAux = ($puntuacionInfo["puntos"] * $comentariosAux) - $puntuacionInfo["puntos"] + $this -> ratingProducto;
            $comentarioCalc = $comentariosAux;
            $puntuacionEdit = round($puntuacionAux / $comentariosCalc);

            $datosUpdate = array(
                "id_empresa" => $this ->empresaProducto,
                "id_producto" => $this -> idProducto,
                "puntos" => $puntuacionEdit,
                "comentarios"=>$comentariosCalc
            );
            $actualizarPuntuaje = ShProducto::shModificarPuntuacionProducto($datosUpdate);

            $comentar = ShProductos::shUpdateComentarioProducto($datos);
        }

        if($cometar == "ok"){
            echo json_encode($comentar);
        }
    }
}