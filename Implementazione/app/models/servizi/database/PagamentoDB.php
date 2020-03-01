<?php


namespace model\servizi;


class PagamentoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO PAGAMENTO 
                VALUES ($obj->OID, $obj->importo, $obj->puntiUtilizzati, $obj->data, $obj->OIDIstituto)";
    }

}