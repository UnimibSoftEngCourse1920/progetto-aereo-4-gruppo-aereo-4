<?php


namespace model\servizi;
require_once("AbstractDB.php");


class BigliettoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        $query = "INSERT INTO Biglietto VALUES ('%s', '%s', '%s')";
        return sprintf($query,$obj->getOID() , $obj->getTariffa(), $obj->getNominativo());

    }
}