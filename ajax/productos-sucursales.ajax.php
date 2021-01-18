<?php
/* require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";


class AjaxProductoSucursales
{
    /*=============================================
    EDITAR PRODUCTO
    =============================================
    public $nombreProductoSucursal;
    public function ajaxEditarProductoSucursal()
    {
        $item = "producto_nombre";
        $valor = $this->nombreProductoSucursal;
        $respuesta = ControladorSucursales::ctrMostrarProductosSucursal($item, $valor);
        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR PRODUCTO SUCURSAL
=============================================
if (isset($_POST["nombreProductoSucursal"])) {
    $editarProductoSucursal = new AjaxProductoSucursales();
    $editarProductoSucursal->nombreProductoSucursal = $_POST["nombreProductoSucursal"];
    $editarProductoSucursal->ajaxEditarProductoSucursal();
} */
