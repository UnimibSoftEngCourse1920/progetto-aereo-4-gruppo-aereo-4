<?php

require_once __DIR__ . "/Pagamento.php";

class PagamentoconPunti extends Pagamento{
	
    private $puntiUtilizzati;
	
	public function __construct($importo) {
		$this->setImporto($importo);
	}
	
	public function setImporto($importo) {
		$this->importo = $importo;
	}
	
	
	public function effettua($cliente) {
		$punti = $this->getPunti();
		if($punti <= $cliente->getPunti()) {
			$esitoPagamento = $cliente->sottraiPunti($punti);			
		} else {
			$esitoPagamento = false;
		}
		return $esitoPagamento;
	}
	
}
