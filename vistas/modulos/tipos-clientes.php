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
            Tipos Clientes

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Tipos Clientes</li>
        </ol>
    </section><!-- Base -->

    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary btnirAClientes">
                    Clientes
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive" style="width:50%; margin:auto">
                    <thead>
                        <tr>



                            <th>Tipo</th>
                            <th>Descuento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $tipos = ControladorClientes::ctrMostrarTipos($item, $valor);
                        foreach ($tipos as $key => $value) {
                            echo '<tr>
                            <td>' . $value["tipo_nombre"] . '</td>
                            <td>' . $value["tipo_descuento"] . ' %</td>
                            ';
                            echo '
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarTipo" tipoDescuento="' . $value["tipo_nombre"] . '" data-toggle="modal" data-target="#modalEditarTipo">
                                        <i class="fa fa-pencil"></i>
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
<!-- Modal Agregar Colonia -->
<div id="modalEditarTipo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Descuento</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Input para La Colonia -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-percentage"></i></span>
                                <input type="number" class="form-control input-lg" name="editarDescuento" id="editarDescuento" required>
                            </div>
                        </div><!-- Input para La Colonia -->
                        <input type="hidden" name="editarDescuentoNombre" id="editarDescuentoNombre" required>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $editarDescuento = new ControladorClientes();
                $editarDescuento->ctrEditarDescuento();
                ?>
            </form>
        </div>

    </div>
</div>