<?php

require_once __DIR__ . "/Cliente.php";

class ClienteFedelta extends Cliente{

    public static $STATOFEDELE = 'FEDELE';
    public static $STATOINFEDELE = 'INFEDELE';

    private $indirizzo;
    private $codiceFedelta;
    private $password;
    private $stato;

    public function __construct($nome, $cognome, $email, $dataNascita, $codiceFedelta, $indirizzo, $password, $OID){
            parent::__construct($nome, $cognome, $email, $dataNascita, $OID);
            $this->codiceFedelta = $codiceFedelta;
            $this->indirizzo = $indirizzo;
            $this->password = $password;
            $this->stato = ClienteFedelta::$STATOFEDELE;
    }

    public function getCodiceFedelta() {
        return $this->codiceFedelta;
    }


    public function getIndirizzo() {
        return $this->indirizzo;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getStato() {
        return $this->stato;
    }

    public function annullaIscrizioneFedelta(){
        $this->indirizzo = null;
        $this->codiceFedelta = null;
        $this->username = null;
        $this->password = null;
        $this->stato = null;
    }

    public function setStato($stato){
        $this->stato = $stato;
    }

}

?>

