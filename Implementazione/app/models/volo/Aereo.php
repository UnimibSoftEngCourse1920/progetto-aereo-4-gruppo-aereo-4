<?php


namespace model\volo;


use model\servizi\OIDGenerator;

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
}

