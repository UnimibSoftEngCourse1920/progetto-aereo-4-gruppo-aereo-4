<?php

require_once "../app/models/servizi/OIDGenerator.php";


class Aereo{
    private $OID;
    private $marcaModello;
    private $numeroPosti;
    private $numeroSerie;


    public function __construct($marcaModello, $numeroPosti, $numeroSerie)
    {
        $this->marcaModello = $marcaModello;
        $this->numeroPosti = $numeroPosti;
        $this->numeroSerie = $numeroSerie;
        $this->OID = OIDGenerator::getIstance()->getNewOID();
    }

    public function getNumeroPosti()
    {
        return $this->numeroPosti;
    }

    public function getMarcaModello()
    {
        return $this->marcaModello;
    }

    /**
     * @return mixed
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    public function getOID()
    {
        return $this->OID;
    }
}

