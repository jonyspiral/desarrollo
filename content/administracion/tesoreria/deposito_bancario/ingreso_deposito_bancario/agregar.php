<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/tesoreria/deposito_bancario/ingreso_deposito_bancario/agregar/')) { ?>
<?php

$idCajaOrigen = Funciones::post('idCajaOrigen');
$idCuentaBancaria = Funciones::post('idCuentaBancaria');
$fecha = Funciones::post('fecha');
$ventaDeCheque = Funciones::post('ventaCheque');
$numeroBoleta = Funciones::post('numeroBoleta');
$efectivo = Funciones::post('efectivo');
$efectivo = (empty($efectivo) ? 0 : $efectivo);
$arrayCheques = Funciones::post('cheques');

try {
	Factory::getInstance()->beginTransaction();

	$depositoBancarioTemporal = Factory::getInstance()->getDepositoBancarioTemporal();

	$ventaDeCheque == 'S' ? $tipoEspera = 'D' : $tipoEspera = 'N';
	foreach($arrayCheques as $itemCheque){
		$cheque = Factory::getInstance()->getCheque($itemCheque['id']);
		$depositoBancarioTemporal->addCheque($cheque);
	}

	$depositoBancarioTemporal->caja = Factory::getInstance()->getCaja($idCajaOrigen);
	$depositoBancarioTemporal->cuentaBancaria = Factory::getInstance()->getCuentaBancaria($idCuentaBancaria);
	$depositoBancarioTemporal->ventaCheque = $ventaDeCheque;
	$depositoBancarioTemporal->efectivo = $efectivo;
	if ($ventaDeCheque == 'N') {
		$depositoBancarioTemporal->numeroBoleta = $numeroBoleta;
	}
	$depositoBancarioTemporal->fecha = $fecha;

	$depositoBancarioTemporal->guardar()->notificar('administracion/tesoreria/deposito_bancario/ingreso_deposito_bancario/agregar/');

	Factory::getInstance()->commitTransaction();

	$nombreOperaci�n = ($depositoBancarioTemporal->esVentaCheque() ? 'la venta de cheques' : 'el dep�sito bancario');

	Html::jsonSuccess('Se gener� correctamente ' . $nombreOperaci�n . ' y se encuentra disponible para confirmar.');
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar generar ' . $nombreOperaci�n);
}

?>
<?php } ?>