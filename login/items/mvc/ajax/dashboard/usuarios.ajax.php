<?php
session_start();

require_once '../../modelos/conexion.php';
require_once '../../modelos/dashboard/modelo.usuarios.php';
require_once '../../modelos/dashboard/modelo.compras.php';

class AjaxUsuariosPlataforma{

	/*==========================================================
	=            VERIFICACION DE CORREO ELECTRONICO            =
	==========================================================*/
	
	public $verificacionEmail;

	public function ajaxVerificacionEmail(){

		$tabla = "clientes_servicio_plataforma";
		$item = "email";
		$valor = $this -> verificacionEmail;
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$respuesta = ModelosUsuarios::mdlMostrarUsuarios($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);

	}
	
	/*=====  End of VERIFICACION DE CORREO ELECTRONICO  ======*/

	/*==================================================================
	=            ESTADO DE USUARIO (ACTIVADO O DESACTIVADO)            =
	==================================================================*/
	
	public $UsuarioActivarId;
	public $UsuarioActivarEstado;

	public function ajaxActivarUsuario(){

		$tabla = "usuarios_plataforma";

		$datos = array("estado" => $this -> UsuarioActivarEstado,
						"id_usuario_plataforma" => $this -> UsuarioActivarId);

		$respuesta = ModelosUsuarios::mdlHabilitarUsuarioDashboard($tabla, $datos);

		// echo json_encode($respuesta);
	}
	
	/*=====  End of ESTADO DE USUARIO (ACTIVADO O DESACTIVADO)  ======*/

	/*======================================================
	=            CREAR NUEVO USUARIO DE EMPRESA            =
	======================================================*/
	
	public $crearUsuarioNombre;
	public $crearUsuarioEmail;
	public $crearUsuarioTelefono;
	public $crearUsuarioPassword;
	public $crearUsuarioRol;
	public $crearUsuarioAlmacen;
	
	public function ajaxCrearUsuarioPlataforma(){

		$item = "id_usuarios_plataforma_roles";
		$valor = $this -> crearUsuarioRol;
		$rol = ModelosUsuarios::mdlMostrarRoles($item, $valor);


		$tabla = "usuarios_plataforma";

		$datos = array("id_empresa" => $_SESSION["idEmpresa_dashboard"],
						"nombre" => $this -> crearUsuarioNombre,
						"email" => $this -> crearUsuarioEmail,
						"password" => $this -> crearUsuarioPassword,
						"telefono" => $this -> crearUsuarioTelefono,
						"almacen" => $this -> crearUsuarioAlmacen,
						"rol" => $rol["rol_nombre"]);

		$respuesta = ModelosUsuarios::mdlCrearUsuarioPlataforma($tabla, $datos);

		echo json_encode($respuesta);
	}
	
	/*=====  End of CREAR NUEVO USUARIO DE EMPRESA  ======*/
		

	/*===================================================================
	=            MOSTRAR INFORMACION DEL USUARIO PARA EDITAR            =
	===================================================================*/
	
	public $idUsuario;
	public function ajaxEditarUsuario(){

		$tabla = "usuarios_plataforma";
		$item = "id_usuario_plataforma";
		$valor = $this -> idUsuario;
		$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModelosUsuarios::mdlMostrarUsuarios($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR INFORMACION DEL USUARIO PARA EDITAR  ======*/

	/*===============================================
	=            EDITAR USUARIO MOSTRADO            =
	===============================================*/
	
	public $editarUsuarioNombre;
	public $editarUsuarioId;
	public $editarUsuarioEmail;
	public $editarUsuarioPass;
	public $editarUsuarioTelefono;
	public $editarUsuarioalmacen;
	
	public function ajaxEditarUsuarioMostrado(){

		$tabla = "usuarios_plataforma";

		$datos = array("nombre" => $this -> editarUsuarioNombre,
						"email" => $this -> editarUsuarioEmail,
						"password" => $this -> editarUsuarioPass,
						"telefono" => $this -> editarUsuarioTelefono,
						"id_usuario_plataforma" => $this -> editarUsuarioId,
						"almacen" => $this -> editarUsuarioalmacen
					);

		$respuesta = ModelosUsuarios::mdlEditarUsuarioPlataforma($tabla,$datos);

		echo json_encode($respuesta);

	}
	
	/*=====  End of EDITAR USUARIO MOSTRADO  ======*/

	/*=====================================================
	=            ELIMINAR USUARIO DE DASHBOARD            =
	=====================================================*/
	
	public $usuariosEliminarId;
	public function ajaxEliminarUsuario(){

		$tabla = "usuarios_plataforma";

		$item = "id_usuario_plataforma";
		$valor = $this -> usuariosEliminarId;

		$respuesta = ModelosUsuarios::mdlEliminarUsuario($tabla, $item, $valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of ELIMINAR USUARIO DE DASHBOARD  ======*/

	/*====================================================
	=            ADMINISTRACION DE PLATAFORMA            =
	====================================================*/
	
	public $rolAdministrador;
	public $almacenAdministrador;
	
	public function ajaxAdministradorPlataforma(){

		$_SESSION["rol_dashboard"] = $this -> rolAdministrador;
		$_SESSION["almacen_dashboard"] = $this -> almacenAdministrador;

		echo json_encode('ok');
	}
	
	/*=====  End of ADMINISTRACION DE PLATAFORMA  ======*/
		
	/*================================================================
	=                   MOSTRAR ROLES DISPONIBLES                    =
	================================================================*/
	
	public $rolesDisponibles;
	public function ajaxMostrarRolesDisponibles(){

		/* MOSTRAR CONTENIDO DE LA EMPRESA */
		$empresa = $_SESSION["idEmpresa_dashboard"];
		$elementos = ModeloCompras::mdlMostrarElementosEmpresa($empresa);

		/* MOSTRAR USUARIOS DE LA EMPRESA */
		$usuarios = ModelosUsuarios::mdlMostrarUsuariosAgrupados($empresa);

		$Adm = 0;
		$AdmAlm = 0;
		$VenAlm = 0;
		$VenExt = 0;

		foreach ($usuarios as $key => $value) {

			if($value["rol"] == "Administrador"){

				$Adm = intval($elementos["administrador"]) - intval($value["cantidad"]);

			}
			
			if($value["rol"] == "Administrador Almacen" || $value["rol"] == "Administrador Almacen "){

				$AdmAlm = intval($elementos["administrador_almacen"]) - intval($value["cantidad"]);

			}

			if($value["rol"] == "Vendedor Almacen" || $value["rol"] == "Vendedor Almacen "){

				$VenAlm = intval($elementos["vendedores_almacen"]) - intval($value["cantidad"]);

			}

			if($value["rol"] == "Vendedor Externo"){

				$VenExt = intval($elementos["vendedores_externos"]) - intval($value["cantidad"]);

			}

		}

		$respuesta = array("administrador" => $Adm,
							"administrador_almacen" => $AdmAlm,
							"vendedores_almacen" => $VenAlm,
							"vendedores_externos" => $VenExt);

		echo json_encode($respuesta);
	}
	
	/*============  End of MOSTRAR ROLES DISPONIBLES   =============*/
		/*===================================================================
	=            MOSTRAR INFORMACION DEL USUARIO Almacen PARA EDITAR            =
	===================================================================*/
	
	public $idUsuarioAlmacen;
	public function ajaxEditarUsuariAlmacen(){

		
		$valor = $this -> idUsuarioAlmacen;
		//$empresa = $_SESSION["idEmpresa_dashboard"];

		$respuesta = ModelosUsuarios::mdlMostrarUsuariosenalmacen($valor);

		echo json_encode($respuesta);
	}
	
	/*=====  End of MOSTRAR INFORMACION DEL USUARIO Almacen PARA EDITAR  ======*/

	public $idEmpresa;
	public function ajaxMostrarUsuariosPlataformaEmpresa(){
		$tabla = "usuarios_plataforma";
		$item = null;
		$valor = null;
		$empresa = $this -> idEmpresa;

		$respuesta = ModelosUsuarios::mdlMostrarUsuarios($tabla, $item, $valor, $empresa);

		echo json_encode($respuesta);
	}
}

/*==========================================================
=            VERIFICACION DE CORREO ELECTRONICO            =
==========================================================*/

if (isset($_POST["verificacionEmail"])) {
	$existenciaEmail = new AjaxUsuariosPlataforma();
	$existenciaEmail -> verificacionEmail = $_POST["verificacionEmail"];
	$existenciaEmail -> ajaxVerificacionEmail();
}

/*=====  End of VERIFICACION DE CORREO ELECTRONICO  ======*/

/*==================================================================
=            ESTADO DE USUARIO (ACTIVADO O DESACTIVADO)            =
==================================================================*/

if(isset($_POST["UsuarioActivarId"])){
	$activarUsuario = new AjaxUsuariosPlataforma();
	$activarUsuario -> UsuarioActivarId = $_POST["UsuarioActivarId"];
	$activarUsuario -> UsuarioActivarEstado = $_POST["UsuarioActivarEstado"];
	$activarUsuario -> ajaxActivarUsuario();
}

/*=====  End of ESTADO DE USUARIO (ACTIVADO O DESACTIVADO)  ======*/

/*======================================================
=            CREAR NUEVO USUARIO DE EMPRESA            =
======================================================*/

if (isset($_POST["crearUsuarioNombre"])) {
	$crearUsuario = new AjaxUsuariosPlataforma();
	$crearUsuario -> crearUsuarioNombre = $_POST["crearUsuarioNombre"];
	$crearUsuario -> crearUsuarioEmail = $_POST["crearUsuarioEmail"];
	$crearUsuario -> crearUsuarioTelefono = $_POST["crearUsuarioTelefono"];
	$crearUsuario -> crearUsuarioPassword = $_POST["crearUsuarioPassword"];
	$crearUsuario -> crearUsuarioRol = $_POST["crearUsuarioRol"];
	$crearUsuario -> crearUsuarioAlmacen = $_POST["crearUsuarioAlmacen"];
	$crearUsuario -> ajaxCrearUsuarioPlataforma();
}

/*=====  End of CREAR NUEVO USUARIO DE EMPRESA  ======*/

/*===================================================================
=            MOSTRAR INFORMACION DEL USUARIO PARA EDITAR            =
===================================================================*/

if (isset($_POST["idUsuario"])) {
	$editar = new AjaxUsuariosPlataforma();
	$editar -> idUsuario = $_POST["idUsuario"];
	$editar -> ajaxEditarUsuario();
}

/*=====  End of MOSTRAR INFORMACION DEL USUARIO PARA EDITAR  ======*/

/*===============================================
=            EDITAR USUARIO MOSTRADO            =
===============================================*/

if (isset($_POST["editarUsuarioId"])) {
	$editarUsuario = new AjaxUsuariosPlataforma();
	$editarUsuario -> editarUsuarioNombre = $_POST["editarUsuarioNombre"];
	$editarUsuario -> editarUsuarioId = $_POST["editarUsuarioId"];
	$editarUsuario -> editarUsuarioEmail = $_POST["editarUsuarioEmail"];
	$editarUsuario -> editarUsuarioPass = $_POST["editarUsuarioPass"];
	$editarUsuario -> editarUsuarioTelefono = $_POST["editarUsuarioTelefono"];
	$editarUsuario -> editarUsuarioalmacen = $_POST["editarUsuarioAlmacen"];
	$editarUsuario -> ajaxEditarUsuarioMostrado();
}

/*=====  End of EDITAR USUARIO MOSTRADO  ======*/

/*=====================================================
=            ELIMINAR USUARIO DE DASHBOARD            =
=====================================================*/

if (isset($_POST["usuariosEliminarId"])) {
	$eliminarUsuario = new AjaxUsuariosPlataforma();
	$eliminarUsuario -> usuariosEliminarId = $_POST["usuariosEliminarId"];
	$eliminarUsuario -> ajaxEliminarUsuario();
}

/*=====  End of ELIMINAR USUARIO DE DASHBOARD  ======*/

/*====================================================
=            ADMINISTRACION DE PLATAFORMA            =
====================================================*/

if (isset($_POST["rolAdministrador"])) {
	$administrador = new AjaxUsuariosPlataforma();
	$administrador -> rolAdministrador = $_POST["rolAdministrador"]; 
	$administrador -> almacenAdministrador = $_POST["almacenAdministrador"];
	$administrador -> ajaxAdministradorPlataforma();
}

/*=====  End of ADMINISTRACION DE PLATAFORMA  ======*/

/*===============================================================
=                   MOSTRAR ROLES DISPONIBLES                   =
===============================================================*/

if(isset($_POST["rolesDisponibles"])){
	$rolesDisponibles = new AjaxUsuariosPlataforma();
	$rolesDisponibles -> rolesDisponibles = $_POST["rolesDisponibles"];
	$rolesDisponibles -> ajaxMostrarRolesDisponibles();
}

/*============  End of MOSTRAR ROLES DISPONIBLES  =============*/
/*===================================================================
=            MOSTRAR INFORMACION DEL USUARIO Almacen PARA EDITAR            =
===================================================================*/

if (isset($_POST["idUsuarioAlmacen"])) {
	$editar = new AjaxUsuariosPlataforma();
	$editar -> idUsuarioAlmacen = $_POST["idUsuarioAlmacen"];
	$editar -> ajaxEditarUsuariAlmacen();
}

/*=====  End of MOSTRAR INFORMACION DEL USUARIO Almacen PARA EDITAR  ======*/

/*===================================================================
=            MOSTRAR INFORMACION DEL USUARIO Almacen PARA EDITAR            =
===================================================================*/

if (isset($_POST["idEmpresaRegistroUsuarioPlataforma"])) {
	$editar = new AjaxUsuariosPlataforma();
	$editar -> idEmpresa = $_POST["idEmpresaRegistroUsuarioPlataforma"];
	$editar -> ajaxMostrarUsuariosPlataformaEmpresa();
}

/*=====  End of MOSTRAR INFORMACION DEL USUARIO Almacen PARA EDITAR  ======*/

?>