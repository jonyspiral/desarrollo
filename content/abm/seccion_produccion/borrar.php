<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/seccion_produccion/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$seccion = Factory::getInstance()->getSeccionProduccion($id);
	$seccion->borrar()->notificar('abm/seccion_produccion/borrar/');

	Html::jsonSuccess('La secci�n fue borrada correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('La secci�n que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar la secci�n');
}

?>
<?php } ?>