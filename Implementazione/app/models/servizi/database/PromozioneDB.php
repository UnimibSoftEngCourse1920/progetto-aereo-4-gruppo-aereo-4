<?php


namespace model\servizi;


class PromozioneDB extends AbstractDB{

    //Da rivedere fabio

    protected function generateCreateQuery($obj){
        return "INSERT INTO Promozione
                VALUES ($obj->getOID(), $obj->getDataInizio(), $obj->getDataFine(), $obj->getNome())"; //tipologia
    }
}