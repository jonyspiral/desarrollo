<?php
?>

<style>
	#divNotaDeCredito {
		width: 302px;
		margin: 6% 0 0 39%;
	}
	.box {
		border-width: 3px;
	}
	span {
		height: 50px;
		width: 100px;
	}
}
</style>

<script type='text/javascript'>
	var opciones = [
		{'id': 'factura', 'nombre': 'Por factura entera'},
		{'id': 'nota_de_debito', 'nombre': 'Por NDB entera'},
		{'id': 'devolucion', 'nombre': 'Por devoluci�n'},
		{'id': 'generica', 'nombre': 'Ajuste', 'tipo': 'NCA'},
		{'id': 'generica', 'nombre': 'Comercial', 'tipo': 'NCC'},
		{'id': 'generica', 'nombre': 'Financiera', 'tipo': 'NCF'},
		{'id': 'garantia/normal', 'nombre': 'Garant�a normal'},
		{'id': 'garantia/ecommerce', 'nombre': 'Garant�a ecommerce'}
	];

	$(document).ready(function(){
		tituloPrograma = 'Generaci�n de notas de cr�dito';
		cambiarModo('inicio');
		$('.box').livequery(function(){
			$(this).hover(function(){
				$(this).removeClass('bAllOrange bOrange').addClass('bAllDarkOrange bLightOrange');
			}, function(){
				$(this).removeClass('bAllDarkOrange bLightOrange').addClass('bAllOrange bOrange');
			});
			$(this).click(function(){
				window.location = window.location + this.id + '/' + ($(this).attr('tipo') !== 'undefined' ? '?tipoDocumento2=' + $(this).attr('tipo') : '');
			});
		});
		proximaOpcion(0);
	});

	function proximaOpcion(i) {
		var o = opciones[i];
		var div = $('<div id="' + o.id + '" tipo="' + o.tipo + '" class="box fLeft corner5 p10 calibri s16 bold m10 bOrange bAllOrange aCenter white cPointer"></div>');
		$('<span class="vaMiddle table-cell">' + o.nombre + '</span>').appendTo(div);
		div.hide().appendTo($('#divNotaDeCredito')).show('fast', function(){
			if (i != opciones.length - 1) {
				i += 1;
				proximaOpcion(i);
			}
		});
	}

	function cambiarModo(modo){
		funciones.cambiarModo(modo);
	}
</script>

<div id='programaTitulo'></div>
<div id='programaContenido'>
	<div id='divNotaDeCredito' class='fLeft customScroll'></div>
</div>
<div id='programaPie'>
</div>