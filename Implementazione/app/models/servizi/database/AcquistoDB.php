<?php


namespace model\servizi;
require_once("AbstractDB.php");


class AcquistoDB extends AbstractDB
{
    protected function generatePutQuery($obj)
    {
        $pagamento = $this->getClassName($obj->getPagamento()) == "Pagamento" ? $obj->getPagamento()->getOID() : $obj->getPagamento(); //materializzazione pigra
        $query = "INSERT INTO Acquisto VALUES ('%s', %d, '%s')";
        return sprintf($query,$obj->getOID(), $obj->getPuntiAccumulati(), $pagamento);
    }
}