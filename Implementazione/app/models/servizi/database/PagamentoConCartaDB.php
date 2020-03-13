<?php


require_once("AbstractDB.php");


class PagamentoConCartaDB extends AbstractDB{

    public function generatePutQuery($obj){
        $query = "INSERT INTO Pagamento VALUES ('%s',%d,'%s',null,'%s','Carta')";
        return sprintf($query, $obj->getOID(), $obj->getImporto(), $obj->getData(), $obj->getIstituto()->getOID());
    }

}