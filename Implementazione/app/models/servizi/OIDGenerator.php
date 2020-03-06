<?php

//Singleton??
//Static??

class OIDGenerator
{

    //Ogni volta scrivo da qualche parte l'ultimo, così in caso di crash recupero tutto?
    //Per ora è static per semplicità. è da sistemare

    private $date;
    private $seqnumber;
    private static $instance;
    private static $fname = "oid.txt";

    private function __construct(){
        $fp = fopen(self::$fname, "w+");
        $oid = fread($fp, 20);

        $this->seqnumber = (substr($oid, 0, 8) == date("Ymd")) ? (substr($oid, 8) + 1) : 1 ;
        $this->date = date("Ymd");

        fclose($fp);
    }

    public static function getIstance(){
        if (!self::$instance) {
            self::$instance = new OIDGenerator();
        }
        return self::$instance;
    }

    public function getNewOID(){
        $today = date("Ymd");
        if($this->date != $today){
            $this->date = $today;
            $this->seqnumber =  0;
        }
        $this->seqnumber += 1;
        $oid = strval($this->date) . sprintf('%05d', $this->seqnumber);

        $fp = fopen(self::$fname, "w+");
        fwrite($fp, $oid);
        fclose($fp);

        return $oid;
    }

}