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

        $verificarComentario = ShProductos::mdlVerficarComentario($this->idProducto, $this -> idUsuarioProducto);

        $datosConsulta = array(
            "id_empresa" => $this -> empresaProducto,
            "id_producto" => $this -> idProducto
        );

        $puntuacionInfo = ShProductos::mdlObtenerPuntuacionProducto($datosConsulta);

        if($verificarComentario == "false"){
            if($puntuacionInfo["comentarios"] == 0){
                $datosUpdate =  array(
                    "id_empresa" => $this->empresaProducto,
                    "id_producto" => $this->idProducto,
                    "puntos" => $this->ratingProducto,
                    "comentarios" =>1
                );
                $actualizarPuntaje = ShProductos::mdlModificarPuntuacionProducto($datosUpdate);
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

                $actualizarPuntuaje = ShProductos::mdlModificarPuntuacionProducto($datosUpdate);
            }
            $comentar = ShProductos::mdlGuardarComentarioProducto($tabla, $datos);
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
            $actualizarPuntuaje = ShProducto::mdlModificarPuntuacionProducto($datosUpdate);

            $comentar = ShProductos::mdlUpdateComentarioProducto($datos);
        }

        if($cometar == "ok"){
            echo json_encode($comentar);
        }
    }
}