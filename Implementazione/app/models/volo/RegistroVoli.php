<?php


namespace model\volo;


use model\servizi\DB;

class RegistroVoli{

    public function getVolo($codiceVolo){
        //cerca sul db e ritorna un volo
        return null;
    }

    public function aggiungiVolo($datiVolo){
        //controllo che i dati forniti siano validi
        $codiceVolo = $this -> generaCodiceVolo($datiVolo);
        $nuovoVolo = new Volo($datiVolo, $codiceVolo);
        DB::getInstance() -> put($nuovoVolo);
    }

    private function generaCodiceVolo($datiVolo){
        return 'MIAM202010070810';
    }

    public static function checkDisponibilitaPosti($numPosti, $codVolo){
        return Volo::getDisponibilitaPosti($codVolo);
    }

}