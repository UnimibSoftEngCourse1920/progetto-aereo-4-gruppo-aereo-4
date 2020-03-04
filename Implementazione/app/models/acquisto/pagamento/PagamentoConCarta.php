<?php


namespace model\acquisto\pagamento;


class PagamentoConCarta extends Pagamento{
	
	private $carta;
	
	public function __construct($importo, $carta) {
	    parent::__construct($importo);
	    $this->carta = $carta;
	}

	public function setCarta($carta) {
		//TODO: Vedere come arriva la carta
		$this->carta = $carta;
	}	
    
	public function effettua($cliente) {
		$istituto = new IstitutoDiCredito();
		$esitoPagamento = $istituto->autorizzaPagamento($this->carta);
		return $esitoPagamento;
	}

	//Secondo me la carta arriva direttamente dalla chiamata effettua
	
} 