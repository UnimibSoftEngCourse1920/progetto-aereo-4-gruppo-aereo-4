<?php


namespace model\servizi;

//Singleton??
//Static??

class OIDGenerator
{

    //Ogni volta scrivo da qualche parte l'ultimo, così in caso di crash recupero tutto?
    //Per ora è static per semplicità. è da sistemare

    private $date;
    private $seqnumber;

    private static $instance;

    private function __construct(){
        $this->date = date("Ymd");
        $this->seqnumber = 0;
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

        return strval($this->date) . sprintf('%05d', $this->seqnumber);
    }

}