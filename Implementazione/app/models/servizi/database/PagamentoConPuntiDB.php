<?php


//namespace model\servizi;
require_once("AbstractDB.php");


class PagamentoConPuntiDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO PagamentoConPunti VALUES ('%s',%d,'%s',%d)";
        return sprintf($query, $obj->getOID(), $obj->getImporto(), $obj->getData(), $obj->getPuntiUtilizzati());
    }

}