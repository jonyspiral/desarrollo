<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/almacenes/agregar/')) { ?>
<?php

$id = Funciones::post('idAgregar');
$nombre = Funciones::post('nombre');
$nombreCorto = Funciones::post('nombreCorto');

try {
	$almacen = Factory::getInstance()->getAlmacen();
	$almacen->id = $id;
	$almacen->nombre = $nombre;
	$almacen->nombreCorto = $nombreCorto;
	
	$almacen->guardar()->notificar('abm/almacenes/agregar/');
	Html::jsonSuccess('El almac�n fue guardada correctamente');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar guardar el almac�n');
}

?>
<?php } ?>