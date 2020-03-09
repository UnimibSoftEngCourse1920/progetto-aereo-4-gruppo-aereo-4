<?php


require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";


abstract class MetodoPagamento
{
    const PUNTI = "punti";
    const CARTA = "carta";
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
		if($metodoPagamento == MetodoPagamento::PUNTI && $cliente->getCodiceFedelta()) {
			$punti = $this->costoToPunti($this->getImporto());
			$this->pagamento = new PagamentoConPunti($punti);
		} else if ($metodoPagamento == MetodoPagamento::CARTA && $carta != "") {
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
