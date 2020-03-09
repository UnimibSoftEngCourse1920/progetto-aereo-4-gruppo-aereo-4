<?php


//namespace model\servizi;
require_once "AbstractDB.php";

class VoloDB extends AbstractDB
{

    protected function generatePutQuery($obj){

        $promozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
        
        $query = sprintf("INSERT INTO Volo VALUES ('%s','%s','%s','%s','%s','%s'); ",
                        $obj->getOID(),$obj->getDataOraPartenza(),$obj->getDataOraArrivo(),$obj->getStato(), $obj->getMiglia(), $obj->getAereo()->getOID());

        //VoloAeroporto
        $query .= sprintf("Insert into VoloAeroporto values ('%s', '%s', '%s' ); ", $obj->getOID(), $obj->getAeroportoPartenza()->getOID(), $obj->getAeroportoDestinazione()->getOID());

        //VoloPosto
        foreach ($obj->getPosti() as $posto)
            $query .= sprintf("INSERT INTO VoloPosto values ('%s', '%s')", $obj->getOID(), $posto->getOID());

        return $query;
    }

    protected function generateUpdateQuery($object){
        return sprintf("UPDATE ".get_class($object)." SET stato = '%s', dataOraPartenza='%s', dataOraArrivo='%s' WHERE OID = '%s'",
                    $object->getStato(), $object->getDataOraPartenza(), $object->getDataOraArrivo(), $object->getOID() );
    }

    protected function generateGetQuery($OID, $class)
    {
        return "SELECT * from Volo v join VoloAeroporto va on v.OID = va.volo";
    }

    public function get($OID, $class){
        $volo = parent::get($OID, $class);
        //$this->setAereoporti($volo);
        $this->setPosti($volo);
        //TODO: Promozione
        return $volo;
    }

    private function DEPRECATO_setAereoporti(Volo $volo){
        $query = sprintf("Select aeroportoPartenza, aeroportoDestinazione from VoloAeroporto where volo='%s'", $volo->getOID());
        $aereoporti = $this->connection->query($query)->fetch();
        //TODO: controlli
        $volo->setAeroportoPart($aereoporti[0]);
        $volo->setAeroportoDest($aereoporti[1]);
    }

    private function setPosti(Volo $volo){
        $query = sprintf("Select posto from VoloPosto where volo='%s'", $volo->getOID());
        $listaPosti = $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
        $volo->setPosti($listaPosti);
    }

    public function cercaVoli($partenza, $destinazione, $data, $nPosti){
        $query = "SELECT v.* from Volo as v JOIN VoloAeroporto as va on v.OID = va.volo 
                    WHERE va.aeroportoPartenza = '$partenza' AND va.aeroportoArrivo = '$destinazione' 
                        AND DATE(v.dataOraPartenza) = '$data'
                        AND $nPosti < (SELECT count(*) from VoloPosto where volo = v.OID)";
        $stmt = $this->connection->query($query);
        $lista = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //per ogni riga creo un oggetto generico
            $obj = (object)($row);
            array_push($lista,$obj);
        }

        $listaVoli = array();
        foreach ($lista as $el){
            array_push($listaVoli,$this->objectToObject($el,"Volo")); //eseguo il cast dell'oggetto generico
        }

        return $listaVoli;

    }

    //Modifico direttamente la get richiamando quella del padre


}