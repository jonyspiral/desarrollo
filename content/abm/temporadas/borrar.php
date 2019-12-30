<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/temporadas/borrar/')) { ?>
<?php

$idTemporada = Funciones::post('idTemporada');

try {
	$temporada = Factory::getInstance()->getTemporada($idTemporada);
	$temporada->borrar()->notificar('abm/temporadas/borrar/');
	Html::jsonSuccess('La temporada fue borrada correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('La temporada que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar la temporada');
}
?>
<?php } ?>