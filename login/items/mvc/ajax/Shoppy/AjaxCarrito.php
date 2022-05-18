<?php

class AjaxShCarrito{

    public $idAgregarProducto;
    public $cantidad;
    public $empresa;
    public $modelo;
    public $proveedor;

    public function AjaxShCarritoAgregar(){
        $tabla = "sh_carrito";
        $can = $this -> cantidad;
        $datos = array("id_producto" => $this ->idAgregarProducto, "id_empresa" => $this -> empresa, "opcion" => 1);

        $verificacion = ShCarrito::ShMostrarCarrito($tabla, $datos);

        if(sizeof($verificacion) == 0){

            $datosCrear = array("id_producto" => $this -> idAgregarProducto, "id_empresa" => $this -> empresa, "cantidad" => $this -> cantidad, "modelo" => $this -> modelo, "id_proveedor" => $this -> empresa);

            $respuesta = ShCarrito::shAgregarProductoCarrito($tabla, $datosCrear);
        }
        echo json_encode($respuesta);
    }

    public $CantidadDetalleProducto;
    public $codigoDetalleProducto;
    public $empresaDetalleProducto;

    public function AjaxShCambioPrecioEnvio(){
        $tabla = "sh_productos_listado";
        $cantidad = $this -> cantidadDetalleProducto;
        $datos = array("id_proveedor" => $this -> empresaDetalleProducto, "codigo" => $this -> codigoDetalleProducto);
        
    }

    public $idAgregarProductoEditar;
	public $cantidadEditar;
	public $idEmpresaEditar;

	public function ajaxCarritoEditar(){

		$tabla = "sh_carrito";

		$datos = array("id_producto" => $this -> idAgregarProductoEditar,
						"id_empresa" => $this -> idEmpresaEditar,
						"cantidad" => $this -> cantidadEditar);

		$respuesta = ShCarrito::shModificarProductoCarrito($tabla, $datos);
			
		echo json_encode($respuesta);
		

	}
}