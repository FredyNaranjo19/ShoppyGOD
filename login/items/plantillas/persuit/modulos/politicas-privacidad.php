<?php
    include 'fix/header.php';
?> 

<!--================login Area =================-->
<section class="login_area p_100"> 
    <div class="container">
        <div class="login_inner">
            <center><h2>Políticas de privacidad</h2></center>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <span>
                        <?php echo str_replace("\n", "<br>", $respuestaPoliticas["texto"]);  ?>
                    </span>
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