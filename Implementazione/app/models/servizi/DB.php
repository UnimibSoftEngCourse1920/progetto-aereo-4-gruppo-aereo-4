<?php

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

    public function getFedeltaUltimaPrenotazione($anni){
        //select * from prenot join cliente WHERE (clienteFedelta) and OIDCli not in (SELECT codcli from pr where diff(today, data)>= $anni)
        //ritorna lista di clienti da aggiornare
        return array();
    }

    public function checkPrenotazioneUnivoca($email,$codVolo){
        $query = "SELECT * from PRENOTAZIONE WHERE EMAIL = '$email' and CODVOLO ='$codVolo' ";
        $result = $this->connection -> query($query);
        return  $result->rowCount() == 0;
    }

    public function salvaPrenotazione($prenotazione){
        $sql = "INSERT INTO PRENOTAZIONE (firstname, lastname, email) VALUES ('John', 'Doe', 'john@example.com')";
        // use exec() because no results are returned
        $this->connection->exec($sql);
        $id = $this->connection->lastInsertId();
        return $id;
    }

    public function getClientiFedelta(){
        //ritorna lista clienti fedelta
        return array();
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





