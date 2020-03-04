<?php

class Aereo{
    private $marcaModello;
    private $postiDisponibili;
    private $numeroSerie;

    public function __construct($postiDisponibili)
    {
        $this->postiDisponibili = $postiDisponibili;
    }

    public function getPostiDisponibili()
    {
        return $this->postiDisponibili;
    }
}

