<?php require_once('../../../../../../premaster.php'); if (Usuario::logueado()->puede('comercial/notas_de_credito/generacion/garantia/ecommerce/agregar/')) { ?>
<?php

$idGarantia = Funciones::post('idGarantia');

try {
	if (!$idGarantia) {
		throw new FactoryExceptionCustomException('Deber� indicarse el n�mero de garant�a que se desea aprobar');
	}

	$garantia = Factory::getInstance()->getGarantia($idGarantia);
	if (!is_null($garantia->solucionNcr)) {
		throw new FactoryExceptionCustomException('La garant�a ya fue resuelta. Por favor recargue la p�gina');
	}
	$garantia->finalizar('comercial/notas_de_credito/generacion/garantia/ecommerce/agregar/', true);

	Html::jsonSuccess('La garant�a fue aprobada y se ha creado correctamente la nota de cr�dito');
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar aprobar la garant�a y/o la nota de cr�dito');
}

?>
<?php } ?>