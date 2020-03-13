<?php


 \database;
require_once("AbstractDB.php");


class ImpiegatoDB
{
    protected function generatePutQuery($obj){
        $query = "INSERT INTO Impiegato VALUES ('%s', '%s', '%s', '%s', '%s')";
        return sprintf($query, $obj->getOID(), $obj->getNome(), $obj->getCognome(), $obj->getUsername(), $obj->getPassword());
    }

    public function login($username, $password){
        $query = "SELECT * from Impiegato where username = '$username' and password='$password'";
        $stmt = $this->connection->query($query);
        return ($stmt->rowCount() > 0);
    }
}