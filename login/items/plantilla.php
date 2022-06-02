<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Yira Proveedores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="plantillas/Shoppy/Shoppy/images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/css/util.css">
	<link rel="stylesheet" type="text/css" href="plantillas/Shoppy/Shoppy/css/main.css">
<!--===============================================================================================-->
</head>

<body class="animsition">
    <?php
	include 'plantillas/Shoppy/Shoppy/nav-menu.php';
    if (isset($_GET["ruta"])) {
            if (
                $_GET['ruta'] == "contact" ||
                $_GET['ruta'] == "index" ||
                $_GET['ruta'] == "product" ||
				$_GET['ruta'] == "categorie" ||
				$_GET['ruta'] == "categories" ||
                $_GET['ruta'] == "product-detail" ||
                $_GET['ruta'] == "proveedor" ||
                $_GET['ruta'] == "Proveedores" ||
                $_GET['ruta'] == "shopping-cart"
            ) {
           
            include 'plantillas/Shoppy/Shoppy/' . $_GET["ruta"] . '.php';
        } else {
            include 'plantillas/Shoppy/Shoppy/Error404.php';
        }
    } else {
        include 'plantillas/Shoppy/Shoppy/index.php';
    }
    ?>

	<?php
	include 'plantillas/Shoppy/Shoppy/Footer.php';
	?>


    <!--===============================================================================================-->	
	<script src="plantillas/Shoppy/Shoppy/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/bootstrap/js/popper.js"></script>
	<script src="plantillas/Shoppy/Shoppy/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/daterangepicker/moment.min.js"></script>
	<script src="plantillas/Shoppy/Shoppy/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/slick/slick.min.js"></script>
	<script src="plantillas/Shoppy/Shoppy/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/parallax100/parallax100.js"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "Fue agregado a tu wishlist", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "Fue agregado a tu wishlist", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "Fue agregado al carrito", "success");
			});
		});
	
	</script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="plantillas/Shoppy/Shoppy/js/main.js"></script>
   
</body>

</html>