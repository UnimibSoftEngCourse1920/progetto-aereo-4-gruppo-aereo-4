<?php


 ;
require_once("AbstractDB.php");


class AcquistoDB extends AbstractDB
{
    public function get($OID, $class)
    {
        //TODO riutilizzo la get ??
        $acquisto = parent::get($OID, $class); //Fa la get di acquisto
        $tipo = $this->getTipoPagamento($acquisto->getPagamento());

        $query = "Select * from Pagamento WHERE OID = '".$acquisto->getPagamento()."'";
        $stmt = $this->connection->query($query); //la eseguo
        $classePagamento = "PagamentoCon".$tipo;
        $pagamento = $this->fetchSingleByClass($stmt, $classePagamento);
        $acquisto->setPagamento($pagamento);
        return $acquisto;
    }

    private function getTipoPagamento($OID){
        $query = "Select tipo from Pagamento WHERE OID = '$OID'";
        return $this->connection->query($query)->fetch()[0];
    }

    protected function generatePutQuery($obj)
    {
        $query = "INSERT IGNORE INTO Acquisto VALUES ('%s', %d, '%s')";
        return sprintf($query,$obj->getOID(), $obj->getPuntiAccumulati(), $obj->getPagamento()->getOID());
    }
}