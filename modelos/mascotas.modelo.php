<?php
require_once "conexion.php";
class ModeloMascotas{
/* Mostrar usuarios */
    static public function mdlMostrarMascotas($tabla,$item,$valor){
        if($item!=null){
        $stmt= Conexion::conectar()->prepare("SELECT M.mascota_id,M.mascota_nombre,M.mascota_raza,
                                                    M.mascota_peso,M.mascota_edad, C.cliente_id,
                                                    C.cliente_nombre, M.sesion_id
                                            FROM $tabla AS M JOIN clientes AS C
                                            ON M.cliente_id= C.cliente_id 
                                            WHERE $item = :$item ");
        $stmt-> bindParam(":".$item,$valor,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt-> fetch();
        }else{
            $stmt= Conexion::conectar()->prepare("SELECT M.mascota_id,M.mascota_nombre,M.mascota_raza,
                                                    M.mascota_peso,M.mascota_edad, C.cliente_id,
                                                    C.cliente_nombre, M.sesion_id
                                            FROM $tabla AS M JOIN clientes AS C
                                            ON M.cliente_id= C.cliente_id ");
            $stmt->execute();
        return $stmt-> fetchAll();
        } 
        
        $stmt=null;
        
    }
    static public function mdlIngresarMascota($tabla,$datos){
        // $estado="1";
        // $numsesion=1;
        $stmt= Conexion::conectar()->prepare
        ("INSERT INTO $tabla (  mascota_nombre,
                                mascota_raza,
                                mascota_peso,
                                mascota_edad,
                                cliente_id,
                                sesion_id
                                ) 
        VALUES (:mascota_nombre,
                :mascota_raza,
                :mascota_peso,
                :mascota_edad,
                :cliente_id,
                :sesion_id
                ) ");
        
        $stmt->bindParam(":mascota_nombre",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":mascota_raza",$datos["raza"],PDO::PARAM_STR);
        $stmt->bindParam(":mascota_peso",$datos["peso"],PDO::PARAM_INT);
        $stmt->bindParam(":mascota_edad",$datos["edad"],PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id",$datos["duegno"],PDO::PARAM_INT);
        $stmt->bindParam(":sesion_id",$datos["sesion"],PDO::PARAM_INT);
        
        //$stmt->bindParam(":usuario_estado",$estado,PDO::PARAM_STR);
        // /* Reemplazar para que guarde la sesion actual */
        //$stmt->bindParam(":sesion_id",$numsesion,PDO::PARAM_INT);
        
        if($stmt->execute()){
            return "ok";
        }else{
            //var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt=null;
    }
    
    static public function mdlEditarMascota($tabla,$datos){
        $stmt= Conexion::conectar()->prepare
        ("UPDATE $tabla 
        SET 
        mascota_nombre=:mascota_nombre,
        mascota_raza=:mascota_raza,
        mascota_peso=:mascota_peso,
        mascota_edad=:mascota_edad
        WHERE mascota_id=:mascota_id");

        $stmt->bindParam(":mascota_nombre",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":mascota_raza",$datos["raza"],PDO::PARAM_STR);
        $stmt->bindParam(":mascota_peso",$datos["peso"],PDO::PARAM_INT);
        $stmt->bindParam(":mascota_edad",$datos["edad"],PDO::PARAM_STR);
        $stmt->bindParam(":mascota_id",$datos["id"],PDO::PARAM_INT);
        if($stmt->execute()){
            return "ok";
        }else{
            var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt=null;
    }
    /* Borrar cliente */
    static public function mdlBorrarMascota($tabla,$datos){
    $stmt= Conexion::conectar()->prepare("DELETE FROM $tabla WHERE mascota_id=:mascota_id");
        $stmt->bindParam(":mascota_id",$datos,PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            //var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt=null;
        
    }
}