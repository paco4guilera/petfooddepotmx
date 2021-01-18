<?php
require_once "../modelos/acciones.modelo.php";

class TablaAcciones
{
    /*=============================================
        mostrar la tabla productos                             
    =============================================*/
    public function mostrarTablaAcciones()
    {
        $acciones = ModeloAcciones::mdlTablaAcciones();
        $datosJson = '{
		"data": [';
        for ($i = 0; $i < count($acciones); $i++) {
            $datosJson .= '[
                    "' . ($i + 1) . '",
                    "' . $acciones[$i]["accion_categoria"] . '-' . $acciones[$i]["accion_id"] . '",
                    "' . $acciones[$i]["accion_descripcion"] . '",
                    "' . $acciones[$i]["accion_fecha"] . '",
                    "' . $acciones[$i]["accion_categoria"] . '-' . $acciones[$i]["usuario_nombre"] . '",
                    "S-' . $acciones[$i]["sesion_id"] . '"
                ],';
        }
        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=   ']
        
        }';
        echo $datosJson;
    }
}
/*=============================================
    Activar tabla acciones                             
=============================================*/
$activarAcciones = new TablaAcciones();
$activarAcciones->mostrarTablaAcciones();
