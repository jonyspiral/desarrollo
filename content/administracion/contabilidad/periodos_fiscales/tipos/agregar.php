<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/periodos_fiscales/tipos/agregar/')) { ?>
<?php

$nombre = Funciones::post('nombre');

try {
	$tipoPeriodoFiscal = Factory::getInstance()->getTipoPeriodoFiscal();
	$tipoPeriodoFiscal->nombre = $nombre;

	$tipoPeriodoFiscal->guardar()->notificar('administracion/contabilidad/periodos_fiscales/tipos/agregar/');
	Html::jsonSuccess('El tipo de per�odo fiscal fue guardado correctamente');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar guardar el tipo de per�odo fiscal');
}
?>
<?php } ?>