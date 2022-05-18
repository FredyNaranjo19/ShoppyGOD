<?php

class ControladorUsuarios{

	/*====================================================
	=            INICIAR SESION  DEPENDIENDO             =
	====================================================*/
	
	static public function ctrIngresarDashboard(){

		if (isset($_POST["emailDashboard"])) {

			$item = "email";
			$valor = $_POST["emailDashboard"];
			$tabla = "usuarios_plataforma";
			$empresa = "";

			$respuesta = ModelosUsuarios::mdlMostrarUsuarios($tabla, $item, $valor, $empresa);


			if($respuesta["email"] == $_POST["emailDashboard"] && $respuesta["password"] == $_POST["passwordDashboard"]){

          		if ($respuesta["rol"] == "Administrador" || $respuesta["rol"] == "Administrador General") {

					$_SESSION["sesion_dashboard"] = "ok";
					$_SESSION["id_dashboard"] = $respuesta["id_usuario_plataforma"];
					$_SESSION["nombre_dashboard"] = $respuesta["nombre"];

					$tablaEmpresa = "empresas";
					$itemEmpresa = "id_empresa";
					$valorEmpresa = $respuesta["id_empresa"];
					$resEmpresa = ModelosEmpresas::mdlMostrarEmpresas($tablaEmpresa, $itemEmpresa, $valorEmpresa);

					$_SESSION["idEmpresa_dashboard"] = $respuesta["id_empresa"];
					$_SESSION["nombreEmpresa_dashboard"] = $resEmpresa["nombre"];
					$_SESSION["aliasEmpresa_dashboard"] = $resEmpresa["alias"];
					$_SESSION["domicilioEmpresa_dashboard"] = $resEmpresa["domicilio"];

          			$_SESSION["rol_principal"] = $respuesta["rol"];
          			echo '<script> 
							window.location = "administracion";
						</script>';


          		} else if ($respuesta["rol"] == "Administrador Almacen" || $respuesta["rol"] == "Vendedor Almacen" || $respuesta["rol"] == "Vendedor Externo" || $respuesta["rol"] == "Vendedor Matriz" || $respuesta["rol"] == "Administrador Almacen " || $respuesta["rol"] == "Vendedor Almacen "){

					/* SABER DE DEUDAS */
					$deuda = "no";
					/* EN CASO DE ERROR QUITAR LAS VARIABLES DE ITEM Y VALOR
						-------------------------------------------------- */

						$almacenes = ModeloCompras::mdlMostrarComprasAlmacenes($item, $valor, $respuesta["id_empresa"]);
						if ($almacenes != false) {
							foreach ($almacenes as $key => $value) {
								if (date('Y-m-d') > $value["fecha_proximo_pago"]) {
								$deuda = "si";
								}
							}
						}

						$vendedores = ModeloCompras::mdlMostrarComprasVendedoresAlmacen($item, $valor, $respuesta["id_empresa"]);
						if ($vendedores != false) {
							foreach ($vendedores as $key => $value) {
							if (date('Y-m-d') > $value["fecha_proximo_pago"]) {
								$deuda = "si";
							}
							}
						}

					if ($deuda == "no") {

						$_SESSION["sesion_dashboard"] = "ok";
						$_SESSION["id_dashboard"] = $respuesta["id_usuario_plataforma"];
						$_SESSION["nombre_dashboard"] = $respuesta["nombre"];
	
						$tablaEmpresa = "empresas";
						$itemEmpresa = "id_empresa";
						$valorEmpresa = $respuesta["id_empresa"];
						$resEmpresa = ModelosEmpresas::mdlMostrarEmpresas($tablaEmpresa, $itemEmpresa, $valorEmpresa);
	
						$_SESSION["idEmpresa_dashboard"] = $respuesta["id_empresa"];
						$_SESSION["nombreEmpresa_dashboard"] = $resEmpresa["nombre"];
						$_SESSION["aliasEmpresa_dashboard"] = $resEmpresa["alias"];
						$_SESSION["domicilioEmpresa_dashboard"] = $resEmpresa["domicilio"];

						$_SESSION["rol_principal"] = $respuesta["rol"];
						$_SESSION["rol_dashboard"] = $respuesta["rol"];
						$_SESSION["almacen_dashboard"] = $respuesta["almacen"];

						if ($respuesta["rol"] == "Vendedor Matriz") {
							echo '<script> 
								window.location = "cedis-crear-venta";
							</script>';
						}else{
							echo '<script> 
								window.location = "inicio";
							</script>';
						}

					} else {

						echo '<script> 
								alert("No tienes acceso al sistema por falta de pago");
						</script>';

					}
          			

          		} elseif ($respuesta["rol"] == "Administrador Registro") {
					  	$_SESSION["sesion_dashboard"] = "ok";
						$_SESSION["id_dashboard"] = $respuesta["id_usuario_plataforma"];
						$_SESSION["nombre_dashboard"] = $respuesta["nombre"];
	
						// $tablaEmpresa = "empresas";
						// $itemEmpresa = "id_empresa";
						// $valorEmpresa = $respuesta["id_empresa"];
						// $resEmpresa = ModelosEmpresas::mdlMostrarEmpresas($tablaEmpresa, $itemEmpresa, $valorEmpresa);
	
						$_SESSION["idEmpresa_dashboard"] = 9999;
						// $_SESSION["nombreEmpresa_dashboard"] = $resEmpresa["nombre"];
						// $_SESSION["aliasEmpresa_dashboard"] = $resEmpresa["alias"];
						// $_SESSION["domicilioEmpresa_dashboard"] = $resEmpresa["domicilio"];

						$_SESSION["rol_principal"] = $respuesta["rol"];
						$_SESSION["rol_dashboard"] = $respuesta["rol"];
						// $_SESSION["almacen_dashboard"] = $respuesta["almacen"];

						
						echo '<script> 
							window.location = "regEmpAdmin";
						</script>';
						
				}

			}	

		}
	}
	
	/*=====  End of INICIAR SESION  DEPENDIENDO   ======*/
	
	/*==================================================
	=            MOSTRAR USUARIOS DASHBOARD            =
	==================================================*/
	
	static public function ctrMostrarUsuario($tabla, $item, $valor){
		
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModelosUsuarios::MdlMostrarUsuarios($tabla, $item, $valor, $empresa);
 
		return $respuesta; 
	}
	
	/*=====  End of MOSTRAR USUARIOS DASHBOARD  ======*/

	/*=================================================
	=            MOSTRAR ROLES DE USUARIO             =
	=================================================*/
	
	static public function ctrMostrarRoles($item, $valor){

		$respuesta = ModelosUsuarios::mdlMostrarRoles($item, $valor);

		return $respuesta;
	}
	
	/*=====  End of MOSTRAR ROLES DE USUARIO   ======*/
	
}

?> 