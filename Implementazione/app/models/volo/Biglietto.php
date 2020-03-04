<?php


namespace model\volo;


use model\servizi\OIDGenerator;

class Biglietto{

    private $tariffa;
    private $nominativo;
    private $OID;

    /**
     * Biglietto constructor.
     * @param $tariffa
     * @param $nominativo
     * @param $OID
     */
    public function __construct($tariffa, $nominativo)
    {
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

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }




}