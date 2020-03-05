<?php

require_once('./models/servizi/OIDGenerator.php');
require_once('./models/servizi/DBFacade.php');


class Aereoporto{

    private $OID;
    private $nome;
    private $continente;
    private $nazione;
    private $citta;
    private $codice;

    public function __construct($nome, $continente, $nazione, $citta, $codice)
    {
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->nome = $nome;
        $this->continente = $continente;
        $this->nazione = $nazione;
        $this->citta = $citta;
        $this->codice = $codice;
    }

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getContinente()
    {
        return $this->continente;
    }

    /**
     * @return mixed
     */
    public function getNazione()
    {
        return $this->nazione;
    }

    /**
     * @return mixed
     */
    public function getCitta()
    {
        return $this->citta;
    }

    /**
     * @return mixed
     */
    public function getCodice()
    {
        return $this->codice;
    }



}

