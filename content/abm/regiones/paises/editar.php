<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('abm/regiones/paises/editar/')) { ?>
<?php

$idPais = Funciones::post('idPais');
$nombre = Funciones::post('nombre');
try {
	if (!isset($idPais))
		throw new FactoryExceptionRegistroNoExistente();
	$pais = Factory::getInstance()->getPais($idPais);
	$pais->nombre = $nombre;
	Factory::getInstance()->persistir($pais);
	Html::jsonSuccess('El pa�s fue guardado correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('El pa�s que intent� editar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar guardar el pa�s');
}
?>
<?php } ?>