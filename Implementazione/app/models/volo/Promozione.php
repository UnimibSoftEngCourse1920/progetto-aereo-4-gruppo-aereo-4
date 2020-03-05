<?php

class Promozione{

    private $dataInizio;
    private $dataFine;
    private $nome;
    private $percentualeSconto;
    private $promozioneFedelta;
    private $OID;

    /**
     * Promozione constructor.
     * @param $dataInizio
     * @param $dataFine
     * @param $nome
     * @param $percentualeSconto
     * @param $promozioneFedelta
     */
    public function __construct($dataInizio, $dataFine, $nome, $percentualeSconto, $promozioneFedelta)
    {
        $this->dataInizio = $dataInizio;
        $this->dataFine = $dataFine;
        $this->nome = $nome;
        $this->percentualeSconto = $percentualeSconto;
        $this->promozioneFedelta = $promozioneFedelta;
        $this->OID = OIDGenerator::getIstance()->getNewOID();
    }


}
