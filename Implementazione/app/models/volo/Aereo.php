<?php

<<<<<<< HEAD

namespace model\volo;


use model\servizi\OIDGenerator;

=======
>>>>>>> 29ea33f6a4ea2601f6bc81a01f225a3209ead39c
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

