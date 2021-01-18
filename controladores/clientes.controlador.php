<?php
class ControladorClientes
{
    static public function ctrCrearCliente()
    {
        if (isset($_POST["nuevoNombre"])) {
            if (
                preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevoTelefono"])
            ) {
                $tabla = "clientes";
                $datos = array(
                    "nombre" => $_POST["nuevoNombre"],
                    "telefono" => $_POST["nuevoTelefono"],
                    "correo" => $_POST["nuevoEmail"],
                    "colonia" => $_POST["nuevaColoniaCliente"],
                    "tipo" => $_POST["nuevoTipo"],
                    "sesion" => $_SESSION["sesion"]
                );

                $respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);
                $c = "C";
                $d = 'Se creó Cliente = ' . $datos["nombre"] . '; Teléfono = ' . $datos["telefono"] . '; Correo = ' . $datos["correo"] . '; Colonia = ' . $datos["colonia"] . '; Tipo = ' . $datos["tipo"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Cliente registrado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="' . $_GET["ruta"] . '";
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Cliente no registrado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="' . $_GET["ruta"] . '";
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
                            window.location="' . $_GET["ruta"] . '";
                        }
                    });
                    </script>';
            }
        }
    }
    static public function ctrMostrarClientes($item, $valor)
    {
        $tabla = "clientes";
        $respuesta = ModeloClientes::MdlMostrarClientes($tabla, $item, $valor);
        return $respuesta;
    }
    static public function ctrMostrarDescuento($item, $valor)
    {
        $respuesta = ModeloClientes::mdlMostrarDescuento($item, $valor);
        return $respuesta;
    }
    static public function ctrMostrarTipos($item, $valor)
    {
        $tabla = "tiposClientes";
        $respuesta = ModeloClientes::MdlMostrarTipos($tabla, $item, $valor);
        return $respuesta;
    }
    static public function ctrEditarDescuento()
    {
        if (isset($_POST["editarDescuento"])) {
            $datos = array(
                "nombre" => $_POST["editarDescuentoNombre"],
                "descuento" => $_POST["editarDescuento"]
            );
            $respuesta=ModeloClientes::mdlEditarDescuento($datos);
            $c = "D";
            $d = 'Se actualizó el tipo de Cliente = ' . $datos["nombre"] . '; Procentaje = ' . $datos["descuento"] .' %';
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Descuento Actualizado Con Éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="' . $_GET["ruta"] . '";
                        }
                    });
                    </script>';
            }

        }
    }
    /* Editar usuario */
    static public function ctrEditarCliente()
    {
        if (isset($_POST["editarNombre"])) {
            if (
                preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"]) &&
                preg_match('/^[0-9]+$/', $_POST["editarTelefono"])
            ) {
                $tabla = "clientes";
                $datos = array(
                    "id" => $_POST["idActual"],
                    "nombre" => $_POST["editarNombre"],
                    "telefono" => $_POST["editarTelefono"],
                    "correo" => $_POST["editarEmail"],
                    "colonia" => $_POST["editarColoniaCliente"],
                    "tipo" => $_POST["editarTipo"]
                );
                $respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
                $c = "C";
                $d = 'Se editó Cliente = ' . $datos["nombre"] . '; Teléfono = ' . $datos["telefono"] . '; Correo = ' . $datos["correo"] . '; Colonia = ' . $datos["colonia"] . '; Tipo = ' . $datos["tipo"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Cliente modificado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });
                    </script>';
                }
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
                            window.location="clientes";
                        }
                    });
                    </script>';
            }
        }
    }
    /* Borrar usuario */
    static public function ctrBorrarCliente()
    {
        if (isset($_GET["idCliente"])) {
            $tabla = "clientes";
            $datos = $_GET["idCliente"];
            $cliente = $_GET["nombreCliente"];
            $respuesta = ModeloClientes::mdlBorrarCliente($tabla, $datos);
            $c = "C";
            $d = 'Se eliminó Cliente = ' . $cliente . ' con id = ' . $datos;
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Cliente eliminado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });
                    </script>';
            } else {
                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Cliente no eliminado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });
                    </script>';
            }
        }
    }
}
