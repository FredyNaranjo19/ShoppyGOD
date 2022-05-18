<div class="left_menu">
    <div class="offcanvas_fixed_menu">
        <a class="logo_offcanvas" href="#">
            <img src="<?php echo $logo['imagen'] ?>" alt="" style="width: 100%; height: 220px; object-fit: scale-down;">
            <!-- logo -->
        </a>
        <div class="input-group search_form">
            <input type="text" class="form-control formBusqueda" placeholder="Search" aria-label="Search">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button"><i class="icon-magnifier icons "></i></button>
            </span>
        </div>
        <div class="offcanvas_menu">
            <ul class="nav flex-column">
                <li class="nav-item active"><a class="nav-link" href="inicio" >Inicio</a></li>
                <li class="nav-item active"><a class="nav-link" href="categorias" >Catálogo</a></li>
            <?php

                if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {

            ?>

                <li class="dropdown side_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["userCliente"]; ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
                        <li class="nav-item"><a class="nav-link" href="historial">Mis compras</a></li>
                        <li class="nav-item"><a class="nav-link" href="wish">Lista de deseos</a></li>
                        <li class="nav-item"><a class="nav-link" href="salir">Cerrar sesión</a></li>
                    </ul>
                </li>

            <?php

                }else{

            ?>

                <li class="nav-item"><a class="nav-link" href="login">Login</a></li>

            <?php

                }

            ?>

            </ul>
        </div>
        <div class="cart_list">
            <ul>
                <?php
                    if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {
                ?>
                    <li class="cart_icon"><a href="shopping-cart"><i class="icon-handbag"></i></a></li>

                <?php
                }else{
                ?>
                    <li class="cart_icon"><a href="login"><i class="icon-handbag"></i></a></li>
                <?php
                }
                ?>

            </ul>
        </div>
    </div>
</div>