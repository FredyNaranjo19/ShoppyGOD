<footer class="footer_area box_footer">
    <div class="container">
        <div class="footer_widgets"> 
            <div class="row"> 
                <div class="col-lg-4 col-xs-12">
                    <aside class="f_widget f_about_widget">
                        <img src="<?php echo $logo['imagen'] ?>" alt="">
                        <p></p>
                        <h6>Social:</h6> 
                        <ul>
                        <?php
                            if ($respuestaMisRedes != false) {
                                if ($respuestaMisRedes["facebook"] != '') {
                                    echo '<li><a href="'.$respuestaMisRedes["facebook"].'"><i class="social_facebook"></i></a></li>';
                                }
                                if ($respuestaMisRedes["instagram"] != '') {
                                    echo '<li><a href="'.$respuestaMisRedes["instagram"].'"><i class="social_instagram"></i></a></li>';
                                }
                                if ($respuestaMisRedes["twitter"] != '') {
                                    echo '<li><a href="'.$respuestaMisRedes["twitter"].'"><i class="social_twitter"></i></a></li>';
                                }
                                if ($respuestaMisRedes["youtube"] != '') {
                                    echo '<li><a href="'.$respuestaMisRedes["youtube"].'"><i class="social_youtube"></i></a></li>';
                                }
                                if ($respuestaMisRedes["tiktok"] != '') {
                                    echo '<li><a href="'.$respuestaMisRedes["tiktok"].'"><i class="social_tiktok"></i></a></li>';
                                }
                            }
                        ?>
                            
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-xs-12 textFooter">
                    <aside class="f_widget link_widget f_account_widget">
                        <div class="f_w_title">
                            <h3>Mi cuenta</h3>
                        </div>
                        <ul>
                            <?php
                            if (isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] == "ok") {
                            ?>
                                <li><a href="history-order">Mis compras</a></li>
                                <li><a href="wish">Lista de deseos</a></li>
                                <li><a href="end-session">Cerrar sesión</a></li>
                            <?php
                            } else {
                            ?>
                                <li><a href="login">Iniciar sesión</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </aside>
                </div>
                <?php if ($respuestContactoEmpresa != false) { ?>
                <div class="col-lg-3 col-xs-12 textFooter">
                    <aside class="f_widget link_widget f_account_widget">
                        <div class="f_w_title">
                            <h3>Contacto</h3>
                        </div>
                        <ul>
                        <?php
                            if ($respuestContactoEmpresa["telefono"] != "0") {
                                echo '<li>
                                    <a href="tel:'.$respuestContactoEmpresa["telefono"].'" title="Teléfono de contacto">
                                        <i class="fa fa-phone"></i> '.$respuestContactoEmpresa["telefono"].'
                                    </a>
                                </li>';
                            }

                            if ($respuestContactoEmpresa["mail"] != "") {
                                echo '<li>
                                    <a href="mailto:'.$respuestContactoEmpresa["mail"].'" title="Teléfono de contacto">
                                        <i class="fa fa-envelope"></i> '.$respuestContactoEmpresa["mail"].'
                                    </a>
                                        
                                </li>';
                            }
                        ?>
                        </ul>
                    </aside>
                </div>
            <?php } ?>
                <div class="col-lg-2 col-xs-12 textFooter">
                    <aside class="f_widget link_widget f_account_widget">
                        <div class="f_w_title">
                            
                        </div>
                        <ul>
                        <?php if ($respuestaTerminos != false) { ?>
                            <li>
                                <a href="terminos-condiciones" title="Terminos y Condiciones">
                                    Términos y Condiciones.
                                </a>
                            </li>
                        <?php } 
                            if ($respuestaPoliticas != false) {
                        ?>
                            <li>
                                <a href="politicas-privacidad" title="Políticas de Privacidad">
                                    Políticas de privacidad.
                                </a>
                            </li>
                        <?php 
                            }
                        ?>
                        </ul>
                    </aside>
                </div>
                
            </div>
        </div>
    </div>
</footer>