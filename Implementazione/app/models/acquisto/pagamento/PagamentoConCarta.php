<?php

require_once __DIR__ . "/Pagamento.php";

class PagamentoConCarta extends Pagamento{

    private $istituto;

	public function __construct($importo) {
	    parent::__construct($importo);
	}
    
	public function effettua($carta) {
		$this->istituto = new IstitutoDiCredito("Banca Bicocca");
		$esitoPagamento = $this->istituto->autorizzaPagamento($this->carta);
		return $esitoPagamento;
	}

	//Secondo me la carta arriva direttamente dalla chiamata effettua
	
} 