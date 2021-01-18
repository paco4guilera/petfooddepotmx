<div class="login-box">
    <div class="login-logo">
        <img src="vistas/img/plantilla/logopng.png" alt="logo principal" class="img-responsive" style="padding:0px 75px">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Ingresar al sistema</p>

        <form method="post">
            <div class="form-group has-feedback">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-store"></i></span>
                    <select class="form-control input-lg" name="ingresoSucursal" required>
                        <option value="">Selecione Sucursal</option>
                        <?php
                        $tabla = "sucursales";
                        $item = null;
                        $valor = null;
                        $sucursales = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor);
                        foreach ($sucursales as $key => $value) {
                            echo '
                                <option value="' . $value["sucursal_nombre"] . '">' . $value["sucursal_nombre"] . '</option>
                                ';
                        }
                        ?>
                    </select>
                </div><br>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
                <?php
                $login = new ControladorUsuarios();
                $login->ctrIngresoUsuario();
                ?>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->