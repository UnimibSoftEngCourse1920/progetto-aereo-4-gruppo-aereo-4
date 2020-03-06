<?php


namespace model\volo;


class RegistroPromozioni
{
    public function creaPromozione($sconto, $dataInizio,$dataFine, $nome, $codVolo, $promozioneFedelta){

        $promozione = new Promozione($dataInizio, $dataFine, $nome, $sconto, $promozioneFedelta);
        DBFacade::getIstance()->put($promozione);

        if($codVolo!=""){
            $registroVoli = new RegistroVoli();
            $v = $registroVoli->getVolo($codVolo);
            $v -> setPromozione($promozione);
            DBFacade::getIstance()->update($v);
        }

    }

    public function getPromozioniFedelta(){
        //ritorna lista delle promozioni fedelta attive
        return array();
    }

    public function getMigliorPromozioneAttiva(){
        $listaPromozioniAttive = DBFacade::getIstance()->getPromozioniAttive(date("Y-m-d")); //recupero le promozioni attive
        $migliorProm = $listaPromozioniAttive[0]; //setto la miglior promozione
        foreach ($listaPromozioniAttive as $promozione){ //scorro tutte le promozioni
            if($promozione->percentualeSconto > $migliorProm->percentualeSconto) //se ne trovo una migliore aggiorno
                $migliorProm = $promozione;
        }

        return $migliorProm;
    }

}