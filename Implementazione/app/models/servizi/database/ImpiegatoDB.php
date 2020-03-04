<?php


namespace model\servizi\database;


class ImpiegatoDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO Impiegato 
                VALUES ($obj->getOID(), $obj->getNome(), $obj->getCognome(), $obj->getUsername(), $obj->getPassword())";
    }
}