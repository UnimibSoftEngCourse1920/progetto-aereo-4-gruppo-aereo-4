<?php


namespace model\servizi\database;


class IstitutoDB
{
    public function generateCreateQuery($obj){
        return "INSERT INTO IstitutoDiCredito
                VALUES ('$obj->getOID()', '$obj->getNome()')";
    }
}
