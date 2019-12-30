<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/asientos_contables/editar/')) { ?>
<?php

$empresa = Funciones::session('empresa');
$id = Funciones::post('id');
$nombre = Funciones::post('nombre');
$fecha = Funciones::post('fecha');
$detalleJson = Funciones::post('detalleJson');

try {
	$asientoContable = Contabilidad::contabilizar($empresa, $nombre, $fecha, $detalleJson, $id);
	Html::jsonSuccess('Se edit� correctamente el asiento contable', $asientoContable->expand());
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar editar el asiento contable');
}

?>
<?php } ?>