<?php

/**
 * @property Socio							$socio
 * @property AsientoContable				$asientoContable
 * @property FormularioOperacionSocio		$formulario
 */

class AporteSocio extends TransferenciaBase implements DocumentoContable {
	protected	$_entradaSalida = 'E';

	public		$idSocio;
	protected	$_socio;
	public		$concepto;
	public		$fecha;
	public		$idAsientoContable;
	protected	$_asientoContable;
	public		$formulario;

	protected function validarNuevo() {
		$idSocio = $this->datosSinValidar['idSocio'];
		$concepto = $this->datosSinValidar['concepto'];
		$caja = $this->datosSinValidar['idCaja_E'];
		try {
			$this->socio = Factory::getInstance()->getSocio($idSocio);
		} catch (Exception $ex) {
			throw new FactoryExceptionCustomException('Debe completar el campo de socio');
		}
		if (empty($concepto) || empty($caja)) {
			throw new FactoryExceptionCustomException('Debe completar todos los campos obligatorios');
		}
		$this->concepto = $this->datosSinValidar['concepto'];
		$this->fecha = $this->datosSinValidar['fechaDocumento'];

		parent::validarNuevo();

		$this->validarSiHayChequesConcluidos();
	}

	protected function beforeSave() {
		$t = 0;
		foreach($this->importesSinValidar[$this->getEntradaSalida()] as $imps) {
			foreach($imps as $imp) {
				/* @var $imp Importe */
				$t += $imp->importe;
			}
		}
		$this->importeTotal = $t;
	}

	public function getCodigoPermiso(){
		return PermisosUsuarioPorCaja::aporteSocio;
	}

	public function getTipoTransferenciaBase(){
		return TiposTransferenciaBase::aporteSocio;
	}

	public function calcularNuevoImporteCaja($importeViejo, $importe, $delete = false) {
		return $importeViejo + ($delete ? -1 : 1) * $importe;
	}

	public function validarCantidadPermitidaEfectivo($cantidad) {
		if ($cantidad > 1) {
			throw new FactoryExceptionCustomException('S�lo se puede ingresar un importe de tipo efectivo');
		}
		return true;
	}

	public function validarCantidadPermitidaCheque($cantidad){
		return true;
	}

	public function validarCantidadPermitidaTransferenciaBancaria($cantidad){
		return true;
	}

	public function validarCantidadPermitidaRetencionEfectuada($cantidad) {
		return false;
	}

	public function validarCantidadPermitidaRetencionSufrida($cantidad) {
		return false;
	}

	public function getTextoDe($conTipo = false) {
		return ($conTipo ? 'Socio: ' : '') . $this->socio->getIdNombre();
	}

	//formulario
	public function abrir() {
		$this->crearFormulario();
		$this->llenarFormulario();
		$this->formulario->abrir();
	}

	protected function crearFormulario() {
		$this->formulario = new FormularioOperacionSocio();
	}

	protected function llenarFormulario() {
		$cheques = $this->getCheques();
		$transferencias = $this->getTransferencias();
		$totalCheques = 0;
		$totalTransferencias = 0;

		foreach($cheques as $cheque)
			$totalCheques += $cheque->importe;

		foreach($transferencias as $transferencia)
			$totalTransferencias += $transferencia->importe;

		$this->formulario->id = $this->numero;
		$this->formulario->fecha = $this->fechaAlta;
		$this->formulario->socio = $this->socio->nombre;
		$this->formulario->concepto = $this->concepto;
		$this->formulario->cheques = $cheques;
		$this->formulario->montoEfectivo = $this->getEfectivo();
		$this->formulario->montoCheques = $totalCheques;
		$this->formulario->montoTransferencias = $totalTransferencias;
		$this->formulario->montoTotal = $this->importeTotal;
		$this->formulario->empresa = $this->empresa;
		$this->formulario->tipoOperacion = $this->entradaSalida;
	}

	protected function beforeCommit() {
		parent::beforeCommit();

		$this->idAsientoContable = null;
		$asiento = $this->contabilidad();
		$this->asientoContable = $asiento;
		$this->update();
	}

	protected function beforeDelete(){
		Contabilidad::descontabilizarDocumento($this);
	}

	/************************************** CONTABILIDAD **************************************/

	public function contabilidad() {
		return Contabilidad::contabilizarDocumento($this);
	}

	public function contabilidadEmpresa() {
		return $this->empresa;
	}

	public function contabilidadNombre() {
		$nombre = 'Aporte de socio (' . $this->socio->nombre . ')';
		return $nombre;
	}

	public function contabilidadFecha() {
		$fecha = ($this->fecha ? $this->fecha : Funciones::hoy());
		return $fecha;
	}

	public function contabilidadDetalle() {
		$fecha = $this->contabilidadFecha();
		$det = array();

		/* AGREGO LAS FILAS DE LOS IMPORTES */
		$importeTotal = 0;
		$i = 1;
		foreach ($this->importePorOperacion->detalle as $ixod) {
			$fila = array();
			/** @var ImportePorOperacionItem $ixod */
			$importe = $ixod->importe;
			$fila['numeroFila'] = $i;
			/** @var Cheque $importe */ //PUEDE NO SER UN CHEQUE, pero lo pongo as� para que me tome ->fechaVencimiento
			$fila['fechaVencimiento'] = ($importe->getTipoImporte() == TiposImporte::cheque) ? $importe->fechaVencimiento : $fecha;
			$fila['imputacion'] = $importe->getImputacion();
			$fila['importeDebe'] = Funciones::toFloat($ixod->importe->importe, 2);
			$fila['importeHaber'] = 0;
			$fila['observaciones'] = $importe->getObservacionContabilidad();
			$det[] = $fila;
			$importeTotal += $fila['importeDebe'];
			$i++;
		}

		/* AGREGO LA FILA DEL HABER */
		$fila = array();
		$fila['numeroFila'] = $i;
		$fila['fechaVencimiento'] = $fecha;
		$fila['imputacion'] = $this->getImputacionHaber();
		$fila['importeDebe'] = 0;
		$fila['importeHaber'] = $importeTotal;
		$fila['observaciones'] = $this->observaciones;
		$det[] = $fila;

		return $det;
	}

	public function contabilidadIdAsientoContable() {
		return $this->idAsientoContable;
	}

	/************************************** ************ **************************************/

	public function getImputacionHaber() {
		$return = Factory::getInstance()->getParametroContabilidad(ParametrosContabilidad::cuentaParticular)->idImputacion;
		return $return;
	}

	//GETS y SETS
	protected function getAsientoContable() {
		if (!isset($this->_asientoContable)){
			$this->_asientoContable = Factory::getInstance()->getAsientoContable($this->idAsientoContable);
		}
		return $this->_asientoContable;
	}
	protected function setAsientoContable($asientoContable) {
		$this->_asientoContable = $asientoContable;
		return $this;
	}
	protected function getSocio() {
		if (!isset($this->_socio)){
			$this->_socio = Factory::getInstance()->getSocio($this->idSocio);
		}
		return $this->_socio;
	}
	protected function setSocio($socio) {
		$this->_socio = $socio;
		return $this;
	}
}

?>