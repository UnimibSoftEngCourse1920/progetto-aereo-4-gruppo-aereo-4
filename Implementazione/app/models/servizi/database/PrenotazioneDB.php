<?php


namespace model\servizi;


class PrenotazioneDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        $query = "INSERT INTO Prenotazione VALUES ('$obj->getOID()', '$obj->getData()');
                  INSERT INTO PrenotazioneCliente VALUES ('$obj->getOID()', '$obj->getCliente()->getOID()');
                  INSERT INTO PrenotazioneVolo VALUES ('$obj->getOID()', '$obj->getVolo()->getOID()');";

        foreach($obj->getBiglietti() as $biglietto)
            $query .= "INSERT INTO PrenotazioneBiglietto VALUES ('$obj->getOID()', '$biglietto->getOID()');";

        foreach($obj->getPosti() as $posto)
            $query .= "INSERT INTO PrenotazionePosto VALUES ('$obj->getOID()', '$posto->getOID()');";

        foreach($obj->getAcquisti() as $acquisto)
            $query .= "INSERT INTO PrenotazioneAcquisto VALUES ('$obj->getOID()', '$acquisto->getOID()');";

        return $query;
    }

    protected function generateUpdateQuery($obj){
        $query = "UPDATE PrenotazioneVolo  SET volo = '$obj->getVolo()->getOID()' where OID = '$obj->getOID()';";

        foreach($obj->getBiglietti() as $biglietto)
            $query .= "UPDATE PrenotazioneBiglietto SET biglietto = '$biglietto->getOID()' where OID = '$obj->getOID()';";

        foreach($obj->getPosti() as $posto)
            $query .= "UPDATE PrenotazionePosto SET posto = '$posto->getOID()' where OID = '$obj->getOID()';";

        foreach($obj->getAcquisti() as $acquisto)
            $query .= "UPDATE PrenotazioneAcquisto  SET biglietto = '$acquisto->getOID()' where OID = '$obj->getOID()';";
    }
}