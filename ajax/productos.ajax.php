<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";
require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";


class AjaxProductos
{
    /*=============================================
    EDITAR PRODUCTO
    =============================================*/

    public $nombreProducto;
    public $nombreProductoSucursal;
    public $nombreSucursal;
    public $traerProductos;

    public function ajaxEditarProducto()
    {

        $item = "producto_nombre";
        $valor = $this->nombreProducto;
        $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);
        echo json_encode($respuesta);
    }

    public function ajaxEditarProductoSucursal()
    {
        /* if ($this->traerProductos == "ok") {
            $item = null;
            $valor = null;
            $sucursal = $this->nombreSucursal;
            $respuesta = ControladorSucursales::ctrMostrarProductosSucursal($item, $valor, $sucursal);
            echo json_encode($respuesta);
        } else { */
        $item = "producto_nombre";
        $valor = $this->nombreProductoSucursal;
        $sucursal = $this->nombreSucursal;
        $respuesta = ControladorSucursales::ctrMostrarProductosSucursal($item, $valor, $sucursal);
        echo json_encode($respuesta);
        //}
    }
}

/*=============================================
EDITAR PRODUCTO
=============================================*/

if (isset($_POST["nombreProducto"])) {

    $editarProducto = new AjaxProductos();
    $editarProducto->nombreProducto = $_POST["nombreProducto"];
    $editarProducto->ajaxEditarProducto();
}
/*=============================================
EDITAR PRODUCTO SUCURSAL
=============================================*/

if (isset($_POST["nombreProductoSucursal"])) {
    $editarProductoSucursal = new AjaxProductos();
    $editarProductoSucursal->nombreSucursal = $_POST["nombreSucursal"];
    $editarProductoSucursal->nombreProductoSucursal = $_POST["nombreProductoSucursal"];
    $editarProductoSucursal->ajaxEditarProductoSucursal();
}
/*=============================================
TRAER PRODUCTOS
=============================================*/
/* 
if (isset($_POST["traerProductos"])) {

    $traerProductos = new AjaxProductos();
    $traerProductos->nombreSucursal = $_POST["nombreSucursal"];
    $traerProductos->traerProductos = $_POST["traerProductos"];
    $traerProductos->ajaxEditarProductoSucursal();
} */

/*=============================================
TRAER Sucursal
=============================================*/

/* if (isset($_POST["nombreProducto"])) {

    $traerProductos = new AjaxProductos();
    $traerProductos->nombreProducto = $_POST["nombreProducto"];
    $traerProductos->ajaxEditarProductoSucursal();
} */
