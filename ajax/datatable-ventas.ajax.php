<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/sucursales.controlador.php";
require_once "../modelos/sucursales.modelo.php";
class TablaProductos
{
    /*=============================================
        mostrar la tabla productos                             
        =============================================*/
    public function mostarTablaProductos()
    {
        $item = null;
        $valor = null;
        $sucursal = $_GET["sucursal"];
        $productos = ControladorSucursales::ctrMostrarProductosSucursal($item, $valor, $sucursal);
        $datosJson = '{
		"data": [';

        for ($i = 0; $i < count($productos); $i++) {
            /*=============================================
            INVENTARIO
            =============================================*/

            if ($productos[$i]["producto_inventario"] <= 10) {

                $inventario = "<button class='btn btn-danger'>" . $productos[$i]["producto_inventario"] . "</button>";
            } else if ($productos[$i]["producto_inventario"] > 11 && $productos[$i]["producto_inventario"] <= 30) {

                $inventario = "<button class='btn btn-warning'>" . $productos[$i]["producto_inventario"] . "</button>";
            } else {
                $inventario = "<button class='btn btn-success'>" . $productos[$i]["producto_inventario"] . "</button>";
            }
            /*=============================================
            TRAEMOS LAS ACCIONES
            =============================================*/
            $botones =  "<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='" . $productos[$i]["producto_nombre"] . "' nombreSucursal='" .  $sucursal . "' >Agregar</button></div>";
            $datosJson .= '[
                    "' . ($i + 1) . '",
                    "' . $productos[$i]["producto_nombre"] . '",
                    "$ ' . $productos[$i]["producto_mayoreo"] . '",
                    "$ ' . $productos[$i]["producto_menudeo"] . '",
                    " ' . $inventario . '",
                    "' . $botones . '"
                ],';
        }

        $datosJson = substr($datosJson, 0, -1);

        $datosJson .=   ']
        
        }';
        echo $datosJson;
    }
}
/*=============================================
    Activar tabla productos                             
    =============================================*/
$activarProductos = new TablaProductos();
$activarProductos->mostarTablaProductos();
