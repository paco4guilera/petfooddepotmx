<?php
require_once "conexion.php";
class ModeloAgenda
{
    static public function mdlIngresarAgenda($datosC)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO agenda (cliente_id,
                                                                    venta_id,
                                                                    agenda_fecha)
                                                                VALUES(:cliente_id,
                                                                    :venta_id,
                                                                    :agenda_fecha)");
        $stmt->bindParam(":cliente_id", $datosC["cliente"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_id", $datosC["venta"], PDO::PARAM_STR);
        $stmt->bindParam(":agenda_fecha", $datosC["fecha"], PDO::PARAM_STR);
        return $stmt->execute();
        $stmt = null;
    }
    static public function mdlMostrarAgenda($item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT C.cliente_id,
                                                        C.cliente_nombre, 
                                                        C.cliente_telefono, 
                                                        A.agenda_id,
                                                        A.agenda_fecha,
                                                        A.venta_id FROM agenda AS A
                                                        JOIN clientes AS C ON A.cliente_id=C.cliente_id
                                                        JOIN ventas AS V ON A.venta_id= V.venta_id
                                                        WHERE $item=:$item
                                                        ORDER BY A.agenda_fecha");
            $stmt->bindParam($item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } else {
            $stmt = Conexion::conectar()->prepare("SELECT C.cliente_id,
                                                        C.cliente_nombre, 
                                                        C.cliente_telefono,
                                                        A.agenda_id, 
                                                        A.agenda_fecha,
                                                        A.venta_id FROM agenda AS A
                                                        JOIN clientes AS C ON A.cliente_id=C.cliente_id
                                                        JOIN ventas AS V ON A.venta_id= V.venta_id
                                                        ORDER BY A.agenda_fecha");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        $stmt = null;
    }
    static public function mdlEliminarAgenda($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM agenda WHERE agenda_id=:agenda_id");
        $stmt->bindParam(":agenda_id", $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}
