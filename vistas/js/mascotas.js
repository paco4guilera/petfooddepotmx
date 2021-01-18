/* Eliminar Usuario */
$(document).on("click", ".btnEliminarMascota", function () { 
    var idMascota = $(this).attr("idMascota");
    Swal.fire({
        title: '¿Seguro que quieres eliminar este mascota?',
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.value) {
        window.location = "index.php?ruta=mascotas&idMascota="+idMascota;
    } 
    })
})
/* Editar Mascota */

$(document).on("click", ".btnEditarMascota", function () {
    var idMascota = $(this).attr("idMascota");
    var datos = new FormData();
    datos.append("idMascota", idMascota);
    console.log(datos);
    $.ajax({
        url: "ajax/Mascotas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#idActual").val(respuesta["mascota_id"]);
            $("#editarNombre").val(respuesta["mascota_nombre"]);
            $("#editarRaza").val(respuesta["mascota_raza"]);
            $("#editarPeso").val(respuesta["mascota_peso"]);
            $('#editarEdad').val(respuesta["mascota_edad"]).trigger('change.select2');
            $("#editarDuegno").val(respuesta["cliente_id"]);
            $("#editarDuegno").html(respuesta["cliente_id"]+" - "+respuesta["cliente_nombre"]);
            $("#editarDuegnoID").val(respuesta["cliente_id"]);

        }
    });
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
