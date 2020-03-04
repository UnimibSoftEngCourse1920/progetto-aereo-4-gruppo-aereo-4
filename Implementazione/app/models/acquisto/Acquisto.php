<?php

abstract class MetodoPagamento
{
    const Punti = "punti";
    const Carta = "carta";
}

class Acquisto{
	
    private $puntiAccumulati;
    private $codiceAcquisto;
	
	public function __construct($metodoPagamento, $importo) {
		
	}
	
	
	public function effettuaPagamento($cliente, $carta) {
		$metodoPagamento = $this->getMetodoPagamento();
		if($metodoPagamento == MetodoPagamento::Punti && $cliente->getCodiceFedelta()) {
			$punti = $this->costoToPunti($this->getImporto());
			$pagamento = new PagamentoConPunti($punti);			
		} else if ($metodoPagamento == MetodoPagamento::Carta && $carta != "") {
			$importo = $this->getImporto();
			$pagamento = new PagamentoConCarta($importo, $carta);
		}
		$esitoPagamento =  $pagamento->effettua($cliente);
		return $esitoPagamento;
	}
	
	private function costoToPunti($importo) {
		//TODO: Stabilire come effettuare la conversione
		return $importo * 100;
	}
	
} 