<?php


namespace model\servizi;


class AcquistoDB extends AbstractDB
{
    protected function generatePutQuery($obj)
    {
        //$pagamento = $obj->getPagamento() == null ? null : $obj->getPagamento()->getOID();
        return "INSERT INTO Acquisto 
                VALUES ('$obj->getOID()', $obj->getPuntiAccumulati(), '$obj->getPagamento()->getOID(')";
    }
}