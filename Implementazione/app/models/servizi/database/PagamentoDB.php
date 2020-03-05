<?php


namespace model\servizi;
require_once("AbstractDB.php");


class PagamentoDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        if($this->getClassName($obj) == "PagamentoConCarta")
            $carta = true;

        $importo = ($carta) ? $obj->getImporto() : null;
        $istituto = ($carta) ? $obj->getIstituto() : null;
        $punti = ($carta) ? null : $obj->getPuntiUtilizzati();
        $tipo = $carta ? 'CARTA' : 'PUNTI';

        $query = "INSERT INTO Pagamento VALUES ('%s',%d,%d,'%s','%s')";

        return sprintf($query, $obj->getOID(), $importo, $punti, $obj->getData(), $istituto, $tipo);

    }

}