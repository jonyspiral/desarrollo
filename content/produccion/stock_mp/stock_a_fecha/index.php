<?php
?>

<script type='text/javascript'>
	$(document).ready(function(){
		tituloPrograma = 'Stock a fecha MP';
		cambiarModo('inicio');
	});

	function limpiarScreen(){
		$('#divStock').html('');
	}

	function buscar() {
		if ($('#inputBuscarAlmacen_selectedValue').val() == '' && $('#inputBuscarMaterial_selectedValue').val() == '') {
			$.error('Debe ingresar al menos un almac�n o un material para realizar la b�squeda');
		} else {
			funciones.limpiarScreen();
			var url = funciones.controllerUrl('buscar', {
				idAlmacen: $('#inputBuscarAlmacen_selectedValue').val(),
				idMaterial: $('#inputBuscarMaterial_selectedValue').val(),
				idColor: $('#inputBuscarColor_selectedValue').val(),
				fecha: $('#inputBuscarFecha').val()
			});
			funciones.load($('#divStock'), url);
		}
	}

	function pdfClick(){
		var finalUrl = urlToExport('pdf');
		if (finalUrl)
			funciones.pdfClick(finalUrl);
	}

	function xlsClick(){
		var finalUrl = urlToExport('xls');
		if (finalUrl)
			funciones.xlsClick(finalUrl);
	}

	function urlToExport(tipo){
		return funciones.controllerUrl('get' + (tipo == 'xls' ? 'Xls' : 'Pdf'), {
			idAlmacen: $('#inputBuscarAlmacen_selectedValue').val(),
			idMaterial: $('#inputBuscarMaterial_selectedValue').val(),
			idColor: $('#inputBuscarColor_selectedValue').val(),
			nameAlmacen: $('#inputBuscarAlmacen_selectedName').val(),
			nameMaterial: $('#inputBuscarMaterial_selectedName').val(),
			nameColor: $('#inputBuscarColor_selectedName').val(),
			fecha: $('#inputBuscarFecha').val()
		});
	}

	function cambiarModo(modo){
		funciones.cambiarModo(modo);
		switch (modo){
			case 'buscar':
				funciones.cambiarTitulo('Stock a fecha' + ($('#inputBuscarFecha').val() ? ' (' + $('#inputBuscarFecha').val() + ')' : ''));
				break;
		}
	}
</script>

<div id='programaTitulo'></div>
<div id='programaContenido'>
	<div id='divStock' class='w100p customScroll'></div>
</div>
<div id='programaPie'>
	<div id='filtro' class='draggableDialog hidden'>
		<div>
			<label class='filtroBuscar'>Almac�n:</label>
			<input type='text' id='inputBuscarAlmacen' class='textbox obligatorio autoSuggestBox filtroBuscar w200' name='Almacen' />
		</div>
		<div>
			<label class='filtroBuscar'>Material:</label>
			<input type='text' id='inputBuscarMaterial' class='textbox obligatorio autoSuggestBox filtroBuscar w200' name='Material' />
		</div>
		<div>
			<label class='filtroBuscar'>Color:</label>
			<input type='text' id='inputBuscarColor' class='textbox autoSuggestBox filtroBuscar w200' name='ColorMateriaPrima' linkedTo='inputBuscarMaterial,Material' />
		</div>
		<div>
			<label for='inputBuscarFecha' class='filtroBuscar'>Fecha:</label>
			<input id='inputBuscarFecha' class='textbox filtroBuscar w180' validate='Fecha' />
		</div>
		<div>
			<a id='btnMiniBuscar' class='boton' href='#' title='Buscar'><img src="/img/botones/25/buscar.gif" /></a>
		</div>
	</div>
	<div class='botonera'>
		<?php Html::echoBotonera(array('boton' => 'buscar', 'accion' => 'funciones.buscarClick();')); ?>
		<?php Html::echoBotonera(array('boton' => 'pdf', 'accion' => 'pdfClick();')); ?>
		<?php Html::echoBotonera(array('boton' => 'xls', 'accion' => 'xlsClick();')); ?>
		<?php Html::echoBotonera(array('boton' => 'cancelar', 'accion' => 'funciones.cancelarBuscarClick();', 'id' => 'btnCancelarBuscar')); ?>
	</div>
</div>