/*=============================================
Carga de productos                             
=============================================*/

$('.tabla-productos').DataTable( {
    "ajax": "ajax/datatable-productos.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

});
/*=============================================
AGREGANDO COSTO                             
=============================================*/
$("#nuevoProductoSucursal").change(function () { 
	var nombreProducto = document.getElementById("nuevoProductoSucursal").value;
	console.log(nombreProducto);
	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);
	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {
			document.getElementById("costoProducto").value = respuesta["producto_costo"];
			if($(".porcentajeMayoreo").prop("checked")){
				var valorPorcentajeMayoreo = $(".nuevoPorcentajeMayoreo").val();
				var porcentajeMayoreo = Number(($("#costoProducto").val()*valorPorcentajeMayoreo/100))+Number($("#costoProducto").val());
			//var editarPorcentajeMayoreo = Number(($("#editarProductoSucursal").val()*valorPorcentajeMayoreo/100))+Number($("#editarProductoSucursal").val());
				
				$("#nuevoPrecioMayoreo").val(porcentajeMayoreo);
				$("#nuevoPrecioMayoreo").prop("readonly",true);
			
			/* $("#editarPrecioMayoreo").val(editarPorcentajeMayoreo);
			$("#editarPrecioMayoreo").prop("readonly",true); */
			}
			if($(".porcentajeMenudeo").prop("checked")){
				var valorPorcentajeMenudeo = $(".nuevoPorcentajeMenudeo").val();
				var porcentajeMenudeo = Number(($("#costoProducto").val()*valorPorcentajeMenudeo/100))+Number($("#costoProducto").val());
			//var editarPorcentajeMenudeo = Number(($("#editarProductoSucursal").val()*valorPorcentajeMenudeo/100))+Number($("#editarProductoSucursal").val());
				
				$("#nuevoPrecioMenudeo").val(porcentajeMenudeo);
				$("#nuevoPrecioMenudeo").prop("readonly",true);
			
			/* $("#editarPrecioMenudeo").val(editarPorcentajeMenudeo);
			$("#editarPrecioMenudeo").prop("readonly",true); */
			}
		}	
	});
})

/*=============================================
AGREGANDO PRECIO DE MAYOREO
=============================================*/
/* $("#costoProducto, #editarProductoSucursal").change(function(){

	if($(".porcentajeMayoreo").prop("checked")){

		var valorPorcentajeMayoreo = $(".nuevoPorcentajeMayoreo").val();
		
		var porcentajeMayoreo = Number(($("#costoProducto").val()*valorPorcentajeMayoreo/100))+Number($("#costoProducto").val());

		var editarPorcentajeMayoreo = Number(($("#editarProductoSucursal").val()*valorPorcentajeMayoreo/100))+Number($("#editarProductoSucursal").val());

		$("#nuevoPrecioMayoreo").val(porcentajeMayoreo);
		$("#nuevoPrecioMayoreo").prop("readonly",true);

		$("#editarPrecioMayoreo").val(editarPorcentajeMayoreo);
		$("#editarPrecioMayoreo").prop("readonly",true);

	}

}) */
/*=============================================
AGREGANDO PRECIO DE Menudeo
=============================================*/
/* $("#nuevoProductoSucursal, #editarProductoSucursal").change(function(){

	if($(".porcentajeMenudeo").prop("checked")){

		var valorPorcentajeMenudeo = $(".nuevoPorcentajeMenudeo").val();
		
		var porcentajeMenudeo = Number(($("#nuevoProductoSucursal").val()*valorPorcentajeMenudeo/100))+Number($("#nuevoProductoSucursal").val());

		var editarPorcentajeMenudeo = Number(($("#editarProductoSucursal").val()*valorPorcentajeMenudeo/100))+Number($("#editarProductoSucursal").val());

		$("#nuevoPrecioMenudeo").val(porcentajeMenudeo);
		$("#nuevoPrecioMenudeo").prop("readonly",true);

		$("#editarPrecioMenudeo").val(editarPorcentajeMenudeo);
		$("#editarPrecioMenudeo").prop("readonly",true);

	}

}) */

/*=============================================
CAMBIO DE PORCENTAJE MAYOREO
=============================================*/
$(".nuevoPorcentajeMayoreo").change(function(){

	if($(".porcentajeMayoreo").prop("checked")){

		var valorPorcentajeMayoreo = $(this).val();
		
		var porcentajeMayoreo = Number(($("#costoProducto").val()*valorPorcentajeMayoreo/100))+Number($("#costoProducto").val());

		var editarPorcentajeMayoreo = Number(($("#editarCostoProducto").val()*valorPorcentajeMayoreo/100))+Number($("#editarCostoProducto").val());

		$("#nuevoPrecioMayoreo").val(porcentajeMayoreo);
		$("#nuevoPrecioMayoreo").prop("readonly",true);

		$("#editarPrecioMayoreo").val(editarPorcentajeMayoreo);
		$("#editarPrecioMayoreo").prop("readonly",true);

	}

})

$(".porcentajeMayoreo").on("ifUnchecked",function(){

	$("#nuevoPrecioMayoreo").prop("readonly",false);
	$("#editarPrecioMayoreo").prop("readonly",false);

})

$(".porcentajeMayoreo").on("ifChecked",function(){

	$("#nuevoPrecioMayoreo").prop("readonly",true);
	$("#editarPrecioMayoreo").prop("readonly",true);

})
/*=============================================
CAMBIO DE PORCENTAJE MENUDEO
=============================================*/
$(".nuevoPorcentajeMenudeo").change(function(){

	if($(".porcentajeMenudeo").prop("checked")){

		var valorPorcentajeMenudeo = $(this).val();
		
		var porcentajeMenudeo = Number(($("#costoProducto").val()*valorPorcentajeMenudeo/100))+Number($("#costoProducto").val());

		var editarPorcentajeMenudeo = Number(($("#editarCostoProducto").val()*valorPorcentajeMenudeo/100))+Number($("#editarCostoProducto").val());

		$("#nuevoPrecioMenudeo").val(porcentajeMenudeo);
		$("#nuevoPrecioMenudeo").prop("readonly",true);

		$("#editarPrecioMenudeo").val(editarPorcentajeMenudeo);
		$("#editarPrecioMenudeo").prop("readonly",true);

	}

})

$(".porcentajeMenudeo").on("ifUnchecked",function(){

	$("#nuevoPrecioMenudeo").prop("readonly",false);
	$("#editarPrecioMenudeo").prop("readonly",false);

})

$(".porcentajeMenudeo").on("ifChecked",function(){

	$("#nuevoPrecioMenudeo").prop("readonly",true);
	$("#editarPrecioMenudeo").prop("readonly",true);

}) 
/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/
$(".nuevaImagen").change(function () {
    var imagen = this.files[0];
/* Validando el formato de la imagen */
    if (imagen["type"] != "image/jpeg" &&
        imagen["type"] != "image/png") {
        $(".nuevaImagen").val("");
        
        swal.fire({
            icon: "error",
            title: "Error al subir la imagen",
            text: "El fromato del archivo debe ser JPEG o PNG",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
        });
                    
    } else if (imagen["size"] > 2000000) {
        $(".nuevaImagen").val("");
        
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



/*=============================================
EDITAR PRODUCTO
=============================================*/

$(".tabla-productos tbody").on("click", "button.btnEditarProducto", function(){

	var nombreProducto = $(this).attr("nombreProducto");
	var datos = new FormData();
	datos.append("nombreProducto", nombreProducto);
	
	$.ajax({
    url:"ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json",
		success:function(respuesta) {
        var datosMarca = new FormData();
        datosMarca.append("idMarca",respuesta["marca_id"]);
		
        $.ajax({
            url:"ajax/marcas.ajax.php",
            method: "POST",
            data: datosMarca,
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json",
            success:function(respuesta){
                $("#editarProductoMarca").val(respuesta["marca_id"]);
                $("#editarProductoMarca").html(respuesta["marca_nombre"]);
            }
		}) 
        $("#editarProducto").val(respuesta["producto_nombre"]);
        $("#editarPrecioCompra").val(respuesta["producto_costo"]);
		$("#editarDuracion").val(respuesta["producto_duracion"]);
		$("#editarPuntos").val(respuesta["producto_puntos"]);
		$("#editarTope").val(respuesta["producto_tope"]);
			if (respuesta["producto_foto"] != "") {
				$("#imagenActual").val(respuesta["producto_foto"]);
				$(".previsualizar").attr("src", respuesta["producto_foto"]);
			}

		}

	})

})
/*=============================================
EDITAR PRODUCTO SUCURSAL                             
=============================================*/

$(document).on("click", ".btnEditarProductoSucursal", function () {
    let nombreProducto = $(this).attr("nombreProducto");
    let nombreSucursal = $(this).attr("nombreSucursal");
	let datos = new FormData();
		datos.append("nombreProductoSucursal", nombreProducto);
		datos.append("nombreSucursal", nombreSucursal);
	let costo = new FormData();
	costo.append("nombreProducto", nombreProducto);
	
    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: costo,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
		success: function (respuesta) {
			document.getElementById("editarCostoProducto").value = respuesta["producto_costo"];
			let costoProducto=respuesta["producto_costo"];
			$.ajax({
				url:"ajax/productos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType:"json",
				success: function (respuesta) {
				$("#editarProductoSucursal").val(respuesta["producto_nombre"]);
				$("#editarInventario").val(respuesta["producto_inventario"]);
				$("#editarPrecioMayoreo").val(respuesta["producto_mayoreo"]);
				$("#editarPrecioMenudeo").val(respuesta["producto_menudeo"]);
				$("#editarPorcentajeMayoreo").val(((respuesta["producto_mayoreo"]*100)/costoProducto)-100);
				$("#editarPorcentajeMenudeo").val(((respuesta["producto_menudeo"]*100)/costoProducto)-100);
            }
		}) 
        }
    });
})
/*=============================================
ELIMINAR PRODUCTO SUCURSAL                             
=============================================*/

$(document).on("click", ".btnEliminarProductoSucursal", function () {
	var nombreProducto = $(this).attr("nombreProducto");
	var nombreSucursal = $(this).attr("nombreSucursal");
	
    Swal.fire({
        title: '¿Seguro que quieres eliminar este producto de '+nombreSucursal+'?',
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.value) {
        window.location = "index.php?ruta=sucursal&nombreProductoSucursal="+nombreProducto+"&nombreSucursal="+nombreSucursal;
    } 
    })
})

/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tabla-productos tbody").on("click", "button.btnEliminarProducto", function(){

	var nombreProducto = $(this).attr("nombreProducto");
	var imagen = $(this).attr("imagen");
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
			window.location = "index.php?ruta=productos&nombreProducto="+nombreProducto+"&imagen="+imagen;
		} 
    })

}) 