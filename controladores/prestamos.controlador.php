<?php
class ControladorPrestamos
{
    public static function ctrMostrarPrestamos($item, $valor)
    {
        $respuesta = ModeloPrestamos::mdlMostrarPrestamos($item, $valor);
        return $respuesta;
    }
    public static function ctrEliminarPrestamo()
    {
        if (isset($_GET["idPrestamoL"])) {
            $id = $_GET["idPrestamoL"];
            $item = "prestamo_id";
            $prestamo = ModeloPrestamos::mdlMostrarPrestamos($item, $id);
            $respuesta = ModeloPrestamos::mdlEliminarPrestamo($id);
            $c = "Pr";
            $d = 'Se Liquidó Préstamo = ' . $id . '; Con Un Monto de = $ ' . $prestamo["prestamo_monto"] . '; Otorgado al Cliente = ' . $prestamo["cliente_nombre"] . ' en la Venta = ' . $prestamo["venta_id"];
            if ($respuesta == "ok") {
                ModeloAcciones::mdlNuevaAccion($d, $c);
                echo '<script>
				swal.fire({
                        icon:"success",
                        title: "Préstamo Liquidado Con Éxito",
                        showConfirmButton: false,
                        timer: 500
                    }).then(function (result) {
                    if (result.dismiss === swal.DismissReason.timer) {
                        window.location="prestamos";
                        }
                    });
				</script>';
            } else {
                echo '<script>
				swal.fire({
                        icon:"error",
                        title: "Error Al Liquidar Préstamo",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function (result) {
                    if (result.dismiss === swal.DismissReason.timer) {
                        window.location="prestamos";
                        }
                    });
				</script>';
            }
        }
    }
}
