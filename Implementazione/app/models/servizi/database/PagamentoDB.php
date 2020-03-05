<?php


namespace model\servizi;


class PagamentoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        if($this->getClassName($obj) == 'PagamentoConCarta') {
            $query = "INSERT INTO Pagamento 
                        VALUES ($obj->getOID(), 
                                $obj->getImporto(), 
                                null , 
                                $obj->getData(), 
                                $obj->getIstituto(), 
                                'CARTA')";
        }
        else{
            $query = "INSERT INTO Pagamento 
                        VALUES ($obj->getOID(), 
                        null, $
                        obj->getPuntiUtilizzati() , 
                        $obj->getData(), 
                        null , 
                        'PUNTI')";
        }

        return $query;
    }

}