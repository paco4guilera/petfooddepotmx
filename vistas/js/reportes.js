/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/
if (localStorage.getItem("capturarRango2") != null) {
    $("#daterange-btn2 span").html(localStorage.getItem("capturarRango2"));
} else {
    $("#daterange-btn2 span").html('<i class="fa fa-calendar"></i> Rango de fecha');
}
var resp = 'no';
var op = 'no';//variable para saber qué opción fue seleccionada del date range picker
/*=============================================
RANGO DE FECHAS
=============================================*/
$('#daterange-btn2').daterangepicker(
  {
    ranges   : {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
        'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //agregar combobox de dias/semanas
    var fechaInicial = start.format('YYYY-MM-DD');
    var fechaFinal = end.format('YYYY-MM-DD');
    var capturarRango = $("#daterange-btn2 span").html();
    localStorage.setItem("capturarRango2", capturarRango);
    window.location = "index.php?ruta=reporte-ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal+"&op="+op;

  }

)
/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/
$(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function () {
    localStorage.removeItem("capturarRango2");
    localStorage.clear();
    window.location = "reporte-ventas";
})

/*=============================================
CAPTURAR HOY
=============================================*/

$(".daterangepicker.opensright .ranges li").on("click", function(){

	op = $(this).attr("data-range-key");

  if (op == "Hoy") {

    var d = new Date();
		
    var dia = d.getDate();
    var mes = d.getMonth() + 1;
    var año = d.getFullYear();

    dia = ("0" + dia).slice(-2);
    mes = ("0" + mes).slice(-2);

    var fechaInicial = año + "-" + mes + "-" + dia;
    var fechaFinal = año + "-" + mes + "-" + dia;

    localStorage.setItem("capturarRango2", "Hoy");

    window.location = "index.php?ruta=reporte-ventas&fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal + "&op=" + op;;


  } else if (op == "Últimos 7 días") {
    op = "ultimos7";
  } else if (op == "Últimos 30 días") {
    op = "ultimos30";
  } else if (op == "Este mes") {
    op = "estemes";
  } else if (op == "Último mes") {
    op = "ultimomes";
  } else if (op == "Rango Personalizado") {
    op = "rango";
  }

})