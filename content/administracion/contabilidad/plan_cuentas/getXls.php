<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/plan_cuentas/buscar/')) { ?>
<?php

$desde = Funciones::get('desde');
$hasta = Funciones::get('hasta');
$concepto = (Funciones::get('concepto') ? explode(' ', Funciones::get('concepto')) : array());
$esReporte = Funciones::get('$esReporte', '1');

try {
	$html2xls = new Html2Xls();
	$html2xls->html = Html2Xls::getHtmlFromPhp('buscar.php');
	$html2xls->fileName = 'Plan_de_cuentas' . (isset($desde) ? '_' . $desde : '') . (isset($hasta) ? '_' . $hasta : '');
	$html2xls->tituloReporte = 'Plan de Cuentas';
	$html2pdf->datosCabecera = array('Cta. desde' => (isset($desde) ? $desde : '-'), 'Cta. hasta' => (isset($hasta) ? $hasta : '-'));
	$html2xls->download();
	$html2xls->deleteFiles();
} catch (Exception $ex) {
	Html::jsonError($ex->getMessage());
}

?>
<?php } ?>