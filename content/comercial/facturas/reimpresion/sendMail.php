<?php require_once('../../../../premaster.php'); if (Usuario::logueado()->puede('comercial/facturas/reimpresion/editar/')) { ?>
<?php

$empresa = Funciones::session('empresa');
$puntoDeVenta = Funciones::get('puntoDeVenta');
$numero = Funciones::get('numero');
$letra = Funciones::get('letra');

try {
	$factura = Factory::getInstance()->getFactura($empresa, $puntoDeVenta, 'FAC', $numero, $letra);
	if (!isset($factura->cae))
		throw new FactoryExceptionCustomException('No se puede enviar por mail una factura que a�n no tiene CAE');
	if (!PHPMailer::ValidateAddress($factura->cliente->email))
		throw new FactoryExceptionCustomException('No se puede enviar la factura porque el cliente no tiene email o es incorrecto');

	//Env�o la factura por mail al cliente!
	$asunto = 'Spiral Shoes - Factura N� ' . $factura->numeroComprobante;
	if (!PHPMailer::ValidateAddress($factura->cliente->vendedor->email))
		throw new FactoryExceptionCustomException('No se puede enviar la factura porque el vendedor no tiene email o es incorrecto');
	$para = array($factura->cliente->vendedor->email);
	($factura->empresa == 1) && $para[] = $factura->cliente->email;
	//Le tengo que mandar el PDF adjunto!
	$pdfPath = $factura->crear();
	$cuerpo = 'Se adjunta el comprobante electr�nico correspondiente a la factura N� ' . $factura->numeroComprobante . '. Muchas gracias. ';
	Email::enviar(
		 array(
			 'para' => $para,
			 'asunto' => $asunto,
			 'contenido' => $cuerpo,
			 'adjuntos' => array($pdfPath)
		 )
	);

	//Guardo en la base que ya se envi� el mail
	$factura->mailEnviado = 'S';
	Factory::getInstance()->persistir($factura);

	$arr['puntoDeVenta'] = $factura->puntoDeVenta;
	$arr['nro'] = $factura->numero;
	$arr['nroComprobante'] = $factura->numeroComprobante;
	$arr['letra'] = $factura->letra;
	Html::jsonSuccess('', $arr);
} catch (FactoryExceptionRegistroNoExistente $ex) {
	Html::jsonError('La factura que intent� enviar por mail no existe');
} catch (FactoryExceptionCustomException $ex) {
	Html::jsonError($ex->getMessage());
} catch (Exception $ex){
	Html::jsonError('Ocurri� un error al intentar enviar la factura por mail');
}

?>
<?php } ?>