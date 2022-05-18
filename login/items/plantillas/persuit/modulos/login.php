<?php
	include 'fix/header.php';


$user_agent = $_SERVER['HTTP_USER_AGENT'];


function getBrowser($user_agent){

 if(strpos($user_agent, 'FB_IAB') !== FALSE)
  return 'Facebook WEB';
 else
  return 'nada';

}

$navegador = getBrowser($user_agent);
?> 

<!--================Categories Banner Area =================-->
<section class="solid_banner_area">
    <div class="container">
        <div class="solid_banner_inner">
            <h3>Login</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="login">Login</a></li>
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
                    <div class="login_title">
                        <h2>INICIA SESIÓN EN TU CUENTA</h2>
                        <p>Inicie sesión en su cuenta para descubrir todas las excelentes promociones y precios de nuestros productos.</p>
                    </div>
                    <form class="login_form row" method="POST">
                    <?php
                            if ($navegador != "Facebook WEB") {
                    ?>
                        <div class="col-lg-12 form-group">
                            <button type="button" class="btn update_btn form-control btnGoogleSesion" style="background: red; color: white;margin-top: 10px;">
                                <i class="fa fa-google-plus"></i> Iniciar sesión
                            </button>
                        </div>
                        <div class="col-lg-12 form-group">
                            <button type="button" class="btn update_btn form-control btnFacebookSesion" style="background: #385596; color: white;margin-top: 10px;">
                                <i class="fa fa-facebook-square"></i> Iniciar sesión
                            </button>
                        </div>
                        <br>
                        <br>
                        <div class="col-lg-12">
                            <center>---------------------<b> Ó </b>---------------------</center>
                        </div>
                        <br>
                        <br>
                    <?php
                        }
                    ?>
                        <input type="hidden" name="ingEmpresa" id="ingEmpresa" value="<?php echo $empresa["id_empresa"] ?>">
                        <div class="col-lg-12 form-group">
                            <input class="form-control" type="email" name="ingCorreo" placeholder="Correo electronico">
                        </div>
                        <div class="col-lg-12 form-group">
                            <input class="form-control" type="password" name="ingPassword" placeholder="Password">
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="creat_account">
                            </div>
                        </div>
                        <div class="col-lg-12 ">
                            <button type="submit" class="btn update_btn form-control">Iniciar</button>
                        </div>
                        
                        

                    <?php

                        $login = new ControladorClientes();
                        $login -> ctrIngresarCliente();

                    ?>

                    </form>
 
                    <div class="row" >
                        <div class="col-lg-12" style="text-align: center; font-size:1.2em">
                            Aun no tienes cuenta!
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-lg-12">
                            <a href="registro" class="btn update_btn form-control" style="color:red">Registrate</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <img src="<?php
                            if($respuestaConfiguracion != false){ 

                                if($imagenes['PersuitSesionUrl'] != ''){

                                    echo $imagenes['PersuitSesionUrl'];

                                } else {

                                    echo '../persuit/img/login.jpeg';

                                } 
                            } else {

                                echo '../persuit/img/login.jpeg';

                            }?>" width="100%">
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