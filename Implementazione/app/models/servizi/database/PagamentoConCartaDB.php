<?php


require_once("AbstractDB.php");


class PagamentoConCartaDB extends AbstractDB{

    public function generatePutQuery($obj){
        //TODO get istituto è un oggetto o un codice??
        $query = "INSERT INTO PagamentoConPunti VALUES ('%s',%d,'%s','%s')";
        return sprintf($query, $obj->getOID(), $obj->getImporto(), $obj->getData(), $obj->getIstituto()->getOID());
    }

}