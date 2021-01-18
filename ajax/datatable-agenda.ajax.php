<?php
require_once "../modelos/agenda.modelo.php";

class TablaAgenda
{
    /*=============================================
        mostrar la tabla productos                             
    =============================================*/
    public function mostrarTablaAgenda()
    {
        $item = null;
        $valor = null;
        $agenda = ModeloAgenda::mdlMostrarAgenda($item, $valor);
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date('Y-m-d');
        $datosJson = '{
		"data": [';
        for ($i = 0; $i < count($agenda); $i++) {
            $fechaPago = $agenda[$i]["agenda_fecha"];
            $diff = strtotime($fechaPago) - strtotime($fechaActual);
            $days = floor(($diff) / (60 * 60 * 24));
            $botones = "<div class='btn-group'><button class='btn btn-info btnVerVenta' idVenta='" . $agenda[$i]["venta_id"] . "'><i class='fas fa-file-invoice'></i></button><button class='btn btn-success btnEliminarAgenda' idAgenda='" . $agenda[$i]["agenda_id"] . "'><i class='fas fa-check'></i></button></div>";
            $datosJson .= '[
                    "' . ($i + 1) . '",
                    "' . $agenda[$i]["cliente_nombre"] . '",
                    "' . $agenda[$i]["cliente_telefono"] . '",
                    "' . $agenda[$i]["agenda_fecha"] . '",
                    "' . $days . ' días",
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
    Activar tabla agenda                           
=============================================*/
$activarAgenda = new TablaAgenda();
$activarAgenda->mostrarTablaAgenda();
