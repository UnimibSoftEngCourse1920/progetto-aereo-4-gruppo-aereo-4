<?php


class Biglietto{

    private $numPosto;
    private $tariffa;
    private $nominativo;
    private $OID;

    /**
     * Biglietto constructor.
     * @param $tariffa
     * @param $nominativo
     * @param $OID
     */
    public function __construct($numPosto, $tariffa, $nominativo)
    {
        $this->numPosto=$numPosto;
        $this->tariffa = $tariffa;
        $this->nominativo = $nominativo;
        $this->OID = OIDGenerator::getIstance()->getNewOID();
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




}
