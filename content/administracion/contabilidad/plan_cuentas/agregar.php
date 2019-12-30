<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/contabilidad/plan_cuentas/buscar/')) { ?>
<?php

$concepto = Funciones::post('concepto');
$cuenta = Funciones::post('cuenta');
$imputable = Funciones::post('imputable');

try {
	if (strlen($cuenta) != 7)
		throw new FactoryExceptionCustomException('El n�mero de cuenta debe ser de 7 caracteres.');

	if (is_int($cuenta))
		throw new FactoryExceptionCustomException('El n�mero de cuenta debe ser un entero positivo.');

	if($imputable != 'S' && $imputable != 'N')
		throw new FactoryExceptionCustomException('Error en el formato del campo no imputable.');

	try {
		$imputacionExistente = Factory::getInstance()->getImputacion($cuenta);
		if($imputacionExistente->anulado()){
			$imputacionExistente->idNuevo = $imputacionExistente->id;
			$imputacionExistente->anulado = 'N';
			$imputacion = $imputacionExistente;
		} else {
			throw new FactoryExceptionCustomException('El n�mero de cuenta ingresado ya existe en el sistema');
		}
	} catch(FactoryExceptionRegistroNoExistente $ex) {
		$imputacion = Factory::getInstance()->getImputacion();
	}

	$imputacion->nombre = $concepto;
	$imputacion->id = $cuenta;
	$imputacion->imputable = $imputable;
	$imputacion->guardar()->notificar('abm/imputaciones/agregar/');

	Html::jsonSuccess('La imputaci�n fue guardada correctamente');
} catch (FactoryExceptionRegistroExistente $ex) {
	Html::jsonError('El n�mero de cuenta ingresado ya existe en el sistema');
} catch (FactoryExceptionCustomException $ex){
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar guardar la imputaci�n');
}

?>
<?php } ?>