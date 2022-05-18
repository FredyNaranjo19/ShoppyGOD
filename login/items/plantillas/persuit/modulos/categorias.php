<?php
    include 'fix/header.php';
?> 

<!--================login Area =================-->
<section class="login_area p_100"> 
    <div class="container">
        <!-- <div class="login_inner"> -->
        <center><h2>Categorías y Subcategorías</h2></center>
        <hr>
        <div class="row">
        <?php
        $item = NULL;
        $valor = NULL;
        $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor, $empresa["id_empresa"]);

            foreach ($categorias as $key => $value) {
        ?>
            <div class="col-md-3" style="margin-bottom: 15px;">

                <div class="cateImagen" style="width: 100%;height: 200px;">
                    <?php if ($value["imagen"] != ""){ ?>
                        <img src="<?php echo $value["imagen"] ?>" alt="" style="width: 100%;height: 100%; object-fit: scale-down;">
                    <?php } else { ?>
                        <img src="../items/img/Categoria.png" alt="" style="width: 100%;height: 100%; object-fit: scale-down;">                     
                    <?php } ?>
                </div>

                
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="input-group">
                            <!-- <input type="text" class="form-control" aria-label="..."> -->
                            <a href="<?php echo 'index.php?ruta=extraccion&&ca145te687go='.$value["nombre"].'&&nt4e54sv3=184&&isid45='.$value["id_categoria"]; ?>" type="button" class="btn update_btn btn-block" style="padding: 0; margin: 0;">
                                <?php echo $value["nombre"] ?> 
                            </a>
                            <?php
                            $item = "id_categoria";
                            $valor = $value['id_categoria'];
                            $sub = ControladorCategorias::ctrMostrarSubCategorias($item, $valor);

                                if(sizeof($sub)>0){
                            ?>

                                <div class="input-group-btn">
                                    <button type="button" class="btn update_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">

                                    <?php foreach ($sub as $kay => $val) { 

                                        echo '<li class="menuLi" style="text-align: center; width:100%">
                                                <a href="index.php?ruta=extraccion&&sub244ca747te='.$val["nombre"].'&&nt4e54sv3=184&&isSubid='.$val["id_subcategoria"].'"> 
                                                    '.$val["nombre"].'
                                                </a>
                                            </li>';

                                    } ?>

                                    </ul>
                                </div>

                            <?php
                                }
                            ?>
                        </div>
                    </div>
                        
                </div>
            </div>


        <?php
            }
        ?>

        </div>
        <!-- </div> -->
    </div>
</section>
<!--================End login Area =================-->

<?php
    include 'fix/redes.php';
    include 'fix/footer.php';
?>