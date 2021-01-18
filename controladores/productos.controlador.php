<?php

class ControladorProductos
{

    /*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

    static public function ctrMostrarProductos($item, $valor)
    {
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
	CREAR PRODUCTO
	=============================================*/

    static public function ctrCrearProducto()
    {
        if (isset($_POST["nuevoProducto"])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoProducto"]) &&
                preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"])
            ) {
                /*=============================================
				VALIDAR IMAGEN
				=============================================*/

                $ruta = "vistas/img/productos/default/anonymous.png";

                if (isset($_FILES["nuevaImagen"]["tmp_name"])) {
                    list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;
                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/
                    $directorio = "vistas/img/productos/" . $_POST["nuevoProducto"];
                    mkdir($directorio, 0755);
                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/
                    if ($_FILES["nuevaImagen"]["type"] == "image/jpeg") {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/productos/" . $_POST["nuevoProducto"] . "/" . $aleatorio . ".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if ($_FILES["nuevaImagen"]["type"] == "image/png") {
                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/productos/" . $_POST["nuevoProducto"] . "/" . $aleatorio . ".png";
                        $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "productos";

                $datos = array(
                    "producto" => $_POST["nuevoProducto"],
                    "marca" => $_POST["nuevoProductoMarca"],
                    "duracion" => $_POST["nuevaDuracion"],
                    "costo" => $_POST["nuevoPrecioCompra"],
                    "puntos" => $_POST["nuevoPuntos"],
                    "tope" => $_POST["nuevoTope"],
                    "foto" => $ruta,
                    "sesion" => $_SESSION["sesion"],
                );

                $respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);

                if ($respuesta == "ok") {
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Producto registrado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="productos";
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Producto no registrado con éxito",
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
            } else {

                echo '
            <script>
					swal({
						type: "error",
						title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})
			</script>';
            }
        }
    }

    /*=============================================
	EDITAR PRODUCTO
	=============================================*/

    static public function ctrEditarProducto()
    {

        if (isset($_POST["editarPrecioCompra"])) {


            if (
                preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"])
            ) {

                /*=============================================
				VALIDAR IMAGEN
				=============================================*/

                $ruta = $_POST["imagenActual"];

                if (isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])) {

                    list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    /*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

                    $directorio = "vistas/img/productos/" . $_POST["editarProducto"];

                    /*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

                    if (!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png") {

                        unlink($_POST["imagenActual"]);
                    } else {

                        mkdir($directorio, 0755);
                    }

                    /*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

                    if ($_FILES["editarImagen"]["type"] == "image/jpeg") {

                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/productos/" . $_POST["editarProducto"] . "/" . $aleatorio . ".jpg";

                        $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);
                    }

                    if ($_FILES["editarImagen"]["type"] == "image/png") {

                        /*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

                        $aleatorio = mt_rand(100, 999);

                        $ruta = "vistas/img/productos/" . $_POST["editarProducto"] . "/" . $aleatorio . ".png";

                        $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);
                    }
                }

                $tabla = "productos";

                $datos = array(
                    "producto" => $_POST["editarProducto"],
                    "duracion" => $_POST["editarDuracion"],
                    "costo" => $_POST["editarPrecioCompra"],
                    "puntos" => $_POST["editarPuntos"],
                    "tope" => $_POST["editarTope"],
                    "foto" => $ruta
                );

                $respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);
                $c = "P";
                $d = 'Se Editó Producto = ' . $_POST["editarProducto"] . '; Duración = ' . $_POST["editarDuracion"] . ' días; Costo = ' . $_POST["editarCosto"] . '; Puntos = ' . $_POST["editarPuntos"] . '; Tope = ' . $_POST["editarTope"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Producto editado con éxito",
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
            } else {

                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Lenna todos los datos correctamente",
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
	BORRAR PRODUCTO
	=============================================*/
    static public function ctrEliminarProducto()
    {

        if (isset($_GET["nombreProducto"])) {

            $tabla = "productos";
            $datos = $_GET["nombreProducto"];

            if ($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png") {

                unlink($_GET["imagen"]);
                rmdir('vistas/img/productos/' . $_GET["nombreProducto"]);
            }

            $respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

            $c = "P";
            $d = 'Se Eliminó Producto = ' . $_GET["nombreProducto"];
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Producto eliminado con éxito",
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
}
