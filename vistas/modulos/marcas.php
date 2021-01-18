<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Marcas

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Marcas</li>
        </ol>
    </section><!-- Base -->

    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca">
                    Agregar Marca
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 15px;">ID</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Sesión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);
                        foreach ($marcas as $key => $value) {
                            echo '<tr>
                            <td>' . $value["marca_id"] . '</td>
                            <td>' . $value["marca_nombre"] . '</td>
                            <td>' . $value["marca_fecha"] . '</td>';
                            echo '<td>' . $value["sesion_id"] . '</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarMarca" idMarca="' . $value["marca_id"] . '" data-toggle="modal" data-target="#modalEditarMarca">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btnEliminarMarca" idMarca="' . $value["marca_id"] . '">
                                        <i class="fa fa-times"></i>
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
<!-- 

<!-- 
/*=============================================
EDITAR MARCA                             
=============================================*/  -->
<div id="modalEditarCliente" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar de Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <!-- Input para el Nombre -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="hidden" id="idActual" name="idActual">
                                <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" placeholder="Nombre Completo" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <div class="form-group">
                            <!-- Input para el telefono -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="tel" class="form-control input-lg" id="editarTelefono" name="editarTelefono" placeholder="Teléfono" required>
                            </div>
                        </div><!-- Input para el telefono -->

                        <div class="form-group">
                            <!-- Input para la email -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-at"></i></span>
                                <input type="email" class="form-control input-lg" id="editarEmail" name="editarEmail" placeholder="E-mail" required>
                            </div>
                        </div><!-- Input para la email -->
                        <div class="form-group">
                            <!-- Input para la Colonia -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-home"></i></span>
                                <input type="text" class="form-control input-lg" id="editarColonia" name="editarColonia" placeholder="Colonia" required>
                            </div>
                        </div><!-- Input para la Colonia -->
                        <div class="form-group">
                            <!-- Input para el tipo -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control input-lg" name="editarTipo">
                                    <option value="" id="editarTipo"></option>
                                    <option value="Mayorista">Mayorista</option>
                                    <option value="Veterinaria">Veterinaria</option>
                                    <option value="Detalle">Detalle</option>
                                    <option value="Final">Final</option>
                                </select>
                            </div>
                        </div><!-- Input para el rol -->
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $editarCliente = new ControladorClientes();
                $editarCliente->ctrEditarCliente();
                ?>
            </form>
        </div>

    </div>
</div>
<?php
$borrarCliente = new ControladorClientes();
$borrarCliente->ctrBorrarCliente();
?>