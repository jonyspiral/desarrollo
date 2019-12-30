<?php require_once('../../../premaster.php'); if (Usuario::logueado()->puede('abm/clientes/buscar/')) { ?>
<?php

$cuit = Funciones::get('cuit');

try {
	if (isset($cuit)){
		$clientes = Factory::getInstance()->getListObject('Cliente', 'cuit = ' . Datos::objectToDB($cuit));
		if (count($clientes) == 0) {
			if(Funciones::validarCuit($cuit)){
				HTML::jsonSuccess();
			} else {
				HTML::jsonError($msgExiste . 'El cuit ingresado no es v�lido.');
			}
		} else {
			$cliente = $clientes[0];
			$msgExiste = 'El cuit ingresado ya existe. Corresponde al cliente "' . $cliente->id . ' - ' . $cliente->razonSocial . '" ';
			if ($cliente->anulado == 'S' && $cliente->autorizado == 'S')
				HTML::jsonError($msgExiste . 'y est� anulado.');
			elseif ($cliente->anulado == 'N' && $cliente->autorizado == 'S')
				HTML::jsonError($msgExiste . '.');
			elseif ($cliente->anulado == 'S' && $cliente->autorizado == 'N')
				HTML::jsonError($msgExiste . 'y a�n no fue autorizado.');
			elseif ($cliente->anulado == 'N' && $cliente->autorizado == 'N')
				HTML::jsonError($msgExiste . 'y est� anulado y desautorizado (situaci�n extra�a).');
		}
	}
} catch (Exception $ex) {
	Html::jsonError('Ocurri� un error al intentar verificar el cuit');
}
?>
<?php } ?>