<?php


namespace model\servizi;

use model\cliente\ClienteFedelta;
use PDO;


class DB{
    private $connection;
    private static $instance = null;

    private function __construct(){
        //si connette al DB
        $this->connection = new PDO('dblib:host=your_hostname;dbname=your_db;charset=UTF-8', 'user', 'pass');
    }

    public static function getIstance(){
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function emailFedeltaExists($email){
        $query = "SELECT * from CLIENTE WHERE EMAIL = '$email' and codiceFedelta is not null ";
        $result = $this->connection -> query($query);
        return  $result->rowCount() == 0;
    }

    //Operazioni CRUD

    public function update($object){
        return null;
    }

    public function put($object){
    return 'esito';
    }

    public function get($object){
        return new ClienteFedelta();
    }

}





