<?php

require_once "../app/models/servizi/DB.php";

class Volo {
    private $OID;
    private $dataOraPartenza;
    private $dataOraArrivo;
    private $stato;
    private $codiceVolo;
    private $miglia;

    private $aereoportoPart;
    private $aereoportoDest;
    private $aereo;
    private $promozione;

    private $listaPosti; //posti del volo

    public function __construct($dataOraPartenza, $dataOraArrivo, $AereoportoPart, $AereoportArr, $Aereo){
        //$database = DBFacade::getIstance();
        //$this->OID = OIDGenerator::getIstance()->getNewOID();
        //$this->OID = $data; //Per test
        $this->dataOraPartenza = $dataOraPartenza;
        $this->dataOraArrivo = $dataOraArrivo;
        //$this->miglia = $this->calcolaMiglia();
        $this->stato = 'ATTIVO';
        //codice volo??
        //$this->aereoportoPart = $database->get($AereoportoPart);
        //$this->aereoportoDest = $database->get($AereoportArr);
        //$this->aereo = $database->get($Aereo);
        $this->promozione = null;
        $this->listaPosti = array();

        /*for($i=0; $i<$this->aereo->getPostiDisponibili(); $i++){
            $p = new Posto($i+1);
            $this->listaPosti[] = $p;
        }*/
    }

    public function setDataOraPartenza($dataOraPartenza){
        $this->dataOraPartenza = $dataOraPartenza;
    }

    public function setDataOraArrivo($dataOraArrivo){
        $this->dataOraArrivo = $dataOraArrivo;
    }

    public function setStato($stato){
        $this->stato = $stato;
    }

    public function getDataOraPartenza(){
        return $this->dataOraPartenza;
    }

    public function getDataOraArrivo(){
        return $this->dataOraArrivo;
    }

    public function getAeroportoPartenza(){
        return $this->aereoportoPart;
    }

    public function getAeroportoDestinazione(){
        return $this->aereoportoDest;
    }

    public function getOID() {
        return $this->OID;
    }

    public function getDisponibilitaPosti($numPosti){
        $contaLiberi=0;
        $posti = $this->listaPosti;
        foreach ($posti as $posto){
            if($posto->isOccupato()==0)
                $contaLiberi++;
        }

        if($numPosti<=$contaLiberi)
            return true;
        else
            return false;
    }

    private function calcolaMiglia(){
        if($this->aereoportoPart.getNazione() == $this->aereoportoDest.getNazione()){
            return rand(200,600);
        }
        else if($this->aereoportoPart.getContinente() == $this.$this->aereoportoDest.getContinente()){
            return rand(300,1500);
        }
        else{
            return rand(1200,6000);
        }
    }

    public function getPrezzoBiglietto(){
        return $this->miglia/10;
    }

    public function prenota($numPosti){
        $postiRimanenti = $numPosti;
        $listaPostiPrenotati = array();
        foreach ($this->listaPosti as $posto){ //per ogni posto del volo
            if($postiRimanenti>0) { //controllo che ci siano ancora posti da prenotare
                if ($posto->isOccupato() == 0) { //se non è occupato
                    $posto->cambiaStato(); //lo occupo
                    array_push($listaPostiPrenotati,$posto); //lo aggiungo alla lista dei posti prenotati
                    DBFacade::getIstance()->update($posto); //aggiorno anche sul DB
                    $postiRimanenti--; // diminuisco i posti da prenotare
                }
            }

        }
        return $listaPostiPrenotati;
    }

    public function calcolaPrezzo($isFedelta){
        $prezzo = $this->miglia/10;
        if((isset($this->promozione))) { //se esiste una promozione per questo volo
            //se è per fedeltà e cliente è fedeltà o non è per fedeltà
            if (($this->promozione->promozioneFedelta && $isFedelta) || !$this->promozione->promozioneFedelta){
                $sconto = $this->promozione->percentualeSconto;
                $prezzo = $prezzo - (($prezzo*$sconto)/100);
            } else {
                $registroPromozioni = new RegistroPromozioni();
                $migliorPromozione = $registroPromozioni->getMigliorePromozioneAttiva();
                if (($migliorPromozione->promozioneFedelta && $isFedelta) || !$migliorPromozione->promozioneFedelta) {
                    $prezzo = $prezzo - (($prezzo * $migliorPromozione->percentualeSconto) / 100);
                }
            }
        }
        return $prezzo;
    }

}