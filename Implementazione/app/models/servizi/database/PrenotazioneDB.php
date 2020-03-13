<?php


require_once("AbstractDB.php");


class PrenotazioneDB extends AbstractDB
{
    public function get($OID, $class){
        $prenotazione = parent::get($OID, $class);
        $prenotazione->setListaPosti($this->getAssociazioni("posto", $prenotazione));
        $prenotazione->setListaBiglietti($this->getAssociazioni("biglietto", $prenotazione));
        $prenotazione->setListaAcquisti($this->getAssociazioni("acquisto", $prenotazione));
        return $prenotazione;
    }

    private function getAssociazioni($nomeClasseAssociata, $prenotazione){
        $name = ucfirst(strtolower($nomeClasseAssociata));
        $query = sprintf("Select $name from Prenotazione$name where prenotazione = '%s'", $prenotazione->getOID());
        return $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    protected function generateGetQuery($OID, $class)
    {
        //Prendo anche cliente e Volo associati
        return "select p.*,pv.volo,pc.cliente from Prenotazione p join PrenotazioneVolo pv join PrenotazioneCliente pc 
                on p.OID = pv.prenotazione and p.OID=pc.prenotazione WHERE p.OID = '$OID'";
    }

    protected function generatePutQuery($obj)
    {
        $query = sprintf("INSERT INTO Prenotazione VALUES ('%s', '%s', '%s');", $obj->getOID(), $obj->getData());
        $query .= sprintf("INSERT INTO PrenotazioneCliente VALUES ('%s', '%s');", $obj->getOID(), $obj->getCliente()->getOID());
        $query .= sprintf("INSERT INTO PrenotazioneVolo VALUES ('%s', '%s');", $obj->getOID(), $obj->getVolo()->getOID());

        foreach ($obj->getListaBiglietti() as $biglietto) {
            $query .= sprintf("INSERT INTO PrenotazioneBiglietto VALUES ('%s', '%s');", $obj->getOID(), $biglietto->getOID());
        }
        foreach ($obj->getListaPosti() as $posto) {
            $query .= sprintf("INSERT INTO PrenotazionePosto VALUES ('%s', '%s');", $obj->getOID(), $posto->getOID());
        }
        foreach($obj->getListaAcquisti() as $acquisto) {
            $query .= sprintf("INSERT INTO PrenotazioneAcquisto VALUES ('%s', '%s');", $obj->getOID(), $acquisto->getOID());
        }
        return $query;
    }

    protected function generateUpdateQuery($obj){
        //Potrebbe non servire controllare la materializzazione qui

        $query = sprintf("UPDATE PrenotazioneVolo  SET volo = '%s' where prenotazione = '%s';", $obj->getVolo()->getOID() ,$obj->getOID());

        foreach($obj->getListaBiglietti() as $biglietto) {
            $query .= sprintf("UPDATE PrenotazioneBiglietto SET biglietto = '%s' where prenotazione = '%s';", $biglietto->getOID(), $obj->getOID());
        }
        foreach($obj->getListaPosti() as $posto) {
            $query .= sprintf("UPDATE PrenotazionePosto SET posto = '%s' where prenotazione = '%s';", $posto->getOID(), $obj->getOID());
        }
        foreach($obj->getListaAcquisti() as $acquisto) {
            $query .= sprintf("INSERT IGNORE into PrenotazioneAcquisto  values('%s','%s');", $obj->getOID(), $acquisto->getOID());
        }
        return $query;
    }

    protected function generateDeleteQuery($OID, $class)
    {
        //TODO dovrei cancellare anche i biglietti
        $query = "DELETE FROM Prenotazione WHERE OID = $OID; 
                    DELETE FROM PrenotazioneCliente WHERE prenotazione = $OID; 
                    DELETE FROM PrenotazioneVolo WHERE prenotazione = $OID;
                    DELETE FROM PrenotazionePosto WHERE prenotazione = $OID;
                    DELETE FROM PrenotazioneBiglietto WHERE prenotazione = $OID;";
        return $query;
    }

    public function getScadute($ore){
        $query = "select p.OID, v.*, TIMESTAMPDIFF(HOUR, NOW(), v.dataOraPartenza) from Prenotazione as p JOIN Volo as v JOIN PrenotazioneVolo pv 
                    on p.OID = pv.prenotazione and pv.volo = v.OID where TIMESTAMPDIFF(HOUR, NOW(), v.dataOraPartenza) <= '$ore' 
                    AND p.OID NOT IN (select prenotazione from PrenotazioneAcquisto);";
        $stmt = $this->connection->query($query);
        return $this->materializeAll($stmt, Prenotazione::class);
    }

    public function checkUnivoca($email, $OIDVolo)
    {
        $query = "SELECT * from Prenotazione p JOIN PrenotazioneCliente as pc JOIN Cliente as c JOIN PrenotazioneVolo as pv on c.OID=pc.cliente and p.OID = pc.prenotazione and pv.prenotazione=p.OID
                    WHERE c.email = '$email' and  pv.volo='$OIDVolo' and p.OID NOT IN (select OID from PrenotazioneAcquisto)";
        $result = $this->connection->query($query);
        return $result->rowCount() == 0;
    }

    public function getFedeltaUltimaPrenotazione(){
        //Per ogni codice fedeltà, ritorna l'ultima prenotazione effettuata
        $result = array();
        $query = "select c.OID,max(data) from Prenotazione p JOIN PrenotazioneCliente pc JOIN Cliente c 
                    on p.OID=pc.prenotazione and c.OID = pc.cliente where c.codiceFedelta is not null group by c.OID;";
        $stmt = $this->connection->query($query);
        $stmt->bindColumn(1, $OIDCliente);
        $stmt->bindColumn(2, $data);
        while($cli = $stmt->fetch(PDO::FETCH_BOUND))
        {
            $result[] = array($OIDCliente, $data);
        }
        return $result;
    }

    public function getPrenotazioniCliente($OID, $soloAcquistate){
        //TODO guardo se funziona
        $prenotazioni = array();
        if($soloAcquistate) {
            $query = "select prenotazione from PrenotazioneCliente where cliente = '$OID'";
        } else{
            $query = "select p.OID from PrenotazioneCliente pc join Prenotazione p join PrenotazioneAcquisto a on p.OID = pc.cliente and p.OID = a.prenotazione WHERE pc.cliente='$OID';";
        }
        $codiciPrenotazioni = $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
        foreach ($codiciPrenotazioni as $OID){
            $prenotazioni[] = $this->get($OID, Prenotazione::class);
        }
        return $prenotazioni;
    }
}