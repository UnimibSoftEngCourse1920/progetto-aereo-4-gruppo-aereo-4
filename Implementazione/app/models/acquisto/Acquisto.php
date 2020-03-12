<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";
require_once("../app/models/acquisto/pagamento/PagamentoConPunti.php");
require_once("../app/models/acquisto/pagamento/PagamentoConCarta.php");

abstract class MetodoPagamento
{
    const PUNTI = "punti";
    const CARTA = "carta";
}

class Acquisto{

    private $puntiAccumulati;
    private $OID;
    private $pagamento;

	public function __construct() {
		$this->OID = OIDGenerator::getIstance()->getNewOID();
	}
	
	
	public function effettuaPagamento($metodoPagamento, $cliente, $importo, $carta) {
        $esitoPagamento = false;
		if($metodoPagamento == MetodoPagamento::PUNTI && $cliente->getCodiceFedelta()) {
			$this->pagamento = new PagamentoConPunti($importo);
            $esitoPagamento =  $this->pagamento->effettua($cliente);
		} else if ($metodoPagamento == MetodoPagamento::CARTA && $carta != "") {
			$this->pagamento = new PagamentoConCarta($importo);
            $esitoPagamento =  $this->pagamento->effettua($carta);
		}
        if($esitoPagamento && $cliente->getCodiceFedelta()) {
            $this->puntiAccumulati = $this->calcolaPuntiAccumulati($importo);
            $cliente->aggiungiPunti($this->puntiAccumulati);
            $cliente->setStato(Cliente::$STATO_FEDELE);
        }
		return $esitoPagamento;
	}

	private function calcolaPuntiAccumulati($importo){
        return $importo/10;
    }
	
	private function costoToPunti($importo) {
		//TODO: Stabilire come effettuare la conversione
		return $importo * 100;
	}

    public function getPuntiAccumulati()
    {
        return $this->puntiAccumulati;
    }

    public function getOID()
    {
        return $this->OID;
    }

    public function getPagamento()
    {
        //Pagamento non ha la materializzazione pigra
        /*
         * Ci sono tre possibili strade da seguire:
         * 1) Non c'è la materializzazione pigra del pagamento
         * 2) getPagamento chiede al DB a quale pagamento appartiene quell'OID
         * 3) getPagamento ha il campo metodoPagamento
         *
         * Ad oggi (09/03) è stata scelta la soluzione 1)
         * */
        return $this->pagamento;
    }

    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
    }




	
} 
