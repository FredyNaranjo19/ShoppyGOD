<div class="p_color">

    <h5 class="p_d_title">Opciones</h5>

    <div class="col-md-12 divTableDerivados">
        <table class="table" style="width: 100%;">
            <thead>
                <th style="width: 30%;">
                    Imagen
                </th>
                <th>
                    Caracteristicas
                </th>
                <th>
                    Accion
                </th>
            </thead>
            <tbody>
                <?php
                
                    $datos = array("codigo" => $producto["codigo"],
                                    "sku" => $producto["sku"],
                                    "id_producto" => $producto["id_producto"],
                                    "id_empresa" => $empresa["id_empresa"]);
                                    //var_dump($datos);

                    $resultCaracteristicas = ControladorProductos::ctrMostrarProductosDerivados($datos);
                    //var_dump($resultCaracteristicas);

                    foreach ($resultCaracteristicas as $key => $val) {

                        echo '<tr>
                                <td>
                                    <img src="'.$val["imagen"].'" style="width: 100%; height: 30px; object-fit: scale-down;">
                                </td>
                                    <td>';

                        if ($val["caracteristicas"] != NULL && $val["caracteristicas"] != "[]") {
                            # code...
                        
                            $caracteristicas = json_decode($val["caracteristicas"], true);


                            foreach ($caracteristicas as $k => $value1) {
                                
                                $option = "";
                                if ($k <= 2) {

                                   if ($value1["caracteristica"] == "Color") {

                                       $option .= $value1["caracteristica"].': <i class="fa fa-circle" 
                                                                                style="border: 2px solid gray; 
                                                                                       border-radius: 50px; 
                                                                                       background: '.$value1["datoCaracteristica"].'; 
                                                                                       color: '.$value1["datoCaracteristica"].';">
                                                                                </i>, ';

                                   } else {

                                        $option .= $value1["caracteristica"].": ".$value1["datoCaracteristica"].", ";

                                   }

                                }
                            
                            }
                            $option = substr($option, 0, -2);

                            echo $option;

                        }

                        echo '      
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btnViewDerivado btn-sm" pR06412="'.$val["id_producto"].'" cod="'.$val["codigo"].'"><i class="fa fa-eye"></i></button>
                                </td>
                            </tr>';

                    }

                ?>
            </tbody>
        </table>
    </div>

    

</div>


<?php



?>