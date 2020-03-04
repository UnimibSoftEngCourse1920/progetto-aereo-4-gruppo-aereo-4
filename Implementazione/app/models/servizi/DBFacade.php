<?php


namespace model\servizi;

//Require di tutto il sottopackage database
use model\acquisto\Acquisto;
use model\servizi\database\ImpiegatoDB;
use model\servizi\database\IstitutoDB;
use model\volo\Volo;

$folder =   "./database/";
$files = glob($folder."*.php");
foreach($files as $phpFile){
    require_once("$phpFile");
}


class DBFacade{
    private static $instance = null;

    private $gestori = array();


    private function __construct(){
        //factory ??
        $this->gestori['Cliente'] = new ClienteDB();
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

    private function getClassName($class){
        return substr(strrchr(get_class($class), "\\"), 1);
    }

    //Metodi Facade

    public function emailExists($email){
        //Cerca sul DB se c'è un cliente fedeltà con quella email
        //ritorna boolean
    }

    public function cercaVoli($partenza, $destinazione, $data, $nPosti){
        $this->gestori['Volo']->getVoli($partenza, $destinazione, $data, $nPosti);
    }

}





