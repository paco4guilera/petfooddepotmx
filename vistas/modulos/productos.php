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
        <h1> Productos</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Productos</li>
        </ol>
    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <!-- 
        /*=============================================
        Tabla productos                             
        =============================================*/  
        -->
        <div class="box">
            <div class="box-header with-border">
                <!-- 
                    /*=============================================
                    Condicionar permiso para su aparición                             
                    =============================================*/ 
                -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
                    Agregar Producto
                </button>
                <!-- 
                    /*=============================================                          
                    =============================================*/ 
                -->
            </div>
            <div class="box-body">
                <!-- <table class="table table-bordered table-striped tablas"> -->
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-productos" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 2%;">#</th>
                            <th style="width: 16%;">Nombre</th>
                            <th style="width: 16%;">Marca</th>
                            <th style="width: 7%;">Foto</th>
                            <th style="width: 8%;">Costo</th>
                            <th style="width: 6%;">Puntos</th>
                            <th style="width: 6%;">Tope</th>
                            <th style="width: 6%;">Duración</th>
                            <th style="width: 14%;">Fecha</th>
                            <th style="width: 10%;">Sesión</th>
                            <th style="width: 9%;">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- 
/*=============================================
Agregar producto                             
=============================================*/  
-->
<div id="modalAgregarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Agregar Producto</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <!-- ENTRADA MARCA -->
                    <div class="form-group search-combo">
                        <!-- Input para marca-->
                        <div class="input-group search-combo">
                            <span class="input-group-addon search-combo"><i class="fas fa-certificate"></i></span>
                            <select class="form-control combo-search input-lg search-combo texto-combo" style="width: 100%" name="nuevoProductoMarca" required>
                                <option class="texto-combo" value="">Selecciona La Marca</option>
                                <?php
                                $item = null;
                                $valor = null;
                                $marcas = ControladorMarcas::ctrMostrarMarcas($item, $valor);
                                foreach ($marcas as $key => $value) {
                                    echo '<option value="' . $value["marca_id"] . '">' . $value["marca_nombre"] . '</option>';
                                }
                                ?>
                            </select>
                            <span class="input-group-addon  search-combo btn-add"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca"><i class=" fas fa-plus"></i></button></span>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE -->
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-bone"></i></span>
                            <input type="text" class="form-control input-lg" id="nuevoProducto" name="nuevoProducto" placeholder="Ingresar Nombre del Producto" required>
                        </div>
                    </div>
                    <!-- 
                    /*=============================================
                    Input de costo y duración                             
                    =============================================*/  -->
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA PRECIO COMPRA -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                <input type="number" step="any" class="form-control input-lg" name="nuevoPrecioCompra" id="nuevoPrecioCompra" min="0" placeholder="Precio De Compra" required>
                            </div>
                            <br>
                        </div>
                        <!-- ENTRADA PARA DURACIÓN -->
                        <div class="col-xs-12 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="number" class="form-control input-lg" name="nuevaDuracion" min="0" placeholder="Días De Duración" required>
                            </div>
                        </div>
                    </div>
                    <!-- 
                    /*=============================================
                    Input de puntos y tope                           
                    =============================================*/  -->
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA PUNTOS -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-coins"></i></i></span>
                                <input type="number" class="form-control input-lg" name="nuevoPuntos" id="nuevoPuntos" min="0" placeholder="Puntos Por Compra" required>
                            </div>
                            <br>
                        </div>
                        <!-- ENTRADA PARA TOPE DE USO -->
                        <div class="col-xs-12 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-stop-circle"></i></span>
                                <input type="number" class="form-control input-lg" name="nuevoTope" min="0" placeholder="Tope Puntos X Compra" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA SUBIR FOTO -->
                    <div class="form-group">
                        <div class="panel">SUBIR IMAGEN</div>
                        <input type="file" class="nuevaImagen" name="nuevaImagen">
                        <p class="help-block">Peso Máximo De La Imagen 2MB</p>
                        <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    </div>
                </div>
                <?php
                $crearProducto = new ControladorProductos();
                $crearProducto->ctrCrearProducto();
                ?>
            </form>
        </div>
    </div>
</div>
<!-- 
/*=============================================
Editar producto                             
=============================================*/  
-->
<div id="modalEditarProducto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <!--=====================================
                CABEZA DEL MODAL
                ======================================-->
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar producto</h4>
                </div>
                <!--=====================================
                CUERPO DEL MODAL
                ======================================-->
                <div class="modal-body">
                    <!-- Input para marca-->
                    <div class="form-group search-combo">
                        <div class="input-group search-combo">
                            <span class="input-group-addon search-combo"><i class="fas fa-certificate"></i></span>
                            <select class="form-control  input-lg " style="width: 100%" name="editarProductoMarca" disabled>
                                <option class="texto-combo" id="editarProductoMarca"></option>
                            </select>
                        </div>
                    </div>
                    <!-- ENTRADA PARA EL NOMBRE -->
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-bone"></i></span>
                            <input type="text" class="form-control input-lg" id="editarProducto" name="editarProducto" placeholder="Ingresar Nombre" readonly>
                        </div>
                    </div>
                    <!-- ENTRADA MARCA -->
                    <!-- 
                    /*=============================================
                    Input costo y duracion                             
                    =============================================*/  -->
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA PRECIO COMPRA -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                                <input type="number" step="any" class="form-control input-lg" name="editarPrecioCompra" id="editarPrecioCompra" min="0" placeholder="Precio compra" required>
                            </div>
                            <br>
                        </div>
                        <!-- ENTRADA PARA DURACIÓN -->
                        <div class="col-xs-12 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="number" class="form-control input-lg" name="editarDuracion" id="editarDuracion" min="0" placeholder="Días De Duración" required>
                            </div>
                        </div>
                    </div>
                    <!--
                    /*=============================================
                    Input de puntos y tope
                    =============================================*/ -->
                    <div class="form-group row">
                        <div class="col-xs-12 col-sm-6">
                            <!-- ENTRADA PARA PUNTOS -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-coins"></i></i></span>
                                <input type="number" class="form-control input-lg" name="editarPuntos" id="editarPuntos" min="0" placeholder="Puntos Por Compra" required>
                            </div>
                            <br>
                        </div>
                        <!-- ENTRADA PARA TOPE DE USO -->
                        <div class="col-xs-12 col-sm-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-stop-circle"></i></span>
                                <input type="number" class="form-control input-lg" name="editarTope" id="editarTope" min="0" placeholder="Tope Puntos X Compra" required>
                            </div>
                        </div>
                    </div>
                    <!-- ENTRADA PARA SUBIR FOTO -->
                    <div class="form-group">
                        <div class="panel">SUBIR IMAGEN</div>
                        <input type="file" class="nuevaImagen" name="editarImagen">
                        <p class="help-block">Peso máximo de la imagen 2MB</p>
                        <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                        <input type="hidden" name="imagenActual" id="imagenActual">
                    </div>
                </div>
                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Guardar producto</button>
                    </div>
                </div>
                <?php
                $editarProducto = new ControladorProductos();
                $editarProducto->ctrEditarProducto();
                ?>
            </form>
        </div>
    </div>
</div>
<!--
/*=============================================
CREAR MARCA
=============================================*/
-->
<div id="modalAgregarMarca" class="modal fade" role="dialog">

    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form role="form" method="post" enctype="multipart/form-data">
                <div class="modal-header" style="background:#3c8dbc; color:white">
                    <button type=" button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Registro de Marca</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">

                        <!-- Input para el Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fas fa-certificate"></i></span>
                                <input type="text" class="form-control input-lg" name="nuevaMarca" id="nuevaMarca" placeholder="Marca" required>
                            </div>
                        </div><!-- Input para el nombre -->
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary ">Guardar</button>
                </div>
                <?php
                $crearMarca = new ControladorMarcas();
                $crearMarca->ctrCrearMarca();
                ?>
            </form>
        </div>

    </div>
</div>
<?php
$eliminarProducto = new ControladorProductos();
$eliminarProducto->ctrEliminarProducto();
?>