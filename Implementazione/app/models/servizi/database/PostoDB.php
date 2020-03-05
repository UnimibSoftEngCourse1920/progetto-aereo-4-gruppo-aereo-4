<?php


//namespace model\servizi;
require_once("AbstractDB.php");


class PostoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        $query = "INSERT INTO Posto VALUES ('%s',%b ,%d )";
        return sprintf($query, $obj->getOID(), $obj->getStato(), $obj->getNumeroPosto());
    }

    protected function generateUpdateQuery($object){
        $query = "UPDATE %s SET stato = %b WHERE OID = '%s'";
        return sprintf($query, $this->getClassName($object), $object->getStato(), $object->getOID());
    }

}
