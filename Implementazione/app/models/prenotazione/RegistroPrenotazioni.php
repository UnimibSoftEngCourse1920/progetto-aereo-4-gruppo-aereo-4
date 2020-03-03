<?php


namespace model\prenotazione;


use model\servizi\DB;
use model\volo\RegistroVoli;
use model\volo\Volo;

class RegistroPrenotazioni{

    public function getClientiVolo($OIDVolo){
        $listaClienti = DB::getIstance() -> getClientiVolo($OIDVolo);
        return $listaClienti;
    }

    public function generaEstrattoConto($codiceFedelta){

    }

    public function effettuaPrenotazione($cliente,$codVolo,$numPosti,$tariffa){
        $univoca = DB::getIstance()->checkPrenotazioneUnivoca($cliente->email,$codVolo);
        if($univoca){
            $disp = RegistroVoli::checkDisponibilitaPosti($numPosti,$codVolo);
            if($disp){
                $nuovaPrenotazione = new Prenotazione($cliente,$codVolo,$numPosti,$tariffa,date("d/m/Y"));
                $nuovaPrenotazione->registraPrenotazione();
                $volo = DB::getIstance()->getVolo($codVolo);
                $nuovaPrenotazione->listaPosti = $volo->prenota($numPosti);

            }
            else
                return false;
        } else
            return false;
    }

    public function getFedeltaUltimaPrenotazione($anniTrascorsi){
        //ritorna la lista di clienti che hanno fatto l'ultima prenotazione $anniTrascorsi anni fa
        //NB!! Questo metodo mi DOVREBBE ritornare una lista di clienti, la chiamata al DB probabilmente ritorna la lista di prenotazioni
        return DB::getIstance()->getFedeltaUltimaPrenotazione($anniTrascorsi);
    }
}
?>