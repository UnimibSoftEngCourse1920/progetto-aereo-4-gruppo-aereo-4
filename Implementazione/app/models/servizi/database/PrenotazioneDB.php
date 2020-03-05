<?php


namespace model\servizi;
require_once("AbstractDB.php");


class PrenotazioneDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        $query = sprintf("INSERT INTO Prenotazione VALUES ('%s', '%s')",$obj->getOID(), $obj->getData());
        $query .= sprintf("INSERT INTO PrenotazioneCliente VALUES ('%s', '%s');", $obj->getOID(), $obj->getCliente()->getOID());
        $query .= sprintf("INSERT INTO PrenotazioneVolo VALUES ('%s', '%s');", $obj->getOID(), $obj->getVolo()->getOID());

        foreach($obj->getBiglietti() as $biglietto)
            $query .= sprintf("INSERT INTO PrenotazioneBiglietto VALUES ('%s', '%s');", $obj->getOID(), $biglietto->getOID());

        foreach($obj->getPosti() as $posto)
            $query .= sprintf("INSERT INTO PrenotazionePosto VALUES ('%s', '%s');", $obj->getOID(), $posto->getOID());

        foreach($obj->getAcquisti() as $acquisto)
            $query .= sprintf("INSERT INTO PrenotazioneAcquisto VALUES ('%s', '%s');", $obj->getOID(), $acquisto->getOID());

        return $query;
    }

    protected function generateUpdateQuery($obj){
        $query = sprintf("UPDATE PrenotazioneVolo  SET volo = '%s' where OID = '%s';", $obj->getVolo()->getOID() ,$obj->getOID());

        foreach($obj->getBiglietti() as $biglietto)
            $query .= sprintf("UPDATE PrenotazioneBiglietto SET biglietto = '%s' where OID = '%s';", $biglietto->getOID(), $obj->getOID());

        foreach($obj->getPosti() as $posto)
            $query .= sprintf("UPDATE PrenotazionePosto SET posto = '%s' where OID = '%s';", $posto->getOID(), $obj->getOID());

        foreach($obj->getAcquisti() as $acquisto)
            $query .= sprintf("UPDATE PrenotazioneAcquisto  SET acquisto = '%s' where OID = '%s';",$acquisto->getOID() ,$obj->getOID());
    }
}