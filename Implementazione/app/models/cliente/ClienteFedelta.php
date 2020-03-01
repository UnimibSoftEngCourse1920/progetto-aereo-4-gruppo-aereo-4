<?php


namespace model\cliente;


class ClienteFedelta extends Cliente{

    private $indirizzo;
    private $codiceFedelta;
    private $username;
    private $password;

    public function __construct($datiCliente, $codiceFedelta){
            parent::construct(); //capire come vengono gestiti i dati cliente
            $this->codiceFedelta = $codiceFedelta;
            //parsing dati (arriva direttamente qui il json!!
    }

    public function annullaIscrizioneFedelta(){
        $this->indirizzo = null;
        $this->codiceFedelta = null;
        $this->username = null;
        $this->password = null;
    }
}

?>

