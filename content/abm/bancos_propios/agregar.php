<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/bancos_propios/agregar/')) { ?>
<?php

$idBanco = Funciones::post('idBanco');
$nombreSucursal = Funciones::post('nombreSucursal');
$calle = Funciones::post('calle');
$numeroCalle = Funciones::post('numero');
$piso = Funciones::post('piso');
$dpto = Funciones::post('dpto');
$codPostal = Funciones::post('codPostal');
$idPais = Funciones::post('idPais');
$idProvincia = Funciones::post('idProvincia');
$idLocalidad = Funciones::post('idLocalidad');
$fechaInicioCuenta = Funciones::post('fechaInicioCuenta');
$telefono = Funciones::post('telefono');
$observaciones = Funciones::post('observaciones');

try {
	$bancoPropio = Factory::getInstance()->getBancoPropio();
	$bancoPropio->banco = Factory::getInstance()->getBanco($idBanco);
	$bancoPropio->nombreSucursal = $nombreSucursal;

	$bancoPropio->fechaInicioCuenta = $fechaInicioCuenta;
	$bancoPropio->telefono = $telefono;
	$bancoPropio->observaciones = $observaciones;

	$bancoPropio->direccion->calle = $calle;
	$bancoPropio->direccion->numero = $numeroCalle;
	$bancoPropio->direccion->piso = $piso;
	$bancoPropio->direccion->departamento = $dpto;
	$bancoPropio->direccion->pais = Factory::getInstance()->getPais($idPais);
	$bancoPropio->direccion->provincia = Factory::getInstance()->getProvincia($idPais, $idProvincia);
	$bancoPropio->direccion->localidad = Factory::getInstance()->getLocalidad($idPais, $idProvincia, $idLocalidad);
	$bancoPropio->direccion->codigoPostal = $codPostal;

	$bancoPropio->guardar()->notificar('abm/bancos_propios/agregar/');
	Html::jsonSuccess('El banco propio fue guardado correctamente');
} catch (FactoryException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex) {
	Html::jsonError('Ocurri� un error al intentar guardar el banco propio');
}

?>
<?php } ?>
