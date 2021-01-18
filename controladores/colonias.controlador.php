<?php
class ControladorColonias
{
    public static function ctrMostrarColonias($item, $valor)
    {
        $tabla = "colonias";
        $respuesta = ModeloColonias::mdlMostrarColonias($tabla, $item, $valor);
        return $respuesta;
    }
    public static function ctrNuevaColonia()
    {
        if (isset($_POST["nuevaColonia"])) {
            if (preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaColonia"])) {
                $tabla = "colonias";
                $datos = $_POST["nuevaColonia"];
                $respuesta = ModeloColonias::mdlNuevaColonia($tabla, $datos);
                if ($respuesta == "ok") {

                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Colonia Agregada Con Éxito",
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
                        title: "Error Al Agregar Colonia",
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
                        title: "Llena Bien El Campo",
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
}
