<?php


//TODO perchè queste??
require_once "../app/models/volo/Aeroporto.php";
require_once "../app/models/volo/Aereo.php";
require_once "../app/models/volo/Volo.php";


abstract class AbstractDB
{
    protected $connection;

    public function __construct(){
        try {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $pdo_options[PDO::ATTR_PERSISTENT] = true;
            $this->connection = new PDO('mysql:host=localhost;dbname=id12704943_compagniaaerea' , 'id12704943_sa', '4dm1n', $pdo_options);
        }
        catch (Exception $e)
        {
            die('Error : ' . $e->getMessage());
        }
    }

    public function get($OID, $class){
        $query = $this->generateGetQuery($OID,$class); //creo la query
        $stmt = $this->connection->query($query); //la eseguo
        return $this->fetchSingleByClass($stmt, $class);
    }

    protected function fetchSingleByClass($stmt, $class){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);//per ogni riga creo un oggetto generico
        $obj = (object)($row);
        return $this->objectToObject($obj,$class); //eseguo il cast dell'oggetto generico
    }

    public function delete($OID, $class){
        $res = $this->connection->exec($this->generateDeleteQuery($OID, $class));
        return !($res==0);
    }

    public function update($object){
        $res = $this->connection->exec($this->generateUpdateQuery($object));
        return !($res==0);
    }

    public function put($object){
        $res = $this->connection->exec($this->generatePutQuery($object));
        return !($res==0);
    }

    public function getAll($class){
        $query = $this->generateGetAllQuery($class); //creo la query
        $stmt = $this->connection->query($query); //la eseguo
        return $this->fetchResultsByClass($stmt, $class);
    }

    protected function fetchResultsByClass($stmt, $class){
        $lista = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ //per ogni riga creo un oggetto generico
            $obj = (object)($row);
            array_push($lista,$obj);
        }
        $listaDef = array();
        foreach ($lista as $el){
            array_push($listaDef,$this->objectToObject($el,$class)); //eseguo il cast dell'oggetto generico
        }
        return $listaDef;
    }

    protected function objectToObject($instance, $className) {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }

    //Metodi hook

    protected function generateGetQuery($OID, $class){
        return "SELECT * FROM " . $class . " WHERE OID = '" . $OID . "'";
    }

    //TODO da rivedere
    protected function generatePutQuery($object){ return '';}

    protected function generateUpdateQuery($posto){ return '';}

    protected function generateDeleteQuery($OID, $class){
        return "DELETE FROM ".$class." WHERE OID ='".$OID."'";
    }

    protected function generateGetAllQuery($class){
        return "SELECT * from ".$class;
    }

}