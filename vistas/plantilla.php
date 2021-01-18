<?php
session_start();
$_SESSION['Ancho'] = null;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Pet Food Depot</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!-- Plug ins CSS-------------------------------------------------------------------------- -->
    <link rel="icon" href="vistas/img/plantilla/tienda-de-animales.png">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" />
    <!-- Data Tables -->
    <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <!--Select 2-------------------------------------------------------------------------  -->
    <!-- 
    <link rel="stylesheet" href="vistas/dist/css/alt/AdminLTE-select2.css">
    -->
    <link rel="stylesheet" href="vistas/bower_components/select2/dist/css/select2.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
    <!-- TIME PICKER-->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
    <!-- jQuery 3 -->
    <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="vistas/dist/js/adminlte.min.js"></script>
    <!-- Data tables -->
    <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>
    <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
    <!-- Font awesome nuevo -->
    <script src="https://kit.fontawesome.com/d2da642bf8.js" crossorigin="anonymous"></script>
    <!-- Select2 -->
    <script src="vistas/bower_components/select2/dist/js/select2.full.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="vistas/plugins/iCheck/icheck.min.js"></script>

    <!-- InputMask -->
    <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- jQuery Number -->
    <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>
    <!-- jQuery DATEPICKER-->
    <script src="vistas/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

    <!-- daterangepicker http://www.daterangepicker.com/-->
    <!-- <script src="vistas/bower_components/moment/min/moment.min.js"></script>
    <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->

    <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
    <script src="vistas/bower_components/raphael/raphael.min.js"></script>
    <script src="vistas/bower_components/morris.js/morris.min.js"></script>

    <!-- ChartJS http://www.chartjs.org/-->
    <script src="vistas/bower_components/Chart.js/Chart.js"></script>
    <!-- css personalizado -->
    <link rel="stylesheet" href="vistas/css/personalizado.css">


</head>
<!-- Cuerpo documento -------------------------------------------------------------------------------- -->
<script>
    let ancho = window.innerWidth;
    let cuerpo;
    if (ancho > 768) {
        cuerpo = "<body class=\"hold-transition skin-blue sidebar-mini login-page sidebar-collapse \" style= \"height: auto; min-height: 100% \">"
    } else {
        cuerpo = "<body class=\"hold-transition skin-blue sidebar-mini login-page \" style= \"height: auto; min-height: 100% \">"
    }
    document.write(cuerpo);
    window.addEventListener("resize", function() {
        if (screen.width > 768) {
            location.reload();
        }

    });
</script>


<!-- Site wrapper -->

<?php
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {
    echo '<div class="wrapper">';
    /* CABEZOTE */
    include "modulos/cabezote.php";
    /* MENÚ */
    include "modulos/menu.php";
    if (isset($_GET["ruta"])) {
        if (
            $_GET["ruta"] == "inicio" ||
            $_GET["ruta"] == "usuarios" ||
            $_GET["ruta"] == "mascotas" ||
            $_GET["ruta"] == "productos" ||
            $_GET["ruta"] == "clientes" ||
            $_GET["ruta"] == "tipos-clientes" ||
            $_GET["ruta"] == "agenda" ||
            $_GET["ruta"] == "vender" ||
            $_GET["ruta"] == "reporte-ventas" ||
            $_GET["ruta"] == "historial-ventas" ||
            $_GET["ruta"] == "detalles-venta" ||
            $_GET["ruta"] == "prestamos" ||
            $_GET["ruta"] == "sucursales" ||
            $_GET["ruta"] == "sucursal" ||
            $_GET["ruta"] == "acciones" ||
            $_GET["ruta"] == "salir"
        ) {
            include "modulos/" . $_GET["ruta"] . ".php";
        } else {
            include "modulos/404.php";
        }
    } else {
        include "modulos/inicio.php";
    }
    /* Footer */
    include "modulos/footer.php";
    echo '</div>';
} else {
    include "modulos/login.php";
}

?>



<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/mascotas.js"></script>
<script src="vistas/js/productos.js"></script>
<script src="vistas/js/sucursales.js"></script>
<script src="vistas/js/acciones.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/prestamos.js"></script>
<script src="vistas/js/agenda.js"></script>
<script src="vistas/js/historial-ventas.js"></script>
</body>



</html>