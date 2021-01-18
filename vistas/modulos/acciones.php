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
        <h1>Acciones</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"><i class="fa fa-dashboard"></i> Inicio</a>
            </li>
            <li class="active">Acciones</li>
        </ol>
    </section><!-- Base -->

    <!-- Main content -->
    <section class="content">
        <!-- 
        /*=============================================
        Tabla Acciones                         
        =============================================*/  
        -->

        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-condensed  table-hover dt-responsive tabla-acciones" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 15px;">#</th>
                            <th>Id</th>
                            <th style="max-width: 650px;">Descripción</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Sesion</th>
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