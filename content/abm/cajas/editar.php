<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/cajas/editar/')) { ?>
<?php

$id = Funciones::post('id');
$nombre = Funciones::post('nombre');
$fechaLimite = Funciones::post('fechaLimite'); // No se usa
$diasCierre = Funciones::post('diasCierre'); // No se usa
$importeDescubierto = Funciones::post('importeDescubierto');
$importeMaximo = Funciones::post('importeMaximo');
$esCajaBanco = Funciones::post('esCajaBanco') == 'S' ? 'S' : 'N';
$idImputacion = Funciones::post('idImputacion');
$dispParaNegociar = Funciones::post('dispParaNegociar');

$cajasTransferencias = Funciones::post('cajasTransferencias');
$permisos = Funciones::post('permisos');

try {
	if (!isset($id)) {
		throw new FactoryExceptionRegistroNoExistente();
	}

	$caja = Factory::getInstance()->getCaja($id);
	if ($caja->anulado()) {
		throw new FactoryExceptionRegistroNoExistente();
	}

	$caja->nombre = $nombre;
	$caja->fechaLimite = $fechaLimite; // No se usa
	$caja->diasCierre = $diasCierre; // No se usa
	$caja->importeDescubierto = $importeDescubierto;
	$caja->importeMaximo = $importeMaximo;
	$caja->esCajaBanco = $esCajaBanco;
	$caja->dispParaNegociar = $dispParaNegociar;
	$caja->imputacion = Factory::getInstance()->getImputacion($idImputacion);

	// Cajas para Transferencias
	$finalCajasTransferencias = array();
	foreach ($cajasTransferencias as $ct) {
		$cajasTransferencia = Factory::getInstance()->getCajaPosiblesTransferenciaInterna();
		$cajasTransferencia->idCajaSalida = $caja->id;
		$cajasTransferencia->idCajaEntrada = $ct['id'];
		$finalCajasTransferencias[] = $cajasTransferencia;
	}
	$caja->cajasPosiblesTransferenciaInterna = $finalCajasTransferencias;

	// Permisos
	$finalPermisos = array();
	$auxUsuarios = array();

	foreach ($permisos as $p) {
		if (! array_key_exists($p['idUsuario'], $auxUsuarios)) {
			$permisoInicial = Factory::getInstance()->getPermisoPorUsuarioPorCaja();
			$permisoInicial->idCaja = $caja->id;
			$permisoInicial->idUsuario = $p['idUsuario'];
			$permisoInicial->idPermiso = PermisosUsuarioPorCaja::verCaja;
			$finalPermisos[] = $permisoInicial;
			$auxUsuarios[$p['idUsuario']] = true;
		}

		if ($p['idPermiso'] != PermisosUsuarioPorCaja::verCaja) {
			$permiso = Factory::getInstance()->getPermisoPorUsuarioPorCaja();
			$permiso->idCaja = $caja->id;
			$permiso->idUsuario = $p['idUsuario'];
			$permiso->idPermiso = $p['idPermiso'];
			$finalPermisos[] = $permiso;
		}
	}

	if (! array_key_exists(Usuario::logueado()->id, $auxUsuarios)) {
		// Creo un primer permiso con el usuario logueado
		$permisoInicial = Factory::getInstance()->getPermisoPorUsuarioPorCaja();
		$permisoInicial->idCaja = $caja->id;
		$permisoInicial->idUsuario = Usuario::logueado()->id;
		$permisoInicial->idPermiso = PermisosUsuarioPorCaja::verCaja;
		$finalPermisos[] = $permisoInicial;
		$auxUsuarios[Usuario::logueado()->id] = true;
	}

	$caja->permisos = $finalPermisos;

	$caja->guardar()->notificar('abm/cajas/editar/');
	Html::jsonSuccess('La caja fue guardada correctamente');
} catch (FactoryException $ex) {
	Html::jsonError($ex->getMessage());
} catch (FactoryExceptionRegistroNoExistente $e) {
	Html::jsonError('La caja que intent� editar no existe');
} catch (Exception $ex) {
	Html::jsonError('Ocurri� un error al intentar guardar la caja ' . $ex->getMessage());
}

?>
<?php } ?>

