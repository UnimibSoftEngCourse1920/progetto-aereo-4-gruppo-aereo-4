<?php


namespace model\servizi;


class AereoportoDB extends AbstractDB{

    protected function generatePutQuery($obj){
        return "INSERT INTO Aereoporto 
                VALUES ('$obj->getOID()', '$obj->getContinente()', '$obj->getNazione()', '$obj->getCitta()', '$obj->getNome()')";
    }
}