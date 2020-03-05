<?php


namespace model\servizi;

require_once("./database/AcquistoDB.php");
require_once("./database/AereoDB.php");
require_once("./database/AereoportoDB.php");
require_once("./database/BigliettoDB.php");
require_once("./database/ClienteDB.php");
require_once("./database/ImpiegatoDB.php");
require_once("./database/IstitutoDB.php");
require_once("./database/PagamentoDB.php");
require_once("./database/PostoDB.php");
require_once("./database/PrenotazioneDB.php");
require_once("./database/PromozioneDB.php");
require_once("./database/VoloDB.php");


class DBFacade{

    private static $instance = null;
    private $gestori = array();

    private function __construct(){
        //factory ??
        $cli = new ClienteDB();
        $this->gestori['Cliente'] = $cli;
        $this->gestori['ClienteFedelta'] = $cli;
        $this->gestori['Acquisto'] = new AcquistoDB();
        $this->gestori['Aereo'] = new AereoDB();
        $this->gestori['Aereoporto'] = new AereoportoDB();
        $this->gestori['Biglietto'] = new BigliettoDB();
        $this->gestori['Impiegato'] = new ImpiegatoDB();
        $this->gestori['Istituto'] = new IstitutoDB();
        $this->gestori['Pagamento'] = new PagamentoDB();
        $this->gestori['Posto'] = new PostoDB();
        $this->gestori['Prenotazione'] = new PrenotazioneDB();
        $this->gestori['Promozione'] = new PromozioneDB();
        $this->gestori['Volo'] = new VoloDB();
    }

    public static function getIstance(){
        if (!self::$instance) {
            self::$instance = new DBFacade();
        }
        return self::$instance;
    }

    //Operazioni CRUD

    public function update($object){
        $esito = $this -> gestori[$this->getClassName($object)] -> update($object);
    }

    public function put($object){
        $esito = $this -> gestori[$this->getClassName($object)] -> put($object);
    }

    public function get($OID, $class){
        $returnObject = $this -> gestori[$class]->get($OID);
        return $returnObject;
    }

    public function delete($OID, $class){
        $this->gestori[$this->getClassName($class)] -> delete($OID);
    }

    private function getClassName($class){
        return get_class($class);
        //return substr(strrchr(get_class($class), "\\"), 1);
    }

    public function getAll($class){
        return $this->gestori[$class] ->getAll($class);
    }

    //Metodi Facade

    public function emailExists($email){
        return $this->gestori['Cliente'] -> emailExists($email);
    }

    public function cercaVoli($partenza, $destinazione, $data, $nPosti){
        return $this->gestori['Volo']->getVoli($partenza, $destinazione, $data, $nPosti);
    }

    public function getPrenotazioniScaduteIn($ore){
        return $this->gestori['Prenotazione'] -> getScadute($ore);
    }

    public function userLogin($email, $password){
        return $this->gestori['Cliente'] -> login($email, $password);
    }

    public function impiegatoLogin($username, $password){
        return $this->gestori['Impiegato'] -> login($username, $password);
    }


}





