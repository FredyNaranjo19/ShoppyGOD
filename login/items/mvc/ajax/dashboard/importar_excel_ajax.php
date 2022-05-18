<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos.php';
require_once '../../modelos/dashboard/modelo.productos-masivo.php';
require_once '../../../../dashboard/vistas/modulos/Classes/PHPExcel/IOFactory.php';


$empresa = $_SESSION['idEmpresa_dashboard']; 

    
    

$nombre = $empresa.'temp.xlsx';
$guardado = $_FILES['fileContacts']['tmp_name'];



    if(!file_exists('archivos')){
        mkdir('archivos',0777,true);
            if(file_exists('archivos')){
                move_uploaded_file($guardado,$nombre);
            }
    }else{
        move_uploaded_file($guardado,'archivos/'.$nombre);
    }
    

	$objPHPExcel = PHPEXCEL_IOFactory::load('archivos/'.$nombre);
	
	$objPHPExcel->setActiveSheetIndex(0);
	
	$numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


$array = array();


/* 
	SI OCURRE ALGUN ERROR EN LA LIBRERIA DE EXCELL, SE COMENTO LA LINEA 86 Y 87 Y SE AGREGO OTRA
 	DEL DOCUMENTO CON LA RUTA: D:\xampp\htdocs\tu_proyecto\login\dashboard\vistas\modulos\Classes\PHPExcel\Cell\DefaultValueBinder.php
*/

for($i = 3; $i <= $numRows; $i++){
		

		array_push($array, array("modelo" => $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue(),
								 "nombre" => $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(),
								 "descripcion" => $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue(),
								 "stock" => $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue(),
								 "costo" => $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(),
								 "factura" => $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue(),
								 "proveedor" => $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue(),
								 "precio" => $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue(),
								 "promo" => $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue(),
								 "p_sugerido" => $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue(),
								 "largo" => $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue(),
								 "ancho" => $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue(),
								 "alto" => $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue(),
								 "peso" => $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue(),
								 "clave_producto" => $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue(),
								 "clave_unidad" => $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue()
								));
		

	}


unlink('archivos/'.$nombre);
foreach ($array as $key => $contactData) {

	/* VALIDAR DATOS OBTENIDOS DE EXCEL
	-------------------------------------------------- */

	/* Se eliminan los espacios en blanco antes y despues de la cadena de texto */
	$modelo = trim($contactData["modelo"]);

	/* Si la descripcion esta vacia se agrega un texto */
	if ($contactData["descripcion"] == null) {
		$descripcion = "Sin descripción";
	}else{
		$descripcion = $contactData["descripcion"];
	}


	/*==========================================
	=            MOSTRAR EXISTENCIA            =
	==========================================*/
	$tabla = "productos";
	$item = "codigo";
	$valor = $modelo;
	

	$existencia = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor, $empresa);
	if (sizeof($existencia) > 0) {
		
		// SKU	
		$sku = $_SESSION['idEmpresa_dashboard'];
		$sku .= "-";
		$sku .= $modelo;
		$sku .= "-D";
		$sku .= rand(100,1000000);

		// PRECIO DEL PRODUCTO

		$tablaListado = "productos_listado_precios";
		$datosListado = array("id_empresa" => $_SESSION['idEmpresa_dashboard'],
							  "modelo" => $modelo);

		$preciosList = ModeloProductos::mdlMostrarPreciosProducto($tablaListado, $datosListado);

		foreach ($preciosList as $k => $valuePrecio) {
			if ($k == 0) {
				$precio = $valuePrecio["precio"];
				$promo = $valuePrecio["promo"];

			}
		}
	
	} else {

		$tablaPrecarga = "productos_masivos";
		$itemPrecarga = "codigo";
		$valorPrecarga = $modelo;

		$existenciaPrecarga = ModeloProductosMasivo::mdlMostrarProductosPrecarga($tablaPrecarga, $itemPrecarga, $valorPrecarga, $empresa);

		if (sizeof($existenciaPrecarga) > 0) {

			// SKU
			$sku = $_SESSION['idEmpresa_dashboard'];
			$sku .= "-";
			$sku .= $modelo;
			$sku .= "-D";
			$sku .= rand(100,1000000);

		} else {

			// SKU
			$sku = $_SESSION['idEmpresa_dashboard'];
			$sku .= "-";
			$sku .= $modelo;
			$sku .= "-";
			$sku .= rand(100,1000000);

		}
		

		// PRECIO DEL PRODUCTO

		$precio = $contactData["precio"];
		$promo = $contactData["promo"];

	}

	/*======================================
	=            CREAR PRODUCTO            =
	======================================*/

	$tablaPrecarga = "productos_masivos";

	$datos = array("id_empresa" => $_SESSION['idEmpresa_dashboard'],
					"sku" => $sku,
					"codigo" => $modelo,
					"nombre" => $contactData["nombre"],
					"descripcion" => $descripcion,
					"stock" => $contactData["stock"],
					"costo" => $contactData["costo"],
					"folio" => $contactData["factura"],
					"proveedor" => $contactData["proveedor"],
					"precio" => $precio,
					"promo" => $promo,
					"p_sugerido" => $contactData["p_sugerido"],
					"largo" => $contactData["largo"],
					"ancho" => $contactData["ancho"],
					"alto" => $contactData["alto"],
					"peso" => $contactData["peso"],
					"caracteristicas" => 'NULL',
					"sat_clave_prod_serv" => $contactData["clave_producto"],
					"sat_clave_unidad" => $contactData["clave_unidad"],
				);

	$crearPrecarga = ModeloProductosMasivo::mdlCrearProductoPrecarga($tablaPrecarga, $datos);

	/*=====  End of CREAR PRODUCTO  ======*/

}

/*=================================================
=            MOSTRAR PRECARGA DE EXCEL            =
=================================================*/

$tablaPrecarga = "productos_masivos";
$itemPrecarga = NULL;
$valorPrecarga = NULL;

$respuesta = ModeloProductosMasivo::mdlMostrarProductosPrecarga($tablaPrecarga, $itemPrecarga, $valorPrecarga, $empresa);

echo json_encode($respuesta);

?>