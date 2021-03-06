<?php


require_once("../app/models/volo/Biglietto.php");
require_once("../app/models/acquisto/Acquisto.php");
require_once("../app/models/acquisto/pagamento/PagamentoConPunti.php");
require_once "../app/models/servizi/OIDGenerator.php";


class Prenotazione{

    private $data;
    private $OID;
    private $cliente;
    private $volo;
    private $listaPosti;
    private $listaBiglietti;
    private $listaAcquisti;

    public function __construct($cliente, $listaPasseggeri, $volo, $numPosti, $tariffa)
    {
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->cliente = $cliente;
        $this->volo = $volo;
        $this->listaPosti = $this->volo->prenota($numPosti);
        $prezzo = $this->volo->getPrezzoScontato($this->cliente->isFedelta());
        $this->listaBiglietti = $this->generaBiglietti($prezzo, $tariffa, $listaPasseggeri);
        $this->listaAcquisti = array();
        $this->data = date("Y-m-d");
    }

    public function generaEstrattoContoParziale($estrattoConto)
    {
        foreach ($this->getListaAcquisti() as $acquisto) {
            $punti = $acquisto->getPuntiAccumulati();
            if ($punti > 0) {
                $estrattoConto->addRiga($this->getVolo(), $estrattoConto::$ACQUISTO, $punti);
            }
            $pag = $acquisto->getPagamento();
            if (get_class($pag) == PagamentoConPunti::class) {
                $punti = $pag->getPuntiUtilizzati();
                if ($punti > 0) {
                    $estrattoConto->addRiga($this->volo, $estrattoConto::$PAGAMENTO, -$punti); //gli passo -punti
                }
            }
        }
        //non c'è nessuna return perchè lavora direttamente sull'obj
    }

    private function generaBiglietti($prezzo, $tariffa, $listaPasseggeri)
    {
        $lista = array();
        $i = 0;
        foreach ($this->listaPosti as $posto) {
            $b = new Biglietto($posto->getNumeroPosto(), $tariffa, $listaPasseggeri[$i], $prezzo);
            DBFacade::getIstance()->put($b);
            array_push($lista, $b);
            $i++;
        }
        return $lista;
    }


    public function getImporto()
    {
        $importo = 0;
        $plus = false;
        foreach ($this->getListaBiglietti() as $biglietto) {
            if (strtolower($biglietto->getTariffa()) == "plus") {
                $plus = true;
            }
            $importo += $biglietto->getPrezzo();
        }
        if($plus) {
            $importo += 20;
        }
        return $importo;
    }

	public function cambiaData($metodoPagamento, $cliente, $nuovoVolo, $tassa, $nuovaTariffa, $carta) {
		$nPosti = count($this->listaPosti);
		if($nuovoVolo->getDisponibilitaPosti($nPosti)) {
		    if($tassa != 0) {
                $esitoPagamentoTassa = $this->acquista($metodoPagamento, $cliente, $tassa, $carta);
            } else {
		        $esitoPagamentoTassa = true;
            }
			if($esitoPagamentoTassa) {
				$nuoviPosti = $nuovoVolo->prenota($nPosti);
				$vecchioVolo = $this->getVolo();
                $vecchioVolo->libera($this->getListaPosti());
				$this->setVolo($nuovoVolo);
				$this->setListaPosti($nuoviPosti);
				$biglietti = $this->getListaBiglietti();
				for($i = 0; $i < $nPosti; $i++) {
					$biglietti[$i]->setPosto($nuoviPosti[$i]->getNumeroPosto()); //Numero che è diverso da OID
                    $biglietti[$i]->setTariffa($nuovaTariffa);
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
        $this->listaAcquisti = $this->getListaAcquisti(); //Per fare la materializzazione degli obj
		array_push($this->listaAcquisti, $acquisto);
		return $esitoPagamento;
	}

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

    public function getOID()
    {
        return $this->OID;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getVolo()
    {
        if (is_string($this->volo)) {
            $this->volo = DBFacade::getIstance()->get($this->volo, Volo::class);
        }
        return $this->volo;
    }

    public function getCliente()
    {
        if (is_string($this->cliente)) {
            $this->cliente = DBFacade::getIstance()->get($this->cliente, Cliente::class);
        }
        return $this->cliente;
    }

    public function getListaPosti()
    {
        if (count($this->listaPosti)>0 && is_string($this->listaPosti[0])) {
            $this->listaPosti = $this->materializeAll($this->listaPosti, Posto::class);
        }
        return $this->listaPosti;
    }

    public function getListaBiglietti()
    {
        if (count($this->listaBiglietti)>0 && is_string($this->listaBiglietti[0])) {
            $this->listaBiglietti = $this->materializeAll($this->listaBiglietti, Biglietto::class);
        }
        return $this->listaBiglietti;
    }

    public function getListaAcquisti()
    {

        if (count($this->listaAcquisti)>0 && is_string($this->listaAcquisti[0])) {
            $this->listaAcquisti = $this->materializeAll($this->listaAcquisti, Acquisto::class);
        }
        return $this->listaAcquisti;
    }

    private function materializeAll($lista, $class)
    {
        $listaRitorno = array();
        for ($i = 0; $i < count($lista); $i++) {
            $listaRitorno[$i] = DBFacade::getIstance()->get($lista[$i], $class);
        }
        return $listaRitorno;
    }

    public function liberaPostiOccupati()
    {
        //Utilizzo le get per materializzazione
        $this->getVolo()->libera($this->getListaPosti());
    }
}