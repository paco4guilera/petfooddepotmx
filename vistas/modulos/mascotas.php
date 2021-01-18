<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mascotas

        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Mascotas</li>
        </ol>
    </section><!-- Base -->

    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMascota">
                    Agregar Mascota
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 30px;">ID</th>
                            <th>Nombre</th>
                            <th>Raza</th>
                            <th>Peso</th>
                            <th>Edad</th>
                            <th>ID Cliente</th>
                            <th>Dueño</th>
                            <th>Sesión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $mascotas = ControladorMascotas::ctrMostrarMascotas($item, $valor);
                        foreach ($mascotas as $key => $value) {
                            echo '<tr>
                            <td>' . $value["mascota_id"] . '</td>
                            <td>' . $value["mascota_nombre"] . '</td>
                            <td>' . $value["mascota_raza"] . '</td>
                            <td>' . $value["mascota_peso"] . ' Kg' . '</td>
                            <td>' . $value["mascota_edad"] . '</td>
                            <td>' . '#' . $value["cliente_id"] . '</td>
                            <td>' . $value["cliente_nombre"] . '</td>
                            ';
                            echo '<td>' . $value["sesion_id"] . '</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarMascota" idMascota="' . $value["mascota_id"] . '" data-toggle="modal" data-target="#modalEditarMascota">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btnEliminarMascota" idMascota="' . $value["mascota_id"] . '">
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
<div id="modalAgregarMascota" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registro de Mascota</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <!-- Input para el Nombre -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" placeholder="Nombre" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <div class="form-group">
                            <!-- Input para el telefono -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-dog"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevaRaza" id="nuevaRaza" placeholder="Raza" required>
                            </div>
                        </div><!-- Input para el telefono -->

                        <div class="form-group">
                            <!-- Input para la Peso -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-weight"></i></span>
                                <input type="number" class="form-control input-lg" name="nuevoPeso" placeholder="Peso en Kg" required>
                            </div>
                        </div><!-- Input para la Peso -->
                        <!-- Input para el tipo -->
                        <div class="form-group ">
                            <div class="input-group " style="width: 100%;">
                                <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                <select class="form-control combo-search input-lg d-block texto-combo" style="width: 100%; height:46px" name="nuevaEdad">
                                    <option value="">Selecciona la edad</option>
                                    <option value="1 mes">1 mes</option>
                                    <option value="2 meses">2 meses</option>
                                    <option value="3 meses">3 meses</option>
                                    <option value="4 meses">4 meses</option>
                                    <option value="5 meses">5 meses</option>
                                    <option value="6 meses">6 meses</option>
                                    <option value="7 meses">7 meses</option>
                                    <option value="8 meses">8 meses</option>
                                    <option value="9 meses">9 meses</option>
                                    <option value="10 meses">10 meses</option>
                                    <option value="11 meses">11 meses</option>
                                    <option value="12 meses">12 meses</option>
                                    <option value="13 meses">13 meses</option>
                                    <option value="14 meses">14 meses</option>
                                    <option value="15 meses">15 meses</option>
                                    <option value="16 meses">16 meses</option>
                                    <option value="17 meses">17 meses</option>
                                    <option value="18 meses">18 meses</option>
                                    <option value="1 año">1 año</option>
                                    <option value="2 años">2 años</option>
                                    <option value="3 años">3 años</option>
                                    <option value="4 años">4 años</option>
                                    <option value="5 años">5 años</option>
                                    <option value="6 años">6 años</option>
                                    <option value="7 años">7 años</option>
                                    <option value="8 años">8 años</option>
                                    <option value="9 años">9 años</option>
                                    <option value="10 años">10 años</option>
                                    <option value="11 años">11 años</option>
                                    <option value="12 años">12 años</option>
                                    <option value="13 años">13 años</option>
                                    <option value="14 años">14 años</option>
                                    <option value="15 años">15 años</option>
                                    <option value="16 años">16 años</option>
                                    <option value="17 años">17 años</option>
                                    <option value="18 años">18 años</option>
                                    <option value="19 años">19 años</option>
                                    <option value="20 años">20 años</option>
                                    <option value="21 años">21 años</option>
                                </select>
                            </div>
                        </div>
                        <!-- Input para el tipo -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fa fa-user"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="nuevoDuegno">
                                    <option class="texto-combo" value="">Selecciona al dueño</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                                    foreach ($clientes as $key => $value) {
                                        echo '<option value="' . $value["cliente_id"] . '">' . $value["cliente_id"] .
                                            ' - ' . $value["cliente_nombre"] . '</option>';
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
                $crearMascota = new ControladorMascotas();
                $crearMascota->ctrCrearMascota();
                ?>
            </form>
        </div>

    </div>
</div>
<!-- -------------------------------------------------------------------------------------------------------------- -->
<!-- Modal editar Mascota -->
<div id="modalEditarMascota" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Datos De La Mascota</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <div class="form-group">
                            <!-- Input para el Nombre -->
                            <div class="input-group">
                                <input type="hidden" id="idActual" name="idActual">
                                <span class="input-group-addon"><i class="fa fa-paw"></i></span>
                                <input type="text" class="form-control input-lg" name="editarNombre" id="editarNombre" placeholder="Nombre" required>
                            </div>
                        </div><!-- Input para el nombre -->

                        <div class="form-group">
                            <!-- Input para el telefono -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-dog"></i></span>
                                <input type="text" class="form-control input-lg" name="editarRaza" id="editarRaza" placeholder="Raza" required readonly>
                            </div>
                        </div><!-- Input para el telefono -->

                        <div class="form-group">
                            <!-- Input para la Peso -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-weight"></i></span>
                                <input type="number" class="form-control input-lg" id="editarPeso" name="editarPeso" placeholder="Peso" required>
                            </div>
                        </div><!-- Input para la Peso -->
                        <div class="form-group ">
                            <!-- Input para el tipo -->
                            <div class="input-group " style="width: 100%;">
                                <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                <select class="form-control combo-search input-lg d-block texto-combo" style="width: 100%; height:46px" name="editarEdad" id="editarEdad">
                                    <option value="1 mes">1 mes</option>
                                    <option value="2 meses">2 meses</option>
                                    <option value="3 meses">3 meses</option>
                                    <option value="4 meses">4 meses</option>
                                    <option value="5 meses">5 meses</option>
                                    <option value="6 meses">6 meses</option>
                                    <option value="7 meses">7 meses</option>
                                    <option value="8 meses">8 meses</option>
                                    <option value="9 meses">9 meses</option>
                                    <option value="10 meses">10 meses</option>
                                    <option value="11 meses">11 meses</option>
                                    <option value="12 meses">12 meses</option>
                                    <option value="13 meses">13 meses</option>
                                    <option value="14 meses">14 meses</option>
                                    <option value="15 meses">15 meses</option>
                                    <option value="16 meses">16 meses</option>
                                    <option value="17 meses">17 meses</option>
                                    <option value="18 meses">18 meses</option>
                                    <option value="1 año">1 año</option>
                                    <option value="2 años">2 años</option>
                                    <option value="3 años">3 años</option>
                                    <option value="4 años">4 años</option>
                                    <option value="5 años">5 años</option>
                                    <option value="6 años">6 años</option>
                                    <option value="7 años">7 años</option>
                                    <option value="8 años">8 años</option>
                                    <option value="9 años">9 años</option>
                                    <option value="10 años">10 años</option>
                                    <option value="11 años">11 años</option>
                                    <option value="12 años">12 años</option>
                                    <option value="13 años">13 años</option>
                                    <option value="14 años">14 años</option>
                                    <option value="15 años">15 años</option>
                                    <option value="16 años">16 años</option>
                                    <option value="17 años">17 años</option>
                                    <option value="18 años">18 años</option>
                                    <option value="19 años">19 años</option>
                                    <option value="20 años">20 años</option>
                                    <option value="21 años">21 años</option>
                                </select>
                            </div>
                        </div>
                        <!-- Input para el tipo -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fa fa-user"></i></span>
                                <select class="form-control  input-lg search-combo texto-combo" style="width: 100%" name="editarDuegno" disabled>
                                    <option class="texto-combo" value="" id="editarDuegno"></option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="editarDuegnoID" name="editarDuegnoID">
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $editarMascota = new ControladorMascotas();
                $editarMascota->ctrEditarMascota();
                ?>
            </form>
        </div>

    </div>
</div>
<?php
$borrarMascota = new ControladorMascotas();
$borrarMascota->ctrBorrarMascota();
?>