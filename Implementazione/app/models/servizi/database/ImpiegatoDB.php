<?php


namespace model\servizi\database;
require_once("AbstractDB.php");


class ImpiegatoDB
{
    protected function generateCreateQuery($obj){
        $query = "INSERT INTO Impiegato VALUES ('%s', '%s', '%s', '%s', '%s')";
        return sprintf($obj->getOID(), $obj->getNome(), $obj->getCognome(), $obj->getUsername(), $obj->getPassword());
    }
}