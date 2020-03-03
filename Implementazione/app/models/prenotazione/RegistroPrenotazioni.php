<?php


namespace model\prenotazione;


use model\servizi\DB;
use model\volo\RegistroVoli;

class RegistroPrenotazioni{

    public function getClientiVolo($OIDVolo){
        $listaClienti = DB::getIstance() -> getClientiVolo($OIDVolo);
        return $listaClienti;
    }

    public function generaEstrattoConto($codiceFedelta){

    }

    public function effettuaPrenotazione($cliente,$codVolo,$numPosti){
        if($this->checkPrenotazioneUnivoca($cliente->email,$codVolo)){
            if(RegistroVoli::checkDisponibilitaPosti($numPosti,$codVolo)){
                $codice = $this->creaPrenotazione($cliente, $codVolo,$numPosti);
            }
            else
                return false;
        } else
            return false;
    }

    public function checkPrenotazioneUnivoca($email,$codVolo){
        //query
        $ris = DB::getIstance()->get();
        if($ris->rowCount()>0)
            return false;
        else
            return true;
    }

    public function creaPrenotazione($cliente,$codVolo,$numPosti){
        $nuovaPrenotazione = new Prenotazione($cliente,$codVolo,$numPosti,date("d/m/Y"));
        DB::getIstance()->put($nuovaPrenotazione);
        $codice = $nuovaPrenotazione->OID;
        return $codice;
    }

    public function getFedeltaUltimaPrenotazione($anniTrascorsi){
        //ritorna la lista di clienti che hanno fatto l'ultima prenotazione $anniTrascorsi anni fa
        //NB!! Questo metodo mi DOVREBBE ritornare una lista di clienti, la chiamata al DB probabilmente ritorna la lista di prenotazioni
        return DB::getIstance()->getFedeltaUltimaPrenotazione($anniTrascorsi);
    }
}
?>