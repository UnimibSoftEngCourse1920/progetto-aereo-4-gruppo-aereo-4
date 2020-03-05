<?php


namespace model\servizi;

use PDO;


abstract class AbstractDB
{
    protected $connection;

    public function __construct(){
        try {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $this->connection = new PDO('mysql:host=localhost;dbname=id12704943_compagniaaerea' , 'id12704943_sa', '4dm1n', $pdo_options);
        }
        catch (Exception $e)
        {
            die('Error : ' . $e->getMessage());
        }
    }

    public function get($OID, $class){
        //Ad ora non vale per cliente

        $stmt = $this->connection->prepare($this->generateGetQuery()); //manca la query
        //template method
        $stmt->execute();
        $stmt -> setFetchMode(PDO::FETCH_CLASS, $class);
        return $obj = $stmt->fetchAll();
    }

    public function delete($OID, $class){
        $result = $this->connection->exec($this->generateDeleteQuery($OID, $class));
        return $result;
    }

    public function update($object){
        $result = $this->connection->exec($this->generateUpdateQuery($object));
        return $result;
    }

    public function put($object){
        $result = $this->connection->exec($this->generatePutQuery($object));
        return $result;
    }

    protected function getClassName($object){
        return substr(strrchr(get_class($object), "\\"), 1);
    }

    //Metodi hook
    //Sono comunque stati definiti qui perchè per molte operazioni il comportamento è comune per tutti (es. delete)

    protected function generateGetQuery($OID, $class){
        return "SELECT * FROM " . $class . " WHERE OID = '" . $OID . "'";
    }

    protected function generatePutQuery($object){ return '';}

    protected function generateUpdateQuery($object){ return '';}

    protected function generateDeleteQuery($OID, $class){
        return "DELETE FROM ".$class." WHERE OID ='".$OID."'";
    }
}