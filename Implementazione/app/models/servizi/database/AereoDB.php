<?php


namespace model\servizi;
require_once("AbstractDB.php");


class AereoDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO Aereo 
                    VALUES ('%s', %d , '%s', '%s')";
        return spirntf($query, $obj->getOID(), $obj->getNumeroPosti(), $obj->getNumeroSerie(), $obj->getMarcaModello());
    }

    protected function generateUpdateQuery($obj){
        $query = "UPDATE ".$this->getClassName($obj)." 
                    SET marcaModello = '%s', numeroPosti = , numeroSerie = '%s'
                    WHERE OID = '$obj->OID'";
        return sprintf($query, $obj->getMarcaModello(), $obj->getNumeroPosti(), $obj->getNumeroSerie());
    }
}