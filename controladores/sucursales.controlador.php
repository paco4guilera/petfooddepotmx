<?php

class ControladorSucursales
{

    /*=============================================
    INGRESAR PRODUCTO A SUCURSAL                             
    =============================================*/
    static public function ctrCrearProducto()
    {
        if (isset($_POST["nuevoProductoSucursal"])) {
            if (
                preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioMayoreo"]) &&
                preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioMenudeo"])
            ) {
                $tabla = "inventario";
                $datos = array(
                    "nombreProducto" => $_POST["nuevoProductoSucursal"],
                    "nombreSucursal" => $_SESSION["nombreSucursal"],
                    "inventario" => $_POST["nuevoInventario"],
                    "mayoreo" => $_POST["nuevoPrecioMayoreo"],
                    "menudeo" => $_POST["nuevoPrecioMenudeo"]
                );
                $respuesta = ModeloSucursales::mdlIngresarProducto($tabla, $datos);

                $c = "PS";
                $d = 'Se Ingresó Producto = ' . $_POST["nuevoProductoSucursal"] .  '; Inventario = ' . $_POST["nuevoInventario"] . '; Mayoreo = $' . $_POST["nuevoPrecioMayoreo"] . '; Menudeo = $' . $_POST["nuevoPrecioMenudeo"]  . '; En Sucursal = ' . $_SESSION["nombreSucursal"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Producto guardado en ' . $_GET["nombreSucursal"] . ' con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location = "sucursal";
                        }
                    });
                    </script>';
                }
            }
        }
    }
    /*=============================================
    INGRESAR PRODUCTO A SUCURSAL                             
    =============================================*/
    static public function ctrEditarProducto()
    {
        if (isset($_POST["editarProductoSucursal"])) {
            if (
                preg_match('/^[0-9.]+$/', $_POST["editarPrecioMayoreo"]) &&
                preg_match('/^[0-9.]+$/', $_POST["editarPrecioMenudeo"])
            ) {
                $tabla = "inventario";
                $datos = array(
                    "nombreProducto" => $_POST["editarProductoSucursal"],
                    "nombreSucursal" => $_SESSION["nombreSucursal"],
                    "inventario" => $_POST["editarInventario"],
                    "mayoreo" => $_POST["editarPrecioMayoreo"],
                    "menudeo" => $_POST["editarPrecioMenudeo"]
                );
                $respuesta = ModeloSucursales::mdlEditarProducto($tabla, $datos);

                $c = "PS";
                $d = 'Se Editó Producto = ' . $_POST["editarProductoSucursal"] .  '; Inventario = ' . $_POST["editarInventario"] . '; Mayoreo = $' . $_POST["editarPrecioMayoreo"] . '; Menudeo = $' . $_POST["editarPrecioMenudeo"]  . '; En Sucursal = ' . $_SESSION["nombreSucursal"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Producto editado en ' . $_GET["nombreSucursal"] . ' con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location = "sucursal";
                        }
                    });
                    </script>';
                }
            }
        }
    }
    /*=============================================
	CREAR Sucursales
	=============================================*/

    static public function ctrCrearSucursal()
    {

        if (isset($_POST["nuevaSucursal"])) {

            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaSucursal"]) &&
                preg_match('/^[0-9]+$/', $_POST["nuevoTelefonoSucursal"])
            ) {

                $tabla = "sucursales";

                $datos = array(
                    "nombre" => $_POST["nuevaSucursal"],
                    "telefono" => $_POST["nuevoTelefonoSucursal"],
                    "encargado" => $_POST["nuevoEncargado"],
                    "direccion" => $_POST["nuevaDireccionSucursal"]
                );

                $respuesta = ModeloSucursales::mdlIngresarSucursal($tabla, $datos);

                if ($respuesta == "ok") {

                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Sucursal guardada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="sucursales";
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
                            window.location="sucursales";
                        }
                    });
                    </script>';
            }
        }
    }

    /*=============================================
	MOSTRAR Sucursal
	=============================================*/
    static public function ctrMostrarSucursales($item, $valor)
    {
        $tabla = "sucursales";
        $respuesta = ModeloSucursales::mdlMostrarSucursales($tabla, $item, $valor);
        return $respuesta;
    }

    /*=============================================
	MOSTRAR PRODUCTOS DE SUCURSAL
	=============================================*/
    static public function ctrMostrarProductosSucursal($item, $valor, $sucursal)
    {
        $tabla = "inventario";
        $respuesta = ModeloSucursales::mdlMostrarProductosSucursal($tabla, $item, $valor, $sucursal);
        return $respuesta;
    }
    /*=============================================
	MOSTRAR PRODUCTOS  QUE SE PUEDEN AGREAR
	=============================================*/
    static public function ctrMostrarProductosSucursalFaltantes($item, $valor, $sucursal)
    {
        $tabla = "inventario";
        $respuesta = ModeloSucursales::mdlMostrarProductosSucursal($tabla, $item, $valor, $sucursal);
        return $respuesta;
    }
    /*=============================================
	EDITAR Sucursal
	=============================================*/
    static public function ctrEditarSucursal()
    {
        if (isset($_POST["editarTelefonoSucursal"])) {
            if (preg_match('/^[0-9]+$/', $_POST["editarTelefonoSucursal"])) {
                $tabla = "sucursales";
                $datos = array(
                    "nombre" => $_POST["editarSucursal"],
                    "telefono" => $_POST["editarTelefonoSucursal"],
                    "encargado" => $_POST["editarEncargado"],
                );
                $respuesta = ModeloSucursales::mdlEditarSucursal($tabla, $datos);
                $tu = "usuarios";
                $item = "usuario_login";
                $v = $_POST["editarEncargado"];
                $encargado = ModeloUsuarios::mdlMostrarUsuarios($tu, $item, $v);
                $c = "SC";
                $d = 'Se Editó Sucursal = ' . $_POST["editarSucursal"] .  '; Teléfono = ' . $_POST["editarTelefonoSucursal"] . '; Encargado = ' . $encargado["usuario_nombre"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Sucursal editada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="sucursales";
                        }
                    });
                    </script>';
                }
            } else {

                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "La Sucursal no puede ir vacía o con caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="sucursales";
                        }
                    });
                    </script>';
            }
        }
    }

    /*=============================================
	BORRAR Sucursal
	=============================================*/

    static public function ctrBorrarSucursal()
    {

        if (isset($_GET["idSucursal"])) {

            $tabla = "sucursales";
            $datos = $_GET["idSucursal"];

            $respuesta = ModeloSucursales::mdlBorrarSucursal($tabla, $datos);

            if ($respuesta == "ok") {

                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Sucursal borrada con éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="sucursales";
                        }
                    });
                    </script>';
            }
        }
    }
    /*=============================================
    BORRAR PRODUCTO DE SUCURSAL                             
    =============================================*/
    static public function ctrBorrarProducto()
    {

        if (isset($_GET["nombreProductoSucursal"])) {

            $tabla = "inventario";
            $datos = array(
                "producto" => $_GET["nombreProductoSucursal"],
                "sucursal" => $_GET["nombreSucursal"]

            );

            $respuesta = ModeloSucursales::mdlBorrarProducto($tabla, $datos);

            $c = "PS";
            $d = 'Se Eliminó Producto = ' . $_GET["nombreProductoSucursal"] .  '; En Sucursal = ' . $_GET["nombreSucursal"];
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
                    swal.fire({
                        icon:"success",
                        title: "Producto Eliminado De Sucursal Con Éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="sucursal";
                        }
                    });
                    </script>';
            }
        }
    }
}
