<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/colores_por_articulo/borrar/')) { ?>
<?php

$idArticulo = Funciones::post('idArticulo');
$idColorPorArticulo = Funciones::post('id');

try {
	if (!isset($idArticulo) || !isset($idColorPorArticulo)) {
		throw new FactoryExceptionRegistroNoExistente();
	}
	$colorPorArticulo = Factory::getInstance()->getColorPorArticulo($idArticulo, $idColorPorArticulo);
	$colorPorArticulo->borrar()->notificar('abm/colores_por_articulo/borrar/');
	Html::jsonSuccess('El color por art�culo fue borrado correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('El color por art�culo que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar el color por art�culo');
}
?>
<?php } ?>