<?php
error_reporting(0);
if (isset($_GET["fechaInicial"])) {

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];
    $op = $_GET["op"];
} else {
    $fechaInicial = null;
    $fechaFinal = null;
    $op = null;
}
$venta = ModeloVentas::mdlRangoVentas($fechaInicial, $fechaFinal);
$arrayFechas = array();
$arrayVentas = array();
$sumaPagos= array();
$l=7;
$inicio= 0;
switch($_GET["op"]){
    case "Hoy":case "Ayer":
        $l = 2;
        $inicio = 11;
        break;
    case "ultimos7":
    case "ultimos30":
    case "estemes":
    case "ultimomes":
    case "rango":
        $l = 10;
        break;
}
foreach ($venta as $key => $value) {

    #Capturamos sólo el año y el mes
    $fecha = substr($value["venta_fecha"], $inicio,$l);
    #Introducir las fechas en arrayFechas
    array_push($arrayFechas, $fecha);
    #Capturamos las ventas
    $arrayVentas = array($fecha => $value["venta_total"]);
    #Sumamos los pagos que ocurrieron el mismo mes
    foreach ($arrayVentas as $key => $value) {
        $sumaPagos[$key] += $value;
    }
}
$noRepetirFechas = array_unique($arrayFechas);
if($_GET["op"]=="rango" && sizeof($noRepetirFechas)>30){
    foreach ($venta as $key => $value) {
        #Capturamos sólo el año y el mes
        $fecha = substr($value["venta_fecha"], 0, 7);
        #Introducir las fechas en arrayFechas
        array_push($arrayFechas, $fecha);
        #Capturamos las ventas
        $arrayVentas = array($fecha => $value["venta_total"]);
        #Sumamos los pagos que ocurrieron el mismo mes
        foreach ($arrayVentas as $key => $value) {
            $sumaPagos[$key] += $value;
        }
    }
}
?>
<!--/*=============================================
Gráfico de ventas
=============================================*/-->
<div class="box box-solid bg-teal-gradient">

    <div class="box-header">

        <i class="fa fa-th"></i>

        <h3 class="box-title">Gráfico de Ventas</h3>

    </div>

    <div class="box-body border-radius-none nuevoGraficoVentas">

        <div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

    </div>

</div>

<script>
    
    var line = new Morris.Line({
        element: 'line-chart-ventas',
        resize: true,
        data: [
        <?php
            if ($noRepetirFechas != null) {
                foreach ($noRepetirFechas as $key) {
                    echo "{ y: '" . $key . "', ventas: " . $sumaPagos[$key] . " },";
                }
                echo "{y: '" . $key . "', ventas: " . $sumaPagos[$key] . " }";
            } else {
                echo "{ y: '0', ventas: '0' }";
            }
            ?>
        ],
        xkey: 'y',
        ykeys: ['ventas'],
        labels: ['ventas'],
        lineColors: ['#efefef'],
        lineWidth: 2,
        hideHover: 'auto',
        gridTextColor: '#fff',
        gridStrokeWidth: 0.4,
        pointSize: 4,
        pointStrokeColors: ['#efefef'],
        gridLineColor: '#efefef',
        gridTextFamily: 'Open Sans',
        preUnits: '$',
        gridTextSize: 10
    });
</script>