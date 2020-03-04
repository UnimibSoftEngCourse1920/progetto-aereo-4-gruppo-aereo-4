<?php

class Cliente{
    protected $OID;
    protected $nome;
    protected $cognome;
    protected $email;
    protected $dataNascita;

    public function __construct($OID, $nome, $cognome, $email, $dataNascita){
        $this->OID = $OID;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->email = $email;
        $this->dataNascita = $dataNascita;
    }

    public function getEmail(){
        return $this->email;
    }

}

 ?>
