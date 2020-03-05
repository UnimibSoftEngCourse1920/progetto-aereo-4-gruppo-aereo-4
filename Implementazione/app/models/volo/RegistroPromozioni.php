<?php


namespace model\volo;


class RegistroPromozioni
{
    public function getPromozioniFedelta(){
        //ritorna lista delle promozioni fedelta attive
        return array();
    }

    public function getMigliorPromozioneAttiva(){
        $listaPromozioniAttive = DB::getIstance()->getPromozioniAttive(date("Y-m-d")); //recupero le promozioni attive
        $migliorProm = $listaPromozioniAttive[0]; //setto la miglior promozione
        foreach ($listaPromozioniAttive as $promozione){ //scorro tutte le promozioni
            if($promozione->percentualeSconto > $migliorProm->percentualeSconto) //se ne trovo una migliore aggiorno
                $migliorProm = $promozione;
        }

        return $migliorProm;
    }

}