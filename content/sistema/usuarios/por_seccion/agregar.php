<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('sistema/usuarios/por_seccion/agregar/')) { ?>
<?php

$idUsuario = Funciones::post('idUsuario');
$idSeccionProduccion = Funciones::post('idSeccionProduccion');

try {
	$uxa = Factory::getInstance()->getUsuarioPorSeccionProduccion();
	$uxa->idSeccionProduccion = $idSeccionProduccion;
	$uxa->id = $idUsuario;
	$uxa->guardar()->notificar('sistema/usuarios/por_seccion/agregar/');

	$uxa = Factory::getInstance()->getUsuarioPorSeccionProduccion($idUsuario, $idSeccionProduccion);

	Html::jsonSuccess('El usuario fue agregado correctamente a los permisos de la secci�n', $uxa->expand());
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (FactoryExceptionRegistroExistente $ex) {
	Html::jsonError('Ese usuario ya ten�a permisos sobre la seccion. Por favor, recargue la p�gina');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar agregar el usuario a los permisos la secci�n');
}
?>
<?php } ?>