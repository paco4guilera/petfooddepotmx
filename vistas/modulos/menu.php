<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="active">
                <a href="inicio">
                    <i class="fa fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <?php
            if ($_SESSION["rol"] != "Vendedor") {
                echo '
                <li>
                    <a href="acciones">
                        <i class="fas fa-archive"></i>
                        <span>Acciones</span>
                    </a>
                </li>
                ';
            }
            ?>

            <li>
                <a href="agenda">
                    <i class="fa fa-calendar"></i>
                    <span>Agenda</span>
                </a>
            </li>

            <?php
            if ($_SESSION["rol"] != "Vendedor") {
                echo '
                <li>
                <a href="clientes">
                    <i class="fa fa-users"></i>
                    <span>Clientes</span>
                </a>
                </li>
                ';
            }
            ?>
            <li>
                <a href="mascotas">
                    <i class="fa fa-paw"></i>
                    <span>Mascotas</span>
                </a>
            </li>


            <?php
            if ($_SESSION["rol"] != "Vendedor") {
                echo '
                <li>
                <a href="productos">
                <i class="fas fa-bone"></i>
                <span> Productos</span>
                </a>
                </li>
                ';
            }
            echo '
                <li>
                <a href="prestamos">
                <i class="fas fa-comments-dollar"></i>
                <span> Préstamos</span>
                </a>
                </li>
                
                ';
            if ($_SESSION["rol"] != "Vendedor") {
                echo '
                    <li>
                    <a href="usuarios">
                    <i class="fa fa-user"></i>
                    <span>Usuarios</span>
                    </a>
                    </li>
                    
                    ';
            }
            ?>



            <!-- 
                /*=============================================
                VENTAS                             
                =============================================*/ 
            -->
            <li class="treeview menu-open">
                <a href="ventas">
                    <!-- <i class="fa fa-list-ul"></i> -->
                    <!-- <i class="fas fa-dollar-sign"></i> -->
                    <i class="fas fa-hand-holding-usd"></i>
                    <span> Ventas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li>
                        <a href="vender">
                            <i class="fas fa-cash-register"></i>
                            <span> Vender</span>
                        </a>
                    </li>
                    <?php
                    if ($_SESSION["rol"] != "Vendedor") {
                        echo '
                            <li>
                        <a href="historial-ventas">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span> Historial De Ventas</span>
                        </a>
                    </li>
                    <li>
                        <a href="reporte-ventas">
                            <i class="fas fa-chart-line"></i>
                            <span> Reporte de ventas</span>
                        </a>
                    </li>
                            ';
                    }
                    ?>

                </ul>
            </li>
            <!-- 
            /*=============================================
            SUCURSALES                             
            =============================================*/  -->
            <?php
            if ($_SESSION["rol"] != "Vendedor") {
                echo '
            <li class="treeview menu-open">
                <a href="#">
                    <i class="fas fa-store"></i>
                    <span>Sucursales </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" style="display: block;">

                    <li>
                        <a class="mostrar-sucursal" role="button" nombreSucursal="Bodega">
                            <i class="fas fa-store-alt"></i>
                            <span> Bodega</span>
                        </a>
                    </li>';

                $item = null;
                $valor = null;
                $sucursales = ControladorSucursales::ctrMostrarSucursales($item, $valor);
                foreach ($sucursales as $key => $value) {
                    if ($value["sucursal_nombre"] != "Bodega") {
                        echo '
                            <li>
                                <a class="mostrar-sucursal" role="button" nombreSucursal="' . $value["sucursal_nombre"] . '">
                                    <i class="fas fa-store-alt"></i>
                                    <span> ' . $value["sucursal_nombre"] . '</span>
                                </a>
                            </li>';
                    }
                }
                echo '
                    <li>
                        <a href="sucursales">
                            <i class="fas fa-star"></i>
                            <span>Administrar Sucursales</span>
                        </a>
                    </li>
                </ul>
            </li>
                    ';
            }
            ?>

        </ul>
    </section>
</aside>