<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('produccion/compras/presupuesto/manual/buscar/')) { ?>
<?php

$id = Funciones::get('id');

try {
	$presupuesto = Factory::getInstance()->getPresupuesto($id);
	if ($presupuesto->anulado()) {
		throw new FactoryExceptionCustomException('El pedido de cotizaci�n est� anulado');
	}

	$presupuesto->abrir();
} catch (Exception $ex) {
	Html::jsonError($ex->getMessage());
}

?>
<?php } ?>