<?php

require_once "../app/models/servizi/OIDGenerator.php";

class Cliente{
    protected $OID;
    protected $nome;
    protected $cognome;
    protected $email;
    protected $dataNascita;

    public function __construct($nome, $cognome, $email, $dataNascita){
        $this->OID = OIDGenerator::getIstance()->getNewOID();
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->dataNascita = $dataNascita;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getOID() {
        return $this->OID;
    }

}

 ?>
