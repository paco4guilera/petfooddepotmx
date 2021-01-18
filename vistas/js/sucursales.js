/* Eliminar Sucursal */
$(document).on("click", ".btnEliminarSucursal", function () { 
    var nombreSucursal = $(this).attr("nombreSucursal");
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
        window.location = "index.php?ruta=sucursales&nombreSucursal="+nombreSucursal;
    } 
    })
})
/* Editar Sucursal */
//$(".btnEditarSucursal").click(function () { 
$(document).on("click", ".btnEditarSucursal", function () {
    var nombreSucursal = $(this).attr("nombreSucursal");
    var datos = new FormData();
    datos.append("nombreSucursal", nombreSucursal);
    $.ajax({
        url: "ajax/sucursales.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            var datosUsuario = new FormData();
            datosUsuario.append("idUsuario", respuesta["usuario_login"]);
            console.log(respuesta["usuario_login"]);
            $.ajax({
            url:"ajax/usuarios.ajax.php",
            method: "POST",
            data: datosUsuario,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success:function(respuesta){
                $('#editarEncargado').val(respuesta["usuario_login"]).trigger('change.select2');
            }
        })  
            $("#editarSucursal").val(respuesta["sucursal_nombre"]);
            $("#editarTelefonoSucursal").val(respuesta["sucursal_telefono"]);
            $("#editarDireccionSucursal").val(respuesta["sucursal_direccion"]);

        }
    });
})
$(document).on("click", ".mostrar-sucursal", function () { 
    var nombreSucursal = $(this).attr("nombreSucursal");
        window.location = "index.php?ruta=sucursal&nombreSucursal="+nombreSucursal;
    
})
/* Revisar si el usuario existe */
/* $("#nuevoTelefono").change(function () { 
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
}) */
