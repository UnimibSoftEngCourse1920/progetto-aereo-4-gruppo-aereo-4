<?php


require_once("AbstractDB.php");


class PostoDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO Posto VALUES ('%s',%b ,%d )";
        return sprintf($query, $obj->getOID(), $obj->isOccupato(), $obj->getNumeroPosto());
    }

    protected function generateUpdateQuery($posto){
        $query = "UPDATE Posto SET stato = %b WHERE OID = '%s'";
        return sprintf($query, $posto->isOccupato(), $posto->getOID());
    }

}
