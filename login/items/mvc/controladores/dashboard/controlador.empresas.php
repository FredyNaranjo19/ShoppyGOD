<?php

class ControladorEmpresas{

	/*========================================
	=            MOSTRAR EMPRESAS            =
	========================================*/

	static public function ctrMostrarEmpresasAdministracion($item, $valor){

		$tabla = "empresas";

		$respuesta = ModelosEmpresas::mdlMostrarEmpresas($tabla, $item, $valor);

		return $respuesta;
	}

	/*=====  End of MOSTRAR EMPRESAS  ======*/

	/*===============================================================
	=                   REGISTRAR CLIENTE DIRECTO                   =
	===============================================================*/

	static public function ctrCrearClienteDirectoEmpresa(){
		if(isset($_POST["registroNombreCliente"])){
			$tabla = "clientes_servicio_plataforma";
			
			$datos = ["nombre" => $_POST["registroNombreCliente"],
						"correo" => $_POST["registroCorreoCliente"],
						"telefono" => $_POST["registroTelefonoCliente"],
						"password" => $_POST["registroPasswordCliente"],
						"estado" => $_POST["selectEstadoCliente"],
						];

			$respuesta = ModelosEmpresas::modeloCrearClienteDirectoEmpresa($tabla,$datos);

			if ($respuesta == "ok") {

				echo "<script>
						alert('Cliente registrado');
						window.location='regEmpAdmin';
					</script>";
			}else{
				echo "<script>
						alert('ERROR cliente NO registrado');
						window.location='regEmpAdmin';
					</script>";
			}
			

		}
	}


	/*============  End of REGISTRAR CLIENTE DIRECTO  =============*/

	/*==================================================================
	=                   CONSULTAR CLIENTES DIRECTOS                    =
	==================================================================*/
	static public function ctrMostrarClienteDirectoEmpresa($item, $valor){
		$tabla = "clientes_servicio_plataforma";
		$respuesta = ModelosEmpresas::modeloMostrarClienteDirectoEmpresa($tabla,$item, $valor);
		
		return $respuesta;
	}
	
	/*============  End of CONSULTAR CLIENTES DIRECTOS   =============*/

	/*========================================================
	=                   REGISTRAR EMPRESA                    =
	========================================================*/
	
	static public function ctrCrearEmpresa(){
		if(isset($_POST["selectClienteDirecTo"])){
			/* CREANDO EMPRESA
			-------------------------------------------------- */
			
			$tabla = "empresas";
			
			$datos = ["id_cliente" => $_POST["selectClienteDirecTo"],
						"rfc" => $_POST["registroRfcEmpresa"],
						"nombre" => $_POST["registroNombreEmpresa"],
						"domicilio" => $_POST["registroDomicilioEmpresa"],
						"ramo" => $_POST["registroRamoEmpresa"],
						"alias" => $_POST["registroAliasEmpresa"],
						];

			$respuesta = ModelosEmpresas::modeloCrearEmpresa($tabla,$datos);

			/* SI SE CREA CORRECTAMENTE, CREA CONTENIDO DE EMPRESA Y CONFIGURACIONES
			-------------------------------------------------- */
			
			if ($respuesta == "ok") {

				//OBTENER ID DE LA EMPRESA
				$tabla = "empresas";
				$item = "id_clienteDirecto";
				$valor = $_POST["selectClienteDirecTo"];

				$respuestaEmpresa = ModelosEmpresas::modeloMostrarEmpresaPorClienteDirecto($tabla,$item,$valor);

				//CREAR CONTENIDO DE LA EMPRESA
				$tabla = "empresas_contenido_sistema";
				$empresa = $respuestaEmpresa["id_empresa"];

				$crearContenidoEmpresa = ModelosEmpresas::modeloCrearContenidoEmpresa($tabla,$empresa);

				/* SI SE CREA EL CONTENIDO, CREAR CONFIGURACION DE PAGOS Y VENTAS
				-------------------------------------------------- */
				
				if($crearContenidoEmpresa == "ok"){

					//CREAR CONFIGURACION DE PAGOS

					$tabla = "cedis_ventas_pagos_configuracion";
					// $crearConfigPagos = ModelosEmpresas::modeloCrearConfiguracionesEmpresa($tabla, $empresa);
					
					//PRUEBA CREAR CONFIG PAGOS CEDIS 
					$pagoIncial = '[{"pago_inicial":"si","tipo_pago_inicial":"libre","monto_pago_inicial":0}]';
					$periodos = '[{"semanal":"Si","semanal_valor":"0","quincenal":"Si","quincenal_valor":"0","mensual":"Si","mensual_valor":"0"}]';
					$datos = ["id_empresa" => $empresa,
								"pago_inicial" => $pagoIncial,
								"periodos" => $periodos];
					$crearConfigPagos = ModelosEmpresas::modeloCrearConfiguracionesPagosEmpresa($tabla, $datos);

					//CREAR CONFIGURACION VENTAS
					$tabla = "configuracion_ventas";
					$crearConfigVentas = ModelosEmpresas::modeloCrearConfiguracionesEmpresa($tabla, $empresa);

					//CREAR ALMACEN
					$tabla = "almacenes";
					$crearAlmacen = ModelosEmpresas::modeloCrearConfiguracionesEmpresa($tabla, $empresa);

					//MOSTRAR ALMACEN DE LA EMPRESA 
					$mostrarAlmacenEmprea = ModeloAlmacenes::mdlMostrarAlmacenes($tabla,null,null,$empresa);

					//CREAR CONFIGURACION PAGOS ALMACEN
					$tabla = "ventas_pagos_configuracion";
					$id_almacen = $mostrarAlmacenEmprea[0]["id_almacen"];
					$datos = ["id_almacen" => $id_almacen,
								"pago_inicial" => $pagoIncial,
								"periodos" => $periodos];

					$crearConfigPagosAlmacen = ModelosEmpresas::modeloCrearConfiguracionesPagosAlmacen($tabla,$datos);




					echo "<script>
							alert('Empresa registrada, contenido creado, almacen creado y configuraciones hechas');
							window.location='regEmpAdmin';
						</script>";
				}else{
					echo "<script>
						alert('ERROR empresa registrada Contenido NO creado');
						window.location='regEmpAdmin';
					</script>";
				}
			}else{
				echo "<script>
						alert('ERROR empresa NO registrada');
						window.location='regEmpAdmin';
					</script>";
			}
			

		}
	}
	
	
	/*============  End of REGISTRAR EMPRESA   =============*/

	/*=========================================================================
	=                   MOSTRAR INFO CLIETE DIRECTO EMPRESA                   =
	=========================================================================*/
	
	static public function ctrMostrarInfoEmpresaClienteDirecto(){
		$respuesta = ModelosEmpresas::mdlMostrarInfoEmpresaClienteDirecto();
		return $respuesta;
	}
	
	
	/*============  End of MOSTRAR INFO CLIETE DIRECTO EMPRESA  =============*/

	/*==============================================================
	=                   CREAR USUARIO PLATADORMA                   =
	==============================================================*/
	
	static public function ctrCrearUsuarioPlataforma(){
		if(isset($_POST["registroNombreUsuario"])){
			$tabla = "usuarios_plataforma";

			if($_POST["selectAlmacenEmpresa"] !== "null"){
				$almacenSeleccionado = $_POST["selectAlmacenEmpresa"];
			}else{
				$almacenSeleccionado = NULL;
			}

			
			$datos = [
					"id_empresa" => $_POST["selectEmpresa"],
					"nombre" => $_POST["registroNombreUsuario"],
					"email" => $_POST["regristroCorreoUsuario"],
					"password" => $_POST["registroContraseñaUsuario"],
					"telefono" => $_POST["registroTelefonoUsuario"],
					"almacen" => $almacenSeleccionado,
					"estado" => $_POST["selectEstadoUsuario"],
					"rol" => $_POST["selectRolUsuario"],
					];

			$respuesta = ModelosEmpresas::mdlCrearUsuarioPlataforma($tabla, $datos);

			if($respuesta == "ok"){
				echo "<script>
							alert('Usuario registrado correctamente');
							window.location='regEmpAdmin';
						</script>";
			}
		}
	}
	
	/*============  End of CREAR USUARIO PLATADORMA  =============*/

}

?>