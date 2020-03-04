<?php

class Posto{
    private $OID;
    private $numeroPosto;
    private $stato;
    private $codPrenotazione;

    public function __construct($numeroPosto){
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->stato = false;
        $this->numeroPosto = $numeroPosto;
    }

    public function cambiaStato(){
        $this->stato = 1;
    }

    public function isOccupato(){
        return $this->stato;
    }

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

    public function creaBiglietto($numPosto,$prezzo, $tariffa){

    }
}