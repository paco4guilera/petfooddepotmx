<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
class AjaxClientes
{
    /* Editar usuario */
    public $idCliente;
    public $traerDescuento;
    public $descuento;
    public function ajaxEditarCliente()
    {
        $item = "cliente_id";
        $valor = $this->idCliente;
        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
        echo json_encode($respuesta);
    }
    public function ajaxTipoDescuento()
    {
        $item = "tipo_nombre";
        $valor = $this->descuento;
        $respuesta = ControladorClientes::ctrMostrarTipos($item, $valor);
        echo json_encode($respuesta);
    }
    public function ajaxDescuentoCliente()
    {
        $item = "cliente_id";
        $valor = $this->traerDescuento;
        $respuesta = ControladorClientes::ctrMostrarDescuento($item, $valor);
        echo json_encode($respuesta);
    }
    public $validarTelefono;
    public function ajaxValidarTelefono()
    {
        $item = "cliente_telefono";
        $valor = $this->validarTelefono;
        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
        echo json_encode($respuesta);
    }
    public $validarCorreo;
    public function ajaxValidarCorreo()
    {
        $item = "cliente_correo";
        $valor = $this->validarCorreo;
        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
        echo json_encode($respuesta);
    }
    public $validarNombre;
    public function ajaxValidarNombre()
    {
        $item = "cliente_nombre";
        $valor = $this->validarNombre;
        $respuesta = ControladorClientes::ctrMostrarClientes($item, $valor);
        echo json_encode($respuesta);
    }
}
if(isset($_POST["tipoDescuento"])){
    $descuento= new AjaxClientes();
    $descuento->descuento= $_POST["tipoDescuento"];
    $descuento->ajaxTipoDescuento();
}
if (isset($_POST["idCliente"])) {
    $editar = new AjaxClientes();
    $editar->idCliente = $_POST["idCliente"];
    $editar->ajaxEditarCliente();
}
if (isset($_POST["traerDescuento"])) {
    $descuento = new AjaxClientes();
    $descuento->traerDescuento = $_POST["traerDescuento"];
    $descuento->ajaxDescuentoCliente();
}
if (isset($_POST["validarTelefono"])) {
    $valTel = new AjaxClientes();
    $valTel->validarTelefono = $_POST["validarTelefono"];
    $valTel->ajaxValidarTelefono();
}
if (isset($_POST["validarCorreo"])) {
    $valCorreo = new AjaxClientes();
    $valCorreo->validarCorreo = $_POST["validarCorreo"];
    $valCorreo->ajaxValidarCorreo();
}
if (isset($_POST["validarNombre"])) {
    $valNombre = new AjaxClientes();
    $valNombre->validarNombre = $_POST["validarNombre"];
    $valNombre->ajaxValidarNombre();
}
