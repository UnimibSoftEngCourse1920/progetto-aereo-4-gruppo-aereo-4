<?php


//namespace model\servizi;
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

    public function emailFedeltaExists($email){
        $query = "SELECT * from CLIENTE WHERE EMAIL = '$email' and codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return ($stmt->rowCount() > 0);
    }

    public function login($email, $password){
        $query = "SELECT * from Impiegato where email = '$email' and password='$password'";
        $stmt = $this->connection->query($query);
        return ($stmt->rowCount() > 0);
    }

    public function getClientiFedelta(){
        $query = "SELECT * FROM CLIENTE WHERE codiceFedelta is null";
        $stmt = $this->connection->query($query);
        $lista = $stmt->fetchAll(PDO::FETCH_CLASS, "ClienteFedelta");
        return $lista;
    }

}