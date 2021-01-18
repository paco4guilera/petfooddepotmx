<?php
require_once "conexion.php";
class ModeloPrestamos
{
    static public function mdlIngresarPrestamo($datosP)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO prestamos (prestamo_monto,
                                                                        prestamo_caducidad,
                                                                        cliente_id,
                                                                        sesion_id,
                                                                        venta_id)
                                                                VALUES(:prestamo_monto,
                                                                        :prestamo_caducidad,
                                                                        :cliente_id,
                                                                        :sesion_id,
                                                                        :venta_id)");
        $stmt->bindParam(":prestamo_monto", $datosP["monto"], PDO::PARAM_STR);
        $stmt->bindParam(":prestamo_caducidad", $datosP["caducidad"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $datosP["cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $datosP["sesion"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_id", $datosP["venta"], PDO::PARAM_STR);
        return $stmt->execute();
        $stmt = null;
    }
    static public function mdlMostrarPrestamos($item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT C.cliente_id,
                                                        C.cliente_nombre, 
                                                        C.cliente_telefono, 
                                                        P.prestamo_id,
                                                        P.prestamo_monto, 
                                                        P.prestamo_caducidad, 
                                                        P.venta_id FROM prestamos AS P
                                                        JOIN clientes AS C ON P.cliente_id=C.cliente_id
                                                        JOIN ventas AS V ON P.venta_id= V.venta_id
                                                        WHERE $item=:$item
                                                        ORDER BY P.prestamo_caducidad");
            $stmt->bindParam($item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT C.cliente_id,
                                                        C.cliente_nombre, 
                                                        C.cliente_telefono, 
                                                        P.prestamo_id,
                                                        P.prestamo_monto, 
                                                        P.prestamo_caducidad, 
                                                        P.venta_id FROM prestamos AS P
                                                        JOIN clientes AS C ON P.cliente_id=C.cliente_id
                                                        JOIN ventas AS V ON P.venta_id= V.venta_id
                                                        ORDER BY P.prestamo_caducidad");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    static public function mdlEliminarPrestamo($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM prestamos WHERE prestamo_id=:prestamo_id");
        $stmt->bindParam(":prestamo_id", $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}
