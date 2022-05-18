

<section>
    <div id="inicio" class="contenedores">
        <script>
            console.log("Login");
        </script>
        


        <div class="transicion">
            <div class="transcont">
                <span class="blink_me2" id="rotate2">
                    <span>
                        <div class="d-flex">
                            <img class="img" src="../items/img/login/UNO.png" alt="">
                            <div class="texto">
                                <div class="d-flex">
                                    <h1 class="texto1">la mejor</h1>
                                    <h1 class="texto2 ml-3">opcion</h1>
                                </div>
                                <div class="d-flex">
                                    <h1 class="texto2">para tu</h1>
                                    <h1 class="texto1 ml-3">negocio.</h1>
                                </div>
                            </div>
                        </div>
                    </span>
                    <span>
                        <div class="d-flex">
                            <img class="img" src="../items/img/login/DOS.png" alt="">
                            <div class="texto">
                                <div class="d-flex">
                                    <h1 class="texto2">Accede</h1>
                                    <h1 class="texto1 ml-3">desde</h1>
                                </div>
                                <div class="d-flex">
                                    <h1 class="texto1">cualquier</h1>
                                    <h1 class="texto2 ml-3">lugar.</h1>
                                </div>
                            </div>
                        </div>
                    </span>
                    <span>
                        <div class="d-flex">
                            <img class="img" src="../items/img/login/TRES.png" alt="">
                            <div class="texto">
                                <div class="d-flex">
                                    <h1 class="texto1">Logra</h1>
                                    <h1 class="texto2 ml-3">una mejor</h1>
                                </div>
                                <div class="d-flex">
                                    <h1 class="texto2">gestion</h1>
                                    <h1 class="texto1 ml-3">administrativa.</h1>
                                </div>
                            </div>
                        </div>
                    </span>
                    <span>
                        <div class="d-flex">
                            <img class="img" src="../items/img/login/CUATRO.png" alt="">
                            <div class="texto">
                                <div class="d-flex">
                                    <h1 class="texto2">Controla</h1>
                                    <h1 class="texto1 ml-3">todo desde</h1>
                                </div>
                                <div class="d-flex">
                                    <h1 class="texto1">un mismo</h1>
                                    <h1 class="texto2 ml-3">lugar.</h1>
                                </div>
                            </div>
                        </div>
                    </span>                        
                </span>
            </div>
        </div>


      <form action="#" method="POST">
        <div class="loginbar">
            <a href="index.php">
                <div style="display:grid; justify-items: center;">
                    <img style="height:50px; width: 50px; margin-top: 50px;" src="../items/img/login/svg/Logo-Azul.svg" alt="">
                    <img style="height:50px; width: 100px; margin-top: 10px;" src="../items/img/login/svg/Yira-Blanco.svg" alt="">
                </div>
            </a>
            <h5 class="usrcont">Usuario</h5>
            <img style="height: 25px; margin-bottom: 10px;" src="../items/img/login/USUARIOS.png" alt="">
            <!-- <input class="imputlogin" type="text"> -->
            <input id="emaillogin" type="email" class="imputlogin" name="emailDashboard" placeholder="Email">
            <h5 class="usrcont">Contraseña</h5>
            <img style="height: 25px; margin-bottom: 10px;" src="../items/img/login/CONTRASEÑA.png" alt="">
            <!-- <input class="imputlogin" type="text"> -->
            <input id="paswordlogin" type="password" class="imputlogin" name="passwordDashboard" placeholder="Password">
            <!-- <button style="margin-top: 25px;" class="btn btn-dark">Iniciar</button> -->
            <button id="log" style="margin-top: 25px; background-color:#00b4d8; color:white;" class="btn">Iniciar</button>
            <div class="d-flex mt-5 Fb-Wh">
                <div class="mx-2 fb">
                    <a href="https://www.facebook.com/yiramexico" target="_blank"><img style="height:40px" src="../items/img/login/svg/Facebook-Azul.svg" alt=""></a>
                    <h4 class="txt3f">@yiramexico</h4>
                </div>
                <div class="mx-2 wh">
                    <a href="https://api.whatsapp.com/send?phone=7715565754&text=hola,%20me%20gustaría%20recibir%20mas%20información%20sobre%20yira" target="_blank"><img class="whatsappIcono" src="../items/img/login/svg/Whatsapp-Azul.svg" alt=""></a>
                    <h4 class="txt3f" >whatsapp</h4>
                </div>
            </div>
        </div>
        <?php
          $iniciar = new ControladorUsuarios();
          $iniciar -> ctrIngresarDashboard();
        ?>
      </form>

    </div>
</section>
<script>
            
    $(document).on("click", "#log", function(){
        //alert("joa");
        console.log("read");
    })

            
</script>

<!-- 
<style>
    .transicion{
        max-width:100vw;
        height: 100%; 
        overflow: hidden;
    }
    .transcont{
        width: 98vw;
        height: 100%;
        display: grid;
        justify-items: center;
    }
    .blink_me2 {
        position: absolute;
        display: inline-block;
        vertical-align: bottom;
        animation: blinker 10s linear infinite;
        animation-delay: 5s;
        left: 0%;
    }
  
    .blink_me2 span {
        float: left;
        font-size: xxx-large;
        overflow: hidden;
        font-family: 'Montserrat';
        font-weight: 600;
        animation: hideShow 40s linear infinite;
    }
  
    .blink_me2 span:nth-child(1) { animation-delay: -0s; }
    .blink_me2 span:nth-child(2) { animation-delay: -10s; }
    .blink_me2 span:nth-child(3) { animation-delay: -20s; }
    .blink_me2 span:nth-child(4) { animation-delay: -30s; }
    .d-flexl{
        display: flex;
    }
    .d-flexl{
        display: unset;
    }
    .texto{
      align-self: center;
      margin-left: 2rem;
    }
    .texto1{
      font-family: 'Montserrat';
      font-size: xxx-large;
    }
    .texto2{
        font-family: 'Montserrat';
        font-weight: 700;
        font-size: xxx-large;
    }
    @media only screen and (max-width: 850px) {
        .texto{
            display: none;
        }
        .contenedores{
            overflow: hidden;
        }
        .img{
            opacity: .8;
            margin-left: 5rem;
        }
    }
</style> -->