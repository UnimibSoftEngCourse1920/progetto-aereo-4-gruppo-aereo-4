<?php


namespace model\servizi;


class BigliettoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        return "INSERT INTO Biglietto 
                VALUES ($obj->getOID(), $obj->getTariffa(), $obj->getNominativo())";
    }
}