<?php


require_once "Promozione.php";
require_once "RegistroVoli.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/DBFacade.php";


class RegistroPromozioni
{
    public function __construct()
    {

    }

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

    public function cancellaPrenotazione($OID){
        DBFacade::getIstance()->delete($OID, "Promozione");
    }

    //TODO da mettere insieme i due metodi sotto??

    public function getPromozioniFedelta(){
        //ritorna lista delle promozioni fedelta attive
        return DBFacade::getIstance() ->getPromozioniFedelta();
    }

    public function getPromozioni(){
        return DBFacade::getIstance()->getAll("Promozione");
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