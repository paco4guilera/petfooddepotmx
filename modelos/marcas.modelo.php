<?php

require_once "conexion.php";

class ModeloMarcas
{

    /*=============================================
	CREAR MARCA
	=============================================*/

    static public function mdlIngresarMarca($tabla, $datos)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(marca_nombre, marca_fecha,sesion_id) VALUES (:marca_nombre,:marca_fecha,:sesion_id)");
        $stmt->bindParam(":marca_nombre", $datos, PDO::PARAM_STR);
        $stmt->bindParam(":marca_fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $_SESSION["sesion"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt = null;
    }

    /*=============================================
	MOSTRAR MarcaS
	=============================================*/

    static public function mdlMostrarMarcas($tabla, $item, $valor)
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
	EDITAR Marca
	=============================================*/

    static public function mdlEditarMarca($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET marca_nombre = :marca_nombre WHERE marca_id = :marca_id");

        $stmt->bindParam(":marca_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":marca_id", $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }
        $stmt = null;
    }

    /*=============================================
	BORRAR Marca
	=============================================*/

    static public function mdlBorrarMarca($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE marca_id = :marca_id");

        $stmt->bindParam(":marca_id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt = null;
    }
}
