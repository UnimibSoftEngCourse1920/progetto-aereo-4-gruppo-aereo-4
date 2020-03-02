<?php


namespace model\servizi;


class ImpiegatoDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO IMPIEGATO 
                VALUES ($obj->OID, $obj->nome, $obj->cognome, $obj->username, $obj->password)";
    }
}