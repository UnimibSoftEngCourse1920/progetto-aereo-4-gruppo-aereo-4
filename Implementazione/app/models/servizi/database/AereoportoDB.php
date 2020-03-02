<?php


namespace model\servizi;


class AereoportoDB extends AbstractDB{

    protected function generateCreateQuery($obj){
        return "INSERT INTO AEREOPORTO 
                VALUES ($obj->OID, $obj->continente, $obj->nazione, $obj->citta, $obj->nome)";
    }
}