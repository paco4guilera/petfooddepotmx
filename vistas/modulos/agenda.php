<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Agenda

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Agenda</li>
        </ol>
    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-primary">
            <div class="box-header with-border">

            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-agenda" style="width:100%">
                    <thead>
                        <tr>
                            <td style="width: 1%">#</td>
                            <td>Nombre Cliente</td>
                            <td>Teléfono Cliente</td>
                            <td>Fecha De Contacto</td>
                            <td>Días Restantes</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
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
$eliminarAgenda = new ControladorAgenda();
$eliminarAgenda->ctrEliminarAgenda();
?>