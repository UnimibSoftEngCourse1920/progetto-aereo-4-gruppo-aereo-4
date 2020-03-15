<?php


require_once("AbstractDB.php");


class AereoDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO Aereo 
                    VALUES ('%s', %d , '%s', '%s')";
        return sprintf($query, $obj->getOID(), $obj->getNumeroPosti(), $obj->getNumeroSerie(), $obj->getMarcaModello());
    }

    protected function generateUpdateQuery($obj){
        $query = "UPDATE Aereo 
                    SET marcaModello = '%s', numeroPosti = %d, numeroSerie = '%s'
                    WHERE OID = '%s'";
        return sprintf($query, $obj->getMarcaModello(), $obj->getNumeroPosti(), $obj->getNumeroSerie(), $obj->getOID());
    }

}