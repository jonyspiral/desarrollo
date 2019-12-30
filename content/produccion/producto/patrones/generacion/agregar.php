<?php require_once('../../../../../premaster.php'); if (Usuario::logueado()->puede('produccion/producto/patrones/generacion/agregar/')) { ?>
<?php

$idArticulo = Funciones::post('idArticulo');
$idColor = Funciones::post('idColor');
$idVersion = Funciones::post('idVersion');
$detalle = Funciones::post('detalle');

try {
	if (empty($idArticulo) || empty($idColor) || empty($idVersion)) {
		throw new FactoryExceptionCustomException('Debe completar todos los campos obligatorios');
	}

	if (count($detalle) == 0) {
		throw new FactoryExceptionCustomException('El patr�n debe tener al menos un detalle');
	}

	$articuloColor = Factory::getInstance()->getColorPorArticulo($idArticulo, $idColor);

	if (!$articuloColor->idArticulo) {
		throw new FactoryExceptionCustomException('El Art�culo no existe o no posee el color seleccionado');
	}

	if (($articuloColor->getUltimoPatron() + 1) != $idVersion) {
		throw new FactoryExceptionCustomException('No puede crear un patr�n con una numeraci�n no consecutiva al �ltimo creado para el art�culo "' . $idArticulo . '" color "' . $idColor . '"');
	}

	Factory::getInstance()->beginTransaction();

	$patron = Factory::getInstance()->getPatron();
	$patron->articulo = $articuloColor->articulo;
	$patron->colorPorArticulo = $articuloColor;
	$patron->version = $idVersion;
	if ($patron->version == 1) {
		$patron->tipoPatron = 'P';
	}
	$patron->confirmado = 'N';
	$patron->versionActual = 'N';
	$patron->borrador = 'N';

	foreach ($detalle as $item) {
		if (empty($item['idSeccion']) || empty($item['idConjunto']) || empty($item['idMaterial']) || empty($item['idColor']) || empty($item['consumoPar'])) {
			throw new FactoryExceptionCustomException('Debe completar todos los campos de los detalles');
		}

		$patronItem = Factory::getInstance()->getPatronItem();
		$patronItem->patron = $patron;
		$patronItem->seccion = Factory::getInstance()->getSeccionProduccion($item['idSeccion']);
		$patronItem->conjunto = Factory::getInstance()->getConjunto(trim($item['idConjunto']));
		$patronItem->colorMateriaPrima = Factory::getInstance()->getColorMateriaPrima($item['idMaterial'], $item['idColor']);
		$patronItem->material = $patronItem->colorMateriaPrima->material;
		$patronItem->consumoPar = Funciones::toFloat($item['consumoPar']);

		$patron->addDetalle($patronItem);
	}

	$patron->guardar();

	Factory::getInstance()->commitTransaction();
	Html::jsonSuccess('El patron se agreg� correctamente');
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex) {
	Html::jsonError('Ocurri� un error al intentar agregar el patron');
}

?>
<?php } ?>