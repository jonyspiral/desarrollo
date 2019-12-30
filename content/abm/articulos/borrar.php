<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/articulos/borrar/')) { ?>
<?php

$id = Funciones::post('id');

try {
	$articulo = Factory::getInstance()->getArticulo($id);
	$articulo->borrar()->notificar('abm/articulos/borrar/');

	Html::jsonSuccess('El art�culo fue borrado correctamente');
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('El art�culo que intent� borrar no existe');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar borrar el art�culo');
}

?>
<?php } ?>