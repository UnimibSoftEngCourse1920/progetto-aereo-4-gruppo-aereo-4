<?php


namespace model\servizi;

use PDO;


abstract class AbstractDB
{
    protected $connection;

    protected function __construct(){
        //si connette al DB
        $this -> connection = new PDO('dblib:host=your_hostname;dbname=your_db;charset=UTF-8', 'user', 'pass');
    }

    protected function read($OID, $class){
        //Ad ora non vale per cliente

        $stmt = $this->connection->prepare($this->generateReadQuery()); //manca la query
        //template method
        $stmt->execute();
        $stmt -> setFetchMode(PDO::FETCH_CLASS, $class);
        return $obj = $stmt->fetchAll();
    }

    protected function delete($OID, $class){
        $result = $this->connection->exec($this->generateDeleteQuery($OID, $class));
        return $result;
    }

    protected function update($object){
        $result = $this->connection->exec($this->generateUpdateQuery($object));
        return $result;
    }

    protected function create($object){
        $result = $this->connection->exec($this->generateCreateQuery($object));
        return $result;
    }

    //Metodi hook
    //Sono comunque stati definiti qui perchè per molte operazioni il comportamento è comune per tutti (es. delete)

    protected function generateReadQuery($OID, $class){
        return "SELECT * FROM " . $class . " WHERE OID = '" . $OID . "'";
    }

    protected function generateCreateQuery($object){ return '';}

    protected function generateUpdateQuery($object){ return '';}

    protected function generateDeleteQuery($OID, $class){
        return "DELETE FROM ".$class." WHERE OID ='".$OID."'";
    }
}