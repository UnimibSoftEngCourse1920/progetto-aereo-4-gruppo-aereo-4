<?php


namespace model\prenotazione;


use model\servizi\DB;

class Prenotazione{
    private $data;
    private $OID;
    private $tariffa;
    private $listaPosti;
    private $cliente;
    private $codVolo;
    private $listaBiglietti;

    public function __construct($cliente,$codVolo,$numPosti,$tariffa,$data){
        $this->data=$data;
        $this->tariffa=$tariffa;
        $this->cliente = $cliente;
        $this->codVolo = $codVolo;
    }

    public function generaEstrattoContoParziale(){

    }

    public function registraPrenotazione(){
        $this->OID = DB::getIstance()->salvaPrenotazione($this);
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