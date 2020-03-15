<?php


require_once("AbstractDB.php");


class PromozioneDB extends AbstractDB{

    protected function generatePutQuery($obj){
        return sprintf("INSERT INTO Promozione VALUES ('%s', '%s', '%s', '%s', %u, %u)",
            $obj->getOID(), $obj->getDataInizio(), $obj->getDataFine(), $obj->getNome(), (int)$obj->getSconto(), (int)$obj->isFedelta());
    }

    public function getPromozioniFedelta(){
        $data = date("Y-m-g");
        $query = "select * from Promozione where promozioneFedelta = 1  and dataFine > '$data'";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Promozione::class);
    }

    public function getPromozioniAttive(){
        $data = date("Y-m-g");
        $query = "select * from Promozione where dataFine > '$data' and promozioneFedelta = 0";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Promozione::class);
    }
}