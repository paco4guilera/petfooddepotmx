<?php
require_once "conexion.php";
class ModeloAcciones
{
    /* Mostrar usuarios */
    static public function mdlNuevaAccion($descripcion, $categoria)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $fechaActual = $fecha . ' ' . $hora;
        $stmt = Conexion::conectar()->prepare("INSERT INTO acciones (accion_categoria,
                                                                    accion_descripcion,
                                                                    accion_fecha,
                                                                    sesion_id)
                                            VALUES (:accion_categoria,
                                                    :accion_descripcion,
                                                    :accion_fecha,
                                                    :sesion_id)");
        $stmt->bindParam(":accion_categoria", $categoria, PDO::PARAM_STR);
        $stmt->bindParam(":accion_descripcion", $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":accion_fecha", $fechaActual, PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $_SESSION["sesion"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }

        $stmt = null;
    }
    static public function mdlTablaAcciones()
    {
        $stmt = Conexion::conectar()->prepare("SELECT 
        A.accion_categoria, A.accion_id, A.accion_descripcion,A.accion_fecha,U.usuario_nombre,A.sesion_id
            From acciones as A 
            join sesiones as S on A.sesion_id= S.sesion_id
            join usuarios as U on S.usuario_login= U.usuario_login ORDER BY A.accion_fecha desc");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
