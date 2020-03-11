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

    public function getUltimoCodiceFedelta(){
        //TODO: metodo di Omar??
        $query = "select IFNULL(max(codiceFedelta), 'F0') from Cliente;";
        $result = $this->connection->query($query)->fetch();
        return $result[0];
    }


}