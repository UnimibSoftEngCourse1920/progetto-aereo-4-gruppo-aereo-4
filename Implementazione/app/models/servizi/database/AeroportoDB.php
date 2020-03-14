<?php


require_once("AbstractDB.php");


class AeroportoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        $query = "INSERT INTO Aeroporto VALUES ('%s', '%s', '%s', '%s', '%s')";
        return sprintf($query, $obj->getOID(), $obj->getContinente(), $obj->getNazione(),$obj->getCitta(), $obj->getNome());
    }
}