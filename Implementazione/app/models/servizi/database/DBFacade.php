<?php


namespace model\servizi;


class DBFacade{
    private static $instance = null;

    private $gestori = array();


    private function __construct(){
        $cli = new ClienteDB();
        $gestori['Cliente'] = $cli;
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
        $esito = $this -> gestori[get_class($object)] -> update($object);
    }

    public function create($object){
        $esito = $this -> gestori[get_class($object)] -> put($object);
    }

    public function read($OID, $class){
        $returnObject = $this -> gestori[$class]->get($OID);
        return $returnObject;
    }

}





