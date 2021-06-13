<?php

$item = null;
$valor = null;

$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
$clientes = ControladorClientes::ctrMostrarClientes($item, $valor);

$arrayClientes = array();
$arraylistaClientes = array();

foreach ($ventas as $key => $valueVentas) {

    foreach ($clientes as $key => $valueClientes) {

        if ($valueClientes["cliente_id"] == $valueVentas["cliente_id"]) {

            #Capturamos los Clientes en un array
            array_push($arrayClientes, $valueClientes["cliente_nombre"]);

            #Capturamos las nombres y los valores netos en un mismo array
            $arraylistaClientes = array($valueClientes["cliente_nombre"] => $valueVentas["venta_total"]);

            #Sumamos los netos de cada cliente
            foreach ($arraylistaClientes as $key => $value) {

                $sumaTotalClientes[$key] += $value;
            }
        }
    }
}

#Evitamos repetir nombre
$noRepetirNombres = array_unique($arrayClientes);

?>

<!--=====================================
COMPRADORES
======================================-->

<div class="box box-primary">

    <div class="box-header with-border">

        <h3 class="box-title">Compradores</h3>

    </div>

    <div class="box-body">

        <div class="chart-responsive">

            <div class="chart" id="bar-chart2" style="height: 300px;"></div>

        </div>

    </div>

</div>

<script>
    //BAR CHART
    var bar = new Morris.Bar({
        element: 'bar-chart2',
        resize: true,
        data: [
            <?php

            foreach ($noRepetirNombres as $value) {

                echo "{y: '" . $value . "', a: '" . $sumaTotalClientes[$value] . "'},";
            }

            ?>
        ],
        barColors: ['#f6a'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['ventas'],
        preUnits: '$',
        hideHover: 'auto'
    });
</script>