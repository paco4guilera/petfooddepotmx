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
            Usuarios

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Usuarios</li>
        </ol>
    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
                    Agregar Usuario
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Rol</th>
                            <th>Foto</th>
                            <th>Sesion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
                        foreach ($usuarios as $key => $value) {
                            $cont = 1;
                            echo '<tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $value["usuario_login"] . '</td>
                            <td>' . $value["usuario_nombre"] . '</td>
                            <td>' . $value["usuario_rol"] . '</td>';
                            if ($value["usuario_foto"] != "") {
                                echo '<td><img src="' . $value["usuario_foto"] . '" alt="foto" 
                                    width="40px"></td>';
                            } else {
                                echo '<td><img src="vistas/img/usuarios/default/anonymous.png" alt="foto" 
                                    width="40px"></td>';
                            }
                            echo '<td>' . $value["sesion_id"] . '</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarUsuario" idUsuario="' . $value["usuario_login"] . '" data-toggle="modal" data-target="#modalEditarUsuario">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btnEliminarUsuario" idUsuario="' . $value["usuario_login"] . '"fotoUsuario="' . $value["usuario_foto"] . '">
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
<!-- Modal AGREGAR USUARIO-->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear Usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <!-- Input para el usuario -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoLogin" id="nuevoLogin" placeholder="Usuario" required>
                            </div>
                        </div><!-- Input para el usuario -->

                        <div class="form-group">
                            <!-- Input para el nombre -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Nombre completo" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <div class="form-group">
                            <!-- Input para la contraseña -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg" name="nuevoPassword" placeholder="Nueva contraseña" required>
                            </div>
                        </div><!-- Input para la contraseña -->

                        <div class="form-group">
                            <!-- Input para el rol -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control input-lg" name="nuevoRol">
                                    <option value="">Seleccionar rol</option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Administrador">Administrador</option>
                                    <!-- <option value="Dueño">Dueño</option> -->
                                </select>
                            </div>
                        </div><!-- Input para el rol -->
                        <div class="form-group">
                            <div class="panel">SUBIR FOTO</div>
                            <input type="file" class="nuevaFoto" name="nuevaFoto">
                            <p class="help-block">Peso máximo: 2 MB</p>
                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px" alt="foto usuario por defecto">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $crearUsuario = new ControladorUsuarios();
                $crearUsuario->ctrCrearUsuario();
                ?>
            </form>
        </div>

    </div>
</div>
<!-- -------------------------------------------------------------------------------------------------------------- -->
<!-- Modal editar usuario -->
<div id="modalEditarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <!-- Input para el usuario -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="" class="form-control input-lg" id="editarLogin" name="editarLogin" value="" readonly>
                            </div>
                        </div><!-- Input para el usuario -->

                        <!-- Input para el nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <!-- Input para la contraseña -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control input-lg" name="editarPassword" placeholder="Nueva contraseña">
                                <input type="hidden" id="passwordActual" name="passwordActual">
                            </div>
                        </div><!-- Input para la contraseña -->

                        <!-- Input para el rol -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control input-lg" name="editarRol">
                                    <option value="" id="editarRol"></option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Administrador">Administrador</option>
                                    <!-- <option value="Dueño">Dueño</option> -->
                                </select>
                            </div>
                        </div><!-- Editar para el rol -->
                        <!-- Editar foto -->
                        <div class="form-group">
                            <div class="panel">SUBIR FOTO</div>
                            <input type="file" class="nuevaFoto" name="editarFoto">
                            <p class="help-block">Peso máximo: 2 MB</p>
                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px" alt="foto usuario por defecto">
                            <input type="hidden" name="fotoActual" id="fotoActual">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $editarUsuario = new ControladorUsuarios();
                $editarUsuario->ctrEditarUsuario();
                ?>
            </form>
        </div>

    </div>
</div>
<?php
$borrarUsuario = new ControladorUsuarios();
$borrarUsuario->ctrBorrarUsuario();
?>