<?php


namespace model\servizi;
require_once("AbstractDB.php");


class AcquistoDB extends AbstractDB
{
    protected function generatePutQuery($obj)
    {
        //$pagamento = $obj->getPagamento() == null ? null : $obj->getPagamento()->getOID();
        $query = "INSERT INTO Acquisto VALUES ('%s', %d, '%s')";
        return sprintf($query,$obj->getOID(), $obj->getPuntiAccumulati(), $obj->getPagamento()->getOID());
    }
}