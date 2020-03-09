<?php


//namespace model\servizi;
require_once "AbstractDB.php";

class VoloDB extends AbstractDB
{

    protected function generatePutQuery($obj){

        $promozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
        
        $query = sprintf("INSERT INTO Volo VALUES ('%s','%s','%s','%s','%s','%s'); ",
                        $obj->getOID(),$obj->getDataOraPartenza(),$obj->getDataOraArrivo(),$obj->getStato(), $obj->getMiglia(), $obj->getAereo()->getOID());

        //VoloAereoporto
        $query .= sprintf("Insert into VoloAereoporto values ('%s', '%s', '%s' ); ", $obj->getOID(), $obj->getAeroportoPartenza()->getOID(), $obj->getAeroportoDestinazione()->getOID());

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
        $query = sprintf("Select aereoportoPartenza, aereoportoDestinazione from VoloAereoporto where volo='%s'", $volo->getOID());
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
        $query = "SELECT v.* from Volo as v JOIN VoloAereoporto as va on v.OID = va.volo 
                    WHERE va.aereoportoPartenza = '$partenza' AND va.aereoportoArrivo = '$destinazione' 
                        AND DATE(v.dataOraPartenza) = '$data'
                        AND $nPosti < (SELECT count(*) from VoloPosto where volo = v.OID)";

        $stmt = $this->connection->query($query);
        $listaVoli = $stmt->fetchAll(PDO::FETCH_CLASS, "Volo");
        return $listaVoli;

    }

    //Modifico direttamente la get richiamando quella del padre


}