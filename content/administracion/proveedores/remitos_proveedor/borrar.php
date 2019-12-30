<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('administracion/proveedores/remitos_proveedor/borrar/')) { ?>
<?php

$idRemito = Funciones::post('idRemito');

try {
	if (!isset($idRemito))
		throw new FactoryExceptionRegistroNoExistente();

	Factory::getInstance()->beginTransaction();

	$remito = Factory::getInstance()->getRemitoProveedor($idRemito);

	if($remito->esHexagono()){
		throw new FactoryExceptionCustomException('No se pueden borrar remitos que fueron creados en el sistema Hex�gono');
	}

	$remito->borrar();

	Factory::getInstance()->commitTransaction();

	Html::jsonSuccess('El remito N� "' . $idRemito . '" fue borrado correctamente');
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (FactoryExceptionRegistroExistente $ex){
	Html::jsonError('No existe el remito N� ' . $idRemito);
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar el remito');
}

?>
<?php } ?>