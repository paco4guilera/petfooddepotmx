<?php

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";

class AjaxSucursales
{
    /*=============================================
	EDITAR SUCURSAL
	=============================================*/
    public $nombreSucursal;
    public function ajaxEditarSucursal()
    {

        $item = "sucursal_nombre";
        $valor = $this->nombreSucursal;

        $respuesta = ControladorSucursales::ctrMostrarSucursales($item, $valor);

        echo json_encode($respuesta);
    }
}

/*=============================================
EDITAR SUCURSAL
=============================================*/
if (isset($_POST["nombreSucursal"])) {

    $sucursal = new AjaxSucursales();
    $sucursal->nombreSucursal = $_POST["nombreSucursal"];
    $sucursal->ajaxEditarSucursal();
}
