<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/areas_empresa/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$areaEmpresa = Factory::getInstance()->getAreaEmpresa($id);
	$areaEmpresa->borrar()->notificar('abm/areas_empresa/borrar/');
	Html::jsonSuccess('El �rea empresa fue borrado correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('El �rea empresa que intent� borrar no existe');
} catch (Exception $ex) {
	Html::jsonError('Ocurri� un error al intentar borrar el �rea empresa');
}

?>
<?php } ?>