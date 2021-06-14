<?php
if ($_SESSION["rol"] == "Vendedor") {
    echo '<script>
    window.location="inicio";
    </script>';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Historial De Ventas
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Historial De Ventas</li>
        </ol>
    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <div class="box">
        <div class="box-header with-border">
            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                <span>
                    <i class="fa fa-calendar"></i> Rango Fecha
                </span>
                <i class="fa fa-caret-down"></i>
            </button>
        </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla- hventas tabla-plugin" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 1%;">#</th>
                            <th style="width: 10%;">ID Venta</th>
                            <th style="width: 20%;">Cliente</th>
                            <th style="width: 15%;">Método Pago</th>
                            <th style="width: 15%;">Total Venta</th>
                            <th style="width: 10%;">Neto Venta</th>
                            <th style="width: 15%;">Fecha</th>
                            <th style="width: 20%;">Vendedor</th>
                            <th style="width: 15%;">Sucursal</th>
                            <th style="width: 1%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                if (isset($_GET["fechaInicial"])) {

                                $fechaInicial = $_GET["fechaInicial"];
                                $fechaFinal = $_GET["fechaFinal"];
                                } else {
                                    $fechaInicial = null;
                                    $fechaFinal = null;
                                    }
                                $venta = ModeloVentas::mdlRangoVentas($fechaInicial, $fechaFinal);
                                foreach($venta as $key => $value){
                                    echo '<tr>
                                            <td>'. ($key+1). '</td>
                                            <td>V-'.$value["venta_id"].'</td>
                                            <td>'. $value["cliente_nombre"]. '</td>
                                            <td>' . $value["venta_metodo_pago"] . '</td>
                                            <td>$ '. $value["venta_total"].'</td>
                                            <td>$ '. $value["venta_total"]. '</td>
                                            <td>' . $value["venta_fecha"] . '</td>
                                            <td>' . $value["usuario_nombre"] . '</td>
                                            <td>' . $value["sucursal_nombre"] . '</td>';
                                    echo'<td>
                                        <div class="btn-group"><button class="btn btn-info btnVerVenta" idVenta="' . $value["venta_id"] . '"><i class="fas fa-file-invoice"></i></button></div>
                                    </td>
                                </tr>
                                ';


                                }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->