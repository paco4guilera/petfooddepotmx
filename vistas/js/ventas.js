/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/
var sucursal = $("#sucursal").val();
$('.tablaVentas').DataTable({
    "ajax": "ajax/datatable-ventas.ajax.php?sucursal="+sucursal,
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

} );



var cambioCliente = 0;
var idCliente = 0;
var descuentoCliente = 0;
var tipoCliente;
var puntosCliente = 0;
var puntosTope = 0;
var topeGlobal = 0;
var puntosEnUso = 0;
var descuentoAdicionalGlobal = 0;
$("#seleccionarCliente").change(function () { 
    idCliente = document.getElementById("seleccionarCliente").value;
    //console.log(idCliente);
    cambioCliente++;
    
    if (cambioCliente > 1) {
        window.location = "vender";
    } else { 
        $("#clienteFormulario").val($(this).val());
        console.log($(this).val());
        var datos = new FormData();
        datos.append("traerDescuento", idCliente);
        $.ajax({
            url: "ajax/clientes.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) { 
                descuentoCliente = respuesta["tipo_descuento"];
                tipoCliente = respuesta["cliente_tipo"];
                puntosCliente = respuesta["puntos"];
                if (puntosCliente != null) {
                    $("#puntosCliente").val(puntosCliente);
                } else { 
                    puntosCliente = 0;
                    $("#puntosCliente").val(puntosCliente);
                }
                var select = document.getElementById("nuevoMetodoPago");

                select.options[0] = new Option("Seleccione método de pago", "");
                select.options[1] = new Option("Efectivo", "Efectivo");
                select.options[2] = new Option("Tarjeta", "Tarjeta");
                select.options[3] = new Option("Transferencia", "Transferencia");
                if (tipoCliente == "Mayorista") { 
                    select.options[4] = new Option("Préstamo", "Prestamo");
                }
            }
        })
    }
    

})


/*=============================================
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/
let productosencaja = [];

$(".tablaVentas tbody").on("click", "button.agregarProducto", function () {
    /* console.log("picado");
    console.log(cambioCliente);
    console.log(idCliente);  */
    if (idCliente == 0) {
        swal.fire({
            icon: "error",
            title: "Cliente No Selecionado",
            text: "Debe elegir un cliente para agregar productos",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
        });
    } else { 
        var idProducto = $(this).attr("idProducto");
        var nombreSucursal = $(this).attr("nombreSucursal");
        /* console.log(idProducto);
        console.log(nombreSucursal); */
        var agregar = true;
        if (productosencaja.length > 0) {
            for (let index = 0; index < productosencaja.length; index++) {
                if (idProducto == productosencaja[index]) {
                    agregar= false;
                }
                
            }
        } 
        if (agregar == true) {
            productosencaja.push(idProducto);
            $(this).removeClass("btn-primary agregarProducto");
            $(this).addClass("btn-default");
            var datos = new FormData();
            datos.append("nombreProductoSucursal", idProducto);
            datos.append("nombreSucursal", nombreSucursal);
            $.ajax({
                url: "ajax/productos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (respuesta) { 
                    var inventario = respuesta["producto_inventario"];
                    if (tipoCliente == "Mayorista") {
                        precio = respuesta["producto_mayoreo"];
                    } else {
                        precio = respuesta["producto_menudeo"];
                    }
                    /*=============================================
                    obtenemos los puntos de cada cliente                             
                    =============================================*/
                    var puntos = respuesta["producto_puntos"];
                    var tope = respuesta["producto_tope"];
                    var descuentoIndividual = descuentoCliente / 100;
                    var precioConDescuento = precio - (precio * descuentoIndividual);
                    if (descuentoIndividual == 0 || descuentoIndividual < 0) { 
                        descuentoIndividual = 1;
                        precioConDescuento = precio;
                    }
                    /*=============================================
                    EVITAR AGREGAR PRODUTO CUANDO EL inventario ESTÁ EN CERO
                    =============================================*/
                    if (inventario == 0) {
                        swal({
                            title: "No hay inventario disponible",
                            type: "error",
                            confirmButtonText: "Cerrar"
                        });
                        $("button[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");
                        return;
                    }
                    $(".nuevoProducto").append(
                        '<div class="row colorear-Renglon" style="padding:5px 15px">' +
                            '<!-- Nombre del producto -->' +
                            '<div class="col-lg-4 col-xs-7" style="padding-right:0px">' +
                                '<h5>Producto</h5>' +
                                '<div class="input-group">' +
                                    '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-times"></i></button></span>' +
                                    '<input type="text" class="form-control nuevaDescripcionProducto" idProducto="' + idProducto + '" name="agregarProducto" value="' + idProducto + '" readonly required>' +
                                '</div>' +
                            '</div>' +
                            '<!-- Precio del producto -->' +
                            '<div class="col-lg-3 col-xs-5 ingresoPrecio" style="padding-left:10px">' +
                                '<h5>Precio</h5>' +
                                '<div class="input-group">' +
                                    '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                                    '<input type="text" class="form-control nuevoPrecioProducto" precioReal="' + precio + '" precioConDescuento="' + precioConDescuento + '" name="nuevoPrecioProducto" value="' + precioConDescuento + '" readonly required>' +
                                '</div>' +
                            '</div>' +
                            '<input type="hidden" class="nuevosPuntos" name="nuevosPuntos" value="'+puntos+'">'+
                            '<input type="hidden" class="puntosUnidad" name="puntosUnidad" value="'+puntos+'">'+
                            '<input type="hidden" class="nuevoTope" name="nuevoTope" value="'+tope+'">'+
                            '<input type="hidden" class="topeUnidad" name="topeUnidad" value="'+tope+'">'+
                            '<!-- Cantidad del producto -->' +
                            '<div class="col-lg-2 col-xs-7">' +
                                '<h5>Cantidad</h5>' +
                                '<div class="input-group">' +
                                    '<span class="input-group-addon"><i class="fas fa-cubes"></i></span>' +
                                    '<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" inventario="' + inventario + '" nuevoInventario="' + Number(inventario - 1) + '" required>' +
                                '</div>' +
                            '</div>' +
                            '<!-- Descuento Adicional-->' +
                            '<div class="col-lg-3 col-xs-5">' +
                                '<h5>Descuento</h5>' +
                                '<div class="input-group">' +
                                    '<input type="number" class="form-control nuevoDescuento" name="nuevoDescuento" min="0" value="'+descuentoCliente+'" required readonly>' +
                                    '<span class="input-group-addon"><i class="fas fa-percentage"></i></span>' +
                                '</div>' +
                            '</div>' +
                        '</div>')
                    // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
                    $(".nuevoPrecioProducto").number(true, 2);
                    // SUMAR TOTAL DE PRECIOS
                    sumarTotalPrecios()
                    //CALCULA LOS PUNTOS A OBTENER EN LA COMPRA
                    calcularPuntos();
                    //CALCULA EL TOPE DE PUNTOS A USAR EN LA COMPRA
                    calcularTope();
                    //LISTAR PRODUCTOS
                    listarProductos();

                }

            })
        } else { 
            swal.fire({
            icon: "error",
            title: "Ya Has Agregado Este Producto",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
            });
        }
        
        
        
    }
});
function calcularTope() {
    if (productosencaja.length > 0) { 
        if (puntosCliente > 0) {
            var topeItem = $(".nuevoTope");
            var arraySumaTope = [];

            for (var i = 0; i < topeItem.length; i++) {

                arraySumaTope.push(Number($(topeItem[i]).val()));
		
            }

            function sumaArrayTope(total, numero) {

                return total + numero;

            }

            var sumaTotalTope = arraySumaTope.reduce(sumaArrayTope);
            if (sumaTotalTope > puntosCliente) {
                sumaTotalTope = puntosCliente;
            }
            //AQUI USAR HIDDEN EN VENDER PARA ACTUALIZAR EL TOPE
            topeGlobal = sumaTotalTope;
            var puntosActuales=$("#puntosClienteUsar").val();
            if (puntosActuales > topeGlobal) { 
                $("#puntosClienteUsar").val(topeGlobal);
                
            }
            $("#topePuntos").val(sumaTotalTope);
            $("#topePuntos").attr("total", sumaTotalTope);
            //$("#puntosClineteUsar").attr("max", sumaTotalTope);
        
        } 
    } else { 
        topeGlobal = 0;
        $("#topePuntos").val(0);
        $("#topePuntos").attr("total", 0);
        $("#puntosClienteUsar").val(0);
    }
    
}
function calcularPuntos() { 
    var puntosItem = $(".nuevosPuntos");
    var arraySumaPuntos = [];  

	for(var i = 0; i < puntosItem.length; i++){

		arraySumaPuntos.push(Number($(puntosItem[i]).val()));
		
	}

	function sumaArrayPuntos(total, numero){

		return total + numero;

	}

    var sumaTotalPuntos = arraySumaPuntos.reduce(sumaArrayPuntos);
    
    //AQUI USAR HIDDEN EN VENDER PARA ACTUALIZAR LOS PUNTOS
	$("#totalPuntos").val(sumaTotalPuntos);
    $("#totalPuntos").attr("total", sumaTotalPuntos);
    
}
function sumarTotalPrecios(){

	var precioItem = $(".nuevoPrecioProducto");
	
	var arraySumaPrecio = [];  

	for(var i = 0; i < precioItem.length; i++){

		arraySumaPrecio.push(Number($(precioItem[i]).val()));
		
	}

	function sumaArrayPrecios(total, numero){

		return total + numero;

	}

    var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);
    sumaTotalPrecio-=$("#puntosClienteUsar").val();
    var descuentoAdicional = descuentoAdicionalGlobal;
    descuentoAdicional /= (100) + 1;
    descuentoAdicional *= sumaTotalPrecio;
    sumaTotalPrecio -= descuentoAdicional;
	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	$("#totalVenta").val(sumaTotalPrecio);
	$("#nuevoTotalVenta").attr("total",sumaTotalPrecio);


}

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2);

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaVentas').on( 'draw.dt', function(){

	quitarAgregarProducto();

})
/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto(){

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaVentas tbody button.agregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for(var i = 0; i < idProductos.length; i++){

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idProducto") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}
/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioVenta").on("click", "button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();

	var idProducto = $(this).attr("idProducto");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if(localStorage.getItem("quitarProducto") == null){

		idQuitarProducto = [];
	
	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

    $("button.recuperarBoton[idProducto='" + idProducto + "']").addClass('btn-primary agregarProducto');
    var i = productosencaja.indexOf( idProducto );
    productosencaja.splice( i, 1 );

	if($(".nuevoProducto").children().length == 0){

		//$("#nuevoImpuestoVenta").val(0);
		$("#nuevoTotalVenta").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalVenta").attr("total",0);

    } else {
        

		// SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios()
        
    	// AGREGAR IMPUESTO
        
        //agregarImpuesto()
        
        // AGRUPAR PRODUCTOS EN FORMATO JSON
        
        listarProductos()
        
    }
    calcularPuntos()
    calcularTope()
    // SUMAR TOTAL DE PRECIOS
        sumarTotalPrecios()
    

})
/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos(){

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".nuevaCantidadProducto");

    var precio = $(".nuevoPrecioProducto");
    var descuento = $(".nuevoDescuento");
    var puntos = $(".nuevosPuntos");
    

	for(var i = 0; i < descripcion.length; i++){

		listaProductos.push({   "nombre" : $(descripcion[i]).attr("idProducto"), 
                                "cantidad" : $(cantidad[i]).val(),
                                "inventario" : $(cantidad[i]).attr("nuevoInventario"),
                                "precioReal" : $(precio[i]).attr("precioReal"),
                                "precioConDescuento" : $(precio[i]).attr("precioConDescuento"),
                                "total": $(precio[i]).val(),
                                "descuento": $(descuento[i]).val(),
                                "puntos": $(puntos[i]).val()
        })

	}

    $("#listaProductos").val(JSON.stringify(listaProductos)); 
    console.log(JSON.stringify(listaProductos));

}
/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function(){
    //console.log("cambio");
    var precio = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
    var puntos = $(this).parent().parent().parent().children(".nuevosPuntos");
    //console.log(precio);
    var topePuntos = $(this).parent().parent().parent().children(".nuevoTope");
    var puntosProductoInd = $(this).parent().parent().parent().children(".topeUnidad").val();
    var cantidadProducto = $(this).val();
    var nuevoTope = puntosProductoInd * cantidadProducto;
    topePuntos.val(nuevoTope);
    
	var precioFinal = $(this).val() * precio.attr("precioConDescuento");
    //console.log(precioFinal);
	precio.val(precioFinal);
    console.log(precio.val());
    var nuevoInventario = Number($(this).attr("inventario")) - $(this).val();
    var puntosUnidad = $(this).parent().parent().parent().children(".puntosUnidad").val();
    var totalPuntos = $(this).val() * puntosUnidad;
    puntos.val(totalPuntos);
	$(this).attr("nuevoInventario", nuevoInventario);

	if(Number($(this).val()) > Number($(this).attr("inventario"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

		$(this).val(1);

		$(this).attr("nuevoInventario", $(this).attr("inventario"));

		var precioFinal = $(this).val() * precio.attr("precioConDescuento");

		precio.val(precioFinal);

		// AGRUPAR PRODUCTOS EN FORMATO JSON

        listarProductos()
        calcularTope()
        calcularPuntos()
        // SUMAR TOTAL DE PRECIOS

        sumarTotalPrecios()



	    return;

	}

	

    // AGRUPAR PRODUCTOS EN FORMATO JSON

    listarProductos()
    calcularTope()
    calcularPuntos()
    // SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

})
$(".formularioVenta").on("change", "input.puntosClienteUsar", function () {
    if ($(this).val() > topeGlobal) {
        $(this).val(topeGlobal);
        /* swal.fire({
            icon: "error",
            title: "No puedes exceder el tope de puntos",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
            });  */
        
    } 
    sumarTotalPrecios();
})
/*=============================================
LISTAR MÉTODO DE PAGO PARA LA INFO DE LA VENTA
=============================================*/
function listarMetodos(){
	//console.log("Listó método");
	if($("#nuevoMetodoPago").val() == "Efectivo"){
		$("#listaMetodoPago").val("Efectivo");
    } else if($("#nuevoMetodoPago").val() == "Prestamo") {
        $("#listaMetodoPago").val($("#fechaPago").val());
        //console.log("P-" + $("#fechaPago").val());
    }else if($("#nuevoMetodoPago").val() == "Tarjeta") {
        $("#listaMetodoPago").val("Tarjeta");
    }else if($("#nuevoMetodoPago").val() == "Transferencia") {
        $("#listaMetodoPago").val("Tansferencia");
    }else{
        $("#listaMetodoPago").val("");
	}
}
$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val();

    if (metodo == "Efectivo") {

        $(this).parent().parent().removeClass("col-xs-8");
        $(this).parent().parent().removeClass("col-lg-4");

        $(this).parent().parent().addClass("col-xs-4");
        $(this).parent().parent().addClass("col-lg-2");

        $(this).parent().parent().parent().children(".cajasMetodoPago").html(

            '<div class="col-xs-4 col-lg-2 ">' +
                '<div class="input-group">' +
                    '<span class="input-group-addon ocultar-iconos"><i class="ion ion-social-usd"></i></span>' +
                    '<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" autocomplete="off" required>' +
                '</div>' +
            '</div>' +
            '<div class="col-xs-4 col-lg-2  " id="capturarCambioEfectivo" style="padding-left:0px">' +
                '<div class="input-group">' +
                    '<span class="input-group-addon ocultar-iconos"><i class="ion ion-social-usd"></i></span>' +
                    '<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>' +
                '</div>' +
            '</div>'

        )

        // Agregar formato al precio

        $('#nuevoValorEfectivo').number(true, 2);
        $('#nuevoCambioEfectivo').number(true, 2);


        // Listar método en la entrada
        listarMetodos() //SOLO CUANDO YA SE AÑADA CÓDIGO DE TRANSACCIÓN

    } else if (metodo == "Prestamo") {
        $(this).parent().parent().addClass("col-lg-2");
        $(this).parent().parent().removeClass("col-lg-4");
        $(this).parent().parent().removeClass("col-xs-8");
        $(this).parent().parent().addClass("col-xs-6");
        $(this).parent().parent().parent().children('.cajasMetodoPago').html(
            '<div class="col-xs-6 col-lg-2">' +
                '<div class="input-group date">' +
                    '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>' +
                    '<input type="text" class="form-control pull-right datepicker fechaPago" id="fechaPago" autocomplete="off" required>' +
                '</div>' +
            '</div>' +
            '<script>' +
            '$(".datepicker").datepicker({format: "yyyy-mm-dd"});'+
            '</script>'
        );
    } else {

        $(this).parent().parent().removeClass("col-lg-2");
        $(this).parent().parent().addClass("col-lg-4");
		$(this).parent().parent().removeClass('col-xs-4');
		$(this).parent().parent().addClass('col-xs-6');
        $(this).parent().parent().parent().children('.cajasMetodoPago').html('');
        //listar porque en tarjeta y transferencia no hay código
        listarMetodos();
	}

	

})

$(".agendarContacto").on("ifChecked", function () {

    /* $(this).parent().parent().parent().parent().parent().parent().children(".contacto").children().children().children().html(
        '<h5>hola</h5>'
    ); */
    $(this).parent().parent().parent().parent().parent().children().children(".fechaContacto").html(
            '<div class="input-group date">' +
                '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>' +
                '<input type="text" class="form-control pull-right datepicker" id="fechaContactar"  name="fechaContactar" autocomplete="off" required>' +
            '</div>' +
        '<script>' +
        '$(".datepicker").datepicker({format: "yyyy-mm-dd"});'+
        '</script>'
    );
}) 
$(".agendarContacto").on("ifUnchecked",function(){
    
    $(this).parent().parent().parent().parent().parent().children().children(".fechaContacto").html('');

})
/*=============================================
APLICAR DESCUENTO ADICIONAL FINAL                             
=============================================*/
$(".formularioVenta").on("change", "input.nuevoDescuentoVenta", function () {
    //console.log("cambió descuento final");
    descuentoAdicionalGlobal = $(this).val();
    //console.log(descuentoAdicionalGlobal);
    sumarTotalPrecios();
    calcularPuntos();
})
/*=============================================
CAMBIO FECHA PAGO
=============================================*/
$(".formularioVenta").on("change", "input#fechaPago", function(){

	// Listar método en la entrada
    listarMetodos()


})
/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function(){

	var efectivo = $(this).val();

	var cambio =  Number(efectivo) - Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(cambio);

})
/*=============================================
BOTON  INFO COMPLETA DE VENTA                             
=============================================*/
$(document).on("click", ".btnVerVenta", function () { 
    var idVenta = $(this).attr("idVenta");
        window.location = "index.php?ruta=detalles-venta&idVenta="+idVenta;
    
})
/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(document).on("click", ".btnImprimirFactura", function () { 

	var idVenta = $(this).attr("idVenta");

	window.open("extensiones/tcpdf/pdf/factura.php?idVenta="+idVenta, "_blank");

})
//Volver a las ventas
$(document).on("click", ".btnVolverVentas", function () { 

	

    window.location = "historial-ventas";

})