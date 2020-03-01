<?php


namespace model\servizi;


class PrenotazioneDB extends AbstractDB
{
    protected function generateCreateQuery($obj){
        return "INSERT INTO PRENOTAZIONE VALUES ($obj->OID, $obj->data, $obj->stato)";
    }

    protected function generateUpdateQuery($object){
        return "UPDATE ".get_class($object)." 
                SET stato = '$object->stato', data = '$object->data'
                WHERE OID = '$object->OID'";
    }
}