<?php


//namespace model\servizi;
require_once("AbstractDB.php");


class AcquistoDB extends AbstractDB
{
    public function get($OID, $class)
    {
        //TODO dovrebbe funzionare ma non mi piace
        $acquisto = $this->get($OID, $class);
        $acquisto->setPagamento($this->getPagamento($acquisto->getPagamento()));
        return $acquisto;
    }

    private function getPagamento($OIDPagamento){
        $query = "(SELECT OID, 'Punti' as tipo from PagamentoConPunti WHERE OID = '$OIDPagamento') 
                   UNION ALL 
                  (SELECT OID, 'Carta' as tipo from PagamentoConCarta WHERE OID = $OIDPagamento)";
        $pagamento = $this->connection->query($query)->fetch();
        return $this->get($pagamento[0], "PagamentoCon".$pagamento[1]);
    }

    protected function generatePutQuery($obj)
    {
        $query = "INSERT INTO Acquisto VALUES ('%s', %d, '%s')";
        return sprintf($query,$obj->getOID(), $obj->getPuntiAccumulati(), $obj->getPagamento()->getOID());
    }
}