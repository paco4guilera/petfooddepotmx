$(document).on("click", ".btnLiquidarPrestamo", function () { 
    var idPrestamo = $(this).attr("idPrestamo");
    Swal.fire({
        title: '¿Seguro que quieres liquidar esta deuda?',
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.value) {
        window.location = "index.php?ruta=prestamos&idPrestamoL="+idPrestamo;
    } 
    })
})