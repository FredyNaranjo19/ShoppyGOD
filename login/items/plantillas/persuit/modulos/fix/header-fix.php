<header class="shop_header_area fixed_tb_menu carousel_menu_area">
    <div class="carousel_menu_inner">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="inicio">
                    <img src="<?php echo $logo['imagen'] ?>" alt="" style="width: 200px; height: 70px; object-fit: scale-down;">
                    <!-- logo -->
                </a>
                <?php if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { ?>
                <a href="shopping-cart">
                    <button class="navbar-toggler" type="button" style="height: 40px; width: 50px;">
                        <span class="icon-handbag"> 
                        
                            <p class="noProductos">
                            <?php
                                $datos = array("id_cliente" => $_SESSION["id"],
                                                "opcion" => 3);
                                $respuesta = ControladorCarrito::ctrMostrarCarrito($datos);

                                echo sizeof($respuesta);
                            ?>
                            </p>
                        
                        </span>
                    </button>
                </a>
                <?php } else { ?>
                <a href="login">
                    <button class="navbar-toggler" type="button" style="height: 40px; width: 50px;">
                        <span class="icon-handbag"></span>
                    </button>
                </a>
                <?php } ?>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item SearchBtnLink"><a href="nav-link" href="#" data-toggle="modal" data-target="#modalSearch"><i class="icon-magnifier"></i> Search</a></li>
                        <li class="nav-item active"><a class="nav-link" href="inicio">Inicio</a></li>
                        <li class="nav-item active"><a class="nav-link" href="categorias">Catálogo</a></li>
                        
                        
                    <?php
                    if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {
                    ?>

                        <li class="nav-item dropdown submenu">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_SESSION["userCliente"]; ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="#"><?php echo $_SESSION["nombre"]; ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="historial">Mis compras</a></li>
                                <li class="nav-item"><a class="nav-link" href="wish">Favoritos</a></li>
                                <li class="nav-item"><a class="nav-link" href="salir">Cerrar sesión</a></li>
                            </ul>
                        </li>

                        <li class="nav-item ShoppingBtnLink"><a class="nav-link" href="shopping-cart">Carrito de compras</a></li>

                    <?php } else { ?>

                        <li class="nav-item"><a class="nav-link" href="login">Login</a></li>

                        <li class="nav-item ShoppingBtnLink"><a class="nav-link " href="login" >Carrito de compras</a></li>

                    <?php } ?>


                        

                        
                    </ul>
                    <ul class="navbar-nav justify-content-end">
                        <li class="search_icon">
                            <a href="#" data-toggle="modal" data-target="#modalSearch">
                                <i class="icon-magnifier icons"></i>
                            </a>
                        </li>

                        <li class="cart_cart">
                            <?php if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") { ?>
                                <a href="shopping-cart"><i class="icon-handbag"></i></a>
                            <?php } else { ?>
                                <a href="login"><i class="icon-handbag"></i></a>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<!-- MODAL PARA BUSQUEDA -->

<div id="modalSearch" class="modal fade" role="dialog" >
  <div class="modal-dialog" >
    <div class="modal-content" style="background: transparent; border: none">
        <!--==================================
        =            CUERPO MODAL            =
        ===================================-->
        <div class="modal-body ">

          <div class="box-body">

            <div class="form-group">

                <div class="input-group" style="margin:0; padding: 0;">
                    
                    <input type="text" class="form-control input-sm" id="SearchModalInput" placeholder="Search" required>
                    <span class="input-group-addon btnSearchModal" style="cursor:pointer;"><i class="icon-magnifier"></i></span>
                </div>

            </div>
            

          </div>

        </div>
    </div>
  </div>
</div>