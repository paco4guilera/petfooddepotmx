<?php
class ModeloColonias
{
    public static function mdlMostrarColonias($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ");
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
    public static function mdlNuevaColonia($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (colonia_nombre,sesion_id) VALUES(:colonia_nombre,:sesion_id) ");
        $stmt->bindParam(":colonia_nombre", $datos, PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $_SESSION["sesion"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
    }
}
