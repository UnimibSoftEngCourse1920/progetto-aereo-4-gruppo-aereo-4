<?php


namespace model\servizi;


class DB{
    private $connection;
    private static $instance = null;

    private function __construct(){
        //si connette al DB
        $this -> connection = new PDO('dblib:host=your_hostname;dbname=your_db;charset=UTF-8', 'user', 'pass');
    }

    public static function getIstance(){
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function emailExists($email){
        //Cerca sul DB se c'è un cliente fedeltà con quella email
        //ritorna boolean
    }

    //Operazioni CRUD

    public function update($object){
        return null;
    }

    public function put($object){

    }

    public function get($object){
        return null;
    }

}





