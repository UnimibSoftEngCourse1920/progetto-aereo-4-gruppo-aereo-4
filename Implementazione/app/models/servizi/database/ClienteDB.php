<?php


namespace model\servizi;

use model\cliente\Cliente;
use model\cliente\ClienteFedelta;


class ClienteDB extends AbstractDB
{

    public function get($OID){
        $query = "Select * from Cliente where OID = '$OID'";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        
    }

    public function generatePutQuery($object)
    {
        $indirizzo = $codiceFedelta = $stato = $password = null;
        if($object->isClienteFedelta()){
            $indirizzo = $object->getIndirizzo();
            $codiceFedelta = $object-> getCodiceFedelta();
            $stato = $object->getStato();
            $password = $object-> getPassword();
        }

        $query = "INSERT INTO Cliente VALUES($object->getOID(),
                                             $object->getNome(),
                                             $object->getCognome(),
                                             $object->getDataNascita(),
                                             $indirizzo,
                                             $codiceFedelta,
                                             $stato,
                                             $password
                                             $object->getEmail() 
                                             );";
    }

}