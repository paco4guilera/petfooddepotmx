<?php
require_once "conexion.php";
class ModeloUsuarios
{
    /* Mostrar usuarios */
    static public function mdlMostrarUsuarios($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $estado = "usuario_estado";
            $val = "1";
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $estado = :$estado");
            $stmt->bindParam(":" . $estado, $val, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt = null;
    }
    static public function mdlIngresarUsuario($tabla, $datos)
    {
        // $estado="1";
        // $numsesion=1;
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (  usuario_login,
                                usuario_nombre,
                                usuario_password,
                                usuario_rol,
                                usuario_foto,
                                sesion_id) 
        VALUES (:usuario_login,
                :usuario_nombre,
                :usuario_password,
                :usuario_rol,
                :usuario_foto,
                :sesion_id)");

        $stmt->bindParam(":usuario_login", $datos["login"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_rol", $datos["rol"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $datos["sesion"], PDO::PARAM_INT);
        //$stmt->bindParam(":usuario_estado",$estado,PDO::PARAM_STR);
        // /* Reemplazar para que guarde la sesion actual */
        //$stmt->bindParam(":sesion_id",$numsesion,PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            //var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt = null;
    }
    static public function mdlEditarUsuario($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
        SET usuario_nombre=:usuario_nombre,
        usuario_password=:usuario_password,
        usuario_rol=:usuario_rol,
        usuario_foto=:usuario_foto 
        WHERE usuario_login=:usuario_login");

        $stmt->bindParam(":usuario_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_rol", $datos["rol"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario_login", $datos["login"], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            //var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt = null;
    }
    /* Borrar Usuario */
    static public function mdlBorrarUsuario($tabla, $datos)
    {
        $estado = "0";
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
                                                set usuario_estado=:usuario_estado
                                                WHERE usuario_login=:usuario_login");
        $stmt->bindParam(":usuario_estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":usuario_login", $datos, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            //var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt = null;
    }
}
