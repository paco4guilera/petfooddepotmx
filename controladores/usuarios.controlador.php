<?php
class ControladorUsuarios
{

    static public function ctrIngresoUsuario()
    {
        if (isset($_POST["ingUsuario"])) {
            if (
                preg_match('/^[-a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
                preg_match('/^[-a-zA-Z0-9]+$/', $_POST["ingPassword"])
            ) {
                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $tabla = "usuarios";
                $item = "usuario_login";
                $valor = $_POST["ingUsuario"];
                $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
                if (
                    $respuesta["usuario_login"] == $_POST["ingUsuario"] &&
                    $respuesta["usuario_password"] == $encriptar
                ) {
                    if ($respuesta["usuario_estado"] == "1") {
                        //echo'<br><div class="alert alert-success">Bienvenido</div>';
                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["login"] = $respuesta["usuario_login"];
                        $_SESSION["nombre"] = $respuesta["usuario_nombre"];
                        $_SESSION["rol"] = $respuesta["usuario_rol"];
                        $_SESSION["foto"] = $respuesta["usuario_foto"];
                        $_SESSION["sucursal"] = $_POST["ingresoSucursal"];
                        //Sacar la fecha y hora para hacer el registro de sesión

                        date_default_timezone_set('America/Mexico_City');
                        $fecha = date('Y-m-d');
                        $hora = date('H:i:s');
                        $fechaActual = $fecha . ' ' . $hora;

                        $usuario = $respuesta["usuario_login"];
                        $inicioSesion = ModeloSesiones::mdlCrearSesion($fechaActual, $usuario);
                        //var_dump($inicioSesion);
                        if ($inicioSesion["MAX(sesion_id)"] != 0) {
                            $_SESSION["sesion"] = $inicioSesion["MAX(sesion_id)"];
                            echo '<script>
                                window.location = "inicio";
                                </script>';
                        } else {
                            $_SESSION["iniciarSesion"] = "error";
                            echo '<br><div class="alert alert-danger">Error al iniciar sesion, intente de nuevo</div>';
                        }
                    } else {
                        echo '<br><div class="alert alert-danger">Usuario desactivado</div>';
                    }
                } else {

                    echo '<br><div class="alert alert-danger">Error en los datos, vuelve a intentar</div>';
                }
            }
        }
    }
    static public function ctrCrearUsuario()
    {
        if (isset($_POST["nuevoLogin"])) {
            if (
                preg_match('/^[-a-zA-Z0-9]+$/', $_POST["nuevoLogin"]) &&
                preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
                preg_match('/^[-a-zA-Z0-9]+$/', $_POST["nuevoPassword"])
            ) {
                $ruta = "";
                if (isset($_FILES["nuevaFoto"]["tmp_name"])) {
                    list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;
                    $directorio = "vistas/img/usuarios/" . $_POST["nuevoLogin"];
                    mkdir($directorio, 0755);
                    /* De acuerdo al tipo de imagen, se hace algo diferente */

                    if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/usuarios/" . $_POST["nuevoLogin"] . "/" . $aleatorio . ".jpg";
                        $origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    } else if ($_FILES["nuevaFoto"]["type"] == "image/png") {
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/usuarios/" . $_POST["nuevoLogin"] . "/" . $aleatorio . ".png";
                        $origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "usuarios";
                $encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $datos = array(
                    "login" => $_POST["nuevoLogin"],
                    "nombre" => $_POST["nuevoNombre"],
                    "password" => $encriptar,
                    "rol" => $_POST["nuevoRol"],
                    "foto" => $ruta,
                    "sesion" => $_SESSION["sesion"]
                );
                $c = "U";
                $d = 'Se agregó Usuario = ' . $_POST["nuevoLogin"] . '; Nombre = ' . $_POST["nuevoNombre"] . '; Rol = ' . $_POST["nuevoRol"];
                $respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Usuario registrado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Usuario no registrado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                    </script>';
                }
            } else {
                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "El usuario no puede estar vacío ni con caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                    </script>';
            }
        }
    }
    static public function ctrMostrarUsuarios($item, $valor)
    {
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::MdlMostrarUsuarios($tabla, $item, $valor);
        return $respuesta;
    }
    /* Editar usuario */
    static public function ctrEditarUsuario()
    {
        if (isset($_POST["editarLogin"])) {
            if (preg_match('/^[-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombre"])) {

                $ruta = $_POST["fotoActual"];

                if (isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {
                    list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
                    $nuevoAncho = 500;
                    $nuevoAlto = 500;

                    $directorio = "vistas/img/usuarios/" . $_POST["editarLogin"];
                    //Existe foto?
                    if (!empty($_POST["fotoActual"])) {
                        unlink($_POST["fotoActual"]);
                    } else {
                        mkdir($directorio, 0755);
                    }

                    /* De acuerdo al tipo de imagen, se hace algo diferente */
                    if ($_FILES["editarFoto"]["type"] == "image/jpeg") {
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/usuarios/" . $_POST["editarLogin"] . "/" . $aleatorio . ".jpg";
                        $origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagejpeg($destino, $ruta);
                    }
                    if ($_FILES["editarFoto"]["type"] == "image/png") {
                        $aleatorio = mt_rand(100, 999);
                        $ruta = "vistas/img/usuarios/" . $_POST["editarLogin"] . "/" . $aleatorio . ".png";
                        $origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);
                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                        imagepng($destino, $ruta);
                    }
                }
                $tabla = "usuarios";
                if ($_POST["editarPassword"] != "") {
                    if (preg_match('/^[-a-zA-Z0-9]+$/', $_POST["editarPassword"])) {
                        $encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                    } else {
                        echo '<script>
                                    swal.fire({
                                        icon:"error",
                                        title: "La contraseña no puede estar vacía ni con caracteres especiales",
                                        showConfirmButton: true,
                                        confirmButtonText: "Cerrar",
                                        closeOnConfirm: false
                                    }).then((result)=>{
                                        if(result.value){
                                            window.location="usuarios";
                                        }
                                    });
                                    </script>';
                    }
                } else {
                    $encriptar = $_POST["passwordActual"];
                }
                $datos = array(
                    "nombre" => $_POST["editarNombre"],
                    "login" => $_POST["editarLogin"],
                    "password" => $encriptar,
                    "rol" => $_POST["editarRol"],
                    "foto" => $ruta
                );
                $respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);
                $c = "U";
                $d = 'Se editó Usuario = ' . $_POST["editarLogin"] . '; Nombre = ' . $_POST["editarNombre"] . '; Rol = ' . $_POST["editarRol"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Usuario modificado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                    </script>';
                }
            } else {
                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "Llena bien los campos",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                    </script>';
            }
        }
    }
    /* Borrar usuario */
    static public function ctrBorrarUsuario()
    {
        if (isset($_GET["idUsuario"])) {
            $tabla = "usuarios";
            $datos = $_GET["idUsuario"];
            /* if ($_GET["fotoUsuario"] != "") {
                unlink($_GET["fotoUsuario"]);
                rmdir('vistas/img/usuarios/' . $_GET["idUsuario"]);
            } */
            $respuesta = ModeloUsuarios::mdlBorrarUsuario($tabla, $datos);
            $c = "U";
            $d = 'Se eliminó Usuario = ' . $datos;
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Usuario eliminado con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="usuarios";
                        }
                    });
                    </script>';
            }
        }
    }
}
