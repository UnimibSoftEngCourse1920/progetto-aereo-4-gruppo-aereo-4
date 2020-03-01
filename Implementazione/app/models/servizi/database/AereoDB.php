<?php


namespace model\servizi;


class AereoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO AEREO 
                VALUES ($obj->OID, $obj->marcaModello, $obj->numeroPosti, $obj->numeroSerie)";
    }

    protected function generateUpdateQuery($obj){
        return "UPDATE ".get_class($obj)." 
                SET marcaModello = '$obj->marcaModello, numeroPosti = '$obj->numeroPosti, numeroSerie = '$obj->numeroSerie'
                WHERE OID = '$obj->OID'";
    }
}