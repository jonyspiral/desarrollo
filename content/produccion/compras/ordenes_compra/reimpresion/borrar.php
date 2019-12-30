<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('produccion/compras/ordenes_compra/reimpresion/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$ordenDeCompra = Factory::getInstance()->getOrdenDeCompra($id);
	$ordenDeCompra->borrar();

	Html::jsonSuccess('La �rden de compra se borr� correctamente', array('nro' => $ordenDeCompra->id));
} catch (FactoryExceptionRegistroNoExistente $ex) {
	Html::jsonError('La �rden de compra que intent� borrar no existe');
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar la �rden de compra N� "' . $id . '"');
}

?>
<?php } ?>