<?php


require_once "AbstractDB.php";


class VoloDB extends AbstractDB
{
    protected function generatePutQuery($obj){
        $query = "";
        $promozione = $obj->getPromozione()!=null ? $obj->getPromozione()->getOID() : null;
        $query .= sprintf("INSERT INTO Volo VALUES ('%s','%s','%s','%s','%s','%s', '%s', '%s'); ",
                        $obj->getOID(),$obj->getDataOraPartenza(),$obj->getDataOraArrivo(),$obj->getStato(), $obj->getMiglia(), $obj->getAereo()->getOID(), $promozione, $obj->getCodiceVolo());
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
        return sprintf("UPDATE ".get_class($obj)." SET stato = '%s', dataOraPartenza='%s', dataOraArrivo='%s' , promozione = '%s' WHERE OID = '%s'",
                                $obj->getStato(), $obj->getDataOraPartenza(), $obj->getDataOraArrivo(), $OIDpromozione, $obj->getOID() );
    }

    protected function generateGetQuery($OID, $class)
    {
        return $this->generateGetAllQuery(Volo::class) ." and v.OID = '$OID'";
    }

    protected function generateGetAllQuery($class)
    {
        //TODO cercare di usare il parametro della classe Volo
        return "SELECT v.*, va.aeroportoPartenza, va.aeroportoDestinazione from Volo v join VoloAeroporto va on v.OID = va.volo WHERE v.stato != '".Volo::$STATO_CANCELLATO."'";
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
                        AND $nPosti <= (SELECT count(*) FROM VoloPosto vp join Posto p on vp.posto = p.OID WHERE stato = '0' and vp.volo = v.OID)"; 
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Volo::class);
    }

    public function getPasseggeriVolo($OIDVolo){
        $query = "select c.* from PrenotazioneVolo pv join Prenotazione p join PrenotazioneCliente pc join Cliente c 
                    on c.OID = pc.cliente and pv.prenotazione = p.OID and pc.prenotazione = p.OID where pv.volo = '$OIDVolo'";
        $stmt = $this->connection->query($query); //la eseguo
        return $this->fetchResultsByClass($stmt, Cliente::class);
    }

    public function isAereoDisponibile($partenza, $arrivo, $OIDAereo){
        $query = "select * from Volo where aereo = '$OIDAereo' and stato <> '".Volo::$STATO_CANCELLATO."' AND ((dataOraPartenza BETWEEN '$partenza' and '$arrivo') 
                OR (dataOraArrivo BETWEEN '$partenza' and '$arrivo') OR (dataOraPartenza < '$partenza' AND dataOraArrivo > '$arrivo'))";
        $result = $this->connection->query($query);
        return $result->rowCount() == 0;
    }

    public function getVoliConPromozione(){
        $data = date("Y-m-d");
        $query = "select * from Volo where promozione != '' and stato = 'ATTIVO' and dataOraPartenza > '$data'";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Volo::class);
    }
}
