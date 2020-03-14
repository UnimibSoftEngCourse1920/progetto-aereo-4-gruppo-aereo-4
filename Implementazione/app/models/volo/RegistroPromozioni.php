<?php


require_once __DIR__."/Promozione.php";
require_once __DIR__."/RegistroVoli.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/DBFacade.php";


class RegistroPromozioni
{

    public function creaPromozione($sconto, $dataInizio,$dataFine, $nome, $codVolo, $promozioneFedelta){
        if($dataInizio==""){
            $dataInizio = date("Y-m-g");
        }
        if($dataFine==""){
            $dataFine = date("Y-m-g");
        }
        $promozione = new Promozione($dataInizio, $dataFine, $nome, $sconto, $promozioneFedelta);
        DBFacade::getIstance()->put($promozione);

        if($codVolo!="no"){
            $registroVoli = new RegistroVoli();
            $v = $registroVoli->getVolo($codVolo);
            $v -> setPromozione($promozione);
            DBFacade::getIstance()->update($v);
        }
    }

    public function cancellaPromozione($OID){
        DBFacade::getIstance()->delete($OID, Promozione::class);
    }

    public function getPromozioniFedelta(){
        //ritorna lista delle promozioni fedelta attive
        return DBFacade::getIstance() ->getPromozioniFedelta();
    }

    public function getPromozioni(){
        //Ritorna la lista di tutte le promozioni
        return DBFacade::getIstance()->getAll(Promozione::class);
    }

    public function getMigliorPromozioneAttiva(){
        $listaPromozioniAttive = DBFacade::getIstance()->getPromozioniAttive(); //recupero le promozioni attive
        $migliorProm = $listaPromozioniAttive[0]; //setto la miglior promozione
        foreach ($listaPromozioniAttive as $promozione){ //scorro tutte le promozioni
            if($promozione->percentualeSconto > $migliorProm->percentualeSconto) { //se ne trovo una migliore aggiorno
                $migliorProm = $promozione;
            }
        }
        return $migliorProm;
    }

}
