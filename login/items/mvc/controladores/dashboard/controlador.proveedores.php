<?php

class ControladorProveedores{

	/*===========================================
	=            MOSTRAR PROVEEDORES            =
	===========================================*/
	
	static public function ctrMostrarProveedores($item, $valor){

		$tabla = "proveedores";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloProveedores::mdlMostrarProveedores($tabla, $item, $valor, $empresa);

		return $respuesta;

	}
	
	/*=====  End of MOSTRAR PROVEEDORES  ======*/

	/*=============================================
	=            CREAR NUEVO PROVEEDOR            =
	=============================================*/
	
	static public function ctrCrearProveedor(){

		if (isset($_POST["ProveedornNombre"])) {
			

			$tabla = "proveedores";

			$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						    "nombre" => $_POST["ProveedornNombre"],
						    "contacto" => $_POST["ProveedornContacto"],
							"telefono" => $_POST["ProveedornTelefono"],
							"calle" => $_POST["ProveedornCalle"],
							"noExt" => $_POST["ProveedornNoExt"],
							"noInt" => $_POST["ProveedornNoInt"],
							"colonia" => $_POST["ProveedornColonia"],
							"cp" => $_POST["ProveedornCP"],
							"municipio" => $_POST["ProveedornMunicipio"],
							"estado" => $_POST["ProveedornEstado"],
							"pais" => $_POST["ProveedornPais"]);

			$respuesta = ModeloProveedores::mdlCrearProveedor($tabla, $datos);

			if ($respuesta) {
				
				echo '<script>
						window.location = "proveedores";
					</script>';
			}

		}
	}
	
	/*=====  End of CREAR NUEVO PROVEEDOR  ======*/
	
	/*========================================
	=            EDITAR PROVEEDOR            =
	========================================*/
	
	static public function ctrEditarProveedor(){

		if (isset($_POST["ProveedoreNombre"])) {
			

			$tabla = "proveedores";

			$datos = array("id_empresa" => $_POST["ProveedoreEmpresa"],
						    "nombre" => $_POST["ProveedoreNombre"],
						    "contacto" => $_POST["ProveedoreContacto"],
							"telefono" => $_POST["ProveedoreTelefono"],
							"calle" => $_POST["ProveedoreCalle"],
							"noExt" => $_POST["ProveedoreNoExt"],
							"noInt" => $_POST["ProveedoreNoInt"],
							"colonia" => $_POST["ProveedoreColonia"],
							"cp" => $_POST["ProveedoreCP"],
							"municipio" => $_POST["ProveedoreMunicipio"],
							"estado" => $_POST["ProveedoreEstado"],
							"pais" => $_POST["ProveedorePais"],
							"id_proveedor" => $_POST["ProveedoreId"]);

			$respuesta = ModeloProveedores::mdlEditarProveedor($tabla, $datos);

			if ($respuesta == "ok") {
				
				echo '<script>
						window.location = "proveedores";
					</script>';
			}

		}
	}
	
	/*=====  End of EDITAR PROVEEDOR  ======*/
	
}

?>