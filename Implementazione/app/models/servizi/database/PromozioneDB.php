<?php


//namespace model\servizi;
require_once("AbstractDB.php");


class PromozioneDB extends AbstractDB{

    //Da rivedere fabio
    //percentuale
    protected function generatePutQuery($obj){
        $var = sprintf("INSERT INTO Promozione VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $obj->getOID(), $obj->getDataInizio(), $obj->getDataFine(), $obj->getNome(), $obj->isFedelta(), $obj->getSconto());
        return $var;
    }
}