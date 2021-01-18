<?php

require_once "conexion.php";

class ModeloSucursales
{

    /*=============================================
	CREAR SUCURSAL
	=============================================*/

    static public function mdlIngresarSucursal($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(sucursal_nombre,
                                                                    sucursal_telefono,
                                                                    usuario_login,
                                                                    sucursal_direccion,
                                                                    sesion_id) 
                                            VALUES (:sucursal_nombre,
                                                    :sucursal_telefono,
                                                    :usuario_login,
                                                    :sucursal_direccion,
                                                    :sesion_id)");
        $stmt->bindParam(":sucursal_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":sucursal_telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_login", $datos["encargado"], PDO::PARAM_STR);
        $stmt->bindParam(":sucursal_direccion", $datos["direccion"], PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $_SESSION["sesion"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt = null;
    }

    /*=============================================
	MOSTRAR SUCURSALES
	=============================================*/

    static public function mdlMostrarSucursales($tabla, $item, $valor)
    {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null;
    }

    /*=============================================
	MOSTRAR PRODUCTOS SUCURSALES
	=============================================*/
    static public function mdlMostrarProductosSucursal($tabla, $item, $valor, $sucursal)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT I.producto_nombre, I.producto_mayoreo,I.producto_menudeo, I.producto_inventario, P.producto_puntos,P.producto_tope 
                                                    FROM $tabla AS I join productos AS P ON P.producto_nombre = I.producto_nombre  
                                                    WHERE sucursal_nombre = :sucursal_nombre AND P.producto_nombre=:producto_nombre");
            $stmt->bindParam(":producto_nombre", $valor, PDO::PARAM_STR);
            $stmt->bindParam(":sucursal_nombre", $sucursal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT I.producto_nombre, I.producto_mayoreo,I.producto_menudeo, I.producto_inventario, P.producto_puntos,P.producto_tope 
                                                    FROM $tabla AS I join productos AS P ON P.producto_nombre = I.producto_nombre  
                                                    WHERE sucursal_nombre = :sucursal_nombre"
            );
            $stmt->bindParam(":sucursal_nombre", $sucursal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    /*=============================================
	MOSTRAR PRODUCTOS QUE SE PUEDEN AGREGAR
	=============================================*/
    static public function mdlMostrarProductosSucursalFaltantes($tabla, $item, $valor, $sucursal)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT I.producto_nombre, I.producto_mayoreo,I.producto_menudeo, I.producto_inventario, P.producto_puntos,P.producto_tope 
                                                    FROM $tabla AS I join productos AS P ON P.producto_nombre = I.producto_nombre  
                                                    WHERE sucursal_nombre = :sucursal_nombre AND P.producto_nombre=:producto_nombre");
            $stmt->bindParam(":producto_nombre", $valor, PDO::PARAM_STR);
            $stmt->bindParam(":sucursal_nombre", $sucursal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare(
                "SELECT I.producto_nombre, I.producto_mayoreo,I.producto_menudeo, I.producto_inventario, P.producto_puntos,P.producto_tope 
                                                    FROM $tabla AS I join productos AS P ON P.producto_nombre = I.producto_nombre  
                                                    WHERE sucursal_nombre = :sucursal_nombre"
            );
            $stmt->bindParam(":sucursal_nombre", $sucursal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }


    /*=============================================
	CREAR PRODUCTO EN SUCURSAL
	=============================================*/
    static public function mdlIngresarProducto($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(sucursal_nombre,
                                                                    producto_nombre,
                                                                    producto_inventario,
                                                                    producto_mayoreo,
                                                                    producto_menudeo,
                                                                    sesion_id) 
                                            VALUES (:sucursal_nombre,
                                                    :producto_nombre,
                                                    :producto_inventario,
                                                    :producto_mayoreo,
                                                    :producto_menudeo,
                                                    :sesion_id)");
        $stmt->bindParam(":sucursal_nombre", $datos["nombreSucursal"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $datos["nombreProducto"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_inventario", $datos["inventario"], PDO::PARAM_INT);
        $stmt->bindParam(":producto_mayoreo", $datos["mayoreo"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_menudeo", $datos["menudeo"], PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $_SESSION["sesion"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt = null;
    }
    /*=============================================
	EDITAR PRODUCTO EN SUCURSAL
	=============================================*/
    static public function mdlEditarProducto($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
                                                producto_inventario=:producto_inventario,
                                                producto_mayoreo=:producto_mayoreo,
                                                producto_menudeo=:producto_menudeo
                                                WHERE producto_nombre=:producto_nombre 
                                                AND   sucursal_nombre = :sucursal_nombre
                                                ");
        $stmt->bindParam(":producto_inventario", $datos["inventario"], PDO::PARAM_INT);
        $stmt->bindParam(":producto_mayoreo", $datos["mayoreo"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_menudeo", $datos["menudeo"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $datos["nombreProducto"], PDO::PARAM_STR);
        $stmt->bindParam(":sucursal_nombre", $datos["nombreSucursal"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt = null;
    }

    /*=============================================
	EDITAR SUCURSAL
	=============================================*/

    static public function mdlEditarSucursal($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
        sucursal_telefono = :sucursal_telefono, 
        usuario_login = :usuario_login
        WHERE sucursal_nombre = :sucursal_nombre");

        $stmt->bindParam(":sucursal_telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_login", $datos["encargado"], PDO::PARAM_STR);
        $stmt->bindParam(":sucursal_nombre", $datos["nombre"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt = null;
    }

    /*=============================================
	BORRAR SUCURSAL
	=============================================*/

    static public function mdlBorrarSucursal($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE sucursal_nombre = :sucursal_nombre");

        $stmt->bindParam(":sucursal_nombre", $datos, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt = null;
    }
    /*=============================================
	BORRAR PRODUCTO DE SUCURSAL
	=============================================*/

    static public function mdlBorrarProducto($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE sucursal_nombre = :sucursal_nombre AND producto_nombre=:producto_nombre ");

        $stmt->bindParam(":sucursal_nombre", $datos["sucursal"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $datos["producto"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt = null;
    }
}
