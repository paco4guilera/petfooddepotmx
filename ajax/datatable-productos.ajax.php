<?php
require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/marcas.controlador.php";
require_once "../modelos/marcas.modelo.php";
class TablaProductos
{
    /*=============================================
        mostrar la tabla productos                             
        =============================================*/
    public function mostarTablaProductos()
    {
        $item = null;
        $valor = null;
        $productos = ControladorProductos::ctrMostrarProductos($item, $valor);
        $datosJson = '{
		"data": [';

        for ($i = 0; $i < count($productos); $i++) {

            /*=============================================
                TRAEMOS LA IMAGEN
                =============================================*/
            if ($productos[$i]["producto_foto"] != "") {
                $imagen = "<img src='" . $productos[$i]["producto_foto"] . "' width='60px'>";
            } else {
                $imagen = "<img src='vistas/img/productos/default/anonymous.png' width='60px'>";
            }

            /*=============================================
            TRAEMOS LA CATEGORÍA
            =============================================*/

            $item = "marca_id";
            $valor = $productos[$i]["marca_id"];

            $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);

            /*=============================================
            STOCK
            =============================================*/

            /* if ($productos[$i]["producto_inventario"] <= 10) {

                $inventario = "<button class='btn btn-danger'>" . $productos[$i]["producto_inventario"] . "</button>";
            } else if ($productos[$i]["producto_inventario"] > 11 && $productos[$i]["producto_inventario"] <= 15) {

                $inventario = "<button class='btn btn-warning'>" . $productos[$i]["producto_inventario"] . "</button>";
            } else {

                $inventario = "<button class='btn btn-success'>" . $productos[$i]["producto_inventario"] . "</button>";
            }    */

            /*=============================================
            TRAEMOS LAS ACCIONES
            =============================================*/
            $botones =  "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' nombreProducto='" . $productos[$i]["producto_nombre"] . "' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' nombreProducto='" . $productos[$i]["producto_nombre"]  . "' imagen='" . $productos[$i]["producto_foto"] . "'><i class='fa fa-times'></i></button></div>";
            $datosJson .= '[
                    "' . ($i + 1) . '",
                    "' . $productos[$i]["producto_nombre"] . '",
                    "' . $marcas["marca_nombre"] . '",
                    "' .  $imagen . '",
                    "$ ' . $productos[$i]["producto_costo"] . '",
                    " ' . $productos[$i]["producto_puntos"] . '",
                    " ' . $productos[$i]["producto_tope"] . '",
                    "' . $productos[$i]["producto_duracion"] . ' días",
                    "' . $productos[$i]["producto_fecha"] . '",
                    "s-' . $productos[$i]["sesion_id"] . '",
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
