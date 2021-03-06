<?php
?>

<script type='text/javascript'>
	$(document).ready(function(){
		tituloPrograma = 'Movimiento de almac�n PT';
		//noinspection JSCheckFunctionSignatures
		$('.inputPar').livequery(function(){
			$(this).blur(function() {
				blurPar($(this));
			});
		});
		cambiarModo('inicio');
	});

	function buscar() {
		if (!$('#inputBuscarAlmacen_selectedValue').val()) {
			$.error('Debe elegir el almac�n desde el cual quiere realizar los movimientos');
			return;
		}
		funciones.limpiarScreen();
		var url = funciones.controllerUrl('buscar', {
			idAlmacen: $('#inputBuscarAlmacen_selectedValue').val(),
			idArticulo: $('#inputBuscarArticulo_selectedValue').val(),
			idColorArticulo: $('#inputBuscarColorArticulo_selectedValue').val(),
			one: '0',
			orden: $('#inputOrden').val()
		});
		funciones.load($('#divMovimientoAlmacen'), url, function() {
			$('#divMovimientoAlmacen').fixedHeader({target: 'table'});
			$('.btnConfirmar').click(guardar);
			cambiarModo('agregar');
		});
	}

	function blurPar(obj) {
		if (funciones.toInt(obj.val()) > funciones.toInt(obj.data('maxcant')) || funciones.toInt(obj.val()) < 0 || obj.val() == '')
			obj.val(obj.data('maxcant'));
		var idComb = funciones.padLeft(obj.data('idalmacen').toString(), 2) + '-' + obj.data('idarticulo') + '-' + obj.data('idcolorarticulo');
		var sum = 0;
		$('.articulo_' + idComb).each(function(){
			sum += funciones.toInt($(this).val());
		});
		$('#total_' + idComb).text(sum);
	}

	function hayErrorGuardar(obj){
		if (!obj.cantidadTotal) {
			return 'No puede hacer un movimiento vac�o (todas las columnas est�n en cero)';
		}
		if (!obj.idAlmacen) {
			return 'Deber� elegir el almac�n al que quiere mover la mercader�a';
		}
		if (!obj.motivo) {
			return 'Deber� ingresar un motivo por el cual quiere mover la mercader�a';
		}
		return false;
	}

	function guardar(e){
		var obj = armoObjetoGuardar((e.target.tagName == 'IMG') ? $(e.target).parents('a') : $(e.target));
		var error = hayErrorGuardar(obj);
		if (!error) {
			$.confirm('�Est� seguro que desea mover ' + obj.cantidadTotal + ' pares del almac�n ' + obj.idAlmacenOriginal + ' al ' + obj.idAlmacen + '?', function(r) {
				if (r == funciones.si) {
					var url = funciones.controllerUrl('agregar');
					funciones.guardar(url, obj, function() {
						$.info(this.responseMsg);
						funciones.delay('$.showLoading()', 200);
						refreshOne(obj);
					}, null, null, false);
				}
			});
		} else {
			$.error(error);
		}
	}

	function armoObjetoGuardar(obj){
		var idComb = funciones.padLeft(obj.data('idalmacen').toString(), 2) + '-' + obj.data('idarticulo') + '-' + obj.data('idcolorarticulo');
		var i = 1;
		var sum = 0;
		var movimiento = {};
		var almacenPad = funciones.padLeft($('#mover_a_' + idComb + '_selectedValue').val().toString(), 2);
		almacenPad = (almacenPad == '00' ? null : almacenPad);
		movimiento.idAlmacen = almacenPad;
		movimiento.idAlmacenOriginal = funciones.padLeft(obj.data('idalmacen').toString(), 2);
		movimiento.idArticulo = obj.data('idarticulo');
		movimiento.idColorArticulo = obj.data('idcolorarticulo');
		movimiento.motivo = $('#motivo_' + idComb).val();
		movimiento.cantidad = [];
		$('.articulo_' + idComb).each(function(){
			movimiento.cantidad[i] = funciones.toInt($(this).val());
			sum += movimiento.cantidad[i];
			i++;
		});
		movimiento.cantidadTotal = sum;
		return movimiento;
	}

	function refreshOne(obj) {
		var url = funciones.controllerUrl('buscar', {
				idAlmacen: obj.idAlmacenOriginal,
				idArticulo: obj.idArticulo,
				idColorArticulo: obj.idColorArticulo,
				one: '1'
			}),
			msgError = 'Ocurri� un error al intentar actualizar la lista. Por favor, actualice la p�gina e int�ntelo nuevamente',
			cbSuccess = function(json){
				var idComb = json.idAlmacen + '-' + json.idArticulo + '-' + json.idColorArticulo;
				$('.stock_' + idComb).each($.proxy(function(a, b){
					$(b).text(funciones.toInt(this.cantidad[a + 1]));
				}, json));
				$('.articulo_' + idComb).val(0);
				var row = $('#row_' + idComb);
				if (json.cantidadTotal > 0) {
					blurPar($(row).find('.inputPar:last'));
					$(row).find('.mover_a').val('');
					$(row).find('.motivo').val('');
					$(row).find('.inputPar:first').focus();
				} else {
					row.remove();
					$('#divMovimientoAlmacen .inputPar:first').focus();
				}
			};
		funciones.buscar(url, cbSuccess, msgError);
	}

	function cambiarModo(modo){
		funciones.cambiarModo(modo);
		switch (modo){
			case 'inicio':
				$('#divMovimientoAlmacen').html('');
				break;
			case 'buscar':
				funciones.cambiarTitulo();
				break;
			case 'editar':
				break;
			case 'agregar':
				break;
		}
	}
</script>

<div id='programaTitulo'></div>
<div id='programaContenido' class='customScroll'>
	<div id='divMovimientoAlmacen' class='w100p customScroll acordeon h480'>
		<?php // TABLOTA ?>
	</div>
</div>
<div id='programaPie'>
	<div id='filtro' class='draggableDialog hidden'>
		<div>
			<label for='inputBuscarAlmacen' class='filtroBuscar'>Almac�n:</label>
			<input id='inputBuscarAlmacen' class='textbox autoSuggestBox obligatorio filtroBuscar w220' name='UsuarioPorAlmacen' alt='&idUsuario=<?php echo Usuario::logueado()->id; ?>' />
		</div>
		<div>
			<label for='inputBuscarArticulo' class='filtroBuscar'>Art�culo:</label>
			<input id='inputBuscarArticulo' class='textbox autoSuggestBox filtroBuscar w220' name='Articulo' alt='' />
		</div>
		<div>
			<label for='inputBuscarColorArticulo' class='filtroBuscar'>Color:</label>
			<input id='inputBuscarColorArticulo' class='textbox autoSuggestBox filtroBuscar w220' name='ColorPorArticulo' linkedTo='inputBuscarArticulo,Articulo' alt='' />
		</div>
		<div>
			<label for="inputOrden" class='filtroBuscar'>Orden:</label>
			<select id='inputOrden' class='textbox filtroBuscar w220'>
				<option value='0'>N� de art�culo/color ascendente</option>
				<option value='1'>N� de art�culo/color descendente</option>
				<option value='2'>Cantidad stock descendente</option>
				<option value='3'>Cantidad stock ascendente</option>
			</select>
		</div>
		<div>
			<a id='btnMiniBuscar' class='boton' href='#' title='Buscar'><img src="/img/botones/25/buscar.gif" /></a>
		</div>
	</div>
	<div class='botonera'>
		<?php Html::echoBotonera(array('boton' => 'buscar', 'accion' => 'funciones.buscarClick();')); ?>
		<?php Html::echoBotonera(array('boton' => 'cancelar', 'accion' => 'funciones.cancelarBuscarClick();', 'id' => 'btnCancelarBuscar')); ?>
	</div>
</div>