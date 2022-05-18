<style>

.offcanvas_menu .nav li a{
	color: <?php echo $colores[0]['letrasMenu'] ?>;
}
.offcanvas_menu .nav li:hover a {
  color: <?php echo $colores[0]["letrasMenuSobre"] ?>;
}

.shop_header_area .navbar .navbar-nav li a{
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}
.shop_header_area .navbar .navbar-nav li:hover a, .shop_header_area .navbar .navbar-nav li.active a {
  color: <?php echo $colores[0]["letrasMenuSobre"] ?>;
}

.home_left_main_area .left_menu{
  background: <?php echo $colores[0]['MenuFondo'] ?>;
}

/*=============================================
=           BOTON DE SHOPPING CART            =
=============================================*/

.cart_list ul{
  border: 1px solid <?php echo $colores[0]['letrasMenu'] ?>;
}

.cart_list ul li.cart_icon a{
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}

.cart_list ul li.cart_icon a:hover{
  color: <?php echo $colores[0]["letrasMenuSobre"] ?>;
}

/*=====  End of BOTON DE SHOPPING CART  ======*/


.offcanvas_fixed_menu .search_form .btn.btn-secondary{
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}

.offcanvas_fixed_menu .search_form input {
  border: 1px solid <?php echo $colores[0]['letrasMenu'] ?>;
  color: <?php echo $colores[0]['letrasMenuSobre'] ?>;
}


.offcanvas_fixed_menu .search_form input.placeholder {
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}

.offcanvas_fixed_menu .search_form input:-moz-placeholder {
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}

.offcanvas_fixed_menu .search_form input::-moz-placeholder {
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}

.offcanvas_fixed_menu .search_form input::-webkit-input-placeholder{
  color: <?php echo $colores[0]['letrasMenu'] ?>;
}




@media (min-width: 992px) {
  .offcanvas_menu .nav li.side_menu .dropdown-menu {
    background: <?php echo $colores[0]['MenuFondo'] ?>;
    
  }
  .offcanvas_menu .nav li.side_menu .dropdown-menu li.side_subMenu .dropdown-subMenu{
    background: <?php echo $colores[0]['SubmenuFondo'] ?>;
  }

  .shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu {
    background: <?php echo $colores[0]['MenuFondo'] ?>;
  }

  .shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu li.submenu2 .dropdown-subMenu{
    background: <?php echo $colores[0]['SubmenuFondo'] ?>;
  }
}




.offcanvas_menu .nav li.side_menu .dropdown-menu li a{
  color: <?php echo $colores[0]['letrasSubmenu'] ?>;
}
.offcanvas_menu .nav li.side_menu .dropdown-menu li:hover a {
  color: <?php echo $colores[0]['letrasSubmenuSobre'] ?>;
}

.offcanvas_menu .nav li.side_menu .dropdown-menu li.side_subMenu .dropdown-subMenu a{
  color: <?php echo $colores[0]['letrasSubmenu'] ?>;
}
.offcanvas_menu .nav li.side_menu .dropdown-menu li.side_subMenu .dropdown-subMenu li:hover a {
  color: <?php echo $colores[0]['letrasSubmenuSobre'] ?>;
}


.shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu li a {
  color: <?php echo $colores[0]['letrasSubmenu'] ?>;
}

.shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu li:hover a, .shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu li.active a {
  color: <?php echo $colores[0]['letrasSubmenuSobre'] ?>;
}


.shop_header_area .navbar .navbar-nav li:hover.submenu .dropdown-menu li.submenu2 .dropdown-subMenu a {
  color: <?php echo $colores[0]['letrasSubmenu'] ?>;
}


.shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu li.submenu2 .dropdown-subMenu li:hover a,
.shop_header_area .navbar .navbar-nav li.submenu .dropdown-menu li.active a{
  color: <?php echo $colores[0]['letrasSubmenuSobre'] ?>;
}


.categories_banner_area {
  width: 100%;
  height: 300px;
  background: url(<?php 
                  if($respuestaConfiguracion != false){

                    if($imagenes['PersuitBannersUrl'] != ''){
                        echo $imagenes['PersuitBannersUrl'];
                    } else {
                        echo '../persuit/img/principalBanner.jpeg';
                    } 

                  }else{
                    echo '../persuit/img/principalBanner.jpeg';
                  }
              ?> ) no-repeat scroll center center;
  position: relative;
  z-index: 3;
  background-size: 100% 300px;
}


.solid_banner_area{
  background: url(<?php echo  $imagenes['PersuitBannersUrl'] ?>) no-repeat scroll center center;
  background-size: cover;
  position: relative;
  z-index: 3;
}


/*==========================================
=            ESTILO EN CATALOGO            =
==========================================*/

.dropdown-menu-right .menuLi a{
  color: <?php echo $colores[0]['letrasSubmenu'] ?>;
}

.dropdown-menu-right .menuLi a:hover{
  color: <?php echo $colores[0]['letrasSubmenuSobre'] ?>;
}
/*=====  End of ESTILO EN CATALOGO  ======*/




</style>