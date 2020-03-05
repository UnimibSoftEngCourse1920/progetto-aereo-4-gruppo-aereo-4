<?php

class Volo{
    private $OID;
    private $data;
    private $orarioPartenza;
    private $orarioArrivo;
    private $stato;
    private $codiceVolo;
    private $miglia;

    private $aereoportoPart;
    private $aereoportoDest;
    private $aereo;
    private $promozione;

    private $listaPosti; //posti del volo

    public function __construct($orarioPartenza, $orarioArrivo, $data, $AereoportoPart, $AereoportArr, $Aereo){
        $database = DB::getIstance();
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->orarioPartenza = $orarioPartenza;
        $this->orarioArrivo = $orarioArrivo;
        $this->data = $data;
        $this->miglia = $this->calcolaMiglia();
        $this->stato = 'ATTIVO';
        //codice volo??
        $this->aereoportoPartenza = $database->get($AereoportoPart);
        $this->aereoportoDestinazione = $database->get($AereoportArr);
        $this->aereo = $database->get($Aereo);
        $this->promozione = null;
        $this->listaPosti = array();

        for($i=0; $i<$this->aereo->getPostiDisponibili(); $i++){
            $p = new Posto($i+1);
            $this->listaPosti[] = $p;
        }
    }

    // <editor-fold defaultstate="collapsed" desc="getters">

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getOrarioPartenza()
    {
        return $this->orarioPartenza;
    }

    /**
     * @return mixed
     */
    public function getOrarioArrivo()
    {
        return $this->orarioArrivo;
    }

    /**
     * @return string
     */
    public function getStato()
    {
        return $this->stato;
    }

    /**
     * @return mixed
     */
    public function getCodiceVolo()
    {
        return $this->codiceVolo;
    }

    /**
     * @return int
     */
    public function getMiglia()
    {
        return $this->miglia;
    }

    /**
     * @return mixed
     */
    public function getAereoportoPart()
    {
        return $this->aereoportoPart;
    }

    /**
     * @return mixed
     */
    public function getAereoportoDest()
    {
        return $this->aereoportoDest;
    }

    /**
     * @return \model\cliente\ClienteFedelta
     */
    public function getAereo()
    {
        return $this->aereo;
    }

    /**
     * @return null
     */
    public function getPromozione()
    {
        return $this->promozione;
    }

    /**
     * @return array
     */
    public function getListaPosti()
    {
        return $this->listaPosti;
    }

    // </editor-fold>


    public function setData($data){
        //if($data >= date("Ymd"))
            $this->data = $data;
    }

    public function setOrarioPartenza($orarioPartenza){
        $this->orarioPartenza = $orarioPartenza;
    }

    public function setOrarioArrivo($orarioArrivo){
        $this->orarioArrivo = $orarioArrivo;
    }

    public function setStato($stato){
        $this->stato = $stato;
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
        foreach ($this->listaPosti as $posto){
            if($postiRimanenti>0) {
                if ($posto->isOccupato() == 0) {
                    $posto->cambiaStato();
                    array_push($listaPostiPrenotati,$posto);
                    $postiRimanenti--;
                }
            }

        }
        return $listaPostiPrenotati;
    }



}