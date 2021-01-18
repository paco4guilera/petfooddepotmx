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
            Clientes

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Clientes</li>
        </ol>
    </section><!-- Base -->

    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
                    Agregar Cliente
                </button>
                <button class="btn btn-primary btnirATiposClientes">
                    Tipos De Clientes
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width:100%">
                    <thead>
                        <tr>

                            <th style="width: 15px;">ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Colonia</th>
                            <th>Tipo</th>
                            <th>Puntos</th>
                            <th>Sesión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                        foreach ($clientes as $key => $value) {
                            $col = "cliente_id";
                            $id = $value["cliente_id"];
                            $puntos = ControladorClientes::ctrMostrarDescuento($col, $id);
                            if ($puntos["puntos"] == null) {
                                $puntos["puntos"] = 0;
                            }
                            echo '<tr>
                            <td>' . $value["cliente_id"] . '</td>
                            <td>' . $value["cliente_nombre"] . '</td>
                            <td>' . $value["cliente_telefono"] . '</td>
                            <td>' . $value["cliente_correo"] . '</td>
                            <td>' . $value["colonia_nombre"] . '</td>
                            <td>' . $value["cliente_tipo"] . '</td>
                            <td>' . $puntos["puntos"] . '</td>
                            ';
                            echo '<td>' . $value["sesion_id"] . '</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarCliente" idCliente="' . $value["cliente_id"] . '" data-toggle="modal" data-target="#modalEditarCliente">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btnEliminarCliente" idCliente="' . $value["cliente_id"] . '" nombreCliente="' . $value["cliente_nombre"] . '">
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
/*=============================================
REGISTRO CLIENTE                             
=============================================*/  -->
<div id="modalAgregarCliente" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registro de Cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Input Colonia -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fas fa-home"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="nuevaColoniaCliente">
                                    <option class="texto-combo" value="">Seleccionar Colonia</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $usuarios = ControladorColonias::ctrMostrarColonias($item, $valor);
                                    foreach ($usuarios as $key => $value) {
                                        echo '<option value="' . $value["colonia_nombre"] . '">' . $value["colonia_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-group-addon  search-combo btn-add"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarColonia"><i class=" fas fa-plus"></i></button></span>
                            </div>
                        </div><!-- Input para la colonia -->

                        <!-- Input para el Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" placeholder="Nombre Completo" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <!-- Input para el telefono -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone-alt"></i></span>
                                <input type="tel" class="form-control input-lg" name="nuevoTelefono" id="nuevoTelefono" placeholder="Teléfono" required>
                            </div>
                        </div><!-- Input para el telefono -->

                        <!-- Input para la email -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-at"></i></span>
                                <input type="email" class="form-control input-lg" name="nuevoEmail" id="nuevoEmail" placeholder="E-mail" required>
                            </div>
                        </div><!-- Input para la email -->

                        <!-- Input para el tipo -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fa fa-users"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="nuevoTipo">
                                    <option value="">Seleccionar Tipo</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $usuarios = ControladorClientes::ctrMostrarTipos($item, $valor);
                                    foreach ($usuarios as $key => $value) {
                                        echo '<option value="' . $value["tipo_nombre"] . '">' . $value["tipo_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $crearCliente = new ControladorClientes();
                $crearCliente->ctrCrearCliente();
                ?>
            </form>
        </div>

    </div>
</div>
<!-- -------------------------------------------------------------------------------------------------------------- -->
<!-- Modal editar cliente -->
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
                        <!-- Input Colonia -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fas fa-home"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="editarColoniaCliente" id="editarColoniaCliente">
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $colonias = ControladorColonias::ctrMostrarColonias($item, $valor);
                                    foreach ($colonias as $key => $value) {
                                        echo '<option value="' . $value["colonia_nombre"] . '">' . $value["colonia_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <span class="input-group-addon  search-combo btn-add"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarColonia"><i class=" fas fa-plus"></i></button></span>
                            </div>
                        </div><!-- Input para la colonia -->
                        <!-- Input para el Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="hidden" id="idActual" name="idActual">
                                <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" placeholder="Nombre Completo" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <!-- Input para el telefono -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone-alt"></i></span>
                                <input type="tel" class="form-control input-lg" id="editarTelefono" name="editarTelefono" placeholder="Teléfono" required>
                            </div>
                        </div><!-- Input para el telefono -->

                        <!-- Input para la email -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-at"></i></span>
                                <input type="email" class="form-control input-lg" id="editarEmail" name="editarEmail" placeholder="E-mail" required>
                            </div>
                        </div><!-- Input para la email -->

                        <!-- Input Colonia -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fa fa-users"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="editarTipo" id="editarTipo">
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    foreach ($usuarios as $key => $value) {
                                        echo '<option value="' . $value["tipo_nombre"] . '">' . $value["tipo_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><!-- Input para la colonia -->

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
<!-- Modal Agregar Colonia -->
<div id="modalAgregarColonia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nueva Colonia</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Input para La Colonia -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-home"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevaColonia" id="nuevaColonia" placeholder="Nombre Colonia" required>
                            </div>
                        </div><!-- Input para La Colonia -->


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $nuevaColonia = new ControladorColonias();
                $nuevaColonia->ctrNuevaColonia();
                ?>
            </form>
        </div>

    </div>
</div>
<?php
$borrarCliente = new ControladorClientes();
$borrarCliente->ctrBorrarCliente();
?>