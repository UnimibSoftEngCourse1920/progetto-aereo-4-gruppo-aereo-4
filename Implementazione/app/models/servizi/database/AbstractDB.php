<?php


//namespace model\servizi;

//use PDO;
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Aereoporto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Aereo.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/Volo.php";


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
        /*$stmt = $this->connection->prepare($this->generateGetQuery($OID,$class)); //manca la query
        //template method
        $stmt->execute();
        $stmt -> setFetchMode(PDO::FETCH_CLASS, $class);
        return $obj = $stmt->fetchAll(); */
        $query = $this->generateGetQuery($OID,$class); //creo la query
        $stmt = $this->connection->query($query); //la eseguo
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

    public function getAll($class){
        $query = $this->generateGetAllQuery($class); //creo la query
        $stmt = $this->connection->query($query); //la eseguo
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

    protected function getClassName($object){
        return get_class($object);
    }

    //Metodi hook
    //Sono comunque stati definiti qui perchè per molte operazioni il comportamento è comune per tutti (es. delete)

    protected function generateGetQuery($OID, $class){
        return "SELECT * FROM " . $class . " WHERE OID = '" . $OID . "'";
    }

    protected function generatePutQuery($object){
        return '';
    }

    protected function generateUpdateQuery($object){ return '';}

    protected function generateDeleteQuery($OID, $class){
        return "DELETE FROM ".$class." WHERE OID ='".$OID."'";
    }

    protected function generateGetAllQuery($class){
        return "SELECT * from ".$class;
    }

    protected function objectToObject($instance, $className) {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }
}