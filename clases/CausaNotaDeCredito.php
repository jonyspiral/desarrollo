<?php

class CausaNotaDeCredito extends Base {
	const		_primaryKey = '["id"]';

	public		$id;
	public		$nombre;

	public function __construct() {
		parent::__construct();
	}

	//GETS y SETS
}

?>