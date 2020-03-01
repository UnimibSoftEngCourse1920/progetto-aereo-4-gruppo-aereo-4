<?php


namespace model\servizi;


class AcquistoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO ACQUISTO 
                VALUES ($obj->OID, $obj->OIDPagamento, $obj->puntiAccumulati)";
    }
}