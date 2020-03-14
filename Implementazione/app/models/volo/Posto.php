<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";


class Posto{
    private $OID;
    private $numeroPosto;
    private $stato;

    public function __construct($numeroPosto){
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->stato = false;
        $this->numeroPosto = $numeroPosto;
    }

    public function cambiaStato($stato){
        $this->stato = $stato;
    }

    public function isOccupato(){
        return $this->stato;
    }

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }

    /**
     * @return Posto
     */
    public function getNumeroPosto()
    {
        return $this->numeroPosto;
    }

    /**
     * @return bool
     */
    public function isStato()
    {
        //TODO rinominare
        return $this->stato;
    }


    public function __get($attributo) {
        //da rimuovere
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