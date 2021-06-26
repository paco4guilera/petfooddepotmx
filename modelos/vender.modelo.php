<?php

require_once "conexion.php";

class ModeloVentas
{

    /*=============================================
	MOSTRAR VENTAS
	=============================================*/

    static public function mdlMostrarVentas($item, $valor)
    {

        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT V.venta_id,C.cliente_id,C.cliente_telefono,C.cliente_correo, 
                                                    C.cliente_nombre, V.venta_metodo_pago, 
                                                    V.venta_total, C.cliente_tipo, V.venta_descuento_cliente, 
                                                    V.venta_descuento_puntos, V.venta_descuento_adicional, 
                                                    V.venta_iva, V.venta_impuesto_adicional, V.venta_neto,
                                                    V.venta_fecha,U.usuario_nombre, V.sucursal_nombre, 
                                                    V.sesion_id, V.venta_productos,V.venta_puntos
                                                    From ventas AS V
                                                    JOIN clientes AS C ON V.cliente_id= C.cliente_id
                                                    JOIN sesiones AS S ON S.sesion_id=V.sesion_id
                                                    JOIN usuarios AS U on S.usuario_login= U.usuario_login
                                                    WHERE $item=:$item
                                                    ORDER BY V.venta_fecha DESC");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT V.venta_id,C.cliente_id,C.cliente_telefono,C.cliente_correo, 
                                                    C.cliente_nombre, V.venta_metodo_pago, 
                                                    V.venta_total, C.cliente_tipo, V.venta_descuento_cliente, 
                                                    V.venta_descuento_puntos, V.venta_descuento_adicional, 
                                                    V.venta_iva, V.venta_impuesto_adicional, V.venta_neto,
                                                    V.venta_fecha,U.usuario_nombre, V.sucursal_nombre, 
                                                    V.sesion_id, V.venta_productos ,V.venta_puntos
                                                    From ventas AS V
                                                    JOIN clientes AS C ON V.cliente_id= C.cliente_id
                                                    JOIN sesiones AS S ON S.sesion_id=V.sesion_id
                                                    JOIN usuarios AS U on S.usuario_login= U.usuario_login 
                                                    ORDER BY V.venta_fecha DESC");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null;
    }
    /*=============================================
	MOSTRAR VENTAS POR RANGO
	=============================================*/

    static public function mdlRangoVentas($fechaInicial, $fechaFinal)
    {

        if ($fechaInicial == null) {

            $stmt = Conexion::conectar()->prepare("SELECT V.venta_id,C.cliente_id,C.cliente_telefono,C.cliente_correo, 
                                                    C.cliente_nombre, V.venta_metodo_pago, 
                                                    V.venta_total, C.cliente_tipo, V.venta_descuento_cliente, 
                                                    V.venta_descuento_puntos, V.venta_descuento_adicional, 
                                                    V.venta_iva, V.venta_impuesto_adicional, V.venta_neto,
                                                    V.venta_fecha,U.usuario_nombre, V.sucursal_nombre, 
                                                    V.sesion_id, V.venta_productos,V.venta_puntos
                                                    From ventas AS V
                                                    JOIN clientes AS C ON V.cliente_id= C.cliente_id
                                                    JOIN sesiones AS S ON S.sesion_id=V.sesion_id
                                                    JOIN usuarios AS U on S.usuario_login= U.usuario_login
                                                    ORDER BY V.venta_fecha DESC");

            $stmt->execute();
        //var_dump("sin filtro");
            return $stmt->fetchAll();
        } else if ($fechaInicial == $fechaFinal){
            $stmt = Conexion::conectar()->prepare("SELECT V.venta_id,C.cliente_id,C.cliente_telefono,C.cliente_correo, 
                                                    C.cliente_nombre, V.venta_metodo_pago, 
                                                    V.venta_total, C.cliente_tipo, V.venta_descuento_cliente, 
                                                    V.venta_descuento_puntos, V.venta_descuento_adicional, 
                                                    V.venta_iva, V.venta_impuesto_adicional, V.venta_neto,
                                                    V.venta_fecha,U.usuario_nombre, V.sucursal_nombre, 
                                                    V.sesion_id, V.venta_productos,V.venta_puntos
                                                    From ventas AS V
                                                    JOIN clientes AS C ON V.cliente_id= C.cliente_id
                                                    JOIN sesiones AS S ON S.sesion_id=V.sesion_id
                                                    JOIN usuarios AS U on S.usuario_login= U.usuario_login
                                                    WHERE V.venta_fecha LIKE '%$fechaFinal%'");

            $stmt -> bindParam(":V.venta_fecha", $fechaFinal, PDO::PARAM_STR);
            $stmt -> execute();
            //var_dump($stmt->execute());
            return $stmt -> fetchAll();
        }else {
            $unixTime = time();
            $timeZone = new \DateTimeZone('America/Mexico_City');
            $fechaActual = new \DateTime();
            $fechaActual->setTimestamp($unixTime)->setTimezone($timeZone);
            $fechaActual-> add(new DateInterval("P1D"));
            $fechaActualMasUno = $fechaActual->format("Y-m-d");

            $fechaFinal2 = new DateTime($fechaFinal);
            $fechaFinal2-> add(new DateInterval("P1D"));
            $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

            if($fechaFinalMasUno == $fechaActualMasUno){
                $stmt = Conexion::conectar()->prepare("SELECT V.venta_id,C.cliente_id,C.cliente_telefono,C.cliente_correo, 
                                                    C.cliente_nombre, V.venta_metodo_pago, 
                                                    V.venta_total, C.cliente_tipo, V.venta_descuento_cliente, 
                                                    V.venta_descuento_puntos, V.venta_descuento_adicional, 
                                                    V.venta_iva, V.venta_impuesto_adicional, V.venta_neto,
                                                    V.venta_fecha,U.usuario_nombre, V.sucursal_nombre, 
                                                    V.sesion_id, V.venta_productos ,V.venta_puntos
                                                    From ventas AS V
                                                    JOIN clientes AS C ON V.cliente_id= C.cliente_id
                                                    JOIN sesiones AS S ON S.sesion_id=V.sesion_id
                                                    JOIN usuarios AS U on S.usuario_login= U.usuario_login 
                                                    WHERE V.venta_fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'
                                                    ORDER BY V.venta_fecha DESC");
            
            }else{
                
                $stmt = Conexion::conectar()->prepare("SELECT V.venta_id,C.cliente_id,C.cliente_telefono,C.cliente_correo, 
                                                        C.cliente_nombre, V.venta_metodo_pago, 
                                                        V.venta_total, C.cliente_tipo, V.venta_descuento_cliente, 
                                                        V.venta_descuento_puntos, V.venta_descuento_adicional, 
                                                        V.venta_iva, V.venta_impuesto_adicional, V.venta_neto,
                                                        V.venta_fecha,U.usuario_nombre, V.sucursal_nombre, 
                                                        V.sesion_id, V.venta_productos ,V.venta_puntos
                                                        From ventas AS V
                                                        JOIN clientes AS C ON V.cliente_id= C.cliente_id
                                                        JOIN sesiones AS S ON S.sesion_id=V.sesion_id
                                                        JOIN usuarios AS U on S.usuario_login= U.usuario_login 
                                                        WHERE V.venta_fecha BETWEEN '$fechaInicial' AND '$fechaFinal'
                                                        ORDER BY V.venta_fecha DESC");    
            }
            $stmt->execute();
            //var_dump($stmt->execute());
            return $stmt->fetchAll();
        }

        $stmt = null;
    }
    /*=============================================
    Traer última venta para registrar el préstamo                             
    =============================================*/
    static public function mdlUltimaVenta($cliente)
    {
        $stmt = Conexion::conectar()->prepare("SELECT MAX(venta_id), venta_fecha FROM ventas WHERE cliente_id =:cliente_id");
        $stmt->bindParam(":cliente_id", $cliente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt = null;
    }
    /*=============================================
	REGISTRO DE VENTA
	=============================================*/

    static public function mdlIngresarVenta($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla (cliente_id, 
                venta_descuento_cliente, 
                venta_descuento_adicional, 
                venta_descuento_puntos,
                venta_iva, 
                venta_impuesto_adicional, 
                venta_metodo_pago,
                venta_productos,
                sesion_id,
                venta_total,
                venta_neto,
                sucursal_nombre,
                venta_fecha,
                venta_puntos) 
            VALUES (:cliente_id, 
                    :venta_descuento_cliente, 
                    :venta_descuento_adicional, 
                    :venta_descuento_puntos, 
                    :venta_iva, 
                    :venta_impuesto_adicional, 
                    :venta_metodo_pago,
                    :venta_productos,
                    :sesion_id,
                    :venta_total,
                    :venta_neto,
                    :sucursal_nombre,
                    :venta_fecha,
                    :venta_puntos)"
        );
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $fechaActual = $fecha . ' ' . $hora;
        $stmt->bindParam(":cliente_id", $datos["id"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_descuento_cliente", $datos["descuentoCliente"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_descuento_adicional", $datos["descuentoAdicional"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_descuento_puntos", $datos["descuentoPuntos"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_iva", $datos["iva"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_impuesto_adicional", $datos["impuestoAdicional"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_metodo_pago", $datos["metodoPago"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_productos", $datos["productos"], PDO::PARAM_STR);
        $stmt->bindParam(":sesion_id", $datos["sesion"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_total", $datos["total"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_neto", $datos["neto"], PDO::PARAM_STR);
        $stmt->bindParam(":sucursal_nombre", $datos["sucursal"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_fecha", $fechaActual, PDO::PARAM_STR);
        $stmt->bindParam(":venta_puntos", $datos["puntos"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            var_dump($stmt->execute());
            return "error";
        }
        $stmt = null;
    }
    /*=============================================
	EDITAR VENTA
	=============================================*/
    static public function mdlEditarVenta($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, impuesto = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago WHERE codigo = :codigo");

        $stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
        $stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
        $stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
        $stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
        $stmt->bindParam(":impuesto", $datos["impuesto"], PDO::PARAM_STR);
        $stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
        $stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
        $stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }


        $stmt = null;
    }

    /*=============================================
	ELIMINAR VENTA
	=============================================*/

    static public function mdlEliminarVenta($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }



        $stmt = null;
    }

    /*=============================================
	RANGO FECHAS
	=============================================*/

    static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal)
    {

        if ($fechaInicial == null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

            $stmt->execute();

            return $stmt->fetchAll();
        } else if ($fechaInicial == $fechaFinal) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");

            $stmt->bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $fechaActual = new DateTime();
            $fechaActual->add(new DateInterval("P1D"));
            $fechaActualMasUno = $fechaActual->format("Y-m-d");

            $fechaFinal2 = new DateTime($fechaFinal);
            $fechaFinal2->add(new DateInterval("P1D"));
            $fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

            if ($fechaFinalMasUno == $fechaActualMasUno) {

                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");
            } else {


                $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");
            }

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/

    static public function mdlSumaTotalVentas($tabla)
    {

        $stmt = Conexion::conectar()->prepare("SELECT SUM(neto) as total FROM $tabla");

        $stmt->execute();

        return $stmt->fetch();



        $stmt = null;
    }
    /*================================================================================================================================
                                                        VENTAS PRODUCTOS
	=================================================================================================================================*/
    /* Registro de los productos en las ventas */
    static public function mdlRegistroProductoVenta($datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO ventas_productos( 
                                                        producto_nombre, 
                                                        producto_cantidad,
                                                        venta_fecha, 
                                                        venta_id, 
                                                        sesion_id)
                                                VALUES( :producto_nombre, 
                                                        :producto_cantidad,
                                                        :venta_fecha, 
                                                        :venta_id, 
                                                        :sesion_id)");

        $stmt->bindParam(":producto_nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":producto_cantidad", $datos["cantidad"], PDO::PARAM_INT);
        $stmt->bindParam(":venta_fecha", $datos["fecha"], PDO::PARAM_STR);
        $stmt->bindParam(":venta_id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["sesion"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            return "error";
        }
        $stmt = null;
        
    }
    
}
