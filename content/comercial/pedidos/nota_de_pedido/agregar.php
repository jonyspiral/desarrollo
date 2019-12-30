<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('comercial/pedidos/nota_de_pedido/agregar/')) { ?>
<?php

$idCliente = Funciones::post('idCliente');
$idSucursal = Funciones::post('idSucursal');
$idAlmacen = Funciones::post('idAlmacen');
$observaciones = Funciones::post('observaciones');
//$formaDePago = Funciones::post('formaDePago');
$idTemporada = Funciones::post('idTemporada');
$descuento = Funciones::post('descuento');
$recargo = Funciones::post('recargo');
$idVendedor = Funciones::post('idVendedor');
$detalleNotaDePedido = Funciones::post('notaDePedido');

try {
	$notaDePedido = Factory::getInstance()->getPedido();
	$notaDePedido->empresa = 1;
	$notaDePedido->cliente = Factory::getInstance()->getClienteTodos($idCliente);
	$notaDePedido->sucursal = Factory::getInstance()->getSucursal($idCliente, $idSucursal);
	if (!Usuario::logueado()->esCliente() && !Usuario::logueado()->esVendedor()){
		$notaDePedido->idAlmacen = (isset($idAlmacen) ? $idAlmacen : '01');
		//$notaDePedido->formaDePago = Factory::getInstance()->getFormaDePago($formaDePago);
		$notaDePedido->descuento = Funciones::toFloat($descuento);
		$notaDePedido->recargo = Funciones::toFloat($recargo);
	} else {
		//Hardcodeo para los vendedores y clientes
		$notaDePedido->idAlmacen = '01';
	}
	if (Usuario::logueado()->esCliente())
		$idVendedor = Usuario::logueado()->contacto->cliente->vendedor->id;
	elseif (Usuario::logueado()->esVendedor())
		$idVendedor = Usuario::logueado()->getCodigoPersonal();
	$notaDePedido->temporada = Factory::getInstance()->getTemporada($idTemporada);
	$notaDePedido->observaciones = $observaciones;
	$notaDePedido->vendedor = Factory::getInstance()->getVendedor($idVendedor);
	$notaDePedido->usuario = Usuario::logueado();
	$notaDePedido->precioAlFacturar = 'S';
	$notaDePedido->aprobado = 'N';

	$nroItem = 1;
	foreach ($detalleNotaDePedido as $idCombinado => $curvas){
		$idCombinado = explode('_', $idCombinado);
		$idArticulo = $idCombinado[0];
		$idColorPorArticulo = $idCombinado[1];
		$colorPorArticulo = Factory::getInstance()->getColorPorArticulo($idArticulo, $idColorPorArticulo);
		$arrValores = array();
		foreach ($curvas as $key => $val){
			if ($key == 'L'){
				$cantidades = explode('-', $val);
				$i = 1;
				foreach ($cantidades as $cantidad){
					if (!isset($arrValores[$i]))
						$arrValores[$i] = 0;
					$arrValores[$i] += Funciones::toInt($cantidad);
					$i++;
				}
				break;
			} else {
				$curva = Factory::getInstance()->getCurva($key);
				$i = 1;
				foreach ($curva->cantidad as $cantidad){
					if (!isset($arrValores[$i]))
						$arrValores[$i] = 0;
					$arrValores[$i] += Funciones::toInt($cantidad) * Funciones::toInt($val);
					$i++;
				}
			}
		}
		$notaDePedidoItem = Factory::getInstance()->getPedidoItem();
		$notaDePedidoItem->empresa = $notaDePedido->empresa;
		$notaDePedidoItem->idAlmacen = $notaDePedido->idAlmacen;
		$notaDePedidoItem->idArticulo = $idArticulo;
		$notaDePedidoItem->idColorPorArticulo = $idColorPorArticulo;
		$notaDePedidoItem->numeroDeItem = $nroItem;
		$notaDePedidoItem->precioUnitario = $colorPorArticulo->getPrecioSegunCliente($notaDePedido->cliente);
		for ($i = 1; $i <= 10; $i++)
			$notaDePedidoItem->cantidad[$i] = Funciones::toInt(Funciones::keyIsSet($arrValores, $i, 0));
		$notaDePedido->addItem($notaDePedidoItem);
		$nroItem++;
	}
	$notaDePedido->calcularTotal();
	$notaDePedido->guardar()->notificar('comercial/pedidos/nota_de_pedido/agregar/');
	Html::jsonSuccess('La nota de pedido fue guardada correctamente');
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar guardar la nota de pedido');
}

?>
<?php } ?>