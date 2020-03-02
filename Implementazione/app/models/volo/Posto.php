<?php


namespace model\volo;


class Posto{
    private $numeroPosto;
    private $stato;
    private $codPrenotazione;

    public function __construct($codPrenotazione){
        $numeroPosto = null; //poi prenderà dal db il primo posto libero
        $this->codPrenotazione = $codPrenotazione;
    }

    public function cambiaStato(){
        $this->stato = 1;
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
}