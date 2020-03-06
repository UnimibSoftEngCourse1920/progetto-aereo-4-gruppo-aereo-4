<?php


abstract class MetodoPagamento
{
    const Punti = "punti";
    const Carta = "carta";
}

class Acquisto{

    //mettere importo qui??

    private $puntiAccumulati;
    private $OID;
    private $pagamento;
	
	public function __construct($metodoPagamento, $importo) {
		$this->OID = OIDGenerator::getIstance()->getNewOID();
	}
	
	
	public function effettuaPagamento($metodoPagamento, $cliente, $carta) {
		$metodoPagamento = $this->getMetodoPagamento();
		if($metodoPagamento == MetodoPagamento::Punti && $cliente->getCodiceFedelta()) {
			$punti = $this->costoToPunti($this->getImporto());
			$this->pagamento = new PagamentoConPunti($punti);
		} else if ($metodoPagamento == MetodoPagamento::Carta && $carta != "") {
			$importo = $this->getImporto();
			$this->pagamento = new PagamentoConCarta($importo, $carta);
		}
		$esitoPagamento =  $this->pagamento->effettua($cliente);
		return $esitoPagamento;
	}

	private function calcolaPuntiAccumulati(){
	    //TODO: fare il metodo per il calcolo controllando se il cliente passato è fedelta
    }
	
	private function costoToPunti($importo) {
		//TODO: Stabilire come effettuare la conversione
		return $importo * 100;
	}
	
} 
