<?php


namespace model\servizi;


class VoloDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        $query = "INSERT INTO VOLO VALUES (
                    $obj->OID, 
                    $obj->orarioPartenza, 
                    $obj->orarioArrivo,
                    $obj->data,
                    $obj->stato,
                    $obj->miglia,
                    $obj->getAereo().getOID(),
                    $obj->getAereoportoPart().getOID(),
                    $obj->getAereoportoArrivo().getOID()";
        if($obj.getPromozione()!=null)
            $query = $query . ", $obj->getPromozione().getOID()";

        return $query . ')';
    }

    protected function generateUpdateQuery($object){
        //Cosa si può cambiare di un volo?
        //DA FINIRE
        return "UPDATE ".get_class($object)." 
                SET stato = '$object->stato', data = '$object->data'
                WHERE OID = '$object->OID'";
    }
}