<?php


//use PDO;

require_once("AbstractDB.php");


class PrenotazioneDB extends AbstractDB
{
    public function get($OID, $class){
        $prenotazione = parent::get($OID, $class);
        $this->setCliente($prenotazione);
        $this->setVolo($prenotazione);
        $this->setPosti($prenotazione);
        $this->setBiglietti($prenotazione);
        $this->setAcquisti($prenotazione);
        return $prenotazione;
    }

    //TODO fare getAll sulla falsariga di getPrenotazioniCliente(così utilizzo solo una volta le set ecc...)

    //TODO faccio la join direttamente nella generateGetQuery così da no dover chiamare la setXX anche sui campi singoli ù(Cioè anche dove non serve)

    private function setCliente(Prenotazione $prenotazione){
        $query = sprintf("Select cliente from PrenotazioneCliente where prenotazione = '%s'", $prenotazione->getOID());
        $cliente = $this->connection->query($query)->fetch()[0];
        $prenotazione->setCliente($cliente);
    }

    private function setVolo(Prenotazione $prenotazione){
        $query = sprintf("Select volo from PrenotazioneVolo where prenotazione = '%s'", $prenotazione->getOID());
        $volo = $this->connection->query($query)->fetch()[0];
        $prenotazione->setVolo($volo);
    }

    private function setPosti(Prenotazione $prenotazione){
        $query = sprintf("Select posto from PrenotazionePosto where prenotazione = '%s'", $prenotazione->getOID());
        $posti = $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
        $prenotazione->setListaPosti($posti);
    }

    private function setBiglietti(Prenotazione $prenotazione){
        $query = sprintf("Select biglietto from PrenotazioneBiglietto where prenotazione = '%s'", $prenotazione->getOID());
        $biglietti = $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
        $prenotazione->setListaBiglietti($biglietti);
    }

    private function setAcquisti(Prenotazione $prenotazione){
        $query = sprintf("Select acquisto from PrenotazioneAcquisto where prenotazione = '%s'", $prenotazione->getOID());
        $acquisti = $this->connection->query($query)->fetchAll(PDO::FETCH_COLUMN, 0);
        $prenotazione->setListaAcquisti($acquisti);
    }

    protected function generatePutQuery($obj){
        $query = sprintf("INSERT INTO Prenotazione VALUES ('%s', '%s', '%s');",$obj->getOID(), $obj->getData(), $obj->getTariffa());
        $query .= sprintf("INSERT INTO PrenotazioneCliente VALUES ('%s', '%s');", $obj->getOID(), $obj->getCliente()->getOID());
        $query .= sprintf("INSERT INTO PrenotazioneVolo VALUES ('%s', '%s');", $obj->getOID(), $obj->getVolo()->getOID());

        foreach($obj->getListaBiglietti() as $biglietto)
            $query .= sprintf("INSERT INTO PrenotazioneBiglietto VALUES ('%s', '%s');", $obj->getOID(), $biglietto->getOID());

        foreach($obj->getListaPosti() as $posto)
            $query .= sprintf("INSERT INTO PrenotazionePosto VALUES ('%s', '%s');", $obj->getOID(), $posto->getOID());

        foreach($obj->getListaAcquisti() as $acquisto)
            $query .= sprintf("INSERT INTO PrenotazioneAcquisto VALUES ('%s', '%s');", $obj->getOID(), $acquisto->getOID());

        return $query;
    }

    protected function generateUpdateQuery($obj){
        //Potrebbe non servire controllare la materializzazione qui

        $query = sprintf("UPDATE PrenotazioneVolo  SET volo = '%s' where OID = '%s';", $obj->getVolo()->getOID() ,$obj->getOID());

        foreach($obj->getListaBiglietti() as $biglietto)
            $query .= sprintf("UPDATE PrenotazioneBiglietto SET biglietto = '%s' where OID = '%s';", $biglietto->getOID(), $obj->getOID());

        foreach($obj->getListaPosti() as $posto)
            $query .= sprintf("UPDATE PrenotazionePosto SET posto = '%s' where OID = '%s';", $posto->getOID(), $obj->getOID());

        foreach($obj->getListaAcquisti() as $acquisto)
            $query .= sprintf("UPDATE PrenotazioneAcquisto  SET acquisto = '%s' where OID = '%s';",$acquisto->getOID() ,$obj->getOID());
    }

    protected function generateDeleteQuery($OID, $class)
    {
        $query = "DELETE FROM Prenotazione WHERE OID = $OID; 
                    DELETE FROM PrenotazioneCliente WHERE prenotazione = $OID; 
                    DELETE FROM PrenotazioneVolo WHERE prenotazione = $OID;
                    DELETE FROM PrenotazionePosto WHERE prenotazione = $OID;
                    DELETE FROM PrenotazioneBiglietto WHERE prenotazione = $OID;";
        return $query;
    }

    public function getScadute($ore){
        $query = "select * from Prenotazione as p JOIN volo as v where p.OID NOT IN (select OID from PrenotazioneAcquisto) AND TIMESTAMPDIFF(HOUR, v.dataora, NOW()) >= '$ore'";
        $stmt = $this->connection->query($query);
        $listaPrenotazioni = $stmt->fetchAll(PDO::FETCH_CLASS, "Prenotazione");
        return $listaPrenotazioni;
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
        $query = "select c.OID,max(data) from Prenotazione p JOIN PrenotazioneCliente pc JOIN Cliente c on p.OID=pc.prenotazione and c.OID = pc.cliente where c.codiceFedelta is not null group by c.OID;";
        $stmt = $this->connection->query($query);
        $stmt->bindColumn(1, $OIDCliente);
        $stmt->bindColumn(2, $data);
        while($cli = $stmt->fetch(PDO::FETCH_BOUND))
        {
            $result[] = array($OIDCliente, $data);
        }
        return $result;
        //select * from prenot join cliente WHERE (clienteFedelta) and OIDCli not in (SELECT codcli from pr where diff(today, data)>= $anni)
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