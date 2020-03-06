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
            $password = $object->getPassword();
        }

        $query = "INSERT INTO Cliente VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s');";
        return sprintf($query, $object->getOID(), $object->getNome(), $object->getCognome(), $object->getDataNascita(), $indirizzo, $codiceFedelta, $stato, $password, $object->getEmail());
    }

    public function emailFedeltaExists($email){
        $query = "SELECT * from Cliente WHERE email = '$email' and codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return ($stmt->rowCount() > 0);
    }

    public function login($email, $password){
        $query = "SELECT * from Cliente where email = '$email' and password='$password'  and codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = (object)($row);
        return $this->objectToObject($obj, "ClienteFedelta");
    }

    public function getClientiFedelta(){
        $query = "SELECT * FROM CLIENTE WHERE codiceFedelta is null";
        $stmt = $this->connection->query($query);
        $lista = $stmt->fetchAll(PDO::FETCH_CLASS, "ClienteFedelta");
        return $lista;
    }

    public function getUltimoCodiceFedelta(){
        $query = "select IFNULL(max(codiceFedelta), 'F0') from Cliente;";
        $result = $this->connection->query($query)->fetch();
        return $result[0];
    }

}