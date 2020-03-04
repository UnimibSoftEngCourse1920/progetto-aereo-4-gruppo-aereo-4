<?php

namespace model\acquisto;

use model\servizi\OIDGenerator;

abstract class MetodoPagamento
{
    const Punti = "punti";
    const Carta = "carta";
}

class Acquisto{

    //mettere importo qui??

    private $puntiAccumulati;
    private $OID;
	
	public function __construct($metodoPagamento, $importo) {
		$this->OID = OIDGenerator::getIstance()->getNewOID();
	}
	
	
	public function effettuaPagamento($metodoPagamento, $cliente, $carta) {
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