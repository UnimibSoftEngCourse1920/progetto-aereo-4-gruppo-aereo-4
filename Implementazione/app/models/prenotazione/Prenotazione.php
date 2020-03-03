<?php


namespace model\prenotazione;


use model\servizi\DB;

class Prenotazione{
    private $data;
    private $OID;
    private $stato; //Serve??
    private $listaPosti;
    private $cliente;

    public function __construct($cliente,$codVolo,$numPosti,$data){
        $this->data=$data;

        //NB!! Il costruttore NON fa logica
        DB::getIstance()->put();//inserisci pren
       // DB::getIstance()->inserisciPrenotazione();
        $this->OID = DB::getIstance()->get(); // prendo il codice prenotazione appena creata
    }

    public function generaEstrattoContoParziale(){

    }

    //getClienteCode() !!

    public function __get($attributo) {
        if (property_exists($this, $attributo)) {
            return $this->$attributo;
        }
    }

    public function __set($attributo, $valore) {
        if (property_exists($this, $attributo)) {
            $this->$attributo = $valore;
        }
        return $this;
    }
}