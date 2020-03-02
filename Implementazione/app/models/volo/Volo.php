<?php


namespace model\volo;


use model\servizi\DB;
use model\servizi\OIDGenerator;

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

    private $posti; //posti che sono stati occupati dal volo

    public function __construct($orarioPartenza, $orarioArrivo, $data, $AereoportoPart, $AereoportArr, $Aereo){
        $database = DB::getIstance();
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->orarioPartenza = $orarioPartenza;
        $this->orarioArrivo = $orarioArrivo;
        $this->data = $data;
        $this->miglia = $this->calcolaMiglia();
        $this->stato = 'ATTIVO';
        //codice volo??
        $this->aereoportoPart = $database->get($AereoportoPart);
        $this->aereoportoDest = $database->get($AereoportArr);
        $this->aereo = $database->get($Aereo);
        $this->promozione = null;
    }

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

    public function getOrarioPartenza(){
        return $this->orarioPartenza;
    }

    public function getOrarioArrivo(){
        return $this->orarioArrivo;
    }

    public static function getDisponibilitaPosti($numPosti){
        $ris = null;
        if($numPosti<=$ris)
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

    public function prenota($numPosti, $codPrenotazione){
        $postiRimanenti = $numPosti;
        $listaPosti = array();
        while ($postiRimanenti > 0){
            $posto = new Posto($codPrenotazione);
            array_push($listaPosti,$posto->numPosto);
            $postiRimanenti--;
        }
        return $listaPosti;
    }
}