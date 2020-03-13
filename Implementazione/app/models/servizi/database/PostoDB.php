<?php


 ;
require_once("AbstractDB.php");


class PostoDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO Posto VALUES ('%s',%b ,%d )";
        return sprintf($query, $obj->getOID(), $obj->isStato(), $obj->getNumeroPosto());
    }

    protected function generateUpdateQuery($object){
        $query = "UPDATE %s SET stato = %b WHERE OID = '%s'";
        return sprintf($query, $this->getClassName($object), $object->isStato(), $object->getOID());
    }

}
