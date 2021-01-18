<?php
require_once "conexion.php";
class ModeloSesiones{
    static public function mdlCrearSesion($fecha,$usuario){
        $tabla="sesiones";
        $stmt= Conexion::conectar()->prepare("INSERT INTO $tabla (
                                                                sesion_inicio,
                                                                usuario_login)

                                                        VALUES (:sesion_inicio, 
                                                                :usuario_login)");
        $stmt->bindParam(":sesion_inicio",$fecha,PDO::PARAM_STR);
        $stmt->bindParam(":usuario_login",$usuario,PDO::PARAM_STR);
        if($stmt->execute()){
        $stmt= Conexion::conectar()->prepare("SELECT MAX(sesion_id) FROM $tabla WHERE  usuario_login=:usuario_login");
        $stmt->bindParam(":usuario_login",$usuario,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        }else{
            return 0;
        }
        $stmt=null;



    }
}