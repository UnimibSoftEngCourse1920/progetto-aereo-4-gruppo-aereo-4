<?php


 ;
require_once("AbstractDB.php");


class BigliettoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        $query = "INSERT INTO Biglietto VALUES ('%s', '%s', '%s', '%s', %.2f)";
        return sprintf($query,$obj->getOID() , $obj->getTariffa(), $obj->getNominativo(), $obj->getNumPosto(), $obj->getPrezzo());

    }
}