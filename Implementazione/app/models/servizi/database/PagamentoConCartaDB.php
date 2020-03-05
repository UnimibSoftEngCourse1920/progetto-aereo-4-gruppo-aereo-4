<?php


namespace model\servizi;


class PagamentoConCartaDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO PagamentoConCarta 
                VALUES ($obj->getOID(), $obj->getImporto(), $obj->getData(), $obj->getIstituto())";
    }

}