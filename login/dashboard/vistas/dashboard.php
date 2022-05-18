<?php
// $_SESSION["nombreEmpresa_dashboard"] = "Studio Spook";
// $_SESSION["idEmpresa_dashboard"] = "1";

include '../items/js/global.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../items/img/login/svg/Logo-Azul.svg" rel="shortcut icon">
	<title>Dashboard</title>




	<!--==================================================================================
	=            ************************* LINK CSS *************************            =
	===================================================================================-->
	<link rel="stylesheet" href="vistas/css/cedis-venta.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="../items/plugins/fontawesome-free/css/all.min.css">
	<!-- Ekko Lightbox -->
  	<link rel="stylesheet" href="../items/plugins/ekko-lightbox/ekko-lightbox.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="../items/plugins/toastr/toastr.min.css">
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="../items/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- DataTables -->
  	<link rel="stylesheet" href="../items/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  	<link rel="stylesheet" href="../items/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  	<link rel="stylesheet" href="../items/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../items/dist/css/adminlte.min.css">
  	<!-- Select2 -->
  	<link rel="stylesheet" href="../items/plugins/select2/css/select2.min.css">
  	<link rel="stylesheet" href="../items/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  	<!-- Google Font: Montserrat -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

		<!-- C S S --- P E R S O N A L E S -->

		<link rel="stylesheet" href="vistas/css/facturacion.css">
		<link rel="stylesheet" href="vistas/css/productos.css">
		<link rel="stylesheet" href="vistas/css/plantillas.css">
		<link rel="stylesheet" href="vistas/css/productos-masivo.css">
		<link rel="stylesheet" href="vistas/css/ventas-pagos-aprobacion.css">
		<link rel="stylesheet" href="vistas/css/cedis-step-progress.css">
		<link rel="stylesheet" href="vistas/css/loginNuevo.css">
		<link rel="stylesheet" href="vistas/css/styleLogin.css">
		
		
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="../items/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="../items/plugins/jqvmap/jqvmap.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../items/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="../items/plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="../items/plugins/summernote/summernote-bs4.css">

	<style>
		body{
			font-family: 'Montserrat';
			font-weight: 400;
			
		}
		
		.content-wrapper{
			background-image: url("../items/img/FONDO-ROL.JPG");
			background-repeat: no-repeat; 
			background-position: center center;
			background-size: cover;
		}

		body table thead{
			font-family: 'Montserrat';
			font-weight: 700;
		}

		body table tbody{
			font-family: 'Montserrat';
			font-weight: 400;
		}


		.main-sidebar{
			/*border-top-right-radius: 50px;*/
			/* border-bottom-right-radius: 50px; */
			background: black;
			font-family: 'Montserrat';
			font-weight: 700;
			font-size: 0.8em;
		}

		.main-header{
			background: black;
			color: white;
			/* background: linear-gradient(to right, #C20B7E, #403195); */
		}

			.navbar-light .navbar-nav .nav-link{
				color: white;
			}
			

			.navbar-light .navbar-nav .nav-link:hover, .navbar-light .navbar-nav .nav-link:focus {
				color: #00b4d8ff;
			}

			.navbar-nav .nav-link .fa-bars{
				color : white;
			}



		.btnColorCambio{
			background: #00b4d8ff;
			font-size: 1.1em;
			font-weight: 500;
			border-radius: 15px;
		}

		.btnColorCambio:hover{
			background: #2da4d7ff;
			font-size: 1.1em;
			font-weight: 600;
		}

		

	</style>
	<!--====  End of ************************* LINK CSS *************************  ====-->
	<!-- jQuery -->
	<script src="../items/plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="../items/plugins/jquery-ui/jquery-ui.min.js"></script>


	
</head>
<?php
if (isset($_SESSION['sesion_dashboard']) && $_SESSION['sesion_dashboard'] == "ok") {
	
echo '<body class="hold-transition sidebar-mini">
		<div class="wrapper">';

	
		/*==================================
		=            ENCABEZADO            =
		==================================*/
		
		include 'modulos/fix/header.php';

		/*====================================
		=            MENU LATERAL            =
		====================================*/
		
		include 'modulos/fix/lateral.php';

		if (isset($_SESSION["rol_dashboard"])){

			if ($_SESSION["rol_dashboard"] == "Cedis") {
				
				/*==========================================
				=            CUERPO DEL SISTEMA            =
				==========================================*/
				
				if (isset($_GET["ruta"])) {

					if ($_GET["ruta"] == "administracion" ||
						$_GET["ruta"] == "almacenes" ||
						$_GET["ruta"] == "clientes" ||
						$_GET["ruta"] == "cedis-crear-venta" ||
						$_GET["ruta"] == "cedis-ventas" ||
						$_GET["ruta"] == "cedis-ventas-cancelaciones" ||
						$_GET["ruta"] == "cedis-ventas-cortes" ||
						$_GET["ruta"] == "cedis-ventas-dia" ||
						$_GET["ruta"] == "cedis-ventas-link" ||
						$_GET["ruta"] == "cedis-ventas-link-valorar" ||
						$_GET["ruta"] == "cedis-ventas-pagos-clientes" ||
						$_GET["ruta"] == "estado-cuenta-cliente" ||
						$_GET["ruta"] == "cedis-ventas-pagos" ||
						$_GET["ruta"] == "cedis-ventas-pagos-aprobacion" ||
						$_GET["ruta"] == "cedis-ventas-pagos-configuracion" ||
						$_GET["ruta"] == "cedis-ventas-pagos-historial" ||
						$_GET["ruta"] == "comprasElementosEmpresa" ||
						$_GET["ruta"] == "end-close" ||
						$_GET["ruta"] == "regEmpAdmin" ||
						$_GET["ruta"] == "embarques" ||
						$_GET["ruta"] == "embarques-nuevo" ||
						$_GET["ruta"] == "facturacion-configuracion" ||
						$_GET["ruta"] == "facturacion-save-compra" ||
						$_GET["ruta"] == "facturacion-cedis" ||
						$_GET["ruta"] == "facturacion-cedis-nueva" ||
						$_GET["ruta"] == "facturacion-cedisVentPag-nueva" ||
						$_GET["ruta"] == "facturacion-cedisVentPag-realizar" ||
						$_GET["ruta"] == "facturacion-tv" ||
						$_GET["ruta"] == "facturacion-tv-nueva" ||
						$_GET["ruta"] == "inicio" ||
						$_GET["ruta"] == "mis-compras" ||
						$_GET["ruta"] == "productos" ||
						$_GET["ruta"] == "productos-lotes" ||
						$_GET["ruta"] == "productos-masivo" ||
						$_GET["ruta"] == "proporcionar-datos" ||
						$_GET["ruta"] == "proveedores" ||
						$_GET["ruta"] == "pruebaCorreo" ||
						$_GET["ruta"] == "renovarElementosEmpresa" ||
						$_GET["ruta"] == "tienda-configuracion" ||
						$_GET["ruta"] == "tienda-pedidos-finalizados" ||
						$_GET["ruta"] == "tienda-pedidos-guias" ||
						$_GET["ruta"] == "tienda-pedidos-sin-comprobante" ||
						$_GET["ruta"] == "tienda-pedidos-pendientes" ||
						$_GET["ruta"] == "tienda-pedidos-preparacion" ||
						$_GET["ruta"] == "tienda-plantillas" ||
						$_GET["ruta"] == "tienda-plantillas-compras" ||
						$_GET["ruta"] == "tienda-plantillas-configuracion" ||
						$_GET["ruta"] == "tienda-plantillas-successful" ||
						$_GET["ruta"] == "tienda-productos" ||
						$_GET["ruta"] == "usuarios-plataforma" ||
						$_GET["ruta"] == "ventas-pagos-aprobacion" ||
						$_GET["ruta"] == "ventas-pagos-configuracion" ||
						$_GET["ruta"] == "vendedorExt-pedidos-cancelaciones" ||
						$_GET["ruta"] == "vendedorExt-pedidos-generar" ||
						$_GET["ruta"] == "vendedorext-pedidos-pagos-configuracion" ||
						$_GET["ruta"] == "vendedorExt-pedidos-pagos-aprobar" ||
						$_GET["ruta"] == "starter" ||
						$_GET["ruta"] == "configuracion-venta" ||
						$_GET["ruta"] == "devoluciones" ||
						$_GET["ruta"] == "vendedorExt-pedidos-cortes")
						{

						include 'modulos/'.$_GET["ruta"].".php";

					} else {

						include 'modulos/404.php';

					}

				} else {

					include 'modulos/inicio.php';

				}

			} else if ($_SESSION["rol_dashboard"] == "Administrador Almacen" || $_SESSION["rol_dashboard"] == "Administrador Almacen ") {

				/*==========================================
				=            CUERPO DEL SISTEMA            =
				==========================================*/
				
				if (isset($_GET["ruta"])) {

					if ($_GET["ruta"] == "administracion" ||
						$_GET["ruta"] == "end-close" ||
						$_GET["ruta"] == "embarques-almacen" ||
						$_GET["ruta"] == "facturacion-almacen" ||
						$_GET["ruta"] == "facturacion-almacen-nueva" ||
						$_GET["ruta"] == "inicio" ||
						$_GET["ruta"] == "productos-almacen" ||
						$_GET["ruta"] == "ventas" ||
						$_GET["ruta"] == "ventas-cancelaciones" ||
						$_GET["ruta"] == "ventas-cortes" ||
						$_GET["ruta"] == "ventas-dia" ||
						$_GET["ruta"] == "ventas-nueva" ||
						$_GET["ruta"] == "ventas-pagos" ||
						$_GET["ruta"] == "ventas-pagos-historial"){

						include 'modulos/'.$_GET["ruta"].".php";

					} else {

						include 'modulos/404.php';

					}

				} else {

					include 'modulos/inicio.php';

				}

				
			} else if ($_SESSION["rol_dashboard"] == "Vendedor Almacen" || $_SESSION["rol_dashboard"] == "Vendedor Almacen ") {
				
				/*==========================================
				=            CUERPO DEL SISTEMA            =
				==========================================*/
				
				if (isset($_GET["ruta"])) {

					if ($_GET["ruta"] == "administracion" ||
						$_GET["ruta"] == "inicio" ||
						$_GET["ruta"] == "end-close" ||
						$_GET["ruta"] == "ventas-dia" ||
						$_GET["ruta"] == "ventas-nueva" ||
						$_GET["ruta"] == "ventas-pagos"){

						include 'modulos/'.$_GET["ruta"].".php";

					} else {

						include 'modulos/404.php';

					}

				} else {

					include 'modulos/inicio.php';

				}

			} else if ($_SESSION["rol_dashboard"] == "Vendedor Externo") {
				/*==========================================
				=            CUERPO DEL SISTEMA            =
				==========================================*/
				
				if (isset($_GET["ruta"])) {

					if ($_GET["ruta"] == "end-close" ||
						$_GET["ruta"] == "inicio" ||
						$_GET["ruta"] == "vendedorExt-cancelacion" ||
						$_GET["ruta"] == "vendedorExt-entregas" ||
						$_GET["ruta"] == "vendedorExt-pedidos" ||
						$_GET["ruta"] == "vendedorExt-pedidos-pagos" ||
						$_GET["ruta"] == "vendedorExt-pedidos-generar" ||
						$_GET["ruta"] == "vendedorExt-pedidos-pagos-aprobar" ||
						$_GET["ruta"] == "vendedorext-pedidos-dia" ||
						$_GET["ruta"] == "vendedorExt-pedidos-pagos-configuracion" ||
						$_GET["ruta"] == "vendedorExt-pedidos-cortes" ||
						$_GET["ruta"] == "vendedorExt-pedidos-pagos-historial"){

						include 'modulos/'.$_GET["ruta"].".php";

					} else {

						// include 'modulos/404.php';

					}

				}else {

					include 'modulos/inicio.php';

				}
			
			} else if ($_SESSION["rol_dashboard"] == "Vendedor Matriz") {
				/*==========================================
				=            CUERPO DEL SISTEMA            =
				==========================================*/
				
				if (isset($_GET["ruta"])) {

					if ($_GET["ruta"] == "end-close" ||
						$_GET["ruta"] == "inicio" ||
						$_GET["ruta"] == "cedis-crear-venta" ||
						$_GET["ruta"] == "cedis-ventas" ||
						$_GET["ruta"] == "cedis-ventas-dia" ||
						$_GET["ruta"] == "cedis-ventas-link" ||
						$_GET["ruta"] == "cedis-ventas-pagos" ||
						$_GET["ruta"] == "cedis-ventas-pagos-clientes" ||
						$_GET["ruta"] == "facturacion-cedis-nueva" ||
						$_GET["ruta"] == "cedis-ventas-pagos-historial"){

						include 'modulos/'.$_GET["ruta"].".php";

					} else {

						// include 'modulos/404.php';

					}

				}else {

					include 'modulos/inicio.php';

				}
			} else if ($_SESSION["rol_dashboard"] == "Administrador Registro"){
				if (isset($_GET["ruta"])) {

					if ($_GET["ruta"] == "regEmpAdmin" ||
						$_GET["ruta"] == "end-close" ||
						$_GET["ruta"] == "inicio" ){

						include 'modulos/'.$_GET["ruta"].".php";

					} else {

						// include 'modulos/404.php';

					}

				} else {

					include 'modulos/inicio.php';

				}
			}

		} else {

			if (isset($_GET["ruta"])) {

				if ($_GET["ruta"] == "end-close" ||
					$_GET["ruta"] == "administracion"){

					include 'modulos/'.$_GET["ruta"].".php";

				} else {

					include 'modulos/404.php';

				}

			} else {

				include 'modulos/administracion.php';

			}
			

		}
	

	echo '</div>';

} else { 

//echo '<body class="hold-transition login-page">';
echo '<body class="hold-transition login-page" style="overflow: hidden;">';
	


	include 'modulos/login.php';

	

}
?>

</body>
	<!--============================
	=            SCRIPTS           =
	=============================-->

	<!-- Bootstrap 4 -->
	<script src="../items/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- SweetAlert2 -->
  	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.4/dist/sweetalert2.all.min.js" charset="utf-8"></script>
  	<!-- Toastr -->
	<script src="../items/plugins/toastr/toastr.min.js"></script>
	<!-- DataTables -->
	<script src="../items/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../items/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../items/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../items/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	
	<script src="../items/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../items/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
	<script src="../items/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="../items/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="../items/plugins/jszip/jszip.min.js"></script>
	<script src="../items/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="../items/plugins/pdfmake/vfs_fonts.js"></script>
	
	<!-- AdminLTE App -->
	<script src="../items/dist/js/adminlte.min.js"></script>
	<!-- AdminLTE ChartJS -->
	<script src="../items/plugins/chart.js/Chart.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../items/dist/js/demo.js"></script>
	<!-- Ekko Lightbox --> 
	<script src="../items/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<!-- Filterizr-->
	<script src="../items/plugins/filterizr/jquery.filterizr.min.js"></script>
	<!-- Select2 -->
	<script src="../items/plugins/select2/js/select2.full.min.js"></script>
	<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
	<!-- InputMask -->
	<script src="../items/plugins/moment/moment.min.js"></script>
	<script src="../items/plugins/inputmask/jquery.inputmask.min.js"></script>

	<!-- FIREBASE -->
	<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-auth.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-firestore.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-storage.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-database.js"></script>
    <script src="../items/js/firestore-config.js"></script>
    <script src="../items/js/configuracion-dimensionar-Imagen.js"></script>

	    <!--========================================
		=            SCRIPTS PERSONALES            =
		=========================================-->
		<script src="vistas/js/almacenes.js"></script>
		<script src="vistas/js/administrador.js"></script>
		<!-- <script src="vistas/js/select.js"></script>	 -->
		<script src="vistas/js/clientes_empresa.js"></script>
		<script src="vistas/js/configuracion_tienda.js"></script>
		<!-- <script src="vistas/js/cedis_crear_venta.js"></script> -->
		<!-- <script src="vistas/js/cedis_pagos.js"></script>
		<script src="vistas/js/cedis_ventas.js"></script> -->
		<script src="vistas/js/cedis-step-progress.js"></script>
		<!-- <script src="vistas/js/crear_venta.js"></script> -->
		<script src="vistas/js/dashboard.js"></script>
		<!-- <script src="vistas/js/embarcaciones.js"></script> -->
		<!-- <script src="vistas/js/modulo-facturacion.js"></script> -->
		<script src="vistas/js/pedidos.js"></script>
		<script src="vistas/js/plantillas_tienda.js"></script>
		<script src="vistas/js/productos.js"></script>
		<!-- <script src="vistas/js/productos_almacen.js"></script> -->
		<script src="vistas/js/productos_caracteristicas.js"></script>
		<script src="vistas/js/productos_masiva.js"></script>
		<script src="vistas/js/productos_tienda.js"></script>
		<script src="vistas/js/productos_tienda_categorias.js"></script>
		<script src="vistas/js/proveedores.js"></script>
		<script src="vistas/js/usuarios.js"></script>
		<!-- <script src="vistas/js/ventas.js"></script> -->
		<!-- <script src="vistas/js/ventas_pagos.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-pedidos.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-entregas.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-pedidos-pagos.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-pedidos-generar.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-pedidos-pagos-aprobar.js"></script> -->
		<!-- <script src="vistas/js/vendedorext-pedidos-dia.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-pedidos-cortes.js"></script> -->
		<!-- <script src="vistas/js/vendedorExt-pedidos-pagos-configuracion.js"></script> -->

		<script src="vistas/js/demos/persuit.js"></script>

		<script src="https://cdn.datatables.net/plug-ins/1.10.25/api/sum().js"></script>
		<script src="vistas/js/configuracion_venta.js"></script>
		<script src="vistas/js/cedis_devoluciones.js"></script>
		
	<!--====  End of SCRIPTS  ====-->
</html>