<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/DBFacade.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Posto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Aeroporto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";


class Volo {

    static $STATO_ATTIVO = "ATTIVO";
    static $STATO_CANCELLATO = "CANCELLATO";

    private $OID;
    private $dataOraPartenza;
    private $dataOraArrivo;
    private $stato;
    private $miglia;
    private $aereo;

    private $aeroportoPartenza;
    private $aeroportoDestinazione;
    private $promozione;

    private $listaPosti; //posti del volo

    public function __construct($dataOraPartenza, $dataOraArrivo, $aeroportoPartenza, $aeroportoDestinazione, $aereo){
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->dataOraPartenza = $dataOraPartenza;
        $this->dataOraArrivo = $dataOraArrivo;
        $this->aeroportoPartenza = $aeroportoPartenza;
        $this->aeroportoDestinazione = $aeroportoDestinazione;
        $this->miglia = $this->calcolaMiglia();
        $this->stato = self::STATO_ATTIVO;
        $this->aereo = $aereo;
        $this->promozione = null;
        $this->listaPosti = array();

        for($i=0; $i<$this->aereo->getNumeroPosti(); $i++){
            $p = new Posto($i+1);
            $this->listaPosti[] = $p;
        }
    }


    public function setAeroportoDestinazione($aeroportoDestinazione)
    {
        $this->aeroportoDestinazione = $aeroportoDestinazione;
    }

    public function setAeroportoPartenza($aeroportoPartenza)
    {
        $this->aeroportoPartenza = $aeroportoPartenza;
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
        if(is_string($this->promozione)){
            $this->promozione = DBFacade::getIstance() ->get($this->promozione, Promozione::class);
        }
        return $this->promozione;
    }

    public function getMiglia(){
        return $this->miglia;
    }

    public function getStato(){
        return $this->stato;
    }

    public function getPosti(){
        if(is_string($this->listaPosti[0])){
            for($i=0; $i< count($this->listaPosti); $i++){
                $this->listaPosti[$i] = DBFacade::getIstance()->get($this->listaPosti[i], Posto::class);
            }
        }
        return $this->listaPosti;
    }

    public function getAereo(){
        if(is_string($this->aereo)){
            $this->aereo = DBFacade::getIstance() ->get($this->aereo, Aereo::class);
        }
        return $this->aereo;
    }

    public function getAeroportoPartenza(){
        if(is_string($this->aeroportoPartenza)){
            $this->aeroportoPartenza = DBFacade::getIstance() ->get($this->aeroportoPartenza, Aeroporto::class);
        }
        return $this->aeroportoPartenza;
    }

    public function getAeroportoDestinazione(){
        if(is_string($this->aeroportoDestinazione)){
            $this->aeroportoDestinazione = DBFacade::getIstance() ->get($this->aeroportoDestinazione, Aeroporto::class);
        }
        return $this->aeroportoDestinazione;
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

        return ($numPosti <= $contaLiberi);
    }

    private function calcolaMiglia(){
        if($this->aeroportoPartenza->getNazione() == $this->aeroportoDestinazione->getNazione()){
            return rand(200,600);
        }
        else if($this->aeroportoPartenza->getContinente() == $this->aeroportoDestinazione->getContinente()){
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