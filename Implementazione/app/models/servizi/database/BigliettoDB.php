<?php


require_once("AbstractDB.php");


class BigliettoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        $query = "INSERT INTO Biglietto VALUES ('%s', '%s', '%s', '%s', %.2f)";
        return sprintf($query,$obj->getOID() , $obj->getTariffa(), $obj->getNominativo(), $obj->getNumPosto(), $obj->getPrezzo());
    }

    protected function generateUpdateQuery($biglietto)
    {
        $query = "UPDATE Biglietto set numPosto = %d, tariffa ='%s', prezzo='%.2f' WHERE OID = '%s' ";
        return sprintf($query, $biglietto->getNumPosto(), $biglietto->getTariffa(), $biglietto->getPrezzo(), $biglietto->getOID());
    }


}