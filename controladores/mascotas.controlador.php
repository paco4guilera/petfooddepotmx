<?php
class ControladorMascotas
{

    static public function ctrCrearMascota()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"])) {
                $tabla = "mascotas";
                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "raza" => $_POST["nuevaRaza"],
                    "peso" => $_POST["nuevoPeso"],
                    "edad" => $_POST["nuevaEdad"],
                    "duegno" => $_POST["nuevoDuegno"],
                    "sesion" => $_SESSION["sesion"]
                );

                $respuesta = ModeloMascotas::mdlIngresarMascota($tabla, $datos);
                $tc = "clientes";
                $item = "cliente_id";
                $cliente = ModeloClientes::mdlMostrarClientes($tc, $item, $_POST["nuevoDuegno"]);
                $c = "M";
                $d = 'Se Registró Mascota = ' . $_POST["nuevoNombre"] . '; Raza = ' . $_POST["nuevaRaza"]  . '; Peso = ' . $_POST["nuevoPeso"] . ' Kg; Edad = ' . $_POST["nuevaEdad"]  . '; Dueño = ' . $cliente["cliente_nombre"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Mascota registrada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Mascota no registrada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
                }
            } else {
                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "¡No dejes campos vacíos! ",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
            }
        }
    }
    static public function ctrMostrarMascotas($item, $valor)
    {
        $tabla = "mascotas";
        $respuesta = ModeloMascotas::MdlMostrarMascotas($tabla, $item, $valor);
        return $respuesta;
    }
    /* Editar usuario */
    static public function ctrEditarMascota()
    {
        if (isset($_POST["editarNombre"])) {
            if (
                preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarPeso"])
            ) {
                $tabla = "mascotas";
                $datos = array(
                    "id" => $_POST["idActual"],
                    "nombre" => $_POST["editarNombre"],
                    "raza" => $_POST["editarRaza"],
                    "peso" => $_POST["editarPeso"],
                    "edad" => $_POST["editarEdad"]
                );
                $respuesta = ModeloMascotas::mdlEditarMascota($tabla, $datos);
                $tc = "clientes";
                $item = "cliente_id";
                $cliente = ModeloClientes::mdlMostrarClientes($tc, $item, $_POST["editarDuegnoID"]);
                $c = "M";
                $d = 'Se Editó Mascota = ' . $_POST["editarNombre"] .  '; Peso = ' . $_POST["editarPeso"] . ' Kg; Edad = ' . $_POST["editarEdad"]  . '; Dueño = ' . $cliente["cliente_nombre"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Mascota modificada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
                }/* else{
                                echo'<script>
                    swal.fire({
                        icon:"error",
                        title: "Mascota no modificada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
                            } */
            } else {
                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Verifique los datos ingresados",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
            }
        }
    }
    /* Borrar usuario */
    static public function ctrBorrarMascota()
    {
        if (isset($_GET["idMascota"])) {
            $tabla = "mascotas";
            $datos = $_GET["idMascota"];
            $tm = "mascotas";
            $item = "mascota_id";
            $mascota = ModeloMascotas::mdlMostrarMascotas($tm, $item, $_GET["idMascota"]);
            $tc = "clientes";
            $item = "cliente_id";
            $cliente = ModeloClientes::mdlMostrarClientes($tc, $item, $mascota["cliente_id"]);
            $c = "M";
            $d = 'Se Eliminó Mascota = ' . $mascota["mascota_nombre"] . '; Dueño = ' . $cliente["cliente_nombre"] . ' Id = ' . $mascota["mascota_id"];
            $respuesta = ModeloMascotas::mdlBorrarMascota($tabla, $datos);
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Mascota eliminada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
            } else {
                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Mascota no eliminada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="mascotas";
                        }
                    });
                    </script>';
            }
        }
    }
}
