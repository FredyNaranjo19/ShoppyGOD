<?php

class ShConfiguracion{
    
    static public function MostrarConfiguracionPago($tabla, $item, $valor){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        $conex -> execute();

        return $conex -> fetch();

        $conex -> close();
        $conex = NULL;
    }

    static public function MostrarConfiguracionEntregas($tabla, $item, $valor){
        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item");

        $conex -> execute();

        return $conex -> fetch();

        $conex -> close();
        $conex = NULL;
    }

    static public function shMostrarConfiguracionCostoEnvio($tabla, $item, $valor){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item ORDER BY precio");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        $conex -> execute();

        return $conex -> fetchAll();

        $stmt -> close();
        $stmt = NULL;
    }

    static public function shEmpresas($empresa){

        $conex = Conexion::conectar()->prepare("SELECT * FROM empresas WHERE id_empresa = :id_empresa");
        $conex -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $close = NULL;
    }
}