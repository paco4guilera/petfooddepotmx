<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php
        if (isset($_GET["idVenta"])) {
            $_SESSION["idVenta"] = $_GET["idVenta"];
        } else {
            $_GET["idVenta"] = $_SESSION["idVenta"];
        }
        ?>

    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <button class="btn btn-primary btnVolverVentas">
                    Volver
                </button>
                <?php
                echo '<h2>Detalles De La Venta: ' . $_SESSION["idVenta"] . ' </h2>';
                ?>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-datos-ventas">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $item = "venta_id";
                        $valor = $_SESSION["idVenta"];
                        $venta = ControladorVentas::ctrMostrarVentas($item, $valor);
                        echo '
                        <tr>
                            <td>Nombre Cliente:</td>
                            <td>' . $venta["cliente_nombre"] . '</td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Tipo Cliente:</td>
                            <td>' . $venta["cliente_tipo"] . '</td>
                        </tr>';
                        if ($venta["venta_descuento_cliente"] > 0) {
                            echo '
                        <tr>
                            <td>Descuento Cliente:</td>
                            <td>' . $venta["venta_descuento_cliente"] . ' %</td>
                        </tr>';
                        }
                        if ($venta["venta_descuento_puntos"] > 0) {
                            echo '
                        <tr>
                            <td>Descuento Puntos:</td>
                            <td>' . $venta["venta_descuento_puntos"] . ' pts</td>
                        </tr>';
                        }
                        if ($venta["venta_descuento_adicional"] > 0) {
                            echo '
                        <tr>
                            <td>Descuento Adicional:</td>
                            <td>' . $venta["venta_descuento_adicional"] . ' %</td>
                        </tr>';
                        }
                        echo '
                        <tr>
                            <td>Método Pago:</td>
                            <td>' . $venta["venta_metodo_pago"] . '</td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Total Venta:</td>
                            <td>$ ' . $venta["venta_total"] . '</td>
                        </tr>';



                        echo '
                        <tr>
                            <td>IVA:</td>
                            <td>$ ' . $venta["venta_iva"] . ' </td>
                        </tr>';
                        if ($venta["venta_impuesto_adicional"] > 0) {
                            echo '
                        <tr>
                            <td>Impuesto Adicional:</td>
                            <td>$ ' . $venta["venta_impuesto_adicional"] . ' </td>
                        </tr>';
                        }
                        echo '
                        <tr>
                            <td>Venta Neto:</td>
                            <td>$ ' . $venta["venta_neto"] . ' </td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Puntos Venta:</td>
                            <td>' . $venta["venta_puntos"] . ' pts.</td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Fecha y Hora:</td>
                            <td>' . $venta["venta_fecha"] . ' </td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Vendedor:</td>
                            <td>' . $venta["usuario_nombre"] . '</td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Sesión:</td>
                            <td>' . $venta["sesion_id"] . '</td>
                        </tr>';
                        echo '
                        <tr>
                            <td>Sucursal:</td>
                            <td>' . $venta["sucursal_nombre"] . '</td>
                        </tr>';
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2>Productos Comprados</h2>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-plugin" style="width: 100%">
                    <thead>
                        <tr>
                            <td style="width: 15px">#</td>
                            <td>Producto</td>
                            <td>Precio</td>
                            <td>Descuento</td>
                            <td>Precio Final/Unidad</td>
                            <td>Cantidad</td>
                            <td>Puntos</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $array = json_decode($venta["venta_productos"], true);
                        $i = 0;
                        foreach ($array as $value) {
                            echo '<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $value["nombre"] . '</td>
                            <td>$ ' . $value["precioReal"] . '</td>
                            <td>' . $value["descuento"] . ' %</td>
                            <td>$ ' . $value["precioConDescuento"] . '</td>
                            <td>' . $value["cantidad"] . '</td>
                            <td>' . $value["puntos"] . ' pts.</td>
                            <td>$ ' . $value["total"] . '</td>
                            </tr>
                            ';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <form role="form" method="post" class="formularioVenta">
                <?php
                echo '
                        <input type="hidden" name="idVentaImprimirDetalles" value="' . $venta["venta_id"] . '">
                    ';
                ?>
                <div class="box-footer">
                    <?php
                    echo '
                        <button type="submit" class="btn btn-primary pull-right btnImprimirFactura" idVenta="' . $venta["venta_id"] . '">Imprimir Recibo</button>
                        ';

                    ?>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->