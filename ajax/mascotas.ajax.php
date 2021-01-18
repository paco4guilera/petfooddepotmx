<?php
require_once "../controladores/mascotas.controlador.php";
require_once "../modelos/mascotas.modelo.php";
class AjaxMascotas
{
    /* Editar usuario */
    public $idMascota;
    public function ajaxEditarMascota()
    {
        $item = "mascota_id";
        $valor = $this->idMascota;
        $respuesta = ControladorMascotas::ctrMostrarMascotas($item, $valor);
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
if (isset($_POST["idMascota"])) {
    $editar = new AjaxMascotas();
    $editar->idMascota = $_POST["idMascota"];
    $editar->ajaxEditarMascota();
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
