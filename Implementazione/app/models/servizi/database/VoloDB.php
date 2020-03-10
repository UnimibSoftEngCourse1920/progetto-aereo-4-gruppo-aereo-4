<?php


//namespace model\servizi;
require_once "AbstractDB.php";

class VoloDB extends AbstractDB
{

    protected function generatePutQuery($obj){

        $promozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
        
        $query = sprintf("INSERT INTO Volo VALUES ('%s','%s','%s','%s','%s','%s', '%s'); ",
                        $obj->getOID(),$obj->getDataOraPartenza(),$obj->getDataOraArrivo(),$obj->getStato(), $obj->getMiglia(), $obj->getAereo()->getOID(), $promozione);
        //VoloAeroporto
        $query .= sprintf("Insert into VoloAeroporto values ('%s', '%s', '%s' ); ", $obj->getOID(), $obj->getAeroportoPartenza()->getOID(), $obj->getAeroportoDestinazione()->getOID());
        //VoloPosto
        foreach ($obj->getPosti() as $posto)
            $query .= sprintf("INSERT INTO VoloPosto values ('%s', '%s')", $obj->getOID(), $posto->getOID());
        return $query;
    }

    protected function generateUpdateQuery($obj){
        $OIDpromozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
        return sprintf("UPDATE ".get_class($obj)." SET stato = '%s', dataOraPartenza='%s', dataOraArrivo='%s' , promozione = '$OIDpromozione' WHERE OID = '%s'",
                    $obj->getStato(), $obj->getDataOraPartenza(), $obj->getDataOraArrivo(), $OIDpromozione, $obj->getOID() );
    }

    protected function generateGetQuery($OID, $class)
    {
        return "SELECT * from Volo v join VoloAeroporto va on v.OID = va.volo WHERE v.OID = '$OID'";
    }

    protected function generateGetAllQuery($class)
    {
        return "SELECT * from Volo v join VoloAeroporto va on v.OID = va.volo";
    }

    public function get($OID, $class){
        $volo = parent::get($OID, $class);
        //$this->setAereoporti($volo);
        $this->setPosti($volo);
        //setPromozione non serve perchè promo è attributo
        return $volo;
    }

    private function DEPRECATO_setAereoporti(Volo $volo){
        $query = sprintf("Select aeroportoPartenza, aeroportoDestinazione from VoloAeroporto where volo='%s'", $volo->getOID());
        $aereoporti = $this->connection->query($query)->fetch();
        //TODO: controlli
        $volo->setAeroportoPartenza($aereoporti[0]);
        $volo->setAeroportoDestinazione($aereoporti[1]);
    }

    private function setPosti(Volo $volo){
        $query = sprintf("Select posto from VoloPosto where volo='%s'", $volo->getOID());
        $listaPosti = $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
        $volo->setPosti($listaPosti);
    }

    public function cercaVoli($partenza, $destinazione, $data, $nPosti){
        $query = "SELECT v.* from Volo as v JOIN VoloAeroporto as va on v.OID = va.volo 
                    WHERE va.aeroportoPartenza = '$partenza' AND va.aeroportoDestinazioneivo = '$destinazione' 
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

    public function getPasseggeriVolo($OIDVolo){
        //TODO ritorno solamente la mail?
        $query = "select c.* from PrenotazioneVolo pv join Prenotazione p join PrenotazioneCliente pc join Cliente c 
                    on c.OID = pc.cliente and pv.prenotazione = p.OID and pc.prenotazione = p.OID where pv.volo = '$OIDVolo'";
        $stmt = $this->connection->query($query); //la eseguo
        $lista = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //per ogni riga creo un oggetto generico
            $obj = (object)($row);
            array_push($lista,$obj);
        }
        $listaDef = array();
        foreach ($lista as $el){
            array_push($listaDef,$this->objectToObject($el,'Cliente')); //eseguo il cast dell'oggetto generico
        }
        return $listaDef;
    }

    public function isAereoDisponibile($partenza, $arrivo, $OIDAereo){
        $query = "select * from Volo where aereo = '$OIDAereo' and stato= '".Volo::$STATO_ATTIVO."' AND ((dataOraPartenza BETWEEN '$partenza' and '$arrivo') 
                OR (dataOraArrivo BETWEEN '$partenza' and '$arrivo') OR (dataOraPartenza < '$partenza' AND dataOraArrivo > '$arrivo'))";
        $result = $this->connection->query($query);
        return $result->rowCount() == 0;
    }

}