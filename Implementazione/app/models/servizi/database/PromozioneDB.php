<?php


namespace model\servizi;


class PromozioneDB extends AbstractDB{

    protected function generateCreateQuery($obj){
        return "INSERT INTO PROMOZIONE 
                VALUES ($obj->OID, $obj->dataInizio, $obj->dataFine, $obj->nome)
                "; //tipologia
    }
}