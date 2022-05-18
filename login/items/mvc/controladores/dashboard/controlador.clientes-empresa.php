<?php

class ControladorClientes{
	/*========================================
	=            MOSTRAR CLIENTES            =
	========================================*/
	
	static public function ctrMostrarClientes($item, $valor){

		$tabla = "clientes_empresa";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloClientes::mdlMostrarClientes($tabla,$item,$valor,$empresa);

		return $respuesta;
	
	}
	
	/*=====  End of MOSTRAR CLIENTES  ======*/

	/*===================================================
	=            CREAR CLIENTE DE LA EMPRESA            =
	===================================================*/
	
	static public function ctrCrearCliente(){

		if(isset($_POST["nCorreoCli"])){

				$pass = $_POST["nUsuarioCli"];
				$pesta = 1;	
				if($_POST["nCorreoCli"]==""){
					$correo="pendiente";
				}else{
					$correo=$_POST["nCorreoCli"];
				}
			
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['nNombreCli']) &&
				preg_match('/^[a-zA-Z0-9ñÑ._@ ]+$/', $correo)) {

				$tabla = "clientes_empresa";
				

				$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
								"nombre" => $_POST["nNombreCli"],
								"usuario" => $_POST["nUsuarioCli"],
							 	"email" => $correo,
							  	"telefono" => $_POST["ntelCli"],
							  	"password" => $pass);

				$respuesta = ModeloClientes::mdlCrearCliente($tabla,$datos);

				if ($respuesta == "ok") {

					echo "<script>
							window.location='clientes'
						 </script>";

				}
			} else {
					
				echo "<script>
					window.location='clientes';
				</script>";	

			}
			
		}
	}
	
	/*=====  End of CREAR CLIENTE DE LA EMPRESA  ======*/
	
	/*===================================================
	=            EDITAR CLIENT DE LA EMPRESA            =
	===================================================*/
	
	static public function ctrEditarCliente(){
		if (isset($_POST["ClienteeNombre"])) {
			
			$tabla = "clientes_empresa";

			$datos = array("nombre" => $_POST["ClienteeNombre"],
							"telefono" => $_POST["ClienteeTelefono"],
							"id_cliente" => $_POST["ClienteeId"]);

			$respuesta = ModeloClientes::mdlEditarCLiente($tabla, $datos);

			echo '<script>
					window.location = "clientes"
			</script>';

		}
	}
	
	/*=====  End of EDITAR CLIENT DE LA EMPRESA  ======*/

	/*============================================================
	=            CREAR O EDITAR DIRECCION DEL CLIENTE            =
	============================================================*/
	
	static public function ctrDireccionCliente(){
		if (isset($_POST["DireccionClientes"])) {

			$tabla = "clientes_direcciones_empresa";

			if ($_POST["tipoAccionClientes"] == "Crear") {
				
				$datos = array("direccion" => $_POST["DireccionClientes"],
								"exterior" => $_POST["ExtClientes"],
								"interior" => $_POST["IntClientes"],
								"colonia" => $_POST["ColoniaClientes"],
								"ciudad" => $_POST["CiudadClientes"],
								"estado" => $_POST["EstadoClientes"],
								"cp" => $_POST["CPClientes"],
								"pais" => $_POST["PaisClientes"],
								"calle1" => $_POST["calle1Clientes"],
								"calle2" => $_POST["calle2Clientes"],
								"referencia" => $_POST["refClientes"],
								"idCliente" => $_POST["clienteIdClientes"]);

				$respuesta = ModeloClientes::mdlCrearDireccion($tabla, $datos);

			} else {

				$datos = array("direccion" => $_POST["DireccionClientes"],
								"exterior" => $_POST["ExtClientes"],
								"interior" => $_POST["IntClientes"],
								"colonia" => $_POST["ColoniaClientes"],
								"ciudad" => $_POST["CiudadClientes"],
								"estado" => $_POST["EstadoClientes"],
								"cp" => $_POST["CPClientes"],
								"pais" => $_POST["PaisClientes"],
								"calle1" => $_POST["calle1Clientes"],
								"calle2" => $_POST["calle2Clientes"],
								"referencia" => $_POST["refClientes"],
								"id_info" => $_POST["idDireccionClientes"]);

				$respuesta = ModeloClientes::mdlEditarDireccionCliente($tabla, $datos);
			}

			if ($respuesta == "ok") {
				
				echo '<script>
						window.location = "clientes";
				</script>';
			}
		}
	}
	
	/*=====  End of CREAR O EDITAR DIRECCION DEL CLIENTE  ======*/
	
	/*====================================================
	=            SOLICITUD DE CREDITO CLIENTE            =
	====================================================*/
	
	static public function ctrMostrarSolicitudesCredito($item, $valor){

		$tabla = "clientes_solicitud_credito";
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModeloClientes::mdlMostrarSolicitudesCredito($tabla, $item, $valor, $empresa);

		return $respuesta;
	}
	
	/*=====  End of SOLICITUD DE CREDITO CLIENTE  ======*/
	
}

?>