<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/OIDGenerator.php";

class Cliente{
    protected $OID;
    protected $nome;
    protected $cognome;
    protected $email;
    protected $dataNascita;

    public function __construct($nome, $cognome, $email, $dataNascita, $OID = ""){
        if($OID == "") {
            $this->OID = OIDGenerator::getIstance()->getNewOID();
        } else {
            $this->OID = $OID;
        }
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->dataNascita = $dataNascita;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getDataNascita() {
        return $this->dataNascita;
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

    public function isFedelta(){
        //TODO: da rivedere
        return false;
    }
}

 ?>
