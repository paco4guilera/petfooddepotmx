<header class="main-header">
    <!-- LOGOTIPO -->
    <a href="inicio" class="logo">
        <!-- logo mini -->
        <span class="logo-mini">
            <img src="vistas/img/plantilla/tienda-de-animales.png" class="img-responsive" style="padding:5px" alt="logo mini">
        </span>
        <!-- logo normal -->
        <span class="logo-lg logo-escritorio">
            <img src="vistas/img/plantilla/logo-lineal.png" class="img-responsive  img-cel " style="padding:5px 0px" alt="logo normal">
        </span>
        <!-- <span class="logo-xs">
            <img src="vistas/img/plantilla/logo-lineal.png" class="img-responsive" style="padding:0px 0px 0px 20px"
                alt="logo normal">
        </span> -->
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Botón de navegación -->
        <a href="#" class="sidebar-toggle " data-toggle="push-menu" role="button">
            <span class="sr-only"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if ($_SESSION["foto"] != "") {
                            echo '<img src="' . $_SESSION["foto"] . '" alt="default" class="user-image">';
                        } else {
                            echo '<img src="vistas/img/usuarios/default/anonymous.png" alt="default" class="user-image">';
                        }
                        ?>
                        <span class="hidden-xs"><?php echo $_SESSION["nombre"]; ?></span>
                    </a>
                    <!-- Dropdown toggle-->
                    <ul class="dropdown-menu">
                        <li class="user-body">
                            <div class="pull-right">
                                <a href="salir" class="btn btn-default btn-flat">
                                    Salir
                                </a>
                            </div>
                            <div class="pull-left">
                                <p>Sesión: <?php echo $_SESSION["sesion"]; ?></p>
                                <p>Sucursal: <?php echo $_SESSION["sucursal"]; ?></p>
                            </div>

                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>