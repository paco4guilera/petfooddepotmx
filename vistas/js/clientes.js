/* Eliminar Usuario */
$(document).on("click", ".btnEliminarCliente", function () { 
    var idCliente = $(this).attr("idCliente");
    var nombreCliente = $(this).attr("nombreCliente");
    Swal.fire({
        title: '¿Seguro que quieres eliminar este cliente?',
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.value) {
        window.location = "index.php?ruta=clientes&idCliente="+idCliente+"&nombreCliente="+nombreCliente;
    } 
    })
})
/* Editar Usuario */
//$(".btnEditarUsuario").click(function () { 
$(document).on("click", ".btnEditarCliente", function () {
    var idCliente = $(this).attr("idCliente");
    var datos = new FormData();
    datos.append("idCliente", idCliente);
    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#idActual").val(respuesta["cliente_id"]);
            $("#editarNombre").val(respuesta["cliente_nombre"]);
            $("#editarTelefono").val(respuesta["cliente_telefono"]);
            $("#editarEmail").val(respuesta["cliente_correo"]);
            $('#editarColoniaCliente').val(respuesta["colonia_nombre"]).trigger('change.select2');
            $('#editarTipo').val(respuesta["cliente_tipo"]).trigger('change.select2');

        }
    });
})
$(document).on("click", ".btnEditarTipo", function () {
    var tipoDescuento= $(this).attr("tipoDescuento");
    var datos = new FormData();
    datos.append("tipoDescuento", tipoDescuento);
    $.ajax({
        url: "ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#editarDescuento").val(respuesta["tipo_descuento"]);
            $("#editarDescuentoNombre").val(respuesta["tipo_nombre"]);
        }
    });
})

$(document).on("click", ".btnirATiposClientes", function () { 


    window.location = "tipos-clientes";

})
$(document).on("click", ".btnirAClientes", function () { 


    window.location = "clientes";

})
/* Revisar si el usuario existe */
$("#nuevoTelefono").change(function () { 
    $(".alert").remove();
    var tel = $(this).val();
    var datos = new FormData();
    datos.append("validarTelefono", tel);
    $.ajax({
        url:"ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) { 
            if (respuesta) { 
                $("#nuevoTelefono").parent().after('<br><div class="alert alert-warning">Ya existe un cliente con este teléfono</div>');
                $("#nuevoTelefono").val("");
            }
        }
    })
})
$("#nuevoEmail").change(function () { 
    $(".alert").remove();
    var correo = $(this).val();
    var datos = new FormData();
    datos.append("validarCorreo", correo);
    $.ajax({
        url:"ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) { 
            if (respuesta) { 
                $("#nuevoEmail").parent().after('<br> <div class="alert alert-warning">Ya existe un cliente con este correo</div>');
                $("#nuevoEmail").val("");
            }
        }
    })
})
$("#nuevoNombre").change(function () { 
    $(".alert").remove();
    var correo = $(this).val();
    var datos = new FormData();
    datos.append("validarNombre", correo);
    $.ajax({
        url:"ajax/clientes.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) { 
            if (respuesta) { 
                $("#nuevoNombre").parent().after('<br><div class="alert alert-warning">Ya existe un cliente con nombre exacto</div>');
                $("#nuevoNombre").val("");
            }
        }
    })
})
