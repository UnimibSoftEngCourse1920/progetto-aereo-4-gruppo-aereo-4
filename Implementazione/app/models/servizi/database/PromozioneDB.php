<?php


require_once("AbstractDB.php");


class PromozioneDB extends AbstractDB{

    //TODO Da rivedere fabio
    protected function generatePutQuery($obj){
        return sprintf("INSERT INTO Promozione VALUES ('%s', '%s', '%s', '%s', %u, %u)",
            $obj->getOID(), $obj->getDataInizio(), $obj->getDataFine(), $obj->getNome(), (int)$obj->isFedelta(), (int)$obj->getSconto());
    }

    public function getPromozioniFedelta(){
        $query = "select * from Promozione where promozioneFedelta = 'TRUE'";
        $stmt = $this->connection->query($query);
        return $this->materializeAll($stmt, Promozione::class);
    }
}