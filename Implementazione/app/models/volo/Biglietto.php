<?php

require_once "../app/models/servizi/OIDGenerator.php";


class Biglietto{

    private $numPosto;
    private $tariffa;
    private $nominativo;
    private $OID;
    private $prezzo;

    public function __construct($numPosto, $tariffa, $nominativo, $prezzo)
    {
        $this->numPosto=$numPosto;
        $this->tariffa = $tariffa;
        $this->nominativo = $nominativo;
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->prezzo=$prezzo;
    }

    public function setPosto($numPosto) {
        $this->numPosto = $numPosto;
    }

    public function setTariffa($tariffa) {
        $this->tariffa = $tariffa;
    }

    /**
     * @return mixed
     */
    public function getTariffa()
    {
        return $this->tariffa;
    }

    /**
     * @return mixed
     */
    public function getNominativo()
    {
        return $this->nominativo;
    }

    public function getNumPosto(){
        return $this->numPosto;
    }

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }

    public function getPrezzo(){
        return $this->prezzo;
    }




}
