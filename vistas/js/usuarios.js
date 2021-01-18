/* Subiendo foto usuario*/
$(".nuevaFoto").change(function () {
    var imagen = this.files[0];
/* Validando el formato de la imagen */
    if (imagen["type"] != "image/jpeg" &&
        imagen["type"] != "image/png") {
        $(".nuevaFoto").val("");
        
        swal.fire({
            icon: "error",
            title: "Error al subir la imagen",
            text: "El fromato del archivo debe ser JPEG o PNG",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
        });
                    
    } else if (imagen["size"] > 2000000) {
        $(".nuevaFoto").val("");
        
        swal.fire({
            icon: "error",
            title: "Error al subir la imagen",
            text: "La imagen no puede pesar más de 2 MB",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
        });
    } else { 
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);
        $(datosImagen).on("load", function (event) { 
            var rutaImagen = event.target.result;
            $(".previsualizar").attr("src", rutaImagen);
        })
    }

})
/* Eliminar Usuario */
$(document).on("click", ".btnEliminarUsuario", function () { 
    var idUsuario = $(this).attr("idUsuario");
    var fotoUsuario = $(this).attr("fotoUsuario");
    Swal.fire({
        title: '¿Seguro que quieres eliminar este usuario?',
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.value) {
        window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&fotoUsuario="+fotoUsuario;
    } 
    })
})
/* Editar Usuario */
//$(".btnEditarUsuario").click(function () { 
$(document).on("click", ".btnEditarUsuario", function () {
    var idUsuario = $(this).attr("idUsuario");
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);
    $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#editarLogin").val(respuesta["usuario_login"]);
            $("#editarNombre").val(respuesta["usuario_nombre"]);
            $("#editarRol").html(respuesta["usuario_rol"]);
            $("#editarRol").val(respuesta["usuario_rol"]);
            $("#fotoActual").val(respuesta["usuario_foto"]);

            $("#passwordActual").val(respuesta["usuario_password"]);

            if (respuesta["usuario_foto"] != "") {
                $(".previsualizar").attr("src", respuesta["usuario_foto"]);
            } else {
                $(".previsualizar").attr("src", "vistas/img/usuarios/default/anonymous.png");
            }
        }
    });
})
/* Revisar si el usuario existe */
$("#nuevoLogin").change(function () { 
    $(".alert").remove();
    var usuario = $(this).val();
    var datos = new FormData();
    datos.append("validarUsuario", usuario);
    $.ajax({
        url:"ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) { 
            if (respuesta) { 
                $("#nuevoLogin").parent().after(' <br> <div class="alert alert-warning">Este usuario ya existe </div>');
                $("#nuevoLogin").val("");
            }
        }
    })
})
