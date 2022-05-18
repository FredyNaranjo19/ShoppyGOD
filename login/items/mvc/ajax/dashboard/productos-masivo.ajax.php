<?php
session_start();
require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.productos-masivo.php';
require_once '../../modelos/dashboard/modelo.productos.php';

class AjaxProductosMasivo{

	/*======================================================
	=            CAMBIO DE VALOR DE ALGUN CAMPO            =
	======================================================*/
	
	public $inputValorCambio;
	public $inputCampoCambio;
	public $inputIdCambio;
	
	public function ajaxCambioValorCampo(){

		$tabla = "productos_masivos";
		$datos = array("id_precarga" => $this -> inputIdCambio,
						"campo" => $this -> inputCampoCambio,
						"valor" => $this -> inputValorCambio);

		$respuesta = ModeloProductosMasivo::mdlModificarCampoPrecarga($tabla, $datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of CAMBIO DE VALOR DE ALGUN CAMPO  ======*/

//****************************************************************************************************************************
//****************************************************************************************************************************
//****************************************************************************************************************************

	/*==============================================================================
	=            GUARDAR CARACTERISTICAS DE LOS PRODUCTOS SELECCIONADOS            =
	==============================================================================*/
	
	public $idsProductosCarac;
	public $idsCaracteristicas;

	public function ajaxGuardarCaracteristicas(){

		$idsProductos = json_decode($this -> idsProductosCarac, true);
		$idsCaracteristicas = json_decode($this -> idsCaracteristicas, true);

		$caracteristicas = array();

		foreach ($idsCaracteristicas as $key => $value) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM caracteristicas_productos WHERE id_panel_caracteristicas_dashboard = :id_panel_caracteristicas_dashboard");
			$stmt -> bindParam(":id_panel_caracteristicas_dashboard", $value["id_carcateristica"]);
			$stmt -> execute();
			$valorResult = $stmt -> fetch();

			array_push($caracteristicas, array("caracteristica" => $valorResult["caracteristica"],
												"datoCaracteristica" => "",
												"tipoCaracteristica" => $valorResult["tipo_input"]));

		}


		$caracteristicasJson = json_encode($caracteristicas);

		foreach ($idsProductos as $key => $value) {

			$tabla = "productos_masivos";
			$datos = array("id_precarga" => $value["id"],
							"campo" => "caracteristicas",
							"valor" => $caracteristicasJson);

			$respuesta = ModeloProductosMasivo::mdlModificarCampoPrecarga($tabla, $datos);

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of GUARDAR CARACTERISTICAS DE LOS PRODUCTOS SELECCIONADOS  ======*/

	/*============================================================
	=            MOSTRAR CARACTERISTICAS DEL PRODUCTO            =
	============================================================*/
	
	public $idProductoCaracteristicas;
	
	public function ajaxMostrarCaracteristicasProducto(){

		$tabla = "productos_masivos";
		$item = "id_precarga";
		$valor = $this -> idProductoCaracteristicas;
		$empresa = $_SESSION['idEmpresa_dashboard'];

		$datos = ModeloProductosMasivo::mdlMostrarProductosPrecarga($tabla, $item, $valor, $empresa);

		if ($datos["caracteristicas"] != NULL) {
			
			$respuesta = $datos["caracteristicas"];
		}

		echo $respuesta;
	}
	
	/*=====  End of MOSTRAR CARACTERISTICAS DEL PRODUCTO  ======*/

	/*=========================================================
	=            MOSTRAR CARCTERISTICAS EXISTENTES            =
	=========================================================*/
	
	public $seleccionadasCarac;
	public function ajaxMostrarCaracteristicasExistentes(){

		$caracteristicas = json_decode($this -> seleccionadasCarac, true);

		$consulta = 'SELECT * FROM caracteristicas_productos';

		if (sizeof($caracteristicas) > 0) {
			$consulta .= ' WHERE';

			foreach ($caracteristicas as $key => $value) {
				if ($key > 0) {
					$consulta .= " AND";
				}
				$consulta .= ' caracteristica <> "'.$value['caracteristica'].'"';
			}

			$stmt = Conexion::conectar()->prepare($consulta);
			$stmt -> execute();

			$respuesta = $stmt -> fetchAll();

		} else {

			$respuesta = NULL;

		}

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR CARCTERISTICAS EXISTENTES  ======*/

	/*===========================================================
	=            MOSTRAR CARACTERISTICA SELECCIONADA            =
	===========================================================*/
	
	public $inputSeleccion;
	public function cambioCaracteristica(){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM caracteristicas_productos WHERE caracteristica = :caracteristica");
		$stmt -> bindParam(":caracteristica", $this -> inputSeleccion, PDO::PARAM_STR);
		$stmt -> execute();

		$respuesta = $stmt -> fetch();

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR CARACTERISTICA SELECCIONADA  ======*/

//****************************************************************************************************************************
//****************************************************************************************************************************
//****************************************************************************************************************************
	
	/*=====================================================
	=            ELIMINAR PRODUCTO DE PRECARGA            =
	=====================================================*/
	
	public $idEliminar;
	public function ajaxEliminarProductoPrecarga(){

		$tabla = "productos_masivos";
		$item = "id_precarga";
		$valor = $this -> idEliminar;

		$respuesta = ModeloProductosMasivo::mdlEliminarProducto($tabla, $item, $valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ELIMINAR PRODUCTO DE PRECARGA  ======*/

	/*========================================================
	=            ELIMINAR PRODUCTOS SELECCIONADOS            =
	========================================================*/
	
	public $productosEliminar;

	public function ajaxEliminarSeleccionados(){

		$seleccionados = json_decode($this -> productosEliminar, true);
		$tabla = "productos_masivos";
		$item = "id_precarga";

		foreach ($seleccionados as $key => $value) {

			$vaa = $value["id"];
			$valor = $value["id"];
			$respuesta = ModeloProductosMasivo::mdlEliminarProducto($tabla, $item, $valor);

		}

		echo json_encode($vaa);


	}
	
	/*=====  End of ELIMINAR PRODUCTOS SELECCIONADOS  ======*/

//****************************************************************************************************************************
//****************************************************************************************************************************
//****************************************************************************************************************************

	/*======================================
	=            SUBIR PRODUCTO            =
	======================================*/
	
	public $idSubir;

	public function ajaxSubirProducto(){

		$tabla = "productos_masivos";
		$item = "id_precarga";
		$valor = $this -> idSubir;
		$empresa = $_SESSION['idEmpresa_dashboard'];

		$retorno = ModeloProductosMasivo::mdlMostrarProductosPrecarga($tabla, $item, $valor, $empresa);

			//VALORES POR DEFECTO DE FACTURACION
			$sat_clave_prod_serv = '01010101';
			$sat_clave_unidad = 'H87';

			//SI LAS CLAVES DEL SAT NO ESTAN VACIAS, TOMA EL VALOR DE LA TABLA
			if ($retorno["sat_clave_prod_serv"] !== null) {
				$sat_clave_prod_serv = $retorno["sat_clave_prod_serv"];
			}

			if ($retorno["sat_clave_unidad"] !== null) {
				$sat_clave_unidad = $retorno["sat_clave_unidad"];
			}

			/*======================================
			=            CREAR PRODUCTO            =
			======================================*/
			// CREAR JSON DE MEDIDAS
			$medidas = array(["largo" => $retorno["largo"],
							 "ancho" => $retorno["ancho"],
							 "alto" => $retorno["alto"]]);

			$medidas = json_encode($medidas, true);



		$tablaProductos = "productos";
		$datosProductos = array("id_empresa" => $retorno["id_empresa"],
								"codigo" => $retorno["codigo"], 
								"sku" => $retorno["sku"],
								"nombre" => $retorno["nombre"], 
								"descripcion" => $retorno["descripcion"],
								"stock" => $retorno["stock"],
								"stock_disponible" => $retorno["stock"],
								"caracteristicas" => $retorno["caracteristicas"],
								"medidas" => $medidas,
								"peso" => $retorno["peso"],
								"sat_clave_prod_serv" => $sat_clave_prod_serv,
								"sat_clave_unidad" => $sat_clave_unidad
								); 

		$respuestaProducto = ModeloProductos::mdlCrearProducto($tablaProductos, $datosProductos);
		
		
		if ($respuestaProducto == 'ok') {
			
			/*===============================================
			=            CREAR LOTE DEL PRODUCTO            =
			===============================================*/

			$tablaLote = "productos_lote";
			$datosLote = array("sku" => $retorno["sku"],
								"cantidad" => $retorno["stock"],
								"costo" => $retorno["costo"],
								"precioSugerido" => $retorno["p_sugerido"],
								"factura" => $retorno["folio"],
								"proveedor" => $retorno["proveedor"],
								"costo_prom_ant" => 0,
								"stock_ant_disp" => 0,
								"no_lote" => 1);

			$respuestaLote = ModeloProductos::mdlCrearLote($tablaLote, $datosLote);

			if ($respuestaLote == "ok") {

			/*===================================================
			=            CREAR LISTADO DEL PRODUCTO             =
			===================================================*/
			
					
				// Verificar existencia
				$tablaListado = "productos_listado_precios";
				$datosListado = array("id_empresa" => $retorno["id_empresa"],
										"modelo" => $retorno["codigo"]);

				$existencia = ModeloProductos::mdlMostrarPreciosProducto($tablaListado, $datosListado);

				if (sizeof($existencia) == 0) {

					// CONFIGURAR VARIABLES POR PROMOCION
					$promo = $retorno["promo"];
					$promoActivado = "no";
					$cantidad = 1;

					if ($promo == "" || floatval($promo) == 0) {
						
						$promo = $retorno["precio"];	

					} 
					// else {

					// 	if (floatval($promo) < floatval($retorno["precio"])) {
					// 		$promoActivado = "si";

					// 	}	

					// }	

					
					$datosListado = array("id_empresa" => $retorno["id_empresa"],
										  "modelo" => $retorno["codigo"],
										  "cantidad" => $cantidad,
										  "costo" => $retorno["costo"],
										  "precio" => $retorno["precio"],
										  "promo" => $promo,
										  "activadoPromo" => $promoActivado);

					$respuestaListado = ModeloProductos::mdlCrearListadoPrecios($tablaListado, $datosListado);


					if ($respuestaListado == "ok") {

						// ELIMINAR PRODUCTO DE PRECARGA
						
						$respuesta = ModeloProductosMasivo::mdlEliminarProducto($tabla, $item, $valor);

						echo json_encode($respuesta);

					} 

				} else {

					// ELIMINAR PRODUCTO DE PRECARGA
					$respuesta = ModeloProductosMasivo::mdlEliminarProducto($tabla, $item, $valor);

					echo json_encode($respuesta);

				}
				
		 	/*=====  End of CREAR LISTADO DEL PRODUCTO  ======*/
			} 

		} 
		
		
	}


	/*=====================================================
	=            SUBIR PRODUCTOS SELECCIONADOS            =
	=====================================================*/
	
	public $productosSubirSelect;
	public function ajaxSubirSleccionados(){

		$seleccionados = json_decode($this -> productosSubirSelect, true);

		foreach ($seleccionados as $key => $value) {
		
		  // if ($key == 0) {
			
			$vaa = $value["id"];

			/*==============================================================
			=            OBTENER INFORMACION DE PRECARGA POR ID            =
			==============================================================*/
			
			$tabla = "productos_masivos";
			$item = "id_precarga";
			$valor = $value["id"];
			$empresa = $_SESSION['idEmpresa_dashboard'];

			$retorno = ModeloProductosMasivo::mdlMostrarProductosPrecarga($tabla, $item, $valor, $empresa);
				
				//VALORES POR DEFECTO DE FACTURACION
				$sat_clave_prod_serv = '01010101';
				$sat_clave_unidad = 'H87';

				//SI LAS CLAVES DEL SAT NO ESTAN VACIAS, TOMA EL VALOR DE LA TABLA
				if ($retorno["sat_clave_prod_serv"] !== null) {
					$sat_clave_prod_serv = $retorno["sat_clave_prod_serv"];
				}

				if ($retorno["sat_clave_unidad"] !== null) {
					$sat_clave_unidad = $retorno["sat_clave_unidad"];
				}

				/*======================================
				=            CREAR PRODUCTO            =
				======================================*/
				$medidas = array(["largo" => $retorno["largo"],
							 "ancho" => $retorno["ancho"],
							 "alto" => $retorno["alto"]]);

				$medidas = json_encode($medidas, true);

				$tablaProductos = "productos";
				$datosProductos = array("id_empresa" => $retorno["id_empresa"],
								"codigo" => $retorno["codigo"], 
								"sku" => $retorno["sku"],
								"nombre" => $retorno["nombre"], 
								"descripcion" => $retorno["descripcion"],
								"stock" => $retorno["stock"],
								"stock_disponible" => $retorno["stock"],
								"caracteristicas" => $retorno["caracteristicas"],
								"medidas" => $medidas,
								"peso" => $retorno["peso"],
								"sat_clave_prod_serv" => $sat_clave_prod_serv,
								"sat_clave_unidad" => $sat_clave_unidad);

				$respuestaProducto = ModeloProductos::mdlCrearProducto($tablaProductos, $datosProductos);
				

				if ($respuestaProducto == 'ok') {

					/*===============================================
					=            CREAR LOTE DEL PRODUCTO            =
					===============================================*/

					$tablaLote = "productos_lote";
					$datosLote = array("sku" => $retorno["sku"],
								"cantidad" => $retorno["stock"],
								"costo" => $retorno["costo"],
								"precioSugerido" => $retorno["p_sugerido"],
								"factura" => $retorno["folio"],
								"proveedor" => $retorno["proveedor"],
								"costo_prom_ant" => 0,
								"stock_ant_disp" => 0,
								"no_lote" => 1);

					$respuestaLote = ModeloProductos::mdlCrearLote($tablaLote, $datosLote);

					if ($respuestaLote == "ok") {

						/*===================================================
						=            CREAR LISTADO DEL PRODUCTO             =
						===================================================*/
						
						// Verificar existencia
						$tablaListado = "productos_listado_precios";
						$datosListado = array("id_empresa" => $retorno["id_empresa"],
										"modelo" => $retorno["codigo"]);

						$existencia = ModeloProductos::mdlMostrarPreciosProducto($tablaListado, $datosListado);

						if (sizeof($existencia) == 0) {

							// $res = "no hay";

							// CONFIGURAR VARIABLES POR PROMOCION
								$promo = $retorno["promo"];
								$promoActivado = "no";
								$cantidad = 1;

								if ($promo == "" || floatval($promo) == 0) {
									
									$promo = $retorno["precio"];	

								} 
								// else {

								// 	if (floatval($promo) < floatval($retorno["precio"])) {
								// 		$promoActivado = "si";

								// 	}	
								// }	

							$datosListado = array("id_empresa" => $retorno["id_empresa"],
												  "modelo" => $retorno["codigo"],
												  "cantidad" => $cantidad,
												  "costo" => $retorno["costo"],
												  "precio" => $retorno["precio"],
												  "promo" => $promo,
												  "activadoPromo" => $promoActivado);

							$respuestaListado = ModeloProductos::mdlCrearListadoPrecios($tablaListado, $datosListado);

							if ($respuestaListado == "ok") {

								$respuesta = ModeloProductosMasivo::mdlEliminarProducto($tabla, $item, $valor);

							}

						} else {

							$respuesta = ModeloProductosMasivo::mdlEliminarProducto($tabla, $item, $valor);

						}
					}
				}
		  // }

		}

		echo json_encode($respuesta);

	}
	
	/*=====  End of SUBIR PRODUCTOS SELECCIONADOS  ======*/

}

/*======================================================
=            CAMBIO DE VALOR EN ALGUN CAMPO            =
======================================================*/

if (isset($_POST["inputValorCambio"])) {
	$cambioValor = new AjaxProductosMasivo();
	$cambioValor -> inputValorCambio = $_POST["inputValorCambio"];
	$cambioValor -> inputCampoCambio = $_POST["inputCampoCambio"];
	$cambioValor -> inputIdCambio = $_POST["inputIdCambio"];
	$cambioValor -> ajaxCambioValorCampo();
}

/*=====  End of CAMBIO DE VALOR EN ALGUN CAMPO  ======*/

/*==============================================================================
=            GUARDAR CARACTERISTICAS DE LOS PRODUCTOS SELECCIONADOS            =
==============================================================================*/

if (isset($_POST["idsProductosCarac"])) {
	$guardarCarcateristicas = new AjaxProductosMasivo();
	$guardarCarcateristicas -> idsProductosCarac = $_POST["idsProductosCarac"];
	$guardarCarcateristicas -> idsCaracteristicas = $_POST["idsCaracteristicas"];
	$guardarCarcateristicas -> ajaxGuardarCaracteristicas();
}

/*=====  End of GUARDAR CARACTERISTICAS DE LOS PRODUCTOS SELECCIONADOS  ======*/

/*===========================================================
=            MOSTRAR CARCTERISTICAS DEL PRODUCTO            =
===========================================================*/

if (isset($_POST["idProductoCaracteristicas"])) {
	$mostrarCaracteristicasProducto = new AjaxProductosMasivo();
	$mostrarCaracteristicasProducto -> idProductoCaracteristicas = $_POST["idProductoCaracteristicas"];
	$mostrarCaracteristicasProducto -> ajaxMostrarCaracteristicasProducto();
}

/*=====  End of MOSTRAR CARCTERISTICAS DEL PRODUCTO  ======*/

/*=========================================================
=            MOSTRAR CARCTERISTICAS EXISTENTES            =
=========================================================*/

if (isset($_POST["seleccionadasCarac"])) {
	$existentesCarcteristicas = new AjaxProductosMasivo();
	$existentesCarcteristicas -> seleccionadasCarac = $_POST["seleccionadasCarac"];
	$existentesCarcteristicas -> ajaxMostrarCaracteristicasExistentes();
}

/*=====  End of MOSTRAR CARCTERISTICAS EXISTENTES  ======*/

/*===========================================================
=            MOSTRAR CARACTERISTICA SELECCIONADA            =
===========================================================*/

if (isset($_POST["inputSeleccion"])) {
	$cambioCaracteristica = new AjaxProductosMasivo();
	$cambioCaracteristica -> inputSeleccion = $_POST["inputSeleccion"];
	$cambioCaracteristica -> cambioCaracteristica();
}

/*=====  End of MOSTRAR CARACTERISTICA SELECCIONADA  ======*/

//*******************************************************************
//*******************************************************************
//*******************************************************************

/*=====================================================
=            ELIMINAR PRODUCTO DE PRECARGA            =
=====================================================*/

if (isset($_POST["idEliminar"])) {
	$eliminarProducto = new AjaxProductosMasivo();
	$eliminarProducto -> idEliminar = $_POST["idEliminar"];
	$eliminarProducto -> ajaxEliminarProductoPrecarga();
} 

/*=====  End of ELIMINAR PRODUCTO DE PRECARGA  ======*/

/*========================================================
=            ELIMINAR PRODUCTOS SELECCIONADOS            =
========================================================*/

if (isset($_POST["productosEliminar"])) {
	$eliminarSeleccionados = new AjaxProductosMasivo();
	$eliminarSeleccionados -> productosEliminar = $_POST["productosEliminar"];
	$eliminarSeleccionados -> ajaxEliminarSeleccionados();
}

/*=====  End of ELIMINAR PRODUCTOS SELECCIONADOS  ======*/

//*******************************************************************
//*******************************************************************
//*******************************************************************

/*=======================================
=            SUBIR PRODUCTO             =
=======================================*/

if (isset($_POST["idSubir"])) {
	$subirProducto = new AjaxProductosMasivo();
	$subirProducto -> idSubir = $_POST["idSubir"];
	$subirProducto -> ajaxSubirProducto();
}

/*=====  End of SUBIR PRODUCTO   ======*/

/*=====================================================
=            SUBIR PRODUCTOS SELECCIONADOS            =
=====================================================*/

if (isset($_POST["productosSubirSelect"])) {
	$subirSeleccionados = new AjaxProductosMasivo();
	$subirSeleccionados -> productosSubirSelect = $_POST["productosSubirSelect"];
	$subirSeleccionados -> ajaxSubirSleccionados();
}

/*=====  End of SUBIR PRODUCTOS SELECCIONADOS  ======*/

?>