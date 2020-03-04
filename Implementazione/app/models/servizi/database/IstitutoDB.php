<?php


namespace model\servizi\database;


class IstitutoDB
{
    public function generateCreateQuery($obj){
        return "INSERT INTO ISTITUTODICREDITO
                VALUES ($obj->OID, $obj->nome)";
    }
}
