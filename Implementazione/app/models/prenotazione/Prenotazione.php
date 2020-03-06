<?php

class Prenotazione{
    private $data;
    private $OID;
    private $tariffa; //TODO: inserire nei vari diagrammi

    private $cliente;
    private $volo;

    private $listaPosti;
    private $listaBiglietti;
    private $listaAcquisti;

    public function __construct($cliente,$volo,$numPosti,$tariffa,$data){
        $this->data=$data; //TODO: da rimuovere dai parametri
        $this->tariffa=$tariffa;
        $this->cliente = $cliente;
        $this->volo = $volo;
        $this->listaPosti = $this->volo->prenota($numPosti);
        $prezzo = $this->volo->calcolaPrezzo($this->cliente->isFedelta());
        $this->listaBiglietti = $this->generaBiglietti($prezzo);
        $this->listaAcquisti = array();
    }

    public function generaEstrattoContoParziale(){

    }

    public function registraPrenotazione(){
        $this->OID = DBFacade::getIstance()->salvaPrenotazione($this);
    }

    //getClienteCode() !!

    public function __get($attributo) {
        if (property_exists($this, $attributo)) {
            return $this->$attributo;
        }
    }

    public function __set($attributo, $valore) {
        if (property_exists($this, $attributo)) {
            $this->$attributo = $valore;
        }
        return $this;
    }

    public function generaBiglietti($prezzo){
        $lista = array();
        foreach ($this->listaPosti as $posto){
            $b = new Biglietto($posto->numeroPosto,$this->tariffa,$this->cliente->getEmail());
            array_push($lista,$b);
        }
        return $lista;
    }
	
	public function cambiaData($metodoPagamento, $cliente, $nuovoVolo, $tassa, $carta) {
		$nPosti = $this->getNumeroPosti();
		if($nPosti <= $nuovoVolo->getNumeroPostiDisponibili()) {
			$esitoPagamentoTassa = $this->acquista($metodoPagamento, $cliente, $tassa, $carta);
			if($esitoPagamentoTassa) {
				$nuoviPosti = $nuovoVolo->occupaPosti($nPosti, $this->getCodice());
				$volo = $this->getVolo();
				$volo->liberaPosti($this->getPosti());
				$this->setVolo($nuovoVolo);		
				$biglietti = $this->getBiglietti();
				for($i = 0; $i < $nPosti; $i++) {
					$biglietti[$i]->setPosto($nuoviPosti[$i]->getNumero()); //Numero che è diverso da OID
				}
			}
			$esitoCambioData = $esitoPagamentoTassa;
		} else {
			$esitoCambioData = false;
		}
		return $esitoCambioData;
	}
	
	public function acquista($metodoPagamento, $cliente, $importo, $carta) {
		$acquisto = new Acquisto($metodoPagamento, $importo);		
		$esitoPagamento = $acquisto->effettuaPagamento($cliente, $carta);
		array_push($this->acquisti, $acquisto);
		return $esitoPagamento;
	}
	
	//TODO: Prevedere logica di recupero per i get su volo, acquisto e posti?
	
	public function getVolo() {
		return $this->volo;
	}	
	
	public function setVolo($volo) {
		$this->volo = $volo;
	}
	
	public function getAcquisto() {
		return $this->acquisto;
	}
	
	public function getPosti() {
		return $this->posti;
	}
	
	public function getCodice() {
		return $this->codicePrenotazione;
	}
	
	public function getNumeroPosti() {
		
	}
	
}