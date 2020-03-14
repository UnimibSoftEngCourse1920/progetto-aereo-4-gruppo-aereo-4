<?php

require_once("AbstractDB.php");

class ClienteDB extends AbstractDB
{
    public function generatePutQuery($cliente)
    {
        return sprintf("INSERT INTO Cliente VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s',%d);",
            $cliente->getOID(), $cliente->getNome(), $cliente->getCognome(), $cliente->getDataNascita(), $cliente->getIndirizzo(),
            $cliente->getCodiceFedelta(), $cliente->getStato(), $cliente->getPassword(), $cliente->getEmail(), $cliente->getSaldoPunti());
    }

    public function generateUpdateQuery($cliente)
    {
        $query = "update Cliente set saldoPunti = %d, indirizzo='%s', stato='%s',password='%s',codiceFedelta='%s' where OID = '%s'";
        return sprintf($query, $cliente->getSaldoPunti(), $cliente->getIndirizzo(), $cliente->getStato(),
                               $cliente->getPassword(), $cliente->getCodiceFedelta(), $cliente->getOID());
    }

    public function emailFedeltaExists($email){
        $query = "SELECT * from Cliente WHERE email = '$email' and codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return ($stmt->rowCount() > 0);
    }

    public function login($email, $password){
        $query = "SELECT * from Cliente where email = '$email' and password='$password'  and codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return $this->fetchSingleByClass($stmt, Cliente::class);
    }

    public function getClientiFedelta(){
        $query = "SELECT * FROM CLIENTE WHERE codiceFedelta is null";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Cliente::class);
    }

    public function getAllFedelta(){
        $query = "Select * from Cliente where codiceFedelta is not null";
        $stmt = $this->connection->query($query);
        return $this->fetchResultsByClass($stmt, Cliente::class);
    }


}