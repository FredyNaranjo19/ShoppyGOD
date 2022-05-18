<?php
require_once 'items/mvc/modelos/dashboard/modelo.pruebacron.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../items/img/login/svg/Logo-Azul.svg" rel="shortcut icon">
	<title>Dashboard</title>
    <!-- jQuery -->
	<script src="items/plugins/jquery/jquery.min.js"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="items/plugins/jquery-ui/jquery-ui.min.js"></script>


	
</head>
<body class="hold-transition sidebar-mini">
    <?php
$existenciaPaquete = ModeloPCron::mdlpcron();
?>
</body>


		<!-- <script src="dashboard/vistas/js/pruebacron.js"></script> -->
	<!--====  End of SCRIPTS  ====-->
</html>