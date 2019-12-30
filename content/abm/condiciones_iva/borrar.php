<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/condiciones_iva/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$condicionIva = Factory::getInstance()->getCondicionIva($id);
	Factory::getInstance()->marcarParaBorrar($condicionIva);
	Factory::getInstance()->persistir($condicionIva);
	Html::jsonSuccess('La condici�n de IVA fue borrada correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('La condici�n de IVA que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar la condici�n de IVA');
}
?>
<?php } ?>