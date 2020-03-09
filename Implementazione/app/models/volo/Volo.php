<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/DBFacade.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Posto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Aeroporto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";


class Volo {
    private $OID;
    private $dataOraPartenza;
    private $dataOraArrivo;
    private $stato;
    private $miglia;
    private $aereo;

    private $aeroportoPart;
    private $aeroportoDest;
    private $promozione; //TODO: vedere se ora è diventato 1:1

    private $listaPosti; //posti del volo

    public function __construct($dataOraPartenza, $dataOraArrivo, $AeroportoPart, $AeroportArr, $Aereo){
        $database = DBFacade::getIstance();
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->dataOraPartenza = $dataOraPartenza;
        $this->dataOraArrivo = $dataOraArrivo;
        $this->aeroportoPart = $database->get($AeroportoPart->getOID(),"Aeroporto");
        $this->aeroportoDest = $database->get($AeroportArr->getOID(),"Aeroporto");
        $this->miglia = $this->calcolaMiglia();
        $this->stato = 'ATTIVO';
        $this->aereo = $database->get($Aereo->getOID(),"Aereo");
        $this->promozione = null;
        $this->listaPosti = array();

        for($i=0; $i<$this->aereo->getNumeroPosti(); $i++){
            $p = new Posto($i+1);
            $this->listaPosti[] = $p;
        }
    }


    public function setAeroportoDest($aeroportoDest)
    {
        $this->aeroportoDest = $aeroportoDest;
    }

    public function setAeroportoPart($aeroportoPart)
    {
        $this->aeroportoPart = $aeroportoPart;
    }

    public function setPosti($listaPosti){
        $this->listaPosti = $listaPosti;
    }

    public function setDataOraPartenza($dataOraPartenza){
        $this->dataOraPartenza = $dataOraPartenza;
    }

    public function setDataOraArrivo($dataOraArrivo){
        $this->dataOraArrivo = $dataOraArrivo;
    }

    public function setPromozione($promozione){
        $this->promozione = $promozione;
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

    public function getPromozione(){
        return $this->promozione;
    }

    public function getMiglia(){
        return $this->miglia;
    }

    public function getStato(){
        return $this->stato;
    }

    public function getPosti(){
        return $this->listaPosti;
    }

    public function getAereo(){
        return $this->aereo;
    }

    public function getAeroportoPartenza(){
        //occhio a materializzazione
        return $this->aeroportoPart;
    }

    public function getAeroportoDestinazione(){
        return $this->aeroportoDest;
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
        if($this->aeroportoPart->getNazione() == $this->aeroportoDest->getNazione()){
            return rand(200,600);
        }
        else if($this->aeroportoPart->getContinente() == $this->aeroportoDest->getContinente()){
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