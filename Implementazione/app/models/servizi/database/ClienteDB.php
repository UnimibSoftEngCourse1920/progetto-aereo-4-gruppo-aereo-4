<?php


namespace model\servizi;
require_once("AbstractDB.php");

use model\cliente\Cliente;
use model\cliente\ClienteFedelta;


class ClienteDB extends AbstractDB
{

    public function generatePutQuery($object)
    {
        $indirizzo = $codiceFedelta = $stato = $password = null;
        if($this->getClassName($object) == 'ClienteFedelta'){
            $indirizzo = $object->getIndirizzo();
            $codiceFedelta = $object-> getCodiceFedelta();
            $stato = $object->getStato();
            $password = $object-> getPassword();
        }

        $query = "INSERT INTO Cliente VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s');";

        return sprinft($query, $object->getOID(), $object->getNome(), $object->getCognome(), $object->getDataNascita(), $indirizzo, $codiceFedelta, $stato, $password, $object->getEmail());
    }

}