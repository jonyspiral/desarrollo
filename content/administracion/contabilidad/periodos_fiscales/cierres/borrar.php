<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/periodos_fiscales/cierres/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$cierre = Factory::getInstance()->getCierrePeriodoFiscal($id);
	$cierre->borrar()->notificar('administracion/contabilidad/periodos_fiscales/cierres/borrar/');

	Html::jsonSuccess('El cierre de per�odo fiscal fue borrado correctamente', array('id' => $id));
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar el cierre de per�odo fiscal');
}

?>
<?php } ?>