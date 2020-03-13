<?php

require_once("AbstractDB.php");

class ClienteDB extends AbstractDB
{
    public function generatePutQuery($cliente)
    {
        return sprintf("INSERT INTO Cliente VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s');",
            $cliente->getOID(), $cliente->getNome(), $cliente->getCognome(), $cliente->getDataNascita(), $cliente->getIndirizzo(),
            $cliente->getCodiceFedelta(), $cliente->getStato(), $cliente->getPassword(), $cliente->getEmail());
    }

    public function emailFedeltaExists($email){
        $query = "SELECT * from Cliente WHERE email = '$email' and codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return ($stmt->rowCount() > 0);
    }

    public function login($email, $password){
        $query = "SELECT * from Cliente where email = '$email' and password='$password'  and codiceFedelta is not null";
        // TODO migliorare qui
        $stmt = $this->connection->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = (object)($row);
        return $this->objectToObject($obj, "Cliente");
    }

    public function getClientiFedelta(){
        $query = "SELECT * FROM CLIENTE WHERE codiceFedelta is null";
        $stmt = $this->connection->query($query);
        return $this->materializeAll($stmt, Cliente::class);
    }

    public function getAllFedelta(){
        //TODO Fare un modo per filtrare la getAll
        $query = "Select * from Cliente where codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return $this->materializeAll($stmt, Cliente::class);
    }


}