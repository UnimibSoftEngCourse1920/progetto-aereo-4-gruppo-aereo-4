<?php


namespace model\servizi;


class PagamentoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO Pagamento 
                VALUES ($obj->getOID(), $obj->getImporto(), $obj->getPuntiUtilizzati(), $obj->getData(), $obj->getIstituto())";
    }

}