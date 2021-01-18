<div class="content-wrapper">
    <section class="content-header">
        <?php
        echo '
        <h1>
        Vender En ' . $_SESSION["sucursal"] . '
        </h1>';
        ?>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Crear venta</li>
        </ol>
    </section>
    <section class="content">
        <!--=====================================
            LA TABLA DE PRODUCTOS
            ======================================-->

        <div class="box box-primary">
            <div class="box-header with-border">
                <h2>Cliente</h2>
            </div>
            <!--=====================================
                                ENTRADA DEL CLIENTE
                                ======================================-->
            <div class="row">
                <!-- 
                <div class="col-lg-3 col-xs-0"></div>
                -->
                <div class="col-lg-6 col-xs-12">
                    <div class="form-group search-combo">
                        <div class="input-group search-combo">
                            <span class="input-group-addon search-combo"><i class="fa fa-users"></i></span>
                            <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="seleccionarCliente" id="seleccionarCliente" required>
                                <option class="texto-combo" value="">Seleccionar cliente</option>
                                <?php
                                $item = null;
                                $valor = null;
                                $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
                                foreach ($clientes as $key => $value) {
                                    echo '<option value="' . $value["cliente_id"] . '">' . $value["cliente_id"] . ' - ' . $value["cliente_nombre"] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="input-group-addon  search-combo btn-add">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
                                    <i class=" fas fa-plus"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <h2>Productos</h2>
                <table class="table table-bordered table-striped dt-responsive tablaVentas" id="tablaVentas">
                    <thead>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre</th>
                            <th>Mayoreo</th>
                            <th>Menudeo</th>
                            <th>Inventario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
                <input type="hidden" value="<?php echo $_SESSION["sucursal"]; ?>" id="sucursal">


            </div>
        </div>
        <!--=====================================
            EL FORMULARIO
            ======================================-->
        <div class="box box-success">
            <div class="box-header with-border">
                <h2>Carrito</h2>
            </div>
            <form role="form" method="post" class="formularioVenta">
                <div class="box-body">
                    <input type="hidden" class="clienteFormulario" id="clienteFormulario" name="clienteFormulario">
                    <!-- 
                        <div class="box">
                    -->

                    <!--=====================================
                                ENTRADA PARA AGREGAR PRODUCTO
                                ======================================-->
                    <div class="nuevoProducto">

                    </div>
                    <input type="hidden" id="listaProductos" name="listaProductos">
                    <!--=====================================
                                BOTÓN PARA AGREGAR PRODUCTO
                                ======================================-->
                    <hr>
                    <div class="row">
                        <!--=====================================
                        ENTRADA DESCUENTO Y TOTAL
                        ======================================-->
                        <div class="col-xs-12 col-lg-5 pull-right">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Puntos Del Cliente</th>
                                        <th>Puntos Disponibles</th>
                                        <th>Puntos A Usar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 25%">
                                            <div class="input-group">
                                                <span class="input-group-addon ocultar-iconos"><i class="fas fa-piggy-bank"></i></span>
                                                <input type="number" class="form-control input-lg puntosCliente" min="0" id="puntosCliente" placeholder="0" name="puntosCliente" readonly>
                                            </div>
                                        </td>
                                        <td style="width: 25%">
                                            <div class="input-group">
                                                <span class="input-group-addon ocultar-iconos"><i class="fas fa-info"></i></span>
                                                <input type="number" class="form-control input-lg topePuntos" min="0" id="topePuntos" name="topePuntos" total="" value="0" readonly>
                                                <input type="hidden" class="totalPuntos" min="0" id="totalPuntos" name="totalPuntos" total="" value="0">
                                            </div>
                                        </td>
                                        <td style="width: 25%">
                                            <div class="input-group">
                                                <span class="input-group-addon ocultar-iconos"><i class="fas fa-coins"></i></span>
                                                <input type="number" class="form-control input-lg puntosClienteUsar" min="0" id="puntosClienteUsar" name="puntosClienteUsar" value="0" required>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-lg-5 pull-right">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Descuento Adicional</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 25%">
                                            <div class="input-group">
                                                <input type="number" class="form-control input-lg nuevoDescuentoVenta" min="0" id="nuevoDescuentoVenta" name="nuevoDescuentoVenta" value="0" required>
                                                <input type="hidden" name="nuevoPrecioDescuento" id="nuevoPrecioDescuento" required>
                                                <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto" required>
                                                <span class="input-group-addon"><i class="fas fa-percentage"></i></i></span>
                                            </div>
                                        </td>
                                        <td style="width: 25%">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                                <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="" placeholder="00000" readonly required>
                                                <input type="hidden" name="totalVenta" id="totalVenta">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <!--=====================================
                                ENTRADA MÉTODO DE PAGO
                                ======================================-->
                    <div class="form-group row">
                        <div class="col-xs-8 col-lg-4" style="padding-right:0px">
                            <div class="input-group">
                                <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                                    <option value="">Seleccione método de pago</option>
                                    <!-- <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Prestamo">Préstamo</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="cajasMetodoPago"></div>
                        <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">
                        <input type="hidden" id="fechaPrestamo">
                    </div>
                    <br>
                    <div class="form-group row contacto">
                        <div class="col-xs-6 col-sm-3 col-lg-2" style="padding-right:0px">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" class="minimal agendarContacto">
                                    Agendar Contacto
                                </label>
                            </div>
                            <div class="fechaContacto"></div>
                        </div>
                    </div>
                    <!-- <div class="form-group row contacto" style="margin-top: 0px;">
                        <div class="col-xs-3 col-lg-2" style="padding-right:0px">
                            <div class="form-group">
                                
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Finalizar Venta</button>
                </div>
            </form>
            <?php

            $guardarVenta = new ControladorVentas();
            $guardarVenta->ctrCrearVenta();
            ?>
        </div>
    </section>
</div>
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