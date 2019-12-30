<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/periodos_fiscales/cierres/agregar/')) { ?>
<?php

$idTipoPeriodo = Funciones::post('idTipoPeriodoFiscal');
$fechaDesde = Funciones::post('fechaDesde');
$fechaHasta = Funciones::post('fechaHasta');

try {
	$cierre = Factory::getInstance()->getCierrePeriodoFiscal();
	$cierre->tipoPeriodoFiscal = Factory::getInstance()->getTipoPeriodoFiscal($idTipoPeriodo);
	$cierre->fechaDesde = $fechaDesde;
	$cierre->fechaHasta = $fechaHasta;

	$cierre->guardar()->notificar('administracion/contabilidad/periodos_fiscales/cierres/agregar/');

	Html::jsonSuccess('Se guard� correctamente el cierre de per�odo fiscal', $cierre->expand());
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar guardar el cierre de per�odo fiscal');
}

?>
<?php } ?>