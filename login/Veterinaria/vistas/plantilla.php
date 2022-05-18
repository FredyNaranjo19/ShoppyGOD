<?php

include 'vistas/peticiones.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo $logo['imagen'] ?>">
	<title><?php echo $tituloEmpresa ?></title>


	<?php
	if ($configuracionSEO != false) {
		$seo = json_decode($configuracionSEO["metadatos"], true);
	?>

	<meta name="description" content="<?php echo $seo[0]['SEO_Description'] ?>"/>
	<meta name="keywords" content="<?php echo $seo[0]['SEO_Keywords'] ?>"/>
	<meta http-equiv="refresh" content="100000; url=<?php echo $GlobalUrl.$nombreEmpresa ?>"/>

	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo $tituloEmpresa ?>" />
	<meta property="og:description" content="<?php echo $seo[0]['SEO_Description'] ?>" />

	<?php

		if (isset($_GET["pR06412"])) {

			$item = "id_producto";
			$valor = $_GET["pR06412"];

		// 	$producto = ControladorProductos::ctrMostrarProductos($item, $valor, $empresa["id_empresa"]);

		// 	// var_dump($producto);

		// 	$imagenSEO = $producto["imagen"];

		} else {

			$imagenSEO = $logo['imagen'];

		}

		// echo $imagenSEO;

	?>
	<meta property="og:image" content="<?php echo $imagenSEO ?>" />
	<link rel="canonical" href="<?php echo $GlobalUrl.$nombreEmpresa ?>"/>

	<?php } ?>

	

	

	<!--=========================================================================
	=            ******************** LINKS CSS ********************            =
	==========================================================================-->

	<?php
		require_once '../items/plantillas/'.$respuestaPlantilla["nombre"].'/list-css.php';
	?>
</head>
<body> 
<?php
// if ($servicioContratado["estado"] == "Activado") {

	if (isset($_GET["ruta"])) {
		
		if ($_GET['ruta'] == "inicio" ||
            $_GET['ruta'] == "login" ||
            $_GET['ruta'] == "registro" ||
            $_GET['ruta'] == "categorias" ||
            $_GET['ruta'] == "extraccion" ||
            $_GET['ruta'] == "product-details" ||
            $_GET['ruta'] == "shopping-cart" ||
            $_GET['ruta'] == "proccess" ||
            $_GET['ruta'] == "successful" ||
            $_GET['ruta'] == "savePayment" ||
            $_GET['ruta'] == "successfulPayment" ||
            $_GET['ruta'] == "wish" ||
            $_GET['ruta'] == "historial" ||
            $_GET['ruta'] == "link-pago" ||
            $_GET['ruta'] == "PaymentPV" ||
            $_GET['ruta'] == "terminos-condiciones" ||
            $_GET['ruta'] == "politicas-privacidad" ||
            $_GET['ruta'] == "salir") {
			
			include '../items/plantillas/'.$respuestaPlantilla["nombre"].'/modulos/'.$_GET["ruta"].'.php';

		} else {

			include '../items/plantillas/'.$respuestaPlantilla["nombre"].'/modulos/404.php';

		}


	} else {

		include '../items/plantillas/'.$respuestaPlantilla["nombre"].'/modulos/inicio.php';

	}

// } else {

// 	echo '<center><h2>Página en desarrollo</h2></center>';

// }

?>
	<!--====================================================================================
	=            ************************** SCRIPTS JS ************************            =
	=====================================================================================-->

	<?php

		include '../items/plantillas/'.$respuestaPlantilla["nombre"].'/list-js.php';

	?>
</body>
</html>