<?php


require_once("AbstractDB.php");


class PromozioneDB extends AbstractDB{

    protected function generatePutQuery($obj){
        return sprintf("INSERT INTO Promozione VALUES ('%s', '%s', '%s', '%s', %u, %u)",
            $obj->getOID(), $obj->getDataInizio(), $obj->getDataFine(), $obj->getNome(), (int)$obj->isFedelta(), (int)$obj->getSconto());
    }

    public function getPromozioniFedelta(){
        $query = "select * from Promozione where promozioneFedelta = 'TRUE'";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Promozione::class);
    }

    public function getPromozioniAttive(){
        $data = date("Y-m-g");
        $query = "select * from Promozione where dataFine < '$data' and promozioneFedelta = 0";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Promozione::class);
    }
}