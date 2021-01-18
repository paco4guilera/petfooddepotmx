<?php

class ControladorMarcas
{

    /*=============================================
	CREAR Marcas
	=============================================*/

    static public function ctrCrearMarca()
    {

        if (isset($_POST["nuevaMarca"])) {

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaMarca"])) {

                $tabla = "marcas";

                $datos = $_POST["nuevaMarca"];

                $respuesta = ModeloMarcas::mdlIngresarMarca($tabla, $datos);

                if ($respuesta == "ok") {

                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Marca guardada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="marcas";
                        }
                    });
                    </script>';
                }
            } else {

                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "La marca no puede ir vacía o con caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="productos";
                        }
                    });
                    </script>';
            }
        }
    }

    /*=============================================
	MOSTRAR MARCA
	=============================================*/

    static public function ctrMostrarMarcas($item, $valor)
    {

        $tabla = "marcas";

        $respuesta = ModeloMarcas::mdlMostrarMarcas($tabla, $item, $valor);

        return $respuesta;
    }

    /*=============================================
	EDITAR MARCA
	=============================================*/

    static public function ctrEditarMarca()
    {

        if (isset($_POST["editarMarca"])) {

            if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarMarca"])) {

                $tabla = "marcas";

                $datos = array(
                    "marca" => $_POST["editarMarca"],
                    "id" => $_POST["idMarca"]
                );

                $respuesta = ModeloMarcas::mdlEditarMarca($tabla, $datos);

                if ($respuesta == "ok") {

                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Marca editada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="marcas";
                        }
                    });
                    </script>';
                }
            } else {

                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "La marca no puede ir vacía o con caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="marcas";
                        }
                    });
                    </script>';
            }
        }
    }

    /*=============================================
	BORRAR MARCA
	=============================================*/

    static public function ctrBorrarMarca()
    {

        if (isset($_GET["idMarca"])) {

            $tabla = "marcas";
            $datos = $_GET["idMarca"];

            $respuesta = ModeloMarcas::mdlBorrarMarca($tabla, $datos);

            if ($respuesta == "ok") {

                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Marca borrada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="marcas";
                        }
                    });
                    </script>';
            }
        }
    }
}
