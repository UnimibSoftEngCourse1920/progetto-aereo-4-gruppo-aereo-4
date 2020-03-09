<?php

require_once __DIR__ . "/Pagamento.php";

class PagamentoconPunti extends Pagamento{

    //TODO rinominare variabile
    private $puntiUtilizzati;
	
	public function __construct($importo) {
	    parent::__construct($importo);
	    $this->importoToPunti();
	}

	private function importoToPunti(){
	    $this->puntiUtilizzati = ($this->importo * 20);
    }
	
	public function effettua($cliente) {
		if($this->puntiUtilizzati <= $cliente->getPunti()) {
			$esitoPagamento = $cliente->sottraiPunti($this->puntiUtilizzati);
		} else {
			$esitoPagamento = false;
		}
		return $esitoPagamento;
	}
	
}
