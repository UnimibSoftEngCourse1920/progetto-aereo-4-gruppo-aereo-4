<?php


namespace model\servizi;


class VoloDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        $query = "INSERT INTO Volo VALUES (
                    $obj->getOID(),
                    $obj->getOrarioPartenza(),
                    $obj->OorarioArrivo(),
                    $obj->getData(),
                    $obj->getStato(),
                    $obj->getMiglia()),
                    $obj->getAereo().getOID()";
        $query .= $obj.getPromozione()!=null ? ", $obj->getPromozione().getOID() );" : ");";
        //VoloAereoporto
        $query .= "Insert into VoloAereoporto values ($obj->getOID(), $obj->getAereoportoPart().getOID(), $obj->getAereoportoArrivo().getOID() )";
        //VoloPosto
        foreach ($obj->getPosti() as $posto)
            $query .= "INSERT INTO VoloPosto values ($obj->getOID(), $posto->getOID())";

        return $query;

    }

    protected function generateUpdateQuery($object){

        return "UPDATE ".get_class($object)." 
                SET stato = '$object->getStato()', data = '$object->getData(), orarioPartenza='$object->getOrarioPartenza()', orarioArrivo='$object->getOrarioArrivo()'
                WHERE OID = '$object->getOID()'";
    }
}