<?php


namespace model\servizi;


class BigliettoDB extends AbstractDB{

    protected function generateCreateQuery($obj){
        return "INSERT INTO BIGLIETTO 
                VALUES ($obj->OID, $obj->tariffa, $obj->nominativo)";
    }
}