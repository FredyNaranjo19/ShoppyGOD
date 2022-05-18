<?php 

class Modeloinicio{

	/*=========================================
	=            MOSTRAR ALMACENES            =
	=========================================*/
	
	static public function mdlMostrartotalproductos($tabla, $item, $valor){


			$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM $tabla WHERE id_empresa = :id_empresa AND stock>= 0");
			$stmt -> bindParam(":id_empresa", $valor, PDO::PARAM_STR);
			$stmt -> execute();

			return $stmt -> fetch();
            $stmt -> close();
		    $stmt = NULL;

		}
/*=====  End of MOSTRAR Total Productos  ======*/

/*======================================================
	=            MOSTRAR Total Clientes           =
	======================================================*/
    static public function mdltotalclientes($tabla, $item, $valor){


        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM $tabla WHERE id_empresa = :id_empresa");
        $stmt -> bindParam(":id_empresa", $valor, PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetch();
        $stmt -> close();
        $stmt = NULL;

    }

    /*=====  End of MOSTRAR Total clientes  ======*/
    /*======================================================
	=            MOSTRAR Ventas Hoy           =
	======================================================*/
   static public function mdlventashoy($tabla, $valor, $fecha){

        $aprobado="Aprobado";
        $stmt = Conexion::conectar()->prepare("SELECT SUM(total) FROM $tabla 
        WHERE id_empresa = :id_empresa
        AND date(fecha) = :fecha
        AND estado= :aprobado");
        
        $stmt -> bindParam(":id_empresa", $valor, PDO::PARAM_STR);
        $stmt -> bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt -> bindParam(":aprobado", $aprobado, PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetch();
        $stmt -> close();
        $stmt = NULL;

    }

    /*=====  End of MOSTRAR Ventas Hoy  ======*/

/*======================================================
	=            MOSTRAR Productos en TV           =
	======================================================*/
    static public function mdlprodentv($tabla, $valor){


        $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM $tabla WHERE id_empresa = :id_empresa");
        $stmt -> bindParam(":id_empresa", $valor, PDO::PARAM_STR);
        $stmt -> execute();

        return $stmt -> fetch();
        $stmt -> close();
        $stmt = NULL;

    }

    /*=====  End of MOSTRAR Productos en TV  ======*/

		
}
	

?>

