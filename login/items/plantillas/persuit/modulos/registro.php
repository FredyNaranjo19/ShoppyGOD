<?php
	include 'fix/header.php';
?> 

<!--================Categories Banner Area =================-->
<section class="solid_banner_area Bannerregistro">
    <div class="container">
        <div class="solid_banner_inner">
            <h3></h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="login">Login</a></li>
                <li><a href="registro">Registro</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->

<!--================login Area =================-->
<section class="login_area p_100">
    <div class="container">
        <div class="login_inner"> 
            <div class="row">
                <div class="col-lg-4">
                    <img src="<?php
                                if($respuestaConfiguracion != false){ 
                                    if($imagenes['PersuitRegistroUrl'] != ''){
                                        echo $imagenes['PersuitRegistroUrl'] ;
                                    } else {
                                        echo '../persuit/img/registro.jpeg';
                                    } 
                                } else {
                                    echo '../persuit/img/registro.jpeg';
                                }
                                ?>" width="100%" height="100%">
                </div>
                <div class="col-lg-8">
                    <div class="login_title">
                        <h2>Crear Cuenta</h2>
                        <p>Siga los pasos a continuación para crear una cuenta de correo electrónico en nuestra página web</p>
                    </div>
                    <form id="formRegistroTienda" class="login_form row" method="POST"> 
                        <input type="hidden" id="nEmpresaCliente" value="<?php echo $empresa["id_empresa"] ?>">
                        <div class="col-lg-6 form-group">
                            <input class="form-control" type="text" placeholder="Nombre" id="nNombreCliente" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <input class="form-control" type="text" placeholder="Usuario" id="nUsuarioCliente" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <input class="form-control" type="email" placeholder="Email" id="nCorreoCliente" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <input class="form-control" type="text" placeholder="Teléfono" id="ntelCliente" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <input class="form-control" type="password" placeholder="Password" id="nPassCliente" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <input class="form-control" type="password" placeholder="Re-Password" id="nPassClienteVerificar">
                        </div>
                        <div class="col-lg-12 form-group">
                            <button type="submit" value="submit" class="btn subs_btn form-control">Registrarse</button>
                        </div>

                    </form>
                </div>
            </div>
        </div> 
    </div>
</section>
<!--================End login Area =================-->

<?php
    include 'fix/redes.php';
    include 'fix/footer.php';
?>