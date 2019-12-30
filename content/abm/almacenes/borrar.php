<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/almacenes/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$almacen = Factory::getInstance()->getAlmacen($id);
	Factory::getInstance()->marcarParaBorrar($almacen);
	Factory::getInstance()->persistir($almacen);
	Html::jsonSuccess('El almac�n fue borrado correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('El almac�n que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar el almac�n');
}
?>
<?php } ?>