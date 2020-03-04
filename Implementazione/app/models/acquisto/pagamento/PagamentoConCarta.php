<?php


namespace model\acquisto\pagamento;


class PagamentoConCarta extends Pagamento{
	
	private $carta;
	
	public function __construct($importo, $carta) {
		$this->setImporto($importo);
		$this->setCarta($carta);
	}
	
	public function setImporto($importo) {
		$this->importo = $importo;
	}
	
	public function setCarta($carta) {
		//TODO: Vedere come arriva la carta
		$this->carta = $carta;
	}	
    
	public function effettua($cliente) {
		$carta = $this->getCarta();
		$istituto = new IstitutoDiCredito();
		$esitoPagamento = $istituto->autorizzaPagamento($carta);
		return $esitoPagamento;
	}
	
} 