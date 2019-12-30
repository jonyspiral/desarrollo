<?php

$letra = $_POST['form_letra'];
$numero = $_POST['form_numero'];
$fecha = $_POST['form_fecha'];
$nombreCliente = $_POST['form_nombreCliente'];
$direccion = $_POST['form_direccion'];
$nombreCondicionIva = $_POST['form_nombreCondicionIva'];
$cuit = $_POST['form_cuit'];
$condicionDeVenta = $_POST['form_condicionDeVenta'];
$descuentos = $_POST['form_descuentos'];
$subtotal = $_POST['form_subtotal'];
$subtotal2 = $_POST['form_subtotal2'];
$ivaPorc1 = $_POST['form_ivaPorc1'];
$ivaImporte1 = $_POST['form_ivaImporte1'];
$ivaPorc2 = $_POST['form_ivaPorc2'];
$ivaImporte2 = $_POST['form_ivaImporte2'];
$ivaPorc3 = $_POST['form_ivaPorc3'];
$ivaImporte3 = $_POST['form_ivaImporte3'];
$importeTotal = $_POST['form_importeTotal'];
$cantidadPares = $_POST['form_cantidadPares'];
$cae = $_POST['form_cae'];
$caeVencimiento = $_POST['form_caeVencimiento'];
$remitosIncluidos = $_POST['form_remitosIncluidos'];
$detalle = $_POST['form_detalle'];

?>
<head>
<link rel="stylesheet" type="text/css" href="../../../../css/styles.css" media="screen"/>
<style>

.centrar{
	margin:0 auto 0 auto;
}

.textoSize1{
	font-size:1em;
}

.textoSize12{
	font-size:1.2em;
}

.textoSize15{
	font-size:1.5em;
}

.textoSize08{
	font-size:0.8em;
}

.fuenteArial{
	font-family:Arial;
}

#spiralSa{
	top: 40px;
	left: 220px;
}

.textoSpiral{
	font-size: 1.5em;
	font-weight: bold;
}

#logo{
	top: 30px;
	left: -20px;
}

#infoEmpresa{
	font-size: 0.85em;
	top: 110px;
	left: 250px;
	line-height:20px;
}

#responsableInscripto{
	top: 200px;
	left: 225px;
}

#responsableInscripto{
	top: 200px;
	left: 225px;
}

#lineaVertical1{
	left: 530px;
	width: 2px;
	height: 50px;
	background-color: black;
}

#lineaVertical2{
	top: 173px;
	left: 530px;
	width: 2px;
	height: 50px;
	background-color: black;
}

#letra{
	width: 120px;
	height: 120px;
	top: 50px;
	left: 470px;
	border: 2px solid black;
}

#codigo19{
	top: 145px;
	left: 496px;
}

.tamanoLetra{
	font-size: 6em;
}

#notaDeCredito{
	font-weight: bold;
	font-size: 1.5em;
	top: 75px;
	right: 190px;
}

#nroFactura{
	font-size: 1.5em;
	top: 105px;
	right: 235px;
}
#fecha{
	font-weight: bold;
	font-size: 1.5em;
	top: 75px;
	right: 52px;
}

#dia{
	font-size: 1.5em;
	top: 105px;
	right: 120px;
}

#mes{
	font-size: 1.5em;
	top: 105px;
	right: 80px;
}

#anio{
	font-size: 1.5em;
	top: 105px;
	right: 40px;
}

#numerosEmpresa{
	font-size: 0.85em;
	top: 170px;
	right: 30px;
}

#division1{
	top: 220px;
	width: 100%;
	height: 7px;
	background-color: black;
}
#nombre{
	top: 250px;
	left: 50px;	
}

#nombreVal{
	top: 250px;
	left: 100px;	
}

#direccion{
	top: 280px;
	left: 20px;
}
#direccionVal{
	top: 280px;
	left: 100px;	
}

#cuit{
	top: 250px;
	right: 300px;
}

#cuitVal{
	top: 250px;
	right: 180px;	
}

#condicionIVA{
	top: 280px;
	right: 300px;	
}
#condicionIVAval{
	top: 280px;
	right: 145px;
}

#fondoCabeceraDetalle{
	top: 350px;
	width: 100%;
	height: 30px;
	background-color: black;
}

#cabeceraCodigo{
	top: 355px;
	left: 50px;
}

#cabeceraDescripcion{
	top: 355px;
	left: 350px;
}

#cabeceraCantidad{
	top: 355px;
	right: 280px;
}

#cabeceraUnitario{
	top: 355px;
	right: 140px;
}

#cabeceraTotal{
	top: 355px;
	right: 50px;
}

#detalle{
	top: 390px;
	left: 60px;
}
.detalleCodArt{
	width:135px;
	
}
.detalleNombreArt{
	width:495px;
	
}
.detalleCantidad{
	width:105px;
	
}
.detallePrecioUnitario{
	width:110px;
	
}
.detallePrecioTotal{
	width:110px;
	
}
#division2{
	top: 1230px;
	width: 100%;
	height: 7px;
	background-color: black;
}

#subtotal1{
	top: 1250px;
	left: 50px;
}

#descuento{
	top: 1250px;
	left: 200px;
}

#subtotal2{
	top: 1250px;
	left: 380px;
}

#IVA1{
	top: 1250px;
	left: 540px;
}

#IVA2{
	top: 1250px;
	left: 670px;
}

#IVA3{
	top: 1250px;
	left: 800px;
}

#total{
	top: 1250px;
	left: 930px;
}
#numSubtotal1{
	top: 1270px;
	left: 35px;
}

#numDescuento{
	top: 1270px;
	left: 200px;
}

#numSubtotal2{
	top: 1270px;
	left: 365px;
}

#numIVA1{
	top: 1270px;
	left: 510px;
}

#numIVA2{
	top: 1270px;
	left: 655px;
}

#numIVA3{
	top: 1270px;
	left: 785px;
}
#numTotal{
	top: 1270px;
	left: 895px;
}
#division3{
	top: 1300px;
	width: 100%;
	height: 15px;
	background-color: black;
}
#observaciones{
	top: 1325px;
	left: 35px;
}
#cae{
	top: 1375px;
	right: 200px;
}

#importeLetras{
	top: 1325px;
	right: 200px;
}
</style>
</head>
<body>

<div id="spiralSa" class="absolute textoSpiral">
	Spiral Shoes S.A
	</div>
	
	<div id="logo" class="absolute">
	<img src="../../img/logos/logo.png" style="width: 252.7px; height: 190px">
	</div>
	
	<div id="infoEmpresa" class="absolute aRight">
		Chaco 2317(1822)<br/>
		valent�n Alsina<br/>
		Provincia de Buenos Aires<br/>
		Tel./Fax: 0810-362-SPIR (7747)
	</div>
	
	<div id="responsableInscripto" class="absolute s13">
		IVA RESPONSABLE INSCRIPTO
	</div>
	
	<div id="letra" class="absolute tamanoLetra">
		<?php echo $letra; ?>
	</div>
	<div id="lineaVertical1" class="absolute"></div>
	<div id="lineaVertical2" class="absolute"></div>
	
	<div id="notaDeCredito" class="absolute">
		NOTA DE CREDITO
	</div>
	
	<div id="codigo19" class="absolute">Codigo 19 </div>
	
	<div id="nroFactura" class="absolute">
		<?php echo Funciones::padLeft($numero, 10, "0"); ?>
	</div>
	
	<div id="fecha" class="absolute">
		FECHA
	</div>
	
	<div  class="fuenteArial">
		<?php echo '<div id="dia" class="absolute">' . $fecha[0]. " </div> "; 
			  echo '<div id="mes" class="absolute">' . $fecha[1] . " </div> ";
			  echo '<div id="anio" class="absolute">' . Funciones::padLeft($fecha[2]-2000, 2, "0") . '</div>';
		?>
	</div>
	
	<div id="numerosEmpresa" class="absolute aRight">
		C.U.I.T N� 33-71005145-9<br/>
		ING. BRUTOS N� 33-71005145-9<br/>
		INICIO DE ACTIVIDADES 04/2007
	</div>

	<div id="division1" class="absolute">
	</div>
	
	<div id="nombre" class="absolute">
		Sr/es: 
	</div>
	<div id="nombreVal" class="textoSize1 textoSize1 absolute">
	<?php echo $nombreCliente; ?>
	</div>
	
	<div id="direccion" class="absolute">
		Domicilio: 
	</div>
	<div id="direccionVal" class="textoSize1 absolute">
		<?php echo $direccion; ?>
	</div>
	
	<div id="condicionIVA" class="absolute">
		I.V.A.:
	</div>
	<div id="condicionIVAval" class="absolute">
		<?php echo $nombreCondicionIva; ?>
	</div>
	
	<div id="cuit" class="absolute">
		C.U.I.T.:
	</div>
	<div id="cuitVal" class="textoSize1 absolute">
		<?php echo $cuit; ?>
	</div>

<div id="fondoCabeceraDetalle" class="absolute"></div>


	<div id="cabeceraCodigo" class="absolute white">
		CODIGO
	</div>
	
	<div id="cabeceraDescripcion" class="absolute white">
		DESCRIPCION
	</div>
	
	<div id="cabeceraCantidad" class="absolute white">
		CANTIDAD
	</div>
	
	<div id="cabeceraUnitario" class="absolute white">
		P.UNITARIO
	</div>
	
	<div id="cabeceraTotal" class="absolute white">
		TOTAL
	</div>
<div id="detalle" class="absolute">
	<?php
		/*
		 * {codArt: 350, nombreArt: 'Avril Woman', codColor: 'V', 
		 * 'nombreColor': 'verde', cantidad: 2, precioUnitario: 310.50, precioTotal: 721.00}
		 */
		foreach ($detalle as $articulo) {
			foreach ($articulo as $colores) {
				foreach ($colores as $precios) {
					foreach ($precios as $item) {
						$codigo = $item['codAlm'] . ($item['codArt'] ? '-' . $item['codArt'] . '-' . $item['codColor'] : '');
						echo '<div class="textoSize12 detalleCodArt fLeft aLeft">�' . $codigo . '</div>';
						echo '<div class="textoSize12 detalleNombreArt fLeft aLeft">�'. $item['nombreArt'] . '</div>';
						echo '<div class="textoSize12 detalleCantidad fLeft aLeft">�' . $item['cantidad'] . '</div>';	
						echo '<div class="textoSize12 detallePrecioUnitario fLeft aLeft">�' . Funciones::formatearMoneda($item['precioUnitario']) . '</div>';		
						echo '<div class="textoSize12 detallePrecioTotal fLeft aLeft">�' . Funciones::formatearMoneda($item['precioTotal']) . '</div>';
					}
				}
			}
		}
	?>
</div>

<div id="division2" class="absolute"></div>

<div id="subtotal1" class="absolute">
	Subtotal
</div>

<div id="numSubtotal1" class="textoSize12 absolute">
	
</div>

<div id="descuento" class="absolute">
	Descuento
</div>

<div id="numDescuento" class="textoSize12 absolute">
	<?php echo Funciones::formatearMoneda($descuentos); ?>
</div>

<div id="subtotal2" class="absolute">
	Subtotal
</div>

<div id="numSubtotal2" class="textoSize12 absolute">
	
</div>

<div id="total" class="absolute">
	Total
</div>
<div id="numTotal" class="textoSize12 absolute">
	<?php echo Funciones::formatearMoneda($importeTotal); ?>
</div>

<div id="division3" class="absolute"></div>

<div id="observaciones" class="absolute">
	OBSERVACIONES:
</div>
<div id="cae" class="absolute">
	C.A.E N�<br/>
	F. Vto.:
</div>
<div id="importeLetras" class="absolute">
	
</div>

</body>
</html>