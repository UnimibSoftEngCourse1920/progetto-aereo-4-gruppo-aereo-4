<?php


namespace model\servizi\database;
require_once("AbstractDB.php");


class IstitutoDB
{
    public function generateCreateQuery($obj){
        $query = "INSERT INTO IstitutoDiCredito VALUES ('%s', '%s')";
        return sprintf($query, $obj->getOID(), $obj->getNome());
    }
}
