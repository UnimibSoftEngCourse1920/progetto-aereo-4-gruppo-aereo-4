<?php

require_once("AbstractDB.php");

class ClienteDB extends AbstractDB
{
    public function generatePutQuery($cliente)
    {
        $query = sprintf("INSERT INTO Cliente VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s');",
            $cliente->getOID(), $cliente->getNome(), $cliente->getCognome(), $cliente->getDataNascita(), $cliente->getIndirizzo(),
                  $cliente->getCodiceFedelta(), $cliente->getStato(), $cliente->getPassword(), $cliente->getEmail());
        return $query;
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
        return $this->objectToObject($obj, "Cliente");
    }

    public function getClientiFedelta(){
        $query = "SELECT * FROM CLIENTE WHERE codiceFedelta is null";
        $stmt = $this->connection->query($query);
        $lista = $stmt->fetchAll(PDO::FETCH_CLASS, "Cliente");
        return $lista;
    }

    public function getAllFedelta(){
        //TODO Fare un modo per filtrare la getAll
        $query = "Select * from Cliente where codiceFedelta is not null";
        $stmt = $this->connection->query($query); //la eseguo
        $lista = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //per ogni riga creo un oggetto generico
            $obj = (object)($row);
            array_push($lista,$obj);
        }
        $listaDef = array();
        foreach ($lista as $el){
            array_push($listaDef,$this->objectToObject($el,Cliente::class)); //eseguo il cast dell'oggetto generico
        }
        return $listaDef;

    }


}