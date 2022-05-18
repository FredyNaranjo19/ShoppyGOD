<?php
if (!isset($_SESSION['iniciarSesion']) && $_SESSION['iniciarSesion'] != "ok"){

    header("Location:login");

}

include 'fix/header.php';

?>

<!--================Categories Banner Area =================-->
<section class="solid_banner_area">
    <div class="container">
        <div class="solid_banner_inner">
            <h3>ESTATUS PAGO</h3>
            <ul>
                <li><a href="inicio">Inicio</a></li>
                <li><a href="#">Estado</a></li>
            </ul>
        </div>
    </div>
</section>
<!--================End Categories Banner Area =================-->
<!--================login Area =================-->
<section class="emty_cart_area p_100">
    <div class="container">
        <div class="emty_cart_inner">
            <i class="icon_check_alt icons"></i>
            <h3>OPERACION EXITOSA</h3>

            <h4>volver a <a href="inicio">Inicio</a></h4>
            <br>
            <p style="color:red;font-weight: bold;font-size: 1.7em">Una vez realizado tu pago, es importante que subas tu comprobante de pago en la sección de <a type="button" class="btn btn-primary" href="historial">mis compras.</a></p>
            <br>
            <p style="color: #66CBFF;font-weight: bold;font-size: 1.5em">Te recomendamos que lo subas en el menor tiempo posible para evitar incovenientes en la existencia de los productos</p>
        </div>
    </div>

    <br>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Anotaciones:</span>
                            <textarea  class="form-control input-lg" id="AnotacionPedido"  placeholder="Escribe anotaciones sobre tu pedido"></textarea>
                            <input type="hidden" class="folioAnotacionPedido" value="<?php echo $_GET["folfo"] ?>">
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <button class="btn btn-primary btn-block btnGuardarAnotaciones">Agregar</button>
                </div>
            </div>
        </div>
</section>
<!--================End login Area =================-->

<?php
	include 'fix/footer.php';
?>