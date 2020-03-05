<?php


namespace model\servizi;


class PostoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO Posto VALUES ('$obj->getOID()', $obj->getStato(), $obj->getNumeroPosto())";
    }

    protected function generateUpdateQuery($object){
        return "UPDATE ".$this->getClassName($object)." 
                SET stato = $object->getStato(),
                WHERE OID = '$object->getOID()'";
    }

}
