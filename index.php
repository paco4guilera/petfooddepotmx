<?php
require_once "controladores/plantilla.controlador.php";

require_once "controladores/agenda.controlador.php";
require_once "controladores/vender.controlador.php";
require_once "controladores/reporte-ventas.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/mascotas.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/agenda.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/marcas.controlador.php";
require_once "controladores/sucursales.controlador.php";
require_once "controladores/colonias.controlador.php";
require_once "controladores/prestamos.controlador.php";

require_once "modelos/agenda.modelo.php";
require_once "modelos/vender.modelo.php";
require_once "modelos/reporte-ventas.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/mascotas.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/agenda.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/sesiones.modelo.php";
require_once "modelos/marcas.modelo.php";
require_once "modelos/sucursales.modelo.php";
require_once "modelos/colonias.modelo.php";
require_once "modelos/prestamos.modelo.php";
require_once "modelos/acciones.modelo.php";
require_once "modelos/conexion.php";

$plantilla = new ControladorPlantilla();
$plantilla->ctrPlantilla();
