<?php


namespace model\servizi;


class PagamentoConPuntiDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO PagamentoConPunti 
                VALUES ($obj->getOID(), $obj->getPuntiUtilizzati(), $obj->getData())";
    }
}