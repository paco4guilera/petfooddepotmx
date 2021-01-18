<?php
require_once "../modelos/vender.modelo.php";

class TablaVentas
{
    /*=============================================
        mostrar la tabla productos                             
    =============================================*/
    public function mostrarTablaVentas()
    {
        $item = null;
        $valor = null;
        $venta = ModeloVentas::mdlMostrarVentas($item, $valor);
        $datosJson = '{
		"data": [';
        for ($i = 0; $i < count($venta); $i++) {
            $boton = "<div class='btn-group'><button class='btn btn-info btnVerVenta' idVenta='" . $venta[$i]["venta_id"] . "'><i class='fas fa-file-invoice'></i></button></div>";
            $datosJson .= '[
                    "' . ($i + 1) . '",
                    "V-' . $venta[$i]["venta_id"] . '",
                    "' . $venta[$i]["cliente_nombre"] . '",
                    "' . $venta[$i]["venta_metodo_pago"] . '",
                    "' . $venta[$i]["venta_total"] . '",
                    "' . $venta[$i]["venta_neto"] . '",
                    "' . $venta[$i]["venta_fecha"] . '",
                    "' . $venta[$i]["usuario_nombre"] . '",
                    "' . $venta[$i]["sucursal_nombre"] . '",
                    "' . $boton . '"
                ],';
        }
        $datosJson = substr($datosJson, 0, -1);
        $datosJson .=   ']
        
        }';
        echo $datosJson;
    }
}
/*=============================================
    Activar tabla Ventas                             
=============================================*/
$activarVentas = new TablaVentas();
$activarVentas->mostrarTablaVentas();
