<?php


//namespace model\servizi;
require_once("AbstractDB.php");


class PromozioneDB extends AbstractDB{

    //Da rivedere fabio
    //percentuale
    protected function generatePutQuery($obj){
        return sprintf("INSERT INTO Promozione VALUES ('%s', '%s', '%s', '%s', %u, %u)", $obj->getOID(), $obj->getDataInizio(), $obj->getDataFine(), $obj->getNome(), (int)$obj->isFedelta(), (int)$obj->getSconto());
    }

    public function getPromozioniFedelta(){
        $query = "select * from Promozione where promozioneFedelta = 'TRUE'";
        $stmt = $this->connection->query($query); //la eseguo
        $lista = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //per ogni riga creo un oggetto generico
            $obj = (object)($row);
            array_push($lista,$obj);
        }

        $listaDef = array();
        foreach ($lista as $el){
            array_push($listaDef,$this->objectToObject($el,Promozione::class)); //eseguo il cast dell'oggetto generico
        }

        return $listaDef;
    }
}