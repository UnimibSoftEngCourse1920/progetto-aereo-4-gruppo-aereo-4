<?php


namespace model\cliente;


class ClienteFedelta extends Cliente{

    public static $STATOFEDELE = 'FEDELE';
    public static $STATOINFEDELE = 'INFEDELE';

    private $indirizzo;
    private $codiceFedelta;
    private $username;
    private $password;
    private $stato;

    public function __construct($nome, $cognome, $email, $dataNascita, $codiceFedelta, $indirizzo, $username, $password, $OID){
            parent::__construct($OID, $nome, $cognome, $email, $dataNascita);
            $this->codiceFedelta = $codiceFedelta;
            $this->indirizzo = $indirizzo;
            $this->username = $username;
            $this->password = $password;
            $this->stato = ClienteFedelta::$STATOFEDELE;
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

