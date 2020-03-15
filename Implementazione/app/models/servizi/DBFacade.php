<?php


require_once("database/AcquistoDB.php");
require_once("database/AereoDB.php");
require_once("database/AeroportoDB.php");
require_once("database/BigliettoDB.php");
require_once("database/ClienteDB.php");
require_once("database/ImpiegatoDB.php");
require_once("database/PagamentoConCartaDB.php");
require_once("database/PagamentoConPuntiDB.php");
require_once("database/PostoDB.php");
require_once("database/PrenotazioneDB.php");
require_once("database/PromozioneDB.php");
require_once("database/VoloDB.php");


class DBFacade{

    private static $instance = null;
    private $gestori = array();

    private function __construct(){
        $this->gestori[Cliente::class] = new ClienteDB();
        $this->gestori[Acquisto::class] = new AcquistoDB();
        $this->gestori[Aereo::class] = new AereoDB();
        $this->gestori[Aeroporto::class] = new AeroportoDB();
        $this->gestori[Biglietto::class] = new BigliettoDB();
        $this->gestori[Impiegato::class] = new ImpiegatoDB();
        $this->gestori[PagamentoConPunti::class] = new PagamentoConPuntiDB();
        $this->gestori[PagamentoConCarta::class] = new PagamentoConCartaDB();
        $this->gestori[Posto::class] = new PostoDB();
        $this->gestori[Prenotazione::class] = new PrenotazioneDB();
        $this->gestori[Promozione::class] = new PromozioneDB();
        $this->gestori[Volo::class] = new VoloDB();
    }

    public static function getIstance(){
        if (!self::$instance) {
            self::$instance = new DBFacade();
        }
        return self::$instance;
    }

    //Operazioni CRUD
    public function update($object){
        return $this -> gestori[get_class($object)] -> update($object);
    }

    public function put($object){
        return $this -> gestori[get_class($object)] -> put($object);
    }

    public function get($OID, $class){
        return $this -> gestori[$class]->get($OID,$class);
    }

    public function delete($OID, $class){
        $this->gestori[$class]->delete($OID,$class);
    }

    public function getAll($class){
        return $this->gestori[$class]->getAll($class);
    }

    //Metodi Facade

    public function emailFedeltaExists($email){
        return $this->gestori[Cliente::class] -> emailFedeltaExists($email);
    }

    public function cercaVoli($partenza, $destinazione, $data, $nPosti){
        return $this->gestori[Volo::class]->cercaVoli($partenza, $destinazione, $data, $nPosti);
    }

    public function getPrenotazioniScaduteIn($ore){
        return $this->gestori[Prenotazione::class]->getScadute($ore);
    }

    public function userLogin($email, $password){
        return $this->gestori[Cliente::class] -> login($email, $password);
    }

    public function impiegatoLogin($username, $password){
        return $this->gestori[Impiegato::class] -> login($username, $password);
    }

    public function getClientiFedelta(){
        return $this->gestori[Cliente::class] -> getClientiFedelta();
    }

    public function checkPrenotazioneUnivoca($email,$OIDVolo){
        return $this->gestori[Prenotazione::class] -> checkUnivoca($email, $OIDVolo);
    }

    public function getFedeltaUltimaPrenotazione(){
        return $this->gestori[Prenotazione::class] -> getFedeltaUltimaPrenotazione();
    }

    public function getPasseggeriVolo($OIDVolo){
        return $this->gestori[Volo::class] -> getPasseggeriVolo($OIDVolo);
    }

    public function isAereoDisponibile($dataoraPartenza, $dataoraArrivo, $OIDAereo){
        return $this->gestori[Volo::class] -> isAereoDisponibile($dataoraPartenza, $dataoraArrivo, $OIDAereo);
    }

    public function getPrenotazioniCliente($OIDCliente, $soloAcquistate = false){
        return $this->gestori[Prenotazione::class] -> getPrenotazioniCliente($OIDCliente, $soloAcquistate);
    }

    public function getPromozioniFedelta(){
        return $this->gestori[Promozione::class] -> getPromozioniFedelta();
    }

    public function getPromozioniAttive(){
        return $this->gestori[Promozione::class]->getPromozioniAttive();
    }

    public function getVoliConPromozione(){
        return $this->gestori[Volo::class]->getVoliConPromozione();
    }

}





