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
            Sucursales

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Sucursales</li>
        </ol>
    </section><!-- Base -->

    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarSucursal">
                    Agregar Sucursal
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Encargado</th>
                            <th>Dirección</th>
                            <th>Sesión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $sucursales = ControladorSucursales::ctrMostrarSucursales($item, $valor);
                        foreach ($sucursales as $key => $value) {
                            $itemEncargado = "usuario_login";
                            $usEncargado = $value["usuario_login"];
                            $encargados = ControladorUsuarios::ctrMostrarUsuarios($itemEncargado, $usEncargado);
                            echo '<tr>
                            <td>' . $value["sucursal_nombre"] . '</td>
                            <td>' . $value["sucursal_telefono"] . '</td>
                            <td>' . $encargados["usuario_nombre"] . '</td>
                            <td>' . $value["sucursal_direccion"] . '</td>
                            ';
                            echo '<td>' . $value["sesion_id"] . '</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarSucursal" nombreSucursal="' . $value["sucursal_nombre"] . '" data-toggle="modal" data-target="#modalEditarSucursal">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btnEliminarSucursal" nombreSucursal="' . $value["sucursal_nombre"] . '">
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
CREAR SUCURSAL                           
=============================================*/  
-->
<div id="modalAgregarSucursal" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registro de Sucursal</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Input para el Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-store"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevaSucursal" id="nuevaSucursal" placeholder="Nombre De Sucursal" required>
                            </div>
                        </div><!-- Input para el nombre -->
                        <!-- Input para el Telefono -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoTelefonoSucursal" id="nuevoTelefonoSucursal" placeholder="Teléfono De Sucursal" required>
                            </div>
                        </div><!-- Input para el Telefono -->
                        <!-- Input para el encargado -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fa fa-user"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="nuevoEncargado">
                                    <option class="texto-combo" value="">Selecciona Al Encargado</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                                    foreach ($usuarios as $key => $value) {
                                        echo '<option value="' . $value["usuario_login"] . '">' . $value["usuario_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><!-- Input para el encargado -->
                        <!-- Input para la dirección -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                                <textarea type="text" class="form-control input-lg" name="nuevaDireccionSucursal" id="nuevaDireccionSucursal" placeholder="Dirección De Sucursal" required></textarea>
                            </div>
                        </div><!-- Input para el Direccion -->

                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $crearSucursal = new ControladorSucursales();
                $crearSucursal->ctrCrearSucursal();
                ?>
            </form>
        </div>

    </div>
</div>
<!-- 
/*=============================================
EDITAR SUCURSAL                            
=============================================*/  -->
<div id="modalEditarSucursal" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Sucursal</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Input para el Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-store"></i></span>
                                <input type="text" class="form-control input-lg" name="editarSucursal" id="editarSucursal" placeholder="Nombre De Sucursal" readonly>
                            </div>
                        </div><!-- Input para el Telefono -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                <input type="text" class="form-control input-lg" name="editarTelefonoSucursal" id="editarTelefonoSucursal" placeholder="Teléfono De Sucursal" required>
                            </div>
                        </div><!-- Input para el Telefono -->
                        <!-- Input para el encargado -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fa fa-user"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="editarEncargado" id="editarEncargado">
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                                    foreach ($usuarios as $key => $value) {
                                        echo '<option value="' . $value["usuario_login"] . '">' . $value["usuario_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><!-- Input para el encargado -->

                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $editarSucursal = new ControladorSucursales();
                $editarSucursal->ctrEditarSucursal();
                ?>
            </form>
        </div>

    </div>
</div>

<?php
$borrarSucursal = new ControladorSucursales();
$borrarSucursal->ctrBorrarSucursal();
?>