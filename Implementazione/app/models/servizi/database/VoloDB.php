<?php


require_once "AbstractDB.php";


class VoloDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "";
        $promozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
       /*
        //E' stato fatto direttamente in inserimentoVolo
        foreach ($obj->getPosti() as $posto){
            $query .= sprintf("INSERT INTO Posto VALUES ('%s',%b ,%d )", $posto->getOID(), $posto->isStato(), $posto->getNumeroPosto());
        }
        */
        $query .= sprintf("INSERT INTO Volo VALUES ('%s','%s','%s','%s','%s','%s', '%s'); ",
                        $obj->getOID(),$obj->getDataOraPartenza(),$obj->getDataOraArrivo(),$obj->getStato(), $obj->getMiglia(), $obj->getAereo()->getOID(), $promozione);
        //VoloAeroporto
        $query .= sprintf("Insert into VoloAeroporto values ('%s', '%s', '%s' ); ", $obj->getOID(), $obj->getAeroportoPartenza()->getOID(), $obj->getAeroportoDestinazione()->getOID());
        //VoloPosto
        foreach ($obj->getPosti() as $posto) {
            $query .= sprintf("INSERT INTO VoloPosto values ('%s', '%s');", $obj->getOID(), $posto->getOID());
        }
        return $query;
    }

    protected function generateUpdateQuery($obj){
        $OIDpromozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
        $var =  sprintf("UPDATE ".get_class($obj)." SET stato = '%s', dataOraPartenza='%s', dataOraArrivo='%s' , promozione = '%s' WHERE OID = '%s'",
                    $obj->getStato(), $obj->getDataOraPartenza(), $obj->getDataOraArrivo(), $OIDpromozione, $obj->getOID() );
        return $var;
    }

    protected function generateGetQuery($OID, $class)
    {
        return $this->generateGetAllQuery() ." WHERE v.OID = '$OID'";
        //return "SELECT v.*, va.aeroportoPartenza, va.aeroportoArrivo from Volo v join VoloAeroporto va on v.OID = va.volo WHERE v.OID = '$OID'";
    }

    protected function generateGetAllQuery($class)
    {
        return "SELECT va.aeroportoPartenza, va.aeroportoArrivo from Volo v join VoloAeroporto va on v.OID = va.volo";
    }

    public function get($OID, $class){
        $volo = parent::get($OID, $class);
        $volo->setPosti($this->getAssociazioni("posto", $volo));
        return $volo;
    }

    private function getAssociazioni($nomeClasseAssociata, $volo){
        $name = ucfirst(strtolower($nomeClasseAssociata));
        $query = sprintf("Select $name from Volo$name where volo = '%s'", $volo->getOID());
        return $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function cercaVoli($partenza, $destinazione, $data, $nPosti){
        $query = "SELECT v.*, va.aeroportoPartenza, va.aeroportoDestinazione from Volo as v JOIN VoloAeroporto as va on v.OID = va.volo 
                    WHERE va.aeroportoPartenza = '$partenza' AND va.aeroportoDestinazione = '$destinazione' 
                        AND DATE(v.dataOraPartenza) = '$data'
                        AND v.stato <> '".Volo::$STATO_CANCELLATO."'
                        AND $nPosti < (SELECT count(*) from VoloPosto where volo = v.OID)";
        $stmt = $this->connection->query($query);
        return $this->materializeAll($stmt, "Volo");
    }

    public function getPasseggeriVolo($OIDVolo){
        //TODO ritorno solamente la mail?
        $query = "select c.* from PrenotazioneVolo pv join Prenotazione p join PrenotazioneCliente pc join Cliente c 
                    on c.OID = pc.cliente and pv.prenotazione = p.OID and pc.prenotazione = p.OID where pv.volo = '$OIDVolo'";
        $stmt = $this->connection->query($query); //la eseguo
        return $this->materializeAll($stmt, 'Cliente');
    }

    public function isAereoDisponibile($partenza, $arrivo, $OIDAereo){
        $query = "select * from Volo where aereo = '$OIDAereo' and stato <> '".Volo::$STATO_CANCELLATO."' AND ((dataOraPartenza BETWEEN '$partenza' and '$arrivo') 
                OR (dataOraArrivo BETWEEN '$partenza' and '$arrivo') OR (dataOraPartenza < '$partenza' AND dataOraArrivo > '$arrivo'))";
        $result = $this->connection->query($query);
        return $result->rowCount() == 0;
    }
}