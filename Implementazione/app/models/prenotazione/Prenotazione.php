<?php


require_once("../app/models/volo/Biglietto.php");
require_once("../app/models/acquisto/Acquisto.php");
require_once($_SERVER['DOCUMENT_ROOT']."/app/models/cliente/EstrattoConto.php");
require_once($_SERVER['DOCUMENT_ROOT']."/app/models/acquisto/pagamento/PagamentoConPunti.php");
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";


class Prenotazione{

    private $data;
    private $OID;
    private $cliente;
    private $volo;

    private $listaPasseggeri;
    private $listaPosti;
    private $listaBiglietti;
    private $listaAcquisti;

    public function __construct($cliente,$listaPasseggeri, $volo,$numPosti,$tariffa){
        $this->OID = OIDGenerator::getIstance() -> getNewOID();
        $this->cliente = $cliente;
        $this->volo = $volo;
        $this->listaPosti = $this->volo->prenota($numPosti);
        $prezzo = $this->volo->calcolaPrezzo($this->cliente->isFedelta());
        $this->listaBiglietti = $this->generaBiglietti($prezzo,$tariffa,$listaPasseggeri);
        $this->listaAcquisti = array();
        $this->data = date("Y-m-d");
    }

    public function generaEstrattoContoParziale(EstrattoConto $estrattoConto){
        //TODO  faccio addRigaAcquisto e Pagamento cosi da togliere la require??
        foreach ($this->listaAcquisti as $acquisto){
            $punti = $acquisto->getPuntiAccumulati();
            if($punti>0){
                $estrattoConto->addRiga($this->volo, EstrattoConto::$ACQUISTO, $punti);
            }
            $pag = $acquisto->getPagamento();
            if(get_class($pag) == PagamentoConPunti::class){
                $punti = $pag->getPuntiUtilizzati();
                if($punti>0){
                    $estrattoConto->addRiga($this->volo, EstrattoConto::$PAGAMENTO, -$punti); //gli passo -punti
                }
            }
        }
        //non c'è nessuna return perchè lavora direttamente sull'obj
    }

    private function generaBiglietti($prezzo,$tariffa,$listaPasseggeri){
        $lista = array();
        $i = 0;
        foreach ($this->listaPosti as $posto){
            $b = new Biglietto($posto->numeroPosto,$tariffa,$listaPasseggeri[$i],$prezzo);
            DBFacade::getIstance()->put($b);
            array_push($lista,$b);
            $i++;
        }
        return $lista;
    }

    public function getImporto(){
        $importo = 0;
        foreach ($this->getListaBiglietti() as $biglietto){
            if($biglietto->getTariffa()=="Plus") {
                $importo += ($biglietto->getPrezzo() + 20);
            } else {
                $importo += $biglietto->getPrezzo();
            }
        }
        return $importo;
    }

	public function cambiaData($metodoPagamento, $cliente, $nuovoVolo, $tassa, $carta) {
		$nPosti = $this->getNumeroPosti();
		if($nPosti <= $nuovoVolo->getNumeroPostiDisponibili()) {
			$esitoPagamentoTassa = $this->acquista($metodoPagamento, $cliente, $tassa, $carta);
			if($esitoPagamentoTassa) {
				$nuoviPosti = $nuovoVolo->occupaPosti($nPosti, $this->getCodice());
				$volo = $this->getVolo();
				$volo->liberaPosti($this->getListaPosti());
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
		$acquisto = new Acquisto();
		$esitoPagamento = $acquisto->effettuaPagamento($metodoPagamento, $cliente, $importo, $carta);
        $this->getListaAcquisti();
		array_push($this->listaAcquisti, $acquisto);
		return $esitoPagamento;
	}
	
	//TODO: Prevedere logica di recupero per i get su volo, acquisto e posti?

	public function setVolo($volo) {
		$this->volo = $volo;
	}

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    public function setListaPosti($listaPosti)
    {
        $this->listaPosti = $listaPosti;
    }

    public function setListaBiglietti($listaBiglietti)
    {
        $this->listaBiglietti = $listaBiglietti;
    }

    public function setListaAcquisti($listaAcquisti)
    {
        $this->listaAcquisti = $listaAcquisti;
    }

	public function getOID() {
		return $this->OID;
	}
	
	public function getNumeroPosti() {
		//TODO a cosa serve
	}

    public function getData()
    {
        return $this->data;
    }

    public function getVolo() {
        if(is_string($this->volo)){
            $this->volo = DBFacade::getIstance() ->get($this->volo, Volo::class);
        }
        return $this->volo;
    }

    public function getCliente()
    {
        //TODO:: se divido il cliente va aggiornata anche questa get!!
        if(is_string($this->cliente)){
            $this->cliente = DBFacade::getIstance() ->get($this->cliente, Cliente::class);
        }
        return $this->cliente;
    }

    //TODO rivedere il metodo materializaAll

    public function getListaPosti()
    {
        if(is_string($this->listaPosti[0])){
            $this->listaPosti = $this->materializeAll($this->listaPosti, Posto::class);
        }
        return $this->listaPosti;
    }

    public function getListaBiglietti()
    {
        if(is_string($this->listaBiglietti[0])){
            $this->listaBiglietti = $this->materializeAll($this->listaBiglietti, Biglietto::class);
        }
        return $this->listaBiglietti;
    }

    public function getListaAcquisti()
    {
        if(is_string($this->listaAcquisti[0])){
            $this->listaAcquisti = $this->materializeAll($this->listaAcquisti, Acquisto::class);
        }
        return $this->listaAcquisti;
    }

    private function materializeAll($lista, $class){
        $listaRitorno = array();
        for($i=0; $i< count($lista); $i++){
            $listaRitorno[$i] = DBFacade::getIstance()->get($lista[$i], $class);
        }
        return $listaRitorno;
    }

}