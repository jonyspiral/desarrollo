<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('produccion/compras/presupuesto/manual/buscar/')) { ?>
<?php

$idMaterial = Funciones::get('idMaterial');

try {
	if (empty($idMaterial))
		throw new FactoryExceptionCustomException('El material no existe');

	$material = Factory::getInstance()->getMaterial($idMaterial);

	$array = array();
	$array['usaRango'] = 'N';
	$array['unidadMedida'] = Factory::getInstance()->getUnidadDeMedida($material->idUnidadMedidaCompra)->nombre;
	$array['cantidadMinima'] = $material->loteMinimo;
	$array['cantidadMultiplo'] = $material->loteMultiplo;
	if($material->usaRango()){
		$array['usaRango'] = 'S';
		$array['rango'] = $material->rango->posicion;
	}

	Html::jsonEncode('', $array);
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonInfo($ex->getMessage());
} catch (FactoryExceptionRegistroNoExistente $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex) {
	Html::jsonNull();
}

?>
<?php } ?>