<?php


namespace model\servizi;
require_once("AbstractDB.php");


class AereoportoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        $query = "INSERT INTO Aereoporto VALUES ('%s', '%s', '%s', '%s', '%s')";
        return sprintf($query, $obj->getOID(), $obj->getContinente(), $obj->getNazione(),$obj->getCitta(), $obj->getNome());
    }
}