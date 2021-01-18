<?php
require_once "conexion.php";
class ModeloClientes
{
    /* Mostrar usuarios */
    static public function mdlMostrarClientes($tabla, $item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $estado = "cliente_estado";
            $val = "1";
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $estado = :$estado");
            $stmt->bindParam(":" . $estado, $val, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt = null;
    }
    static public function mdlMostrarTipoDescuento($item, $valor)
    {
        if ($item != null) {
            $stmt = Conexion::conectar()->prepare("SELECT * FROM tiposClientes WHERE $item = :$item ");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetch();
        } else {
            $estado = "cliente_estado";
            $val = "1";
            $stmt = Conexion::conectar()->prepare("SELECT * FROM tiposClientes");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt = null;
    }
    static public function mdlMostrarDescuento($item, $valor)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $stmt = Conexion::conectar()->prepare("SELECT T.tipo_descuento, C.cliente_tipo,(SELECT SUM(puntos_cantidad) FROM puntos WHERE cliente_id=:$item AND(puntos_caducidad > :puntos_caducidad)) AS puntos FROM tiposClientes AS T 
                                                JOIN clientes AS C ON T.tipo_nombre = C.cliente_tipo
                                                WHERE $item=:$item");
        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
        $stmt->bindParam(":puntos_caducidad", $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    static public function mdlEditarDescuento($datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE tiposClientes SET tipo_descuento=:tipo_descuento WHERE tipo_nombre=:tipo_nombre");
        $stmt->bindParam(":tipo_descuento", $datos["descuento"], PDO::PARAM_STR);
        $stmt->bindParam(":tipo_nombre", $datos["nombre"], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

    }
    static public function mdlMostrarPuntos($cliente)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $stmt = Conexion::conectar()->prepare("SELECT * FROM puntos 
                                                WHERE cliente_id=:cliente_id 
                                                AND puntos_caducidad> :puntos_caducidad
                                                ORDER BY puntos_caducidad");
        $stmt->bindParam(":cliente_id", $cliente, PDO::PARAM_STR);
        $stmt->bindParam(":puntos_caducidad", $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    static public function mdlAgregarPuntos($id, $cantidad)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $fechaActual = $fecha;
        $fechaCaducidad = date('Y-m-d', strtotime($fechaActual . "+ 6 month"));
        $stmt = Conexion::conectar()->prepare("INSERT INTO puntos (puntos_cantidad, 
                                                                    cliente_id, 
                                                                    puntos_caducidad)
                                                VALUES (:puntos_cantidad, 
                                                        :cliente_id, 
                                                        :puntos_caducidad)");
        $stmt->bindParam(":puntos_cantidad", $cantidad, PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $id, PDO::PARAM_STR);
        $stmt->bindParam(":puntos_caducidad", $fechaCaducidad, PDO::PARAM_STR);
        return $stmt->execute();
    }
    static public function mdlBorrarPuntos($id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM puntos WHERE puntos_id=:puntos_id");
        $stmt->bindParam(":puntos_id", $id, PDO::PARAM_STR);
        return $stmt->execute();
    }
    static public function mdlDescontarPuntos($id, $cantidad)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE puntos SET puntos_cantidad=:puntos_cantidad WHERE puntos_id=:puntos_id");
        $stmt->bindParam(":puntos_cantidad", $cantidad, PDO::PARAM_STR);
        $stmt->bindParam(":puntos_id", $id, PDO::PARAM_STR);
        return $stmt->execute();
    }
    static public function mdlMostrarTipos($tabla, $item, $valor)
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
    static public function mdlIngresarCliente($tabla, $datos)
    {
        // $estado="1";
        // $numsesion=1;
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (  cliente_nombre,
                                cliente_telefono,
                                cliente_correo,
                                colonia_nombre,
                                cliente_tipo,
                                cliente_estado,
                                sesion_id) 
        VALUES (:cliente_nombre,
                :cliente_telefono,
                :cliente_correo,
                :colonia_nombre,
                :cliente_tipo,
                :cliente_estado,
                :sesion_id) ");
        $val = 0;
        $estado = "1";
        $stmt->bindParam(":cliente_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":colonia_nombre", $datos["colonia"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_tipo", $datos["tipo"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_estado", $estado, PDO::PARAM_STR);
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

    static public function mdlEditarCliente($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
        SET cliente_nombre=:cliente_nombre,
        cliente_telefono=:cliente_telefono,
        cliente_correo=:cliente_correo,
        colonia_nombre=:colonia_nombre,
        cliente_tipo=:cliente_tipo
        WHERE cliente_id=:cliente_id");

        $stmt->bindParam(":cliente_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_telefono", $datos["telefono"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_correo", $datos["correo"], PDO::PARAM_STR);
        $stmt->bindParam(":colonia_nombre", $datos["colonia"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_tipo", $datos["tipo"], PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $datos["id"], PDO::PARAM_INT);
        if ($stmt->execute()) {
            return "ok";
        } else {
            var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt = null;
    }
    /* Borrar cliente */
    static public function mdlBorrarCliente($tabla, $datos)
    {
        $estado = "0";
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla 
                                                set cliente_estado=:cliente_estado
                                                WHERE cliente_id=:cliente_id");
        $stmt->bindParam(":cliente_estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $datos, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            //var_dump($stmt->execute());
            return "error";
        }
        //$stmt->close();
        $stmt = null;
    }
    /*=============================================
	ACTUALIZAR CLIENTE
	=============================================*/

    static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE cliente_id = :cliente_id");
        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":cliente_id", $valor, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
    }
}
