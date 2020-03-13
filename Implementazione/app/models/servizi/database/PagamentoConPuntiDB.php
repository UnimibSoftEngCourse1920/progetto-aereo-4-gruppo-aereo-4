<?php


//namespace model\servizi;
require_once("AbstractDB.php");


class PagamentoConPuntiDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO Pagamento VALUES ('%s',%d,'%s',%d,null,'Punti')";
        return sprintf($query, $obj->getOID(), $obj->getImporto(), $obj->getData(), $obj->getPuntiUtilizzati());
    }

}