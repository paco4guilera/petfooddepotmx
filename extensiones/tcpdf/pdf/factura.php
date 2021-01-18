<?php

require_once "../../../controladores/vender.controlador.php";
require_once "../../../modelos/vender.modelo.php";

class imprimirFactura
{

	public $idVenta;

	public function traerImpresionFactura()
	{
		$item = "venta_id";
		$nVenta = $this->idVenta;
		$venta = ControladorVentas::ctrMostrarVentas($item, $nVenta);
		date_default_timezone_set('America/Mexico_City');
		$fechaActual = date('Y-m-d');
		$productos = json_decode($venta["venta_productos"], true);

		//REQUERIMOS LA CLASE TCPDF

		require_once('tcpdf_include.php');

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->startPageGroup();

		$pdf->AddPage();

		// ---------------------------------------------------------

		$bloque1 = <<<EOF

	<table style="padding:0px 10px;">
		
		<tr>
			
			<td style="width:150px"><img src="images/logoF.png"></td>

			<td style="background-color:white; width:150px">
				<div style="font-size:8.5px; text-align:left; line-height:15px">
					
					<br>
					Teléfono: 871-186-50-82
					
					<br>
					petfooddepotlaguna@gmail.com
					<br>
					$fechaActual

				</div>
				
			</td>

			<td style="background-color:white; width:240px; text-align:right; color:red"><br><br>Venta N. $venta[venta_id]<br></td>

		</tr>

	</table>

EOF;

		$pdf->writeHTML($bloque1, false, false, false, false, '');

		/*=============================================
		Tabla con detalles de la venta                             
		=============================================*/
		$bloque2 = <<<EOF
		<br>
		<br>
		<br>
		<br>
		<table style="font-size:10px; padding:5px 10px;">

		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Tipo Cliente Y Descuento:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[cliente_tipo] - $venta[venta_descuento_cliente] %</td>
		</tr>

		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Nombre Cliente:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[cliente_nombre]</td>
		</tr>

		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Método Pago:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[venta_metodo_pago]</td>
		</tr>
		
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Total:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$ $venta[venta_total]</td>
		</tr>
		
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Puntos Venta:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[venta_puntos] pts.</td>
		</tr>
		
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Vendedor:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[usuario_nombre]</td>
		</tr>
		
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Fecha Y Hora Venta:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[venta_fecha]</td>
		</tr>
		
		<tr>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">Sucursal:</td>
		<td style="border: 1px solid #666; background-color:white; width:270px; ">$venta[sucursal_nombre]</td>
		</tr>


		</table>


EOF;
		$pdf->writeHTML($bloque2, false, false, false, false, '');

		$bloque3 = <<<EOF
		<br>
		<br>
		<br>
		<br>
		<table style="font-size:10px; padding:5px 10px;">
			<thead>
			<tr>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:170px; ">Producto</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:70px; ">Precio</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:80px; ">Descuento</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:65px; ">Cantidad</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:65px; ">Puntos</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:90px; ">Total</td>

			</tr>
			</thead>
			</table>
		

EOF;
		$pdf->writeHTML($bloque3, false, false, false, false, '');
		//----------------------------------------------------------

		foreach ($productos as  $key => $value) {
			$bloque4 = <<<EOF
			<table style="font-size:10px; padding:5px 10px;">
			<thead>
			<tr>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:170px; ">$value[nombre]</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:70px; ">$ $value[precioReal]</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:80px; ">$value[descuento] %</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:65px; ">$value[cantidad]</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:65px; ">$value[puntos] pts.</td>
			<td style="border: 1px solid #666; background-color:white; text-align: center; width:90px; ">$ $value[total]</td>
			</tr>
			</thead>
			</table>
EOF;
			$pdf->writeHTML($bloque4, false, false, false, false, '');
		}


		// ---------------------------------------------------------
		//SALIDA DEL ARCHIVO 

		$archivo = 'venta-' . $venta["venta_id"] . '.pdf';
		$pdf->Output($archivo, 'D');
	}
}

$factura = new imprimirFactura();
$factura->idVenta = $_GET["idVenta"];
$factura->traerImpresionFactura();
