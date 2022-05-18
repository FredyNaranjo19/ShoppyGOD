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

    static public function MostrarConfiguracionCostoEnvio($tabla, $item, $valor){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item =:$item ORDER BY precio");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        $conex -> execute();

        return $conex -> fetchAll();

        $stmt -> close();
        $stmt = NULL;
    }

    static public function MostrarInformacionIva($empresa){
        $conex = Conexion::conectar()->prepare("SELECT * FROM configuracion_ventas WHERE id_empresa = :id_empresa");
        $conex ->bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
        $conex -> execute();
        return $conex ->fetch();
        $conex -> close();
        $conex = NULL;
    }

    static public function MostrarInformacionCliente($tabla, $item, $valor){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $conex -> bindParam(":".$item, $valor, PDO::PARAM_STR);

        $conex -> execute();

        if($conex -> rowCount() > 0){
            return $conex -> fetchAll();
        }else{
            return "ninguno";
        }
    }

    static public function MostrarClienteEmail($tabla, $datos){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_empresa =:id_empresa AND  email = :email");

        $conex -> bindParam(":id_empresa", $datos["id_empresa"], PDO::PARAM_STR);
        $conex ->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $conex -> execute();

        return $conex ->fetch();

        $conex -> close();
        $conex = NULL;
    }

    static public function MostraUltimaDireccion($tabla, $item, $valor){

        $conex = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id_info DESC Limit 1");

        $conex -> bindParam(":". $item, $valor, PDO::PARAM_STR);
        $conex -> execute();
        
        return $conex -> fetch();
    }

    static public function Empresas($empresa){

        $conex = Conexion::conectar()->prepare("SELECT * FROM empresas WHERE id_empresa = :id_empresa");
        $conex -> bindParam(":id_empresa", $empresa, PDO::PARAM_STR);
        $conex -> execute();
        return $conex -> fetch();
        $conex -> close();
        $close = NULL;
    }
}