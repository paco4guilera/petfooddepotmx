<?php

class ControladorVentas
{

    /*=============================================
	MOSTRAR VENTAS
	=============================================*/

    static public function ctrMostrarVentas($item, $valor)
    {
        $respuesta = ModeloVentas::mdlMostrarVentas($item, $valor);
        return $respuesta;
    }

    /*=============================================
	CREAR VENTA
	=============================================*/

    static public function ctrCrearVenta()
    {

        if (isset($_POST["totalVenta"])) {
            echo '
            <script> console.log("inició venta");</script>

            ';
            /*=============================================
			ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
			=============================================*/

            if ($_POST["listaProductos"] == "") {

                echo '<script>
                    swal.fire({
                        icon:"error",
                        title: "No Hay Productos Agregados",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="vender";
                        }
                    });
                    </script>';

                return;
            }




            $tablaClientes = "clientes";

            $item = "cliente_id";
            $valor = $_POST["clienteFormulario"];
            $valorClienteId = $_POST["clienteFormulario"];
            $traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $item, $valor);
            
            
            /*=============================================
			GUARDAR LA COMPRA
			=============================================*/

            $tabla = "ventas";
            $total = number_format($_POST["totalVenta"], 2, '.', '');
            $iva = $total * 0.16;
            $iva = number_format($iva, 2, '.', '');
            $impuestoAdicional = 0;
            /*=============================================
            
            =============================================*/
            $idCliente = $traerCliente["cliente_id"];
            $descuento = ModeloClientes::mdlMostrarDescuento($item, $idCliente);

            if ($_POST["listaMetodoPago"] == "Tarjeta") {
                $impuestoAdicional = $total * 0.035;
            }

            $impuestoAdicional = number_format($impuestoAdicional, 2, '.', '');
            $neto = $total - $iva - $impuestoAdicional;
            $neto = number_format($neto, 2, '.', '');
            $datos = array(
                "id" => $_POST["clienteFormulario"],
                "descuentoCliente" => $descuento["tipo_descuento"],
                "descuentoAdicional" => $_POST["nuevoDescuentoVenta"],
                "descuentoPuntos" => $_POST["puntosClienteUsar"],
                "iva" => $iva,
                "impuestoAdicional" => $impuestoAdicional,
                "metodoPago" => $_POST["listaMetodoPago"],
                "productos" => $_POST["listaProductos"],
                "sesion" => $_SESSION["sesion"],
                "total" => $total,
                "neto" => $neto,
                "sucursal" => $_SESSION["sucursal"],
                "puntos" => $_POST["totalPuntos"]
            );
            //var_dump($datos);
            $respuesta = ModeloVentas::mdlIngresarVenta($tabla, $datos);
            if ($respuesta == "ok") {
                /*=============================================
                Traer última venta para registar la venta del
                Producto  en ventas_productos                        
                =============================================*/
                $ultimaVenta = ModeloVentas::mdlUltimaVenta($_POST["clienteFormulario"]);
                $idUltimaVenta = $ultimaVenta["MAX(venta_id)"];
                $fechaUltimaVenta = $ultimaVenta["venta_fecha"];
                /*=============================================
                Actualización de inventario y registro de ventas en ventas_productos                 
                =============================================*/
                $listaProductos = json_decode($_POST["listaProductos"], true);

                $totalProductosComprados = array();

                foreach ($listaProductos as $key => $value) {

                    array_push($totalProductosComprados, $value["cantidad"]);

                    $tablaProductos = "productos";

                    $item = "producto_nombre";
                    $valor = $value["nombre"];
                    $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);

                    $item1a = "producto_ventas";
                    $valor1a = $value["cantidad"] + $traerProducto["producto_ventas"];

                    ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);
                    $tablaInventario = "inventario";
                    $item1b = "producto_inventario";
                    $valor1b = $value["inventario"];
                    $sucursal = $_SESSION["sucursal"];
                    ModeloProductos::mdlActualizarInventario($tablaInventario, $item1b, $valor1b, $valor, $sucursal);

                    $datosPV = array(
                        "nombre"=> $value["nombre"],
                        "cantidad"=>$value["cantidad"],
                        "venta"=>$idUltimaVenta);
                    ModeloProductos::mdlInsertarProductosVentas($datosPV);

                }
                /*=============================================
                Actualización de compras del cliente                     
                =============================================*/
                $item1a = "cliente_compras";
                $valor1a = array_sum($totalProductosComprados) + $traerCliente["cliente_compras"];
                $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorClienteId);
                /*=============================================
                descuento de puntos al cliente                      
                =============================================*/
                if ($_POST["puntosClienteUsar"] > 0) {
                    $puntosAUsar = $_POST["puntosClienteUsar"];
                    //Traer todas las tuplas de puntos del cliente ordenadas por fecha en orden ascendente
                    $puntos = ModeloClientes::mdlMostrarPuntos($valorClienteId);
                    //evaluar una por una si es mayor a los puntos a usar y hacer la resta
                    //si la tupla tiene menos de los que va a usar, elimina la tupla y resta los puntos a usar para 
                    //pasar a la siguiente tupla y restar lo que falta
                    foreach ($puntos as $key => $value) {
                        
                        if ($value["puntos_cantidad"] <= $puntosAUsar) {
                            $puntosAUsar -= $value["puntos_cantidad"];
                            ModeloClientes::mdlBorrarPuntos($value["puntos_id"]);
                        } else {
                            $actualizarPuntos = $value["puntos_cantidad"] - $puntosAUsar;
                            ModeloClientes::mdlDescontarPuntos($value["puntos_id"], $actualizarPuntos);
                            $puntosAUsar = 0;
                        }
                    }
                }
                /*=============================================
                Agregar los puntos que se obtuvieron en la compra
                =============================================*/
                if ($_POST["totalPuntos"] > 0) {
                    $puntosNuevos = $_POST["totalPuntos"];
                    ModeloClientes::mdlAgregarPuntos($valorClienteId, $puntosNuevos);
                }
                

                /*=============================================
                Ver si pidió préstamo                             
                =============================================*/
                if (
                    $_POST["listaMetodoPago"] != "Efectivo" &&
                    $_POST["listaMetodoPago"] != "Tarjeta" &&
                    $_POST["listaMetodoPago"] != "Trasferencia"
                ) {

                    /*=============================================
                    si pidió préstamo, traer el id de la venta recien creada                             
                    =============================================*/
                    //Preparar los datos para el prestamo
                    $datosP = array(
                        "monto" => $total,
                        "cliente" => $_POST["clienteFormulario"],
                        "sesion" => $_SESSION["sesion"],
                        "venta" => $idUltimaVenta,
                        "caducidad" => $_POST["listaMetodoPago"]
                    );
                    //crear el prestamo
                    ModeloPrestamos::mdlIngresarPrestamo($datosP);
                }
                /*=============================================
                Ver si pidió un contacto futuro                             
                =============================================*/
                if (isset($_POST["fechaContactar"])) {
                    $ultimaVenta = ModeloVentas::mdlUltimaVenta($_POST["clienteFormulario"]);
                    $datosC = array(
                        "cliente" => $_POST["clienteFormulario"],
                        "fecha" => $_POST["fechaContactar"],
                        "venta" => $ultimaVenta["MAX(venta_id)"]
                    );
                    ModeloAgenda::mdlIngresarAgenda($datosC);
                }
                echo '<script>
				localStorage.removeItem("rango");
				swal.fire({
                        icon:"success",
                        title: "Venta Realizada Con Éxito",
                        showConfirmButton: false,
                        timer: 500
                    }).then(function (result) {
                    if (result.dismiss === swal.DismissReason.timer) {
                        window.location="vender";
                        }
                    });
				</script>';
            } else {
                echo '<script>

				localStorage.removeItem("rango");

				swal.fire({
                        icon:"error",
                        title: "Venta No Realizada Con Éxito",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false 
                    }).then((result)=>{
                        if(result.value){
                            window.location="vender";
                        }
                    });

				</script>';
            }
        }
    }

    /*=============================================
	RANGO FECHAS
	=============================================*/

    static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal)
    {

        $tabla = "ventas";

        $respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

        return $respuesta;
    }

    /*=============================================
	DESCARGAR EXCEL
	=============================================*/

    public function ctrDescargarReporte()
    {

        if (isset($_GET["reporte"])) {

            $tabla = "ventas";

            if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {

                $ventas = ModeloVentas::mdlRangoFechasVentas($tabla, $_GET["fechaInicial"], $_GET["fechaFinal"]);
            } else {

                $item = null;
                $valor = null;

                $ventas = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
            }


            /*=============================================
			CREAMOS EL ARCHIVO DE EXCEL
			=============================================*/

            $Name = $_GET["reporte"] . '.xls';

            header('Expires: 0');
            header('Cache-control: private');
            header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
            header("Cache-Control: cache, must-revalidate");
            header('Content-Description: File Transfer');
            header('Last-Modified: ' . date('D, d M Y H:i:s'));
            header("Pragma: public");
            header('Content-Disposition:; filename="' . $Name . '"');
            header("Content-Transfer-Encoding: binary");

            echo utf8_decode("<table border='0'> 

					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>CÓDIGO</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

            foreach ($ventas as $row => $item) {

                $cliente = ControladorClientes::ctrMostrarClientes("id", $item["id_cliente"]);
                $vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["id_vendedor"]);

                echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>" . $item["codigo"] . "</td> 
			 			<td style='border:1px solid #eee;'>" . $cliente["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>" . $vendedor["nombre"] . "</td>
			 			<td style='border:1px solid #eee;'>");

                $productos =  json_decode($item["productos"], true);

                foreach ($productos as $key => $valueProductos) {

                    echo utf8_decode($valueProductos["cantidad"] . "<br>");
                }

                echo utf8_decode("</td><td style='border:1px solid #eee;'>");

                foreach ($productos as $key => $valueProductos) {

                    echo utf8_decode($valueProductos["descripcion"] . "<br>");
                }

                echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["impuesto"], 2) . "</td>
					<td style='border:1px solid #eee;'>$ " . number_format($item["neto"], 2) . "</td>	
					<td style='border:1px solid #eee;'>$ " . number_format($item["total"], 2) . "</td>
					<td style='border:1px solid #eee;'>" . $item["metodo_pago"] . "</td>
					<td style='border:1px solid #eee;'>" . substr($item["fecha"], 0, 10) . "</td>		
		 			</tr>");
            }


            echo "</table>";
        }
    }


    /*=============================================
	SUMA TOTAL VENTAS
	=============================================*/

    public function ctrSumaTotalVentas()
    {

        $tabla = "ventas";

        $respuesta = ModeloVentas::mdlSumaTotalVentas($tabla);

        return $respuesta;
    }
}
