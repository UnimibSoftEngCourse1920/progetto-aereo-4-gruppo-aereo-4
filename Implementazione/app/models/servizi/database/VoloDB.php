<?php


//namespace model\servizi;
require_once "AbstractDB.php";

class VoloDB extends AbstractDB
{

    protected function generatePutQuery($obj){

        $promozione = $obj.getPromozione()!=null ? $obj->getPromozione().getOID() : null;
        
        $query = sprintf("INSERT INTO Volo VALUES ('%s','%s','%s','%s','%s','%s','%s'); ",
                        $obj->getOID(),$obj->getDataOraPartenza(),$obj->getDataOraArrivo(),$obj->getStato(), $obj->getMiglia(), $obj->getAereo().getOID(), $promozione);

        //VoloAereoporto
        $query .= sprintf("Insert into VoloAereoporto values ('%s', '%s', '%s' ); ", $obj->getOID(), $obj->getAereoportoPart()->getOID(), $obj->getAereoportoArrivo()->getOID());

        //VoloPosto
        foreach ($obj->getPosti() as $posto)
            $query .= sprintf("INSERT INTO VoloPosto values ('%s', '%s')", $obj->getOID(), $posto->getOID());

        return $query;
    }

    protected function generateUpdateQuery($object){
        return sprintf("UPDATE ".get_class($object)." SET stato = '%s', dataOraPartenza='%s', dataOraArrivo='%s' WHERE OID = '%s'",
                    $object->getStato(), $object->getDataOraPartenza(), $object->getDataOraArrivo(), $object->getOID() );
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
}