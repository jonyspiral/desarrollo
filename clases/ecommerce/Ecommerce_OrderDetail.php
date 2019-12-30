<?php

/**
 * @property Ecommerce_Order		$order
 * @property Usuario				$usuario
 * @property Usuario				$usuarioBaja
 * @property Usuario				$usuarioUltimaMod
 */
class Ecommerce_OrderDetail extends Base {
	const		_primaryKey = '["id"]';

	public		$id;
	public		$idOrder;
	protected	$_order;
	public		$reference;
	public		$description;
	public		$size;
	public		$quantity;
	public		$price;
	public		$subtotal;
	public		$anulado;
	public		$idUsuario;
	protected	$_usuario;
	public		$idUsuarioBaja;
	protected	$_usuarioBaja;
	public		$idUsuarioUltimaMod;
	protected	$_usuarioUltimaMod;
	public		$fechaAlta;
	public		$fechaBaja;
	public		$fechaUltimaMod;

	//GETS y SETS
	protected function getOrder() {
		if (!isset($this->_order)){
			$this->_order = Factory::getInstance()->getEcommerce_Order($this->idOrder);
		}
		return $this->_order;
	}
	protected function setOrder($order) {
		$this->_order = $order;
		return $this;
	}
}

?>