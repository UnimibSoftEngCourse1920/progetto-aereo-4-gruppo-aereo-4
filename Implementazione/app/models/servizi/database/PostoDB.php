<?php


namespace model\servizi;


class PostoDB extends AbstractDB
{
    public function __construct(){
        parent::__construct();
    }

    protected function generateCreateQuery($obj){
        return "INSERT INTO POSTO VALUES ($obj->OID, $obj->stato, $obj->numeroPosto)";
    }

    protected function generateUpdateQuery($object){
        return "UPDATE ".get_class($object)." 
                SET stato = '$object->stato', numeroPosto = '$object->numeroPosto'
                WHERE OID = '$object->OID'";
    }

}
