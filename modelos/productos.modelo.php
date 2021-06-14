<?php

require_once "conexion.php";

class ModeloProductos
{

    /*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

    static public function mdlMostrarProductos($tabla, $item, $valor)
    {

        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {

            $estado = "producto_estado";
            $val = "1";
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $estado = :$estado");
            $stmt->bindParam(":" . $estado, $val, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    /*=============================================
	MOSTRAR PRODUCTOS MÁS VENDIDOS
	=============================================*/

    static public function mdlMostrarProductosMasVendidos()
    {

            $estado = "producto_estado";
            $val = "1";
            $stmt = Conexion::conectar()->prepare("SELECT * FROM productos WHERE $estado = :$estado ORDER BY producto_ventas DESC");
            $stmt->bindParam(":" . $estado, $val, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        
        $stmt = null;
    }
    /*=============================================
	REGISTRO DE PRODUCTO
	=============================================*/
    static public function mdlIngresarProducto($tabla, $datos)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $fechaActual = $fecha . ' ' . $hora;
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(producto_nombre, 
            marca_id, 
            producto_duracion, 
            producto_costo, 
            producto_puntos, 
            producto_tope, 
            producto_foto,
            producto_fecha,
            sesion_id) 
            VALUES (:producto_nombre, 
            :marca_id, 
            :producto_duracion, 
            :producto_costo, 
            :producto_puntos, 
            :producto_tope, 
            :producto_foto,
            :producto_fecha,
            :sesion_id)");

        $stmt->bindParam(":producto_nombre", $datos["producto"], PDO::PARAM_STR);
        $stmt->bindParam(":marca_id", $datos["marca"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_duracion", $datos["duracion"], PDO::PARAM_INT);
        $stmt->bindParam(":producto_costo", $datos["costo"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_costo", $datos["costo"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_puntos", $datos["puntos"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_tope", $datos["tope"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_fecha", $fechaActual, PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $datos["sesion"], PDO::PARAM_INT);
        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }


        $stmt = null;
    }

    /*=============================================
	EDITAR PRODUCTO
	=============================================*/
    static public function mdlEditarProducto($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET 
            producto_duracion=:producto_duracion, 
            producto_costo=:producto_costo, 
            producto_puntos=:producto_puntos, 
            producto_tope=:producto_tope, 
            producto_foto=:producto_foto
            WHERE producto_nombre= :producto_nombre");

        $stmt->bindParam(":producto_duracion", $datos["duracion"], PDO::PARAM_INT);
        $stmt->bindParam(":producto_costo", $datos["costo"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_puntos", $datos["puntos"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_tope", $datos["tope"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $datos["producto"], PDO::PARAM_STR);
        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }


        $stmt = null;
    }

    /*=============================================
	BORRAR PRODUCTO
	=============================================*/

    static public function mdlEliminarProducto($tabla, $datos)
    {

        $estado = "0";
        $foto = "vistas/img/productos/default/anonymous.png";
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
                                                set producto_estado=:producto_estado,
                                                    producto_foto=:producto_foto
                                                WHERE producto_nombre=:producto_nombre");
        $stmt->bindParam(":producto_estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":producto_foto", $foto, PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $datos, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt = null;
    }
    /*=============================================
ACTUALIZAR DATOS PRODUCTOS AL VENDER                             
=============================================*/
    static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE producto_nombre = :producto_nombre");
        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $valor, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }
    /*=============================================
    ACTUALIZAR INVENTARIO EN SUCURSAL                            
    =============================================*/
    static public function mdlActualizarInventario($tabla, $item, $valor, $producto, $sucursal)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE producto_nombre = :producto_nombre AND sucursal_nombre=:sucursal_nombre");
        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        $stmt->bindParam(":producto_nombre", $producto, PDO::PARAM_STR);
        $stmt->bindParam(":sucursal_nombre", $sucursal, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }
    /*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

    static public function mdlMostrarSumaVentas($tabla)
    {

        $stmt = Conexion::conectar()->prepare("SELECT SUM(producto_ventas) as total FROM $tabla");

        $stmt->execute();

        return $stmt->fetch();

        $stmt = null;
    }
}
