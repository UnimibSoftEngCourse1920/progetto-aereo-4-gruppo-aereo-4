<?php

require_once "../app/models/servizi/OIDGenerator.php";


class Impiegato{
    private $nome;
    private $cognome;
    private $username;
    private $password;
    private $OID;

    /**
     * Impiegato constructor.
     * @param $nome
     * @param $cognome
     * @param $username
     * @param $password
     */
    public function __construct($nome, $cognome, $username, $password)
    {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->username = $username;
        $this->password = $password;
        $this->OID = OIDGenerator::getIstance()->getNewOID();
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
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getOID()
    {
        return $this->OID;
    }





}
