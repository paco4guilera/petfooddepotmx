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
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-hventas" style="width:100%">
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

                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->