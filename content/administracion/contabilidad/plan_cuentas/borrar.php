<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/plan_cuentas/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$imputacion = Factory::getInstance()->getImputacion($id);
	Factory::getInstance()->marcarParaBorrar($imputacion);
	$imputacion->borrar()->notificar('abm/imputaciones/borrar/');
	Html::jsonSuccess('La imputaci�n fue borrada correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('La imputaci�n que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar la imputaci�n');
}
?>
<?php } ?>