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
        <?php
        if (isset($_GET["nombreSucursal"])) {
            $_SESSION["nombreSucursal"] = $_GET["nombreSucursal"];
        } else {
            $_GET["nombreSucursal"] = $_SESSION["nombreSucursal"];
        }
        echo '
                    <h1>
                        ' . $_SESSION["nombreSucursal"] . '
                    </h1>
                ';
        ?>

        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <?php
            echo '
                    <li class="active">' . $_SESSION["nombreSucursal"] . '</li>
                ';
            ?>

        </ol>
    </section><!-- Base -->

    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalProductoSucursal">
                    Agregar Producto a Sucursal
                </button>
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Inventario</th>
                            <th>Mayoreo</th>
                            <th>Menudeo</th>
                            <!--  <th>Sesión</th>-->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = null;
                        $valor = null;
                        $sucursales = ControladorSucursales::ctrMostrarProductosSucursal($item, $valor, $_SESSION["nombreSucursal"]);
                        foreach ($sucursales as $key => $value) {
                            echo '<tr>
                            <td>' . $value["producto_nombre"] . '</td>
                            <td>' . $value["producto_inventario"] . '</td>
                            <td>$ ' . $value["producto_mayoreo"] . '</td>
                            <td>$ ' . $value["producto_menudeo"] . '</td>
                            ';
                            //echo '<td>' . $value["sesion_id"] . '</td>';
                            echo '
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-warning btnEditarProductoSucursal" nombreProducto="' . $value["producto_nombre"] . '" nombreSucursal="' . $_SESSION["nombreSucursal"] . '" data-toggle="modal" data-target="#modalEditarProductoSucursal">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-danger btnEliminarProductoSucursal" nombreProducto="' . $value["producto_nombre"] . '" nombreSucursal="' . $_SESSION["nombreSucursal"] . '">
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
CREAR PRODUCTO SUCRUSAL                        
=============================================*/  
-->
<div id="modalProductoSucursal" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <?php
                    echo '
                            <h4 class="modal-title">Nuevo Producto En ' . $_SESSION["nombreSucursal"] . '</h4>
                        ';
                    ?>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Input para el producto -->
                        <div class="form-group search-combo">
                            <div class="input-group search-combo">
                                <span class="input-group-addon search-combo"><i class="fas fa-bone"></i></span>
                                <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="nuevoProductoSucursal" id="nuevoProductoSucursal">
                                    <option class="texto-combo" value="">Selecciona El Producto</option>
                                    <?php
                                    $item = null;
                                    $valor = null;
                                    $usuarios = ControladorProductos::ctrMostrarProductos($item, $valor);
                                    foreach ($usuarios as $key => $value) {
                                        $itemMarca = "marca_id";
                                        $valorMarca = $value["marca_id"];
                                        $marca = ControladorMarcas::ctrMostrarMarcas($itemMarca, $valorMarca);
                                        echo '<option value="' . $value["producto_nombre"] . '">' . $marca["marca_nombre"] . ' - ' . $value["producto_nombre"] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><!-- Input para el producto -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6">
                                <!-- ENTRADA PARA PRECIO COMPRA -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-store"></i></span>
                                    <input type="number" class="form-control input-lg" name="costoProducto" id="costoProducto" placeholder="Costo Producto" readonly>
                                </div>
                                <br>
                            </div>
                            <!-- ENTRADA PARA INVENTARIO -->
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                    <input type="number" class="form-control input-lg" name="nuevoInventario" min="0" placeholder="Inventario" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO MAYOREO -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number" class="form-control input-lg" id="nuevoPrecioMayoreo" name="nuevoPrecioMayoreo" min="0" step="any" placeholder="Precio De Mayoreo" required>
                                </div>
                                <br>
                                <!-- CHECKBOX PARA PORCENTAJE -->
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="minimal porcentajeMayoreo" checked>
                                            Utilizar Porcentaje
                                        </label>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA PORCENTAJE -->
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg nuevoPorcentajeMayoreo" min="0" value="30" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA PRECIO MENUDEO -->
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number" class="form-control input-lg" id="nuevoPrecioMenudeo" name="nuevoPrecioMenudeo" min="0" step="any" placeholder="Precio De Menudeo" required>
                                </div>
                                <br>
                                <!-- CHECKBOX PARA PORCENTAJE -->
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="minimal porcentajeMenudeo" checked>
                                            Utilizar Porcentaje
                                        </label>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA PORCENTAJE -->
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg nuevoPorcentajeMenudeo" min="0" value="40" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $crearProducto = new ControladorSucursales();
                $crearProducto->ctrCrearProducto();
                ?>
            </form>
        </div>

    </div>
</div>
<!--
/*=============================================
EDITAR PRODUCTO SUCRUSAL                        
=============================================*/  
-->
<div id="modalEditarProductoSucursal" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <?php
                    echo '
                            <h4 class="modal-title">Editar Producto En ' . $_SESSION["nombreSucursal"] . '</h4>
                        ';
                    ?>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Input para el producto -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-bone"></i></span>
                                <input type="text" class="form-control input-lg" id="editarProductoSucursal" name="editarProductoSucursal" placeholder="Ingresar Nombre" readonly>
                            </div>
                        </div><!-- Input para el producto -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6">
                                <!-- ENTRADA PARA PRECIO COMPRA -->
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-store"></i></span>
                                    <input type="number" class="form-control input-lg" name="editarCostoProducto" id="editarCostoProducto" placeholder="Costo Producto" readonly>
                                </div>
                                <br>
                            </div>
                            <!-- ENTRADA PARA INVENTARIO -->
                            <div class="col-xs-12 col-sm-6">

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                    <input type="number" class="form-control input-lg" name="editarInventario" id="editarInventario" min="0" placeholder="Inventario" required>
                                </div>
                            </div>
                        </div>
                        <!-- ENTRADA PARA PRECIO MAYOREO -->
                        <div class="form-group row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number" class="form-control input-lg" id="editarPrecioMayoreo" name="editarPrecioMayoreo" min="0" step="any" placeholder="Precio De Mayoreo" required>
                                </div>
                                <br>
                                <!-- CHECKBOX PARA PORCENTAJE -->
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="minimal porcentajeMayoreo" checked>
                                            Utilizar Porcentaje
                                        </label>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA PORCENTAJE -->
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg nuevoPorcentajeMayoreo" id="editarPorcentajeMayoreo" min="0" value="40" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                            <!-- ENTRADA PARA PRECIO MENUDEO -->
                            <div class="col-xs-12 col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                                    <input type="number" class="form-control input-lg" id="editarPrecioMenudeo" name="editarPrecioMenudeo" min="0" step="any" placeholder="Precio De Menudeo" required>
                                </div>
                                <br>
                                <!-- CHECKBOX PARA PORCENTAJE -->
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" class="minimal porcentajeMenudeo" checked>
                                            Utilizar Porcentaje
                                        </label>
                                    </div>
                                </div>
                                <!-- ENTRADA PARA PORCENTAJE -->
                                <div class="col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg nuevoPorcentajeMenudeo" id="editarPorcentajeMenudeo" min="0" value="40" required>
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $editarProducto = new ControladorSucursales();
                $editarProducto->ctrEditarProducto();
                ?>
            </form>
        </div>

    </div>
</div>

<?php
$borrarProducto = new ControladorSucursales();
$borrarProducto->ctrBorrarProducto();
?>