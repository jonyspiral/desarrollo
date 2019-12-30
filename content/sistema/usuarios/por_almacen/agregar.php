<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('sistema/usuarios/por_almacen/agregar/')) { ?>
<?php

$idUsuario = Funciones::post('idUsuario');
$idAlmacen = Funciones::post('idAlmacen');

try {
	$uxa = Factory::getInstance()->getUsuarioPorAlmacen();
	$uxa->idAlmacen = $idAlmacen;
	$uxa->id = $idUsuario;
	$uxa->guardar()->notificar('sistema/usuarios/por_almacen/agregar/');

	$uxa = Factory::getInstance()->getUsuarioPorAlmacen($idUsuario, $idAlmacen);

	Html::jsonSuccess('El usuario fue agregado correctamente a los permisos del almac�n', $uxa->expand());
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (FactoryExceptionRegistroExistente $ex) {
	Html::jsonError('Ese usuario ya ten�a permisos sobre el almac�n. Por favor, recargue la p�gina');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar agregar el usuario a los permisos del almac�n');
}
?>
<?php } ?>