<?php

require_once __DIR__ . "/Pagamento.php";

class PagamentoConCarta extends Pagamento{
	
	public function __construct($importo) {
	    parent::__construct($importo);
	}
    
	public function effettua($carta) {
		$istituto = new IstitutoDiCredito();
		$esitoPagamento = $istituto->autorizzaPagamento($this->carta);
		return $esitoPagamento;
	}

	//Secondo me la carta arriva direttamente dalla chiamata effettua
	
} 