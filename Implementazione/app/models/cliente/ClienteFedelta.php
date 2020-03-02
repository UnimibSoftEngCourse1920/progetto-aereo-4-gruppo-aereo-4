<?php


namespace model\cliente;


class ClienteFedelta extends Cliente{

    private $indirizzo;
    private $codiceFedelta;
    private $username;
    private $password;

    public function __construct($nome, $cognome, $email, $dataNascita, $codiceFedelta, $indirizzo, $username, $password, $OID){
            parent::__construct($OID, $nome, $cognome, $email, $dataNascita);
            $this->codiceFedelta = $codiceFedelta;
            $this->indirizzo = $indirizzo;
            $this->username = $username;
            $this->password = $password;
    }

    public function annullaIscrizioneFedelta(){
        $this->indirizzo = null;
        $this->codiceFedelta = null;
        $this->username = null;
        $this->password = null;
    }

}

?>

