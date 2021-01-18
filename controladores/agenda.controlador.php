<?php
class ControladorAgenda
{
    public static function ctrMostrarAgenda($item, $valor)
    {
        $respuesta = ModeloAgenda::mdlMostrarAgenda($item, $valor);
        return $respuesta;
    }
    public static function ctrEliminarAgenda()
    {
        if (isset($_GET["idAgenda"])) {
            $id = $_GET["idAgenda"];
            $item = "agenda_id";
            $agenda = ModeloAgenda::mdlMostrarAgenda($item, $id);
            $respuesta = ModeloAgenda::mdlEliminarAgenda($id);
            if ($respuesta == "ok") {
                $c = "A";
                $d = 'Se eliminó registro de Agenda = ' . $id . '; Cliente = ' . $agenda["cliente_nombre"] . ' de la Venta = ' . $agenda["venta_id"];
                if ($respuesta == "ok") {
                    ModeloAcciones::mdlNuevaAccion($d, $c);
                    echo '<script>
				swal.fire({
                        icon:"success",
                        title: "Registro De Agenda Eliminado",
                        showConfirmButton: false,
                        timer: 500
                    }).then(function (result) {
                    if (result.dismiss === swal.DismissReason.timer) {
                        window.location="agenda";
                        }
                    });
				</script>';
                } else {
                    echo '<script>
				swal.fire({
                        icon:"error",
                        title: "Error Al Eliminar Registro",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function (result) {
                    if (result.dismiss === swal.DismissReason.timer) {
                        window.location="agenda";
                        }
                    });
				</script>';
                }
            }
        }
    }
}
