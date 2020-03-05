<?php


namespace model\servizi;


class AereoDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        return "INSERT INTO Aereo 
                VALUES ('$obj->getOID()', $obj->getNumeroPosti(), '$obj->getNumeroSerie()', '$obj->getMarcaModello()')";
    }

    protected function generateUpdateQuery($obj){
        return "UPDATE ".$this->getClassName($obj)." 
                SET marcaModello = '$obj->marcaModello', numeroPosti = $obj->numeroPosti, numeroSerie = '$obj->numeroSerie'
                WHERE OID = '$obj->OID'";
    }
}