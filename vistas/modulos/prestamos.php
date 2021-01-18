<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Préstamos

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Préstamos</li>
        </ol>
    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">

            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width:100%">
                    <thead>
                        <tr>
                            <td style="width: 1%">#</td>
                            <td>Id Venta</td>
                            <td>Nombre Cliente</td>
                            <td>Teléfono Cliente</td>
                            <td>Monto</td>
                            <td>Fecha De Pago</td>
                            <td>Días Restantes</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $prestamos = ControladorPrestamos::ctrMostrarPrestamos($item, $valor);
                        date_default_timezone_set('America/Mexico_City');
                        $fechaActual = date('Y-m-d');

                        foreach ($prestamos as $key => $value) {
                            echo '
                            <tr>
                                <td>' . ($key + 1) . '</td>
                                <td>V-' . $value["venta_id"] . '</td>
                                <td>' . $value["cliente_nombre"] . '</td>
                                <td>' . $value["cliente_telefono"] . '</td>
                                <td>$ ' . $value["prestamo_monto"] . '</td>
                                <td>' . $value["prestamo_caducidad"] . '</td>';
                            $fechaPago = $value["prestamo_caducidad"];
                            $diff = strtotime($fechaPago) - strtotime($fechaActual);
                            $days = floor(($diff) / (60 * 60 * 24));
                            echo '<td>' . $days . ' Días</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-info btnVerVenta" idVenta="' . $value["venta_id"] . '">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                    <button class="btn btn-success btnLiquidarPrestamo" idPrestamo="' . $value["prestamo_id"] . '">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
$liquidarPrestamo = new ControladorPrestamos();
$liquidarPrestamo->ctrEliminarPrestamo();
?>