<?php


namespace model\volo;


use model\servizi\DB;

class Volo{
    private $aereoportoPart;
    private $aereoportoDest;
    private $data;
    private $orarioPartenza;
    private $orarioArrivo;
    private $stato;
    private $codiceVolo;
    private $miglia;

    public function modificaDati($datiVolo){
        //si modifica da solo
    }

    public static function getDisponibilitaPosti($numPosti){
        $ris = null;
        if($numPosti<=$ris)
            return true;
        else
            return false;
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